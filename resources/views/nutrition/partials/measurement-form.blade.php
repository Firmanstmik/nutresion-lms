{{-- Expects: $action (url), $student (User) --}}
@php $ready = $student->hasNutritionProfile(); @endphp
<form action="{{ $action }}" method="POST" class="space-y-4" data-nt-loading>
    @csrf
    @unless($ready)
        <div class="nt-alert nt-alert-err">Lengkapi tanggal lahir dan jenis kelamin terlebih dahulu sebelum menyimpan pengukuran.</div>
    @endunless
    @error('measurement')
        <div class="nt-alert nt-alert-err" role="alert">{{ $message }}</div>
    @enderror

    <div>
        <label for="nt-measured-at" class="nt-label">Tanggal pengukuran</label>
        <input type="date" id="nt-measured-at" name="measured_at" class="nt-input" required
               max="{{ now()->toDateString() }}"
               value="{{ old('measured_at', now()->toDateString()) }}"
               @error('measured_at') aria-invalid="true" aria-describedby="nt-measured-at-error" @enderror>
        @error('measured_at')
            <div id="nt-measured-at-error" class="nt-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label for="nt-weight" class="nt-label">Berat badan (kg)</label>
            <input type="number" id="nt-weight" name="weight_kg" class="nt-input" required inputmode="decimal"
                   step="0.01" min="{{ \App\Services\NutritionAssessmentService::MIN_WEIGHT_KG }}" max="{{ \App\Services\NutritionAssessmentService::MAX_WEIGHT_KG }}"
                   value="{{ old('weight_kg') }}" placeholder="contoh: 54"
                   @error('weight_kg') aria-invalid="true" aria-describedby="nt-weight-error" @enderror>
            @error('weight_kg')
                <div id="nt-weight-error" class="nt-error">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label for="nt-height" class="nt-label">Tinggi badan (cm)</label>
            <input type="number" id="nt-height" name="height_cm" class="nt-input" required inputmode="decimal"
                   step="0.1" min="{{ \App\Services\NutritionAssessmentService::MIN_HEIGHT_CM }}" max="{{ \App\Services\NutritionAssessmentService::MAX_HEIGHT_CM }}"
                   value="{{ old('height_cm') }}" placeholder="contoh: 166"
                   @error('height_cm') aria-invalid="true" aria-describedby="nt-height-error" @enderror>
            @error('height_cm')
                <div id="nt-height-error" class="nt-error">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="nt-hint">Tinggi dalam sentimeter (bukan meter). IMT, Z-score, dan status gizi dihitung otomatis oleh server.</div>

    <button type="submit" class="nt-btn" {{ $ready ? '' : 'disabled' }}>
        <i class="fas fa-calculator" aria-hidden="true"></i>
        <span>Hitung &amp; simpan</span>
    </button>
</form>

@once
<script>
    // Turbo re-runs this on each visit; bind the document listener only once.
    if (!window.__ntLoadingBound) {
        window.__ntLoadingBound = true;
        document.addEventListener('submit', function (e) {
            var form = e.target;
            if (!form.matches('[data-nt-loading]')) return;
            var btn = form.querySelector('button[type="submit"]');
            if (!btn || btn.disabled) return;
            btn.disabled = true;
            btn.setAttribute('aria-busy', 'true');
            var label = btn.querySelector('span');
            if (label) label.textContent = 'Memproses…';
        });
        // Don't let Turbo's back/forward cache restore a stuck "Memproses…" button.
        document.addEventListener('turbo:before-cache', function () {
            document.querySelectorAll('[data-nt-loading] button[aria-busy="true"]').forEach(function (btn) {
                btn.disabled = false;
                btn.removeAttribute('aria-busy');
                var label = btn.querySelector('span');
                if (label) label.textContent = 'Hitung & simpan';
            });
        });
    }
</script>
@endonce
