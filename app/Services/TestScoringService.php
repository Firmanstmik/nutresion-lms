<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class TestScoringService
{
    /**
     * @return array{
     *   answer_rows: array<int, array<string, mixed>>,
     *   score: int,
     *   mc_score: int|null,
     *   likert_score: int|null,
     *   mc_correct: int,
     *   mc_total: int,
     *   likert_sum: int,
     *   likert_total: int
     * }
     */
    public function grade(Collection $questions, Request $request): array
    {
        $now = now();
        $answerRows = [];

        $mcCorrect = 0;
        $mcTotal = 0;
        $likertSum = 0;
        $likertTotal = 0;

        foreach ($questions as $question) {
            /** @var Question $question */
            $selected = $request->input('question_'.$question->id);

            if ($question->isLikert()) {
                $likertTotal++;
                $raw = is_numeric($selected) ? (int) $selected : null;
                $points = $question->likertPoints($raw);
                if ($points !== null) {
                    $likertSum += $points;
                }

                $answerRows[] = [
                    'question_id' => $question->id,
                    'selected_answer' => $raw !== null ? (string) $raw : null,
                    'is_correct' => $points !== null && $points >= 4,
                    'points' => $points,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                continue;
            }

            $mcTotal++;
            $isCorrect = $selected !== null && $selected === $question->correct_answer;
            if ($isCorrect) {
                $mcCorrect++;
            }

            $answerRows[] = [
                'question_id' => $question->id,
                'selected_answer' => $selected,
                'is_correct' => $isCorrect,
                'points' => $isCorrect ? 5 : 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        $mcScore = $mcTotal > 0 ? (int) round(($mcCorrect / $mcTotal) * 100) : null;
        $likertScore = $likertTotal > 0 ? (int) round(($likertSum / (5 * $likertTotal)) * 100) : null;

        $earned = ($mcCorrect * 5) + $likertSum;
        $possible = (5 * $mcTotal) + (5 * $likertTotal);
        $score = $possible > 0 ? (int) round(($earned / $possible) * 100) : 0;

        return [
            'answer_rows' => $answerRows,
            'score' => $score,
            'mc_score' => $mcScore,
            'likert_score' => $likertScore,
            'mc_correct' => $mcCorrect,
            'mc_total' => $mcTotal,
            'likert_sum' => $likertSum,
            'likert_total' => $likertTotal,
        ];
    }
}
