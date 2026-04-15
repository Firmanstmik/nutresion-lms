@extends('layouts.app')

@section('content')

<div class="nrd-root">

    {{-- ═══════════════════════════════════════════════════════════════
         HERO BAND
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="nrd-hero">

        {{-- BG layers --}}
        <div class="nrd-hero-grid" aria-hidden="true"></div>
        <div class="nrd-hero-blob nrd-blob-1" aria-hidden="true"></div>
        <div class="nrd-hero-blob nrd-blob-2" aria-hidden="true"></div>
        <div class="nrd-hero-photo" aria-hidden="true">
            <img src="{{ route('brand.hero-admin') }}" alt="" class="nrd-hero-photo-img">
        </div>

        <div class="nrd-hero-inner">

            {{-- Left column --}}
            <div class="nrd-hero-left">

                {{-- Badges --}}
                <div class="nrd-hero-badges">
                    <span class="nrd-badge-pill nrd-pill-glass">
                        <i class="fas fa-tag"></i>
                        Kategori: Gizi
                    </span>
                    <span class="nrd-badge-pill nrd-pill-gold">
                        <i class="fas fa-unlock-alt"></i>
                        Akses Gratis
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="nrd-hero-title">{{ $course->title }}</h1>

                {{-- Description --}}
                <p class="nrd-hero-desc">
                    {{ $course->description ?: 'Pelajari materi gizi dan kesehatan dengan pendekatan praktis untuk hasil yang optimal.' }}
                </p>

                {{-- Social proof --}}
                <div class="nrd-social-proof">
                    <div class="nrd-avatars">
                        <img src="https://i.pravatar.cc/100?u=1" class="nrd-avatar" alt="">
                        <img src="https://i.pravatar.cc/100?u=2" class="nrd-avatar" alt="">
                        <img src="https://i.pravatar.cc/100?u=3" class="nrd-avatar" alt="">
                        <div class="nrd-avatar nrd-avatar-count">+1.2k</div>
                    </div>
                    <span class="nrd-proof-text">Bergabung dengan 1,200+ siswa lainnya</span>
                </div>

            </div>

            {{-- Right column — thumbnail (desktop only) --}}
            <div class="nrd-hero-right">
                <div class="nrd-thumb-card">
                    <img
                        src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=2070&auto=format&fit=crop' }}"
                        class="nrd-thumb-img"
                        alt="{{ $course->title }}"
                    >
                    <div class="nrd-thumb-overlay"></div>
                    <div class="nrd-play-btn" aria-hidden="true">
                        <i class="fas fa-play"></i>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         MAIN GRID
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="nrd-layout">

        {{-- ─── LEFT / MAIN ─────────────────────────────────────────── --}}
        <div class="nrd-col-main">

            {{-- Tab Strip --}}
            <div class="nrd-tabs">
                <button class="nrd-tab nrd-tab-active">
                    <i class="fas fa-list-ul"></i>
                    Kurikulum
                </button>
                <button class="nrd-tab">
                    <i class="fas fa-info-circle"></i>
                    Tentang Materi
                </button>
                <button class="nrd-tab">
                    <i class="fas fa-users"></i>
                    Siswa (1.2k)
                </button>
            </div>

            {{-- ─ Section header --}}
            <div class="nrd-section-head">
                <div class="nrd-section-tag">
                    <span class="nrd-tag-dot"></span>
                    DAFTAR BAB
                </div>
                <h2 class="nrd-section-title">
                    Kurikulum <span class="nrd-em">Pembelajaran</span>
                </h2>
                <p class="nrd-section-sub">
                    {{ $course->lessons->count() }} bab tersedia
                    @if($has_pre_test && !$pre_test_done)
                        · <span style="color:#F59E0B;font-weight:700;"><i class="fas fa-lock" style="font-size:0.58rem;"></i> Selesaikan Pre Test untuk membuka bab</span>
                    @else
                        · Selesaikan semua untuk membuka Post Test
                    @endif
                </p>
            </div>

            {{-- ─ Lesson List --}}
            <div class="nrd-lesson-list">
                @foreach($course->lessons as $lesson)
                    @php $is_completed = isset($progress[$lesson->id]) && $progress[$lesson->id]; @endphp

                    <div class="nrd-lesson-row {{ $is_completed ? 'nrd-row-done' : '' }} {{ ($has_pre_test && !$pre_test_done) ? 'nrd-row-locked' : '' }}">

                        {{-- Number badge --}}
                        <div class="nrd-lesson-num {{ $is_completed ? 'nrd-num-done' : '' }} {{ ($has_pre_test && !$pre_test_done) ? 'nrd-num-locked' : '' }}">
                            @if($is_completed)
                                <i class="fas fa-check"></i>
                            @elseif($has_pre_test && !$pre_test_done)
                                <i class="fas fa-lock"></i>
                            @else
                                <span>{{ $loop->iteration }}</span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="nrd-lesson-info">
                            <p class="nrd-lesson-eyebrow">Bab {{ $loop->iteration }}</p>
                            <h4 class="nrd-lesson-title">{{ $lesson->title }}</h4>
                            <div class="nrd-lesson-meta">
                                <span><i class="far fa-clock"></i> 15:00 Menit</span>
                                <span><i class="far fa-file-alt"></i> Materi Belajar</span>
                                @if($has_pre_test && !$pre_test_done)
                                    <span class="nrd-lock-hint"><i class="fas fa-lock"></i> Kerjakan Pre Test dulu</span>
                                @endif
                            </div>
                        </div>

                        {{-- Action --}}
                        @if($is_completed)
                            <div class="nrd-done-badge">
                                <i class="fas fa-check-circle"></i>
                                <span>Selesai</span>
                            </div>
                        @elseif($has_pre_test && !$pre_test_done)
                            <a href="{{ route('tests.pre.index', $lesson->course_id) }}" class="nrd-lock-btn" title="Kerjakan Pre Test terlebih dahulu">
                                <i class="fas fa-lock"></i>
                            </a>
                        @else
                            <a href="{{ route('lessons.show', $lesson->id) }}" class="nrd-play-row-btn">
                                <i class="fas fa-play"></i>
                            </a>
                        @endif

                    </div>
                @endforeach
            </div>

        </div>

        {{-- ─── RIGHT / SIDEBAR ──────────────────────────────────────── --}}
        <div class="nrd-col-side">
            <div class="nrd-sidebar">

                {{-- Progress Block --}}
                <div class="nrd-progress-block">
                    <div class="nrd-progress-tag">
                        <span class="nrd-tag-dot nrd-dot-gold"></span>
                        PROGRESS BELAJARMU
                    </div>

                    @php
                        $progressPercent = $course->lessons->count() > 0
                            ? (count($progress) / $course->lessons->count()) * 100
                            : 0;
                    @endphp

                    <div class="nrd-progress-header">
                        <h4 class="nrd-progress-label">Capaian Materi</h4>
                        <span class="nrd-progress-pct {{ $progressPercent >= 100 ? 'nrd-pct-done' : '' }}">
                            {{ $course->lessons->count() > 0 ? round($progressPercent) : 0 }}%
                        </span>
                    </div>

                    {{-- Ring + bar --}}
                    <div class="nrd-ring-row">
                        <div class="nrd-ring-wrap">
                            <svg viewBox="0 0 44 44" class="nrd-ring-svg">
                                <circle cx="22" cy="22" r="19" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="3.5"/>
                                <circle cx="22" cy="22" r="19" fill="none"
                                    stroke="{{ $progressPercent >= 100 ? '#F6D860' : '#4ADE80' }}"
                                    stroke-width="3.5"
                                    stroke-dasharray="{{ $progressPercent }} {{ 100 - $progressPercent }}"
                                    stroke-dashoffset="30"
                                    stroke-linecap="round"/>
                            </svg>
                            <span class="nrd-ring-inner-pct">{{ round($progressPercent) }}%</span>
                        </div>
                        <div class="nrd-progress-detail">
                            <div class="nrd-progress-track">
                                <div class="nrd-progress-fill {{ $progressPercent >= 100 ? 'nrd-fill-gold' : '' }}"
                                     @style(['width' => $progressPercent . '%'])></div>
                            </div>
                            <p class="nrd-progress-sub">
                                <strong>{{ count($progress) }}</strong> dari <strong>{{ $course->lessons->count() }}</strong> bab selesai
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="nrd-sidebar-divider"></div>

                {{-- Pre Test Block --}}
                @if($has_pre_test)
                    @if($pre_test_done)
                        <div class="nrd-test-block">
                            <div class="nrd-test-head">
                                <div class="nrd-test-icon" style="background:rgba(74,222,128,0.12);border-color:rgba(74,222,128,0.3);color:#4ADE80;">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <p class="nrd-test-eyebrow" style="color:#4ADE80;">PRE TEST SELESAI</p>
                                    <p class="nrd-test-sub">Kamu sudah mengerjakan pre test</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="nrd-test-block nrd-pretest-alert">
                            <div class="nrd-test-head">
                                <div class="nrd-test-icon" style="background:rgba(245,158,11,0.15);border-color:rgba(245,158,11,0.35);color:#FCD34D;">
                                    <i class="fas fa-clipboard-list"></i>
                                </div>
                                <div>
                                    <p class="nrd-test-eyebrow" style="color:#FCD34D;">PRE TEST DIPERLUKAN</p>
                                    <p class="nrd-test-sub">Wajib dikerjakan sebelum belajar</p>
                                </div>
                            </div>
                            <p class="nrd-test-desc">
                                Sebelum mengakses materi, kamu harus menyelesaikan Pre Test terlebih dahulu.
                            </p>
                            <a href="{{ route('tests.pre.index', $course->id) }}" class="nrd-test-btn" style="background:linear-gradient(135deg,#D97706,#F59E0B);color:#fff;box-shadow:0 4px 16px rgba(217,119,6,0.4);">
                                <i class="fas fa-clipboard-list"></i>
                                MULAI PRE TEST
                            </a>
                        </div>
                    @endif
                    {{-- Divider --}}
                    <div class="nrd-sidebar-divider"></div>
                @endif

                {{-- Post Test Block --}}
                @if($has_post_test)
                    @if($all_completed)
                        <div class="nrd-test-block nrd-test-open">
                            <div class="nrd-test-head">
                                <div class="nrd-test-icon nrd-icon-gold">
                                    <i class="fas fa-trophy"></i>
                                </div>
                                <div>
                                    <p class="nrd-test-eyebrow nrd-eyebrow-gold">POST TEST TERBUKA!</p>
                                    <p class="nrd-test-sub">Semua bab selesai — ambil test sekarang</p>
                                </div>
                            </div>
                            <p class="nrd-test-desc">
                                Selamat! Kamu telah menyelesaikan semua materi. Ambil test sekarang untuk mendapatkan sertifikat.
                            </p>
                            <a href="{{ route('tests.index', $course->id) }}" class="nrd-test-btn nrd-btn-active">
                                <i class="fas fa-rocket"></i>
                                MULAI POST TEST
                            </a>
                        </div>
                    @else
                        <div class="nrd-test-block nrd-test-locked">
                            <div class="nrd-test-head">
                                <div class="nrd-test-icon nrd-icon-muted">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <div>
                                    <p class="nrd-test-eyebrow nrd-eyebrow-muted">POST TEST TERKUNCI</p>
                                    <p class="nrd-test-sub">Selesaikan semua bab terlebih dahulu</p>
                                </div>
                            </div>
                            <p class="nrd-test-desc">
                                Selesaikan seluruh bab pembelajaran untuk membuka akses ke Post Test dan mendapatkan nilai.
                            </p>
                            <button disabled class="nrd-test-btn nrd-btn-disabled">
                                <i class="fas fa-lock"></i>
                                AMBIL TEST
                            </button>
                        </div>
                    @endif

                    {{-- Divider --}}
                    <div class="nrd-sidebar-divider"></div>
                @endif

                {{-- Share --}}
                <div class="nrd-share-row">
                    <span class="nrd-share-label">Bagikan materi</span>
                    <div class="nrd-share-icons">
                        <a href="#" class="nrd-share-btn" aria-label="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="#" class="nrd-share-btn" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="nrd-share-btn" aria-label="Salin Link">
                            <i class="fas fa-link"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>{{-- end nrd-layout --}}

</div>{{-- end nrd-root --}}


{{-- ═══════════════════════════════════════════════════════════════
     STYLES
═══════════════════════════════════════════════════════════════ --}}
<style>
:root {
    --nrd-green:     #0D5C34;
    --nrd-green-mid: #187945;
    --nrd-green-lt:  #1E9152;
    --nrd-green-vlt: #4ADE80;
    --nrd-gold:      #C9A84C;
    --nrd-gold-lt:   #F6D860;
    --nrd-ink:       #0F1A12;
    --nrd-muted:     #6B7280;
    --nrd-border:    #E5E7EB;
    --nrd-surface:   #F7FAF8;
    --nrd-white:     #FFFFFF;
    --nrd-shadow:    0 4px 16px rgba(13,92,52,0.08), 0 2px 6px rgba(0,0,0,0.04);
    --nrd-shadow-lg: 0 20px 48px rgba(13,92,52,0.13), 0 8px 20px rgba(0,0,0,0.05);
}

/* ── Root ─────────────────────────────────────────── */
.nrd-root {
    display: flex;
    flex-direction: column;
    gap: 0;
    padding-bottom: 5rem;
    overflow-x: hidden;
    width: 100%;
    max-width: 100%;
}
.nrd-root * { box-sizing: border-box; }

/* ════════════════════════════════════════════════════
   HERO
════════════════════════════════════════════════════ */
.nrd-hero {
    position: relative;
    background: var(--nrd-green);
    border-radius: 24px;
    overflow: hidden;
    padding: 2.5rem 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 20px 60px rgba(13,92,52,0.28);
}
@media (min-width: 640px)  { .nrd-hero { padding: 3.5rem 2.5rem; } }
@media (min-width: 1024px) { .nrd-hero { padding: 4rem 3.5rem; border-radius: 28px; } }

.nrd-hero-grid {
    position: absolute; inset: 0;
    z-index: 1;
    background-image:
        linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
    background-size: 52px 52px;
    pointer-events: none;
}
.nrd-hero-blob {
    position: absolute; border-radius: 50%;
    filter: blur(90px); pointer-events: none;
    z-index: 1;
}
.nrd-blob-1 { width: 440px; height: 440px; background: rgba(74,222,128,0.09); top: -140px; right: -80px; }
.nrd-blob-2 { width: 280px; height: 280px; background: rgba(201,168,76,0.08); bottom: -60px; left: -40px; }

.nrd-hero-photo {
    position: absolute;
    inset: 0;
    z-index: 0;
    pointer-events: none;
    opacity: 0.16;
}
.nrd-hero-photo::after {
    content: '';
    position: absolute;
    inset: 0;
    background:
        linear-gradient(90deg, rgba(13,92,52,0.92) 0%, rgba(13,92,52,0.55) 55%, rgba(13,92,52,0.35) 100%),
        radial-gradient(70% 60% at 12% 10%, rgba(74,222,128,0.22), rgba(74,222,128,0) 55%);
}
.nrd-hero-photo-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    filter: saturate(1.05) contrast(1.03);
    transform: scale(1.02);
}

.nrd-hero-inner {
    position: relative; z-index: 2;
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    align-items: center;
}
@media (min-width: 1024px) { .nrd-hero-inner { grid-template-columns: 1fr 420px; gap: 3.5rem; } }

/* Hero left */
.nrd-hero-left { display: flex; flex-direction: column; gap: 1.1rem; }

.nrd-hero-badges { display: flex; flex-wrap: wrap; gap: 0.55rem; }
.nrd-badge-pill {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.35rem 0.9rem; border-radius: 100px;
    font-size: 0.58rem; font-weight: 800;
    letter-spacing: 0.12em; text-transform: uppercase;
    border: 1px solid transparent;
}
.nrd-pill-glass {
    background: rgba(255,255,255,0.12);
    border-color: rgba(255,255,255,0.22);
    color: rgba(255,255,255,0.85);
    backdrop-filter: blur(8px);
}
.nrd-pill-gold {
    background: rgba(201,168,76,0.18);
    border-color: rgba(201,168,76,0.35);
    color: var(--nrd-gold-lt);
    backdrop-filter: blur(8px);
}

.nrd-hero-title {
    font-size: clamp(1.6rem, 4.5vw, 3.25rem);
    font-weight: 800;
    line-height: 1.1;
    letter-spacing: -0.02em;
    color: #fff;
}
.nrd-hero-desc {
    font-size: 0.88rem;
    font-weight: 400;
    color: rgba(255,255,255,0.6);
    line-height: 1.7;
    max-width: 500px;
}
@media (min-width: 640px) { .nrd-hero-desc { font-size: 0.95rem; } }

/* Social proof */
.nrd-social-proof {
    display: flex; align-items: center; gap: 0.85rem; padding-top: 0.25rem;
}
.nrd-avatars { display: flex; }
.nrd-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.2);
    object-fit: cover;
    margin-left: -10px;
    transition: transform 0.2s ease;
}
.nrd-avatars:hover .nrd-avatar { transform: none; }
.nrd-avatars .nrd-avatar:first-child { margin-left: 0; }
.nrd-avatar-count {
    background: rgba(255,255,255,0.12);
    color: rgba(255,255,255,0.8);
    font-size: 0.5rem;
    font-weight: 800;
    display: flex; align-items: center; justify-content: center;
    backdrop-filter: blur(6px);
    letter-spacing: -0.02em;
}
.nrd-proof-text {
    font-size: 0.68rem;
    font-weight: 700;
    color: rgba(255,255,255,0.5);
    letter-spacing: 0.03em;
    text-transform: uppercase;
}

/* Hero right / thumbnail */
.nrd-hero-right { display: none; }
@media (min-width: 1024px) { .nrd-hero-right { display: block; } }

.nrd-thumb-card {
    position: relative;
    width: 100%;
    aspect-ratio: 16/9;
    border-radius: 18px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(255,255,255,0.06);
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    cursor: pointer;
}
.nrd-thumb-img {
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.7;
    transition: opacity 0.4s, transform 0.6s ease;
}
.nrd-thumb-card:hover .nrd-thumb-img { opacity: 1; transform: scale(1.05); }
.nrd-thumb-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.35), transparent 60%);
    pointer-events: none;
}
.nrd-play-btn {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    pointer-events: none;
}
.nrd-play-btn i {
    width: 68px; height: 68px;
    background: rgba(255,255,255,0.95);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem;
    color: var(--nrd-green);
    box-shadow: 0 8px 32px rgba(0,0,0,0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    padding-left: 4px;
}
.nrd-thumb-card:hover .nrd-play-btn i {
    transform: scale(1.12);
    box-shadow: 0 12px 40px rgba(0,0,0,0.4);
}

/* ════════════════════════════════════════════════════
   LAYOUT GRID
════════════════════════════════════════════════════ */
.nrd-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.5rem;
    align-items: start;
}
@media (min-width: 1024px) {
    .nrd-layout { grid-template-columns: 1fr 340px; gap: 2rem; }
}

/* ════════════════════════════════════════════════════
   MAIN COLUMN
════════════════════════════════════════════════════ */

/* Tabs */
.nrd-tabs {
    display: flex;
    gap: 0;
    border-bottom: 1px solid var(--nrd-border);
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
    margin-bottom: 1.75rem;
}
.nrd-tabs::-webkit-scrollbar { display: none; }

.nrd-tab {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.85rem 1.25rem;
    background: transparent;
    border: none;
    border-bottom: 3px solid transparent;
    margin-bottom: -1px;
    font-size: 0.68rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--nrd-muted);
    cursor: pointer;
    white-space: nowrap;
    transition: all 0.2s ease;
}
.nrd-tab .fas, .nrd-tab .far { font-size: 0.65rem; }
.nrd-tab:hover { color: var(--nrd-ink); }
.nrd-tab-active {
    color: var(--nrd-green-lt);
    border-bottom-color: var(--nrd-green-lt);
}

/* Section head */
.nrd-section-head { margin-bottom: 1.25rem; }
.nrd-section-tag {
    display: inline-flex; align-items: center; gap: 0.4rem;
    font-size: 0.55rem; font-weight: 700;
    letter-spacing: 0.2em; text-transform: uppercase;
    color: var(--nrd-green-mid);
    margin-bottom: 0.35rem;
}
.nrd-tag-dot {
    width: 6px; height: 6px; border-radius: 50%;
    background: var(--nrd-green-lt);
    box-shadow: 0 0 6px rgba(30,145,82,0.6);
    animation: nrd-pulse 2.2s infinite;
}
@keyframes nrd-pulse {
    0%, 100% { opacity: 1; } 50% { opacity: 0.45; }
}
.nrd-section-title {
    font-size: 1.3rem; font-weight: 800;
    color: var(--nrd-ink); line-height: 1.2;
}
.nrd-em { color: var(--nrd-green-lt); }
.nrd-section-sub {
    font-size: 0.72rem; color: var(--nrd-muted);
    margin-top: 0.25rem; font-weight: 500;
}

/* Lesson list */
.nrd-lesson-list { display: flex; flex-direction: column; gap: 0.6rem; }

.nrd-lesson-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 1.1rem;
    background: var(--nrd-white);
    border: 1px solid var(--nrd-border);
    border-radius: 14px;
    transition: all 0.25s ease;
    box-shadow: var(--nrd-shadow);
    animation: nrd-fade-up 0.4s ease both;
}
.nrd-lesson-row:hover {
    border-color: rgba(30,145,82,0.25);
    transform: translateY(-2px);
    box-shadow: var(--nrd-shadow-lg);
}
.nrd-row-done {
    background: rgba(13,92,52,0.03);
    border-color: rgba(74,222,128,0.2);
}
@keyframes nrd-fade-up {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

.nrd-lesson-num {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: var(--nrd-surface);
    border: 1px solid var(--nrd-border);
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; font-weight: 800;
    color: var(--nrd-muted);
    flex-shrink: 0;
    transition: all 0.25s ease;
}
.nrd-lesson-row:hover .nrd-lesson-num:not(.nrd-num-done) {
    background: var(--nrd-green);
    border-color: var(--nrd-green);
    color: white;
}
.nrd-num-done {
    background: rgba(74,222,128,0.12);
    border-color: rgba(74,222,128,0.3);
    color: var(--nrd-green-lt);
}
.nrd-num-done .fas { font-size: 0.85rem; }

.nrd-lesson-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 0.2rem; }
.nrd-lesson-eyebrow {
    font-size: 0.55rem; font-weight: 700;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--nrd-muted);
}
.nrd-lesson-title {
    font-size: 0.92rem; font-weight: 700;
    color: var(--nrd-ink); line-height: 1.3;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    transition: color 0.2s ease;
}
.nrd-lesson-row:hover .nrd-lesson-title { color: var(--nrd-green-lt); }
.nrd-row-done .nrd-lesson-title { color: var(--nrd-muted); text-decoration: line-through; text-decoration-color: rgba(74,222,128,0.4); }

.nrd-lesson-meta {
    display: flex; align-items: center; gap: 1rem;
    font-size: 0.62rem; font-weight: 600; color: var(--nrd-muted);
}
.nrd-lesson-meta span { display: flex; align-items: center; gap: 0.3rem; }
.nrd-lesson-meta .fas, .nrd-lesson-meta .far { font-size: 0.55rem; color: var(--nrd-green-lt); }

/* Done badge */
.nrd-done-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.32rem 0.8rem;
    background: rgba(74,222,128,0.1);
    border: 1px solid rgba(74,222,128,0.25);
    border-radius: 100px;
    font-size: 0.58rem; font-weight: 700;
    color: var(--nrd-green-lt);
    white-space: nowrap; flex-shrink: 0;
}
.nrd-done-badge .fas { font-size: 0.65rem; }

/* Play button */
.nrd-play-row-btn {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: var(--nrd-green);
    color: white; border: none;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.65rem;
    text-decoration: none;
    flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(13,92,52,0.3);
    transition: all 0.25s ease;
    padding-left: 2px;
}
.nrd-play-row-btn:hover {
    background: var(--nrd-green-mid);
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(13,92,52,0.4);
}

/* ════════════════════════════════════════════════════
   SIDEBAR
════════════════════════════════════════════════════ */
.nrd-sidebar {
    background: var(--nrd-green);
    border-radius: 18px;
    overflow: hidden;
    position: sticky;
    top: 1.5rem;
    box-shadow: 0 16px 48px rgba(13,92,52,0.3);
}

/* Progress block */
.nrd-progress-block {
    padding: 1.5rem 1.5rem 1.25rem;
    display: flex; flex-direction: column; gap: 0.75rem;
}
.nrd-progress-tag {
    display: inline-flex; align-items: center; gap: 0.4rem;
    font-size: 0.52rem; font-weight: 700;
    letter-spacing: 0.22em; text-transform: uppercase;
    color: rgba(255,255,255,0.4);
}
.nrd-dot-gold { background: var(--nrd-gold-lt) !important; box-shadow: 0 0 6px rgba(246,216,96,0.6) !important; }

.nrd-progress-header {
    display: flex; align-items: center; justify-content: space-between;
}
.nrd-progress-label {
    font-size: 1rem; font-weight: 700; color: rgba(255,255,255,0.9);
}
.nrd-progress-pct {
    font-size: 1.6rem; font-weight: 800;
    color: var(--nrd-green-vlt); line-height: 1;
}
.nrd-pct-done { color: var(--nrd-gold-lt); }

/* Ring + track row */
.nrd-ring-row { display: flex; align-items: center; gap: 1rem; }
.nrd-ring-wrap {
    width: 56px; height: 56px;
    position: relative; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
}
.nrd-ring-svg {
    position: absolute; inset: 0; width: 100%; height: 100%;
    transform: rotate(-90deg);
}
.nrd-ring-inner-pct {
    position: relative; z-index: 1;
    font-size: 0.52rem; font-weight: 800;
    color: rgba(255,255,255,0.85);
}

.nrd-progress-detail { flex: 1; display: flex; flex-direction: column; gap: 0.45rem; }
.nrd-progress-track {
    height: 5px; border-radius: 100px;
    background: rgba(255,255,255,0.1); overflow: hidden;
}
.nrd-progress-fill {
    height: 100%; border-radius: 100px;
    background: linear-gradient(90deg, var(--nrd-green-lt), var(--nrd-green-vlt));
    transition: width 1s cubic-bezier(0.4,0,0.2,1);
}
.nrd-fill-gold { background: linear-gradient(90deg, var(--nrd-gold), var(--nrd-gold-lt)); }
.nrd-progress-sub {
    font-size: 0.62rem; color: rgba(255,255,255,0.4); font-weight: 500;
}
.nrd-progress-sub strong { color: rgba(255,255,255,0.7); }

/* Divider */
.nrd-sidebar-divider { height: 1px; background: rgba(255,255,255,0.08); margin: 0 1.5rem; }

/* Post Test block */
.nrd-test-block { padding: 1.25rem 1.5rem; display: flex; flex-direction: column; gap: 0.85rem; }
.nrd-test-head { display: flex; align-items: flex-start; gap: 0.85rem; }
.nrd-test-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; flex-shrink: 0; border: 1px solid transparent;
}
.nrd-icon-gold { background: rgba(201,168,76,0.15); border-color: rgba(201,168,76,0.3); color: var(--nrd-gold-lt); }
.nrd-icon-muted { background: rgba(255,255,255,0.06); border-color: rgba(255,255,255,0.1); color: rgba(255,255,255,0.25); }

.nrd-test-eyebrow {
    font-size: 0.52rem; font-weight: 800;
    letter-spacing: 0.2em; text-transform: uppercase;
    margin-bottom: 0.2rem;
}
.nrd-eyebrow-gold { color: var(--nrd-gold-lt); }
.nrd-eyebrow-muted { color: rgba(255,255,255,0.3); }

.nrd-test-sub { font-size: 0.65rem; color: rgba(255,255,255,0.45); font-weight: 500; }
.nrd-test-desc { font-size: 0.7rem; color: rgba(255,255,255,0.5); line-height: 1.65; font-weight: 400; }

.nrd-test-btn {
    display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
    width: 100%; padding: 0.82rem 1rem;
    border-radius: 10px; border: none;
    font-size: 0.65rem; font-weight: 800;
    letter-spacing: 0.12em; text-transform: uppercase;
    text-decoration: none; cursor: pointer;
    transition: all 0.25s ease;
    position: relative; overflow: hidden;
}
.nrd-test-btn::before {
    content: ''; position: absolute; inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transform: translateX(-100%); transition: transform 0.4s ease;
}
.nrd-test-btn:hover::before { transform: translateX(100%); }

.nrd-btn-active {
    background: var(--nrd-gold);
    color: var(--nrd-ink);
    box-shadow: 0 4px 16px rgba(201,168,76,0.35);
}
.nrd-btn-active:hover {
    background: var(--nrd-gold-lt);
    transform: translateY(-1px);
    box-shadow: 0 6px 22px rgba(201,168,76,0.45);
}
.nrd-btn-disabled {
    background: rgba(255,255,255,0.05);
    color: rgba(255,255,255,0.2);
    cursor: not-allowed;
}

/* Share row */
.nrd-share-row {
    padding: 1rem 1.5rem 1.4rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
}
.nrd-share-label {
    font-size: 0.6rem; font-weight: 700;
    letter-spacing: 0.15em; text-transform: uppercase;
    color: rgba(255,255,255,0.3);
}
.nrd-share-icons { display: flex; gap: 0.5rem; }
.nrd-share-btn {
    width: 34px; height: 34px;
    border-radius: 8px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.72rem;
    text-decoration: none;
    transition: all 0.2s ease;
}
.nrd-share-btn:hover {
    background: rgba(255,255,255,0.14);
    color: var(--nrd-green-vlt);
    border-color: rgba(74,222,128,0.25);
    transform: translateY(-2px);
}

/* ── Mobile ──────────────────────────────────────── */
@media (max-width: 639px) {
    .nrd-hero { padding: 2rem 1.1rem; border-radius: 18px; margin-bottom: 1.25rem; }
    .nrd-layout { gap: 1.15rem; padding: 0 0.25rem; }
    .nrd-tabs { overflow-x: visible; }
    .nrd-tab {
        flex: 1;
        justify-content: center;
        padding: 0.75rem 0.55rem;
        font-size: 0.6rem;
        letter-spacing: 0.08em;
    }
    .nrd-tab .fas, .nrd-tab .far { display: none; }
    .nrd-lesson-row { padding: 0.85rem 0.85rem; gap: 0.75rem; }
    .nrd-lesson-num { width: 38px; height: 38px; border-radius: 10px; }
    .nrd-sidebar { position: static; }
}

/* ── Lesson Locked State ─────────────────────────── */
.nrd-row-locked { opacity: 0.72; }
.nrd-num-locked {
    background: rgba(245,158,11,0.12);
    border-color: rgba(245,158,11,0.35);
    color: #FCD34D;
}
.nrd-lock-hint {
    color: #F59E0B;
    font-size: 0.58rem;
    font-weight: 700;
    display: flex; align-items: center; gap: 0.3rem;
}
.nrd-lock-hint .fas { font-size: 0.55rem; }
.nrd-lock-btn {
    width: 42px; height: 42px;
    border-radius: 50%;
    background: rgba(245,158,11,0.15);
    color: #FCD34D;
    border: 1.5px solid rgba(245,158,11,0.3);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.65rem;
    text-decoration: none;
    flex-shrink: 0;
    transition: all 0.25s ease;
}
.nrd-lock-btn:hover {
    background: rgba(245,158,11,0.25);
    transform: scale(1.1);
}
.nrd-pretest-alert { animation: nrd-pulse-border 2s infinite; }
@keyframes nrd-pulse-border {
    0%, 100% { box-shadow: none; }
    50% { box-shadow: 0 0 0 2px rgba(245,158,11,0.2); }
}
</style>

@endsection
