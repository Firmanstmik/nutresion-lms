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
    overflow: hidden;
}
.sp-stat-item::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: var(--accent, var(--s-navy));
    opacity: 0.2;
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

/* Name cell */
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
.sp-student-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--s-ink);
    transition: color 0.2s ease;
    line-height: 1.3;
}
tr:hover .sp-student-name { color: var(--s-navy); }
.sp-student-role {
    font-size: 0.55rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    color: rgba(107,114,128,0.5);
    text-transform: uppercase;
}

/* NISN chip */
.sp-nisn-chip {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    padding: 0.3rem 0.75rem;
    background: rgba(11,30,63,0.04);
    border: 1px solid rgba(11,30,63,0.08);
    border-radius: 2px;
    font-family: var(--font-mono);
    font-size: 0.68rem;
    font-weight: 600;
    color: var(--s-navy);
    letter-spacing: 0.06em;
    transition: all 0.2s ease;
}
tr:hover .sp-nisn-chip {
    background: rgba(30,64,175,0.06);
    border-color: rgba(30,64,175,0.15);
    color: var(--s-blue);
}

/* School cell */
.sp-school-cell {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.sp-school-icon {
    width: 24px; height: 24px;
    background: var(--s-surface);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.55rem;
    color: var(--s-muted);
    flex-shrink: 0;
    transition: all 0.2s ease;
}
tr:hover .sp-school-icon {
    background: rgba(15,126,110,0.08);
    border-color: rgba(15,126,110,0.2);
    color: var(--s-teal);
}
.sp-school-name {
    font-size: 0.78rem;
    font-weight: 500;
    color: var(--s-muted);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 200px;
    transition: color 0.2s ease;
}
tr:hover .sp-school-name { color: var(--s-ink); }

/* Action buttons */
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

/* Empty */
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
.sp-card-name {
    font-size: 0.88rem;
    font-weight: 600;
    color: var(--s-ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 0.2rem;
}
.sp-card-nisn {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-family: var(--font-mono);
    font-size: 0.58rem;
    font-weight: 600;
    color: var(--s-blue);
    letter-spacing: 0.05em;
}
.sp-card-nisn .fas { font-size: 0.5rem; }

.sp-card-footer {
    padding: 0.6rem 1.1rem 0.6rem 1.4rem;
    border-top: 1px solid var(--s-border);
    background: var(--s-surface);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
}
.sp-card-school {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    min-width: 0;
    flex: 1;
}
.sp-card-school-icon {
    width: 20px; height: 20px;
    background: var(--s-white);
    border: 1px solid var(--s-border);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.48rem;
    color: var(--s-teal);
    flex-shrink: 0;
}
.sp-card-school-info { min-width: 0; }
.sp-card-school-label {
    display: block;
    font-size: 0.45rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    color: rgba(107,114,128,0.5);
    text-transform: uppercase;
}
.sp-card-school-name {
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
    max-width: 480px;
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

/* select arrow */
.sp-select-wrap { position: relative; }
.sp-select-wrap .sp-input-icon:last-child {
    left: auto;
    right: 0.9rem;
    transform: translateY(-50%);
    pointer-events: none;
}

/* optional badge */
.sp-field-label-row {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.sp-optional-tag {
    font-size: 0.48rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    color: rgba(107,114,128,0.4);
    text-transform: uppercase;
    padding: 0.1rem 0.4rem;
    background: var(--s-surface);
    border: 1px solid var(--s-border);
    border-radius: 2px;
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

/* Entry animations */
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
                Manajemen Peserta Didik
            </div>
            <h1 class="sp-header-title">
                Data <em>Peserta</em><br>Program Gizi
            </h1>
            <p class="sp-header-sub">
                Pengelolaan akun dan penempatan institusi peserta program edukasi gizi nasional.
            </p>
            <div class="sp-header-meta">
                <span class="sp-header-chip">
                    <i class="fas fa-users"></i>
                    {{ $students->count() }} Peserta Aktif
                </span>
                <span class="sp-header-chip">
                    <i class="fas fa-id-card"></i>
                    Terverifikasi NISN
                </span>
                <span class="sp-header-chip">
                    <i class="fas fa-shield-halved"></i>
                    Data Terlindungi
                </span>
            </div>
        </div>

        <div class="sp-header-right">
            <button onclick="openAddModal()" class="sp-add-btn">
                <i class="fas fa-user-plus"></i>
                Tambah Peserta
            </button>
        </div>
    </div>

    {{-- ═══ STATS STRIP ═════════════════════════════ --}}
    <div class="sp-stats">
        <div class="sp-stat-item" style="--accent: var(--s-navy)">
            <span class="sp-stat-label">Total Peserta</span>
            <span class="sp-stat-value">{{ str_pad($students->count(), 3, '0', STR_PAD_LEFT) }}</span>
            <span class="sp-stat-unit">Siswa</span>
        </div>
        <div class="sp-stat-item" style="--accent: var(--s-blue)">
            <span class="sp-stat-label">Total Lembaga</span>
            <span class="sp-stat-value">{{ str_pad($schools->count(), 2, '0', STR_PAD_LEFT) }}</span>
            <span class="sp-stat-unit">Institusi</span>
        </div>
        <div class="sp-stat-item" style="--accent: var(--s-teal)">
            <span class="sp-stat-label">Rata-rata / Lembaga</span>
            <span class="sp-stat-value">{{ $schools->count() > 0 ? str_pad((int)($students->count() / $schools->count()), 2, '0', STR_PAD_LEFT) : '00' }}</span>
            <span class="sp-stat-unit">Peserta</span>
        </div>
        <div class="sp-stat-item" style="--accent: var(--s-gold)">
            <span class="sp-stat-label">Data Terakhir</span>
            <span class="sp-stat-value" style="font-size:1rem;padding-top:0.2rem">{{ $students->count() > 0 ? $students->last()->created_at->format('d/m') : '—' }}</span>
            <span class="sp-stat-unit">Pendaftaran</span>
        </div>
    </div>

    {{-- ═══ DESKTOP TABLE ═══════════════════════════ --}}
    <div class="sp-table-wrap">
        <div class="sp-table-toolbar">
            <div class="sp-table-toolbar-left">
                <div class="sp-table-icon"><i class="fas fa-users"></i></div>
                <span class="sp-table-title-text">Daftar Peserta</span>
                <span class="sp-table-count">{{ $students->count() }} entri</span>
            </div>
        </div>

        <table class="sp-table">
            <thead class="sp-thead">
                <tr>
                    <th class="sp-th" style="width:56px">No.</th>
                    <th class="sp-th">Nama Peserta</th>
                    <th class="sp-th">NISN / Username</th>
                    <th class="sp-th">Asal Lembaga</th>
                    <th class="sp-th" style="text-align:right">Tindakan</th>
                </tr>
            </thead>
            <tbody class="sp-tbody">
                @forelse($students as $student)
                <tr>
                    <td class="sp-td">
                        <span class="sp-row-num">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="sp-td">
                        <div class="sp-name-cell">
                            <div class="sp-monogram">{{ substr($student->name, 0, 1) }}</div>
                            <div>
                                <div class="sp-student-name">{{ $student->name }}</div>
                                <div class="sp-student-role">Peserta Program NRM</div>
                            </div>
                        </div>
                    </td>
                    <td class="sp-td">
                        <span class="sp-nisn-chip">
                            <i class="fas fa-id-badge" style="font-size:0.5rem"></i>
                            {{ $student->username }}
                        </span>
                    </td>
                    <td class="sp-td">
                        <div class="sp-school-cell">
                            <div class="sp-school-icon"><i class="fas fa-building-columns"></i></div>
                            <span class="sp-school-name">{{ $student->school->name ?? 'Belum Ditetapkan' }}</span>
                        </div>
                    </td>
                    <td class="sp-td sp-td-actions">
                        <div class="sp-actions-group">
                            <button onclick="editStudent(this)"
                                    data-id="{{ $student->id }}"
                                    data-name="{{ $student->name }}"
                                    data-username="{{ $student->username }}"
                                    data-school_id="{{ $student->school_id }}"
                                    class="sp-action-btn sp-action-edit"
                                    title="Edit">
                                <i class="fas fa-pen"></i>
                            </button>
                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')"
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
                    <td colspan="5" class="sp-empty">
                        <div class="sp-empty-icon"><i class="fas fa-user-graduate"></i></div>
                        <div class="sp-empty-text">Belum ada data peserta yang tercatat.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ═══ MOBILE CARDS ════════════════════════════ --}}
    <div class="sp-mobile-grid">
        @forelse($students as $student)
        <div class="sp-card">
            <div class="sp-card-accent"></div>
            <div class="sp-card-inner">
                <div class="sp-card-monogram">{{ substr($student->name, 0, 1) }}</div>
                <div class="sp-card-info">
                    <div class="sp-card-name">{{ $student->name }}</div>
                    <div class="sp-card-nisn">
                        <i class="fas fa-id-badge"></i>
                        NISN: {{ $student->username }}
                    </div>
                </div>
            </div>
            <div class="sp-card-footer">
                <div class="sp-card-school">
                    <div class="sp-card-school-icon"><i class="fas fa-building-columns"></i></div>
                    <div class="sp-card-school-info">
                        <span class="sp-card-school-label">Asal Lembaga</span>
                        <span class="sp-card-school-name">{{ $student->school->name ?? 'Belum Ditetapkan' }}</span>
                    </div>
                </div>
                <div class="sp-card-btns">
                    <button onclick="editStudent(this)"
                            data-id="{{ $student->id }}"
                            data-name="{{ $student->name }}"
                            data-username="{{ $student->username }}"
                            data-school_id="{{ $student->school_id }}"
                            class="sp-card-btn sp-card-btn-edit">
                        <i class="fas fa-pen"></i>
                    </button>
                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')"
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
            <div class="sp-empty-icon" style="margin:0 auto 0.75rem"><i class="fas fa-user-graduate"></i></div>
            <div class="sp-empty-text">Belum ada data peserta.</div>
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
                <div class="sp-modal-eyebrow">Formulir Pendaftaran</div>
                <div class="sp-modal-title">Tambah Peserta Baru</div>
            </div>
            <button onclick="closeAddModal()" class="sp-modal-close">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="sp-modal-body">
            <form action="{{ route('admin.students.store') }}" method="POST" id="addForm">
                @csrf

                <div class="sp-field">
                    <label class="sp-label">Nama Lengkap Peserta</label>
                    <div class="sp-input-wrap">
                        <i class="fas fa-user sp-input-icon"></i>
                        <input type="text" name="name" required
                               class="sp-input"
                               placeholder="Masukkan nama lengkap">
                    </div>
                </div>

                <div class="sp-field">
                    <div class="sp-field-label-row">
                        <span class="sp-label">NISN</span>
                        <span class="sp-optional-tag">Digunakan sebagai Username &amp; Password</span>
                    </div>
                    <div class="sp-input-wrap">
                        <i class="fas fa-id-badge sp-input-icon"></i>
                        <input type="text" name="username" id="addUsername" required
                               class="sp-input"
                               placeholder="Nomor Induk Siswa Nasional">
                        <input type="hidden" name="password" id="addPasswordField">
                    </div>
                </div>

                <div class="sp-field">
                    <label class="sp-label">Asal Lembaga</label>
                    <div class="sp-input-wrap sp-select-wrap">
                        <i class="fas fa-building-columns sp-input-icon"></i>
                        <select name="school_id" required class="sp-input" style="padding-right:2.4rem">
                            <option value="">Pilih Lembaga Pendidikan</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down sp-input-icon" style="left:auto;right:0.9rem;font-size:0.6rem"></i>
                    </div>
                </div>
            </form>
        </div>

        <div class="sp-modal-foot">
            <button type="submit" form="addForm"
                    onclick="document.getElementById('addPasswordField').value = document.getElementById('addUsername').value"
                    class="sp-submit-btn">
                <i class="fas fa-user-plus"></i>
                Daftarkan Peserta
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
                <div class="sp-modal-eyebrow">Formulir Pembaruan Data</div>
                <div class="sp-modal-title">Edit Data Peserta</div>
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
                    <label class="sp-label">Nama Lengkap</label>
                    <div class="sp-input-wrap">
                        <i class="fas fa-user sp-input-icon"></i>
                        <input type="text" name="name" id="editName" required
                               class="sp-input"
                               placeholder="Nama lengkap peserta">
                    </div>
                </div>

                <div class="sp-field">
                    <label class="sp-label">NISN / Username</label>
                    <div class="sp-input-wrap">
                        <i class="fas fa-id-badge sp-input-icon"></i>
                        <input type="text" name="username" id="editUsername" required
                               class="sp-input"
                               placeholder="Nomor Induk Siswa Nasional">
                    </div>
                </div>

                <div class="sp-field">
                    <div class="sp-field-label-row">
                        <span class="sp-label">Password Baru</span>
                        <span class="sp-optional-tag">Opsional</span>
                    </div>
                    <div class="sp-input-wrap">
                        <i class="fas fa-lock sp-input-icon"></i>
                        <input type="password" name="password"
                               class="sp-input"
                               placeholder="Kosongkan jika tidak diubah">
                    </div>
                </div>

                <div class="sp-field">
                    <label class="sp-label">Asal Lembaga</label>
                    <div class="sp-input-wrap sp-select-wrap">
                        <i class="fas fa-building-columns sp-input-icon"></i>
                        <select name="school_id" id="editSchoolId" required
                                class="sp-input" style="padding-right:2.4rem">
                            <option value="">Pilih Lembaga Pendidikan</option>
                            @foreach($schools as $school)
                                <option value="{{ $school->id }}">{{ $school->name }}</option>
                            @endforeach
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

<script>
/* ── Modal helpers ───────────────────────────────── */
function openModal(id) {
    const bd = document.getElementById(id);
    bd.classList.remove('hidden');
    requestAnimationFrame(() => requestAnimationFrame(() => bd.classList.add('sp-open')));
}
function closeModal(id) {
    const bd = document.getElementById(id);
    bd.classList.remove('sp-open');
    setTimeout(() => bd.classList.add('hidden'), 300);
}

function openAddModal()  { openModal('addModal'); }
function closeAddModal() { closeModal('addModal'); }

function editStudent(btn) {
    document.getElementById('editForm').action   = `/admin/students/${btn.dataset.id}`;
    document.getElementById('editName').value    = btn.dataset.name;
    document.getElementById('editUsername').value = btn.dataset.username;
    document.getElementById('editSchoolId').value = btn.dataset.school_id;
    openModal('editModal');
}
function closeEditModal() { closeModal('editModal'); }

['editModal','addModal'].forEach(id => {
    document.getElementById(id).addEventListener('click', function(e) {
        if (e.target === this) closeModal(id);
    });
});
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { closeModal('editModal'); closeModal('addModal'); }
});
</script>
@endsection