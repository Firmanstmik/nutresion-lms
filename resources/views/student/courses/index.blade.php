@extends('layouts.app')

@section('no-container', true)

@section('content')

{{-- ─── Google Font: Plus Jakarta Sans ─────────────────────────── --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<div class="lms-root">

    {{-- ══════════════════════════════════════════════════════════════
         HERO — SPLIT LAYOUT
    ══════════════════════════════════════════════════════════════ --}}
    <section class="lms-hero">

        {{-- ─── NEW: Layered Background ─────────────────────────── --}}
        <div class="lms-hero-bg" aria-hidden="true">
            {{-- Base: diagonal gradient + radial glows --}}
            <div class="lms-bg-base"></div>

            {{-- Animated grid mesh --}}
            <div class="lms-bg-grid"></div>

            {{-- Ambient blur orbs --}}
            <div class="lms-orb lms-orb-a"></div>
            <div class="lms-orb lms-orb-b"></div>
            <div class="lms-orb lms-orb-c"></div>

            {{-- Diagonal light beam --}}
            <div class="lms-light-beam"></div>

            {{-- Horizontal shimmer scanline --}}
            <div class="lms-shimmer-line"></div>

            {{-- SVG Particle constellation (GPU-composited, no JS) --}}
            <div class="lms-particles">
                <svg viewBox="0 0 1440 600" preserveAspectRatio="xMidYMid slice"
                     xmlns="http://www.w3.org/2000/svg" role="presentation">
                    <defs>
                        <radialGradient id="pdot" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#4ADE80" stop-opacity="1"/>
                            <stop offset="100%" stop-color="#4ADE80" stop-opacity="0"/>
                        </radialGradient>
                    </defs>

                    {{-- Large soft depth circles --}}
                    <circle cx="1100" cy="100" r="140" fill="#22C55E" opacity="0.04">
                        <animate attributeName="r" values="140;162;140" dur="9s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="200" cy="450" r="100" fill="#4ADE80" opacity="0.045">
                        <animate attributeName="r" values="100;118;100" dur="11s" repeatCount="indefinite"/>
                    </circle>
                    <circle cx="1320" cy="370" r="78" fill="#16A34A" opacity="0.05">
                        <animate attributeName="r" values="78;93;78" dur="7.5s" repeatCount="indefinite"/>
                    </circle>

                    {{-- Floating dot particles --}}
                    <g fill="url(#pdot)">
                        {{-- Row 1 --}}
                        <circle cx="80"   cy="60"  r="2">  <animate attributeName="opacity" values="0;0.5;0"  dur="4.2s" begin="0s"    repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;2,-12;0,0"   dur="4.2s"  repeatCount="indefinite"/></circle>
                        <circle cx="240"  cy="120" r="1.5"><animate attributeName="opacity" values="0;0.35;0" dur="5.8s" begin="1s"    repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;-3,-10;0,0"  dur="5.8s"  repeatCount="indefinite"/></circle>
                        <circle cx="480"  cy="50"  r="2.5"><animate attributeName="opacity" values="0;0.6;0"  dur="6.1s" begin="0.5s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;4,-14;0,0"   dur="6.1s"  repeatCount="indefinite"/></circle>
                        <circle cx="700"  cy="95"  r="1.8"><animate attributeName="opacity" values="0;0.4;0"  dur="7.3s" begin="2s"    repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;-2,-8;0,0"   dur="7.3s"  repeatCount="indefinite"/></circle>
                        <circle cx="920"  cy="55"  r="2.2"><animate attributeName="opacity" values="0;0.55;0" dur="5.5s" begin="1.5s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;3,-11;0,0"   dur="5.5s"  repeatCount="indefinite"/></circle>
                        <circle cx="1150" cy="80"  r="1.6"><animate attributeName="opacity" values="0;0.3;0"  dur="8.0s" begin="3s"    repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;-4,-9;0,0"   dur="8.0s"  repeatCount="indefinite"/></circle>
                        <circle cx="1380" cy="45"  r="2.0"><animate attributeName="opacity" values="0;0.45;0" dur="6.7s" begin="0.7s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;2,-13;0,0"   dur="6.7s"  repeatCount="indefinite"/></circle>
                        {{-- Row 2 --}}
                        <circle cx="150"  cy="220" r="1.8"><animate attributeName="opacity" values="0;0.45;0" dur="6.4s" begin="0.8s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;2,-13;0,0"   dur="6.4s"  repeatCount="indefinite"/></circle>
                        <circle cx="380"  cy="195" r="2.4"><animate attributeName="opacity" values="0;0.5;0"  dur="4.8s" begin="2.2s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;-3,-10;0,0"  dur="4.8s"  repeatCount="indefinite"/></circle>
                        <circle cx="600"  cy="240" r="1.5"><animate attributeName="opacity" values="0;0.35;0" dur="7.7s" begin="1.2s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;4,-8;0,0"    dur="7.7s"  repeatCount="indefinite"/></circle>
                        <circle cx="820"  cy="185" r="2.0"><animate attributeName="opacity" values="0;0.6;0"  dur="5.2s" begin="0.3s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;-2,-12;0,0"  dur="5.2s"  repeatCount="indefinite"/></circle>
                        <circle cx="1060" cy="215" r="2.6"><animate attributeName="opacity" values="0;0.4;0"  dur="9.0s" begin="1.8s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;3,-15;0,0"   dur="9.0s"  repeatCount="indefinite"/></circle>
                        <circle cx="1280" cy="175" r="1.4"><animate attributeName="opacity" values="0;0.3;0"  dur="6.6s" begin="2.5s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;-3,-9;0,0"   dur="6.6s"  repeatCount="indefinite"/></circle>
                        {{-- Row 3 --}}
                        <circle cx="70"   cy="360" r="2.1"><animate attributeName="opacity" values="0;0.55;0" dur="5.9s" begin="3.1s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;2,-11;0,0"   dur="5.9s"  repeatCount="indefinite"/></circle>
                        <circle cx="300"  cy="340" r="1.7"><animate attributeName="opacity" values="0;0.38;0" dur="7.1s" begin="0.6s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;-4,-8;0,0"   dur="7.1s"  repeatCount="indefinite"/></circle>
                        <circle cx="550"  cy="390" r="2.3"><animate attributeName="opacity" values="0;0.5;0"  dur="4.5s" begin="1.7s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;3,-13;0,0"   dur="4.5s"  repeatCount="indefinite"/></circle>
                        <circle cx="780"  cy="325" r="1.9"><animate attributeName="opacity" values="0;0.42;0" dur="8.3s" begin="2.9s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;-2,-10;0,0"  dur="8.3s"  repeatCount="indefinite"/></circle>
                        <circle cx="1000" cy="370" r="2.5"><animate attributeName="opacity" values="0;0.6;0"  dur="6.8s" begin="0.2s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;4,-14;0,0"   dur="6.8s"  repeatCount="indefinite"/></circle>
                        <circle cx="1230" cy="345" r="1.6"><animate attributeName="opacity" values="0;0.33;0" dur="5.1s" begin="3.5s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;-3,-7;0,0"   dur="5.1s"  repeatCount="indefinite"/></circle>
                        <circle cx="1400" cy="310" r="2.0"><animate attributeName="opacity" values="0;0.4;0"  dur="7.6s" begin="1.0s"  repeatCount="indefinite"/><animateTransform attributeName="transform" type="translate" values="0,0;2,-9;0,0"    dur="7.6s"  repeatCount="indefinite"/></circle>
                    </g>

                    {{-- Constellation connecting lines --}}
                    <g stroke="#4ADE80" stroke-width="0.5" fill="none">
                        <line x1="80"  y1="60"  x2="240"  y2="120"><animate attributeName="opacity" values="0.04;0.11;0.04" dur="6.0s"  repeatCount="indefinite"/></line>
                        <line x1="480" y1="50"  x2="700"  y2="95"> <animate attributeName="opacity" values="0.05;0.12;0.05" dur="8.0s"  begin="1s"   repeatCount="indefinite"/></line>
                        <line x1="700" y1="95"  x2="920"  y2="55"> <animate attributeName="opacity" values="0.04;0.09;0.04" dur="7.0s"  begin="2s"   repeatCount="indefinite"/></line>
                        <line x1="380" y1="195" x2="600"  y2="240"><animate attributeName="opacity" values="0.05;0.11;0.05" dur="9.0s"  begin="0.5s" repeatCount="indefinite"/></line>
                        <line x1="820" y1="185" x2="1060" y2="215"><animate attributeName="opacity" values="0.04;0.10;0.04" dur="6.5s"  begin="1.5s" repeatCount="indefinite"/></line>
                        <line x1="80"  y1="60"  x2="150"  y2="220"><animate attributeName="opacity" values="0.04;0.09;0.04" dur="7.5s"  begin="3.0s" repeatCount="indefinite"/></line>
                        <line x1="300" y1="340" x2="550"  y2="390"><animate attributeName="opacity" values="0.03;0.08;0.03" dur="8.5s"  begin="2.0s" repeatCount="indefinite"/></line>
                    </g>
                </svg>
            </div>

            {{-- Noise grain --}}
            <div class="lms-canvas-noise"></div>
        </div>

        <div class="lms-hero-inner">
            {{-- Left: Content ─────────────────────────────────────────── --}}
            <div class="lms-hero-left">

                <div class="lms-hero-pill">
                    <span class="lms-pill-live"></span>
                    <span>Nutrition Rescue Mission</span>
                    <span class="lms-pill-sep">·</span>
                    <span>Modul Pembelajaran</span>
                </div>

                <h1 class="lms-hero-heading">
                    Kuasai
                    <span class="lms-heading-accent">
                        Ilmu Gizi
                        <svg class="lms-heading-underline" viewBox="0 0 220 12" preserveAspectRatio="none" aria-hidden="true">
                            <path d="M3 9 C60 3, 160 3, 217 9" stroke="url(#u1)" stroke-width="3.5" fill="none" stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="u1" x1="0" y1="0" x2="1" y2="0">
                                    <stop offset="0%" stop-color="#4ADE80"/>
                                    <stop offset="100%" stop-color="#34D399" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                    <br>dari Akar&shy;nya
                </h1>

                <p class="lms-hero-body">
                    Temukan beragam materi pembelajaran yang menarik untuk membantumu memahami pentingnya gizi seimbang dan gaya hidup sehat.
                </p>

                {{-- ─── Search ──────────────────────────────────────── --}}
                <form action="{{ route('courses.index') }}" method="GET" class="lms-search-form">

                    <div class="lms-search-card">
                        <div class="lms-search-icon-wrap" aria-hidden="true">
                            <i class="fas fa-search lms-search-ico"></i>
                        </div>
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            class="lms-search-input"
                            placeholder="Cari kursus, topik, atau kata kunci…"
                            autocomplete="off"
                        >
                        <button type="submit" class="lms-search-submit">
                            <span>Cari</span>
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>

                    {{-- Filter strip --}}
                    <div class="lms-filter-strip">
                        <div class="lms-filter-chip-wrap">
                            <i class="fas fa-arrow-up-short-wide lms-ico-muted"></i>
                            <div class="lms-filter-group">
                                <label class="lms-filter-micro">Urutkan</label>
                                <select name="sort" class="lms-filter-sel">
                                    <option value="newest"       {{ request('sort', 'newest') === 'newest'       ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest"       {{ request('sort') === 'oldest'                 ? 'selected' : '' }}>Terlama</option>
                                    <option value="az"           {{ request('sort') === 'az'                     ? 'selected' : '' }}>Judul A–Z</option>
                                    <option value="za"           {{ request('sort') === 'za'                     ? 'selected' : '' }}>Judul Z–A</option>
                                    <option value="lessons_desc" {{ request('sort') === 'lessons_desc'           ? 'selected' : '' }}>Bab Terbanyak</option>
                                    <option value="lessons_asc"  {{ request('sort') === 'lessons_asc'            ? 'selected' : '' }}>Bab Tersedikit</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="lms-apply-btn">
                            <i class="fas fa-check"></i>
                            Terapkan
                        </button>

                        @if(request('search') || request('sort', 'newest') !== 'newest')
                            <a href="{{ route('courses.index') }}" class="lms-reset-btn">
                                <i class="fas fa-xmark"></i>
                                Reset
                            </a>
                        @endif
                    </div>

                </form>

                {{-- Quick stats --}}
                <div class="lms-hero-stats">
                    <div class="lms-stat">
                        <span class="lms-stat-num">{{ method_exists($courses, 'total') ? $courses->total() : $courses->count() }}</span>
                        <span class="lms-stat-lbl">Kursus</span>
                    </div>
                    <div class="lms-stat-divider" aria-hidden="true"></div>
                    <div class="lms-stat">
                        <span class="lms-stat-num">100%</span>
                        <span class="lms-stat-lbl">Gratis</span>
                    </div>
                    <div class="lms-stat-divider" aria-hidden="true"></div>
                    <div class="lms-stat">
                        <span class="lms-stat-num">∞</span>
                        <span class="lms-stat-lbl">Akses</span>
                    </div>
                </div>

            </div>

            {{-- Right: Decorative panel ─────────────────────────────── --}}
            <div class="lms-hero-right" aria-hidden="true">
                <div class="lms-deco-frame">
                    <img
                        src="{{ route('brand.belajar-nutrition') }}"
                        class="lms-deco-img"
                        alt="Ilustrasi Belajar"
                    >
                </div>
                {{-- Gojek-style separator for mobile --}}
                <div class="lms-mobile-sep"></div>
            </div>
        </div>

        {{-- ─── Wave Divider ────────────────────────────────────── --}}
        <div class="lms-hero-wave" aria-hidden="true">
            <svg viewBox="0 0 1440 90" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,45 C200,90 400,5 600,45 C800,85 1000,10 1200,48 C1320,72 1390,25 1440,45 L1440,90 L0,90 Z" fill="#F7FAF8" opacity="0.45"/>
                <path d="M0,58 C220,25 440,80 660,55 C880,30 1100,76 1300,50 C1380,35 1420,65 1440,55 L1440,90 L0,90 Z" fill="#F7FAF8" opacity="0.7"/>
                <path d="M0,68 C280,45 520,85 760,65 C1000,45 1220,78 1440,62 L1440,90 L0,90 Z" fill="#F7FAF8"/>
            </svg>
        </div>

    </section>

    {{-- ══════════════════════════════════════════════════════════════
         RESULTS RAIL
    ══════════════════════════════════════════════════════════════ --}}
    <div class="lms-rail">
        <div class="lms-rail-inner">
            <div class="lms-rail-left">
                <div class="lms-rail-label">
                    @if(request('search'))
                        Hasil untuk
                        <strong>&ldquo;{{ request('search') }}&rdquo;</strong>
                    @else
                        Semua Pembelajaran
                    @endif
                </div>
                <div class="lms-rail-sub">Pilih kursus untuk mulai belajar</div>
            </div>
            <div class="lms-rail-badge">
                <span class="lms-rail-num">{{ method_exists($courses, 'total') ? $courses->total() : $courses->count() }}</span>
                <span class="lms-rail-unit">kursus</span>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         COURSE GRID
    ══════════════════════════════════════════════════════════════ --}}
    <div class="lms-grid">

        @forelse($courses as $i => $course)
            @php
                $lessonCount = $course->lessons_count ?? $course->lessons->count();
                $completed   = (int) ($completedByCourse[$course->id] ?? 0);
                $total       = max(1, (int) ($course->lessons_count ?? 0));
                $percent     = (int) round(($completed / $total) * 100);
                $percent     = max(0, min(100, $percent));
                $isDone      = $percent >= 100;
                $isStarted   = $percent > 0 && !$isDone;
            @endphp

            <article class="lms-card" style="--i: {{ $i }}">

                {{-- ── Thumbnail ──────────────────────────────────── --}}
                <a href="{{ route('courses.detail', $course->id) }}" class="lms-thumb-link" tabindex="-1">
                    <div class="lms-thumb">
                        <img
                            src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=2070&auto=format&fit=crop' }}"
                            class="lms-thumb-img"
                            alt="{{ $course->title }}"
                            loading="lazy"
                        >
                        <div class="lms-thumb-vignette"></div>
                        <div class="lms-thumb-scrim"></div>

                        {{-- Status ribbon --}}
                        @if($isDone)
                            <div class="lms-ribbon lms-ribbon-done">
                                <i class="fas fa-check-circle"></i>
                                Selesai
                            </div>
                        @elseif($isStarted)
                            <div class="lms-ribbon lms-ribbon-wip">
                                <i class="fas fa-circle-half-stroke"></i>
                                Dilanjutkan
                            </div>
                        @endif

                        {{-- Top badges --}}
                        <div class="lms-badge-row">
                            @if($course->type)
                            <span class="lms-badge-type lms-type-{{ $course->type->color ?? 'gray' }}">
                                {{ $course->type->name }}
                            </span>
                            @endif
                            @if($course->label)
                                <span class="lms-badge-label">{{ $course->label }}</span>
                            @endif
                        </div>

                        {{-- Chapter count --}}
                        <div class="lms-thumb-meta">
                            <span class="lms-chapter-pill">
                                <i class="fas fa-layer-group"></i>
                                {{ $lessonCount }} Bab
                            </span>
                            <div class="lms-ring" title="{{ $percent }}% selesai">
                                <svg viewBox="0 0 40 40" class="lms-ring-svg">
                                    <circle cx="20" cy="20" r="16" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="3"/>
                                    <circle cx="20" cy="20" r="16" fill="none"
                                        stroke="{{ $isDone ? '#FBBF24' : '#4ADE80' }}"
                                        stroke-width="3"
                                        stroke-dasharray="{{ $percent }} {{ 100 - $percent }}"
                                        stroke-dashoffset="25"
                                        stroke-linecap="round"/>
                                </svg>
                                <span class="lms-ring-text">{{ $percent }}%</span>
                            </div>
                        </div>
                    </div>
                </a>

                {{-- ── Body ────────────────────────────────────────── --}}
                <div class="lms-card-body">

                    {{-- School tag --}}
                    <div class="lms-school-tag">
                        <i class="fas fa-school-flag"></i>
                        <span>{{ $course->school->name ?? 'Semua Sekolah' }}</span>
                    </div>

                    {{-- Title --}}
                    <h2 class="lms-card-title">
                        <a href="{{ route('courses.detail', $course->id) }}" class="lms-title-link">
                            {{ $course->title }}
                        </a>
                    </h2>

                    {{-- Description --}}
                    <p class="lms-card-desc">
                        {{ $course->description ?: 'Pelajari materi gizi dan kesehatan dengan pendekatan praktis dan berbasis riset untuk hasil yang optimal.' }}
                    </p>

                    {{-- Spacer --}}
                    <div class="lms-spacer"></div>

                    {{-- Progress --}}
                    <div class="lms-progress">
                        <div class="lms-progress-meta">
                            <span class="lms-progress-label">Progress Belajar</span>
                            <span class="lms-progress-pct {{ $isDone ? 'lms-pct-done' : '' }}">
                                {{ $percent }}%
                            </span>
                        </div>
                        <div class="lms-progress-track">
                            <div
                                class="lms-progress-fill {{ $isDone ? 'lms-fill-done' : '' }}"
                                style="--pct: {{ $percent }}%"
                            ></div>
                        </div>
                        <div class="lms-progress-foot">
                            <span>{{ $completed }} dari {{ $total }} materi selesai</span>
                            @if($isDone)
                                <span class="lms-done-tag">
                                    <i class="fas fa-star"></i>
                                    Tuntas!
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- CTA --}}
                    @php
                        $hasTakenPostTest = isset($resultsByCourse[$course->id]) && $resultsByCourse[$course->id];
                    @endphp
                    <a href="{{ route('courses.detail', $course->id) }}" class="lms-cta {{ $isDone ? 'lms-cta-done' : ($isStarted ? 'lms-cta-resume' : 'lms-cta-start') }}">
                        <span class="lms-cta-inner">
                            @if($isDone)
                                @if($hasTakenPostTest)
                                    <i class="fas fa-rotate-right"></i>
                                    <span>Ulangi Kursus</span>
                                @else
                                    <i class="fas fa-trophy"></i>
                                    <span>Selesaikan Post Test</span>
                                @endif
                            @elseif($isStarted)
                                <i class="fas fa-play-circle"></i>
                                <span>Lanjutkan Belajar</span>
                            @else
                                <i class="fas fa-rocket"></i>
                                <span>Mulai Sekarang</span>
                            @endif
                        </span>
                        <span class="lms-cta-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </a>

                </div>

            </article>

        @empty
            {{-- ── Empty State ──────────────────────────────────── --}}
            <div class="lms-empty">
                <div class="lms-empty-visual">
                    <div class="lms-empty-rings" aria-hidden="true">
                        <div class="lms-er lms-er1"></div>
                        <div class="lms-er lms-er2"></div>
                        <div class="lms-er lms-er3"></div>
                    </div>
                    <div class="lms-empty-ico">
                        <i class="fas fa-seedling"></i>
                    </div>
                </div>
                <h3 class="lms-empty-title">Belum ada pembelajaran</h3>
                <p class="lms-empty-body">
                    @if(request('search'))
                        Tidak ada kursus untuk <strong>&ldquo;{{ request('search') }}&rdquo;</strong>.<br>Coba gunakan kata kunci yang berbeda.
                    @else
                        Kami sedang mempersiapkan materi terbaik untukmu. Mohon tunggu sebentar.
                    @endif
                </p>
                <a href="{{ route('courses.index') }}" class="lms-empty-cta">
                    <i class="fas fa-rotate-right"></i>
                    Segarkan Halaman
                </a>
            </div>
        @endforelse

    </div>{{-- lms-grid --}}

</div>{{-- lms-root --}}


{{-- ══════════════════════════════════════════════════════════════════
     STYLES
══════════════════════════════════════════════════════════════════ --}}
<style>
/* ╔══════════════════════════════════════════════════════════════════
   ║  DESIGN TOKENS
   ╚══════════════════════════════════════════════════════════════════ */
:root {
    /* Greens */
    --g900: #052E17;
    --g800: #0A3D21;
    --g700: #0D5C34;
    --g600: #187945;
    --g500: #1E9152;
    --g400: #22C55E;
    --g300: #4ADE80;
    --g200: #86EFAC;
    --g100: #DCFCE7;
    --g50:  #F0FDF4;

    /* Accents */
    --gold: #D97706;
    --gold-lt: #FCD34D;
    --red:  #EF4444;

    /* Neutrals */
    --ink:     #0C1A12;
    --ink-80:  #1C2B22;
    --ink-60:  #374C3A;
    --muted:   #6B7280;
    --quiet:   #9CA3AF;
    --border:  #E5E7EB;
    --border-lt: #F3F4F6;
    --surface: #F7FAF8;
    --white:   #FFFFFF;

    /* Shadows */
    --s1: 0 1px 3px rgba(10,61,33,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --s2: 0 4px 16px rgba(10,61,33,0.08), 0 2px 6px rgba(0,0,0,0.04);
    --s3: 0 12px 36px rgba(10,61,33,0.12), 0 4px 12px rgba(0,0,0,0.06);
    --s4: 0 24px 56px rgba(10,61,33,0.16), 0 8px 24px rgba(0,0,0,0.08);
    --s-glow: 0 0 0 3px rgba(74,222,128,0.18);

    /* Typography */
    --font: 'Plus Jakarta Sans', system-ui, sans-serif;

    /* Radii */
    --r-sm:  8px;
    --r-md:  12px;
    --r-lg:  16px;
    --r-xl:  20px;
    --r-2xl: 24px;
    --r-full: 9999px;

    /* Transitions */
    --t-fast: 180ms cubic-bezier(0.4,0,0.2,1);
    --t-base: 260ms cubic-bezier(0.4,0,0.2,1);
    --t-slow: 400ms cubic-bezier(0.34,1.56,0.64,1);
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  RESET & ROOT
   ╚══════════════════════════════════════════════════════════════════ */
.lms-root *,
.lms-root *::before,
.lms-root *::after {
    box-sizing: border-box;
}
.lms-root {
    font-family: var(--font);
    background: var(--surface);
    min-height: 100vh;
    margin: 0;
    overflow-x: hidden;
    color: var(--ink);
}
@media (min-width: 768px)  { .lms-root { margin: -1.5rem 0 0; } }
@media (min-width: 1024px) { .lms-root { margin: -2.5rem 0 0; } }

/* ╔══════════════════════════════════════════════════════════════════
   ║  HERO
   ╚══════════════════════════════════════════════════════════════════ */
.lms-hero {
    position: relative;
    /* Fallback solid colour if gradient hasn't painted yet */
    background: #0A3D21;
    min-height: 520px;
    display: flex;
    align-items: stretch;
    overflow: hidden;
}

.lms-hero-inner {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    display: flex;
    flex-wrap: wrap;
    position: relative;
    /* z-index above the bg layer but nothing fancy */
    z-index: 2;
}
@media (min-width: 1400px) {
    .lms-hero-inner { padding: 0 4rem; }
}

/* ── Wave divider ──────────────────────────────────────────────── */
.lms-hero-wave {
    position: absolute;
    bottom: -1px;
    left: 0;
    right: 0;
    line-height: 0;
    /* Wave sits above bg but below content */
    z-index: 3;
    /* GPU layer — prevents repaint on scroll */
    will-change: transform;
    transform: translateZ(0);
}
.lms-hero-wave svg {
    display: block;
    width: 100%;
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  BACKGROUND SYSTEM
   ║
   ║  Performance rules applied throughout:
   ║  • Every animated element uses ONLY opacity / transform
   ║    (the two properties browsers can animate on the GPU
   ║     compositor thread without touching layout or paint).
   ║  • will-change: transform is declared on elements whose
   ║    animation is running continuously, so Chrome/Firefox
   ║    promotes them to their own composited layer up-front.
   ║  • filter: blur() on the orbs is declared statically —
   ║    the blur value itself is never animated, only opacity
   ║    and transform, so the rasterised texture is cached.
   ║  • The grid translates by exactly one tile length, making
   ║    it loop seamlessly while staying on the compositor.
   ║  • The shimmer scanline animates only the `top` property
   ║    (not transform) because it needs to cross the full
   ║    height; its opacity fades near edges so the jump is
   ║    invisible. It is isolated on its own layer via
   ║    will-change: transform, opacity.
   ║  • SVG SMIL animations (particles / constellation lines)
   ║    are handled by the browser's own SVG engine — they
   ║    never trigger JS or layout. Opacity-only SMIL runs
   ║    on the compositor in modern browsers.
   ╚══════════════════════════════════════════════════════════════════ */

/* Wrapper — pointer-events off so it never blocks clicks */
.lms-hero-bg {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 1;
    /* Isolate stacking context so child layers don't leak */
    isolation: isolate;
}

/* ── Base gradient ─────────────────────────────────────────────── */
/* Static — no animation needed; radial + linear gives depth */
.lms-bg-base {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 80% 60% at 18% 50%, #0F5C35 0%, transparent 68%),
        radial-gradient(ellipse 55% 75% at 82% 15%, #0A4A28 0%, transparent 62%),
        linear-gradient(135deg, #061C0E 0%, #0A3D21 38%, #0D5C34 72%, #0A3D21 100%);
}

/* ── Grid mesh ─────────────────────────────────────────────────── */
/*
 * Translates by exactly one tile (52 px) on both axes so the
 * repeat seam is invisible. Only `transform` is animated → GPU.
 */
.lms-bg-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(74,222,128,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(74,222,128,0.04) 1px, transparent 1px);
    background-size: 52px 52px;
    will-change: transform;
    animation: lms-grid-shift 24s linear infinite;
}
@keyframes lms-grid-shift {
    to { transform: translate(52px, 52px); }
}

/* ── Ambient blur orbs ─────────────────────────────────────────── */
/*
 * filter:blur is STATIC — only opacity + transform animate.
 * Each orb gets its own composited layer via will-change.
 * Durations are prime-ish so they never sync up and pulse together.
 */
.lms-orb {
    position: absolute;
    border-radius: 50%;
    /* blur is expensive to change but FREE once composited */
    filter: blur(90px);
    will-change: transform, opacity;
    animation: lms-orb-pulse var(--dur, 9s) ease-in-out infinite alternate;
}
@keyframes lms-orb-pulse {
    0%   { opacity: var(--opa-a, 0.20); transform: translate(0, 0) scale(1); }
    100% { opacity: var(--opa-b, 0.32); transform: translate(var(--tx, 10px), var(--ty, -10px)) scale(1.1); }
}
.lms-orb-a {
    width: 560px; height: 560px;
    left: -130px; top: -110px;
    background: radial-gradient(circle, #187945 0%, #0D5C34 50%, transparent 70%);
    --dur: 9s; --opa-a: 0.22; --opa-b: 0.36; --tx: 18px; --ty: 12px;
}
.lms-orb-b {
    width: 380px; height: 380px;
    right: -70px; bottom: -90px;
    background: radial-gradient(circle, #22C55E 0%, #187945 50%, transparent 70%);
    --dur: 13s; --opa-a: 0.12; --opa-b: 0.22; --tx: -12px; --ty: -18px;
}
.lms-orb-c {
    width: 280px; height: 280px;
    left: 42%; top: 55%;
    background: radial-gradient(circle, #4ADE80 0%, transparent 65%);
    --dur: 17s; --opa-a: 0.06; --opa-b: 0.15; --tx: 22px; --ty: 0px;
}

/* ── Diagonal light beam ───────────────────────────────────────── */
/*
 * A wide, rotated pseudo-line. Only opacity animates → compositor.
 * scaleX is set once and never changes (transform is initial only,
 * then only opacity pulses — so there is NO layout cost).
 */
.lms-light-beam {
    position: absolute;
    top: -100%;
    left: 36%;
    width: 2px;
    height: 200%;
    background: linear-gradient(
        to bottom,
        transparent 0%,
        rgba(74,222,128,0.06) 28%,
        rgba(74,222,128,0.13) 50%,
        rgba(74,222,128,0.06) 72%,
        transparent 100%
    );
    /* Static rotate + wide scale — set once, never re-animated */
    transform: rotate(-24deg) scaleX(100);
    transform-origin: top center;
    will-change: opacity;
    animation: lms-beam-pulse 7s ease-in-out infinite alternate;
}
@keyframes lms-beam-pulse {
    0%   { opacity: 0.35; }
    100% { opacity: 0.75; }
}

/* ── Shimmer scanline ──────────────────────────────────────────── */
/*
 * Uses `top` (not translateY) so it crosses 100% of the hero height.
 * Fades in/out via opacity at the extremes so the loop jump is
 * invisible. Isolated layer via will-change.
 *
 * NOTE: animating `top` does trigger paint in older browsers.
 * In modern Chromium/Firefox it's promoted automatically because
 * it accompanies opacity. If you see jank on older devices, swap
 * to translateY and cap height to 100vh.
 */
.lms-shimmer-line {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(
        90deg,
        transparent,
        rgba(74,222,128,0.18),
        rgba(74,222,128,0.40) 50%,
        rgba(74,222,128,0.18),
        transparent
    );
    will-change: transform, opacity;
    animation: lms-scan-line 9s ease-in-out infinite;
}
@keyframes lms-scan-line {
    0%   { transform: translateY(0);    opacity: 0; }
    6%   { opacity: 1; }
    94%  { opacity: 1; }
    100% { transform: translateY(520px); opacity: 0; }
}

/* ── SVG Particle container ────────────────────────────────────── */
.lms-particles {
    position: absolute;
    inset: 0;
    overflow: hidden;
    /* Entire container on its own GPU layer */
    will-change: transform;
    transform: translateZ(0);
}
.lms-particles svg {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
}

/* ── Noise grain (unchanged) ───────────────────────────────────── */
.lms-canvas-noise {
    position: absolute;
    inset: 0;
    opacity: 0.015;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    background-size: 200px;
}

/* ── Reduced-motion override ───────────────────────────────────── */
/*
 * Respects the OS-level "reduce motion" preference.
 * All CSS animations are paused; SVG SMIL is unaffected
 * (browsers handle that separately).
 */
@media (prefers-reduced-motion: reduce) {
    .lms-bg-grid,
    .lms-orb,
    .lms-light-beam,
    .lms-shimmer-line {
        animation: none;
    }
    /* Freeze orbs at their mid opacity so bg still looks rich */
    .lms-orb { opacity: 0.25; }
    .lms-light-beam { opacity: 0.55; }
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  LEFT SIDE
   ╚══════════════════════════════════════════════════════════════════ */
.lms-hero-left {
    position: relative;
    z-index: 2;
    flex: 0 0 auto;
    width: 100%;
    padding: 3.5rem 1.5rem 3.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 0;
}
@media (min-width: 840px) {
    .lms-hero-left { width: 50%; padding: 4.5rem 4rem 4.5rem 3.5rem; }
}
@media (min-width: 1100px) {
    .lms-hero-left { width: 45%; padding: 5rem 4rem 5rem 4.5rem; }
}
@media (min-width: 1400px) {
    .lms-hero-left { padding-left: 5.5rem; }
}

/* Pill tag */
.lms-hero-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.3rem 0.85rem;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.13);
    border-radius: var(--r-full);
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: rgba(255,255,255,0.55);
    text-transform: uppercase;
    margin-bottom: 1.5rem;
    width: fit-content;
}
.lms-pill-live {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--g300);
    box-shadow: 0 0 0 0 rgba(74,222,128,0.5);
    animation: lms-ping 2s infinite;
}
@keyframes lms-ping {
    0%   { box-shadow: 0 0 0 0 rgba(74,222,128,0.6); }
    70%  { box-shadow: 0 0 0 7px rgba(74,222,128,0); }
    100% { box-shadow: 0 0 0 0 rgba(74,222,128,0); }
}
.lms-pill-sep { opacity: 0.3; }

/* Heading */
.lms-hero-heading {
    font-size: clamp(2rem, 5.5vw, 3.8rem);
    font-weight: 900;
    line-height: 1.05;
    letter-spacing: -0.03em;
    color: #fff;
    margin-bottom: 1.25rem;
    max-width: 18ch;
}
.lms-heading-accent {
    color: var(--g300);
    position: relative;
    display: inline-block;
    white-space: nowrap;
}
.lms-heading-underline {
    position: absolute;
    bottom: -6px;
    left: 0;
    width: 100%;
    height: 12px;
    overflow: visible;
}

/* Body */
.lms-hero-body {
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.75;
    color: rgba(255,255,255,0.5);
    max-width: 46ch;
    margin-bottom: 2rem;
}
@media (min-width: 640px) { .lms-hero-body { font-size: 0.95rem; } }

/* ╔══════════════════════════════════════════════════════════════════
   ║  SEARCH CARD
   ╚══════════════════════════════════════════════════════════════════ */
.lms-search-form {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
    margin-bottom: 2rem;
}
.lms-search-card {
    position: relative;
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.08);
    border: 1.5px solid rgba(255,255,255,0.14);
    border-radius: var(--r-xl);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    transition: border-color var(--t-base), box-shadow var(--t-base), background var(--t-base);
    overflow: hidden;
}
.lms-search-card:focus-within {
    border-color: rgba(74,222,128,0.55);
    background: rgba(255,255,255,0.11);
    box-shadow: var(--s-glow), 0 8px 32px rgba(0,0,0,0.2);
}
.lms-search-icon-wrap {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 1.15rem;
}
.lms-search-ico {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.35);
    transition: color var(--t-fast);
}
.lms-search-card:focus-within .lms-search-ico { color: var(--g300); }
.lms-search-input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    padding: 1.05rem 0.5rem;
    font-family: var(--font);
    font-size: 0.9rem;
    font-weight: 500;
    color: #fff;
    min-width: 0;
}
.lms-search-input::placeholder { color: rgba(255,255,255,0.3); font-weight: 400; }
.lms-search-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
    margin: 0.4rem;
    padding: 0.65rem 1.35rem;
    background: linear-gradient(135deg, var(--g400), var(--g500));
    color: var(--ink);
    border: none;
    border-radius: var(--r-md);
    font-family: var(--font);
    font-size: 0.72rem;
    font-weight: 800;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all var(--t-base);
    box-shadow: 0 3px 12px rgba(34,197,94,0.3);
    white-space: nowrap;
}
.lms-search-submit:hover {
    background: linear-gradient(135deg, var(--g300), var(--g400));
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(34,197,94,0.4);
}

/* Filter strip */
.lms-filter-strip {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex-wrap: wrap;
}
.lms-filter-chip-wrap {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.5rem 0.9rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: var(--r-md);
    backdrop-filter: blur(8px);
    transition: border-color var(--t-fast);
    cursor: pointer;
}
.lms-filter-chip-wrap:focus-within { border-color: rgba(74,222,128,0.35); }
.lms-ico-muted { font-size: 0.65rem; color: rgba(255,255,255,0.35); flex-shrink: 0; }
.lms-filter-group { display: flex; flex-direction: column; gap: 0; }
.lms-filter-micro {
    font-size: 0.5rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.3);
    line-height: 1;
    margin-bottom: 2px;
}
.lms-filter-sel {
    background: transparent;
    border: none;
    outline: none;
    font-family: var(--font);
    font-size: 0.74rem;
    font-weight: 700;
    color: rgba(255,255,255,0.85);
    cursor: pointer;
    -webkit-appearance: none;
    appearance: none;
    padding-right: 0.5rem;
}
.lms-filter-sel option { background: var(--g800); color: #fff; }
.lms-apply-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.52rem 1.1rem;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.16);
    border-radius: var(--r-md);
    font-family: var(--font);
    font-size: 0.68rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    color: rgba(255,255,255,0.75);
    cursor: pointer;
    transition: all var(--t-fast);
}
.lms-apply-btn:hover { background: rgba(255,255,255,0.14); color: #fff; border-color: rgba(255,255,255,0.25); }
.lms-reset-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.52rem 0.9rem;
    background: rgba(239,68,68,0.1);
    border: 1px solid rgba(239,68,68,0.22);
    border-radius: var(--r-md);
    font-size: 0.68rem;
    font-weight: 700;
    color: #FCA5A5;
    text-decoration: none;
    transition: all var(--t-fast);
    cursor: pointer;
}
.lms-reset-btn:hover { background: rgba(239,68,68,0.18); color: #FECACA; }

/* Stats */
.lms-hero-stats { display: flex; align-items: center; gap: 1.5rem; }
.lms-stat { display: flex; flex-direction: column; gap: 1px; }
.lms-stat-num { font-size: 1.4rem; font-weight: 900; color: #fff; line-height: 1; letter-spacing: -0.03em; }
.lms-stat-lbl { font-size: 0.58rem; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: rgba(255,255,255,0.38); }
.lms-stat-divider { width: 1px; height: 28px; background: rgba(255,255,255,0.12); }

/* ╔══════════════════════════════════════════════════════════════════
   ║  RIGHT SIDE (DECO)
   ╚══════════════════════════════════════════════════════════════════ */
.lms-hero-right {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    position: relative;
    z-index: 2;
}
@media (max-width: 839px) {
    .lms-hero-right {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0;
        order: -1;
    }
}
@media (min-width: 840px)  { .lms-hero-right { flex: 1 1 0%; padding: 4rem 3.5rem 4rem 0; } }
@media (min-width: 1400px) { .lms-hero-right { padding-right: 5.5rem; } }

.lms-mobile-sep { display: none; }
@media (max-width: 839px) {
    .lms-mobile-sep {
        display: block;
        height: 12px;
        background: linear-gradient(to bottom, #f8fafc, #f1f5f9);
        border-top: 1px solid rgba(0,0,0,0.05);
        border-bottom: 1px solid rgba(0,0,0,0.05);
        width: 100%;
        position: relative;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
    }
    .lms-mobile-sep::after {
        content: '';
        position: absolute;
        top: 50%; left: 50%;
        transform: translate(-50%, -50%);
        width: 40px; height: 4px;
        background: #e2e8f0;
        border-radius: var(--r-full);
        opacity: 0.8;
    }
}

.lms-deco-frame {
    position: relative;
    width: 100%;
    max-width: 480px;
    aspect-ratio: 4/5;
    background: #fff;
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: var(--r-2xl);
    overflow: hidden;
    box-shadow: var(--s4);
}
@media (max-width: 839px) {
    .lms-deco-frame {
        width: 100%;
        max-width: 100%;
        aspect-ratio: auto;
        min-height: 400px;
        border-radius: 0;
        border-left: none;
        border-right: none;
        border-top: none;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
}
.lms-deco-img { width: 100%; height: 100%; object-fit: contain; background: transparent; }

/* ╔══════════════════════════════════════════════════════════════════
   ║  RAIL
   ╚══════════════════════════════════════════════════════════════════ */
.lms-rail {
    background: #fff;
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 10;
}
.lms-rail-inner {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
}
@media (min-width: 1400px) { .lms-rail-inner { padding-left: 5.5rem; padding-right: 5.5rem; } }
.lms-rail-left { display: flex; flex-direction: column; gap: 1px; }
.lms-rail-label { font-size: 0.875rem; font-weight: 700; color: var(--ink); }
.lms-rail-label strong { color: var(--g500); font-style: normal; }
.lms-rail-sub { font-size: 0.65rem; font-weight: 500; color: var(--quiet); }
.lms-rail-badge { display: flex; align-items: baseline; gap: 0.3rem; flex-shrink: 0; }
.lms-rail-num { font-size: 1.6rem; font-weight: 900; color: var(--ink); line-height: 1; letter-spacing: -0.04em; }
.lms-rail-unit { font-size: 0.6rem; font-weight: 600; letter-spacing: 0.12em; text-transform: uppercase; color: var(--muted); }

/* ╔══════════════════════════════════════════════════════════════════
   ║  GRID
   ╚══════════════════════════════════════════════════════════════════ */
.lms-grid {
    width: 100%;
    max-width: 100%;
    margin: 0 auto;
    padding: 2rem 1.5rem 6rem;
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}
@media (min-width: 1400px) {
    .lms-grid { padding-left: 5.5rem; padding-right: 5.5rem; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); }
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  CARD
   ╚══════════════════════════════════════════════════════════════════ */
.lms-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-xl);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    box-shadow: var(--s2);
    transition: transform var(--t-slow), box-shadow var(--t-base), border-color var(--t-base);
    opacity: 0;
    animation: lms-card-in 0.5s calc(var(--i, 0) * 60ms) ease both;
}
@keyframes lms-card-in {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
.lms-card:hover {
    transform: translateY(-6px) scale(1.005);
    box-shadow: var(--s4);
    border-color: rgba(30,145,82,0.2);
}

/* Thumbnail */
.lms-thumb-link { display: block; text-decoration: none; outline-offset: -2px; }
.lms-thumb { position: relative; height: 210px; overflow: hidden; background: var(--g100); }
.lms-thumb-img {
    position: absolute; inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.7s cubic-bezier(0.4,0,0.2,1);
}
.lms-card:hover .lms-thumb-img { transform: scale(1.08); }
.lms-thumb-vignette {
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 70% 30%, transparent 40%, rgba(0,0,0,0.18) 100%);
    z-index: 1;
}
.lms-thumb-scrim {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(5,46,23,0.72) 0%, rgba(5,46,23,0.18) 45%, transparent 70%);
    z-index: 2;
}

/* Status ribbon */
.lms-ribbon {
    position: absolute; top: 0; right: 0; z-index: 5;
    display: inline-flex; align-items: center; gap: 0.35rem;
    padding: 0.35rem 0.8rem 0.35rem 0.6rem;
    border-bottom-left-radius: var(--r-md);
    font-size: 0.58rem; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase;
}
.lms-ribbon-done { background: linear-gradient(135deg, #D97706, #FBBF24); color: #fff; box-shadow: 0 2px 8px rgba(217,119,6,0.4); }
.lms-ribbon-wip  { background: linear-gradient(135deg, var(--g500), var(--g400)); color: #fff; box-shadow: 0 2px 8px rgba(30,145,82,0.35); }

/* Badge row */
.lms-badge-row { position: absolute; top: 0.75rem; left: 0.75rem; z-index: 5; display: flex; flex-direction: column; gap: 0.3rem; align-items: flex-start; }
.lms-badge-type { display: inline-block; padding: 0.24rem 0.6rem; border-radius: var(--r-full); font-size: 0.5rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; backdrop-filter: blur(10px); }
.lms-type-green   { background: rgba(34,197,94,0.9);   color: #fff; }
.lms-type-emerald { background: rgba(16,185,129,0.9);  color: #fff; }
.lms-type-teal    { background: rgba(20,184,166,0.9);  color: #fff; }
.lms-type-lime    { background: rgba(132,204,22,0.9);  color: #fff; }
.lms-type-orange  { background: rgba(249,115,22,0.9);  color: #fff; }
.lms-type-red     { background: rgba(239,68,68,0.9);   color: #fff; }
.lms-type-yellow  { background: rgba(234,179,8,0.9);   color: #1a1a1a; }
.lms-type-blue    { background: rgba(59,130,246,0.9);  color: #fff; }
.lms-type-purple  { background: rgba(168,85,247,0.9);  color: #fff; }
.lms-type-gray    { background: rgba(107,114,128,0.88);color: #fff; }
.lms-badge-label {
    display: inline-block; padding: 0.2rem 0.55rem; border-radius: var(--r-full);
    font-size: 0.48rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
    background: rgba(255,255,255,0.16); color: rgba(255,255,255,0.9);
    border: 1px solid rgba(255,255,255,0.24); backdrop-filter: blur(8px);
}

/* Thumb meta */
.lms-thumb-meta { position: absolute; bottom: 0.75rem; left: 0.75rem; right: 0.75rem; z-index: 5; display: flex; align-items: center; justify-content: space-between; }
.lms-chapter-pill { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.28rem 0.7rem; background: rgba(0,0,0,0.38); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.12); border-radius: var(--r-full); font-size: 0.58rem; font-weight: 700; color: rgba(255,255,255,0.9); }
.lms-chapter-pill .fas { font-size: 0.48rem; color: var(--g300); }
.lms-ring { position: relative; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.lms-ring-svg { position: absolute; inset: 0; transform: rotate(-90deg); width: 100%; height: 100%; }
.lms-ring-text { position: relative; z-index: 1; font-size: 0.5rem; font-weight: 800; color: #fff; text-shadow: 0 1px 4px rgba(0,0,0,0.5); }

/* Card body */
.lms-card-body { padding: 1.15rem 1.25rem 1.25rem; display: flex; flex-direction: column; flex: 1; gap: 0.55rem; }
.lms-school-tag { display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.62rem; font-weight: 600; color: var(--g500); }
.lms-school-tag .fas { font-size: 0.55rem; }
.lms-card-title { font-size: 0.975rem; font-weight: 800; line-height: 1.35; color: var(--ink); margin: 0; display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: calc(0.975rem * 1.35 * 2); }
.lms-title-link { color: inherit; text-decoration: none; transition: color var(--t-fast); }
.lms-card:hover .lms-title-link { color: var(--g500); }
.lms-card-desc { font-size: 0.75rem; font-weight: 400; line-height: 1.65; color: var(--muted); display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.lms-spacer { flex: 1; }

/* Progress */
.lms-progress { display: flex; flex-direction: column; gap: 0.35rem; padding: 0.75rem; background: var(--g50); border: 1px solid var(--g100); border-radius: var(--r-md); }
.lms-progress-meta { display: flex; align-items: center; justify-content: space-between; }
.lms-progress-label { font-size: 0.58rem; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: var(--muted); }
.lms-progress-pct { font-size: 0.68rem; font-weight: 800; color: var(--g600); letter-spacing: -0.01em; }
.lms-pct-done { color: var(--gold); }
.lms-progress-track { height: 5px; background: var(--g100); border-radius: var(--r-full); overflow: hidden; }
.lms-progress-fill { height: 100%; width: var(--pct, 0%); background: linear-gradient(90deg, var(--g500), var(--g300)); border-radius: var(--r-full); transition: width 1s cubic-bezier(0.4,0,0.2,1); position: relative; }
.lms-progress-fill::after { content: ''; position: absolute; right: 0; top: 50%; transform: translateY(-50%); width: 5px; height: 5px; border-radius: 50%; background: inherit; box-shadow: 0 0 6px rgba(74,222,128,0.5); }
.lms-fill-done { background: linear-gradient(90deg, var(--gold), var(--gold-lt)); }
.lms-fill-done::after { box-shadow: 0 0 6px rgba(251,191,36,0.5); }
.lms-progress-foot { display: flex; align-items: center; justify-content: space-between; font-size: 0.6rem; font-weight: 500; color: var(--quiet); }
.lms-done-tag { display: inline-flex; align-items: center; gap: 0.25rem; font-size: 0.55rem; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; color: var(--gold); }
.lms-done-tag .fas { font-size: 0.5rem; }

/* CTA */
.lms-cta { display: flex; align-items: center; justify-content: space-between; padding: 0.8rem 1rem; border-radius: var(--r-lg); font-family: var(--font); font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em; text-transform: uppercase; text-decoration: none; transition: all var(--t-base); position: relative; overflow: hidden; margin-top: 0.15rem; }
.lms-cta::before { content: ''; position: absolute; inset: 0; background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.12) 50%, transparent 100%); transform: translateX(-120%); transition: transform 0.5s ease; }
.lms-cta:hover::before { transform: translateX(120%); }
.lms-cta-start  { background: linear-gradient(135deg, var(--g700), var(--g600)); color: #fff; box-shadow: 0 4px 16px rgba(13,92,52,0.28); }
.lms-cta-start:hover  { background: linear-gradient(135deg, var(--g600), var(--g500)); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(13,92,52,0.36); }
.lms-cta-resume { background: linear-gradient(135deg, var(--g500), var(--g400)); color: var(--ink); box-shadow: 0 4px 16px rgba(30,145,82,0.28); }
.lms-cta-resume:hover { background: linear-gradient(135deg, var(--g400), var(--g300)); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(30,145,82,0.36); }
.lms-cta-done   { background: linear-gradient(135deg, #92400E, var(--gold)); color: #fff; box-shadow: 0 4px 16px rgba(217,119,6,0.28); }
.lms-cta-done:hover   { background: linear-gradient(135deg, var(--gold), #FDE68A); transform: translateY(-1px); box-shadow: 0 8px 24px rgba(217,119,6,0.36); }
.lms-cta-inner { display: flex; align-items: center; gap: 0.45rem; }
.lms-cta-inner .fas { font-size: 0.72rem; }
.lms-cta-arrow { width: 26px; height: 26px; border-radius: 50%; background: rgba(255,255,255,0.18); display: flex; align-items: center; justify-content: center; font-size: 0.58rem; flex-shrink: 0; transition: transform var(--t-fast); }
.lms-cta:hover .lms-cta-arrow { transform: translateX(2px); }

/* ╔══════════════════════════════════════════════════════════════════
   ║  EMPTY STATE
   ╚══════════════════════════════════════════════════════════════════ */
.lms-empty { grid-column: 1 / -1; display: flex; flex-direction: column; align-items: center; gap: 1rem; padding: 5rem 1.5rem 6rem; text-align: center; }
.lms-empty-visual { position: relative; width: 100px; height: 100px; margin-bottom: 0.5rem; }
.lms-empty-rings { position: absolute; inset: 50%; transform: translate(-50%, -50%); }
.lms-er { position: absolute; border-radius: 50%; border: 1px solid var(--g200); top: 50%; left: 50%; transform: translate(-50%, -50%); }
.lms-er1 { width: 80px;  height: 80px;  border-color: rgba(30,145,82,0.15); }
.lms-er2 { width: 140px; height: 140px; border-color: rgba(30,145,82,0.08); border-style: dashed; }
.lms-er3 { width: 200px; height: 200px; border-color: rgba(30,145,82,0.04); }
.lms-empty-ico { position: relative; z-index: 2; width: 56px; height: 56px; background: var(--g50); border: 2px solid var(--g100); border-radius: var(--r-lg); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--g500); margin: 22px auto 0; box-shadow: var(--s2); }
.lms-empty-title { font-size: 1.4rem; font-weight: 800; color: var(--ink); letter-spacing: -0.02em; margin: 0; }
.lms-empty-body { font-size: 0.84rem; font-weight: 400; line-height: 1.7; color: var(--muted); max-width: 38ch; margin: 0; }
.lms-empty-body strong { color: var(--ink); font-weight: 700; }
.lms-empty-cta { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.75rem; background: var(--g700); color: #fff; border-radius: var(--r-lg); font-size: 0.74rem; font-weight: 700; text-decoration: none; letter-spacing: 0.04em; box-shadow: 0 4px 16px rgba(13,92,52,0.26); transition: all var(--t-base); margin-top: 0.5rem; }
.lms-empty-cta:hover { background: var(--g600); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(13,92,52,0.34); }

/* ╔══════════════════════════════════════════════════════════════════
   ║  MOBILE OVERRIDES
   ╚══════════════════════════════════════════════════════════════════ */
@media (max-width: 559px) {
    .lms-hero-left    { padding: 2rem 1.25rem 3rem; }
    .lms-hero-heading { font-size: 2rem; }
    .lms-thumb        { height: 180px; }
    .lms-card-body    { padding: 1rem 1rem 1.1rem; }
    .lms-grid         { padding: 1.5rem 1rem 5rem; gap: 1.1rem; }
    .lms-cta          { padding: 0.85rem 1rem; }
    .lms-search-submit span { display: none; }
    .lms-hero-stats   { gap: 1rem; }
    .lms-stat-num     { font-size: 1.2rem; }
    /* Reduce scan line height on mobile to match hero height */
    @keyframes lms-scan-line {
        0%   { transform: translateY(0);    opacity: 0; }
        6%   { opacity: 1; }
        94%  { opacity: 1; }
        100% { transform: translateY(420px); opacity: 0; }
    }
}
</style>

@endsection