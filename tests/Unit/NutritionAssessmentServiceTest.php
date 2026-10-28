<?php

namespace Tests\Unit;

use App\Services\NutritionAssessmentException;
use App\Services\NutritionAssessmentService;
use Carbon\CarbonImmutable;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class NutritionAssessmentServiceTest extends TestCase
{
    private NutritionAssessmentService $service;

    private array $reference;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new NutritionAssessmentService;
        $this->reference = require resource_path('data/who2007/bmi_for_age.php');
    }

    private function date(string $date): CarbonImmutable
    {
        return CarbonImmutable::parse($date);
    }

    // ── IMT ──────────────────────────────────────────────────────────────

    public function test_bmi_uses_kilograms_and_metres(): void
    {
        $bmi = $this->service->bmi(54, 166);

        $this->assertEqualsWithDelta(19.5965, $bmi, 0.0001);
        $this->assertSame('19.6', number_format($bmi, 1));
    }

    // ── Reference data ───────────────────────────────────────────────────

    public function test_reference_covers_both_sexes_for_every_month_from_61_to_228(): void
    {
        foreach (['male', 'female'] as $sex) {
            $this->assertSame(range(61, 228), array_keys($this->reference['data'][$sex]), $sex);
        }
    }

    /**
     * Every published SD cut-off must be reproduced from the published L, M, S.
     * This guards both the data file and the LMS formula.
     */
    public function test_lms_reproduces_every_published_sd_column(): void
    {
        $sds = [-3, -2, -1, 0, 1, 2, 3];
        foreach (['male', 'female'] as $sex) {
            foreach ($this->reference['data'][$sex] as $month => $row) {
                [$l, $m, $s] = $row;
                foreach ($sds as $i => $sd) {
                    $this->assertEqualsWithDelta(
                        $row[3 + $i],
                        $this->service->valueAtSd($sd, $l, $m, $s),
                        0.0015,
                        "{$sex} month {$month} SD {$sd}"
                    );
                }
            }
        }
    }

    public function test_known_who_rows_are_loaded_verbatim(): void
    {
        // Same L, M, S as WHO's computation.pdf "Child 2" (16-year-old boy).
        $this->assertSame([-1.3529, 20.4951, 0.12579], array_slice($this->reference['data']['male'][192], 0, 3));
        // The two cells where Tabel_IMT_Usia_14-19_Tahun.docx differs from WHO.
        $this->assertSame(28.271, $this->reference['data']['male'][198][8]);
        $this->assertSame(23.972, $this->reference['data']['male'][199][7]);
    }

    // ── Z-score (WHO worked examples, computation.pdf) ───────────────────

    public function test_who_example_within_three_sd(): void
    {
        // Child 3: 9-year-old boy, BMI 19 -> 1.47
        $z = $this->service->zScore(19, -1.6318, 16.0490, 0.10038);
        $this->assertSame(1.47, round($z, 2));
    }

    public function test_who_example_above_plus_three_sd_is_adjusted(): void
    {
        // Child 1: 11-year-old boy, BMI 30 -> unadjusted 3.24, adjusted 3.35
        // WHO's printed example rounds its intermediates (28.03, 5.58), so allow 0.01.
        $z = $this->service->zScore(30, -1.7862, 16.9392, 0.11070);
        $this->assertEqualsWithDelta(3.35, $z, 0.01);
    }

    public function test_who_example_below_minus_three_sd_is_adjusted(): void
    {
        // Child 2: 16-year-old boy, BMI 14 -> unadjusted -3.96, adjusted -3.80
        // WHO's printed example rounds its intermediates (15.11, 1.39); full precision gives -3.794.
        $z = $this->service->zScore(14, -1.3529, 20.4951, 0.12579);
        $this->assertEqualsWithDelta(-3.80, $z, 0.01);
    }

    public function test_extremes_follow_published_sd2_sd3_distance(): void
    {
        $row = $this->reference['data']['female'][200];
        [$l, $m, $s, $sd3neg, $sd2neg] = $row;
        [$sd2, $sd3] = [$row[8], $row[9]];

        $this->assertEqualsWithDelta(3 + (45 - $sd3) / ($sd3 - $sd2), $this->service->zScore(45, $l, $m, $s), 0.01);
        $this->assertEqualsWithDelta(-3 + (12 - $sd3neg) / ($sd2neg - $sd3neg), $this->service->zScore(12, $l, $m, $s), 0.01);
    }

    public function test_bmi_equal_to_median_gives_zero(): void
    {
        [$l, $m, $s] = $this->reference['data']['male'][180];
        $this->assertEqualsWithDelta(0.0, $this->service->zScore($m, $l, $m, $s), 1e-12);
    }

    public function test_lms_for_boys_and_girls_uses_their_own_table(): void
    {
        foreach (['male', 'female'] as $sex) {
            $row = $this->reference['data'][$sex][192];
            $lms = $this->service->lms($sex, 192.0);
            // BMI exactly at the published -1 SD cut-off scores -1 for that sex.
            $this->assertEqualsWithDelta(-1.0, $this->service->zScore($row[5], $lms['l'], $lms['m'], $lms['s']), 0.001, $sex);
        }

        $male = $this->service->lms('male', 192.0);
        $female = $this->service->lms('female', 192.0);
        $this->assertNotEqualsWithDelta(
            $this->service->zScore(19.6, $male['l'], $male['m'], $male['s']),
            $this->service->zScore(19.6, $female['l'], $female['m'], $female['s']),
            0.01
        );
    }

    public function test_l_equal_to_zero_uses_the_log_limit(): void
    {
        $this->assertEqualsWithDelta(log(22 / 20) / 0.1, $this->service->zScore(22, 0.0, 20, 0.1), 1e-12);
        $this->assertEqualsWithDelta(20 * exp(0.1 * 2), $this->service->valueAtSd(2, 0.0, 20, 0.1), 1e-12);
    }

    public function test_lms_is_interpolated_between_months(): void
    {
        $a = $this->reference['data']['female'][170];
        $b = $this->reference['data']['female'][171];
        $lms = $this->service->lms('female', 170.25);

        $this->assertEqualsWithDelta($a[0] + 0.25 * ($b[0] - $a[0]), $lms['l'], 1e-12);
        $this->assertEqualsWithDelta($a[1] + 0.25 * ($b[1] - $a[1]), $lms['m'], 1e-12);
        $this->assertEqualsWithDelta($a[2] + 0.25 * ($b[2] - $a[2]), $lms['s'], 1e-12);
    }

    // ── Categories ───────────────────────────────────────────────────────

    public static function categoryBoundaries(): array
    {
        return [
            'below -3' => [-3.0001, 'severely_thinness'],
            'exactly -3' => [-3.0, 'thinness'],
            'just below -2' => [-2.0001, 'thinness'],
            'exactly -2' => [-2.0, 'normal'],
            'zero' => [0.0, 'normal'],
            'exactly +1' => [1.0, 'normal'],
            'just above +1' => [1.0001, 'overweight'],
            'exactly +2' => [2.0, 'overweight'],
            'just above +2' => [2.0001, 'obese'],
            'far above' => [4.5, 'obese'],
            'far below' => [-4.5, 'severely_thinness'],
        ];
    }

    #[DataProvider('categoryBoundaries')]
    public function test_category_boundaries(float $z, string $expected): void
    {
        $this->assertSame($expected, $this->service->category($z));
    }

    public function test_category_uses_unrounded_z(): void
    {
        // -2.004 would display as -2.00 but is still below -2.
        $this->assertSame('thinness', $this->service->category(-2.004));
        $this->assertSame('overweight', $this->service->category(1.004));
    }

    // ── Age ──────────────────────────────────────────────────────────────

    public function test_completed_months_on_measurement_date(): void
    {
        $birth = $this->date('2010-05-15');
        $this->assertSame(167, $this->service->completedMonths($birth, $this->date('2024-05-14')));
        $this->assertSame(168, $this->service->completedMonths($birth, $this->date('2024-05-15')));
        $this->assertSame(203, $this->service->completedMonths($birth, $this->date('2027-05-14')));
    }

    public function test_completed_months_month_end_and_leap_day(): void
    {
        $this->assertSame(1, $this->service->completedMonths($this->date('2010-01-31'), $this->date('2010-02-28')));
        $this->assertSame(0, $this->service->completedMonths($this->date('2010-01-31'), $this->date('2010-02-27')));
        // Born 29 Feb: the 14th birthday in a non-leap year is 28 Feb.
        $this->assertSame(168, $this->service->completedMonths($this->date('2008-02-29'), $this->date('2022-02-28')));
        $this->assertSame(167, $this->service->completedMonths($this->date('2008-02-29'), $this->date('2022-02-27')));
    }

    public function test_exact_months_use_who_days_per_month(): void
    {
        $this->assertEqualsWithDelta(3653 / 30.4375, $this->service->exactMonths($this->date('2000-01-01'), $this->date('2010-01-01')), 1e-9);
    }

    public function test_assess_accepts_first_and_last_supported_day(): void
    {
        $first = $this->service->assess('female', $this->date('2010-05-15'), $this->date('2024-05-15'), 54, 166);
        $this->assertSame(168, $first['age_months']);

        $last = $this->service->assess('male', $this->date('2010-05-15'), $this->date('2029-05-14'), 54, 166);
        $this->assertSame(227, $last['age_months']);
    }

    public function test_assess_rejects_under_14(): void
    {
        $this->expectException(NutritionAssessmentException::class);
        $this->expectExceptionMessage('14 tahun 0 bulan');
        $this->service->assess('male', $this->date('2010-05-15'), $this->date('2024-05-14'), 54, 166);
    }

    public function test_assess_rejects_from_19th_birthday(): void
    {
        $this->expectException(NutritionAssessmentException::class);
        $this->expectExceptionMessage('Kategori IMT dewasa tidak digunakan');
        $this->service->assess('male', $this->date('2010-05-15'), $this->date('2029-05-15'), 54, 166);
    }

    public function test_assess_rejects_measurement_before_birth(): void
    {
        $this->expectException(NutritionAssessmentException::class);
        $this->service->assess('male', $this->date('2010-05-15'), $this->date('2010-05-14'), 54, 166);
    }

    public static function invalidInputs(): array
    {
        return [
            'unknown sex' => ['x', 54, 166],
            'zero weight' => ['male', 0, 166],
            'negative weight' => ['male', -5, 166],
            'absurd weight' => ['male', 400, 166],
            'height in metres' => ['male', 54, 1.66],
            'absurd height' => ['male', 54, 300],
        ];
    }

    #[DataProvider('invalidInputs')]
    public function test_assess_rejects_invalid_inputs(string $sex, float $weight, float $height): void
    {
        $this->expectException(NutritionAssessmentException::class);
        $this->service->assess($sex, $this->date('2008-01-10'), $this->date('2024-06-01'), $weight, $height);
    }

    public function test_assess_returns_full_result(): void
    {
        $result = $this->service->assess('male', $this->date('2008-01-10'), $this->date('2024-06-01'), 54, 166);

        $this->assertSame(196, $result['age_months']);
        $this->assertEqualsWithDelta(19.5965, $result['bmi'], 0.0001);
        $this->assertSame('normal', $result['category']);
        $this->assertSame('WHO2007-BMIFA-exp/LMS-adjusted-v1', $result['reference_version']);
        // Sanity: a BMI slightly under the median at this age gives a small negative z.
        $this->assertGreaterThan(-1, $result['z_score']);
        $this->assertLessThan(0, $result['z_score']);
    }

    // ── Missing reference data ───────────────────────────────────────────

    public function test_missing_sex_table_is_reported_not_guessed(): void
    {
        $service = new NutritionAssessmentService(['version' => 'test', 'data' => ['male' => $this->reference['data']['male']]]);

        $this->expectException(NutritionAssessmentException::class);
        $this->expectExceptionMessage('Data referensi WHO');
        $service->assess('female', $this->date('2008-01-10'), $this->date('2024-06-01'), 54, 166);
    }

    public function test_missing_month_is_reported_not_guessed(): void
    {
        $data = $this->reference['data'];
        unset($data['male'][196], $data['male'][197]);
        $service = new NutritionAssessmentService(['version' => 'test', 'data' => $data]);

        $this->expectException(NutritionAssessmentException::class);
        $service->assess('male', $this->date('2008-01-10'), $this->date('2024-06-01'), 54, 166);
    }
}
