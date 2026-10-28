{{-- Expects: $measurement (NutritionMeasurement) --}}
<div class="space-y-4">
    <div class="flex flex-wrap items-center gap-3">
        <span class="nt-badge nt-cat-{{ $measurement->category }}">{{ $measurement->categoryLabel() }}</span>
        <span class="text-sm text-slate-600">
            Diukur {{ $measurement->measured_at->locale('id')->translatedFormat('d M Y') }}
            · {{ $measurement->ageLabel() }}
            · {{ $measurement->sexLabel() }}
        </span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <div class="nt-stat">
            <div class="nt-stat-label">IMT</div>
            <div class="nt-stat-value">{{ $measurement->bmiDisplay() }}</div>
            <div class="nt-stat-unit">kg/m²</div>
        </div>
        <div class="nt-stat">
            <div class="nt-stat-label">Z-score IMT/U</div>
            <div class="nt-stat-value">{{ $measurement->zScoreDisplay() }}</div>
            <div class="nt-stat-unit">SD</div>
        </div>
        <div class="nt-stat">
            <div class="nt-stat-label">Berat</div>
            <div class="nt-stat-value">{{ $measurement->weightDisplay() }}</div>
            <div class="nt-stat-unit">kg</div>
        </div>
        <div class="nt-stat">
            <div class="nt-stat-label">Tinggi</div>
            <div class="nt-stat-value">{{ $measurement->heightDisplay() }}</div>
            <div class="nt-stat-unit">cm</div>
        </div>
    </div>

    <p class="text-sm text-slate-700">
        {{ \App\Services\NutritionAssessmentService::CATEGORY_DESCRIPTIONS[$measurement->category] ?? '' }}
    </p>
</div>
