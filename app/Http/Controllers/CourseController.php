<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Notification;
use App\Models\Result;
use App\Models\User;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%'.$request->string('search')->toString().'%');
        }

        $sort = $request->string('sort', 'newest')->toString();
        if ($sort === 'oldest') {
            $query->orderBy('created_at');
        } elseif ($sort === 'az') {
            $query->orderBy('title');
        } elseif ($sort === 'za') {
            $query->orderByDesc('title');
        } elseif ($sort === 'lessons_desc') {
            $query->withCount('lessons')->orderByDesc('lessons_count')->orderByDesc('created_at');
        } elseif ($sort === 'lessons_asc') {
            $query->withCount('lessons')->orderBy('lessons_count')->orderByDesc('created_at');
        } else {
            $query->orderByDesc('created_at');
        }

        $courses = $query->with(['school', 'type', 'lessons', 'postQuestions'])->withCount('lessons')->get();
        $user_id = Auth::id();

        $completedByCourse = [];
        $resultsByCourse = [];

        foreach ($courses as $course) {
            $totalLessons = $course->lessons->count();
            $completedCount = UserProgress::where('user_id', $user_id)
                ->whereIn('lesson_id', $course->lessons->pluck('id'))
                ->where('is_completed', true)
                ->count();

            $completedByCourse[$course->id] = $completedCount;

            $resultsByCourse[$course->id] = Result::where('user_id', $user_id)
                ->where('course_id', $course->id)
                ->exists();

            // Proactively create notification for post-test if lessons are finished but post-test not taken
            if ($totalLessons > 0 && $completedCount === $totalLessons && ! $resultsByCourse[$course->id]) {
                $notifActionUrl = route('tests.index', $course->id);
                $notifExists = Notification::where('user_id', $user_id)
                    ->where('action_url', $notifActionUrl)
                    ->exists();

                if (! $notifExists) {
                    Notification::create([
                        'user_id' => $user_id,
                        'title' => 'Materi Tuntas: '.$course->title,
                        'message' => 'Selamat! Kamu telah menyelesaikan semua materi di '.$course->title.'. Ayo ambil Post Test sekarang untuk mendapatkan nilai!',
                        'type' => 'result',
                        'action_url' => $notifActionUrl,
                        'is_read' => false,
                    ]);
                }
            }
        }

        return view('student.courses.index', compact('courses', 'completedByCourse', 'resultsByCourse'));
    }

    public function detail($id)
    {
        $course = Course::with(['lessons', 'postQuestions', 'preQuestions'])->findOrFail($id);
        $user_id = Auth::id();
        $progress = UserProgress::where('user_id', $user_id)
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->pluck('is_completed', 'lesson_id')
            ->toArray();

        $all_completed = $course->lessons->count() > 0 && $course->lessons->every(function ($lesson) use ($progress) {
            return isset($progress[$lesson->id]) && $progress[$lesson->id];
        });

        $has_post_test = $course->postQuestions->count() > 0;

        // Pretest info
        $has_pre_test = $course->preQuestions->count() > 0;
        $pre_test_done = $has_pre_test
            ? Result::where('user_id', $user_id)
                ->where('course_id', $id)
                ->where('type', 'pre')
                ->exists()
            : true; // No pretest → treat as "done" so lessons are freely accessible

        $students = User::query()
            ->where('role', 'student')
            ->with('school:id,name')
            ->orderBy('name')
            ->get(['id', 'name', 'username', 'school_id']);
        $student_count = $students->count();

        return view('student.courses.detail', compact(
            'course', 'progress', 'all_completed', 'has_post_test',
            'has_pre_test', 'pre_test_done',
            'students', 'student_count'
        ));
    }
}
