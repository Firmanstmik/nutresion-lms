@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-bg-main -mx-4 sm:-mx-6 lg:-mx-8 -mt-6 sm:-mt-10">
    <div class="relative overflow-hidden pt-10 sm:pt-14 pb-8 sm:pb-10 px-4 sm:px-6 lg:px-8">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl opacity-60"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-secondary/5 rounded-full blur-3xl opacity-60"></div>

        <div class="relative max-w-3xl mx-auto">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('notifications.index') }}" class="inline-flex items-center gap-3 font-black text-xs uppercase tracking-widest text-primary hover:text-primary-light transition-colors">
                    <span class="w-11 h-11 rounded-2xl bg-white border border-border-subtle shadow-sm flex items-center justify-center">
                        <i class="fas fa-arrow-left text-sm"></i>
                    </span>
                    Kembali
                </a>
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white border border-border-subtle shadow-sm text-[10px] font-black uppercase tracking-widest text-text-secondary">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    Detail Notifikasi
                </div>
            </div>

            <div class="mt-8 bg-white rounded-3xl border border-border-subtle shadow-xl shadow-gray-200/60 overflow-hidden">
                <div class="p-6 sm:p-8">
                    <div class="flex flex-wrap items-center gap-3 text-[11px] font-black uppercase tracking-widest text-text-muted">
                        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-gray-50 border border-border-subtle">
                            <i class="fas fa-clock text-primary text-[11px]"></i>
                            {{ $notification->created_at->diffForHumans() }}
                        </span>
                        <span class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-gray-50 border border-border-subtle">
                            <i class="fas fa-calendar-alt text-primary text-[11px]"></i>
                            {{ $notification->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>

                    <h1 class="mt-5 text-2xl sm:text-3xl font-extrabold tracking-tight text-text-main leading-tight">
                        {{ $notification->title }}
                    </h1>
                    <p class="mt-4 text-sm sm:text-base font-medium text-text-secondary leading-relaxed whitespace-pre-line">
                        {{ $notification->message }}
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        @if($notification->action_url)
                            <a href="{{ $notification->action_url }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-6 py-4 rounded-3xl bg-primary text-white font-black uppercase tracking-widest text-xs shadow-xl shadow-primary/20 active:scale-95 transition">
                                Buka Tautan
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                        <a href="{{ route('notifications.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-6 py-4 rounded-3xl bg-white border border-border-subtle text-text-secondary font-black uppercase tracking-widest text-xs shadow-sm active:scale-95 transition">
                            Kembali ke Notif
                            <i class="fas fa-bell"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

