@extends('layouts.app')

@section('content')
<div class="space-y-12 max-w-5xl mx-auto">
    <div class="text-center space-y-8 mb-16">
        <div class="w-24 h-24 bg-teal-600 rounded-[2.5rem] mx-auto flex items-center justify-center text-white shadow-2xl shadow-teal-100 mb-8 transition-transform hover:scale-110">
            <i class="fas fa-edit text-4xl"></i>
        </div>
        <h1 class="text-4xl sm:text-6xl font-black text-gray-900 leading-tight tracking-tight">Post Test:<br><span class="text-teal-600">{{ $course->title }}</span></h1>
        <div class="flex items-center justify-center gap-10 flex-wrap pt-6">
            <div class="flex items-center gap-4 p-6 bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50">
                <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 border border-teal-100 shadow-inner">
                    <i class="fas fa-question text-xl"></i>
                </div>
                <div class="text-left">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Total Pertanyaan</p>
                    <p class="text-2xl font-black text-gray-900 leading-none">{{ $course->postQuestions->count() }} Soal</p>
                </div>
            </div>
            <div class="flex items-center gap-4 p-6 bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50">
                <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600 border border-orange-100 shadow-inner">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="text-left">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Durasi</p>
                    <p class="text-2xl font-black text-gray-900 leading-none">30 Menit</p>
                </div>
            </div>
            <div class="flex items-center gap-4 p-6 bg-white rounded-3xl border border-gray-100 shadow-xl shadow-gray-200/50">
                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 shadow-inner">
                    <i class="fas fa-user-shield text-xl"></i>
                </div>
                <div class="text-left">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Kesempatan</p>
                    <p class="text-2xl font-black text-gray-900 leading-none">1 Kali</p>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('tests.submit', $course->id) }}" method="POST" class="space-y-10 pb-20">
        @csrf
        @foreach($course->postQuestions as $question)
        <div class="bg-white rounded-[3rem] p-8 sm:p-12 lg:p-16 shadow-2xl shadow-gray-200/50 border border-gray-100 group transition-all hover:border-teal-100">
            <div class="flex items-center gap-6 mb-12">
                <div class="w-16 h-16 rounded-2xl bg-teal-600 flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-teal-100">
                    {{ $loop->iteration }}
                </div>
                <h3 class="text-xl sm:text-2xl font-black text-gray-900 leading-tight">{{ $question->question }}</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach(['A', 'B', 'C', 'D'] as $opt)
                <label class="relative group cursor-pointer transition-all">
                    <input type="radio" name="question_{{ $question->id }}" value="{{ $opt }}" required class="peer hidden">
                    <div class="p-8 bg-gray-50 border-2 border-transparent rounded-[2rem] flex items-center gap-6 transition-all group-hover:bg-white group-hover:border-teal-100 group-hover:shadow-xl peer-checked:bg-teal-600 peer-checked:border-teal-600 peer-checked:shadow-2xl peer-checked:shadow-teal-200 peer-checked:text-white">
                        <div class="w-12 h-12 rounded-2xl bg-white flex items-center justify-center text-teal-600 font-black text-lg shadow-lg shadow-teal-50 peer-checked:bg-teal-500 peer-checked:text-white transition-all">
                            {{ $opt }}
                        </div>
                        <span class="text-lg font-bold flex-1">{{ $question->{'option_' . strtolower($opt)} }}</span>
                        <div class="w-8 h-8 rounded-full border-2 border-gray-200 flex items-center justify-center peer-checked:border-white transition-all">
                            <i class="fas fa-check text-xs opacity-0 peer-checked:opacity-100"></i>
                        </div>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="flex flex-col sm:flex-row items-center justify-center gap-8 pt-10">
            <div class="p-6 bg-orange-50 rounded-3xl border border-orange-100 text-orange-800 text-sm font-bold flex items-center gap-4 shadow-lg shadow-orange-50">
                <i class="fas fa-info-circle text-xl"></i>
                Periksa kembali jawaban Anda sebelum mengirim.
            </div>
            <button type="submit" class="w-full sm:w-auto py-6 px-16 bg-gray-900 hover:bg-black text-white font-black rounded-3xl transition-all shadow-2xl active:scale-95 uppercase tracking-widest text-sm flex items-center justify-center gap-4">
                SELESAIKAN TEST <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </form>
</div>
@endsection
