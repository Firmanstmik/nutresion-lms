<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseType;
use App\Models\Lesson;
use App\Models\Notification;
use App\Models\Question;
use App\Models\Result;
use App\Models\School;
use App\Models\User;
use App\Models\UserProgress;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'schools' => School::count(),
            'students' => User::where('role', 'student')->count(),
            'courses' => Course::count(),
            'results' => Result::count(),
        ];

        $recentResults = Result::with(['user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        $schoolsWithCount = School::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(5)
            ->get();

        $recentStudents = User::where('role', 'student')
            ->with('school')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentResults', 'schoolsWithCount', 'recentStudents'));
    }

    // School Management
    public function schools()
    {
        $schools = School::all();

        return view('admin.schools.index', compact('schools'));
    }

    public function storeSchool(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        School::create($request->all());

        return back()->with('success', 'School created successfully');
    }

    public function updateSchool(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $school = School::findOrFail($id);
        $school->update($request->all());

        return back()->with('success', 'School updated successfully');
    }

    public function destroySchool($id)
    {
        $school = School::findOrFail($id);
        $school->delete();

        return back()->with('success', 'School deleted successfully');
    }

    // Student Management
    public function students()
    {
        $students = User::where('role', 'student')->with('school')->get();
        $schools = School::all();

        $schoolIds = $students->pluck('school_id')->unique()->values();
        $totalLessonsBySchoolId = [];
        foreach ($schoolIds as $schoolId) {
            $key = $schoolId === null ? 'null' : (string) $schoolId;

            $totalLessonsBySchoolId[$key] = Lesson::query()
                ->whereHas('course', function ($q) use ($schoolId) {
                    $q->whereNull('school_id');
                    if ($schoolId !== null) {
                        $q->orWhere('school_id', $schoolId);
                    }
                })
                ->count();
        }

        $completedCountsByUserId = UserProgress::query()
            ->select('user_progress.user_id')
            ->selectRaw('COUNT(*) as completed_count')
            ->join('lessons', 'lessons.id', '=', 'user_progress.lesson_id')
            ->join('courses', 'courses.id', '=', 'lessons.course_id')
            ->join('users', 'users.id', '=', 'user_progress.user_id')
            ->whereIn('user_progress.user_id', $students->pluck('id')->all())
            ->where('user_progress.is_completed', true)
            ->where(function ($q) {
                $q->whereNull('courses.school_id')
                    ->orWhereColumn('courses.school_id', 'users.school_id');
            })
            ->groupBy('user_progress.user_id')
            ->pluck('completed_count', 'user_progress.user_id');

        $progressByStudentId = [];
        foreach ($students as $student) {
            $key = $student->school_id === null ? 'null' : (string) $student->school_id;
            $total = (int) ($totalLessonsBySchoolId[$key] ?? 0);
            $completed = (int) ($completedCountsByUserId[$student->id] ?? 0);
            $pct = $total > 0 ? (int) round(($completed / $total) * 100) : 0;

            $progressByStudentId[$student->id] = [
                'completed' => $completed,
                'total' => $total,
                'pct' => $pct,
            ];
        }

        return view('admin.students.index', compact('students', 'schools', 'progressByStudentId'));
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:4', // NISN
            'school_id' => 'required|exists:schools,id',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'school_id' => $request->school_id,
            'role' => 'student',
        ]);

        return back()->with('success', 'Student created successfully');
    }

    public function updateStudent(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username,'.$user->id,
            'password' => 'nullable|string|min:4',
            'school_id' => 'required|exists:schools,id',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'school_id' => $request->school_id,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Student updated successfully');
    }

    public function destroyStudent($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'Student deleted successfully');
    }

    public function studentActivity($id)
    {
        $student = User::where('role', 'student')->with('school')->findOrFail($id);

        $coursesQuery = Course::query()->with(['lessons']);
        if ($student->school_id) {
            $coursesQuery->where(function ($q) use ($student) {
                $q->whereNull('school_id')->orWhere('school_id', $student->school_id);
            });
        }
        $courses = $coursesQuery->orderBy('title')->get();

        $lessonIds = $courses->pluck('lessons')->flatten()->pluck('id')->all();

        $progressByLessonId = UserProgress::query()
            ->where('user_id', $student->id)
            ->whereIn('lesson_id', $lessonIds)
            ->get()
            ->keyBy('lesson_id');

        $results = Result::query()
            ->where('user_id', $student->id)
            ->whereIn('course_id', $courses->pluck('id')->all())
            ->get();

        $resultsByCourse = [];
        foreach ($results as $result) {
            $type = $result->type ?: 'post';
            $resultsByCourse[$result->course_id][$type] = $result;
        }

        return view('admin.students.activity', compact(
            'student',
            'courses',
            'progressByLessonId',
            'resultsByCourse'
        ));
    }

    public function resetStudentActivityAll($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        Notification::where('user_id', $student->id)->delete();
        UserProgress::where('user_id', $student->id)->delete();
        Result::where('user_id', $student->id)->delete();

        return back()->with('success', 'Aktivitas & notifikasi siswa berhasil direset (semua).');
    }

    public function resetStudentActivityCourse($id, $course_id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $course = Course::with('lessons')->findOrFail($course_id);

        $lessonIds = $course->lessons->pluck('id')->all();
        $resultIds = Result::where('user_id', $student->id)->where('course_id', $course->id)->pluck('id')->all();

        $notificationUrls = [
            route('courses.detail', $course->id),
            route('tests.index', $course->id),
            route('tests.pre.index', $course->id),
        ];
        foreach ($lessonIds as $lessonId) {
            $notificationUrls[] = route('lessons.show', $lessonId);
        }
        foreach ($resultIds as $resultId) {
            $notificationUrls[] = route('results.show', $resultId);
        }
        $notificationUrls = array_values(array_unique($notificationUrls));

        Notification::where('user_id', $student->id)->whereIn('action_url', $notificationUrls)->delete();

        if (count($lessonIds) > 0) {
            UserProgress::where('user_id', $student->id)->whereIn('lesson_id', $lessonIds)->delete();
        }

        Result::where('user_id', $student->id)->where('course_id', $course->id)->delete();

        return back()->with('success', 'Aktivitas & notifikasi kursus berhasil direset.');
    }

    public function resetStudentActivityLesson($id, $lesson_id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $lesson = Lesson::findOrFail($lesson_id);

        UserProgress::where('user_id', $student->id)->where('lesson_id', $lesson_id)->delete();

        $notificationUrls = [
            route('lessons.show', $lesson->id),
            route('tests.index', $lesson->course_id),
        ];
        Notification::where('user_id', $student->id)->whereIn('action_url', $notificationUrls)->delete();

        return back()->with('success', 'Aktivitas & notifikasi bab berhasil direset.');
    }

    // Course Management
    public function courses()
    {
        $courses = Course::with(['school', 'type'])->get();
        $schools = School::all();
        $courseTypes = CourseType::all();

        return view('admin.courses.index', compact('courses', 'schools', 'courseTypes'));
    }

    public function storeCourse(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_type_id' => 'required|exists:course_types,id',
            'label' => 'nullable|string|max:50',
            'school_id' => 'nullable|exists:schools,id',
            'description' => 'nullable|string|max:2000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['title', 'description', 'school_id', 'course_type_id', 'label']);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Course::create($data);

        return back()->with('success', 'Course created successfully');
    }

    public function updateCourse(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $request->validate([
            'title' => 'required|string|max:255',
            'course_type_id' => 'required|exists:course_types,id',
            'label' => 'nullable|string|max:50',
            'school_id' => 'nullable|exists:schools,id',
            'description' => 'nullable|string|max:2000',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = $request->only(['title', 'description', 'school_id', 'course_type_id', 'label']);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if exists
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($data);

        return back()->with('success', 'Course updated successfully');
    }

    public function destroyCourse($id)
    {
        $course = Course::findOrFail($id);
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        $course->delete();

        return back()->with('success', 'Course deleted successfully');
    }

    // Lesson Management
    public function lessons($course_id)
    {
        $course = Course::findOrFail($course_id);
        $lessons = $course->lessons;

        return view('admin.lessons.index', compact('course', 'lessons'));
    }

    public function storeLesson(Request $request, $course_id)
    {
        if ($request->input('video_url') === '') {
            $request->merge(['video_url' => null]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order_number' => 'required|integer',
        ]);

        Lesson::create([
            'course_id' => $course_id,
            'title' => $request->title,
            'content' => $request->content,
            'video_url' => $request->video_url,
            'order_number' => $request->order_number,
        ]);

        return back()->with('success', 'Lesson created successfully');
    }

    public function updateLesson(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        if ($request->input('video_url') === '') {
            $request->merge(['video_url' => null]);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'order_number' => 'required|integer',
        ]);

        $lesson->update($request->only(['title', 'content', 'video_url', 'order_number']));

        return back()->with('success', 'Lesson updated successfully');
    }

    public function destroyLesson($id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();

        return back()->with('success', 'Lesson deleted successfully');
    }

    public function uploadLessonImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        $path = $request->file('image')->store('lesson_images', 'public');
        $url = asset('storage/'.$path);

        return response()->json([
            'url' => $url,
            'path' => $path,
        ]);
    }

    // Question Management
    public function questions($course_id)
    {
        $course = Course::findOrFail($course_id);
        $questions = Question::where('course_id', $course_id)->where('type', 'post')->get();

        return view('admin.questions.index', compact('course', 'questions'));
    }

    public function preQuestions($course_id)
    {
        $course = Course::findOrFail($course_id);
        $questions = Question::where('course_id', $course_id)->where('type', 'pre')->get();

        return view('admin.pre_questions.index', compact('course', 'questions'));
    }

    public function storeQuestion(Request $request, $course_id)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        Question::create(array_merge($request->all(), ['course_id' => $course_id, 'type' => 'post']));

        return back()->with('success', 'Question added successfully');
    }

    public function storePreQuestion(Request $request, $course_id)
    {
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        Question::create(array_merge($request->all(), ['course_id' => $course_id, 'type' => 'pre']));

        return back()->with('success', 'Question added successfully');
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $request->validate([
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
        ]);

        $question->update($request->only(['question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_answer']));

        return back()->with('success', 'Question updated successfully');
    }

    public function destroyQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return back()->with('success', 'Question deleted successfully');
    }

    public function destroyPreQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return back()->with('success', 'Question deleted successfully');
    }

    // Result Monitoring
    public function results()
    {
        $results = Result::with(['user.school', 'course'])->latest()->get();
        $schools = School::query()->orderBy('name')->get();

        return view('admin.results.index', compact('results', 'schools'));
    }

    public function resultShow($id)
    {
        $result = Result::with(['course', 'user.school', 'answers.question'])->findOrFail($id);

        return view('student.results.show', compact('result'));
    }

    public function resultsTrendData()
    {
        $schoolId = request()->query('school_id');

        $baseQuery = Result::query()->with('user');
        if ($schoolId !== null && $schoolId !== '' && $schoolId !== 'all') {
            if ($schoolId === 'null') {
                $baseQuery->whereHas('user', function ($q) {
                    $q->whereNull('school_id');
                });
            } else {
                $baseQuery->whereHas('user', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            }
        }

        $latest = $baseQuery->clone()->latest()->take(10)->get()->reverse()->values();

        $labels = $latest->map(function ($r) {
            $name = $r->user?->name ?? 'Siswa';

            return explode(' ', trim($name))[0] ?: 'Siswa';
        });

        $scores = $latest->pluck('score')->map(function ($s) {
            return (int) $s;
        });
        $types = $latest->pluck('type')->map(function ($t) {
            return $t === 'pre' ? 'pre' : 'post';
        });

        $total = (int) $baseQuery->clone()->count();
        $avg = (int) round((float) ($baseQuery->clone()->avg('score') ?? 0));
        $max = (int) ($baseQuery->clone()->max('score') ?? 0);
        $pass = (int) $baseQuery->clone()->where('score', '>=', 70)->count();
        $passRate = $total > 0 ? (int) round(($pass / $total) * 100) : 0;

        return response()->json([
            'labels' => $labels,
            'scores' => $scores,
            'types' => $types,
            'stats' => [
                'total' => $total,
                'avg' => $avg,
                'max' => $max,
                'pass_rate' => $passRate,
            ],
        ]);
    }

    public function resultsExport(Request $request, $type)
    {
        if (! in_array($type, ['pre', 'post'], true)) {
            abort(404);
        }

        $schoolId = $request->query('school_id');
        $format = $request->query('format', 'excel');
        if (! in_array($format, ['excel', 'pdf', 'csv'], true)) {
            $format = 'excel';
        }

        $query = Result::query()
            ->with(['user.school', 'course'])
            ->where('type', $type)
            ->latest();

        if ($schoolId !== null && $schoolId !== '' && $schoolId !== 'all') {
            if ($schoolId === 'null') {
                $query->whereHas('user', function ($q) {
                    $q->whereNull('school_id');
                });
            } else {
                $query->whereHas('user', function ($q) use ($schoolId) {
                    $q->where('school_id', $schoolId);
                });
            }
        }

        $baseName = 'laporan_'.($type === 'pre' ? 'pretest' : 'posttest').'_'.now()->format('Ymd_His');

        if ($format === 'csv') {
            $results = $query->get();
            $filename = $baseName.'.csv';
            $headers = [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ];

            return response()->streamDownload(function () use ($results) {
                $out = fopen('php://output', 'w');
                fprintf($out, "\xEF\xBB\xBF");

                fputcsv($out, ['No', 'Nama Siswa', 'NISN/Username', 'Sekolah', 'Kursus', 'Skor', 'Tanggal', 'Waktu']);

                $i = 1;
                foreach ($results as $r) {
                    fputcsv($out, [
                        $i++,
                        $r->user?->name,
                        $r->user?->username,
                        $r->user?->school?->name ?? 'Institusi Umum',
                        $r->course?->title,
                        (int) $r->score,
                        $r->created_at?->format('d/m/Y'),
                        $r->created_at?->format('H:i:s'),
                    ]);
                }

                fclose($out);
            }, $filename, $headers);
        }

        if ($format === 'pdf') {
            if (! class_exists(Dompdf::class)) {
                abort(500, 'PDF export belum tersedia (dompdf belum terpasang).');
            }

            $totalCount = (int) $query->count();
            $limit = 120;

            @ini_set('memory_limit', '512M');
            set_time_limit(120);
            Storage::disk('local')->makeDirectory('dompdf');

            $results = $query->take($limit)->get();

            $rows = [];
            $i = 1;
            foreach ($results as $r) {
                $rows[] = [
                    'no' => $i++,
                    'name' => (string) ($r->user?->name ?? ''),
                    'username' => (string) ($r->user?->username ?? ''),
                    'school' => (string) ($r->user?->school?->name ?? 'Institusi Umum'),
                    'course' => (string) ($r->course?->title ?? ''),
                    'score' => (int) ($r->score ?? 0),
                    'date' => (string) ($r->created_at?->format('d/m/Y') ?? ''),
                    'time' => (string) ($r->created_at?->format('H:i:s') ?? ''),
                ];
            }

            $title = 'Laporan '.($type === 'pre' ? 'Pre Test' : 'Post Test');
            $html = '<!doctype html><html><head><meta charset="utf-8"><style>
                body{font-family:DejaVu Sans, Arial, sans-serif;font-size:11px;color:#111827}
                h1{font-size:14px;margin:0 0 8px}
                table{width:100%;border-collapse:collapse}
                th,td{border:1px solid #E5E7EB;padding:5px 6px;vertical-align:top}
                th{background:#F3F4F6;font-weight:700}
                .muted{color:#6B7280;font-size:10px;margin:0 0 10px}
            </style></head><body>';
            $html .= '<h1>'.$title.'</h1>';
            $html .= '<div class="muted">Diunduh: '.now()->format('d/m/Y H:i:s').'</div>';
            if ($totalCount > $limit) {
                $html .= '<div class="muted">Catatan: PDF dibatasi '.$limit.' baris (dari total '.$totalCount.' data). Gunakan Excel untuk data lengkap.</div>';
            }
            $html .= '<table><thead><tr>
                <th>No</th><th>Nama Siswa</th><th>NISN/Username</th><th>Sekolah</th><th>Kursus</th><th>Skor</th><th>Tanggal</th><th>Waktu</th>
            </tr></thead><tbody>';
            foreach ($rows as $row) {
                $html .= '<tr>'
                    .'<td>'.$row['no'].'</td>'
                    .'<td>'.e($row['name']).'</td>'
                    .'<td>'.e($row['username']).'</td>'
                    .'<td>'.e($row['school']).'</td>'
                    .'<td>'.e($row['course']).'</td>'
                    .'<td>'.$row['score'].'</td>'
                    .'<td>'.e($row['date']).'</td>'
                    .'<td>'.e($row['time']).'</td>'
                    .'</tr>';
            }
            $html .= '</tbody></table></body></html>';

            $options = new Options;
            $options->set('isRemoteEnabled', false);
            $options->set('tempDir', storage_path('app/dompdf'));
            $options->set('isHtml5ParserEnabled', true);

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();

            $filename = $baseName.'.pdf';

            return response($dompdf->output(), 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="'.$filename.'"',
            ]);
        }

        $results = $query->get();
        $rows = [];
        $i = 1;
        foreach ($results as $r) {
            $rows[] = [
                'no' => $i++,
                'name' => (string) ($r->user?->name ?? ''),
                'username' => (string) ($r->user?->username ?? ''),
                'school' => (string) ($r->user?->school?->name ?? 'Institusi Umum'),
                'course' => (string) ($r->course?->title ?? ''),
                'score' => (int) ($r->score ?? 0),
                'date' => (string) ($r->created_at?->format('d/m/Y') ?? ''),
                'time' => (string) ($r->created_at?->format('H:i:s') ?? ''),
            ];
        }

        $title = 'Laporan '.($type === 'pre' ? 'Pre Test' : 'Post Test');
        $html = '<!doctype html><html><head><meta charset="utf-8"><style>
            body{font-family:DejaVu Sans, Arial, sans-serif;font-size:12px;color:#111827}
            h1{font-size:16px;margin:0 0 10px}
            table{width:100%;border-collapse:collapse}
            th,td{border:1px solid #E5E7EB;padding:6px 8px;vertical-align:top}
            th{background:#F3F4F6;font-weight:700}
            .muted{color:#6B7280;font-size:11px;margin:0 0 12px}
        </style></head><body>';
        $html .= '<h1>'.$title.'</h1>';
        $html .= '<div class="muted">Diunduh: '.now()->format('d/m/Y H:i:s').'</div>';
        $html .= '<table><thead><tr>
            <th>No</th><th>Nama Siswa</th><th>NISN/Username</th><th>Sekolah</th><th>Kursus</th><th>Skor</th><th>Tanggal</th><th>Waktu</th>
        </tr></thead><tbody>';
        foreach ($rows as $row) {
            $html .= '<tr>'
                .'<td>'.$row['no'].'</td>'
                .'<td>'.e($row['name']).'</td>'
                .'<td>'.e($row['username']).'</td>'
                .'<td>'.e($row['school']).'</td>'
                .'<td>'.e($row['course']).'</td>'
                .'<td>'.$row['score'].'</td>'
                .'<td>'.e($row['date']).'</td>'
                .'<td>'.e($row['time']).'</td>'
                .'</tr>';
        }
        $html .= '</tbody></table></body></html>';

        $filename = $baseName.'.xls';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
    }
}
