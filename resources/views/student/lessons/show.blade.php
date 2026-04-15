@extends('layouts.app')

@section('content')
@php
    $lessonTotalCount = $lesson->course->lessons->count();
    $lessonPct = $lessonTotalCount > 0 ? ($lesson->order_number / $lessonTotalCount) * 100 : 0;
    $lessonPct = max(0, min(100, $lessonPct));
@endphp

<div class="min-h-screen -mx-4 sm:-mx-6 lg:-mx-8 -mt-6 sm:-mt-10 bg-bg-main">
    <div class="relative overflow-hidden pt-10 sm:pt-14 pb-8 sm:pb-10 px-4 sm:px-6 lg:px-8">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-secondary/5 rounded-full blur-3xl opacity-60"></div>

        <div class="relative max-w-5xl mx-auto">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-5">
                <a href="{{ route('courses.detail', $lesson->course_id) }}" class="inline-flex items-center gap-3 font-black text-xs uppercase tracking-widest text-primary hover:text-primary-light transition-colors">
                    <span class="w-11 h-11 rounded-2xl bg-white border border-border-subtle shadow-sm flex items-center justify-center">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </span>
                    Kembali ke Detail
                </a>

                <div class="flex items-center gap-4">
                    <div class="hidden sm:flex items-center gap-2 text-[10px] font-black text-text-muted uppercase tracking-widest">
                        <span>Bab {{ $lesson->order_number }}</span>
                        <span class="opacity-40">/</span>
                        <span>{{ $lessonTotalCount }}</span>
                    </div>
                    <div class="w-44 sm:w-56 h-2 rounded-full bg-white border border-border-subtle overflow-hidden">
                        <div class="h-full bg-primary transition-all duration-700" @style(['width' => $lessonPct . '%'])></div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white border border-border-subtle shadow-sm text-[10px] font-black uppercase tracking-widest text-text-secondary">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    Materi Pembelajaran
                </div>
                <h1 class="mt-4 text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight text-text-main">
                    {{ $lesson->title }}
                </h1>
                <div class="mt-3 flex flex-wrap items-center gap-3 text-xs font-bold text-text-muted">
                    <span class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-white border border-border-subtle">
                        <i class="fas fa-calendar-alt text-primary text-[11px]"></i>
                        Diupdate 22 Maret 2026
                    </span>
                    <span class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-white border border-border-subtle">
                        <i class="fas fa-user-tie text-primary text-[11px]"></i>
                        Oleh Dr. Sarah Smith
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        <div class="card-premium overflow-hidden">
            <div class="aspect-video bg-black relative overflow-hidden">
                @if($lesson->video_url)
                    <iframe class="w-full h-full" src="{{ str_replace('watch?v=', 'embed/', $lesson->video_url) }}" frameborder="0" allowfullscreen></iframe>
                @else
                    <img src="{{ $lesson->course->thumbnail ? asset('storage/' . $lesson->course->thumbnail) : route('brand.hero') }}"
                         class="w-full h-full object-cover" alt="{{ $lesson->title }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                    <div class="absolute top-6 left-6">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 shadow-lg text-[10px] font-black uppercase tracking-widest text-gray-900">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Bab {{ $lesson->order_number }}
                        </span>
                    </div>
                @endif
            </div>

            <div class="p-7 sm:p-10 lg:p-12">
                @php
                    $lessonContent = $lesson->content ?? '';
                    $hasHtml = \Illuminate\Support\Str::contains($lessonContent, ['<img', '<p', '<br', '<div', '<h', '<ul', '<ol', '<table']);
                @endphp
                <div class="text-text-secondary text-sm sm:text-base leading-relaxed font-medium space-y-6 nrl-lesson-content">
                    {!! $hasHtml ? $lessonContent : nl2br(e($lessonContent)) !!}
                </div>

                <div class="mt-10 pt-8 border-t border-border-soft flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4 p-5 rounded-2xl bg-primary-soft/40 border border-border-subtle w-full sm:w-auto">
                        <div class="w-12 h-12 rounded-2xl bg-primary flex items-center justify-center text-white shadow-sm">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <p class="text-sm font-extrabold text-text-main leading-tight">Pastikan Anda telah membaca<br>seluruh materi dengan teliti.</p>
                    </div>

                    @if(!$is_completed)
                    <form action="{{ route('lessons.complete', $lesson->id) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="btn-primary w-full py-4 px-10 text-sm uppercase tracking-widest font-extrabold flex items-center justify-center gap-3">
                            Tandai Selesai <i class="fas fa-check-circle text-xs"></i>
                        </button>
                    </form>
                    @else
                    <div class="flex items-center gap-3 px-8 py-4 bg-green-50 text-green-700 font-extrabold rounded-2xl border border-green-100 shadow-inner w-full sm:w-auto justify-center">
                        <i class="fas fa-check-double text-lg"></i>
                        <span class="uppercase tracking-widest text-xs">Materi Selesai</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.nrl-lesson-content br { display: block; content: ""; margin-top: 0.85rem; }
.nrl-lesson-content img { max-width: 100%; height: auto; border-radius: 18px; }
</style>
@endsection
