<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Notification;
use App\Models\Result;
use App\Models\ResultAnswer;
use App\Models\UserProgress;
use App\Services\TestScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class TestController extends Controller
{
    public function index(int $course_id)
    {
        $course = Course::with(['lessons', 'postQuestions'])->findOrFail($course_id);
        $user_id = Auth::id();

        if ($course->postQuestions->count() === 0) {
            return redirect()->route('courses.detail', $course_id)->with('error', 'Belum ada soal Post Test untuk kursus ini.');
        }

        $progress = UserProgress::where('user_id', $user_id)
            ->whereIn('lesson_id', $course->lessons->pluck('id'))
            ->where('is_completed', true)
            ->count();

        if ($progress < $course->lessons->count()) {
            return redirect()->route('courses.detail', $course_id)->with('error', 'Selesaikan semua bab sebelum Post Test.');
        }

        $existing_result = Result::where('user_id', $user_id)->where('course_id', $course_id)->where('type', 'post')->first();
        if ($existing_result) {
            return view('student.tests.completed', compact('course', 'existing_result'));
        }

        $mcQuestions = $course->postQuestions->filter->isMultipleChoice()->values();
        $likertQuestions = $course->postQuestions->filter->isLikert()->values();
        $question_count = $course->postQuestions->count();
        $duration_minutes = max(1, $question_count);
        $duration_seconds = $duration_minutes * 60;

        return view('student.tests.index', compact(
            'course',
            'mcQuestions',
            'likertQuestions',
            'duration_seconds',
            'duration_minutes',
            'question_count'
        ));
    }

    public function submit(Request $request, int $course_id, TestScoringService $scoring)
    {
        $course = Course::with('postQuestions')->findOrFail($course_id);
        $user_id = Auth::id();

        if (Result::where('user_id', $user_id)->where('course_id', $course_id)->where('type', 'post')->exists()) {
            return redirect()->route('courses.detail', $course_id)->with('error', 'Anda sudah mengambil test ini.');
        }

        $graded = $scoring->grade($course->postQuestions, $request);

        $resultData = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'score' => $graded['score'],
            'type' => 'post',
        ];

        if (Schema::hasColumn('results', 'mc_score')) {
            $resultData['mc_score'] = $graded['mc_score'];
            $resultData['likert_score'] = $graded['likert_score'];
        }

        $result = Result::create($resultData);

        if (count($graded['answer_rows']) > 0 && Schema::hasTable('result_answers')) {
            $rows = $graded['answer_rows'];
            foreach ($rows as &$row) {
                $row['result_id'] = $result->id;
                if (! Schema::hasColumn('result_answers', 'points')) {
                    unset($row['points']);
                }
            }
            unset($row);
            ResultAnswer::insert($rows);
        }

        Notification::create([
            'user_id' => $user_id,
            'title' => 'Post Test Selesai: '.$course->title,
            'message' => 'Selamat! Kamu telah menyelesaikan Post Test untuk '.$course->title.' dengan nilai '.$graded['score'].'. Klik di sini untuk melihat detail hasil belajarmu.',
            'type' => 'result',
            'action_url' => route('results.show', $result->id),
            'is_read' => false,
        ]);

        return redirect()->route('results.show', $result->id);
    }

    public function result(int $id)
    {
        $query = Result::with('course');
        if (Schema::hasTable('result_answers')) {
            $query->with(['answers.question']);
        }

        $result = $query->findOrFail($id);
        if ($result->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $answers = Schema::hasTable('result_answers') ? ($result->answers ?? collect()) : collect();
        $hasDetail = Schema::hasTable('result_answers') && $answers->count() > 0;

        return view('student.results.show', compact('result', 'answers', 'hasDetail'));
    }

    public function myResults()
    {
        $user_id = Auth::id();
        $allResults = Result::where('user_id', $user_id)->with('course')->get();
        $preResults = $allResults->where('type', 'pre')->values();
        $postResults = $allResults->where('type', 'post')->values();
        $results = $postResults;

        return view('student.results.index', compact('results', 'preResults', 'postResults'));
    }
}
