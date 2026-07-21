<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Notification;
use App\Models\Result;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    public function show($id)
    {
        $lesson = Lesson::with('course.lessons', 'course.preQuestions')->findOrFail($id);
        $user_id = Auth::id();

        if ($lesson->course->preQuestions->count() > 0) {
            $pretest_done = Result::where('user_id', $user_id)
                ->where('course_id', $lesson->course_id)
                ->where('type', 'pre')
                ->exists();

            if (! $pretest_done) {
                return redirect()->route('tests.pre.index', $lesson->course_id)
                    ->with('warning', 'Kamu harus mengerjakan Pre Test terlebih dahulu sebelum mengakses materi.');
            }
        }

        $progress = UserProgress::firstOrCreate(
            ['user_id' => $user_id, 'lesson_id' => $id],
            ['is_completed' => false, 'opened_at' => now()]
        );

        if ($progress->is_completed) {
            return redirect()->route('courses.detail', $lesson->course_id)
                ->with('info', 'Bab ini sudah selesai dan terkunci. Kamu tidak bisa membukanya lagi.');
        }

        if (! $progress->opened_at) {
            $progress->opened_at = now();
            $progress->save();
        }

        $elapsed = $progress->opened_at->diffInSeconds(now());
        $study_duration_seconds = $lesson->studyDurationSeconds();
        $remaining_seconds = max(0, $study_duration_seconds - (int) $elapsed);

        if ($remaining_seconds <= 0) {
            return $this->finalizeLesson($lesson, $user_id, true);
        }

        $is_completed = false;
        $study_duration_minutes = $lesson->studyDurationMinutes();

        return view('student.lessons.show', compact(
            'lesson',
            'is_completed',
            'remaining_seconds',
            'study_duration_seconds',
            'study_duration_minutes'
        ));
    }

    public function complete($id)
    {
        $lesson = Lesson::with('course')->findOrFail($id);
        $user_id = Auth::id();

        $progress = UserProgress::where('user_id', $user_id)
            ->where('lesson_id', $id)
            ->first();

        if ($progress && $progress->is_completed) {
            return redirect()->route('courses.detail', $lesson->course_id)
                ->with('info', 'Bab ini sudah selesai dan terkunci.');
        }

        return $this->finalizeLesson($lesson, $user_id, false);
    }

    private function finalizeLesson(Lesson $lesson, int $user_id, bool $fromTimeout)
    {
        $progress = UserProgress::firstOrNew(
            ['user_id' => $user_id, 'lesson_id' => $lesson->id]
        );
        $progress->is_completed = true;
        if (! $progress->opened_at) {
            $progress->opened_at = now();
        }
        $progress->save();

        $course = $lesson->course;
        $nextLesson = Lesson::where('course_id', $course->id)
            ->where('order_number', '>', $lesson->order_number)
            ->orderBy('order_number', 'asc')
            ->first();

        if ($nextLesson) {
            $title = 'Bab '.$lesson->order_number.' Selesai!';
            $message = 'Selamat! Kamu telah menyelesaikan Bab '.$lesson->order_number.': '.$lesson->title.'. Ayo lanjut ke Bab berikutnya: '.$nextLesson->title.'!';
            $action_url = route('lessons.show', $nextLesson->id);
            $type = 'course';
        } else {
            $title = 'Materi Tuntas!';
            $message = 'Selamat! Kamu telah menyelesaikan semua materi di '.$course->title.'. Ayo ambil Post Test sekarang untuk mendapatkan nilai!';
            $action_url = route('tests.index', $course->id);
            $type = 'result';
        }

        $existsNotif = Notification::where('user_id', $user_id)
            ->where('action_url', $action_url)
            ->where('title', $title)
            ->exists();

        if (! $existsNotif) {
            Notification::create([
                'user_id' => $user_id,
                'title' => $title,
                'message' => $message,
                'type' => $type,
                'action_url' => $action_url,
                'is_read' => false,
            ]);
        }

        $minutes = $lesson->studyDurationMinutes();
        $flash = $fromTimeout
            ? 'Waktu belajar '.$minutes.' menit habis. Bab dikunci otomatis.'
            : 'Bab telah diselesaikan dan dikunci!';

        return redirect()->route('courses.detail', $course->id)
            ->with('success', $flash);
    }
}
