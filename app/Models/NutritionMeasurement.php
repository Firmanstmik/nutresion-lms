<?php

namespace App\Models;

use App\Services\NutritionAssessmentService;
use Illuminate\Database\Eloquent\Model;

class NutritionMeasurement extends Model
{
    /**
     * Every column is computed or set server-side; user_id and recorded_by are
     * never taken from request input.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'recorded_by',
        'measured_at',
        'birth_date',
        'sex',
        'age_months',
        'weight_kg',
        'height_cm',
        'bmi',
        'z_score',
        'category',
        'reference_version',
    ];

    protected function casts(): array
    {
        return [
            'measured_at' => 'date',
            'birth_date' => 'date',
            'age_months' => 'integer',
            'weight_kg' => 'float',
            'height_cm' => 'float',
            'bmi' => 'float',
            'z_score' => 'float',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function categoryLabel(): string
    {
        return NutritionAssessmentService::CATEGORY_LABELS[$this->category] ?? $this->category;
    }

    public function ageLabel(): string
    {
        return intdiv($this->age_months, 12).' tahun '.($this->age_months % 12).' bulan';
    }

    public function sexLabel(): string
    {
        return NutritionAssessmentService::SEX_LABELS[$this->sex] ?? $this->sex;
    }

    /** Display only: 1 decimal, Indonesian decimal comma. */
    public function bmiDisplay(): string
    {
        return number_format($this->bmi, 1, ',', '.');
    }

    public function weightDisplay(): string
    {
        return self::trimDecimals(number_format($this->weight_kg, 2, ',', '.'));
    }

    public function heightDisplay(): string
    {
        return self::trimDecimals(number_format($this->height_cm, 1, ',', '.'));
    }

    /** "54,00" -> "54", "54,50" -> "54,5". */
    private static function trimDecimals(string $value): string
    {
        return str_contains($value, ',') ? rtrim(rtrim($value, '0'), ',') : $value;
    }

    /** Display only: 2 decimals with explicit sign, never "-0,00". */
    public function zScoreDisplay(): string
    {
        $rounded = round($this->z_score, 2);
        if ($rounded == 0.0) {
            return '0,00';
        }

        return ($rounded > 0 ? '+' : '-').number_format(abs($rounded), 2, ',', '.');
    }
}
