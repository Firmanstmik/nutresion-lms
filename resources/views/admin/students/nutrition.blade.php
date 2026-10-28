@extends('layouts.app')

@section('content')
@include('nutrition.partials.styles')

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-5">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="min-w-0">
            <div class="text-xs font-semibold tracking-widest text-gray-500 uppercase">
                <a href="{{ route('admin.students.index') }}" class="hover:text-gray-900">Siswa</a>
                <span class="mx-1 text-gray-300">/</span>
                <span class="text-gray-900">Status Gizi</span>
            </div>
            <h1 class="mt-2 text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">
                Status Gizi: {{ $student->name }}
            </h1>
            <div class="mt-1 text-sm text-gray-600">
                NISN/Username: <span class="font-semibold text-gray-900">{{ $student->username }}</span>
                <span class="mx-2 text-gray-300">·</span>
                Sekolah: <span class="font-semibold text-gray-900">{{ $student->school->name ?? 'Belum Ditetapkan' }}</span>
            </div>
        </div>
        <a href="{{ route('admin.students.activity', $student->id) }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-sm border border-gray-200 bg-white text-gray-800 text-xs font-extrabold tracking-widest uppercase hover:bg-gray-50">
            <i class="fas fa-chart-line" aria-hidden="true"></i>
            Aktivitas Belajar
        </a>
    </div>

    @include('nutrition.partials.disclaimer')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 items-start">
        <section class="nt-card" aria-labelledby="nt-profile-title">
            <div class="nt-card-head">
                <div class="nt-tag">Data profil</div>
                <h2 id="nt-profile-title" class="nt-title">Tanggal lahir &amp; jenis kelamin</h2>
            </div>
            <div class="nt-body">
                @include('nutrition.partials.profile-form', ['action' => route('admin.students.nutrition.profile', $student->id)])
            </div>
        </section>

        <section class="nt-card" aria-labelledby="nt-measure-title">
            <div class="nt-card-head">
                <div class="nt-tag">Input admin</div>
                <h2 id="nt-measure-title" class="nt-title">Pengukuran baru</h2>
            </div>
            <div class="nt-body">
                @include('nutrition.partials.measurement-form', ['action' => route('admin.students.nutrition.store', $student->id)])
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
            <h2 id="nt-history-title" class="nt-title">Riwayat pengukuran ({{ $measurements->count() }})</h2>
        </div>
        @include('nutrition.partials.history-table', ['linkToDetail' => false, 'showRecorder' => true])
    </section>
</div>
@endsection
