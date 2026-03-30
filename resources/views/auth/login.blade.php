@extends('layouts.app')

@section('no-container', true)
@section('body-class', 'm-0 p-0 overflow-hidden')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=DM+Serif+Display:ital@0;1&display=swap');

    :root {
        --green:     #1B7A3E;
        --gm:        #22943C;
        --gl:        #2DBD54;
        --red:       #CC2929;
        --gold:      #E8AA2A;
        --cream:     #F5F8F5;
        --ink:       #18261C;
        --muted:     #5A7262;
        --border:    #CDE3D5;
        --white:     #FFFFFF;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    /* ── DESKTOP: fixed full-viewport, no scroll ── */
    html { height: 100%; }
    body { height: 100%; font-family: 'Plus Jakarta Sans', sans-serif; }

    .nrm-root {
        display: flex;
        height: 100vh;
        overflow: hidden;
        background: var(--cream);
    }

    /* ════════════════════════════
       LEFT PANEL  (desktop)
    ════════════════════════════ */
    .nrm-left {
        width: 50%;
        height: 100vh;
        flex-shrink: 0;
        background: linear-gradient(155deg, rgba(12, 61, 30, 0.7) 0%, rgba(23, 92, 49, 0.7) 48%, rgba(27, 122, 62, 0.7) 100%), var(--bg-desktop) no-repeat center center;
        background-size: cover;
        display: flex;
        flex-direction: column;
        padding: 48px 60px;
        position: relative;
        overflow: hidden;
    }

    /* Merah-putih flag stripe */
    .lp-flag {
        position: absolute; top: 0; left: 0; right: 0; height: 5px;
        background: linear-gradient(90deg, var(--red) 50%, rgba(255,255,255,.85) 50%);
    }

    /* Background texture */
    .lp-tex {
        position: absolute; inset: 0;
        background-image:
            repeating-linear-gradient(-55deg,
                rgba(255,255,255,.02) 0, rgba(255,255,255,.02) 1px,
                transparent 1px, transparent 44px),
            radial-gradient(ellipse at 80% 80%, rgba(45,189,84,.1) 0%, transparent 55%),
            radial-gradient(ellipse at 15% 20%, rgba(255,255,255,.04) 0%, transparent 45%);
        pointer-events: none;
    }

    /* Decorative ring */
    .lp-ring {
        position: absolute; bottom: -90px; right: -90px;
        width: 340px; height: 340px; border-radius: 50%;
        border: 1.5px solid rgba(255,255,255,.07);
        pointer-events: none;
    }
    .lp-ring-2 {
        position: absolute; bottom: -45px; right: -45px;
        width: 200px; height: 200px; border-radius: 50%;
        border: 1.5px solid rgba(255,255,255,.05);
        background: rgba(255,255,255,.02);
        pointer-events: none;
    }

    /* Top logo row */
    .lp-logo { position: relative; z-index:2; display: flex; align-items: center; gap: 14px; }
    .lp-logo-box {
        width: auto; height: auto;
        background: none; border: none;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; backdrop-filter: none;
    }
    .lp-logo-box img { width: 72px; height: 72px; object-fit: contain; }
    .lp-app-name { font-size: 14px; font-weight: 800; color: white; line-height: 1.2; }
    .lp-app-tag  { font-size: 9.5px; font-weight: 600; color: rgba(255,255,255,.45); letter-spacing: .12em; text-transform: uppercase; margin-top: 2px; }

    /* Mid hero */
    .lp-mid {
        position: relative; z-index:2;
        flex: 1; display: flex; flex-direction: column; justify-content: center;
        padding: 8px 0;
    }
    .lp-mid-flex {
        display: flex;
        align-items: flex-start;
        gap: 32px;
        margin-bottom: 24px;
    }
    .lp-mid-logo {
        flex-shrink: 0;
        width: 220px;
        height: 220px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .lp-mid-logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        filter: drop-shadow(0 0 15px rgba(255, 255, 255, 0.7));
    }
    .lp-mid-content {
        flex: 1;
    }

    .lp-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 12px; border-radius: 100px;
        background: rgba(232,170,42,.14); border: 1px solid rgba(232,170,42,.28);
        font-size: 9.5px; font-weight: 800; color: var(--gold);
        letter-spacing: .12em; text-transform: uppercase;
        margin-bottom: 18px;
    }
    .lp-pill::before { content: '◆'; font-size: 6px; opacity: .75; }

    .lp-heading {
        font-family: 'DM Serif Display', serif;
        font-size: 36px; color: white; line-height: 1.12;
        margin-bottom: 16px; letter-spacing: -.01em;
    }
    .lp-heading .hl { color: var(--gold); font-style: italic; }

    .lp-desc {
        font-size: 13px; color: rgba(255,255,255,.56); line-height: 1.78;
        max-width: 300px; margin-bottom: 28px;
    }

    /* Feature list */
    .lp-feats { display: flex; flex-direction: column; gap: 10px; }
    .lp-feat  { display: flex; align-items: center; gap: 10px; }
    .lp-feat-icon {
        width: 28px; height: 28px; border-radius: 8px; flex-shrink: 0;
        background: rgba(255,255,255,.08); border: 1px solid rgba(255,255,255,.11);
        display: flex; align-items: center; justify-content: center;
    }
    .lp-feat-icon svg { color: rgba(255,255,255,.7); }
    .lp-feat-text { font-size: 12px; font-weight: 600; color: rgba(255,255,255,.58); line-height: 1.4; }
    .lp-feat-text strong { color: rgba(255,255,255,.85); font-weight: 700; }

    /* Bottom card */
    .lp-bottom { position: relative; z-index:2; }
    .lp-card {
        padding: 14px 16px;
        background: rgba(255,255,255,.06); border: 1px solid rgba(255,255,255,.09);
        border-radius: 14px; backdrop-filter: blur(6px);
    }
    .lp-card-head { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
    .lp-card-icon {
        width: 26px; height: 26px; border-radius: 7px;
        background: rgba(232,170,42,.18); border: 1px solid rgba(232,170,42,.28);
        display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .lp-card-label { font-size: 9.5px; font-weight: 800; color: var(--gold); letter-spacing: .1em; text-transform: uppercase; }
    .lp-card-desc  { font-size: 10.5px; color: rgba(255,255,255,.42); line-height: 1.65; }
    .lp-card-tags  { display: flex; gap: 6px; margin-top: 9px; flex-wrap: wrap; }
    .lp-tag {
        display: inline-flex; align-items: center; gap: 4px; padding: 3px 9px;
        border-radius: 100px; background: rgba(255,255,255,.07); border: 1px solid rgba(255,255,255,.1);
        font-size: 8.5px; font-weight: 700; color: rgba(255,255,255,.48);
        letter-spacing: .05em; text-transform: uppercase;
    }

    /* ════════════════════════════
       RIGHT PANEL  (desktop)
    ════════════════════════════ */
    .nrm-right {
        flex: 1; height: 100vh; overflow: hidden;
        display: flex; align-items: center; justify-content: center;
        padding: 0 48px;
        position: relative; background: var(--cream);
    }

    .rp-bg {
        position: absolute; inset: 0;
        background:
            radial-gradient(ellipse at 55% 0%, rgba(27,122,62,.07) 0%, transparent 48%),
            radial-gradient(ellipse at 100% 100%, rgba(27,122,62,.04) 0%, transparent 42%);
        pointer-events: none;
    }
    .rp-arc {
        position: absolute; top: -110px; right: -110px;
        width: 360px; height: 360px; border-radius: 50%;
        border: 1.5px solid rgba(27,122,62,.07); pointer-events: none;
    }
    .rp-arc-2 {
        position: absolute; top: -55px; right: -55px;
        width: 200px; height: 200px; border-radius: 50%;
        border: 1.5px solid rgba(27,122,62,.05); pointer-events: none;
    }

    .rp-inner { position: relative; z-index:2; width: 100%; max-width: 380px; }

    /* National badge */
    .nb-bar {
        display: flex; align-items: center; gap: 9px; padding: 9px 12px;
        background: linear-gradient(135deg,rgba(27,122,62,.07),rgba(27,122,62,.03));
        border: 1px solid rgba(27,122,62,.12); border-radius: 11px; margin-bottom: 20px;
    }
    .nb-ico {
        width: 28px; height: 28px;
        background: linear-gradient(135deg,var(--green),var(--gm));
        border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink:0;
    }
    .nb-t { font-size: 10.5px; font-weight: 700; color: var(--green); line-height: 1.3; }
    .nb-s { font-size: 9px;    font-weight: 500; color: var(--muted); margin-top: 1px; }

    /* Eyebrow + title */
    .rp-eyebrow { display: flex; align-items: center; gap: 7px; margin-bottom: 6px; }
    .rp-dot {
        width: 7px; height: 7px; border-radius: 50%; background: var(--green);
        box-shadow: 0 0 8px rgba(27,122,62,.5); animation: glow 2.5s ease-in-out infinite;
    }
    @keyframes glow {
        0%,100% { box-shadow: 0 0 6px rgba(27,122,62,.4); }
        50%      { box-shadow: 0 0 14px rgba(27,122,62,.75); }
    }
    .rp-eyebrow span { font-size: 10px; font-weight: 800; color: var(--green); letter-spacing: .18em; text-transform: uppercase; }
    .rp-title  { font-family: 'DM Serif Display', serif; font-size: 30px; color: var(--ink); line-height: 1.12; margin-bottom: 6px; }
    .rp-title .hl { color: var(--green); }
    .rp-sub    { font-size: 12.5px; color: var(--muted); line-height: 1.7; margin-bottom: 22px; }

    /* Login card */
    .login-card {
        background: white; border-radius: 18px; padding: 24px 24px 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,.04), 0 12px 36px rgba(27,122,62,.09), 0 0 0 1px rgba(27,122,62,.07);
        animation: cardIn .5s cubic-bezier(.22,1,.36,1) both;
    }
    @keyframes cardIn { from{opacity:0;transform:translateY(18px)} to{opacity:1;transform:translateY(0)} }

    /* Error */
    .err-alert {
        display: flex; align-items: flex-start; gap: 9px; padding: 10px 13px;
        background: #FEF2F2; border: 1px solid #FECACA; border-radius: 11px; margin-bottom: 16px;
    }
    .err-alert i { color: var(--red); font-size: 13px; margin-top: 1px; }
    .err-alert p { font-size: 12.5px; font-weight: 600; color: #991B1B; line-height: 1.4; }

    /* Fields */
    .fg { margin-bottom: 14px; }
    .fl {
        display: block; font-size: 9.5px; font-weight: 800; color: var(--muted);
        text-transform: uppercase; letter-spacing: .15em; margin-bottom: 6px;
    }
    .fw { position: relative; }
    .fi-ic {
        position: absolute; left:0; top:0; bottom:0; width: 40px;
        display: flex; align-items: center; justify-content: center;
        color: #AABDB3; font-size: 12px; pointer-events: none; transition: color .2s;
    }
    .fw:focus-within .fi-ic { color: var(--green); }
    .fi {
        width: 100%; height: 44px; padding: 0 12px 0 40px;
        border-radius: 11px; border: 1.5px solid var(--border);
        background: #F6FAF6;
        font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13.5px; font-weight: 500; color: var(--ink);
        outline: none; transition: border-color .2s, box-shadow .2s, background .2s;
    }
    .fi::placeholder { color: #B2C5BA; font-weight: 400; }
    .fi:hover  { border-color: #A8D0B4; }
    .fi:focus  { border-color: var(--green); background: white; box-shadow: 0 0 0 3px rgba(27,122,62,.1); }
    .fi-tog {
        position: absolute; right:0; top:0; bottom:0; width: 40px;
        display: flex; align-items: center; justify-content: center;
        background: none; border: none; cursor: pointer; color: #AABDB3; font-size: 12px; transition: color .2s;
    }
    .fi-tog:hover { color: var(--green); }

    /* Remember row */
    .rem-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
    .rem-lbl  { display: flex; align-items: center; gap: 7px; cursor: pointer; }
    .rem-chk  { width: 15px; height: 15px; border-radius: 4px; accent-color: var(--green); cursor: pointer; }
    .rem-txt  { font-size: 12px; font-weight: 700; color: var(--muted); }
    .rem-lbl:hover .rem-txt { color: var(--green); }
    .fog-lnk  { font-size: 12px; font-weight: 700; color: var(--green); text-decoration: none; transition: opacity .15s; }
    .fog-lnk:hover { opacity: .72; }

    /* Submit */
    .btn-sub {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; height: 47px; border-radius: 12px;
        background: linear-gradient(135deg, var(--green) 0%, var(--gm) 100%);
        color: white; font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px; font-weight: 800; border: none; cursor: pointer;
        box-shadow: 0 6px 20px rgba(27,122,62,.36); transition: all .2s;
        position: relative; overflow: hidden; letter-spacing: .01em;
    }
    .btn-sub::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(255,255,255,.12),transparent); }
    .btn-sub:hover  { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(27,122,62,.44); }
    .btn-sub:active { transform: scale(.98); }

    /* Divider + quote */
    .dv { height: 1px; margin: 18px 0; background: linear-gradient(90deg,transparent,var(--border),transparent); border: none; }
    .qt { text-align: center; font-family: 'DM Serif Display', serif; font-style: italic; font-size: 11.5px; color: #8AAF96; line-height: 1.65; }

    /* Secure bar */
    .sec-bar { display: flex; align-items: center; justify-content: center; gap: 12px; margin-top: 18px; flex-wrap: wrap; }
    .sec-item { display: flex; align-items: center; gap: 4px; font-size: 9px; font-weight: 700; color: #9BB3A2; text-transform: uppercase; letter-spacing: .09em; }
    .sec-sep  { width: 3px; height: 3px; border-radius: 50%; background: #C0D4C8; }

    /* ════════════════════════════
       MOBILE  ≤ 768px
    ════════════════════════════ */
    @media (max-width: 768px) {
        html, body { height: auto; overflow: auto; }
        .nrm-root  { flex-direction: column; height: auto; min-height: 100vh; overflow: visible; }
        .nrm-left  { display: none; }

        .nrm-right {
            flex: none; height: auto; min-height: 100vh;
            padding: 0; align-items: flex-start; overflow: visible;
        }
        .rp-bg, .rp-arc, .rp-arc-2 { display: none; }
        .rp-inner { max-width: 100%; }

        /* On mobile the rp-inner sits inside .m-card-wrap */
        .rp-eyebrow, .rp-title, .rp-sub { display: none; }
        .nb-bar { display: none; }

        /* Slide-up mobile structure */
        .nrm-right::before { display: none; }
        .m-wrap { display: flex !important; flex-direction: column; width: 100%; }

        /* Top green hero */
        .m-hero {
            background: linear-gradient(150deg, rgba(12, 61, 30, 0.7) 0%, rgba(23, 92, 49, 0.7) 50%, rgba(27, 122, 62, 0.7) 100%), var(--bg-mobile) no-repeat center center;
            background-size: cover;
            padding: 22px 22px 56px; position: relative; overflow: hidden;
        }
        .m-hero::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px;
            background: linear-gradient(90deg, var(--red) 50%, rgba(255,255,255,.8) 50%);
        }
        .m-hero-tex {
            position: absolute; inset: 0;
            background-image: repeating-linear-gradient(
                -55deg, rgba(255,255,255,.02) 0, rgba(255,255,255,.02) 1px, transparent 1px, transparent 40px);
            pointer-events: none;
        }
        .m-hero-blob {
            position: absolute; bottom: -50px; right: -50px;
            width: 180px; height: 180px; border-radius: 50%;
            background: radial-gradient(circle, rgba(45,189,84,.14) 0%, transparent 65%);
            pointer-events: none;
        }

        .m-logo-row { display: flex; align-items: center; gap: 12px; position: relative; z-index:2; margin-bottom: 22px; }
        .m-logo-box {
            width: auto; height: auto; background: none; border: none;
            display: flex; align-items: center; justify-content: center; flex-shrink:0;
        }
        .m-logo-box img { width: 64px; height: 64px; object-fit: contain; }
        .m-app-name { font-size: 14px; font-weight: 800; color: white; line-height: 1.25; }
        .m-app-sub  { font-size: 9px; font-weight: 600; color: rgba(255,255,255,.42); letter-spacing: .12em; text-transform: uppercase; margin-top: 1px; }

        .m-hero-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }
        .m-hero-logo {
             flex-shrink: 0;
             width: 100px;
             height: 100px;
         }
         .m-hero-logo img {
             width: 100%;
             height: 100%;
             object-fit: contain;
             filter: drop-shadow(0 0 12px rgba(255, 255, 255, 0.7));
         }
        .m-hero-text-wrap {
            flex: 1;
        }
        .m-pill {
            display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 100px;
            background: rgba(232,170,42,.15); border: 1px solid rgba(232,170,42,.28);
            font-size: 9px; font-weight: 800; color: var(--gold); letter-spacing: .12em; text-transform: uppercase; margin-bottom: 9px;
        }
        .m-pill::before { content: '◆'; font-size: 5px; opacity: .75; }
        .m-title {
            font-family: 'DM Serif Display', serif; font-size: 26px; color: white; line-height: 1.15; margin-bottom: 6px;
        }
        .m-title .hl { color: var(--gold); font-style: italic; }
        .m-desc { font-size: 12px; color: rgba(255,255,255,.55); line-height: 1.7; }

        /* White card slides up over hero */
        .m-card-area {
            background: var(--cream); border-radius: 22px 22px 0 0;
            margin-top: -22px; padding: 26px 20px 40px; position: relative; z-index: 2;
        }
        /* Research badge in mobile */
        .m-badge {
            display: flex !important; align-items: center; gap: 8px; padding: 8px 12px;
            background: linear-gradient(135deg,rgba(27,122,62,.07),rgba(27,122,62,.03));
            border: 1px solid rgba(27,122,62,.12); border-radius: 10px; margin-bottom: 18px;
        }
        .m-badge-ico {
            width: 26px; height: 26px; background: linear-gradient(135deg,var(--green),var(--gm));
            border-radius: 7px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .m-badge-t { font-size: 10px; font-weight: 700; color: var(--green); line-height: 1.3; }
        .m-badge-s { font-size: 8.5px; font-weight: 500; color: var(--muted); margin-top: 1px; }

        .login-card { border-radius: 14px; padding: 20px 18px 16px; box-shadow: 0 4px 18px rgba(27,122,62,.1), 0 0 0 1px rgba(27,122,62,.07); }
        .sec-bar { margin-top: 16px; }
    }

    /* Hide mobile wrapper on desktop */
    .m-wrap { display: none; }
</style>

<div class="nrm-root" style="--bg-desktop: url('{{ route('brand.bg-desktop') }}'); --bg-mobile: url('{{ route('brand.bg-mobile') }}');">

    {{-- LEFT PANEL (desktop only) --}}
    <div class="nrm-left">
        <div class="lp-flag"></div>
        <div class="lp-tex"></div>
        <div class="lp-ring"></div>
        <div class="lp-ring-2"></div>

        <div class="lp-mid">
            <div class="lp-mid-flex">
                <div class="lp-mid-content">
                    <div class="lp-pill">Halo, Sahabat Gizi!</div>
                    <h2 class="lp-heading">
                        Pantau Gizi Jadi<br>Lebih
                        <span class="hl">Mudah & Seru</span>
                    </h2>
                    <p class="lp-desc">
                        Tempat asik buat kamu belajar gizi, cek kesehatan harian, dan ikut berkontribusi dalam riset kesehatan bareng kakak-kakak Poltekkes Kemenkes.
                    </p>
                </div>
                <div class="lp-mid-logo">
                    <img src="{{ route('brand.logo') }}" alt="Logo">
                </div>
            </div>
            <div class="lp-feats">
                <div class="lp-feat">
                    <div class="lp-feat-icon">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <span class="lp-feat-text"><strong>Cek Gizi</strong> kamu secara rutin & otomatis</span>
                </div>
                <div class="lp-feat">
                    <div class="lp-feat-icon">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    </div>
                    <span class="lp-feat-text"><strong>Tips Sehat</strong> yang asik & gampang ditiru</span>
                </div>
                <div class="lp-feat">
                    <div class="lp-feat-icon">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    </div>
                    <span class="lp-feat-text"><strong>Bantu Riset</strong> bareng kakak Poltekkes NTB</span>
                </div>
            </div>
        </div>

        <div class="lp-bottom">
            <div class="lp-card">
                <div class="lp-card-head">
                    <div class="lp-card-icon">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#E8AA2A" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </div>
                    <span class="lp-card-label">Program Sehat Sekolah</span>
                </div>
                <p class="lp-card-desc">Program keren kolaborasi Poltekkes Kemenkes untuk dukung pola hidup sehat kamu di sekolah.</p>
                <div class="lp-card-tags">
                    <span class="lp-tag">
                        <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        Poltekkes Kemenkes
                    </span>
                    <span class="lp-tag">
                        <svg width="8" height="8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                        Standar SNI
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="nrm-right">
        <div class="rp-bg"></div>
        <div class="rp-arc"></div>
        <div class="rp-arc-2"></div>

        {{-- MOBILE LAYOUT --}}
        <div class="m-wrap" style="width:100%;">
            <div class="m-hero">
                <div class="m-hero-tex"></div>
                <div class="m-hero-blob"></div>
                <div class="m-hero-content">
                    <div class="m-hero-text-wrap">
                        <div class="m-pill">Halo, Sahabat Gizi!</div>
                        <h1 class="m-title">Pantau Gizi Jadi<br>Lebih <span class="hl">Mudah & Seru</span></h1>
                        <p class="m-desc">Tempat asik buat kamu belajar gizi & cek kesehatan harian bareng kakak Poltekkes NTB.</p>
                    </div>
                    <div class="m-hero-logo">
                        <img src="{{ route('brand.logo') }}" alt="Logo">
                    </div>
                </div>
            </div>

            <div class="m-card-area">
                <div class="m-badge">
                    <div class="m-badge-ico">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                    </div>
                    <div>
                        <div class="m-badge-t">Poltekkes Kemenkes · Research Portal</div>
                        <div class="m-badge-s">Akses data riset & materi edukasi terakreditasi</div>
                    </div>
                </div>

                {{-- Shared form (mobile) --}}
                @include('auth.partials._login_card')
            </div>
        </div>

        {{-- DESKTOP LAYOUT --}}
        <div class="rp-inner">
            <div class="nb-bar">
                <div class="nb-ico">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                </div>
                <div>
                    <div class="nb-t">Poltekkes Kemenkes · Research Portal</div>
                    <div class="nb-s">Akses data riset & materi edukasi terakreditasi</div>
                </div>
            </div>

            <div class="rp-eyebrow"><span class="rp-dot"></span><span>Portal Gizi Sekolah</span></div>
            <h1 class="rp-title">Halo, Selamat <span class="hl">Datang!</span></h1>
            <p class="rp-sub">Yuk, masuk ke akun kamu buat cek info gizi dan kesehatan terbaru hari ini.</p>

            @include('auth.partials._login_card')

            <div class="sec-bar">
                <span class="sec-item"><i class="fas fa-shield-alt"></i>&nbsp;Koneksi Aman</span>
                <span class="sec-sep"></span>
                <span class="sec-item"><i class="fas fa-lock"></i>&nbsp;Data Terenkripsi</span>
                <span class="sec-sep"></span>
                <span class="sec-item"><i class="fas fa-certificate"></i>&nbsp;SNI 2026</span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle NISN visibility using classes to support multiple layouts (mobile/desktop)
    const toggles = document.querySelectorAll('.nisn-toggle');
    toggles.forEach(btn => {
        btn.addEventListener('click', function () {
            const wrap = this.closest('.fw');
            const input = wrap.querySelector('.nisn-field');
            const icon = this.querySelector('.eye-icon');
            
            const isPass = input.type === 'password';
            input.type = isPass ? 'text' : 'password';
            icon.classList.toggle('fa-eye-slash', !isPass);
            icon.classList.toggle('fa-eye', isPass);
        });
    });

    // Show correct layout based on viewport
    function applyLayout() {
        const mobile  = window.innerWidth <= 768;
        const mWrap   = document.querySelector('.m-wrap');
        const rpInner = document.querySelector('.rp-inner');
        if (mWrap)   mWrap.style.display   = mobile ? 'flex'  : 'none';
        if (rpInner) rpInner.style.display  = mobile ? 'none'  : '';
    }

    applyLayout();
    window.addEventListener('resize', applyLayout);
});
</script>
@endsection