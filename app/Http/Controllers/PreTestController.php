<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Notification;
use App\Models\Result;
use App\Models\ResultAnswer;
use App\Services\TestScoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class PreTestController extends Controller
{
    public function index(int $course_id)
    {
        $course = Course::with(['lessons', 'preQuestions'])->findOrFail($course_id);
        $user_id = Auth::id();

        if ($course->preQuestions->count() === 0) {
            return redirect()->route('courses.detail', $course_id)
                ->with('info', 'Kursus ini tidak memiliki Pretest.');
        }

        $already_done = Result::where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->where('type', 'pre')
            ->exists();

        if ($already_done) {
            return redirect()->route('courses.detail', $course_id)
                ->with('info', 'Kamu sudah mengerjakan Pretest untuk kursus ini.');
        }

        $mcQuestions = $course->preQuestions->filter->isMultipleChoice()->values();
        $likertQuestions = $course->preQuestions->filter->isLikert()->values();
        $question_count = $course->preQuestions->count();
        $duration_minutes = max(1, $question_count);
        $duration_seconds = $duration_minutes * 60;

        return view('student.tests.pretest', compact(
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
        $course = Course::with('preQuestions')->findOrFail($course_id);
        $user_id = Auth::id();

        if (Result::where('user_id', $user_id)->where('course_id', $course_id)->where('type', 'pre')->exists()) {
            return redirect()->route('courses.detail', $course_id)
                ->with('error', 'Anda sudah mengambil Pretest ini.');
        }

        $graded = $scoring->grade($course->preQuestions, $request);

        $resultData = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'score' => $graded['score'],
            'type' => 'pre',
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
            'title' => 'Pre Test Selesai: '.$course->title,
            'message' => 'Kamu telah menyelesaikan Pre Test untuk '.$course->title.' dengan nilai '.$graded['score'].'. Sekarang kamu bisa mulai belajar!',
            'type' => 'course',
            'action_url' => route('courses.detail', $course_id),
            'is_read' => false,
        ]);

        return redirect()->route('courses.detail', $course_id)
            ->with('success', 'Pre Test selesai! Nilai kamu: '.$graded['score'].'. Selamat belajar!');
    }
}
