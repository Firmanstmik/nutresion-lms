@extends('layouts.app')

@section('hero')
<div class="nrm-root" style="padding-top: 0.5px;">
    {{-- ═══════════════════════════════════════════════════════════════
         HEADER BAND — National Identity Strip
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="nrm-identity-strip">
        <div class="nrm-identity-inner">
            <div class="nrm-identity-left">
                <div class="nrm-seal">
                    <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="nrm-seal-svg">
                        <circle cx="20" cy="20" r="18" stroke="#C9A84C" stroke-width="1.5"/>
                        <circle cx="20" cy="20" r="13" stroke="#C9A84C" stroke-width="0.5" stroke-dasharray="2 2"/>
                        <path d="M20 8 L22.5 15 L30 15 L24 19.5 L26.5 26.5 L20 22 L13.5 26.5 L16 19.5 L10 15 L17.5 15 Z" fill="#C9A84C" opacity="0.9"/>
                    </svg>
                </div>
                <div class="nrm-identity-text">
                    <span class="nrm-ministry-label">SISTEM INFORMASI</span>
                    <span class="nrm-ministry-name">NUTRITION RESCUE MISSION</span>
                </div>
            </div>
            <div class="nrm-identity-right">
                <div class="nrm-time-display" id="nrm-clock"></div>
                <div class="nrm-date-display" id="nrm-date"></div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         HERO — Command Overview
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="nrm-hero">
        <div class="nrm-hero-bg">
            <img src="{{ route('brand.hero-admin') }}" alt="Hero" class="nrm-hero-img">
            <div class="nrm-hero-overlay-l"></div>
            <div class="nrm-hero-overlay-b"></div>
            <div class="nrm-hero-grid"></div>
        </div>

        <div class="nrm-hero-content">
            <div class="nrm-hero-left">
                <div class="nrm-status-pill">
                    <span class="nrm-status-dot"></span>
                    SISTEM AKTIF — {{ now()->format('d M Y') }}
                </div>
                <h1 class="nrm-hero-title">
                    Selamat Datang,<br>
                    <span class="nrm-hero-title-accent">Administrator</span>
                </h1>
                <p class="nrm-hero-sub">
                    Portal Administrasi Terpadu · Pengelolaan ekosistem pembelajaran gizi nasional secara real-time.
                </p>
                <div class="nrm-hero-actions">
                    <a href="{{ route('admin.courses.index') }}" class="nrm-btn-primary">
                        <i class="fas fa-layer-group"></i>
                        Kelola Kursus
                    </a>
                    <a href="{{ route('admin.results.index') }}" class="nrm-btn-ghost">
                        Lihat Laporan <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div class="nrm-hero-right">
                <div class="nrm-hero-data-card">
                    <div class="nrm-hero-data-label">Tingkat Kelulusan</div>
                    <div class="nrm-hero-data-value" id="nrm-pass-rate">—</div>
                    <div class="nrm-hero-data-sub">Berdasarkan data sertifikasi aktif</div>
                    <div class="nrm-hero-data-bar">
                        <div class="nrm-hero-data-fill" id="nrm-pass-bar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;600&swap" rel="stylesheet">

<div class="nrm-root" 
     style="margin-top: -24px;"
     data-total-results="{{ $stats['results'] ?? 0 }}" 
     data-recent-scores="{{ json_encode($recentResults->pluck('score')) }}">
    {{-- ═══════════════════════════════════════════════════════════════
         KPI STRIP — Four Key Metrics
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="nrm-kpi-strip">
        @php
            $kpis = [
                ['label' => 'Total Lembaga',  'value' => $stats['schools'],  'icon' => 'fa-building-columns', 'unit' => 'Institusi', 'route' => 'admin.schools.index',  'accent' => 'var(--nrm-red)'],
                ['label' => 'Total Peserta',  'value' => $stats['students'], 'icon' => 'fa-users',            'unit' => 'Peserta',   'route' => 'admin.students.index', 'accent' => 'var(--nrm-navy)'],
                ['label' => 'Modul Kursus',   'value' => $stats['courses'],  'icon' => 'fa-book-open',        'unit' => 'Modul',     'route' => 'admin.courses.index',  'accent' => 'var(--nrm-gold)'],
                ['label' => 'Sertifikasi',    'value' => $stats['results'],  'icon' => 'fa-certificate',      'unit' => 'Dokumen',   'route' => 'admin.results.index',  'accent' => 'var(--nrm-teal)'],
            ];
        @endphp
        @foreach($kpis as $i => $kpi)
        <a href="{{ route($kpi['route']) }}" class="nrm-kpi-card" style="--accent: {{ $kpi['accent'] }}">
            <div class="nrm-kpi-index">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</div>
            <div class="nrm-kpi-body">
                <div class="nrm-kpi-icon">
                    <i class="fas {{ $kpi['icon'] }}"></i>
                </div>
                <div class="nrm-kpi-info">
                    <div class="nrm-kpi-label">{{ $kpi['label'] }}</div>
                    <div class="nrm-kpi-value">{{ number_format($kpi['value']) }}</div>
                    <div class="nrm-kpi-unit">{{ $kpi['unit'] }}</div>
                </div>
            </div>
            <div class="nrm-kpi-arrow"><i class="fas fa-arrow-up-right"></i></div>
            <div class="nrm-kpi-accent-line"></div>
        </a>
        @endforeach
    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         MAIN GRID — Activity + Sidebar
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="nrm-main-grid">

        {{-- LEFT: Activity Log + New Students --}}
        <div class="nrm-col-main">

            {{-- Activity Log --}}
            <div class="nrm-panel">
                <div class="nrm-panel-head">
                    <div class="nrm-panel-title-group">
                        <div class="nrm-panel-tag">LOG RESMI</div>
                        <h2 class="nrm-panel-title">Aktivitas Sertifikasi <span class="nrm-panel-title-em">Terkini</span></h2>
                    </div>
                    <a href="{{ route('admin.results.index') }}" class="nrm-link-btn">
                        Arsip Lengkap <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>

                <div class="nrm-panel-body">
                    {{-- Table Header --}}
                    <div class="nrm-table-header">
                        <span class="nrm-th nrm-th-wide">Peserta</span>
                        <span class="nrm-th nrm-th-hide">Modul</span>
                        <span class="nrm-th">Waktu</span>
                        <span class="nrm-th nrm-th-center">Nilai</span>
                        <span class="nrm-th nrm-th-center">Status</span>
                    </div>

                    <div class="nrm-activity-list">
                        @forelse($recentResults as $result)
                        <div class="nrm-activity-row">
                            <div class="nrm-activity-person nrm-th-wide">
                                <div class="nrm-avatar" data-initial="{{ substr($result->user->name, 0, 1) }}">
                                    {{ substr($result->user->name, 0, 1) }}
                                </div>
                                <div class="nrm-activity-name-block">
                                    <span class="nrm-activity-name">{{ $result->user->name }}</span>
                                    <span class="nrm-activity-school">{{ $result->user->school->name ?? 'Umum' }}</span>
                                </div>
                            </div>
                            <div class="nrm-activity-course nrm-th-hide">
                                {{ $result->course->title }}
                            </div>
                            <div class="nrm-activity-time">
                                <i class="fas fa-clock"></i>
                                {{ $result->created_at->diffForHumans() }}
                            </div>
                            <div class="nrm-activity-score nrm-th-center {{ $result->score >= 70 ? 'nrm-score-pass' : 'nrm-score-fail' }}">
                                {{ $result->score }}
                            </div>
                            <div class="nrm-activity-status nrm-th-center">
                                @if($result->score >= 70)
                                    <span class="nrm-badge nrm-badge-pass"><i class="fas fa-check"></i> LULUS</span>
                                @else
                                    <span class="nrm-badge nrm-badge-fail"><i class="fas fa-times"></i> GAGAL</span>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="nrm-empty-state">
                            <div class="nrm-empty-icon"><i class="fas fa-inbox"></i></div>
                            <p class="nrm-empty-text">Belum ada data aktivitas tercatat dalam sistem.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Recent Students --}}
            <div class="nrm-panel">
                <div class="nrm-panel-head">
                    <div class="nrm-panel-title-group">
                        <div class="nrm-panel-tag">REGISTRASI BARU</div>
                        <h2 class="nrm-panel-title">Peserta <span class="nrm-panel-title-em">Terdaftar</span></h2>
                    </div>
                    <a href="{{ route('admin.students.index') }}" class="nrm-link-btn">
                        Semua Peserta <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
                <div class="nrm-panel-body">
                    <div class="nrm-student-grid">
                        @foreach($recentStudents as $student)
                        <div class="nrm-student-card">
                            <div class="nrm-student-avatar">{{ substr($student->name, 0, 1) }}</div>
                            <div class="nrm-student-info">
                                <span class="nrm-student-name">{{ $student->name }}</span>
                                <span class="nrm-student-school">
                                    <i class="fas fa-building-columns"></i>
                                    {{ $student->school->name ?? 'Umum' }}
                                </span>
                            </div>
                            <div class="nrm-student-chevron"><i class="fas fa-chevron-right"></i></div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: Sidebar --}}
        <div class="nrm-col-side">

            {{-- Distribution Analytics --}}
            <div class="nrm-panel">
                <div class="nrm-panel-head">
                    <div class="nrm-panel-title-group">
                        <div class="nrm-panel-tag">ANALISIS</div>
                        <h2 class="nrm-panel-title">Sebaran <span class="nrm-panel-title-em">Lembaga</span></h2>
                    </div>
                </div>
                <div class="nrm-panel-body">
                    <div class="nrm-distribution-list">
                        @foreach($schoolsWithCount as $idx => $school)
                        @php
                            $pct = $stats['students'] > 0 ? ($school->users_count / $stats['students']) * 100 : 0;
                        @endphp
                        <div class="nrm-dist-item">
                            <div class="nrm-dist-head">
                                <div class="nrm-dist-rank">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</div>
                                <span class="nrm-dist-name">{{ $school->name }}</span>
                                <span class="nrm-dist-count">{{ $school->users_count }}</span>
                            </div>
                            <div class="nrm-dist-track">
                                <div class="nrm-dist-fill" @style(['width' => $pct . '%'])></div>
                                <span class="nrm-dist-pct">{{ number_format($pct, 1) }}%</span>
                            </div>
                        </div>
                        @endforeach

                        @if($schoolsWithCount->isEmpty())
                        <div class="nrm-empty-state">
                            <p class="nrm-empty-text">Belum ada data lembaga.</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Quick Nav --}}
            <div class="nrm-panel nrm-panel-dark">
                <div class="nrm-panel-head">
                    <div class="nrm-panel-title-group">
                        <div class="nrm-panel-tag nrm-tag-light">NAVIGASI</div>
                        <h2 class="nrm-panel-title nrm-title-light">Panel <span class="nrm-panel-title-em">Kontrol</span></h2>
                    </div>
                </div>
                <div class="nrm-panel-body">
                    <div class="nrm-nav-grid">
                        @php
                            $navItems = [
                                ['label' => 'Lembaga',    'icon' => 'fa-building-columns', 'route' => 'admin.schools.index',  'desc' => 'Kelola Institusi'],
                                ['label' => 'Peserta',    'icon' => 'fa-users',            'route' => 'admin.students.index', 'desc' => 'Data Peserta'],
                                ['label' => 'Kursus',     'icon' => 'fa-book-open',        'route' => 'admin.courses.index',  'desc' => 'Modul Belajar'],
                                ['label' => 'Sertifikasi','icon' => 'fa-certificate',      'route' => 'admin.results.index',  'desc' => 'Hasil & Laporan'],
                            ];
                        @endphp
                        @foreach($navItems as $nav)
                        <a href="{{ route($nav['route']) }}" class="nrm-nav-item">
                            <div class="nrm-nav-icon">
                                <i class="fas {{ $nav['icon'] }}"></i>
                            </div>
                            <span class="nrm-nav-label">{{ $nav['label'] }}</span>
                            <span class="nrm-nav-desc">{{ $nav['desc'] }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- System Status --}}
            <div class="nrm-panel nrm-panel-status">
                <div class="nrm-status-header">
                    <div class="nrm-status-seal">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div>
                        <div class="nrm-status-title">STATUS KEAMANAN</div>
                        <div class="nrm-status-subtitle">Sistem Terverifikasi</div>
                    </div>
                    <div class="nrm-status-online">
                        <span class="nrm-online-dot"></span>
                        ONLINE
                    </div>
                </div>
                <div class="nrm-status-items">
                    <div class="nrm-status-item">
                        <i class="fas fa-lock nrm-status-icon"></i>
                        <span>Enkripsi data end-to-end aktif</span>
                    </div>
                    <div class="nrm-status-item">
                        <i class="fas fa-rotate nrm-status-icon"></i>
                        <span>Sinkronisasi kurikulum otomatis</span>
                    </div>
                    <div class="nrm-status-item">
                        <i class="fas fa-database nrm-status-icon"></i>
                        <span>Backup terjadwal setiap 24 jam</span>
                    </div>
                </div>
                <div class="nrm-status-footer">
                    <div class="nrm-uptime-bar">
                        <div class="nrm-uptime-fill"></div>
                    </div>
                    <span class="nrm-uptime-label">Uptime 99.9%</span>
                </div>
            </div>

        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════════════════════════
     STYLES
═══════════════════════════════════════════════════════════════ --}}
<style>
:root {
    --nrm-navy:     #0B1E3F;
    --nrm-navy-mid: #122247;
    --nrm-navy-lt:  #1B3461;
    --nrm-red:      #C0111E;
    --nrm-red-lt:   #E8192C;
    --nrm-gold:     #C9A84C;
    --nrm-gold-lt:  #E2C471;
    --nrm-teal:     #0F7E6E;
    --nrm-teal-lt:  #14A88F;
    --nrm-ink:      #111827;
    --nrm-muted:    #6B7280;
    --nrm-border:   #E5E7EB;
    --nrm-surface:  #F9FAFB;
    --nrm-white:    #FFFFFF;
    --nrm-font-display: 'Playfair Display', Georgia, serif;
    --nrm-font-body:    'DM Sans', sans-serif;
    --nrm-font-mono:    'JetBrains Mono', monospace;
    --nrm-shadow-sm:    0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --nrm-shadow:       0 4px 16px rgba(0,0,0,0.06), 0 2px 6px rgba(0,0,0,0.04);
    --nrm-shadow-lg:    0 20px 60px rgba(0,0,0,0.08), 0 8px 24px rgba(0,0,0,0.05);
}

* { box-sizing: border-box; margin: 0; padding: 0; }

.nrm-root {
    font-family: var(--nrm-font-body);
    color: var(--nrm-ink);
    background: var(--nrm-surface);
    display: flex;
    flex-direction: column;
    gap: 0;
    margin-top: -1.5rem;
    width: 100vw;
    margin-left: 50%;
    transform: translateX(-50%);
    position: relative;
    overflow-x: hidden;
}

/* ── Identity Strip ──────────────────────────────── */
.nrm-identity-strip {
    background: var(--nrm-navy);
    border-bottom: 2px solid var(--nrm-red);
    position: relative;
    z-index: 10;
}
.nrm-identity-strip::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: repeating-linear-gradient(
        90deg,
        transparent,
        transparent 60px,
        rgba(255,255,255,0.015) 60px,
        rgba(255,255,255,0.015) 61px
    );
    pointer-events: none;
}
.nrm-identity-inner {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0.75rem 2rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.nrm-identity-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.nrm-seal { width: 40px; height: 40px; flex-shrink: 0; }
.nrm-seal-svg { width: 100%; height: 100%; }
.nrm-identity-text {
    display: flex;
    flex-direction: column;
    gap: 0.1rem;
}
.nrm-ministry-label {
    font-family: var(--nrm-font-body);
    font-size: 0.55rem;
    font-weight: 600;
    letter-spacing: 0.2em;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
}
.nrm-ministry-name {
    font-family: var(--nrm-font-body);
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    color: var(--nrm-gold);
    text-transform: uppercase;
}
.nrm-identity-right {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}
.nrm-time-display {
    font-family: var(--nrm-font-mono);
    font-size: 1rem;
    font-weight: 600;
    color: var(--nrm-gold-lt);
    letter-spacing: 0.1em;
}
.nrm-date-display {
    font-family: var(--nrm-font-body);
    font-size: 0.6rem;
    font-weight: 500;
    letter-spacing: 0.1em;
    color: rgba(255,255,255,0.35);
    text-transform: uppercase;
}

/* ── Hero ──────────────────────────────────────── */
.nrm-hero {
    position: relative;
    min-height: 340px;
    display: flex;
    align-items: flex-end;
    overflow: hidden;
}
@media (min-width: 768px) { .nrm-hero { min-height: 480px; } }

.nrm-hero-bg {
    position: absolute;
    inset: 0;
    z-index: 0;
}
.nrm-hero-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    transition: transform 12s ease;
}
.nrm-hero:hover .nrm-hero-img { transform: scale(1.04); }
.nrm-hero-overlay-l {
    position: absolute;
    inset: 0;
    background: linear-gradient(100deg, var(--nrm-navy) 0%, rgba(11,30,63,0.85) 45%, transparent 75%);
}
.nrm-hero-overlay-b {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(11,30,63,0.6) 0%, transparent 50%);
}
.nrm-hero-grid {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(201,168,76,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(201,168,76,0.05) 1px, transparent 1px);
    background-size: 60px 60px;
}

.nrm-hero-content {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 2rem 3rem;
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 2rem;
}

.nrm-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.35rem 0.9rem;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 2px;
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    color: rgba(255,255,255,0.7);
    text-transform: uppercase;
    margin-bottom: 1.25rem;
    backdrop-filter: blur(8px);
}
.nrm-status-dot {
    width: 6px; height: 6px;
    background: #10B981;
    border-radius: 50%;
    box-shadow: 0 0 8px rgba(16,185,129,0.8);
    animation: nrm-pulse 2s infinite;
}
@keyframes nrm-pulse {
    0%, 100% { opacity: 1; box-shadow: 0 0 8px rgba(16,185,129,0.8); }
    50% { opacity: 0.6; box-shadow: 0 0 16px rgba(16,185,129,0.4); }
}

.nrm-hero-title {
    font-family: var(--nrm-font-display);
    font-size: clamp(2rem, 5vw, 4.5rem);
    font-weight: 900;
    line-height: 1.05;
    color: var(--nrm-white);
    margin-bottom: 1rem;
    text-shadow: 0 2px 20px rgba(0,0,0,0.3);
}
.nrm-hero-title-accent {
    color: var(--nrm-gold);
}

.nrm-hero-sub {
    font-size: 0.8rem;
    font-weight: 400;
    color: rgba(255,255,255,0.6);
    line-height: 1.7;
    max-width: 480px;
    margin-bottom: 2rem;
    letter-spacing: 0.01em;
}
.nrm-hero-actions { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; }

.nrm-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1.75rem;
    background: var(--nrm-red);
    color: white;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    text-decoration: none;
    border: none;
    border-radius: 2px;
    transition: all 0.2s ease;
    box-shadow: 0 4px 20px rgba(192,17,30,0.4);
    position: relative;
    overflow: hidden;
}
.nrm-btn-primary::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
    transform: translateX(-100%);
    transition: transform 0.4s ease;
}
.nrm-btn-primary:hover::after { transform: translateX(100%); }
.nrm-btn-primary:hover {
    background: var(--nrm-red-lt);
    box-shadow: 0 6px 28px rgba(192,17,30,0.5);
    transform: translateY(-1px);
}

.nrm-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 0.6rem;
    padding: 0.75rem 1.5rem;
    background: transparent;
    color: rgba(255,255,255,0.7);
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    text-decoration: none;
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 2px;
    transition: all 0.2s ease;
}
.nrm-btn-ghost:hover {
    background: rgba(255,255,255,0.08);
    color: white;
    border-color: rgba(255,255,255,0.4);
}

.nrm-hero-right { flex-shrink: 0; }
.nrm-hero-data-card {
    background: rgba(255,255,255,0.07);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 4px;
    padding: 1.5rem 2rem;
    min-width: 220px;
    position: relative;
    overflow: hidden;
}
.nrm-hero-data-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 2px;
    background: linear-gradient(90deg, var(--nrm-gold), transparent);
}
.nrm-hero-data-label {
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    color: rgba(255,255,255,0.45);
    text-transform: uppercase;
    margin-bottom: 0.5rem;
}
.nrm-hero-data-value {
    font-family: var(--nrm-font-mono);
    font-size: 2.5rem;
    font-weight: 600;
    color: var(--nrm-gold-lt);
    line-height: 1;
    margin-bottom: 0.4rem;
}
.nrm-hero-data-sub {
    font-size: 0.6rem;
    color: rgba(255,255,255,0.35);
    margin-bottom: 1rem;
}
.nrm-hero-data-bar {
    height: 4px;
    background: rgba(255,255,255,0.1);
    border-radius: 0;
    overflow: hidden;
}
.nrm-hero-data-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--nrm-gold), var(--nrm-gold-lt));
    width: 0%;
    transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
}

/* ── KPI Strip ──────────────────────────────────── */
.nrm-kpi-strip {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    background: var(--nrm-navy-mid);
    border-bottom: 1px solid rgba(255,255,255,0.05);
    width: 100%;
}
@media (min-width: 640px)  { .nrm-kpi-strip { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .nrm-kpi-strip { grid-template-columns: repeat(4, 1fr); } }

.nrm-kpi-inner {
    display: contents;
}
.nrm-kpi-strip > * {
    border-right: 1px solid rgba(255,255,255,0.05);
    border-bottom: 1px solid rgba(255,255,255,0.05);
}
.nrm-kpi-strip > *:nth-child(4n) { border-right: none; }

.nrm-kpi-card {
    position: relative;
    padding: 1.75rem 2rem;
    border-right: 1px solid rgba(255,255,255,0.06);
    border-bottom: 1px solid rgba(255,255,255,0.06);
    text-decoration: none;
    cursor: pointer;
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    background: var(--nrm-navy);
}
.nrm-kpi-card:hover {
    background: var(--nrm-navy-mid);
    transform: none;
}
.nrm-kpi-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 80% 50%, rgba(255,255,255,0.03), transparent 60%);
    opacity: 0;
    transition: opacity 0.3s ease;
}
.nrm-kpi-card:hover::after { opacity: 1; }

.nrm-kpi-accent-line {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: var(--accent);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s ease;
}
.nrm-kpi-card:hover .nrm-kpi-accent-line { transform: scaleX(1); }

.nrm-kpi-index {
    font-family: var(--nrm-font-mono);
    font-size: 0.6rem;
    font-weight: 600;
    color: rgba(255,255,255,0.2);
    letter-spacing: 0.1em;
}
.nrm-kpi-body {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.nrm-kpi-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 2px;
    font-size: 1rem;
    color: var(--accent);
    transition: all 0.3s ease;
    flex-shrink: 0;
}
.nrm-kpi-card:hover .nrm-kpi-icon {
    background: var(--accent);
    color: white;
    border-color: var(--accent);
}
.nrm-kpi-info { display: flex; flex-direction: column; gap: 0.1rem; }
.nrm-kpi-label {
    font-size: 0.6rem;
    font-weight: 600;
    letter-spacing: 0.15em;
    color: rgba(255,255,255,0.4);
    text-transform: uppercase;
}
.nrm-kpi-value {
    font-family: var(--nrm-font-mono);
    font-size: 1.75rem;
    font-weight: 600;
    color: var(--nrm-white);
    line-height: 1;
}
.nrm-kpi-unit {
    font-size: 0.55rem;
    color: rgba(255,255,255,0.25);
    text-transform: uppercase;
    letter-spacing: 0.15em;
}
.nrm-kpi-arrow {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    font-size: 0.7rem;
    color: rgba(255,255,255,0.15);
    transition: all 0.3s ease;
}
.nrm-kpi-card:hover .nrm-kpi-arrow {
    color: var(--accent);
    transform: translate(2px, -2px);
}

/* ── Main Grid ──────────────────────────────────── */
.nrm-main-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    padding: 2.5rem 2rem;
    max-width: 1400px;
    margin: 0 auto;
    width: 100%;
}
@media (min-width: 1024px) {
    .nrm-main-grid { grid-template-columns: 1fr 360px; padding: 2rem; gap: 2rem; }
}

.nrm-col-main { display: flex; flex-direction: column; gap: 1.5rem; }
.nrm-col-side  { display: flex; flex-direction: column; gap: 1.5rem; }

/* ── Panel ──────────────────────────────────────── */
.nrm-panel {
    background: var(--nrm-white);
    border: 1px solid var(--nrm-border);
    border-radius: 2px;
    overflow: hidden;
    box-shadow: var(--nrm-shadow);
    transition: box-shadow 0.3s ease;
}
.nrm-panel:hover { box-shadow: var(--nrm-shadow-lg); }

.nrm-panel-dark {
    background: var(--nrm-navy);
    border-color: rgba(255,255,255,0.06);
}

.nrm-panel-status {
    background: linear-gradient(135deg, var(--nrm-navy) 0%, var(--nrm-navy-lt) 100%);
    border: none;
    border-top: 2px solid var(--nrm-gold);
}

.nrm-panel-head {
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--nrm-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.nrm-panel-dark .nrm-panel-head { border-bottom-color: rgba(255,255,255,0.06); }
.nrm-panel-status .nrm-panel-head { border-bottom-color: rgba(255,255,255,0.08); display: none; }

.nrm-panel-title-group { display: flex; flex-direction: column; gap: 0.25rem; }
.nrm-panel-tag {
    font-family: var(--nrm-font-body);
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    color: var(--nrm-red);
    text-transform: uppercase;
}
.nrm-tag-light { color: rgba(201,168,76,0.7); }
.nrm-panel-title {
    font-family: var(--nrm-font-display);
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--nrm-ink);
    line-height: 1.2;
}
.nrm-title-light { color: rgba(255,255,255,0.9); }
.nrm-panel-title-em { color: var(--nrm-red); }
.nrm-panel-dark .nrm-panel-title-em { color: var(--nrm-gold); }

.nrm-link-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.9rem;
    background: var(--nrm-surface);
    border: 1px solid var(--nrm-border);
    border-radius: 2px;
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--nrm-muted);
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.nrm-link-btn:hover {
    background: var(--nrm-navy);
    color: white;
    border-color: var(--nrm-navy);
}

.nrm-panel-body { padding: 1.5rem 1.75rem; }

/* ── Activity Table ─────────────────────────────── */
.nrm-table-header {
    display: grid;
    grid-template-columns: 1fr auto auto auto;
    gap: 1rem;
    padding: 0 0 0.75rem 0;
    border-bottom: 1px solid var(--nrm-border);
    margin-bottom: 0;
}
@media (min-width: 768px) {
    .nrm-table-header { grid-template-columns: 2fr 1.5fr 1fr auto auto; }
}

.nrm-th {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    text-transform: uppercase;
    color: var(--nrm-muted);
}
.nrm-th-hide { display: none; }
@media (min-width: 768px) { .nrm-th-hide { display: block; } }
.nrm-th-center { text-align: center; }

.nrm-activity-list { display: flex; flex-direction: column; }

.nrm-activity-row {
    display: grid;
    grid-template-columns: 1fr auto auto auto;
    gap: 1rem;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(229,231,235,0.5);
    transition: background 0.2s ease;
}
.nrm-activity-row:last-child { border-bottom: none; }
.nrm-activity-row:hover { background: var(--nrm-surface); margin: 0 -1.75rem; padding: 1rem 1.75rem; }
@media (min-width: 768px) {
    .nrm-activity-row { grid-template-columns: 2fr 1.5fr 1fr auto auto; }
}

.nrm-activity-person {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    overflow: hidden;
}
.nrm-avatar {
    width: 36px;
    height: 36px;
    background: var(--nrm-navy);
    color: var(--nrm-gold);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--nrm-font-display);
    font-size: 0.9rem;
    font-weight: 700;
    flex-shrink: 0;
    letter-spacing: 0;
}
.nrm-activity-name-block { display: flex; flex-direction: column; overflow: hidden; }
.nrm-activity-name {
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--nrm-ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.nrm-activity-school {
    font-size: 0.6rem;
    color: var(--nrm-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.nrm-activity-course {
    font-size: 0.72rem;
    color: var(--nrm-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.nrm-activity-time {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.65rem;
    color: var(--nrm-muted);
    white-space: nowrap;
}
.nrm-activity-time .fas { font-size: 0.5rem; }
.nrm-activity-score {
    font-family: var(--nrm-font-mono);
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
    min-width: 40px;
}
.nrm-score-pass { color: var(--nrm-teal); }
.nrm-score-fail { color: var(--nrm-red); }
.nrm-activity-status { display: flex; justify-content: center; }

.nrm-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.2rem 0.6rem;
    border-radius: 2px;
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    white-space: nowrap;
}
.nrm-badge-pass { background: rgba(15,126,110,0.1); color: var(--nrm-teal); border: 1px solid rgba(15,126,110,0.2); }
.nrm-badge-fail { background: rgba(192,17,30,0.08); color: var(--nrm-red); border: 1px solid rgba(192,17,30,0.15); }

.nrm-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    padding: 3rem 1rem;
    text-align: center;
}
.nrm-empty-icon {
    width: 52px;
    height: 52px;
    background: var(--nrm-surface);
    border: 1px solid var(--nrm-border);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: #D1D5DB;
}
.nrm-empty-text {
    font-size: 0.75rem;
    color: var(--nrm-muted);
    font-weight: 500;
}

/* ── Student Grid ───────────────────────────────── */
.nrm-student-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.6rem;
}
@media (min-width: 640px) { .nrm-student-grid { grid-template-columns: repeat(2, 1fr); } }

.nrm-student-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem 1rem;
    border: 1px solid var(--nrm-border);
    border-radius: 2px;
    transition: all 0.2s ease;
    cursor: pointer;
}
.nrm-student-card:hover {
    border-color: var(--nrm-navy);
    background: rgba(11,30,63,0.02);
    transform: translateY(-1px);
    box-shadow: var(--nrm-shadow-sm);
}
.nrm-student-avatar {
    width: 36px;
    height: 36px;
    background: var(--nrm-surface);
    border: 1px solid var(--nrm-border);
    color: var(--nrm-navy);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--nrm-font-display);
    font-size: 0.9rem;
    font-weight: 700;
    flex-shrink: 0;
    transition: all 0.2s ease;
}
.nrm-student-card:hover .nrm-student-avatar {
    background: var(--nrm-navy);
    color: var(--nrm-gold);
    border-color: var(--nrm-navy);
}
.nrm-student-info {
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
    overflow: hidden;
    flex: 1;
}
.nrm-student-name {
    font-size: 0.8rem;
    font-weight: 600;
    color: var(--nrm-ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.nrm-student-school {
    font-size: 0.6rem;
    color: var(--nrm-muted);
    display: flex;
    align-items: center;
    gap: 0.3rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.nrm-student-school .fas { font-size: 0.5rem; color: var(--nrm-red); }
.nrm-student-chevron { color: #D1D5DB; font-size: 0.6rem; flex-shrink: 0; transition: all 0.2s ease; }
.nrm-student-card:hover .nrm-student-chevron { color: var(--nrm-navy); transform: translateX(2px); }

/* ── Distribution ───────────────────────────────── */
.nrm-distribution-list { display: flex; flex-direction: column; gap: 1.25rem; }

.nrm-dist-item { display: flex; flex-direction: column; gap: 0.5rem; }
.nrm-dist-head {
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
.nrm-dist-rank {
    font-family: var(--nrm-font-mono);
    font-size: 0.6rem;
    font-weight: 600;
    color: rgba(107,114,128,0.5);
    letter-spacing: 0.05em;
    flex-shrink: 0;
    width: 20px;
}
.nrm-dist-name {
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--nrm-ink);
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.nrm-dist-count {
    font-family: var(--nrm-font-mono);
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--nrm-navy);
    flex-shrink: 0;
}
.nrm-dist-track {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-left: 26px;
}
.nrm-dist-track > div:first-child {
    flex: 1;
    height: 4px;
    background: var(--nrm-surface);
    border: 1px solid var(--nrm-border);
    border-radius: 0;
    overflow: hidden;
}
.nrm-dist-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--nrm-navy), var(--nrm-navy-lt));
    transition: width 1.2s cubic-bezier(0.4, 0, 0.2, 1);
}
.nrm-dist-pct {
    font-family: var(--nrm-font-mono);
    font-size: 0.6rem;
    font-weight: 600;
    color: var(--nrm-muted);
    flex-shrink: 0;
    min-width: 36px;
    text-align: right;
}

/* ── Nav Grid ───────────────────────────────────── */
.nrm-nav-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
}
.nrm-nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1.25rem 0.75rem;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 2px;
    text-decoration: none;
    transition: all 0.25s ease;
    position: relative;
    overflow: hidden;
}
.nrm-nav-item::before {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: var(--nrm-gold);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}
.nrm-nav-item:hover::before { transform: scaleX(1); }
.nrm-nav-item:hover {
    background: rgba(255,255,255,0.08);
    border-color: rgba(201,168,76,0.25);
    transform: translateY(-2px);
}
.nrm-nav-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    color: rgba(201,168,76,0.6);
    transition: all 0.25s ease;
}
.nrm-nav-item:hover .nrm-nav-icon {
    background: var(--nrm-gold);
    color: var(--nrm-navy);
    border-color: var(--nrm-gold);
}
.nrm-nav-label {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.7);
    transition: color 0.25s ease;
}
.nrm-nav-item:hover .nrm-nav-label { color: white; }
.nrm-nav-desc {
    font-size: 0.55rem;
    color: rgba(255,255,255,0.25);
    letter-spacing: 0.05em;
}

/* ── Status Panel ───────────────────────────────── */
.nrm-status-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem 1.75rem;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.nrm-status-seal {
    width: 44px;
    height: 44px;
    background: rgba(201,168,76,0.12);
    border: 1px solid rgba(201,168,76,0.2);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: var(--nrm-gold);
    flex-shrink: 0;
}
.nrm-status-title {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    color: var(--nrm-gold);
    text-transform: uppercase;
    margin-bottom: 0.2rem;
}
.nrm-status-subtitle {
    font-size: 0.85rem;
    font-weight: 600;
    color: rgba(255,255,255,0.8);
}
.nrm-status-online {
    margin-left: auto;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    color: #10B981;
    text-transform: uppercase;
}
.nrm-online-dot {
    width: 6px;
    height: 6px;
    background: #10B981;
    border-radius: 50%;
    animation: nrm-pulse 2s infinite;
}
.nrm-status-items {
    padding: 1.25rem 1.75rem;
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
}
.nrm-status-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.72rem;
    color: rgba(255,255,255,0.55);
    font-weight: 400;
}
.nrm-status-icon {
    font-size: 0.7rem;
    color: var(--nrm-teal-lt);
    flex-shrink: 0;
    width: 14px;
    text-align: center;
}
.nrm-status-footer {
    padding: 1rem 1.75rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    border-top: 1px solid rgba(255,255,255,0.06);
}
.nrm-uptime-bar {
    flex: 1;
    height: 3px;
    background: rgba(255,255,255,0.08);
    border-radius: 0;
    overflow: hidden;
}
.nrm-uptime-fill {
    height: 100%;
    width: 99.9%;
    background: linear-gradient(90deg, var(--nrm-teal), var(--nrm-teal-lt));
}
.nrm-uptime-label {
    font-family: var(--nrm-font-mono);
    font-size: 0.6rem;
    font-weight: 600;
    color: var(--nrm-teal-lt);
    white-space: nowrap;
}

/* ── Responsive Fixes ───────────────────────────── */
@media (max-width: 640px) {
    .nrm-identity-inner { padding: 0.6rem 1rem; }
    .nrm-hero-content { padding: 1.5rem 1rem 2.5rem; flex-direction: column; align-items: flex-start; }
    .nrm-hero-right { width: 100%; }
    .nrm-hero-data-card { min-width: unset; }
    .nrm-main-grid { padding: 1rem; gap: 1rem; }
    .nrm-panel-body { padding: 1rem 1.25rem; }
    .nrm-panel-head { padding: 1rem 1.25rem; }
}

/* ── Entry Animations ───────────────────────────── */
@keyframes nrm-fade-up {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}
.nrm-hero-content > * {
    animation: nrm-fade-up 0.6s ease both;
}
.nrm-hero-left  { animation-delay: 0.1s; }
.nrm-hero-right { animation-delay: 0.3s; }
.nrm-kpi-card:nth-child(1) { animation: nrm-fade-up 0.5s 0.05s ease both; }
.nrm-kpi-card:nth-child(2) { animation: nrm-fade-up 0.5s 0.12s ease both; }
.nrm-kpi-card:nth-child(3) { animation: nrm-fade-up 0.5s 0.19s ease both; }
.nrm-kpi-card:nth-child(4) { animation: nrm-fade-up 0.5s 0.26s ease both; }
</style>

{{-- ═══════════════════════════════════════════════════════════════
     SCRIPTS — Clock & Live Data
═══════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    // Clock
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2,'0');
        const m = String(now.getMinutes()).padStart(2,'0');
        const s = String(now.getSeconds()).padStart(2,'0');
        const clockEl = document.getElementById('nrm-clock');
        const dateEl  = document.getElementById('nrm-date');
        if (clockEl) clockEl.textContent = `${h}:${m}:${s}`;
        if (dateEl) {
            const opts = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            dateEl.textContent = now.toLocaleDateString('id-ID', opts);
        }
    }
    updateClock();
    setInterval(updateClock, 1000);

    // Pass-rate calculation
    document.addEventListener('DOMContentLoaded', function () {
        const root = document.querySelector('.nrm-root');
        if (!root) return;
        
        const total = parseInt(root.dataset.totalResults || 0);
        const scores = JSON.parse(root.dataset.recentScores || '[]');
        
        const passing = scores.filter(s => s >= 70).length;
        const rate = scores.length > 0 ? Math.round((passing / scores.length) * 100) : 0;

        const valEl = document.getElementById('nrm-pass-rate');
        const barEl = document.getElementById('nrm-pass-bar');
        if (valEl) valEl.textContent = rate + '%';
        if (barEl) setTimeout(() => barEl.style.width = rate + '%', 400);
    });
})();
</script>

@endsection