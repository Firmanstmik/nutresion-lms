@once
<style>
    .nt-card { background: #fff; border: 1px solid #E2E8F0; border-radius: 20px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05); overflow: hidden; }
    .nt-card-head { padding: 1rem 1.25rem; border-bottom: 1px solid #E2E8F0; background: rgba(248, 250, 252, 0.6); }
    .nt-tag { font-size: 0.6rem; font-weight: 800; letter-spacing: 0.1em; color: #1B7A3E; text-transform: uppercase; }
    .nt-title { font-size: 1rem; font-weight: 800; color: #0B1E3F; }
    .nt-body { padding: 1.25rem; }
    .nt-label { display: block; font-size: 0.7rem; font-weight: 800; color: #475569; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.35rem; }
    .nt-input { width: 100%; border: 1px solid #CBD5E1; border-radius: 12px; padding: 0.65rem 0.85rem; font-size: 0.95rem; color: #0F172A; background: #fff; }
    .nt-input:focus { outline: 2px solid #1B7A3E; outline-offset: 1px; border-color: #1B7A3E; }
    .nt-input[aria-invalid="true"] { border-color: #E11D48; }
    .nt-hint { font-size: 0.72rem; color: #64748B; margin-top: 0.3rem; }
    .nt-error { font-size: 0.75rem; color: #BE123C; font-weight: 600; margin-top: 0.3rem; }
    .nt-btn { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.7rem 1.25rem; border-radius: 12px; background: #1B7A3E; color: #fff; font-weight: 800; font-size: 0.85rem; border: 0; cursor: pointer; }
    .nt-btn:hover { background: #166534; }
    .nt-btn[disabled] { opacity: 0.55; cursor: not-allowed; }
    .nt-btn-ghost { background: #fff; color: #0B1E3F; border: 1px solid #E2E8F0; }
    .nt-btn-ghost:hover { background: #F8FAFC; }
    .nt-radio { display: flex; align-items: center; gap: 0.5rem; padding: 0.6rem 0.9rem; border: 1px solid #CBD5E1; border-radius: 12px; cursor: pointer; font-weight: 600; font-size: 0.9rem; }
    .nt-radio:has(input:checked) { border-color: #1B7A3E; background: rgba(27, 122, 62, 0.06); }
    .nt-alert { border-radius: 14px; padding: 0.8rem 1rem; font-size: 0.85rem; }
    .nt-alert-err { background: #FFF1F2; border: 1px solid #FECDD3; color: #9F1239; }
    .nt-alert-info { background: #F0F9FF; border: 1px solid #BAE6FD; color: #075985; }
    .nt-badge { display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.3rem 0.7rem; border-radius: 999px; font-size: 0.75rem; font-weight: 800; border: 1px solid; white-space: nowrap; }
    .nt-cat-severely_thinness { background: #FEF2F2; color: #991B1B; border-color: #FECACA; }
    .nt-cat-thinness { background: #FFFBEB; color: #92400E; border-color: #FDE68A; }
    .nt-cat-normal { background: #ECFDF5; color: #065F46; border-color: #A7F3D0; }
    .nt-cat-overweight { background: #FFF7ED; color: #9A3412; border-color: #FED7AA; }
    .nt-cat-obese { background: #FFF1F2; color: #9F1239; border-color: #FECDD3; }
    .nt-stat { border: 1px solid #E2E8F0; border-radius: 14px; padding: 0.8rem 0.9rem; }
    .nt-stat-label { font-size: 0.62rem; font-weight: 800; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; }
    .nt-stat-value { font-size: 1.35rem; font-weight: 800; color: #0B1E3F; line-height: 1.2; }
    .nt-stat-unit { font-size: 0.72rem; font-weight: 600; color: #64748B; }
    .nt-table { width: 100%; font-size: 0.85rem; border-collapse: collapse; }
    .nt-table th { text-align: left; font-size: 0.62rem; font-weight: 800; letter-spacing: 0.08em; text-transform: uppercase; color: #64748B; padding: 0.6rem 0.75rem; border-bottom: 1px solid #E2E8F0; white-space: nowrap; }
    .nt-table td { padding: 0.7rem 0.75rem; border-bottom: 1px solid #F1F5F9; color: #0F172A; white-space: nowrap; }
    .nt-table tr:last-child td { border-bottom: 0; }
</style>
@endonce
