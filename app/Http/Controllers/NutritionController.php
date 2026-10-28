<?php

namespace App\Http\Controllers;

use App\Models\NutritionMeasurement;
use App\Models\User;
use App\Services\NutritionAssessmentException;
use App\Services\NutritionAssessmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NutritionController extends Controller
{
    /** Indonesian messages for this feature only; the app locale stays as configured. */
    private const VALIDATION_MESSAGES = [
        'required' => ':Attribute wajib diisi.',
        'date' => ':Attribute harus berupa tanggal yang valid.',
        'before' => ':Attribute harus sebelum hari ini.',
        'before_or_equal' => ':Attribute tidak boleh melebihi hari ini.',
        'after' => ':Attribute harus setelah 1 Januari 1990.',
        'numeric' => ':Attribute harus berupa angka.',
        'decimal' => ':Attribute memiliki terlalu banyak angka di belakang koma.',
        'between' => ['numeric' => ':Attribute harus antara :min dan :max.'],
        'in' => 'Pilih :attribute yang tersedia.',
        'weight_kg.decimal' => 'Berat badan maksimal 2 angka di belakang koma.',
        'weight_kg.between' => 'Berat badan harus antara :min dan :max kg.',
        'height_cm.decimal' => 'Tinggi badan diisi dalam sentimeter dengan maksimal 1 angka di belakang koma (contoh: 166 atau 165,5).',
        'height_cm.between' => 'Tinggi badan harus antara :min dan :max cm (isi dalam sentimeter, bukan meter).',
    ];

    public function __construct(private NutritionAssessmentService $assessor) {}

    // ── Student ──────────────────────────────────────────────────────────

    public function index()
    {
        $student = Auth::user();
        $measurements = $student->nutritionMeasurements()
            ->orderByDesc('measured_at')
            ->orderByDesc('id')
            ->get();

        return view('student.nutrition.index', compact('student', 'measurements'));
    }

    public function updateProfile(Request $request)
    {
        $this->saveProfile($request, Auth::user());

        return redirect()->route('nutrition.index')->with('success', 'Data profil berhasil disimpan.');
    }

    public function store(Request $request)
    {
        $measurement = $this->recordMeasurement($request, Auth::user(), Auth::id());
        if (! $measurement instanceof NutritionMeasurement) {
            return $measurement;
        }

        return redirect()->route('nutrition.show', $measurement->id)
            ->with('success', 'Pengukuran berhasil disimpan.');
    }

    public function show(int $id)
    {
        $measurement = NutritionMeasurement::with('user')->findOrFail($id);
        if ((int) $measurement->user_id !== (int) Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('student.nutrition.show', compact('measurement'));
    }

    // ── Admin ────────────────────────────────────────────────────────────

    public function adminIndex(int $id)
    {
        $student = User::where('role', 'student')->with('school')->findOrFail($id);
        $measurements = $student->nutritionMeasurements()
            ->with('recorder')
            ->orderByDesc('measured_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.students.nutrition', compact('student', 'measurements'));
    }

    public function adminUpdateProfile(Request $request, int $id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $this->saveProfile($request, $student);

        return redirect()->route('admin.students.nutrition', $student->id)->with('success', 'Data profil siswa berhasil disimpan.');
    }

    public function adminStore(Request $request, int $id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $measurement = $this->recordMeasurement($request, $student, Auth::id());
        if (! $measurement instanceof NutritionMeasurement) {
            return $measurement;
        }

        return redirect()->route('admin.students.nutrition', $student->id)->with('success', 'Pengukuran berhasil disimpan.');
    }

    // ── Shared ───────────────────────────────────────────────────────────

    private function saveProfile(Request $request, User $student): void
    {
        $data = $request->validate([
            'birth_date' => ['required', 'date', 'before:today', 'after:1990-01-01'],
            'sex' => ['required', Rule::in(NutritionAssessmentService::SEXES)],
        ], self::VALIDATION_MESSAGES, [
            'birth_date' => 'tanggal lahir',
            'sex' => 'jenis kelamin',
        ]);

        $student->update([
            'birth_date' => $data['birth_date'],
            'sex' => $data['sex'],
        ]);
    }

    /**
     * Validates input, runs the assessment server-side and appends a new record.
     * Returns the redirect response when the assessment cannot be made.
     */
    private function recordMeasurement(Request $request, User $student, ?int $recordedBy)
    {
        $data = $request->validate([
            'measured_at' => ['required', 'date', 'before_or_equal:today', 'after:1990-01-01'],
            'weight_kg' => ['required', 'numeric', 'decimal:0,2', 'between:'.NutritionAssessmentService::MIN_WEIGHT_KG.','.NutritionAssessmentService::MAX_WEIGHT_KG],
            'height_cm' => ['required', 'numeric', 'decimal:0,1', 'between:'.NutritionAssessmentService::MIN_HEIGHT_CM.','.NutritionAssessmentService::MAX_HEIGHT_CM],
        ], self::VALIDATION_MESSAGES, [
            'measured_at' => 'tanggal pengukuran',
            'weight_kg' => 'berat badan',
            'height_cm' => 'tinggi badan',
        ]);

        if (! $student->hasNutritionProfile()) {
            return back()->withErrors(['measurement' => 'Lengkapi tanggal lahir dan jenis kelamin terlebih dahulu.'])->withInput();
        }

        try {
            $result = $this->assessor->assess(
                $student->sex,
                $student->birth_date,
                Carbon::parse($data['measured_at']),
                (float) $data['weight_kg'],
                (float) $data['height_cm'],
            );
        } catch (NutritionAssessmentException $e) {
            return back()->withErrors(['measurement' => $e->getMessage()])->withInput();
        }

        return $student->nutritionMeasurements()->create([
            'recorded_by' => $recordedBy,
            'measured_at' => $result['measured_at'],
            'birth_date' => $result['birth_date'],
            'sex' => $result['sex'],
            'age_months' => $result['age_months'],
            'weight_kg' => $result['weight_kg'],
            'height_cm' => $result['height_cm'],
            'bmi' => round($result['bmi'], 4),
            'z_score' => round($result['z_score'], 4),
            'category' => $result['category'],
            'reference_version' => $result['reference_version'],
        ]);
    }
}
