@extends('layouts.app')

@section('content')

<style>
:root {
    --s-navy:     #0B1E3F;
    --s-navy-md:  #122247;
    --s-red:      #C0111E;
    --s-gold:     #C9A84C;
    --s-gold-lt:  #E2C471;
    --s-teal:     #0F7E6E;
    --s-teal-lt:  #14A88F;
    --s-blue:     #1E40AF;
    --s-ink:      #111827;
    --s-muted:    #6B7280;
    --s-border:   #E5E7EB;
    --s-surface:  #F9FAFB;
    --s-white:    #FFFFFF;
    --font-body:    'DM Sans', 'Plus Jakarta Sans', sans-serif;
    --font-display: 'Playfair Display', Georgia, serif;
    --font-mono:    'JetBrains Mono', monospace;
}

.sp-root {
    padding-bottom: 5rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* ══════════════════════════════════════════════
   HEADER BAND
══════════════════════════════════════════════ */
.sp-header {
    position: relative;
    background: var(--s-navy);
    border-radius: 2px;
    overflow: hidden;
    padding: 2.25rem 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.sp-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(201,168,76,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(201,168,76,0.06) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
}
.sp-header::after {
    content: '';
    position: absolute;
    top: 0; left: 0; bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, var(--s-teal), rgba(15,126,110,0.3));
}
.sp-header-stripe {
    position: absolute;
    top: -20px; right: 100px;
    width: 200px; height: 200%;
    background: rgba(255,255,255,0.015);
    transform: skewX(-20deg);
    pointer-events: none;
}

.sp-header-left {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.sp-header-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-family: var(--font-mono);
    font-size: 0.55rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    color: var(--s-gold);
    text-transform: uppercase;
}
.sp-header-eyebrow-dot {
    width: 4px; height: 4px;
    background: var(--s-gold);
    border-radius: 50%;
}
.sp-header-title {
    font-family: var(--font-display);
    font-size: clamp(1.6rem, 3vw, 2.5rem);
    font-weight: 900;
    color: var(--s-white);
    line-height: 1.1;
}
.sp-header-title em {
    font-style: normal;
    color: var(--s-gold);
}
.sp-header-sub {
    font-size: 0.75rem;
    font-weight: 400;
    color: rgba(255,255,255,0.45);
    letter-spacing: 0.01em;
    max-width: 420px;
    margin-top: 0.1rem;
}

/* ══════════════════════════════════════════════
   CHART SECTION
══════════════════════════════════════════════ */
.sp-chart-card {
    background: var(--s-white);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    padding: 1.5rem;
    box-shadow: 0 4px 24px rgba(11,30,63,0.05);
}
.sp-chart-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--s-surface);
    gap: 1rem;
    flex-wrap: wrap;
}
.sp-chart-title {
    font-family: var(--font-display);
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--s-navy);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.sp-chart-title i { color: var(--s-teal); }

.sp-chart-card #resultsChart { min-height: 300px; }
@media (max-width: 639px) {
    .sp-chart-card #resultsChart { min-height: 240px; }
    .sp-export-select { min-width: 100%; }
    .sp-export { width: 100%; }
    .sp-export-dd { width: 100%; }
    .sp-export-trigger { width: 100%; justify-content: space-between; }
    .sp-export-menu { width: 100%; left: 0; right: 0; }
}

.sp-live {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.35rem 0.65rem;
    border-radius: 100px;
    border: 1px solid rgba(15,126,110,0.18);
    background: rgba(15,126,110,0.06);
    font-size: 0.55rem;
    font-weight: 800;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    color: var(--s-teal);
}
.sp-live-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: var(--s-teal);
    box-shadow: 0 0 0 0 rgba(15,126,110,0.45);
    animation: sp-pulse 1.2s infinite;
}
@keyframes sp-pulse {
    0% { box-shadow: 0 0 0 0 rgba(15,126,110,0.45); }
    70% { box-shadow: 0 0 0 10px rgba(15,126,110,0); }
    100% { box-shadow: 0 0 0 0 rgba(15,126,110,0); }
}
.sp-updated {
    font-family: var(--font-mono);
    font-size: 0.6rem;
    font-weight: 600;
    color: rgba(107,114,128,0.75);
    letter-spacing: 0.06em;
}

.sp-export {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
}
.sp-export-select {
    padding: 0.65rem 0.85rem;
    border: 1px solid var(--s-border);
    border-radius: 2px;
    background: var(--s-white);
    font-size: 0.7rem;
    font-weight: 600;
    color: var(--s-ink);
    min-width: 220px;
}
.sp-export-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.55rem;
    padding: 0.65rem 0.95rem;
    border-radius: 2px;
    border: 1px solid var(--s-border);
    background: var(--s-white);
    color: var(--s-ink);
    font-size: 0.65rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    text-decoration: none;
    transition: all 0.2s ease;
}
.sp-export-btn:hover {
    border-color: rgba(15,126,110,0.25);
    background: rgba(15,126,110,0.05);
    color: var(--s-teal);
}
.sp-export-btn-pre:hover {
    border-color: rgba(217,119,6,0.25);
    background: rgba(217,119,6,0.06);
    color: #B45309;
}
.sp-export-btn i { font-size: 0.75rem; }

.sp-export-dd { position: relative; }
.sp-export-trigger {
    display: inline-flex;
    align-items: center;
    gap: 0.55rem;
    padding: 0.65rem 0.95rem;
    border-radius: 2px;
    border: 1px solid var(--s-border);
    background: var(--s-white);
    color: var(--s-ink);
    font-size: 0.65rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.sp-export-trigger:hover {
    border-color: rgba(15,126,110,0.25);
    background: rgba(15,126,110,0.05);
    color: var(--s-teal);
}
.sp-export-trigger-pre:hover {
    border-color: rgba(217,119,6,0.25);
    background: rgba(217,119,6,0.06);
    color: #B45309;
}
.sp-export-menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    width: 220px;
    background: var(--s-white);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    box-shadow: 0 14px 40px rgba(11,30,63,0.16);
    padding: 0.5rem;
    display: none;
    z-index: 50;
}
.sp-export-menu.open { display: block; }
.sp-export-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    padding: 0.75rem 0.85rem;
    border-radius: 2px;
    text-decoration: none;
    color: var(--s-ink);
    font-size: 0.75rem;
    font-weight: 700;
}
.sp-export-item:hover { background: var(--s-surface); color: var(--s-navy); }
.sp-export-item small {
    font-family: var(--font-mono);
    font-size: 0.6rem;
    font-weight: 600;
    color: rgba(107,114,128,0.7);
    letter-spacing: 0.06em;
    text-transform: uppercase;
}

/* ══════════════════════════════════════════════
   STATS STRIP
══════════════════════════════════════════════ */
.sp-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1px;
    background: var(--s-border);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    overflow: hidden;
}
@media (max-width: 639px) { .sp-stats { grid-template-columns: repeat(2, 1fr); } }

.sp-stat-item {
    background: var(--s-white);
    padding: 1.1rem 1.4rem;
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
    position: relative;
}
.sp-stat-label {
    font-size: 0.52rem;
    font-weight: 700;
    letter-spacing: 0.18em;
    color: var(--s-muted);
    text-transform: uppercase;
}
.sp-stat-value {
    font-family: var(--font-mono);
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--s-navy);
    line-height: 1;
}
.sp-stat-unit {
    font-size: 0.52rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    color: rgba(107,114,128,0.5);
    text-transform: uppercase;
}

/* ══════════════════════════════════════════════
   TABLE STYLING
══════════════════════════════════════════════ */
.sp-table-wrap {
    background: var(--s-white);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(11,30,63,0.05);
}
.sp-table-toolbar {
    padding: 1.1rem 1.75rem;
    border-bottom: 1px solid var(--s-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--s-surface);
    flex-wrap: wrap;
    gap: 1rem;
}
.sp-table-toolbar-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.sp-table-icon {
    width: 32px; height: 32px;
    background: var(--s-navy);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    color: var(--s-gold);
}
.sp-table-title-text {
    font-family: var(--font-display);
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--s-navy);
}

.sp-table { width: 100%; border-collapse: collapse; }
.sp-thead { background: var(--s-navy); }
.sp-th {
    padding: 0.85rem 1.5rem;
    font-size: 0.52rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    color: rgba(255,255,255,0.45);
    text-transform: uppercase;
    text-align: left;
}
.sp-td { padding: 1rem 1.5rem; vertical-align: middle; border-bottom: 1px solid var(--s-border); }
tr:last-child .sp-td { border-bottom: none; }

.sp-monogram {
    width: 36px; height: 36px;
    background: var(--s-navy);
    color: var(--s-gold);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-size: 0.95rem;
    font-weight: 700;
    flex-shrink: 0;
}

.sp-score-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 0.85rem;
    border-radius: 2px;
    font-family: var(--font-mono);
    font-size: 0.85rem;
    font-weight: 700;
}
.sp-score-pass { background: rgba(15,126,110,0.08); color: var(--s-teal); border: 1px solid rgba(15,126,110,0.15); }
.sp-score-fail { background: rgba(192,17,30,0.08); color: var(--s-red); border: 1px solid rgba(192,17,30,0.15); }

.sp-status-chip {
    font-size: 0.55rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 0.25rem 0.65rem;
    border-radius: 100px;
}
.sp-status-pass { background: var(--s-teal); color: white; }
.sp-status-fail { background: var(--s-red); color: white; }

.sp-type-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.25rem 0.65rem;
    border-radius: 100px;
    font-size: 0.55rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
}
.sp-type-pre {
    background: rgba(217, 119, 6, 0.1);
    border: 1px solid rgba(217, 119, 6, 0.2);
    color: #B45309;
}
.sp-type-post {
    background: rgba(15, 126, 110, 0.1);
    border: 1px solid rgba(15, 126, 110, 0.2);
    color: var(--s-teal);
}
.sp-action-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: 1px solid var(--s-border);
    border-radius: 2px;
    background: var(--s-white);
    color: var(--s-muted);
    text-decoration: none;
    transition: all 0.2s ease;
}
.sp-action-link:hover {
    border-color: rgba(15, 126, 110, 0.25);
    background: rgba(15, 126, 110, 0.05);
    color: var(--s-teal);
}

/* Search Input */
.sp-search-wrap {
    position: relative;
    width: 100%;
    max-width: 300px;
}
.sp-search-icon {
    position: absolute;
    left: 1rem; top: 50%;
    transform: translateY(-50%);
    font-size: 0.7rem;
    color: var(--s-muted);
}
.sp-search-input {
    width: 100%;
    padding: 0.65rem 1rem 0.65rem 2.4rem;
    background: var(--s-white);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    font-size: 0.75rem;
    font-weight: 500;
    outline: none;
    transition: all 0.2s;
}
.sp-search-input:focus { border-color: var(--s-teal); box-shadow: 0 0 0 3px rgba(15,126,110,0.05); }

/* Animations */
@keyframes sp-fade-up {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.sp-root > * { animation: sp-fade-up 0.4s ease both; }
</style>

<div class="sp-root">
    {{-- ═══ HEADER BAND ════════════════════════════ --}}
    <div class="sp-header">
        <div class="sp-header-stripe"></div>
        <div class="sp-header-left">
            <div class="sp-header-eyebrow">
                <span class="sp-header-eyebrow-dot"></span>
                Monitoring Akademis
            </div>
            <h1 class="sp-header-title">
                Hasil <em>Pre & Post Test</em><br>Siswa Nasional
            </h1>
            <p class="sp-header-sub">
                Pantau capaian pembelajaran dan evaluasi pemahaman gizi dari seluruh peserta didik.
            </p>
        </div>
    </div>

    {{-- ═══ STATS STRIP ═════════════════════════════ --}}
    <div class="sp-stats">
        <div class="sp-stat-item">
            <span class="sp-stat-label">Rata-rata Skor</span>
            <span class="sp-stat-value" id="sp-stat-avg">{{ str_pad((string) round($results->avg('score')), 3, '0', STR_PAD_LEFT) }}</span>
            <span class="sp-stat-unit">Poin</span>
        </div>
        <div class="sp-stat-item">
            <span class="sp-stat-label">Total Ujian</span>
            <span class="sp-stat-value" id="sp-stat-total">{{ str_pad($results->count(), 3, '0', STR_PAD_LEFT) }}</span>
            <span class="sp-stat-unit">Selesai</span>
        </div>
        <div class="sp-stat-item">
            <span class="sp-stat-label">Tingkat Kelulusan</span>
            <span class="sp-stat-value" id="sp-stat-passrate">
                {{ $results->count() > 0 ? round(($results->where('score', '>=', 70)->count() / $results->count()) * 100) : 0 }}%
            </span>
            <span class="sp-stat-unit">Lulus</span>
        </div>
        <div class="sp-stat-item">
            <span class="sp-stat-label">Skor Tertinggi</span>
            <span class="sp-stat-value" id="sp-stat-max">{{ str_pad((string) ($results->max('score') ?? 0), 3, '0', STR_PAD_LEFT) }}</span>
            <span class="sp-stat-unit">Poin</span>
        </div>
    </div>

    {{-- ═══ CHART SECTION ═══════════════════════════ --}}
    <div class="sp-chart-card">
        <div class="sp-chart-header">
            <div style="display:flex; align-items:center; gap:0.9rem; flex-wrap:wrap;">
                <h3 class="sp-chart-title"><i class="fas fa-chart-area"></i> Tren Performa Nilai</h3>
                <span class="sp-live" title="Auto update">
                    <span class="sp-live-dot"></span>
                    Live
                </span>
                <span class="sp-updated" id="sp-last-updated"></span>
            </div>
            <div class="sp-export">
                <select id="sp-school-filter" class="sp-export-select">
                    <option value="all">Semua Sekolah</option>
                    <option value="null">Institusi Umum</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                </select>
                <div class="sp-export-dd">
                    <button type="button" class="sp-export-trigger sp-export-trigger-pre" id="sp-export-pre-trigger">
                        <i class="fas fa-download"></i>
                        Download Pretest
                        <i class="fas fa-chevron-down" style="font-size:0.65rem;opacity:0.7;"></i>
                    </button>
                    <div class="sp-export-menu" id="sp-export-pre-menu">
                        <a class="sp-export-item" id="sp-export-pre-excel" href="{{ route('admin.results.export', ['type' => 'pre']) }}">
                            Excel
                            <small>XLS</small>
                        </a>
                        <a class="sp-export-item" id="sp-export-pre-pdf" href="{{ route('admin.results.export', ['type' => 'pre', 'format' => 'pdf']) }}">
                            PDF
                            <small>PDF</small>
                        </a>
                    </div>
                </div>
                <div class="sp-export-dd">
                    <button type="button" class="sp-export-trigger" id="sp-export-post-trigger">
                        <i class="fas fa-download"></i>
                        Download Posttest
                        <i class="fas fa-chevron-down" style="font-size:0.65rem;opacity:0.7;"></i>
                    </button>
                    <div class="sp-export-menu" id="sp-export-post-menu">
                        <a class="sp-export-item" id="sp-export-post-excel" href="{{ route('admin.results.export', ['type' => 'post']) }}">
                            Excel
                            <small>XLS</small>
                        </a>
                        <a class="sp-export-item" id="sp-export-post-pdf" href="{{ route('admin.results.export', ['type' => 'post', 'format' => 'pdf']) }}">
                            PDF
                            <small>PDF</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div id="resultsChart" style="min-height: 300px;"></div>
    </div>

    {{-- ═══ TABLE DATA ══════════════════════════════ --}}
    <div class="sp-table-wrap">
        <div class="sp-table-toolbar">
            <div class="sp-table-toolbar-left">
                <div class="sp-table-icon"><i class="fas fa-list-check"></i></div>
                <span class="sp-table-title-text">Daftar Hasil Test</span>
            </div>
            <div class="sp-search-wrap">
                <i class="fas fa-search sp-search-icon"></i>
                <input type="text" id="tableSearch" placeholder="Cari nama siswa..." class="sp-search-input">
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="sp-table" id="resultsTable">
                <thead class="sp-thead">
                    <tr>
                        <th class="sp-th" style="width: 60px;">No</th>
                        <th class="sp-th">Peserta</th>
                        <th class="sp-th">Materi Kursus</th>
                        <th class="sp-th" style="width: 140px;">Jenis Test</th>
                        <th class="sp-th">Capaian Skor</th>
                        <th class="sp-th">Waktu Selesai</th>
                        <th class="sp-th" style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)
                    <tr>
                        <td class="sp-td" style="font-family: var(--font-mono); font-size: 0.65rem; color: var(--s-muted);">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </td>
                        <td class="sp-td">
                            <div style="display: flex; align-items: center; gap: 0.85rem;">
                                <div class="sp-monogram">{{ substr($result->user->name, 0, 1) }}</div>
                                <div>
                                    <div style="font-size: 0.85rem; font-weight: 700; color: var(--s-ink);">{{ $result->user->name }}</div>
                                    <div style="font-size: 0.55rem; font-weight: 600; color: var(--s-muted); text-transform: uppercase;">{{ $result->user->school->name ?? 'Institusi Umum' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="sp-td">
                            <div style="font-size: 0.78rem; font-weight: 600; color: var(--s-muted);">{{ $result->course->title }}</div>
                        </td>
                        <td class="sp-td">
                            <span class="sp-type-chip {{ $result->type === 'pre' ? 'sp-type-pre' : 'sp-type-post' }}">
                                <i class="fas {{ $result->type === 'pre' ? 'fa-clipboard-list' : 'fa-trophy' }}" style="font-size:0.6rem;"></i>
                                {{ $result->type === 'pre' ? 'Pre Test' : 'Post Test' }}
                            </span>
                        </td>
                        <td class="sp-td">
                            <div class="sp-score-badge {{ $result->score >= 70 ? 'sp-score-pass' : 'sp-score-fail' }}">
                                {{ $result->score }}
                            </div>
                        </td>
                        <td class="sp-td" style="font-size: 0.72rem; font-weight: 500; color: var(--s-muted);">
                            {{ $result->created_at->format('d/m/Y') }}
                            <span style="display: block; font-size: 0.6rem; opacity: 0.6;">{{ $result->created_at->format('H:i') }} WITA</span>
                        </td>
                        <td class="sp-td" style="text-align: right;">
                            <a class="sp-action-link" href="{{ route('admin.results.show', $result->id) }}" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding: 4rem; text-align: center;">
                            <div style="font-size: 0.72rem; font-weight: 600; color: var(--s-muted); text-transform: uppercase; letter-spacing: 0.1em;">
                                Belum ada data hasil test yang tersedia.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="resultsTrendConfig" data-url="{{ route('admin.results.trend-data') }}" style="display:none;"></div>
<script type="application/json" id="resultsSeedData">{!! json_encode($results->take(10)->reverse()->values()) !!}</script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
(function () {
function initAdminResultsPage() {
    const chartHost = document.querySelector('#resultsChart');
    if (!chartHost) return;
    if (chartHost.dataset.inited === '1') return;
    chartHost.dataset.inited = '1';

    // Search functionality
    const searchInput = document.getElementById('tableSearch');
    const table = document.getElementById('resultsTable');
    const rows = table.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        for (let i = 1; i < rows.length; i++) {
            const nameCell = rows[i].getElementsByTagName('td')[1];
            if (nameCell) {
                const textValue = nameCell.textContent || nameCell.innerText;
                rows[i].style.display = textValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
            }
        }
    });

    // Chart Data
    const seedEl = document.getElementById('resultsSeedData');
    let resultsData = [];
    try {
        resultsData = JSON.parse(seedEl?.textContent || '[]');
    } catch (e) {
        resultsData = [];
    }
    
    const options = {
        series: [{
            name: 'Skor Siswa',
            data: (Array.isArray(resultsData) ? resultsData : []).map(r => r.score)
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false },
            fontFamily: 'DM Sans, sans-serif',
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 650,
                animateGradually: { enabled: true, delay: 120 },
                dynamicAnimation: { enabled: true, speed: 520 }
            }
        },
        colors: ['#0F7E6E'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3.5 },
        markers: {
            size: 4,
            strokeWidth: 2,
            strokeColors: '#FFFFFF',
            hover: { size: 6 }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [20, 100]
            }
        },
        noData: {
            text: 'Belum ada data untuk ditampilkan',
            align: 'center',
            verticalAlign: 'middle',
            style: { color: '#6B7280', fontSize: '12px', fontWeight: 700 }
        },
        xaxis: {
            categories: (Array.isArray(resultsData) ? resultsData : []).map(r => (r?.user?.name || 'Siswa').split(' ')[0]),
            labels: {
                style: {
                    fontSize: '10px',
                    fontWeight: 600,
                    colors: '#6B7280'
                }
            }
        },
        yaxis: {
            min: 0,
            max: 100,
            labels: {
                style: {
                    fontSize: '10px',
                    fontWeight: 600,
                    colors: '#6B7280'
                }
            }
        },
        tooltip: {
            theme: 'dark',
            y: { formatter: (val) => val + " Poin" }
        },
        grid: {
            borderColor: '#F1F1F1',
            padding: { left: 10, right: 10 }
        },
        responsive: [
            {
                breakpoint: 640,
                options: {
                    chart: { height: 260 },
                    stroke: { width: 3 },
                    markers: { size: 3 },
                    xaxis: {
                        labels: { rotate: -45 },
                    },
                },
            },
        ],
    };

    const chart = new ApexCharts(document.querySelector("#resultsChart"), options);
    const renderPromise = chart.render();

    const trendUrl = document.getElementById('resultsTrendConfig')?.dataset?.url || '';
    const schoolFilterEl = document.getElementById('sp-school-filter');
    const statAvgEl = document.getElementById('sp-stat-avg');
    const statTotalEl = document.getElementById('sp-stat-total');
    const statPassEl = document.getElementById('sp-stat-passrate');
    const statMaxEl = document.getElementById('sp-stat-max');
    const lastUpdatedEl = document.getElementById('sp-last-updated');
    let pollId = null;

    function pad3(n) {
        return String(n ?? 0).padStart(3, '0');
    }

    async function refreshTrend() {
        if (!trendUrl) return;
        try {
            const schoolId = schoolFilterEl?.value || 'all';
            const url = trendUrl + '?school_id=' + encodeURIComponent(schoolId);
            const res = await fetch(url, { headers: { Accept: 'application/json' } });
            if (!res.ok) return;
            const data = await res.json();

            const labels = Array.isArray(data?.labels) ? data.labels : [];
            const scores = Array.isArray(data?.scores) ? data.scores : [];

            const numericScores = scores.filter((n) => typeof n === 'number' && !Number.isNaN(n));
            const minScore = numericScores.length ? Math.min(...numericScores) : 0;
            const yMin = Math.max(0, Math.floor(minScore / 10) * 10);

            chart.updateSeries([{ name: 'Skor Siswa', data: scores }], true);
            chart.updateOptions({ xaxis: { categories: labels }, yaxis: { min: yMin, max: 100 } }, false, true);

            const stats = data?.stats || {};
            if (statAvgEl) statAvgEl.textContent = pad3(stats.avg);
            if (statTotalEl) statTotalEl.textContent = pad3(stats.total);
            if (statPassEl) statPassEl.textContent = String(stats.pass_rate ?? 0) + '%';
            if (statMaxEl) statMaxEl.textContent = pad3(stats.max);

            if (lastUpdatedEl) {
                const now = new Date();
                lastUpdatedEl.textContent = 'Update: ' + now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }
        } catch (e) {
        }
    }

    Promise.resolve(renderPromise).then(() => refreshTrend());
    pollId = window.setInterval(refreshTrend, 5000);

    const preTrigger = document.getElementById('sp-export-pre-trigger');
    const preMenu = document.getElementById('sp-export-pre-menu');
    const preExcel = document.getElementById('sp-export-pre-excel');
    const prePdf = document.getElementById('sp-export-pre-pdf');

    const postTrigger = document.getElementById('sp-export-post-trigger');
    const postMenu = document.getElementById('sp-export-post-menu');
    const postExcel = document.getElementById('sp-export-post-excel');
    const postPdf = document.getElementById('sp-export-post-pdf');

    function setExportLinks() {
        const schoolId = schoolFilterEl?.value || 'all';
        const qsExcel = '?school_id=' + encodeURIComponent(schoolId) + '&format=excel';
        const qsPdf = '?school_id=' + encodeURIComponent(schoolId) + '&format=pdf';

        if (preExcel) {
            const base = preExcel.getAttribute('href')?.split('?')[0] || '';
            preExcel.setAttribute('href', base + qsExcel);
        }
        if (prePdf) {
            const base = prePdf.getAttribute('href')?.split('?')[0] || '';
            prePdf.setAttribute('href', base + qsPdf);
        }
        if (postExcel) {
            const base = postExcel.getAttribute('href')?.split('?')[0] || '';
            postExcel.setAttribute('href', base + qsExcel);
        }
        if (postPdf) {
            const base = postPdf.getAttribute('href')?.split('?')[0] || '';
            postPdf.setAttribute('href', base + qsPdf);
        }
    }

    function closeMenus() {
        if (preMenu) preMenu.classList.remove('open');
        if (postMenu) postMenu.classList.remove('open');
    }

    function toggleMenu(menu) {
        if (!menu) return;
        const shouldOpen = !menu.classList.contains('open');
        closeMenus();
        if (shouldOpen) menu.classList.add('open');
    }

    if (schoolFilterEl) {
        schoolFilterEl.addEventListener('change', () => {
            setExportLinks();
            refreshTrend();
        });
        setExportLinks();
    }

    document.addEventListener('visibilitychange', () => {
        if (document.visibilityState === 'visible') refreshTrend();
    });
    window.addEventListener('focus', refreshTrend);

    if (preTrigger) preTrigger.addEventListener('click', () => toggleMenu(preMenu));
    if (postTrigger) postTrigger.addEventListener('click', () => toggleMenu(postMenu));

    document.addEventListener('click', (e) => {
        const inPre = e.target.closest('#sp-export-pre-trigger') || e.target.closest('#sp-export-pre-menu');
        const inPost = e.target.closest('#sp-export-post-trigger') || e.target.closest('#sp-export-post-menu');
        if (inPre || inPost) return;
        closeMenus();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeMenus();
    });
    document.addEventListener('turbo:before-cache', () => {
        if (pollId) window.clearInterval(pollId);
        try { chart.destroy(); } catch (e) {}
        chartHost.dataset.inited = '0';
    });
}

document.addEventListener('DOMContentLoaded', initAdminResultsPage);
document.addEventListener('turbo:load', initAdminResultsPage);
document.addEventListener('livewire:navigated', initAdminResultsPage);
})();
</script>

@endsection
