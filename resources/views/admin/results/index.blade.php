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
                Hasil <em>Post-Test</em><br>Siswa Nasional
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
            <span class="sp-stat-value">{{ round($results->avg('score')) }}</span>
            <span class="sp-stat-unit">Poin</span>
        </div>
        <div class="sp-stat-item">
            <span class="sp-stat-label">Total Ujian</span>
            <span class="sp-stat-value">{{ str_pad($results->count(), 3, '0', STR_PAD_LEFT) }}</span>
            <span class="sp-stat-unit">Selesai</span>
        </div>
        <div class="sp-stat-item">
            <span class="sp-stat-label">Tingkat Kelulusan</span>
            <span class="sp-stat-value">
                {{ $results->count() > 0 ? round(($results->where('score', '>=', 70)->count() / $results->count()) * 100) : 0 }}%
            </span>
            <span class="sp-stat-unit">Lulus</span>
        </div>
        <div class="sp-stat-item">
            <span class="sp-stat-label">Skor Tertinggi</span>
            <span class="sp-stat-value">{{ $results->max('score') ?? '00' }}</span>
            <span class="sp-stat-unit">Poin</span>
        </div>
    </div>

    {{-- ═══ CHART SECTION ═══════════════════════════ --}}
    <div class="sp-chart-card">
        <div class="sp-chart-header">
            <h3 class="sp-chart-title"><i class="fas fa-chart-area"></i> Tren Performa Nilai</h3>
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
                        <th class="sp-th">Capaian Skor</th>
                        <th class="sp-th">Waktu Selesai</th>
                        <th class="sp-th" style="text-align: right;">Status</th>
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
                            <div class="sp-score-badge {{ $result->score >= 70 ? 'sp-score-pass' : 'sp-score-fail' }}">
                                {{ $result->score }}
                            </div>
                        </td>
                        <td class="sp-td" style="font-size: 0.72rem; font-weight: 500; color: var(--s-muted);">
                            {{ $result->created_at->format('d/m/Y') }}
                            <span style="display: block; font-size: 0.6rem; opacity: 0.6;">{{ $result->created_at->format('H:i') }} WITA</span>
                        </td>
                        <td class="sp-td" style="text-align: right;">
                            <span class="sp-status-chip {{ $result->score >= 70 ? 'sp-status-pass' : 'sp-status-fail' }}">
                                {{ $result->score >= 70 ? 'Lulus' : 'Gagal' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 4rem; text-align: center;">
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

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
    const resultsData = JSON.parse('{!! addslashes(json_encode($results->take(10)->reverse()->values())) !!}');
    
    const options = {
        series: [{
            name: 'Skor Siswa',
            data: resultsData.map(r => r.score)
        }],
        chart: {
            height: 350,
            type: 'area',
            toolbar: { show: false },
            fontFamily: 'DM Sans, sans-serif'
        },
        colors: ['#0F7E6E'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth', width: 3 },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.45,
                opacityTo: 0.05,
                stops: [20, 100]
            }
        },
        xaxis: {
            categories: resultsData.map(r => r.user.name.split(' ')[0]),
            labels: {
                style: {
                    fontSize: '10px',
                    fontWeight: 600,
                    colors: '#6B7280'
                }
            }
        },
        yaxis: {
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
        }
    };

    const chart = new ApexCharts(document.querySelector("#resultsChart"), options);
    chart.render();
});
</script>

@endsection
