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
    background: linear-gradient(to bottom, var(--s-blue), rgba(30,64,175,0.3));
}
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
    max-width: 420px;
    margin-top: 0.1rem;
}
.sp-header-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 0.4rem;
    flex-wrap: wrap;
}
.sp-header-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.25rem 0.65rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 2px;
    font-size: 0.58rem;
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
    background: var(--s-blue);
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
    box-shadow: 0 4px 20px rgba(30,64,175,0.35);
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
    background: #1d4ed8;
    box-shadow: 0 6px 28px rgba(30,64,175,0.5);
    transform: translateY(-1px);
}
.sp-add-btn:active { transform: translateY(0); }

.sp-back-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.85rem 1.5rem;
    background: rgba(255,255,255,0.08);
    color: white;
    font-family: var(--font-body);
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 2px;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
    white-space: nowrap;
}
.sp-back-btn:hover {
    background: rgba(255,255,255,0.15);
    border-color: rgba(255,255,255,0.3);
    transform: translateX(-3px);
}
.sp-back-btn i {
    font-size: 0.75rem;
    transition: transform 0.2s ease;
}
.sp-back-btn:hover i {
    transform: translateX(-2px);
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

.sp-td { padding: 1rem 1.5rem; vertical-align: middle; }

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
tr:hover .sp-row-num { color: var(--s-blue); }

.sp-name-cell {
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
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
    transition: all 0.2s ease;
}
tr:hover .sp-monogram {
    background: var(--s-blue);
    color: white;
}
.sp-question-text {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--s-ink);
    transition: color 0.2s ease;
    line-height: 1.3;
}
tr:hover .sp-question-text { color: var(--s-navy); }
.sp-course-title {
    font-size: 0.55rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    color: rgba(107,114,128,0.5);
    text-transform: uppercase;
}

.sp-correct-answer-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.75rem;
    background: rgba(15,126,110,0.08);
    border: 1px solid rgba(15,126,110,0.2);
    border-radius: 2px;
    font-family: var(--font-mono);
    font-size: 0.68rem;
    font-weight: 600;
    color: var(--s-teal);
    letter-spacing: 0.06em;
}
.sp-correct-answer-chip .fas { font-size: 0.5rem; }

.sp-td-actions { text-align: right; }
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
.sp-action-edit:hover { color: var(--s-teal); border-color: var(--s-teal-lt); background: rgba(15,126,110,0.05); }
.sp-action-del:hover  { color: var(--s-red);  border-color: rgba(192,17,30,0.3); background: rgba(192,17,30,0.04); }

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
    background: linear-gradient(to bottom, var(--s-blue), rgba(30,64,175,0.2));
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
.sp-card-question {
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--s-ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 0.2rem;
}
.sp-card-answer {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-family: var(--font-mono);
    font-size: 0.58rem;
    font-weight: 600;
    color: var(--s-teal);
    letter-spacing: 0.05em;
}
.sp-card-answer .fas { font-size: 0.5rem; }

.sp-card-footer {
    padding: 0.6rem 1.1rem 0.6rem 1.4rem;
    border-top: 1px solid var(--s-border);
    background: var(--s-surface);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
}
.sp-card-course {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    min-width: 0;
    flex: 1;
}
.sp-card-course-icon {
    width: 20px; height: 20px;
    background: var(--s-white);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.48rem;
    color: var(--s-muted);
    flex-shrink: 0;
}
.sp-card-course-info { min-width: 0; }
.sp-card-course-label {
    display: block;
    font-size: 0.45rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    color: rgba(107,114,128,0.5);
    text-transform: uppercase;
}
.sp-card-course-name {
    display: block;
    font-size: 0.68rem;
    font-weight: 600;
    color: var(--s-ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 140px;
}
.sp-card-btns {
    display: flex;
    gap: 0.4rem;
    flex-shrink: 0;
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
}
@media (min-width: 640px) {
    .sp-modal-backdrop { align-items: center; padding: 1.5rem; }
}
.sp-modal-backdrop.hidden { display: none; }

.sp-modal {
    background: var(--s-white);
    width: 100%;
    max-width: 640px;
    border-radius: 2px 2px 0 0;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: 92vh;
    box-shadow: 0 -8px 40px rgba(11,30,63,0.15);
    transform: translateY(100%);
    transition: transform 0.3s cubic-bezier(0.4,0,0.2,1), opacity 0.3s ease;
    opacity: 0;
}
@media (min-width: 640px) {
    .sp-modal { border-radius: 2px; transform: translateY(16px); box-shadow: 0 24px 80px rgba(11,30,63,0.18); }
}
.sp-modal-backdrop.sp-open .sp-modal { transform: translateY(0); opacity: 1; }

.sp-modal-head-band {
    background: var(--s-navy);
    padding: 1.1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--s-border);
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
    display: flex;
    flex-direction: column;
    gap: 1.1rem;
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
.sp-input-wrap { position: relative; }
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
    -webkit-appearance: none;
    appearance: none;
}
.sp-input:focus {
    background: var(--s-white);
    border-color: var(--s-teal);
    box-shadow: 0 0 0 3px rgba(15,126,110,0.08);
}
.sp-input::placeholder { color: #D1D5DB; font-weight: 400; }

.sp-select-wrap { position: relative; }
.sp-select-wrap .sp-input-icon:last-child {
    left: auto;
    right: 0.9rem;
    transform: translateY(-50%);
    pointer-events: none;
}

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
.sp-submit-btn:hover { background: var(--s-teal-lt); box-shadow: 0 6px 20px rgba(15,126,110,0.35); transform: translateY(-1px); }
.sp-submit-btn:active { transform: translateY(0); }

@keyframes sp-fade-up {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}
.sp-root > *:nth-child(1) { animation: sp-fade-up 0.4s 0.05s ease both; }
.sp-root > *:nth-child(2) { animation: sp-fade-up 0.4s 0.12s ease both; }
.sp-root > *:nth-child(3) { animation: sp-fade-up 0.4s 0.18s ease both; }
</style>

<div class="sp-root">

    {{-- ═══ HEADER BAND ════════════════════════════ --}}
    <div class="sp-header">
        <div class="sp-header-stripe"></div>
        <div class="sp-header-stripe2"></div>

        <div class="sp-header-left">
            <div class="sp-header-eyebrow">
                <span class="sp-header-eyebrow-dot"></span>
                Manajemen Post Test
            </div>
            <h1 class="sp-header-title">
                Kelola <em>Soal</em><br>Untuk: {{ $course->title }}
            </h1>
            <p class="sp-header-sub">
                Buat, edit, dan hapus pertanyaan untuk post test kursus ini.
            </p>
            <div class="sp-header-meta">
                <span class="sp-header-chip">
                    <i class="fas fa-question-circle"></i>
                    {{ $questions->count() }} Pertanyaan
                </span>
                <span class="sp-header-chip">
                    <i class="fas fa-book"></i>
                    {{ $course->title }}
                </span>
            </div>
        </div>

        <div class="sp-header-right" style="display: flex; gap: 1rem; align-items: center;">
            <a href="{{ route('admin.courses.index') }}" class="sp-back-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            <button onclick="openAddModal()" class="sp-add-btn">
                <i class="fas fa-plus"></i>
                Tambah Pertanyaan
            </button>
        </div>
    </div>

    {{-- ═══ DESKTOP TABLE ═══════════════════════════ --}}
    <div class="sp-table-wrap">
        <div class="sp-table-toolbar">
            <div class="sp-table-toolbar-left">
                <div class="sp-table-icon"><i class="fas fa-question-circle"></i></div>
                <span class="sp-table-title-text">Daftar Pertanyaan</span>
                <span class="sp-table-count">{{ $questions->count() }} entri</span>
            </div>
        </div>

        <table class="sp-table">
            <thead class="sp-thead">
                <tr>
                    <th class="sp-th" style="width:56px">No.</th>
                    <th class="sp-th">Pertanyaan</th>
                    <th class="sp-th">Jawaban Benar</th>
                    <th class="sp-th" style="text-align:right">Tindakan</th>
                </tr>
            </thead>
            <tbody class="sp-tbody">
                @forelse($questions as $question)
                <tr>
                    <td class="sp-td">
                        <span class="sp-row-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="sp-td">
                        <div class="sp-name-cell">
                            <div class="sp-monogram">?</div>
                            <div>
                                <div class="sp-question-text">{{ Str::limit($question->question, 60) }}</div>
                                <div class="sp-course-title">{{ $course->title }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="sp-td">
                        <span class="sp-correct-answer-chip">
                            <i class="fas fa-check"></i>
                            Opsi {{ $question->correct_answer }}
                        </span>
                    </td>
                    <td class="sp-td sp-td-actions">
                        <div class="sp-actions-group">
                            <button onclick="editQuestion(this)"
                                    data-id="{{ $question->id }}"
                                    data-question="{{ $question->question }}"
                                    data-option_a="{{ $question->option_a }}"
                                    data-option_b="{{ $question->option_b }}"
                                    data-option_c="{{ $question->option_c }}"
                                    data-option_d="{{ $question->option_d }}"
                                    data-correct_answer="{{ $question->correct_answer }}"
                                    class="sp-action-btn sp-action-edit"
                                    title="Edit">
                                <i class="fas fa-pen"></i>
                            </button>
                            <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')"
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
                        <div class="sp-empty-icon"><i class="fas fa-question-circle"></i></div>
                        <div class="sp-empty-text">Belum ada data pertanyaan yang tercatat.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ═══ MOBILE CARDS ════════════════════════════ --}}
    <div class="sp-mobile-grid">
        @forelse($questions as $question)
        <div class="sp-card">
            <div class="sp-card-accent"></div>
            <div class="sp-card-inner">
                <div class="sp-card-monogram">?</div>
                <div class="sp-card-info">
                    <div class="sp-card-question">{{ $question->question }}</div>
                    <div class="sp-card-answer">
                        <i class="fas fa-check-circle"></i>
                        Jawaban: {{ $question->correct_answer }}
                    </div>
                </div>
            </div>
            <div class="sp-card-footer">
                <div class="sp-card-course">
                    <div class="sp-card-course-icon"><i class="fas fa-book"></i></div>
                    <div class="sp-card-course-info">
                        <span class="sp-card-course-label">Kursus</span>
                        <span class="sp-card-course-name">{{ $course->title }}</span>
                    </div>
                </div>
                <div class="sp-card-btns">
                    <button onclick="editQuestion(this)"
                            data-id="{{ $question->id }}"
                            data-question="{{ $question->question }}"
                            data-option_a="{{ $question->option_a }}"
                            data-option_b="{{ $question->option_b }}"
                            data-option_c="{{ $question->option_c }}"
                            data-option_d="{{ $question->option_d }}"
                            data-correct_answer="{{ $question->correct_answer }}"
                            class="sp-card-btn sp-card-btn-edit">
                        <i class="fas fa-pen"></i>
                    </button>
                    <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini?')"
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
            <div class="sp-empty-icon" style="margin:0 auto 0.75rem"><i class="fas fa-question-circle"></i></div>
            <div class="sp-empty-text">Belum ada data pertanyaan.</div>
        </div>
        @endforelse
    </div>

</div>{{-- /sp-root --}}

{{-- ═══════════════════════════════════════════════
     ADD MODAL
═══════════════════════════════════════════════ --}}
<div id="addModal" class="sp-modal-backdrop hidden">
    <div class="sp-modal">
        <div class="sp-modal-head-band">
            <div>
                <div class="sp-modal-eyebrow">Formulir Pertanyaan</div>
                <div class="sp-modal-title">Tambah Pertanyaan Baru</div>
            </div>
            <button onclick="closeAddModal()" class="sp-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="sp-modal-body">
            <form action="{{ route('admin.questions.store', $course->id) }}" method="POST" id="addForm">
                @csrf
                <div class="sp-field">
                    <label class="sp-label">Teks Pertanyaan</label>
                    <div class="sp-input-wrap">
                        <i class="fas fa-quote-left sp-input-icon"></i>
                        <textarea name="question" required class="sp-input" placeholder="Masukkan teks pertanyaan" rows="3" style="padding-top:0.8rem; padding-bottom:0.8rem; height:auto;"></textarea>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.1rem;">
                    <div class="sp-field">
                        <label class="sp-label">Opsi A</label>
                        <div class="sp-input-wrap">
                            <i class="fas fa-alpha-a sp-input-icon"></i>
                            <input type="text" name="option_a" required class="sp-input" placeholder="Jawaban A">
                        </div>
                    </div>
                    <div class="sp-field">
                        <label class="sp-label">Opsi B</label>
                        <div class="sp-input-wrap">
                            <i class="fas fa-alpha-b sp-input-icon"></i>
                            <input type="text" name="option_b" required class="sp-input" placeholder="Jawaban B">
                        </div>
                    </div>
                    <div class="sp-field">
                        <label class="sp-label">Opsi C</label>
                        <div class="sp-input-wrap">
                            <i class="fas fa-alpha-c sp-input-icon"></i>
                            <input type="text" name="option_c" required class="sp-input" placeholder="Jawaban C">
                        </div>
                    </div>
                    <div class="sp-field">
                        <label class="sp-label">Opsi D</label>
                        <div class="sp-input-wrap">
                            <i class="fas fa-alpha-d sp-input-icon"></i>
                            <input type="text" name="option_d" required class="sp-input" placeholder="Jawaban D">
                        </div>
                    </div>
                </div>

                <div class="sp-field">
                    <label class="sp-label">Jawaban Benar</label>
                    <div class="sp-input-wrap sp-select-wrap">
                        <i class="fas fa-check-circle sp-input-icon"></i>
                        <select name="correct_answer" required class="sp-input" style="padding-right:2.4rem">
                            <option value="">Pilih Jawaban yang Benar</option>
                            <option value="A">Opsi A</option>
                            <option value="B">Opsi B</option>
                            <option value="C">Opsi C</option>
                            <option value="D">Opsi D</option>
                        </select>
                        <i class="fas fa-chevron-down sp-input-icon" style="left:auto;right:0.9rem;font-size:0.6rem"></i>
                    </div>
                </div>
            </form>
        </div>

        <div class="sp-modal-foot">
            <button type="submit" form="addForm" class="sp-submit-btn">
                <i class="fas fa-plus-circle"></i>
                Simpan Pertanyaan
            </button>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════════
     EDIT MODAL
═══════════════════════════════════════════════ --}}
<div id="editModal" class="sp-modal-backdrop hidden">
    <div class="sp-modal">
        <div class="sp-modal-head-band">
            <div>
                <div class="sp-modal-eyebrow">Formulir Pembaruan</div>
                <div class="sp-modal-title">Edit Pertanyaan</div>
            </div>
            <button onclick="closeEditModal()" class="sp-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="sp-modal-body">
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="sp-field">
                    <label class="sp-label">Teks Pertanyaan</label>
                    <div class="sp-input-wrap">
                        <i class="fas fa-quote-left sp-input-icon"></i>
                        <textarea name="question" id="editQuestion" required class="sp-input" placeholder="Masukkan teks pertanyaan" rows="3" style="padding-top:0.8rem; padding-bottom:0.8rem; height:auto;"></textarea>
                    </div>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.1rem;">
                    <div class="sp-field">
                        <label class="sp-label">Opsi A</label>
                        <div class="sp-input-wrap">
                            <i class="fas fa-alpha-a sp-input-icon"></i>
                            <input type="text" name="option_a" id="editOptionA" required class="sp-input" placeholder="Jawaban A">
                        </div>
                    </div>
                    <div class="sp-field">
                        <label class="sp-label">Opsi B</label>
                        <div class="sp-input-wrap">
                            <i class="fas fa-alpha-b sp-input-icon"></i>
                            <input type="text" name="option_b" id="editOptionB" required class="sp-input" placeholder="Jawaban B">
                        </div>
                    </div>
                    <div class="sp-field">
                        <label class="sp-label">Opsi C</label>
                        <div class="sp-input-wrap">
                            <i class="fas fa-alpha-c sp-input-icon"></i>
                            <input type="text" name="option_c" id="editOptionC" required class="sp-input" placeholder="Jawaban C">
                        </div>
                    </div>
                    <div class="sp-field">
                        <label class="sp-label">Opsi D</label>
                        <div class="sp-input-wrap">
                            <i class="fas fa-alpha-d sp-input-icon"></i>
                            <input type="text" name="option_d" id="editOptionD" required class="sp-input" placeholder="Jawaban D">
                        </div>
                    </div>
                </div>

                <div class="sp-field">
                    <label class="sp-label">Jawaban Benar</label>
                    <div class="sp-input-wrap sp-select-wrap">
                        <i class="fas fa-check-circle sp-input-icon"></i>
                        <select name="correct_answer" id="editCorrectAnswer" required class="sp-input" style="padding-right:2.4rem">
                            <option value="">Pilih Jawaban yang Benar</option>
                            <option value="A">Opsi A</option>
                            <option value="B">Opsi B</option>
                            <option value="C">Opsi C</option>
                            <option value="D">Opsi D</option>
                        </select>
                        <i class="fas fa-chevron-down sp-input-icon" style="left:auto;right:0.9rem;font-size:0.6rem"></i>
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

@endsection

@section('scripts')
<script>
const addModal = document.getElementById('addModal');
const editModal = document.getElementById('editModal');

function openAddModal() {
    addModal.classList.remove('hidden');
    setTimeout(() => addModal.classList.add('sp-open'), 10);
}
function closeAddModal() {
    addModal.classList.remove('sp-open');
    setTimeout(() => addModal.classList.add('hidden'), 300);
}

function openEditModal() {
    editModal.classList.remove('hidden');
    setTimeout(() => editModal.classList.add('sp-open'), 10);
}
function closeEditModal() {
    editModal.classList.remove('sp-open');
    setTimeout(() => editModal.classList.add('hidden'), 300);
}

function editQuestion(button) {
    const data = button.dataset;
    const form = document.getElementById('editForm');

    form.action = `{{ url('admin/questions') }}/${data.id}`;
    document.getElementById('editQuestion').value = data.question;
    document.getElementById('editOptionA').value = data.option_a;
    document.getElementById('editOptionB').value = data.option_b;
    document.getElementById('editOptionC').value = data.option_c;
    document.getElementById('editOptionD').value = data.option_d;
    document.getElementById('editCorrectAnswer').value = data.correct_answer;

    openEditModal();
}

// Close modals on background click
addModal.addEventListener('click', (e) => { if (e.target === addModal) closeAddModal(); });
editModal.addEventListener('click', (e) => { if (e.target === editModal) closeEditModal(); });

</script>
@endsection
