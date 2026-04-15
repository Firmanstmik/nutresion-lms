@extends('layouts.app')

@section('content')
<div class="space-y-12 max-w-4xl mx-auto py-12">
    <div class="bg-white rounded-[4rem] p-12 sm:p-24 text-center shadow-2xl shadow-gray-200 border border-gray-100 relative overflow-hidden group">
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

            <div class="p-10 bg-gray-50 rounded-[3.5rem] border border-gray-100 shadow-inner flex flex-col items-center justify-center gap-6 relative group/score overflow-hidden">
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
