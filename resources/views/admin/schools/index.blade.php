@extends('layouts.app')

@section('content')

<style>
/* ── Root tokens (inherit from navbar palette) ── */
:root {
    --s-navy:     #0B1E3F;
    --s-navy-md:  #122247;
    --s-red:      #C0111E;
    --s-gold:     #C9A84C;
    --s-gold-lt:  #E2C471;
    --s-teal:     #0F7E6E;
    --s-teal-lt:  #14A88F;
    --s-ink:      #111827;
    --s-muted:    #6B7280;
    --s-border:   #E5E7EB;
    --s-surface:  #F9FAFB;
    --s-white:    #FFFFFF;
    --font-body:    'DM Sans', 'Plus Jakarta Sans', sans-serif;
    --font-display: 'Playfair Display', Georgia, serif;
    --font-mono:    'JetBrains Mono', monospace;
}

/* ── Page wrapper ──────────────────────────────── */
.sp-root {
    padding-bottom: 5rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* ══════════════════════════════════════════════
   PAGE HEADER BAND
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
/* grid texture */
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
/* red left accent */
.sp-header::after {
    content: '';
    position: absolute;
    top: 0; left: 0; bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, var(--s-red), rgba(192,17,30,0.3));
}
/* diagonal decorative stripe */
.sp-header-stripe {
    position: absolute;
    top: -20px; right: 100px;
    width: 200px; height: 200%;
    background: rgba(255,255,255,0.015);
    transform: skewX(-20deg);
    pointer-events: none;
}
.sp-header-stripe2 {
    position: absolute;
    top: -20px; right: 60px;
    width: 60px; height: 200%;
    background: rgba(255,255,255,0.02);
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
    max-width: 400px;
    margin-top: 0.1rem;
}
.sp-header-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-top: 0.4rem;
}
.sp-header-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.25rem 0.65rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 2px;
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    color: rgba(255,255,255,0.5);
    text-transform: uppercase;
}
.sp-header-chip .fas { font-size: 0.5rem; color: var(--s-teal-lt); }

.sp-header-right {
    position: relative;
    z-index: 1;
}
.sp-add-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.85rem 2rem;
    background: var(--s-red);
    color: white;
    font-family: var(--font-body);
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: none;
    border-radius: 2px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 20px rgba(192,17,30,0.35);
    white-space: nowrap;
    position: relative;
    overflow: hidden;
}
.sp-add-btn::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
    transform: translateX(-100%);
    transition: transform 0.4s ease;
}
.sp-add-btn:hover::after { transform: translateX(100%); }
.sp-add-btn:hover {
    background: #D4121F;
    box-shadow: 0 6px 28px rgba(192,17,30,0.5);
    transform: translateY(-1px);
}
.sp-add-btn:active { transform: translateY(0); }

/* ══════════════════════════════════════════════
   STATS ROW
══════════════════════════════════════════════ */
.sp-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1px;
    background: var(--s-border);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    overflow: hidden;
}
@media (max-width: 639px) { .sp-stats { grid-template-columns: repeat(3, 1fr); } }

.sp-stat-item {
    background: var(--s-white);
    padding: 1.1rem 1.4rem;
    display: flex;
    flex-direction: column;
    gap: 0.2rem;
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
   DESKTOP TABLE
══════════════════════════════════════════════ */
.sp-table-wrap {
    display: none;
    background: var(--s-white);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(11,30,63,0.05);
}
@media (min-width: 768px) { .sp-table-wrap { display: block; } }

.sp-table-toolbar {
    padding: 1.1rem 1.75rem;
    border-bottom: 1px solid var(--s-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--s-surface);
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
.sp-table-count {
    padding: 0.2rem 0.6rem;
    background: rgba(11,30,63,0.06);
    border: 1px solid rgba(11,30,63,0.08);
    border-radius: 2px;
    font-family: var(--font-mono);
    font-size: 0.6rem;
    font-weight: 600;
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
.sp-th:last-child { text-align: right; }

.sp-tbody tr {
    border-bottom: 1px solid var(--s-border);
    transition: background 0.15s ease;
}
.sp-tbody tr:last-child { border-bottom: none; }
.sp-tbody tr:hover { background: rgba(11,30,63,0.02); }

.sp-td { padding: 1.1rem 1.5rem; }

/* row number */
.sp-row-num {
    font-family: var(--font-mono);
    font-size: 0.65rem;
    font-weight: 600;
    color: rgba(107,114,128,0.4);
    letter-spacing: 0.05em;
    min-width: 28px;
    display: inline-block;
    transition: color 0.2s ease;
}
tr:hover .sp-row-num { color: var(--s-red); }

/* school name cell */
.sp-school-cell {
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
.sp-school-monogram {
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
    transition: all 0.2s ease;
}
tr:hover .sp-school-monogram {
    background: var(--s-teal);
    color: white;
}
.sp-school-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--s-ink);
    transition: color 0.2s ease;
}
tr:hover .sp-school-name { color: var(--s-navy); }
.sp-school-sub {
    font-size: 0.58rem;
    color: var(--s-muted);
    letter-spacing: 0.05em;
    margin-top: 0.1rem;
}

/* student count badge */
.sp-count-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.3rem 0.75rem;
    background: rgba(11,30,63,0.04);
    border: 1px solid rgba(11,30,63,0.08);
    border-radius: 2px;
    font-family: var(--font-mono);
    font-size: 0.65rem;
    font-weight: 600;
    color: var(--s-navy);
    letter-spacing: 0.05em;
    transition: all 0.2s ease;
}
.sp-count-badge .fas { font-size: 0.5rem; color: var(--s-teal); }
tr:hover .sp-count-badge {
    background: rgba(15,126,110,0.08);
    border-color: rgba(15,126,110,0.2);
    color: var(--s-teal);
}

/* action buttons */
.sp-td-actions {
    text-align: right;
}
.sp-actions-group {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
}
.sp-action-btn {
    width: 34px; height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--s-border);
    border-radius: 2px;
    background: var(--s-white);
    cursor: pointer;
    font-size: 0.7rem;
    color: var(--s-muted);
    transition: all 0.2s ease;
}
.sp-action-btn:hover {
    box-shadow: 0 2px 8px rgba(11,30,63,0.08);
}
.sp-action-edit:hover  { color: var(--s-teal); border-color: var(--s-teal-lt); background: rgba(15,126,110,0.05); }
.sp-action-del:hover   { color: var(--s-red);  border-color: rgba(192,17,30,0.3); background: rgba(192,17,30,0.04); }

/* empty state */
.sp-empty {
    padding: 4rem 2rem;
    text-align: center;
}
.sp-empty-icon {
    width: 52px; height: 52px;
    background: var(--s-surface);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    color: #D1D5DB;
    margin: 0 auto 0.85rem;
}
.sp-empty-text {
    font-size: 0.72rem;
    font-weight: 600;
    color: var(--s-muted);
    letter-spacing: 0.08em;
    text-transform: uppercase;
}

/* ══════════════════════════════════════════════
   MOBILE CARDS
══════════════════════════════════════════════ */
.sp-mobile-grid {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}
@media (min-width: 768px) { .sp-mobile-grid { display: none; } }

.sp-card {
    background: var(--s-white);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    overflow: hidden;
    position: relative;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}
.sp-card:hover {
    border-color: rgba(11,30,63,0.15);
    box-shadow: 0 4px 20px rgba(11,30,63,0.07);
}
.sp-card-accent {
    position: absolute;
    top: 0; left: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(to bottom, var(--s-teal), rgba(15,126,110,0.2));
}
.sp-card-inner {
    padding: 1rem 1.1rem 1rem 1.4rem;
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
.sp-card-monogram {
    width: 42px; height: 42px;
    border-radius: 2px;
    background: var(--s-navy);
    color: var(--s-gold);
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 700;
    flex-shrink: 0;
}
.sp-card-info { flex: 1; min-width: 0; }
.sp-card-name {
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--s-ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 0.2rem;
}
.sp-card-meta {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    font-family: var(--font-mono);
    font-size: 0.58rem;
    font-weight: 600;
    color: var(--s-teal);
    letter-spacing: 0.05em;
}
.sp-card-meta .fas { font-size: 0.5rem; }

.sp-card-footer {
    padding: 0.6rem 1.1rem 0.6rem 1.4rem;
    border-top: 1px solid var(--s-border);
    background: var(--s-surface);
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.sp-card-footer-label {
    font-size: 0.52rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    color: rgba(107,114,128,0.5);
    text-transform: uppercase;
}
.sp-card-btns {
    display: flex;
    gap: 0.4rem;
}
.sp-card-btn {
    width: 32px; height: 32px;
    border: 1px solid var(--s-border);
    border-radius: 2px;
    background: var(--s-white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.68rem;
    cursor: pointer;
    transition: all 0.2s ease;
}
.sp-card-btn-edit { color: var(--s-teal); }
.sp-card-btn-edit:hover { background: rgba(15,126,110,0.06); border-color: var(--s-teal-lt); }
.sp-card-btn-del  { color: var(--s-red); }
.sp-card-btn-del:hover  { background: rgba(192,17,30,0.05); border-color: rgba(192,17,30,0.3); }

.sp-mobile-empty {
    background: var(--s-white);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    padding: 3rem 1.5rem;
    text-align: center;
}

/* ══════════════════════════════════════════════
   MODALS
══════════════════════════════════════════════ */
.sp-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(11,30,63,0.65);
    backdrop-filter: blur(6px);
    z-index: 100;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding: 0;
    transition: opacity 0.25s ease;
}
@media (min-width: 640px) {
    .sp-modal-backdrop { align-items: center; padding: 1.5rem; }
}

.sp-modal-backdrop.hidden { display: none; }

.sp-modal {
    background: var(--s-white);
    width: 100%;
    max-width: 460px;
    border-radius: 2px 2px 0 0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: 90vh;
    box-shadow: 0 -8px 40px rgba(11,30,63,0.15);
    transform: translateY(100%);
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
}
@media (min-width: 640px) {
    .sp-modal {
        border-radius: 2px;
        transform: translateY(20px);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
        box-shadow: 0 24px 80px rgba(11,30,63,0.18);
    }
}

/* open state */
.sp-modal-backdrop.sp-open .sp-modal {
    transform: translateY(0);
    opacity: 1;
}

.sp-modal-head {
    padding: 0;
    border-bottom: 1px solid var(--s-border);
    flex-shrink: 0;
}
.sp-modal-head-band {
    background: var(--s-navy);
    padding: 1.1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.sp-modal-eyebrow {
    font-family: var(--font-mono);
    font-size: 0.5rem;
    font-weight: 600;
    letter-spacing: 0.2em;
    color: var(--s-gold);
    text-transform: uppercase;
    margin-bottom: 0.25rem;
}
.sp-modal-title {
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--s-white);
}
.sp-modal-close {
    width: 32px; height: 32px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255,255,255,0.6);
    cursor: pointer;
    font-size: 0.75rem;
    transition: all 0.2s ease;
    flex-shrink: 0;
}
.sp-modal-close:hover { background: rgba(192,17,30,0.3); border-color: rgba(192,17,30,0.4); color: white; }

.sp-modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    flex: 1;
}
.sp-modal-body::-webkit-scrollbar { width: 4px; }
.sp-modal-body::-webkit-scrollbar-thumb { background: rgba(11,30,63,0.1); border-radius: 0; }

.sp-field { display: flex; flex-direction: column; gap: 0.4rem; }
.sp-label {
    font-size: 0.52rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    color: var(--s-muted);
    text-transform: uppercase;
    padding-left: 0.1rem;
}
.sp-input-wrap {
    position: relative;
}
.sp-input-icon {
    position: absolute;
    top: 50%; left: 0.9rem;
    transform: translateY(-50%);
    font-size: 0.75rem;
    color: rgba(107,114,128,0.4);
    pointer-events: none;
    transition: color 0.2s ease;
}
.sp-input-wrap:focus-within .sp-input-icon { color: var(--s-teal); }
.sp-input {
    display: block;
    width: 100%;
    padding: 0.8rem 0.9rem 0.8rem 2.4rem;
    background: var(--s-surface);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    font-family: var(--font-body);
    font-size: 0.82rem;
    font-weight: 500;
    color: var(--s-ink);
    outline: none;
    transition: all 0.2s ease;
}
.sp-input:focus {
    background: var(--s-white);
    border-color: var(--s-teal);
    box-shadow: 0 0 0 3px rgba(15,126,110,0.08);
}
.sp-input::placeholder { color: #D1D5DB; font-weight: 400; }

.sp-modal-foot {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--s-border);
    background: var(--s-surface);
    flex-shrink: 0;
}
.sp-submit-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    padding: 0.85rem;
    background: var(--s-teal);
    color: white;
    font-family: var(--font-body);
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    border: none;
    border-radius: 2px;
    cursor: pointer;
    transition: all 0.2s ease;
    box-shadow: 0 4px 16px rgba(15,126,110,0.25);
}
.sp-submit-btn:hover {
    background: var(--s-teal-lt);
    box-shadow: 0 6px 20px rgba(15,126,110,0.35);
    transform: translateY(-1px);
}
.sp-submit-btn:active { transform: translateY(0); }

/* ── Entry animation ────────────────────────── */
@keyframes sp-fade-up {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.sp-root > * {
    animation: sp-fade-up 0.4s ease both;
}
.sp-root > *:nth-child(1) { animation-delay: 0.05s; }
.sp-root > *:nth-child(2) { animation-delay: 0.12s; }
.sp-root > *:nth-child(3) { animation-delay: 0.18s; }
</style>

<div class="sp-root">

    {{-- ═══ PAGE HEADER ════════════════════════════ --}}
    <div class="sp-header">
        <div class="sp-header-stripe"></div>
        <div class="sp-header-stripe2"></div>

        <div class="sp-header-left">
            <div class="sp-header-eyebrow">
                <span class="sp-header-eyebrow-dot"></span>
                Manajemen Institusi
            </div>
            <h1 class="sp-header-title">
                Data <em>Lembaga</em><br>Pendidikan
            </h1>
            <p class="sp-header-sub">
                Registrasi dan pengelolaan institusi mitra program gizi nasional.
            </p>
            <div class="sp-header-meta">
                <span class="sp-header-chip">
                    <i class="fas fa-building-columns"></i>
                    {{ $schools->count() }} Lembaga Terdaftar
                </span>
                <span class="sp-header-chip">
                    <i class="fas fa-shield-halved"></i>
                    Data Terverifikasi
                </span>
            </div>
        </div>

        <div class="sp-header-right">
            <button onclick="openAddModal()" class="sp-add-btn">
                <i class="fas fa-plus"></i>
                Tambah Lembaga
            </button>
        </div>
    </div>

    {{-- ═══ STATS STRIP ═════════════════════════════ --}}
    <div class="sp-stats">
        <div class="sp-stat-item">
            <span class="sp-stat-label">Total Lembaga</span>
            <span class="sp-stat-value">{{ str_pad($schools->count(), 2, '0', STR_PAD_LEFT) }}</span>
            <span class="sp-stat-unit">Institusi</span>
        </div>
        <div class="sp-stat-item">
            <span class="sp-stat-label">Total Peserta</span>
            <span class="sp-stat-value">{{ str_pad($schools->sum(fn($s) => $s->users->count()), 3, '0', STR_PAD_LEFT) }}</span>
            <span class="sp-stat-unit">Siswa</span>
        </div>
        <div class="sp-stat-item">
            <span class="sp-stat-label">Rata-rata Siswa</span>
            <span class="sp-stat-value">{{ $schools->count() > 0 ? str_pad((int)($schools->sum(fn($s) => $s->users->count()) / $schools->count()), 2, '0', STR_PAD_LEFT) : '00' }}</span>
            <span class="sp-stat-unit">/ Lembaga</span>
        </div>
    </div>

    {{-- ═══ DESKTOP TABLE ═══════════════════════════ --}}
    <div class="sp-table-wrap">
        <div class="sp-table-toolbar">
            <div class="sp-table-toolbar-left">
                <div class="sp-table-icon"><i class="fas fa-table"></i></div>
                <span class="sp-table-title-text">Daftar Lembaga</span>
                <span class="sp-table-count">{{ $schools->count() }} entri</span>
            </div>
        </div>

        <table class="sp-table">
            <thead class="sp-thead">
                <tr>
                    <th class="sp-th" style="width:60px">No.</th>
                    <th class="sp-th">Nama Lembaga</th>
                    <th class="sp-th">Total Peserta</th>
                    <th class="sp-th" style="text-align:right">Tindakan</th>
                </tr>
            </thead>
            <tbody class="sp-tbody">
                @forelse($schools as $school)
                <tr>
                    <td class="sp-td">
                        <span class="sp-row-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="sp-td">
                        <div class="sp-school-cell">
                            <div class="sp-school-monogram">{{ substr($school->name, 0, 1) }}</div>
                            <div>
                                <div class="sp-school-name">{{ $school->name }}</div>
                                <div class="sp-school-sub">Lembaga Mitra NRM</div>
                            </div>
                        </div>
                    </td>
                    <td class="sp-td">
                        <span class="sp-count-badge">
                            <i class="fas fa-users"></i>
                            {{ $school->users->count() }} PESERTA
                        </span>
                    </td>
                    <td class="sp-td sp-td-actions">
                        <div class="sp-actions-group">
                            <button onclick="editSchool(this)"
                                    data-id="{{ $school->id }}"
                                    data-name="{{ $school->name }}"
                                    class="sp-action-btn sp-action-edit"
                                    title="Edit">
                                <i class="fas fa-pen"></i>
                            </button>
                            <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus sekolah ini?')"
                                  style="display:contents">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="sp-action-btn sp-action-del" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="sp-empty">
                        <div class="sp-empty-icon"><i class="fas fa-building-columns"></i></div>
                        <div class="sp-empty-text">Belum ada data lembaga yang tercatat.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ═══ MOBILE CARDS ════════════════════════════ --}}
    <div class="sp-mobile-grid">
        @forelse($schools as $school)
        <div class="sp-card">
            <div class="sp-card-accent"></div>
            <div class="sp-card-inner">
                <div class="sp-card-monogram">{{ substr($school->name, 0, 1) }}</div>
                <div class="sp-card-info">
                    <div class="sp-card-name">{{ $school->name }}</div>
                    <div class="sp-card-meta">
                        <i class="fas fa-users"></i>
                        {{ $school->users->count() }} Peserta Terdaftar
                    </div>
                </div>
            </div>
            <div class="sp-card-footer">
                <span class="sp-card-footer-label">Tindakan Cepat</span>
                <div class="sp-card-btns">
                    <button onclick="editSchool(this)"
                            data-id="{{ $school->id }}"
                            data-name="{{ $school->name }}"
                            class="sp-card-btn sp-card-btn-edit">
                        <i class="fas fa-pen"></i>
                    </button>
                    <form action="{{ route('admin.schools.destroy', $school->id) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus sekolah ini?')"
                          style="display:contents">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="sp-card-btn sp-card-btn-del">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="sp-mobile-empty">
            <div class="sp-empty-icon" style="margin:0 auto 0.75rem"><i class="fas fa-building-columns"></i></div>
            <div class="sp-empty-text">Belum ada data lembaga.</div>
        </div>
        @endforelse
    </div>

</div>{{-- /sp-root --}}

{{-- ═══════════════════════════════════════════════
     EDIT MODAL
═══════════════════════════════════════════════ --}}
<div id="editModal" class="sp-modal-backdrop hidden">
    <div class="sp-modal">
        <div class="sp-modal-head">
            <div class="sp-modal-head-band">
                <div>
                    <div class="sp-modal-eyebrow">Formulir Pembaruan</div>
                    <div class="sp-modal-title">Edit Lembaga</div>
                </div>
                <button onclick="closeEditModal()" class="sp-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="sp-modal-body">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="sp-field">
                    <label class="sp-label">Nama Lembaga</label>
                    <div class="sp-input-wrap">
                        <i class="fas fa-building-columns sp-input-icon"></i>
                        <input type="text" name="name" id="editName" required
                               class="sp-input"
                               placeholder="Nama lembaga pendidikan">
                    </div>
                </div>
            </form>
        </div>

        <div class="sp-modal-foot">
            <button type="submit" form="editForm" class="sp-submit-btn">
                <i class="fas fa-floppy-disk"></i>
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     ADD MODAL
═══════════════════════════════════════════════ --}}
<div id="addModal" class="sp-modal-backdrop hidden">
    <div class="sp-modal">
        <div class="sp-modal-head">
            <div class="sp-modal-head-band">
                <div>
                    <div class="sp-modal-eyebrow">Formulir Pendaftaran</div>
                    <div class="sp-modal-title">Tambah Lembaga Baru</div>
                </div>
                <button onclick="closeAddModal()" class="sp-modal-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="sp-modal-body">
            <form action="{{ route('admin.schools.store') }}" method="POST" id="addForm">
                @csrf
                <div class="sp-field">
                    <label class="sp-label">Nama Lembaga</label>
                    <div class="sp-input-wrap">
                        <i class="fas fa-building-columns sp-input-icon"></i>
                        <input type="text" name="name" required
                               class="sp-input"
                               placeholder="Masukkan nama lembaga pendidikan">
                    </div>
                </div>
            </form>
        </div>

        <div class="sp-modal-foot">
            <button type="submit" form="addForm" class="sp-submit-btn">
                <i class="fas fa-plus"></i>
                Daftarkan Lembaga
            </button>
        </div>
    </div>
</div>

<script>
/* ── Modal helpers ───────────────────────────────────── */
function openModal(id) {
    const backdrop = document.getElementById(id);
    backdrop.classList.remove('hidden');
    // trigger open animation
    requestAnimationFrame(() => {
        requestAnimationFrame(() => backdrop.classList.add('sp-open'));
    });
}

function closeModal(id) {
    const backdrop = document.getElementById(id);
    backdrop.classList.remove('sp-open');
    setTimeout(() => backdrop.classList.add('hidden'), 300);
}

function openAddModal()  { openModal('addModal'); }
function closeAddModal() { closeModal('addModal'); }

function editSchool(btn) {
    const id   = btn.getAttribute('data-id');
    const name = btn.getAttribute('data-name');
    document.getElementById('editForm').action = `/admin/schools/${id}`;
    document.getElementById('editName').value  = name;
    openModal('editModal');
}
function closeEditModal() { closeModal('editModal'); }

/* close on backdrop click */
['editModal','addModal'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) closeModal(id);
    });
});

/* close on Escape */
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeModal('editModal'); closeModal('addModal'); }
});
</script>
@endsection