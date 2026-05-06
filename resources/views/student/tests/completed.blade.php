@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 flex items-center justify-center p-6" style="padding-top: 140px;">
    <div class="max-w-md w-full bg-white rounded-[40px] shadow-2xl shadow-slate-200/60 overflow-hidden border border-slate-100">
        <div class="relative h-48 bg-primary flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white"></path>
                </svg>
            </div>
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-3xl flex items-center justify-center border border-white/30 shadow-inner mb-4">
                    <i class="fas fa-check-circle text-4xl text-white"></i>
                </div>
                <h2 class="text-white font-black text-xl tracking-tight">POST TEST SELESAI</h2>
            </div>
        </div>

        <div class="p-10 text-center">
            <div class="mb-8">
                <h3 class="text-slate-800 font-bold text-2xl mb-3">Wah, Hebat!</h3>
                <p class="text-slate-500 font-medium leading-relaxed">
                    Anda telah menyelesaikan post test untuk materi <span class="text-primary font-bold">"{{ $course->title }}"</span>.
                </p>
            </div>

            <div class="bg-slate-50 rounded-3xl p-6 mb-10 border border-slate-100">
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-1">Skor Kamu</p>
                <div class="text-5xl font-black text-primary">{{ (int)$existing_result->score }}</div>
            </div>

            <div class="flex flex-col gap-3">
                <a href="{{ route('results.show', $existing_result->id) }}" class="w-full inline-flex items-center justify-center gap-3 px-8 py-5 rounded-2xl bg-primary text-white font-black uppercase tracking-widest text-xs shadow-xl shadow-primary/25 active:scale-95 transition-all">
                    Lihat Nilai
                    <i class="fas fa-trophy"></i>
                </a>
                <a href="{{ route('courses.index') }}" class="w-full inline-flex items-center justify-center gap-3 px-8 py-5 rounded-2xl bg-white border-2 border-slate-100 text-slate-500 font-black uppercase tracking-widest text-xs active:scale-95 transition-all">
                    Kembali Belajar
                    <i class="fas fa-book"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
