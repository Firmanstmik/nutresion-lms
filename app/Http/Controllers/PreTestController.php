<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Notification;
use App\Models\Result;
use App\Models\ResultAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreTestController extends Controller
{
    /**
     * Tampilkan soal pretest.
     */
    public function index($course_id)
    {
        $course = Course::with(['lessons', 'preQuestions'])->findOrFail($course_id);
        $user_id = Auth::id();

        // Kalau tidak ada soal pretest, langsung ke detail kursus
        if ($course->preQuestions->count() === 0) {
            return redirect()->route('courses.detail', $course_id)
                ->with('info', 'Kursus ini tidak memiliki Pretest.');
        }

        // Kalau sudah dikerjakan, langsung ke detail kursus
        $already_done = Result::where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->where('type', 'pre')
            ->exists();

        if ($already_done) {
            return redirect()->route('courses.detail', $course_id)
                ->with('info', 'Kamu sudah mengerjakan Pretest untuk kursus ini.');
        }

        $question_count = $course->preQuestions->count();
        $duration_minutes = max(1, $question_count);
        $duration_seconds = $duration_minutes * 60;

        return view('student.tests.pretest', compact('course', 'duration_seconds', 'duration_minutes', 'question_count'));
    }

    /**
     * Simpan hasil pretest.
     */
    public function submit(Request $request, $course_id)
    {
        $course = Course::with('preQuestions')->findOrFail($course_id);
        $user_id = Auth::id();

        // Jika sudah dikerjakan, tolak
        if (Result::where('user_id', $user_id)->where('course_id', $course_id)->where('type', 'pre')->exists()) {
            return redirect()->route('courses.detail', $course_id)
                ->with('error', 'Anda sudah mengambil Pretest ini.');
        }

        $questions = $course->preQuestions;
        $total_questions = $questions->count();

        $correct_count = 0;
        $answer_rows = [];
        $now = now();

        foreach ($questions as $question) {
            $answer_key = 'question_'.$question->id;
            $selected = $request->input($answer_key);
            $is_correct = $selected !== null && $selected === $question->correct_answer;
            if ($is_correct) {
                $correct_count++;
            }
            $answer_rows[] = [
                'question_id' => $question->id,
                'selected_answer' => $selected,
                'is_correct' => $is_correct,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $final_score = $total_questions > 0 ? ($correct_count / $total_questions) * 100 : 0;
        $rounded_score = round($final_score);

        $result = Result::create([
            'user_id' => $user_id,
            'course_id' => $course_id,
            'score' => $rounded_score,
            'type' => 'pre',
        ]);

        if (count($answer_rows) > 0) {
            foreach ($answer_rows as &$row) {
                $row['result_id'] = $result->id;
            }
            unset($row);
            ResultAnswer::insert($answer_rows);
        }

        // Notifikasi
        Notification::create([
            'user_id' => $user_id,
            'title' => 'Pre Test Selesai: '.$course->title,
            'message' => 'Kamu telah menyelesaikan Pre Test untuk '.$course->title.' dengan nilai '.$rounded_score.'. Sekarang kamu bisa mulai belajar!',
            'type' => 'course',
            'action_url' => route('courses.detail', $course_id),
            'is_read' => false,
        ]);

        return redirect()->route('courses.detail', $course_id)
            ->with('success', 'Pre Test selesai! Nilai kamu: '.$rounded_score.'. Selamat belajar!');
    }
}
