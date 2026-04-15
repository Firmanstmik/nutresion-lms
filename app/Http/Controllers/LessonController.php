<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Result;
use App\Models\UserProgress;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show($id)
    {
        $lesson = Lesson::with('course.lessons', 'course.preQuestions')->findOrFail($id);
        $user_id = Auth::id();

        // ── Pretest Gate ──────────────────────────────────────────────
        // Jika kursus ini punya soal pretest, siswa WAJIB mengerjakan
        // pretest terlebih dahulu sebelum bisa membuka bab manapun.
        if ($lesson->course->preQuestions->count() > 0) {
            $pretest_done = Result::where('user_id', $user_id)
                ->where('course_id', $lesson->course_id)
                ->where('type', 'pre')
                ->exists();

            if (!$pretest_done) {
                return redirect()->route('tests.pre.index', $lesson->course_id)
                    ->with('warning', 'Kamu harus mengerjakan Pre Test terlebih dahulu sebelum mengakses materi.');
            }
        }
        // ─────────────────────────────────────────────────────────────
        $progress = UserProgress::where('user_id', $user_id)
            ->where('lesson_id', $id)
            ->first();
        
        $is_completed = $progress ? $progress->is_completed : false;

        return view('student.lessons.show', compact('lesson', 'is_completed'));
    }

    public function complete($id)
    {
        $lesson = Lesson::findOrFail($id);
        $user_id = Auth::id();

        UserProgress::updateOrCreate(
            ['user_id' => $user_id, 'lesson_id' => $id],
            ['is_completed' => true]
        );

        // Notification Logic
        $course = $lesson->course;
        $nextLesson = Lesson::where('course_id', $course->id)
            ->where('order_number', '>', $lesson->order_number)
            ->orderBy('order_number', 'asc')
            ->first();

        if ($nextLesson) {
            $title = "Bab " . $lesson->order_number . " Selesai!";
            $message = "Selamat! Kamu telah menyelesaikan Bab " . $lesson->order_number . ": " . $lesson->title . ". Ayo lanjut ke Bab berikutnya: " . $nextLesson->title . "!";
            $action_url = route('lessons.show', $nextLesson->id);
            $type = 'course';
        } else {
            $title = "Materi Tuntas!";
            $message = "Selamat! Kamu telah menyelesaikan semua materi di " . $course->title . ". Ayo ambil Post Test sekarang untuk mendapatkan nilai!";
            $action_url = route('tests.index', $course->id);
            $type = 'result';
        }

        Notification::create([
            'user_id' => $user_id,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'action_url' => $action_url,
            'is_read' => false,
        ]);

        return redirect()->route('courses.detail', $course->id)
            ->with('success', 'Bab telah diselesaikan!');
    }
}
