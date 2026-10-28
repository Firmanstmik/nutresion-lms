@extends('layouts.app')

@section('content')
@include('nutrition.partials.styles')

<div class="max-w-3xl mx-auto px-4 sm:px-6 py-6 pb-32 space-y-5" style="font-family: 'Plus Jakarta Sans', sans-serif;">
    <div class="text-xs font-semibold tracking-widest text-slate-500 uppercase">
        <a href="{{ route('nutrition.index') }}" class="hover:text-slate-900">Status gizi</a>
        <span class="mx-1 text-slate-300">/</span>
        <span class="text-slate-900">Hasil</span>
    </div>

    <section class="nt-card" aria-labelledby="nt-result-title">
        <div class="nt-card-head">
            <div class="nt-tag">Hasil penilaian IMT/U</div>
            <h1 id="nt-result-title" class="nt-title">{{ $measurement->user->name }}</h1>
        </div>
        <div class="nt-body">
            @include('nutrition.partials.result-card')
        </div>
    </section>

    @include('nutrition.partials.disclaimer')

    <p class="text-xs text-slate-500">
        Referensi: {{ $measurement->reference_version }}. Kategori ditentukan dari nilai Z-score sebelum dibulatkan;
        angka di atas dibulatkan hanya untuk tampilan.
    </p>

    <a href="{{ route('nutrition.index') }}" class="nt-btn nt-btn-ghost">
        <i class="fas fa-arrow-left" aria-hidden="true"></i> Kembali ke riwayat
    </a>
</div>
@endsection
