{{-- Expects: $action (url), $student (User) --}}
<form action="{{ $action }}" method="POST" class="space-y-4" data-nt-loading>
    @csrf
    <div>
        <label for="nt-birth-date" class="nt-label">Tanggal lahir</label>
        <input type="date" id="nt-birth-date" name="birth_date" class="nt-input" required
               max="{{ now()->subDay()->toDateString() }}"
               value="{{ old('birth_date', $student->birth_date?->toDateString()) }}"
               @error('birth_date') aria-invalid="true" aria-describedby="nt-birth-date-error" @enderror>
        @error('birth_date')
            <div id="nt-birth-date-error" class="nt-error">{{ $message }}</div>
        @enderror
    </div>

    <fieldset>
        <legend class="nt-label">Jenis kelamin</legend>
        @php $sexValue = old('sex', $student->sex); @endphp
        <div class="flex flex-wrap gap-2">
            @foreach(\App\Services\NutritionAssessmentService::SEX_LABELS as $value => $label)
                <label class="nt-radio">
                    <input type="radio" name="sex" value="{{ $value }}" required {{ $sexValue === $value ? 'checked' : '' }}>
                    {{ $label }}
                </label>
            @endforeach
        </div>
        <div class="nt-hint">Dipakai untuk memilih tabel referensi WHO yang sesuai.</div>
        @error('sex')
            <div class="nt-error">{{ $message }}</div>
        @enderror
    </fieldset>

    <button type="submit" class="nt-btn">
        <i class="fas fa-save" aria-hidden="true"></i>
        <span>Simpan data profil</span>
    </button>
</form>
