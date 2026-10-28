<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\NutritionMeasurement;
use App\Models\Result;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class NutritionMeasurementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->travelTo('2026-10-28 10:00:00');
    }

    private function student(array $attributes = []): User
    {
        return User::factory()->create(array_merge([
            'birth_date' => '2010-03-01',
            'sex' => 'female',
        ], $attributes));
    }

    private function validMeasurement(array $overrides = []): array
    {
        return array_merge([
            'measured_at' => '2026-10-20',
            'weight_kg' => '54',
            'height_cm' => '166',
        ], $overrides);
    }

    // ── Access ───────────────────────────────────────────────────────────

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/nutrition')->assertRedirect('/login');
        $this->post('/nutrition', $this->validMeasurement())->assertRedirect('/login');
    }

    public function test_student_sees_own_page(): void
    {
        $student = $this->student();

        $this->actingAs($student)->get('/nutrition')
            ->assertOk()
            ->assertSee('Status Gizi (IMT/U)')
            ->assertSee('bukan diagnosis medis');
    }

    public function test_admin_cannot_use_student_routes_and_student_cannot_use_admin_routes(): void
    {
        $admin = User::factory()->admin()->create();
        $student = $this->student();

        $this->actingAs($admin)->get('/nutrition')->assertForbidden();
        $this->actingAs($student)->get("/admin/students/{$student->id}/nutrition")->assertForbidden();
        $this->actingAs($student)->post("/admin/students/{$student->id}/nutrition", $this->validMeasurement())->assertForbidden();
        $this->assertSame(0, NutritionMeasurement::count());
    }

    // ── Profile ──────────────────────────────────────────────────────────

    public function test_student_can_complete_profile(): void
    {
        $student = User::factory()->create();
        $this->assertFalse($student->hasNutritionProfile());

        $this->actingAs($student)->post('/nutrition/profile', ['birth_date' => '2009-07-12', 'sex' => 'male'])
            ->assertRedirect('/nutrition');

        $student->refresh();
        $this->assertSame('2009-07-12', $student->birth_date->toDateString());
        $this->assertSame('male', $student->sex);
    }

    public function test_profile_rejects_invalid_values(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)->post('/nutrition/profile', ['birth_date' => '2030-01-01', 'sex' => 'other'])
            ->assertSessionHasErrors(['birth_date', 'sex']);
        $this->assertNull($student->refresh()->sex);
    }

    public function test_measurement_requires_completed_profile(): void
    {
        $student = User::factory()->create();

        $this->actingAs($student)->from('/nutrition')->post('/nutrition', $this->validMeasurement())
            ->assertSessionHasErrors('measurement');
        $this->assertSame(0, NutritionMeasurement::count());
    }

    // ── Storing ──────────────────────────────────────────────────────────

    public function test_student_measurement_is_computed_on_the_server(): void
    {
        $student = $this->student();
        $other = $this->student();

        $response = $this->actingAs($student)->post('/nutrition', $this->validMeasurement([
            // Tampering attempts: all must be ignored.
            'user_id' => $other->id,
            'bmi' => 99,
            'z_score' => 9,
            'category' => 'obese',
        ]));

        $m = NutritionMeasurement::sole();
        $response->assertRedirect("/nutrition/{$m->id}");

        $this->assertSame($student->id, (int) $m->user_id);
        $this->assertSame($student->id, (int) $m->recorded_by);
        $this->assertSame('2026-10-20', $m->measured_at->toDateString());
        $this->assertSame(199, $m->age_months); // 16 years 7 months
        $this->assertSame('female', $m->sex);
        $this->assertSame('2010-03-01', $m->birth_date->toDateString());
        $this->assertEqualsWithDelta(19.5965, $m->bmi, 0.0001);
        $this->assertSame('normal', $m->category);
        $this->assertLessThan(0, $m->z_score);
        $this->assertSame('WHO2007-BMIFA-exp/LMS-adjusted-v1', $m->reference_version);

        $this->actingAs($student)->get("/nutrition/{$m->id}")
            ->assertOk()
            ->assertSee('19,6')
            ->assertSee('Gizi baik')
            ->assertSee('16 tahun 7 bulan')
            ->assertSee('bukan diagnosis medis');
    }

    public function test_new_measurement_keeps_previous_history(): void
    {
        $student = $this->student();

        $this->actingAs($student)->post('/nutrition', $this->validMeasurement(['measured_at' => '2026-01-10', 'weight_kg' => '50']));
        $this->actingAs($student)->post('/nutrition', $this->validMeasurement(['measured_at' => '2026-10-20', 'weight_kg' => '54']));

        $this->assertSame(2, $student->nutritionMeasurements()->count());
        $this->assertEqualsCanonicalizing([50.0, 54.0], $student->nutritionMeasurements()->pluck('weight_kg')->map(fn ($w) => (float) $w)->all());

        $this->actingAs($student)->get('/nutrition')->assertOk()->assertSee('10/01/2026')->assertSee('20/10/2026');
    }

    public function test_history_snapshot_survives_profile_change(): void
    {
        $student = $this->student();
        $this->actingAs($student)->post('/nutrition', $this->validMeasurement());

        $this->actingAs($student)->post('/nutrition/profile', ['birth_date' => '2009-03-01', 'sex' => 'male']);

        $m = NutritionMeasurement::sole();
        $this->assertSame('female', $m->sex);
        $this->assertSame('2010-03-01', $m->birth_date->toDateString());
    }

    public static function invalidMeasurements(): array
    {
        return [
            'empty weight' => [['weight_kg' => ''], 'weight_kg'],
            'zero weight' => [['weight_kg' => '0'], 'weight_kg'],
            'negative weight' => [['weight_kg' => '-54'], 'weight_kg'],
            'text weight' => [['weight_kg' => 'abc'], 'weight_kg'],
            'too many decimals' => [['weight_kg' => '54.123'], 'weight_kg'],
            'absurd weight' => [['weight_kg' => '500'], 'weight_kg'],
            'empty height' => [['height_cm' => ''], 'height_cm'],
            'height in metres' => [['height_cm' => '1.66'], 'height_cm'],
            'negative height' => [['height_cm' => '-166'], 'height_cm'],
            'absurd height' => [['height_cm' => '400'], 'height_cm'],
            'future date' => [['measured_at' => '2026-11-01'], 'measured_at'],
            'bad date' => [['measured_at' => 'kemarin'], 'measured_at'],
        ];
    }

    #[DataProvider('invalidMeasurements')]
    public function test_invalid_measurements_are_rejected(array $override, string $field): void
    {
        $student = $this->student();

        $this->actingAs($student)->post('/nutrition', $this->validMeasurement($override))
            ->assertSessionHasErrors($field);
        $this->assertSame(0, NutritionMeasurement::count());
    }

    public function test_unsupported_age_is_rejected_without_adult_category(): void
    {
        $tooYoung = $this->student(['birth_date' => '2013-01-01']); // 13 years on 2026-10-20
        $tooOld = $this->student(['birth_date' => '2007-10-20']);   // turns 19 on 2026-10-20

        $this->actingAs($tooYoung)->post('/nutrition', $this->validMeasurement())->assertSessionHasErrors('measurement');
        $this->actingAs($tooOld)->post('/nutrition', $this->validMeasurement())->assertSessionHasErrors('measurement');
        $this->assertSame(0, NutritionMeasurement::count());

        $this->actingAs($tooOld)->post('/nutrition', $this->validMeasurement(['measured_at' => '2026-10-19']))->assertRedirect();
        $this->assertSame(1, NutritionMeasurement::count());
    }

    // ── Ownership ────────────────────────────────────────────────────────

    public function test_student_cannot_view_another_students_measurement(): void
    {
        $owner = $this->student();
        $intruder = $this->student();
        $this->actingAs($owner)->post('/nutrition', $this->validMeasurement());
        $m = NutritionMeasurement::sole();

        $this->actingAs($intruder)->get("/nutrition/{$m->id}")->assertForbidden();
        $this->actingAs($intruder)->get('/nutrition')->assertOk()->assertDontSee('19,6');
        $this->actingAs($owner)->get("/nutrition/{$m->id}")->assertOk();
    }

    public function test_missing_measurement_returns_404(): void
    {
        $this->actingAs($this->student())->get('/nutrition/999')->assertNotFound();
    }

    // ── Admin ────────────────────────────────────────────────────────────

    public function test_admin_can_manage_a_students_profile_and_measurements(): void
    {
        $admin = User::factory()->admin()->create();
        $student = User::factory()->create(['name' => 'Siti Gizi']);

        $this->actingAs($admin)->get("/admin/students/{$student->id}/nutrition")
            ->assertOk()->assertSee('Siti Gizi');

        $this->actingAs($admin)->post("/admin/students/{$student->id}/nutrition/profile", ['birth_date' => '2010-03-01', 'sex' => 'male'])
            ->assertRedirect("/admin/students/{$student->id}/nutrition");

        $this->actingAs($admin)->post("/admin/students/{$student->id}/nutrition", $this->validMeasurement())
            ->assertRedirect("/admin/students/{$student->id}/nutrition");

        $m = NutritionMeasurement::sole();
        $this->assertSame($student->id, (int) $m->user_id);
        $this->assertSame($admin->id, (int) $m->recorded_by);
        $this->assertSame('male', $m->sex);

        $this->actingAs($admin)->get("/admin/students/{$student->id}/nutrition")
            ->assertOk()->assertSee('Gizi baik')->assertSee($admin->name);
    }

    public function test_admin_nutrition_routes_only_target_students(): void
    {
        $admin = User::factory()->admin()->create();
        $otherAdmin = User::factory()->admin()->create();

        $this->actingAs($admin)->get("/admin/students/{$otherAdmin->id}/nutrition")->assertNotFound();
        $this->actingAs($admin)->post("/admin/students/{$otherAdmin->id}/nutrition/profile", ['birth_date' => '2010-03-01', 'sex' => 'male'])->assertNotFound();
        $this->assertNull($otherAdmin->refresh()->sex);
    }

    public function test_deleting_a_student_removes_their_measurements(): void
    {
        $admin = User::factory()->admin()->create();
        $student = $this->student();
        $this->actingAs($student)->post('/nutrition', $this->validMeasurement());

        $this->actingAs($admin)->delete("/admin/students/{$student->id}");

        $this->assertSame(0, NutritionMeasurement::count());
    }

    public function test_admin_cannot_open_student_result_page_directly(): void
    {
        $admin = User::factory()->admin()->create();
        $student = $this->student();
        $this->actingAs($student)->post('/nutrition', $this->validMeasurement());

        $this->actingAs($admin)->get('/nutrition/'.NutritionMeasurement::sole()->id)->assertForbidden();
    }

    // ── Presentation ─────────────────────────────────────────────────────

    public function test_result_text_is_neutral_for_admin_and_student(): void
    {
        $admin = User::factory()->admin()->create();
        $student = $this->student();
        $this->actingAs($student)->post('/nutrition', $this->validMeasurement());

        $this->actingAs($admin)->get("/admin/students/{$student->id}/nutrition")
            ->assertOk()
            ->assertSee('menurut usia dan jenis kelamin (normal)')
            ->assertDontSee('kelaminmu');
        $this->actingAs($student)->get('/nutrition/'.NutritionMeasurement::sole()->id)
            ->assertOk()
            ->assertDontSee('kelaminmu');
    }

    public function test_validation_messages_are_in_indonesian(): void
    {
        $student = $this->student();

        $this->actingAs($student)->post('/nutrition', ['measured_at' => '', 'weight_kg' => '-5', 'height_cm' => 'abc'])
            ->assertSessionHasErrors([
                'measured_at' => 'Tanggal pengukuran wajib diisi.',
                'weight_kg' => 'Berat badan harus antara 15 dan 250 kg.',
                'height_cm' => 'Tinggi badan harus berupa angka.',
            ]);
        $this->actingAs($student)->post('/nutrition', $this->validMeasurement(['height_cm' => '1.66']))
            ->assertSessionHasErrors(['height_cm' => 'Tinggi badan diisi dalam sentimeter dengan maksimal 1 angka di belakang koma (contoh: 166 atau 165,5).']);
        $this->actingAs($student)->post('/nutrition', $this->validMeasurement(['height_cm' => '1.6']))
            ->assertSessionHasErrors(['height_cm' => 'Tinggi badan harus antara 100 dan 230 cm (isi dalam sentimeter, bukan meter).']);
        $this->actingAs($student)->post('/nutrition/profile', ['birth_date' => '', 'sex' => 'other'])
            ->assertSessionHasErrors([
                'birth_date' => 'Tanggal lahir wajib diisi.',
                'sex' => 'Pilih jenis kelamin yang tersedia.',
            ]);
    }

    public function test_dates_use_indonesian_month_names_without_changing_app_locale(): void
    {
        $student = $this->student(['birth_date' => '2010-05-15']);
        $this->actingAs($student)->post('/nutrition', $this->validMeasurement(['measured_at' => '2026-08-17']));

        $this->actingAs($student)->get('/nutrition')
            ->assertOk()
            ->assertSee('Lahir 15 Mei 2010')
            ->assertSee('Diukur 17 Agt 2026');
        $this->assertSame('en', app()->getLocale());
    }

    public function test_mobile_history_cards_keep_all_values(): void
    {
        $admin = User::factory()->admin()->create();
        $student = $this->student();
        $this->actingAs($student)->post('/nutrition', $this->validMeasurement());
        $m = NutritionMeasurement::sole();

        $this->actingAs($student)->get('/nutrition')->assertOk()->assertSeeInOrder([
            'aria-label="Riwayat pengukuran status gizi"',
            '20/10/2026', '16 tahun 7 bulan', 'Gizi baik',
            'IMT (kg/m²)', '19,6', 'Z-score', $m->zScoreDisplay(), 'Berat (kg)', '54', 'Tinggi (cm)', '166',
            "/nutrition/{$m->id}",
        ], false);
        $this->actingAs($admin)->get("/admin/students/{$student->id}/nutrition")->assertOk()->assertSeeInOrder([
            'aria-label="Riwayat pengukuran status gizi"', 'Gizi baik', '19,6', 'Dicatat oleh', $student->name,
        ], false);
    }

    // ── Regression: existing LMS features ────────────────────────────────

    public function test_existing_student_pages_still_load(): void
    {
        $student = $this->student();

        $this->actingAs($student)->get('/profile')->assertOk()->assertSee('Cek Status Gizi')
            ->assertSee('if (!window.__nrnLayoutBooted)', false); // Turbo-safe layout boot guard
        $this->actingAs($student)->get('/results')->assertOk();
    }

    public function test_existing_test_result_ownership_is_unchanged(): void
    {
        $owner = $this->student();
        $other = $this->student();
        $course = Course::create(['title' => 'Gizi Seimbang']);
        $result = Result::create(['user_id' => $owner->id, 'course_id' => $course->id, 'score' => 80, 'type' => 'post']);

        $this->actingAs($owner)->get("/results/{$result->id}")->assertOk();
        $this->actingAs($other)->get("/results/{$result->id}")->assertForbidden();
    }

    public function test_existing_admin_student_pages_still_load_and_link_to_nutrition(): void
    {
        $admin = User::factory()->admin()->create();
        $student = $this->student();

        $this->actingAs($admin)->get('/admin/students')->assertOk()->assertSee("/admin/students/{$student->id}/nutrition", false);
        $this->actingAs($admin)->get("/admin/students/{$student->id}/activity")->assertOk();
    }

    public function test_existing_student_creation_does_not_require_new_fields(): void
    {
        $admin = User::factory()->admin()->create();
        $school = School::create(['name' => 'SMA Uji']);

        $this->actingAs($admin)->post('/admin/students', [
            'name' => 'Siswa Baru',
            'username' => '9988776655',
            'password' => '9988776655',
            'school_id' => $school->id,
        ])->assertSessionHasNoErrors();

        $created = User::where('username', '9988776655')->sole();
        $this->assertNull($created->birth_date);
        $this->assertNull($created->sex);
    }
}
