@extends('layouts.app')

@section('content')
@include('nutrition.partials.styles')

<div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 pb-32 space-y-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <header>
        <div class="nt-tag">Cek Gizi</div>
        <h1 class="mt-1 text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">Status Gizi (IMT/U)</h1>
        <p class="mt-1 text-sm text-slate-600">
            Masukkan berat dan tinggi badan untuk mengetahui Indeks Massa Tubuh (IMT) dan status gizi berdasarkan umur.
            Berlaku untuk usia 14 tahun 0 bulan sampai sebelum 19 tahun.
        </p>
    </header>

    @include('nutrition.partials.disclaimer')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">
        <section class="nt-card" aria-labelledby="nt-profile-title">
            <div class="nt-card-head">
                <div class="nt-tag">Langkah 1</div>
                <h2 id="nt-profile-title" class="nt-title">Data profil</h2>
            </div>
            <div class="nt-body">
                @if($student->hasNutritionProfile())
                    <p class="text-sm text-slate-700 mb-4">
                        Lahir {{ $student->birth_date->locale('id')->translatedFormat('d M Y') }}
                        · {{ \App\Services\NutritionAssessmentService::SEX_LABELS[$student->sex] }}.
                        Ubah jika data belum benar.
                    </p>
                @endif
                @include('nutrition.partials.profile-form', ['action' => route('nutrition.profile')])
            </div>
        </section>

        <section class="nt-card" aria-labelledby="nt-measure-title">
            <div class="nt-card-head">
                <div class="nt-tag">Langkah 2</div>
                <h2 id="nt-measure-title" class="nt-title">Pengukuran baru</h2>
            </div>
            <div class="nt-body">
                @include('nutrition.partials.measurement-form', ['action' => route('nutrition.store')])
            </div>
        </section>
    </div>

    @if($latest = $measurements->first())
        <section class="nt-card" aria-labelledby="nt-latest-title">
            <div class="nt-card-head">
                <div class="nt-tag">Hasil terbaru</div>
                <h2 id="nt-latest-title" class="nt-title">Status gizi terakhir</h2>
            </div>
            <div class="nt-body">
                @include('nutrition.partials.result-card', ['measurement' => $latest])
            </div>
        </section>
    @endif

    <section class="nt-card" aria-labelledby="nt-history-title">
        <div class="nt-card-head">
            <div class="nt-tag">Riwayat</div>
            <h2 id="nt-history-title" class="nt-title">Riwayat pengukuran</h2>
        </div>
        @include('nutrition.partials.history-table', ['linkToDetail' => true])
    </section>
</div>
@endsection
