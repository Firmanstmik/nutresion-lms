@extends('layouts.app')

@section('content')

{{-- Google Fonts - matching Admin style --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="pr-root">
    {{-- ── Background Elements ── --}}
    <div class="pr-bg-glow pr-glow-1"></div>
    <div class="pr-bg-glow pr-glow-2"></div>

    {{-- ═══════════════════════════════════════════════════════════════
         IDENTITY STRIP — Student Edition
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="pr-identity-strip">
        <div class="pr-identity-inner">
            <div class="pr-identity-left">
                <div class="pr-seal">
                    <i data-lucide="leaf"></i>
                </div>
                <div class="pr-identity-text">
                    <span class="pr-id-label">PORTAL PROFIL</span>
                    <span class="pr-id-name">Nutrition Rescue Mission</span>
                </div>
            </div>
            <div class="pr-identity-right">
                <div class="pr-id-date">{{ now()->translatedFormat('l, d M Y') }}</div>
            </div>
        </div>
    </div>

    <div class="pr-container">
        {{-- ═══════════════════════════════════════════════════════════════
             HERO — Profile Overview
        ═══════════════════════════════════════════════════════════════ --}}
        <header class="pr-hero">
            <div class="pr-hero-content">
                <div class="pr-avatar-wrapper">
                    <div class="pr-avatar">
                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="pr-avatar-ring"></div>
                </div>
                
                <h1 class="pr-hero-title">
                    {{ explode(' ', Auth::user()->name)[0] }}<br>
                    <span class="pr-hero-title-accent">{{ str_replace(explode(' ', Auth::user()->name)[0], '', Auth::user()->name) }}</span>
                </h1>
                
                <div class="pr-badges">
                    <span class="pr-badge pr-badge-school">
                        <i data-lucide="building-2"></i>
                        {{ Auth::user()->school->name ?? 'Umum' }}
                    </span>
                    <span class="pr-badge pr-badge-role">
                        <i data-lucide="graduation-cap"></i>
                        Siswa
                    </span>
                </div>
            </div>
        </header>

        {{-- ═══════════════════════════════════════════════════════════════
             KPI STRIP — Academic Stats
        ═══════════════════════════════════════════════════════════════ --}}
        @php
            $results = Auth::user()->results;
            $completedCount = $results->count();
            $totalScore = $results->sum('score');
            $avgScore = $results->count() > 0 ? round($results->avg('score')) : 0;
        @endphp
        <div class="pr-kpi-strip">
            <div class="pr-kpi-card pr-kpi-done">
                <div class="pr-kpi-icon"><i data-lucide="check-circle-2"></i></div>
                <div class="pr-kpi-info">
                    <div class="pr-kpi-label">Selesai</div>
                    <div class="pr-kpi-value">{{ $completedCount }}</div>
                    <div class="pr-kpi-unit">Modul</div>
                </div>
                <div class="pr-kpi-accent"></div>
            </div>
            <div class="pr-kpi-card pr-kpi-score">
                <div class="pr-kpi-icon"><i data-lucide="award"></i></div>
                <div class="pr-kpi-info">
                    <div class="pr-kpi-label">Rata-rata</div>
                    <div class="pr-kpi-value">{{ $avgScore }}</div>
                    <div class="pr-kpi-unit">Poin</div>
                </div>
                <div class="pr-kpi-accent"></div>
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════════
             MAIN CONTENT — Panels
        ═══════════════════════════════════════════════════════════════ --}}
        <main class="pr-main">
            <div class="pr-grid-desktop">
                {{-- Personal Info Panel --}}
                <div class="pr-panel">
                    <div class="pr-panel-head">
                        <div class="pr-panel-title-group">
                            <div class="pr-panel-tag">DATA PRIBADI</div>
                            <h2 class="pr-panel-title">Informasi <span class="pr-panel-title-em">Akademik</span></h2>
                        </div>
                    </div>
                    
                    <div class="pr-info-list">
                        <div class="pr-info-item">
                            <div class="pr-info-icon"><i data-lucide="user"></i></div>
                            <div class="pr-info-body">
                                <label>Nama Lengkap</label>
                                <span>{{ Auth::user()->name }}</span>
                            </div>
                        </div>
                        <div class="pr-info-item">
                            <div class="pr-info-icon"><i data-lucide="fingerprint"></i></div>
                            <div class="pr-info-body">
                                <label>NISN / Username</label>
                                <span>{{ Auth::user()->username }}</span>
                            </div>
                        </div>
                        <div class="pr-info-item">
                            <div class="pr-info-icon"><i data-lucide="school"></i></div>
                            <div class="pr-info-body">
                                <label>Asal Instansi</label>
                                <span>{{ Auth::user()->school->name ?? 'Umum' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Account Settings Panel --}}
                <div class="pr-panel">
                    <div class="pr-panel-head">
                        <div class="pr-panel-title-group">
                            <div class="pr-panel-tag">PENGATURAN</div>
                            <h2 class="pr-panel-title">Keamanan <span class="pr-panel-title-em">& Akun</span></h2>
                        </div>
                    </div>
                    
                    <div class="pr-actions">
                        <form action="{{ route('logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="pr-btn-logout">
                                <div class="pr-btn-logout-icon">
                                    <i data-lucide="log-out"></i>
                                </div>
                                <div class="pr-btn-logout-text">
                                    <span>Keluar dari Aplikasi</span>
                                    <small>Sesi belajar kamu akan berakhir</small>
                                </div>
                                <i data-lucide="chevron-right" class="pr-btn-chevron"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    :root {
        --pr-primary: #1B7A3E;
        --pr-primary-glow: rgba(27, 122, 62, 0.08);
        --pr-navy: #0B1E3F;
        --pr-gold: #C9A84C;
        --pr-bg: #F8FAFC;
        --pr-white: #FFFFFF;
        --pr-text-main: #0F172A;
        --pr-text-muted: #64748B;
        --pr-border: #E2E8F0;
        --pr-panel-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
        --font-display: 'Playfair Display', serif;
        --font-sans: 'Plus Jakarta Sans', sans-serif;
    }

    .pr-root {
        min-height: 100vh;
        background-color: var(--pr-bg);
        font-family: var(--font-sans);
        position: relative;
        overflow-x: hidden;
        padding-bottom: 120px;
    }

    /* ── Identity Strip ── */
    .pr-identity-strip {
        background: var(--pr-white);
        border-bottom: 1px solid var(--pr-border);
        padding: 0.2rem 1.5rem;
        position: sticky;
        top: 60px;
        z-index: 10;
        backdrop-filter: blur(10px);
        background: rgba(255,255,255,0.8);
    }
    .pr-identity-inner {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    @media (max-width: 1240px) {
        .pr-identity-inner { max-width: 640px; }
    }
    
    .pr-identity-left { display: flex; align-items: center; gap: 0.75rem; }
    .pr-seal {
        width: 32px;
        height: 32px;
        background: var(--pr-primary-glow);
        border: 1px solid var(--pr-primary);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--pr-primary);
    }
    .pr-seal i { width: 16px; height: 16px; }
    .pr-identity-text { display: flex; flex-direction: column; line-height: 1; }
    .pr-id-label { font-size: 0.55rem; font-weight: 800; letter-spacing: 0.1em; color: var(--pr-text-muted); text-transform: uppercase; margin-bottom: 0.15rem; }
    .pr-id-name { font-size: 0.75rem; font-weight: 800; color: var(--pr-navy); }
    .pr-id-date { font-size: 0.7rem; font-weight: 600; color: var(--pr-text-muted); }

    /* ── Background Glows ── */
    .pr-bg-glow {
        position: fixed;
        width: 400px;
        height: 400px;
        border-radius: 50%;
        filter: blur(80px);
        z-index: 0;
        opacity: 0.3;
        pointer-events: none;
    }
    .pr-glow-1 { top: -100px; right: -100px; background: var(--pr-primary-glow); }
    .pr-glow-2 { bottom: -100px; left: -100px; background: rgba(201, 168, 76, 0.05); }

    .pr-container {
        position: relative;
        z-index: 1;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }
    
    @media (max-width: 1240px) {
        .pr-container { max-width: 640px; padding: 0 1.25rem; }
    }

    /* ── Hero Section ── */
    .pr-hero {
        padding: 0.75rem 0 2rem;
        text-align: center;
    }
    .pr-avatar-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
    }
    .pr-avatar {
        width: 100%;
        height: 100%;
        background: var(--pr-white);
        border: 4px solid var(--pr-white);
        border-radius: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: var(--font-display);
        font-size: 3.5rem;
        font-weight: 900;
        color: var(--pr-primary);
        box-shadow: var(--pr-premium-shadow);
        position: relative;
        z-index: 2;
    }
    .pr-avatar-ring {
        position: absolute;
        inset: -8px;
        border: 2px dashed var(--pr-primary);
        border-radius: 48px;
        opacity: 0.2;
        animation: rotate 20s linear infinite;
    }

    .pr-hero-title { font-size: 2.75rem; font-weight: 800; color: var(--pr-navy); line-height: 1.05; margin-bottom: 1.5rem; }
    .pr-hero-title-accent {
        font-family: var(--font-display);
        color: var(--pr-gold);
        font-style: italic;
        font-weight: 400;
    }

    .pr-badges { display: flex; justify-content: center; gap: 0.75rem; flex-wrap: wrap; }
    .pr-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: white;
        border: 1px solid var(--pr-border);
        border-radius: 100px;
        font-size: 0.7rem;
        font-weight: 800;
        color: var(--pr-navy);
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .pr-badge i { width: 14px; height: 14px; color: var(--pr-primary); }

    /* ── KPI Strip ── */
    .pr-kpi-strip {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 2.5rem;
    }
    
    @media (min-width: 768px) {
        .pr-kpi-strip { grid-template-columns: repeat(2, 1fr); max-width: 800px; margin-inline: auto; gap: 1.5rem; }
    }
    
    .pr-kpi-card {
        background: white;
        padding: 1.25rem;
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--pr-border);
        box-shadow: var(--pr-panel-shadow);
    }
    .pr-kpi-icon {
        width: 40px;
        height: 40px;
        background: var(--pr-bg);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--pr-navy);
    }
    .pr-kpi-icon i { width: 20px; height: 20px; }
    .pr-kpi-info { display: flex; flex-direction: column; }
    .pr-kpi-label { font-size: 0.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; color: var(--pr-text-muted); margin-bottom: 0.15rem; }
    .pr-kpi-value { font-size: 1.75rem; font-weight: 800; color: var(--pr-navy); line-height: 1; }
    .pr-kpi-unit { font-size: 0.65rem; font-weight: 600; color: var(--pr-text-muted); }
    .pr-kpi-accent { position: absolute; bottom: 0; left: 0; height: 3px; width: 40px; background: var(--pr-navy); }
    .pr-kpi-done .pr-kpi-icon { background: var(--pr-primary-glow); color: var(--pr-primary); }
    .pr-kpi-done .pr-kpi-accent { background: var(--pr-primary); }
    .pr-kpi-score .pr-kpi-icon { background: rgba(201, 168, 76, 0.1); color: var(--pr-gold); }
    .pr-kpi-score .pr-kpi-accent { background: var(--pr-gold); }

    /* ── Panels ── */
    .pr-main { padding-top: 1rem; }
    
    @media (min-width: 1024px) {
        .pr-grid-desktop { display: grid; grid-template-columns: 1.5fr 1fr; gap: 2rem; align-items: start; }
    }
    
    .pr-panel {
        background: white;
        border-radius: 24px;
        border: 1px solid var(--pr-border);
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: var(--pr-panel-shadow);
    }
    .pr-panel-head {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--pr-border);
        background: rgba(248, 250, 252, 0.5);
    }
    .pr-panel-tag {
        font-size: 0.55rem;
        font-weight: 800;
        color: var(--pr-primary);
        letter-spacing: 0.1em;
        margin-bottom: 0.2rem;
    }
    .pr-panel-title { font-size: 1rem; font-weight: 800; color: var(--pr-navy); }
    .pr-panel-title-em { font-family: var(--font-display); color: var(--pr-gold); font-style: italic; font-weight: 400; }

    /* Info List */
    .pr-info-list { display: flex; flex-direction: column; }
    .pr-info-item {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--pr-border);
    }
    .pr-info-item:last-child { border-bottom: none; }
    .pr-info-icon {
        width: 40px;
        height: 40px;
        background: var(--pr-bg);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--pr-text-muted);
    }
    .pr-info-icon i { width: 18px; height: 18px; }
    .pr-info-body { display: flex; flex-direction: column; }
    .pr-info-body label { font-size: 0.6rem; font-weight: 800; color: var(--pr-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.15rem; }
    .pr-info-body span { font-size: 0.95rem; font-weight: 700; color: var(--pr-navy); }

    /* Actions */
    .pr-actions { padding: 0.75rem; }
    .pr-btn-logout {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 1.25rem;
        padding: 1rem 1.25rem;
        background: white;
        border: 1px solid var(--pr-border);
        border-radius: 18px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: left;
    }
    .pr-btn-logout:hover {
        background: #FFF1F2;
        border-color: #FECDD3;
    }
    .pr-btn-logout-icon {
        width: 44px;
        height: 44px;
        background: #FFF1F2;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #E11D48;
    }
    .pr-btn-logout-text { display: flex; flex-direction: column; flex: 1; }
    .pr-btn-logout-text span { font-size: 0.9rem; font-weight: 800; color: #9F1239; }
    .pr-btn-logout-text small { font-size: 0.7rem; font-weight: 600; color: #E11D48; opacity: 0.6; }
    .pr-btn-chevron { width: 14px; height: 14px; color: #FDA4AF; }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    @media (max-width: 480px) {
        .pr-hero-title { font-size: 2.25rem; }
        .pr-hero { padding: 3rem 0 2rem; }
        .pr-kpi-value { font-size: 1.5rem; }
        .pr-avatar-wrapper { width: 100px; height: 100px; }
        .pr-avatar { font-size: 3rem; }
    }
</style>

@endsection
