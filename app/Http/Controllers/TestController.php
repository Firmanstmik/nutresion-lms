<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Result;
use App\Models\UserProgress;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function index($course_id)
    {
        $course = Course::with(['lessons', 'postQuestions'])->findOrFail($course_id);
        $user_id = Auth::id();

        // Check if there are any post-test questions
        if ($course->postQuestions->count() === 0) {
            return redirect()->route('courses.detail', $course_id)->with('error', 'Belum ada soal Post Test untuk kursus ini.');
        }

        // Check if all lessons are completed
        $progress = UserProgress::where('user_id', $user_id)
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->where('is_completed', true)
            ->count();
        
        if ($progress < $course->lessons->count()) {
            return redirect()->route('courses.detail', $course_id)->with('error', 'Selesaikan semua bab sebelum Post Test.');
        }

        // Check if test already taken
        $existing_result = Result::where('user_id', $user_id)->where('course_id', $course_id)->first();
        if ($existing_result) {
            return redirect()->route('results.show', $existing_result->id);
        }

        return view('student.tests.index', compact('course'));
    }

    public function submit(Request $request, $course_id)
    {
        $course = Course::with('postQuestions')->findOrFail($course_id);
        $user_id = Auth::id();

        // Check if test already taken
        if (Result::where('user_id', $user_id)->where('course_id', $course_id)->exists()) {
            return redirect()->route('courses.detail', $course_id)->with('error', 'Anda sudah mengambil test ini.');
        }

        $score = 0;
        $questions = $course->postQuestions;
        $total_questions = $questions->count();

        foreach ($questions as $question) {
            $answer_key = 'question_' . $question->id;
            if ($request->has($answer_key) && $request->input($answer_key) === $question->correct_answer) {
                $score++;
            }
        }

        $final_score = $total_questions > 0 ? ($score / $total_questions) * 100 : 0;
        $rounded_score = round($final_score);

        $result = Result::create([
            'user_id' => $user_id,
            'course_id' => $course_id,
            'score' => $rounded_score,
        ]);

        // Create Notification for Result
        Notification::create([
            'user_id' => $user_id,
            'title' => "Post Test Selesai: " . $course->title,
            'message' => "Selamat! Kamu telah menyelesaikan Post Test untuk " . $course->title . " dengan nilai " . $rounded_score . ". Klik di sini untuk melihat detail hasil belajarmu.",
            'type' => 'result',
            'action_url' => route('results.show', $result->id),
            'is_read' => false,
        ]);

        return redirect()->route('results.show', $result->id);
    }

    public function result($id)
    {
        $result = Result::with('course')->findOrFail($id);
        if ($result->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }
        return view('student.results.show', compact('result'));
    }

    public function myResults()
    {
        $results = Result::where('user_id', Auth::id())->with('course')->get();
        return view('student.results.index', compact('results'));
    }
}
