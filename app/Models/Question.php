<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public const FORMAT_MULTIPLE_CHOICE = 'multiple_choice';

    public const FORMAT_LIKERT = 'likert';

    public const POLARITY_POSITIVE = 'positive';

    public const POLARITY_NEGATIVE = 'negative';

    public const LIKERT_OPTIONS = [
        5 => 'Sangat Setuju',
        4 => 'Setuju',
        3 => 'Netral',
        2 => 'Tidak Setuju',
        1 => 'Sangat Tidak Setuju',
    ];

    protected $fillable = [
        'course_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'type',
        'format',
        'polarity',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function isLikert(): bool
    {
        return ($this->format ?? self::FORMAT_MULTIPLE_CHOICE) === self::FORMAT_LIKERT;
    }

    public function isMultipleChoice(): bool
    {
        return ! $this->isLikert();
    }

    public function likertPoints(?int $raw): ?int
    {
        if ($raw === null || $raw < 1 || $raw > 5) {
            return null;
        }

        if (($this->polarity ?? self::POLARITY_POSITIVE) === self::POLARITY_NEGATIVE) {
            return 6 - $raw;
        }

        return $raw;
    }

    public static function likertLabel(?string $value): string
    {
        if ($value === null || $value === '') {
            return '—';
        }

        $key = (int) $value;

        return self::LIKERT_OPTIONS[$key] ?? (string) $value;
    }
}
