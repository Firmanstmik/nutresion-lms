<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\UserProgress;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show($id)
    {
        $lesson = Lesson::with('course.lessons')->findOrFail($id);
        $user_id = Auth::id();
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
