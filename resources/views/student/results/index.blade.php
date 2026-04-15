@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

@php
    $totalResults = $results->count();
    $passCount    = $results->where('score', '>=', 70)->count();
    $avgScore     = $totalResults > 0 ? (int) round($results->avg('score')) : 0;
    $bestScore    = $totalResults > 0 ? (int) $results->max('score') : 0;
    $passRate     = $totalResults > 0 ? (int) round(($passCount / $totalResults) * 100) : 0;
@endphp

<div class="rs-root">

    {{-- ══════════════════════════════════════════════════════════════
         HERO
    ══════════════════════════════════════════════════════════════ --}}
    <section class="rs-hero">

        <div class="rs-canvas" aria-hidden="true">
            <div class="rs-canvas-mesh"></div>
            <div class="rs-orb rs-orb-a"></div>
            <div class="rs-orb rs-orb-b"></div>
            <div class="rs-orb rs-orb-c"></div>
            <div class="rs-canvas-noise"></div>
        </div>

        <div class="rs-hero-inner">

            {{-- Left --}}
            <div class="rs-hero-left">

                <div class="rs-hero-pill">
                    <span class="rs-pill-live"></span>
                    <span>Monitoring Akademis</span>
                    <span class="rs-pill-sep">·</span>
                    <span>{{ now()->translatedFormat('d M Y') }}</span>
                </div>

                <h1 class="rs-hero-heading">
                    Capaian
                    <span class="rs-heading-accent">
                        Belajarmu
                        <svg class="rs-heading-line" viewBox="0 0 200 12" preserveAspectRatio="none" aria-hidden="true">
                            <path d="M3 9 C50 3, 150 3, 197 9" stroke="url(#rlu)" stroke-width="3.5" fill="none" stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="rlu" x1="0" y1="0" x2="1" y2="0">
                                    <stop offset="0%" stop-color="#4ADE80"/>
                                    <stop offset="100%" stop-color="#34D399" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                </h1>

                <p class="rs-hero-body">
                    Pantau hasil evaluasi dan perkembangan belajarmu untuk tetap termotivasi dalam misi gizi nasional.
                </p>

                {{-- Pass rate inline stat --}}
                <div class="rs-hero-rate-wrap">
                    <div class="rs-rate-track">
                        <div class="rs-rate-fill" style="--p: {{ $passRate }}%"></div>
                    </div>
                    <div class="rs-rate-labels">
                        <span class="rs-rate-label">Tingkat Kelulusan</span>
                        <span class="rs-rate-val {{ $passRate >= 70 ? 'rs-rate-good' : ($passRate >= 40 ? 'rs-rate-mid' : 'rs-rate-low') }}">
                            {{ $passRate }}%
                        </span>
                    </div>
                </div>

                <a href="{{ route('courses.index') }}" class="rs-hero-cta">
                    <span class="rs-cta-icon"><i class="fas fa-rocket"></i></span>
                    <span>Belajar Lagi</span>
                    <span class="rs-cta-arrow"><i class="fas fa-arrow-right"></i></span>
                </a>

            </div>

            {{-- Right: Score ring --}}
            <div class="rs-hero-right" aria-hidden="true">
                <div class="rs-score-ring-wrap">

                    {{-- Decorative rings --}}
                    <div class="rs-ring-deco rs-ring-d1"></div>
                    <div class="rs-ring-deco rs-ring-d2"></div>
                    <div class="rs-ring-deco rs-ring-d3"></div>

                    {{-- Main ring SVG --}}
                    <div class="rs-ring-main">
                        <svg viewBox="0 0 200 200" class="rs-ring-svg">
                            {{-- Background track --}}
                            <circle cx="100" cy="100" r="82"
                                fill="none"
                                stroke="rgba(255,255,255,0.07)"
                                stroke-width="12"/>
                            {{-- Progress arc --}}
                            <circle cx="100" cy="100" r="82"
                                fill="none"
                                stroke="url(#ringGrad)"
                                stroke-width="12"
                                stroke-dasharray="{{ $avgScore * 5.15 }} {{ (100 - $avgScore) * 5.15 }}"
                                stroke-dashoffset="128.75"
                                stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="ringGrad" x1="0" y1="0" x2="1" y2="1">
                                    <stop offset="0%" stop-color="#4ADE80"/>
                                    <stop offset="100%" stop-color="#22C55E"/>
                                </linearGradient>
                            </defs>
                        </svg>
                        <div class="rs-ring-center">
                            <span class="rs-ring-num">{{ $avgScore }}</span>
                            <span class="rs-ring-label">Rata-rata</span>
                            <span class="rs-ring-sub">dari 100 poin</span>
                        </div>
                    </div>

                    {{-- Floating stat chips --}}
                    <div class="rs-fchip rs-fchip-top">
                        <i class="fas fa-trophy"></i>
                        <div>
                            <div class="rs-fchip-val">{{ $bestScore }}</div>
                            <div class="rs-fchip-lbl">Terbaik</div>
                        </div>
                    </div>
                    <div class="rs-fchip rs-fchip-bot">
                        <i class="fas fa-check-circle"></i>
                        <div>
                            <div class="rs-fchip-val">{{ $passCount }}/{{ $totalResults }}</div>
                            <div class="rs-fchip-lbl">Lulus</div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         KPI RAIL
    ══════════════════════════════════════════════════════════════ --}}
    <div class="rs-kpi-rail">
        <div class="rs-kpi-inner">

            <div class="rs-kpi rs-kpi-1">
                <div class="rs-kpi-icon"><i class="fas fa-file-pen"></i></div>
                <div class="rs-kpi-body">
                    <div class="rs-kpi-num">{{ $totalResults }}</div>
                    <div class="rs-kpi-lbl">Total Ujian</div>
                </div>
                <div class="rs-kpi-glow"></div>
            </div>

            <div class="rs-kpi-div" aria-hidden="true"></div>

            <div class="rs-kpi rs-kpi-2">
                <div class="rs-kpi-icon"><i class="fas fa-circle-check"></i></div>
                <div class="rs-kpi-body">
                    <div class="rs-kpi-num">{{ $passCount }}</div>
                    <div class="rs-kpi-lbl">Lulus</div>
                </div>
                <div class="rs-kpi-glow"></div>
            </div>

            <div class="rs-kpi-div" aria-hidden="true"></div>

            <div class="rs-kpi rs-kpi-3">
                <div class="rs-kpi-icon"><i class="fas fa-chart-simple"></i></div>
                <div class="rs-kpi-body">
                    <div class="rs-kpi-num">{{ $avgScore }}</div>
                    <div class="rs-kpi-lbl">Rata-rata</div>
                </div>
                <div class="rs-kpi-glow"></div>
            </div>

            <div class="rs-kpi-div" aria-hidden="true"></div>

            <div class="rs-kpi rs-kpi-4">
                <div class="rs-kpi-icon"><i class="fas fa-medal"></i></div>
                <div class="rs-kpi-body">
                    <div class="rs-kpi-num">{{ $bestScore }}</div>
                    <div class="rs-kpi-lbl">Skor Terbaik</div>
                </div>
                <div class="rs-kpi-glow"></div>
            </div>

        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         RESULTS TABLE
    ══════════════════════════════════════════════════════════════ --}}
    <div class="rs-content">

        <div class="rs-section-head">
            <div class="rs-section-left">
                <div class="rs-section-tag">Riwayat Nilai</div>
                <h2 class="rs-section-title">Hasil <em>Pretest &amp; Posttest</em></h2>
            </div>
            <a href="{{ route('courses.index') }}" class="rs-top-link">
                <i class="fas fa-arrow-left"></i>
                Kembali Belajar
            </a>
        </div>

        {{-- ── PRE TEST section ──────────────────────────────────── --}}
        @if(isset($preResults) && $preResults->count() > 0)
        <div class="rs-sub-head">
            <div class="rs-sub-badge rs-sub-pre">
                <i class="fas fa-clipboard-list"></i>
                Nilai Pre Test
            </div>
        </div>
        <div class="rs-table-card" style="margin-bottom:1.5rem;">
            @foreach($preResults as $i => $result)
                @php
                    $pass    = $result->score >= 70;
                    $s       = (int) $result->score;
                    $grade   = $s >= 90 ? 'A' : ($s >= 80 ? 'B' : ($s >= 70 ? 'C' : ($s >= 60 ? 'D' : 'E')));
                    $gradeColor = $s >= 70 ? 'rs-grade-pass' : 'rs-grade-fail';
                @endphp
                <div class="rs-row" style="--i: {{ $i }}">
                    <div class="rs-grade-col">
                        <div class="rs-grade {{ $gradeColor }}">{{ $grade }}</div>
                    </div>
                    <div class="rs-info-col">
                        <div class="rs-row-meta">
                            <span class="rs-row-date"><i class="fas fa-calendar-days"></i> {{ $result->created_at->format('d M Y') }}</span>
                            <span class="rs-row-time"><i class="fas fa-clock"></i> {{ $result->created_at->format('H:i') }}</span>
                        </div>
                        <div class="rs-row-title">{{ $result->course->title }}</div>
                        <div class="rs-row-progress">
                            <div class="rs-row-track">
                                <div class="rs-row-fill" style="--pct: {{ $s }}%; background:linear-gradient(90deg,#D97706,#F59E0B);"></div>
                            </div>
                        </div>
                    </div>
                    <div class="rs-score-col">
                        <div class="rs-score-wrap">
                            <span class="rs-score-num" style="color:#D97706;">{{ $s }}</span>
                            <span class="rs-score-pts">pts</span>
                        </div>
                        <div class="rs-badge" style="background:rgba(217,119,6,0.1);color:#D97706;border-color:rgba(217,119,6,0.2);">
                            <i class="fas fa-clipboard-check"></i> Pre Test
                        </div>
                    </div>
                    <div class="rs-action-col">
                        <a href="{{ route('results.show', $result->id) }}" class="rs-detail-btn">
                            <span>Detail</span><i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        {{-- ── POST TEST section ─────────────────────────────────── --}}
        <div class="rs-sub-head">
            <div class="rs-sub-badge rs-sub-post">
                <i class="fas fa-trophy"></i>
                Nilai Post Test
            </div>
        </div>

        <div class="rs-table-card">

            @forelse($results as $i => $result)
                @php
                    $pass    = $result->score >= 70;
                    $s       = (int) $result->score;
                    $grade   = $s >= 90 ? 'A' : ($s >= 80 ? 'B' : ($s >= 70 ? 'C' : ($s >= 60 ? 'D' : 'E')));
                    $gradeColor = $s >= 70 ? 'rs-grade-pass' : 'rs-grade-fail';
                @endphp

                <div class="rs-row {{ $pass ? '' : 'rs-row-fail' }}" style="--i: {{ $i }}">

                    {{-- Grade badge --}}
                    <div class="rs-grade-col">
                        <div class="rs-grade {{ $gradeColor }}">{{ $grade }}</div>
                    </div>

                    {{-- Info --}}
                    <div class="rs-info-col">
                        <div class="rs-row-meta">
                            <span class="rs-row-date">
                                <i class="fas fa-calendar-days"></i>
                                {{ $result->created_at->format('d M Y') }}
                            </span>
                            <span class="rs-row-time">
                                <i class="fas fa-clock"></i>
                                {{ $result->created_at->format('H:i') }}
                            </span>
                        </div>
                        <div class="rs-row-title">{{ $result->course->title }}</div>
                        <div class="rs-row-progress">
                            <div class="rs-row-track">
                                <div class="rs-row-fill {{ $pass ? 'rs-fill-pass' : 'rs-fill-fail' }}"
                                     style="--pct: {{ $s }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Score + status --}}
                    <div class="rs-score-col">
                        <div class="rs-score-wrap">
                            <span class="rs-score-num {{ $pass ? 'rs-score-pass' : 'rs-score-fail' }}">{{ $s }}</span>
                            <span class="rs-score-pts">pts</span>
                        </div>
                        <div class="rs-badge {{ $pass ? 'rs-badge-pass' : 'rs-badge-fail' }}">
                            @if($pass)
                                <i class="fas fa-check"></i> Lulus
                            @else
                                <i class="fas fa-rotate-right"></i> Ulang
                            @endif
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="rs-action-col">
                        <a href="{{ route('results.show', $result->id) }}" class="rs-detail-btn">
                            <span>Detail</span>
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>

                </div>

            @empty

                <div class="rs-empty">
                    <div class="rs-empty-visual">
                        <div class="rs-er rs-er1"></div>
                        <div class="rs-er rs-er2"></div>
                        <div class="rs-er rs-er3"></div>
                        <div class="rs-empty-ico">
                            <i class="fas fa-magnifying-glass"></i>
                        </div>
                    </div>
                    <h3 class="rs-empty-title">Belum Ada Nilai</h3>
                    <p class="rs-empty-body">Selesaikan materi dan ambil post-test untuk melihat hasil belajarmu di sini.</p>
                    <a href="{{ route('courses.index') }}" class="rs-empty-cta">
                        <i class="fas fa-rocket"></i>
                        Mulai Belajar Sekarang
                    </a>
                </div>

            @endforelse
        </div>

    </div>

</div>{{-- rs-root --}}


<style>
/* ╔══════════════════════════════════════════════════════════════════
   ║  TOKENS — identical to courses & notifications
   ╚══════════════════════════════════════════════════════════════════ */
:root {
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

    --gold:    #D97706;
    --gold-lt: #FCD34D;
    --red:     #EF4444;
    --red-lt:  #FEE2E2;

    --ink:    #0C1A12;
    --muted:  #6B7280;
    --quiet:  #9CA3AF;
    --border: #E5E7EB;
    --surface:#F7FAF8;
    --white:  #FFFFFF;

    --s1: 0 1px 3px rgba(10,61,33,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --s2: 0 4px 16px rgba(10,61,33,0.08), 0 2px 6px rgba(0,0,0,0.04);
    --s3: 0 12px 36px rgba(10,61,33,0.12), 0 4px 12px rgba(0,0,0,0.06);
    --s4: 0 24px 56px rgba(10,61,33,0.16), 0 8px 24px rgba(0,0,0,0.08);
    --s-glow: 0 0 0 3px rgba(74,222,128,0.18);

    --font: 'Plus Jakarta Sans', system-ui, sans-serif;
    --r-sm: 8px;  --r-md: 12px; --r-lg: 16px;
    --r-xl: 20px; --r-2xl: 24px;--r-full: 9999px;
    --t-fast: 180ms cubic-bezier(0.4,0,0.2,1);
    --t-base: 260ms cubic-bezier(0.4,0,0.2,1);
    --t-slow: 400ms cubic-bezier(0.34,1.56,0.64,1);
}

/* ── Reset ── */
.rs-root *, .rs-root *::before, .rs-root *::after { box-sizing: border-box; }
.rs-root {
    font-family: var(--font);
    background: var(--surface);
    min-height: 100vh;
    margin: -1.5rem -1rem 0;
    overflow-x: hidden;
    color: var(--ink);
}
@media (min-width: 640px)  { .rs-root { margin: -2.5rem -1.5rem 0; } }
@media (min-width: 1024px) { .rs-root { margin: -2.5rem -2rem 0; } }

/* ╔══════════════════════════════════════════════════════════════════
   ║  HERO
   ╚══════════════════════════════════════════════════════════════════ */
.rs-hero {
    position: relative;
    background: var(--g800);
    overflow: hidden;
    padding: 3.5rem 1.5rem 3.5rem;
}
@media (min-width: 840px)  { .rs-hero { padding: 4.5rem 3.5rem; } }
@media (min-width: 1100px) { .rs-hero { padding: 5rem 4.5rem; } }

.rs-canvas { position: absolute; inset: 0; pointer-events: none; z-index: 1; }
.rs-canvas-mesh {
    position: absolute; inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 48px 48px;
}
.rs-orb { position: absolute; border-radius: 50%; filter: blur(96px); }
.rs-orb-a { width: 500px; height: 500px; background: radial-gradient(circle, rgba(34,197,94,0.13), transparent 70%); top: -180px; right: -80px; }
.rs-orb-b { width: 300px; height: 300px; background: radial-gradient(circle, rgba(217,119,6,0.08), transparent 70%); bottom: -80px; left: -60px; }
.rs-orb-c { width: 220px; height: 220px; background: radial-gradient(circle, rgba(74,222,128,0.1), transparent 70%); top: 50%; left: 38%; }
.rs-canvas-noise {
    position: absolute; inset: 0; opacity: 0.025;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    background-size: 200px;
}

.rs-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 3rem;
}

/* ─── Left ──────────────────────────────────────────────────────── */
.rs-hero-left {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 0;
}

.rs-hero-pill {
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
.rs-pill-live {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--g300);
    animation: rs-ping 2s infinite;
}
@keyframes rs-ping {
    0%   { box-shadow: 0 0 0 0 rgba(74,222,128,0.6); }
    70%  { box-shadow: 0 0 0 7px rgba(74,222,128,0); }
    100% { box-shadow: 0 0 0 0 rgba(74,222,128,0); }
}
.rs-pill-sep { opacity: 0.3; }

.rs-hero-heading {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 900;
    line-height: 1.08;
    letter-spacing: -0.03em;
    color: #fff;
    margin-bottom: 1.1rem;
}
.rs-heading-accent {
    color: var(--g300);
    position: relative;
    display: inline-block;
}
.rs-heading-line {
    position: absolute;
    bottom: -5px; left: 0;
    width: 100%; height: 12px;
    overflow: visible;
}

.rs-hero-body {
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.75;
    color: rgba(255,255,255,0.5);
    max-width: 44ch;
    margin-bottom: 1.75rem;
}

/* Pass rate bar */
.rs-hero-rate-wrap {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    margin-bottom: 1.75rem;
    max-width: 340px;
}
.rs-rate-labels {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.rs-rate-label {
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.38);
}
.rs-rate-val {
    font-size: 0.78rem;
    font-weight: 800;
    letter-spacing: -0.01em;
}
.rs-rate-good { color: var(--g300); }
.rs-rate-mid  { color: var(--gold-lt); }
.rs-rate-low  { color: #FCA5A5; }
.rs-rate-track {
    height: 5px;
    background: rgba(255,255,255,0.1);
    border-radius: var(--r-full);
    overflow: hidden;
}
.rs-rate-fill {
    height: 100%;
    width: var(--p, 0%);
    background: linear-gradient(90deg, var(--g500), var(--g300));
    border-radius: var(--r-full);
    transition: width 1.2s cubic-bezier(0.4,0,0.2,1);
}

/* CTA */
.rs-hero-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.7rem;
    padding: 0.82rem 1.3rem;
    background: rgba(255,255,255,0.08);
    border: 1.5px solid rgba(255,255,255,0.16);
    border-radius: var(--r-lg);
    font-size: 0.76rem;
    font-weight: 700;
    color: rgba(255,255,255,0.85);
    text-decoration: none;
    width: fit-content;
    backdrop-filter: blur(12px);
    transition: all var(--t-base);
    letter-spacing: 0.02em;
}
.rs-hero-cta:hover {
    background: rgba(255,255,255,0.14);
    border-color: rgba(74,222,128,0.4);
    color: #fff;
    box-shadow: var(--s-glow);
    transform: translateY(-1px);
}
.rs-cta-icon {
    width: 28px; height: 28px;
    background: linear-gradient(135deg, var(--g400), var(--g500));
    border-radius: var(--r-sm);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.7rem;
    color: var(--ink);
    flex-shrink: 0;
}
.rs-cta-arrow {
    margin-left: auto;
    width: 22px; height: 22px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.55rem;
    color: rgba(255,255,255,0.6);
    transition: transform var(--t-fast);
}
.rs-hero-cta:hover .rs-cta-arrow { transform: translateX(2px); }

/* ─── Right: Score ring ─────────────────────────────────────────── */
.rs-hero-right {
    flex-shrink: 0;
    display: none;
    position: relative;
}
@media (min-width: 800px) { .rs-hero-right { display: block; } }

.rs-score-ring-wrap {
    position: relative;
    width: 260px; height: 260px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Concentric decorative rings */
.rs-ring-deco {
    position: absolute;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.05);
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    animation: rs-spin-slow linear infinite;
}
.rs-ring-d1 { width: 300px; height: 300px; border-style: dashed; animation-duration: 30s; }
.rs-ring-d2 { width: 340px; height: 340px; animation-duration: 50s; animation-direction: reverse; }
.rs-ring-d3 { width: 240px; height: 240px; border-style: dashed; animation-duration: 20s; border-color: rgba(74,222,128,0.07); }
@keyframes rs-spin-slow {
    from { transform: translate(-50%, -50%) rotate(0deg); }
    to   { transform: translate(-50%, -50%) rotate(360deg); }
}

.rs-ring-main {
    position: relative;
    width: 200px; height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
}
.rs-ring-svg {
    position: absolute;
    inset: 0;
    transform: rotate(-90deg);
    filter: drop-shadow(0 0 10px rgba(74,222,128,0.25));
}
.rs-ring-center {
    position: relative;
    z-index: 3;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
    text-align: center;
}
.rs-ring-num {
    font-size: 3rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    letter-spacing: -0.05em;
}
.rs-ring-label {
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--g300);
}
.rs-ring-sub {
    font-size: 0.55rem;
    color: rgba(255,255,255,0.3);
    font-weight: 500;
}

/* Floating chips */
.rs-fchip {
    position: absolute;
    display: flex;
    align-items: center;
    gap: 0.55rem;
    padding: 0.6rem 0.9rem;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: var(--r-lg);
    box-shadow: 0 6px 24px rgba(0,0,0,0.2);
    z-index: 5;
}
.rs-fchip .fas {
    font-size: 0.8rem;
    flex-shrink: 0;
}
.rs-fchip-top {
    top: -8px;
    right: -30px;
    animation: rs-float 4s ease-in-out infinite;
}
.rs-fchip-top .fas { color: var(--gold-lt); }
.rs-fchip-bot {
    bottom: 4px;
    left: -36px;
    animation: rs-float 4s ease-in-out 2s infinite;
}
.rs-fchip-bot .fas { color: var(--g300); }
@keyframes rs-float {
    0%, 100% { transform: translateY(0); }
    50%       { transform: translateY(-6px); }
}
.rs-fchip-val {
    font-size: 0.82rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.rs-fchip-lbl {
    font-size: 0.55rem;
    color: rgba(255,255,255,0.45);
    font-weight: 600;
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  KPI RAIL
   ╚══════════════════════════════════════════════════════════════════ */
.rs-kpi-rail {
    background: var(--white);
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 30;
    box-shadow: 0 2px 16px rgba(10,61,33,0.06);
}
.rs-kpi-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: flex;
    align-items: stretch;
    overflow-x: auto;
    scrollbar-width: none;
}
.rs-kpi-inner::-webkit-scrollbar { display: none; }
@media (min-width: 640px) { .rs-kpi-inner { padding: 0 2rem; } }

.rs-kpi {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.9rem 0.5rem;
    position: relative;
    min-width: 110px;
    transition: background var(--t-fast);
}
.rs-kpi:hover { background: var(--g50); }
.rs-kpi-icon {
    width: 34px; height: 34px;
    border-radius: var(--r-md);
    display: flex; align-items: center; justify-content: center;
    font-size: 0.72rem;
    flex-shrink: 0;
}
.rs-kpi-1 .rs-kpi-icon { background: rgba(10,61,33,0.07); color: var(--g600); }
.rs-kpi-2 .rs-kpi-icon { background: var(--g50); color: var(--g500); }
.rs-kpi-3 .rs-kpi-icon { background: rgba(217,119,6,0.08); color: var(--gold); }
.rs-kpi-4 .rs-kpi-icon { background: rgba(59,130,246,0.08); color: #3B82F6; }

.rs-kpi-body { display: flex; flex-direction: column; gap: 1px; }
.rs-kpi-num {
    font-size: 1.35rem;
    font-weight: 900;
    color: var(--ink);
    line-height: 1;
    letter-spacing: -0.03em;
}
.rs-kpi-lbl {
    font-size: 0.58rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--muted);
}
.rs-kpi-glow {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    opacity: 0;
    transition: opacity var(--t-fast);
    border-radius: var(--r-full);
}
.rs-kpi-1 .rs-kpi-glow { background: linear-gradient(90deg, var(--g500), transparent); }
.rs-kpi-2 .rs-kpi-glow { background: linear-gradient(90deg, var(--g400), transparent); }
.rs-kpi-3 .rs-kpi-glow { background: linear-gradient(90deg, var(--gold), transparent); }
.rs-kpi-4 .rs-kpi-glow { background: linear-gradient(90deg, #3B82F6, transparent); }
.rs-kpi:hover .rs-kpi-glow { opacity: 1; }

.rs-kpi-div {
    width: 1px;
    background: var(--border);
    align-self: stretch;
    margin: 0.5rem 0;
    flex-shrink: 0;
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  CONTENT AREA
   ╚══════════════════════════════════════════════════════════════════ */
.rs-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2.5rem 1.5rem 6rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
@media (min-width: 640px) { .rs-content { padding: 2.5rem 2rem 6rem; } }
@media (min-width: 1024px) { .rs-content { padding: 3rem 2.5rem 7rem; } }

.rs-section-head {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1rem;
    animation: rs-fadein 0.4s ease both;
}
.rs-section-tag {
    font-size: 0.58rem;
    font-weight: 800;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--g500);
    margin-bottom: 0.2rem;
}
.rs-section-title {
    font-size: 1.25rem;
    font-weight: 900;
    color: var(--ink);
    letter-spacing: -0.02em;
    margin: 0;
    line-height: 1.2;
}
.rs-section-title em {
    font-style: normal;
    color: var(--g500);
}
.rs-top-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.7rem;
    font-weight: 700;
    color: var(--muted);
    text-decoration: none;
    letter-spacing: 0.04em;
    padding: 0.45rem 0.9rem;
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-md);
    transition: all var(--t-fast);
    flex-shrink: 0;
    box-shadow: var(--s1);
}
.rs-top-link:hover {
    color: var(--g500);
    border-color: var(--g200);
    background: var(--g50);
}
.rs-top-link .fas { font-size: 0.6rem; }

/* ─── Table card ────────────────────────────────────────────────── */
.rs-table-card {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-2xl);
    overflow: hidden;
    box-shadow: var(--s2);
}

/* ─── Row ────────────────────────────────────────────────────────── */
.rs-row {
    display: grid;
    grid-template-columns: 52px 1fr auto auto;
    align-items: center;
    gap: 1rem;
    padding: 1.1rem 1.35rem;
    border-bottom: 1px solid var(--border);
    transition: background var(--t-fast);
    position: relative;

    opacity: 0;
    animation: rs-fadein 0.45s calc(var(--i, 0) * 55ms) ease both;
}
.rs-row:last-child { border-bottom: none; }
.rs-row:hover { background: var(--g50); }
.rs-row-fail:hover { background: #FFF5F5; }

/* Fail accent */
.rs-row-fail::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, var(--red), transparent);
    border-radius: 0 2px 2px 0;
}

/* Grade badge */
.rs-grade-col { display: flex; justify-content: center; }
.rs-grade {
    width: 40px; height: 40px;
    border-radius: var(--r-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    font-weight: 900;
    letter-spacing: -0.02em;
    flex-shrink: 0;
}
.rs-grade-pass {
    background: var(--g50);
    color: var(--g600);
    border: 1.5px solid var(--g100);
}
.rs-grade-fail {
    background: #FFF1F2;
    color: #B91C1C;
    border: 1.5px solid #FECDD3;
}

/* Info column */
.rs-info-col {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
    min-width: 0;
}
.rs-row-meta {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    flex-wrap: wrap;
}
.rs-row-date, .rs-row-time {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.62rem;
    font-weight: 600;
    color: var(--quiet);
}
.rs-row-date .fas, .rs-row-time .fas { font-size: 0.52rem; }

.rs-row-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--ink);
    line-height: 1.35;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.rs-row-progress { max-width: 240px; }
.rs-row-track {
    height: 4px;
    background: var(--border);
    border-radius: var(--r-full);
    overflow: hidden;
}
.rs-row-fill {
    height: 100%;
    width: var(--pct, 0%);
    border-radius: var(--r-full);
    transition: width 1s cubic-bezier(0.4,0,0.2,1);
}
.rs-fill-pass { background: linear-gradient(90deg, var(--g500), var(--g300)); }
.rs-fill-fail { background: linear-gradient(90deg, var(--red), #FCA5A5); }

/* Score column */
.rs-score-col {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.3rem;
    flex-shrink: 0;
}
.rs-score-wrap {
    display: flex;
    align-items: baseline;
    gap: 2px;
    line-height: 1;
}
.rs-score-num {
    font-size: 1.5rem;
    font-weight: 900;
    letter-spacing: -0.04em;
}
.rs-score-pts {
    font-size: 0.6rem;
    font-weight: 700;
    color: var(--quiet);
    letter-spacing: 0.06em;
    text-transform: uppercase;
}
.rs-score-pass { color: var(--g500); }
.rs-score-fail { color: var(--red); }

.rs-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.28rem;
    padding: 0.2rem 0.6rem;
    border-radius: var(--r-full);
    font-size: 0.52rem;
    font-weight: 800;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    white-space: nowrap;
}
.rs-badge .fas { font-size: 0.45rem; }
.rs-badge-pass { background: var(--g50); color: var(--g600); border: 1px solid var(--g100); }
.rs-badge-fail { background: #FFF1F2; color: #B91C1C; border: 1px solid #FECDD3; }

/* Action column */
.rs-action-col { flex-shrink: 0; }
.rs-detail-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.5rem 0.85rem;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--r-md);
    font-size: 0.68rem;
    font-weight: 700;
    color: var(--ink);
    text-decoration: none;
    transition: all var(--t-fast);
    white-space: nowrap;
    box-shadow: var(--s1);
}
.rs-detail-btn .fas { font-size: 0.55rem; color: var(--quiet); transition: transform var(--t-fast); }
.rs-detail-btn:hover {
    background: var(--g50);
    border-color: var(--g200);
    color: var(--g600);
}
.rs-detail-btn:hover .fas {
    transform: translateX(2px);
    color: var(--g500);
}

/* Collapse action on xs */
@media (max-width: 480px) {
    .rs-row { grid-template-columns: 40px 1fr auto; }
    .rs-action-col { display: none; }
    .rs-row-title { white-space: normal; }
    .rs-score-num { font-size: 1.25rem; }
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  EMPTY STATE
   ╚══════════════════════════════════════════════════════════════════ */
.rs-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 5rem 1.5rem 6rem;
    text-align: center;
}
.rs-empty-visual {
    position: relative;
    width: 100px; height: 100px;
    margin-bottom: 0.5rem;
}
.rs-er {
    position: absolute;
    border-radius: 50%;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
}
.rs-er1 { width: 80px;  height: 80px;  border: 1px solid rgba(30,145,82,0.15); }
.rs-er2 { width: 140px; height: 140px; border: 1px dashed rgba(30,145,82,0.08); }
.rs-er3 { width: 200px; height: 200px; border: 1px solid rgba(30,145,82,0.04); }
.rs-empty-ico {
    position: relative; z-index: 2;
    width: 56px; height: 56px;
    background: var(--g50);
    border: 2px solid var(--g100);
    border-radius: var(--r-lg);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.5rem; color: var(--g500);
    margin: 22px auto 0;
    box-shadow: var(--s2);
}
.rs-empty-title { font-size: 1.3rem; font-weight: 800; color: var(--ink); letter-spacing: -0.02em; margin: 0; }
.rs-empty-body  { font-size: 0.84rem; color: var(--muted); line-height: 1.7; max-width: 38ch; margin: 0; }
.rs-empty-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.75rem;
    background: var(--g700);
    color: #fff;
    border-radius: var(--r-lg);
    font-size: 0.74rem;
    font-weight: 700;
    text-decoration: none;
    letter-spacing: 0.04em;
    box-shadow: 0 4px 16px rgba(13,92,52,0.26);
    transition: all var(--t-base);
    margin-top: 0.5rem;
}
.rs-empty-cta:hover {
    background: var(--g600);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(13,92,52,0.34);
}

/* ── Sub-section badges ── */
.rs-sub-head {
    display: flex;
    align-items: center;
    margin-bottom: 0.75rem;
    margin-top: 0.25rem;
}
.rs-sub-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.35rem 0.9rem;
    border-radius: 100px;
    font-size: 0.62rem;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: 1.5px solid transparent;
}
.rs-sub-pre {
    background: rgba(217,119,6,0.08);
    border-color: rgba(217,119,6,0.25);
    color: #D97706;
}
.rs-sub-post {
    background: var(--g50);
    border-color: var(--g100);
    color: var(--g600);
}

/* ── Animation ── */
@keyframes rs-fadein {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Mobile ── */
@media (max-width: 559px) {
    .rs-hero { padding: 2.75rem 1.25rem 3rem; }
    .rs-hero-heading { font-size: 2.1rem; }
    .rs-content { padding: 1.5rem 1rem 5rem; }
    .rs-row { padding: 1rem; gap: 0.75rem; }
}
</style>

@endsection