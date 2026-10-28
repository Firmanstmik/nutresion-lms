<?php

namespace App\Services;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;

/**
 * IMT/U (BMI-for-age) assessment for adolescents using the WHO 2007 Growth
 * Reference (5–19 years) and WHO's restricted LMS method.
 *
 * Method, mirroring WHO's own anthroplus/anthro R packages:
 *  - IMT = weight_kg / (height_cm / 100)^2
 *  - exact age in months = age in days / 30.4375
 *  - L, M, S are linearly interpolated between the two surrounding whole months
 *  - z = ((IMT / M)^L - 1) / (L * S); beyond ±3 SD the WHO adjustment using the
 *    SD2–SD3 distance is applied
 *
 * See docs/IMT-U.md for sources and the decisions behind the age range and categories.
 */
class NutritionAssessmentService
{
    public const METHOD_VERSION = 'LMS-adjusted-v1';

    public const DAYS_PER_MONTH = 30.4375;

    /** 14 years 0 months, in completed months. */
    public const MIN_AGE_MONTHS = 168;

    /** Last supported completed month: 18 years 11 months (i.e. before the 19th birthday). */
    public const MAX_AGE_MONTHS = 227;

    public const MIN_WEIGHT_KG = 15;

    public const MAX_WEIGHT_KG = 250;

    public const MIN_HEIGHT_CM = 100;

    public const MAX_HEIGHT_CM = 230;

    public const SEXES = ['male', 'female'];

    public const SEX_LABELS = [
        'male' => 'Laki-laki',
        'female' => 'Perempuan',
    ];

    public const CATEGORY_LABELS = [
        'severely_thinness' => 'Gizi buruk',
        'thinness' => 'Gizi kurang',
        'normal' => 'Gizi baik',
        'overweight' => 'Gizi lebih',
        'obese' => 'Obesitas',
    ];

    public const CATEGORY_DESCRIPTIONS = [
        'severely_thinness' => 'IMT berada di bawah -3 SD menurut usia dan jenis kelamin (severely thinness).',
        'thinness' => 'IMT berada antara -3 SD dan di bawah -2 SD menurut usia dan jenis kelamin (thinness).',
        'normal' => 'IMT berada antara -2 SD dan +1 SD menurut usia dan jenis kelamin (normal).',
        'overweight' => 'IMT berada di atas +1 SD sampai +2 SD menurut usia dan jenis kelamin (overweight).',
        'obese' => 'IMT berada di atas +2 SD menurut usia dan jenis kelamin (obese).',
    ];

    private static ?array $defaultReference = null;

    private array $reference;

    /**
     * @param  array|null  $reference  Override for tests; defaults to the bundled WHO tables.
     */
    public function __construct(?array $reference = null)
    {
        $this->reference = $reference ?? self::loadDefaultReference();
    }

    private static function loadDefaultReference(): array
    {
        return self::$defaultReference ??= require resource_path('data/who2007/bmi_for_age.php');
    }

    /**
     * @return array{
     *   sex: string,
     *   birth_date: string,
     *   measured_at: string,
     *   age_months: int,
     *   age_months_exact: float,
     *   weight_kg: float,
     *   height_cm: float,
     *   bmi: float,
     *   lms: array{l: float, m: float, s: float},
     *   z_score: float,
     *   category: string,
     *   reference_version: string
     * }
     */
    public function assess(string $sex, CarbonInterface $birthDate, CarbonInterface $measuredAt, float $weightKg, float $heightCm): array
    {
        if (! in_array($sex, self::SEXES, true)) {
            throw new NutritionAssessmentException('Jenis kelamin belum diisi atau tidak valid.');
        }
        if ($weightKg < self::MIN_WEIGHT_KG || $weightKg > self::MAX_WEIGHT_KG) {
            throw new NutritionAssessmentException('Berat badan harus antara '.self::MIN_WEIGHT_KG.' dan '.self::MAX_WEIGHT_KG.' kg.');
        }
        if ($heightCm < self::MIN_HEIGHT_CM || $heightCm > self::MAX_HEIGHT_CM) {
            throw new NutritionAssessmentException('Tinggi badan harus antara '.self::MIN_HEIGHT_CM.' dan '.self::MAX_HEIGHT_CM.' cm.');
        }

        $birth = CarbonImmutable::parse($birthDate->format('Y-m-d'));
        $measured = CarbonImmutable::parse($measuredAt->format('Y-m-d'));

        if ($measured->lessThan($birth)) {
            throw new NutritionAssessmentException('Tanggal pengukuran tidak boleh sebelum tanggal lahir.');
        }

        $ageMonths = $this->completedMonths($birth, $measured);
        if ($ageMonths < self::MIN_AGE_MONTHS || $ageMonths > self::MAX_AGE_MONTHS) {
            throw new NutritionAssessmentException(
                'Penilaian IMT/U hanya tersedia untuk usia 14 tahun 0 bulan sampai sebelum 19 tahun pada tanggal pengukuran '
                .'(usia saat ini: '.intdiv($ageMonths, 12).' tahun '.($ageMonths % 12).' bulan). '
                .'Kategori IMT dewasa tidak digunakan sebagai pengganti.'
            );
        }

        $exactMonths = $this->exactMonths($birth, $measured);
        $bmi = $this->bmi($weightKg, $heightCm);
        $lms = $this->lms($sex, $exactMonths);
        $z = $this->zScore($bmi, $lms['l'], $lms['m'], $lms['s']);

        return [
            'sex' => $sex,
            'birth_date' => $birth->toDateString(),
            'measured_at' => $measured->toDateString(),
            'age_months' => $ageMonths,
            'age_months_exact' => $exactMonths,
            'weight_kg' => $weightKg,
            'height_cm' => $heightCm,
            'bmi' => $bmi,
            'lms' => $lms,
            'z_score' => $z,
            'category' => $this->category($z),
            'reference_version' => $this->referenceVersion(),
        ];
    }

    public function referenceVersion(): string
    {
        return ($this->reference['version'] ?? 'unknown').'/'.self::METHOD_VERSION;
    }

    public function bmi(float $weightKg, float $heightCm): float
    {
        $heightM = $heightCm / 100;

        return $weightKg / ($heightM * $heightM);
    }

    /**
     * Whole calendar months between the dates. Month-end birthdays count a month
     * as completed on the last day of a shorter month (31 Jan -> 28/29 Feb).
     */
    public function completedMonths(CarbonInterface $birth, CarbonInterface $measured): int
    {
        $birth = CarbonImmutable::parse($birth->format('Y-m-d'));
        $measured = CarbonImmutable::parse($measured->format('Y-m-d'));

        $months = ($measured->year - $birth->year) * 12 + ($measured->month - $birth->month);
        if ($birth->addMonthsNoOverflow($months)->greaterThan($measured)) {
            $months--;
        }

        return $months;
    }

    /** Age in days divided by WHO's 30.4375 days per month. */
    public function exactMonths(CarbonInterface $birth, CarbonInterface $measured): float
    {
        // round(): Carbon 3 returns a float, and a DST shift must not drop a whole day.
        $days = (int) round(CarbonImmutable::parse($birth->format('Y-m-d'))
            ->diffInDays(CarbonImmutable::parse($measured->format('Y-m-d')), true));

        return $days / self::DAYS_PER_MONTH;
    }

    /**
     * L, M, S for the given sex and exact age, linearly interpolated between the
     * surrounding whole months as WHO anthroplus does.
     *
     * @return array{l: float, m: float, s: float}
     */
    public function lms(string $sex, float $exactMonths): array
    {
        $low = (int) floor($exactMonths);
        $fraction = $exactMonths - $low;

        $lowRow = $this->row($sex, $low);
        if ($fraction <= 0) {
            return ['l' => (float) $lowRow[0], 'm' => (float) $lowRow[1], 's' => (float) $lowRow[2]];
        }

        $uppRow = $this->row($sex, $low + 1);

        return [
            'l' => $lowRow[0] + $fraction * ($uppRow[0] - $lowRow[0]),
            'm' => $lowRow[1] + $fraction * ($uppRow[1] - $lowRow[1]),
            's' => $lowRow[2] + $fraction * ($uppRow[2] - $lowRow[2]),
        ];
    }

    private function row(string $sex, int $month): array
    {
        $row = $this->reference['data'][$sex][$month] ?? null;
        if (! is_array($row) || count($row) < 3) {
            throw new NutritionAssessmentException('Data referensi WHO untuk usia dan jenis kelamin ini tidak tersedia.');
        }

        return $row;
    }

    /** The y value sitting exactly at z SD for the given L, M, S. */
    public function valueAtSd(float $sd, float $l, float $m, float $s): float
    {
        if (abs($l) < 1e-12) {
            return $m * exp($s * $sd);
        }

        return $m * ((1 + $l * $s * $sd) ** (1 / $l));
    }

    /** WHO restricted LMS z-score (anthro::compute_zscore_adjusted). */
    public function zScore(float $y, float $l, float $m, float $s): float
    {
        if ($y <= 0 || $m <= 0 || $s <= 0) {
            throw new NutritionAssessmentException('Nilai IMT atau data referensi tidak valid.');
        }

        $z = abs($l) < 1e-12
            ? log($y / $m) / $s
            : ((($y / $m) ** $l) - 1) / ($l * $s);

        if ($z > 3) {
            $sd3pos = $this->valueAtSd(3, $l, $m, $s);
            $sd23pos = $sd3pos - $this->valueAtSd(2, $l, $m, $s);

            return 3 + ($y - $sd3pos) / $sd23pos;
        }

        if ($z < -3) {
            $sd3neg = $this->valueAtSd(-3, $l, $m, $s);
            $sd23neg = $this->valueAtSd(-2, $l, $m, $s) - $sd3neg;

            return -3 + ($y - $sd3neg) / $sd23neg;
        }

        return $z;
    }

    /** Category from the unrounded z-score (Permenkes 2/2020 IMT/U, WHO 2007 cut-offs). */
    public function category(float $z): string
    {
        return match (true) {
            $z < -3 => 'severely_thinness',
            $z < -2 => 'thinness',
            $z <= 1 => 'normal',
            $z <= 2 => 'overweight',
            default => 'obese',
        };
    }
}
