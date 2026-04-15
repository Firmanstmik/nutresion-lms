@extends('layouts.app')

@section('content')
<div class="space-y-10 max-w-5xl mx-auto py-8 sm:py-12 px-4 sm:px-6">
    <div class="bg-white rounded-[3rem] sm:rounded-[4rem] p-10 sm:p-20 text-center shadow-2xl shadow-gray-200 border border-gray-100 relative overflow-hidden group">
        <div class="absolute -top-10 -left-10 w-48 h-48 bg-teal-50 rounded-full blur-3xl opacity-50 transition-all group-hover:scale-150"></div>
        <div class="absolute -bottom-10 -right-10 w-48 h-48 bg-blue-50 rounded-full blur-3xl opacity-50 transition-all group-hover:scale-150"></div>
        
        <div class="relative z-10 space-y-10">
            <div class="w-32 h-32 {{ $result->score >= 70 ? 'bg-teal-600 shadow-teal-200' : 'bg-red-500 shadow-red-200' }} rounded-[3rem] mx-auto flex items-center justify-center text-white shadow-2xl mb-12 transition-transform hover:scale-110">
                <i class="fas {{ $result->type === 'pre' ? 'fa-clipboard-list' : ($result->score >= 70 ? 'fa-trophy' : 'fa-exclamation-triangle') }} text-5xl"></i>
            </div>
            
            <div class="space-y-4">
                <h2 class="text-xs font-black text-gray-400 uppercase tracking-widest leading-relaxed">Hasil {{ $result->type === 'pre' ? 'Pre Test' : 'Post Test' }}</h2>
                <h1 class="text-4xl sm:text-6xl font-black text-gray-900 leading-tight tracking-tight">{{ $result->course->title }}</h1>
            </div>

            <div class="p-8 sm:p-10 bg-gray-50 rounded-[2.5rem] sm:rounded-[3.5rem] border border-gray-100 shadow-inner flex flex-col items-center justify-center gap-6 relative group/score overflow-hidden">
                <div class="absolute inset-0 bg-white/50 backdrop-blur-xl opacity-0 group-hover/score:opacity-100 transition-all"></div>
                <div class="relative z-10 flex flex-col items-center">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Skor Akhir Anda</p>
                    <p class="text-[8rem] sm:text-[12rem] font-black {{ $result->score >= 70 ? 'text-teal-600' : 'text-red-500' }} leading-none tracking-tighter drop-shadow-2xl transition-all group-hover/score:scale-110">{{ $result->score }}</p>
                    <p class="text-sm font-black text-gray-400 mt-6">Dari 100 Poin</p>
                </div>
            </div>

            <div class="space-y-8">
                @if($result->score >= 70)
                <div class="p-8 bg-teal-50 rounded-3xl border border-teal-100 flex items-center justify-center gap-6 shadow-xl shadow-teal-50 transition-all hover:scale-105">
                    <div class="w-14 h-14 rounded-2xl bg-teal-600 flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <div class="text-left">
                        <h3 class="text-xl font-black text-teal-900 leading-tight">Selamat! Anda Lulus</h3>
                        <p class="text-sm font-bold text-teal-600">Sertifikat pelatihan akan segera dikirimkan ke email Anda.</p>
                    </div>
                </div>
                @else
                <div class="p-8 bg-red-50 rounded-3xl border border-red-100 flex items-center justify-center gap-6 shadow-xl shadow-red-50 transition-all hover:scale-105">
                    <div class="w-14 h-14 rounded-2xl bg-red-500 flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-redo-alt"></i>
                    </div>
                    <div class="text-left">
                        <h3 class="text-xl font-black text-red-900 leading-tight">Belum Lulus</h3>
                        <p class="text-sm font-bold text-red-600">Pelajari kembali materi dan coba lagi di pelatihan berikutnya.</p>
                    </div>
                </div>
                @endif
            </div>

            @php
                $answers = $result->answers ?? collect();
                $hasDetail = $answers->count() > 0;
                $correctCount = $hasDetail ? $answers->where('is_correct', true)->count() : 0;
                $answeredCount = $hasDetail ? $answers->whereNotNull('selected_answer')->count() : 0;
                $unansweredCount = $hasDetail ? ($answers->count() - $answeredCount) : 0;
            @endphp

            <div class="space-y-6">
                <div class="bg-white/60 border border-gray-100 rounded-[2.5rem] p-6 sm:p-8 text-left shadow-xl shadow-gray-200/40">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Rincian Jawaban</h3>
                    <p class="mt-2 text-sm font-bold text-gray-600 leading-relaxed">
                        @if($hasDetail)
                            Benar: <span class="text-emerald-700 font-extrabold">{{ $correctCount }}</span>
                            <span class="mx-2 text-gray-300">·</span>
                            Terjawab: <span class="text-gray-900 font-extrabold">{{ $answeredCount }}</span>
                            <span class="mx-2 text-gray-300">·</span>
                            Kosong: <span class="text-gray-900 font-extrabold">{{ $unansweredCount }}</span>
                        @else
                            Detail jawaban belum tersedia untuk hasil ini.
                        @endif
                    </p>
                    @if($hasDetail)
                        <div class="mt-5 grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <div class="rounded-3xl border border-emerald-100 bg-emerald-50 px-5 py-4">
                                <div class="text-[10px] font-black uppercase tracking-widest text-emerald-700">Benar</div>
                                <div class="mt-1 text-2xl font-black text-emerald-900">{{ $correctCount }}</div>
                            </div>
                            <div class="rounded-3xl border border-red-100 bg-red-50 px-5 py-4">
                                <div class="text-[10px] font-black uppercase tracking-widest text-red-700">Salah</div>
                                <div class="mt-1 text-2xl font-black text-red-900">{{ max(0, $answers->count() - $correctCount - $unansweredCount) }}</div>
                            </div>
                            <div class="rounded-3xl border border-gray-100 bg-gray-50 px-5 py-4">
                                <div class="text-[10px] font-black uppercase tracking-widest text-gray-600">Kosong</div>
                                <div class="mt-1 text-2xl font-black text-gray-900">{{ $unansweredCount }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                @if($hasDetail)
                    <div class="space-y-4">
                        @foreach($answers as $idx => $answer)
                            @php
                                $q = $answer->question;
                                $selected = $answer->selected_answer;
                                $correct = $q?->correct_answer;
                                $isCorrect = (bool) $answer->is_correct;
                            @endphp

                            <div class="bg-white rounded-[2.5rem] border border-gray-100 shadow-xl shadow-gray-200/60 overflow-hidden">
                                <div class="p-6 sm:p-8 flex flex-col gap-5">
                                    <div class="flex items-start gap-4">
                                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-black shadow-lg {{ $isCorrect ? 'bg-emerald-600 shadow-emerald-100' : 'bg-red-500 shadow-red-100' }}">
                                            {{ $idx + 1 }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="text-base sm:text-lg font-extrabold text-gray-900 leading-snug">
                                                {{ $q?->question ?? 'Soal tidak ditemukan' }}
                                            </div>
                                            <div class="mt-3 flex flex-wrap items-center gap-2 text-[11px] font-black uppercase tracking-widest">
                                                <span class="px-3 py-2 rounded-2xl border {{ $isCorrect ? 'bg-emerald-50 border-emerald-100 text-emerald-700' : 'bg-red-50 border-red-100 text-red-700' }}">
                                                    {{ $isCorrect ? 'Benar' : 'Salah' }}
                                                </span>
                                                <span class="px-3 py-2 rounded-2xl bg-gray-50 border border-gray-100 text-gray-600">
                                                    Jawaban: <span class="text-gray-900">{{ $selected ?? '—' }}</span>
                                                </span>
                                                <span class="px-3 py-2 rounded-2xl bg-gray-50 border border-gray-100 text-gray-600">
                                                    Kunci: <span class="text-gray-900">{{ $correct ?? '—' }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    @if($q)
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                            @foreach(['A','B','C','D'] as $opt)
                                                @php
                                                    $optText = $q->{'option_' . strtolower($opt)};
                                                    $isKey = $correct === $opt;
                                                    $isPick = $selected === $opt;
                                                    $border = 'border-gray-100';
                                                    $bg = 'bg-gray-50';
                                                    $text = 'text-gray-700';

                                                    if ($isKey) {
                                                        $border = 'border-emerald-200';
                                                        $bg = 'bg-emerald-50';
                                                        $text = 'text-emerald-900';
                                                    } elseif ($isPick) {
                                                        $border = 'border-red-200';
                                                        $bg = 'bg-red-50';
                                                        $text = 'text-red-900';
                                                    }
                                                @endphp
                                                <div class="p-4 rounded-2xl border {{ $border }} {{ $bg }}">
                                                    <div class="flex items-start gap-3">
                                                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center font-black {{ $isKey ? 'bg-emerald-600 text-white' : ($isPick ? 'bg-red-500 text-white' : 'bg-white text-gray-900 border border-gray-200') }}">
                                                            {{ $opt }}
                                                        </div>
                                                        <div class="text-sm font-bold leading-relaxed {{ $text }}">
                                                            {{ $optText }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-6 pt-10">
                <a href="{{ route('dashboard') }}" class="w-full sm:w-auto py-5 px-12 bg-gray-900 hover:bg-black text-white font-black rounded-3xl transition-all shadow-2xl active:scale-95 uppercase tracking-widest text-xs flex items-center justify-center gap-4">
                    KEMBALI KE DASHBOARD <i class="fas fa-home"></i>
                </a>
                <a href="{{ route('courses.index') }}" class="w-full sm:w-auto py-5 px-12 bg-white border-2 border-gray-100 hover:border-teal-500 hover:text-teal-600 text-gray-500 font-black rounded-3xl transition-all shadow-xl active:scale-95 uppercase tracking-widest text-xs flex items-center justify-center gap-4">
                    BELAJAR LAGI <i class="fas fa-book-open"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
