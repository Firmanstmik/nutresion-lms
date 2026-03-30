<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Nutrition Rescue Mission - LMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=JetBrains+Mono:wght@500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        /* ── Root tokens ─────────────────────────────── */
        :root {
            --nav-navy:      #0B1E3F;
            --nav-navy-md:   #122247;
            --nav-red:       #C0111E;
            --nav-gold:      #C9A84C;
            --nav-gold-lt:   #E2C471;
            --nav-teal:      #0F7E6E;
            --nav-teal-lt:   #14A88F;
            --nav-border:    rgba(11,30,63,0.08);
            --nav-surface:   #FFFFFF;
            --nav-muted:     #6B7280;
            --nav-ink:       #111827;
            --font-body:     'DM Sans', sans-serif;
            --font-display:  'Playfair Display', Georgia, serif;
            --font-mono:     'JetBrains Mono', monospace;
        }

        /* ── Global body font override ───────────────── */
        body { font-family: var(--font-body); }

        /* ── Mobile student padding ──────────────────── */
        @media (max-width: 639px) {
            .nr-student main.nr-main {
                padding-bottom: calc(11rem + env(safe-area-inset-bottom));
            }
        }

        /* ══════════════════════════════════════════════
           MAIN NAVBAR
        ══════════════════════════════════════════════ */
        .nrn-bar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255,255,255,0.96);
            backdrop-filter: blur(16px) saturate(180%);
            -webkit-backdrop-filter: blur(16px) saturate(180%);
            border-bottom: 1px solid var(--nav-border);
            box-shadow: 0 1px 0 rgba(11,30,63,0.05), 0 4px 20px rgba(11,30,63,0.04);
        }
        /* Thin gold accent under logo area */
        .nrn-bar::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background: linear-gradient(to bottom, var(--nav-gold), transparent);
            opacity: 0.6;
        }
        .nrn-bar-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            gap: 1rem;
        }

        /* ── Logo cluster ───────────────────────────── */
        .nrn-logo-link {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            text-decoration: none;
            flex-shrink: 0;
        }
        .nrn-logo-img {
            height: 36px;
            width: 36px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        .nrn-logo-link:hover .nrn-logo-img { transform: scale(1.05); }
        .nrn-logo-wordmark {
            display: flex;
            flex-direction: column;
            gap: 0;
        }
        .nrn-logo-word1 {
            font-family: var(--font-display);
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--nav-navy);
            line-height: 1.1;
            letter-spacing: 0.01em;
        }
        .nrn-logo-word2 {
            font-family: var(--font-body);
            font-size: 0.48rem;
            font-weight: 700;
            letter-spacing: 0.2em;
            color: var(--nav-red);
            text-transform: uppercase;
            line-height: 1.3;
        }
        @media (max-width: 480px) {
            .nrn-logo-wordmark { display: none; }
        }

        /* Vertical rule between logo and nav links */
        .nrn-bar-rule {
            width: 1px;
            height: 24px;
            background: var(--nav-border);
            flex-shrink: 0;
        }

        /* ── Nav links (desktop) ────────────────────── */
        .nrn-links {
            display: none;
            align-items: center;
            gap: 0.25rem;
            flex: 1;
        }
        @media (min-width: 768px) { .nrn-links { display: flex; } }

        .nrn-link {
            position: relative;
            padding: 0.45rem 0.9rem;
            border-radius: 2px;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            text-decoration: none;
            color: var(--nav-muted);
            transition: color 0.2s ease, background 0.2s ease;
            white-space: nowrap;
        }
        .nrn-link::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 50%;
            right: 50%;
            height: 2px;
            background: var(--nav-navy);
            transition: left 0.25s ease, right 0.25s ease;
        }
        .nrn-link:hover { color: var(--nav-navy); background: rgba(11,30,63,0.04); }
        .nrn-link:hover::after { left: 0.9rem; right: 0.9rem; }

        /* Active state */
        .nrn-link.nrn-active {
            color: var(--nav-navy);
            background: rgba(11,30,63,0.06);
            font-weight: 700;
        }
        .nrn-link.nrn-active::after { left: 0.9rem; right: 0.9rem; }

        /* Student active uses teal */
        .nrn-link.nrn-active-student {
            color: var(--nav-teal);
            background: rgba(15,126,110,0.07);
        }
        .nrn-link.nrn-active-student::after { background: var(--nav-teal); left: 0.9rem; right: 0.9rem; }

        /* ── Right cluster (actions) ────────────────── */
        .nrn-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        /* ── Icon button (notif, etc) ───────────────── */
        .nrn-icon-btn {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            background: transparent;
            border: 1px solid var(--nav-border);
            border-radius: 2px;
            color: var(--nav-muted);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .nrn-icon-btn:hover {
            background: rgba(11,30,63,0.04);
            border-color: rgba(11,30,63,0.15);
            color: var(--nav-navy);
        }
        .nrn-icon-btn svg { width: 16px; height: 16px; }

        /* Notification badge */
        .nrn-badge-dot {
            position: absolute;
            top: -3px;
            right: -3px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            border: 2px solid white;
        }
        .nrn-badge-dot-orange { background: #F97316; }
        .nrn-badge-dot-green  { background: #10B981; }

        /* Numeric notification badge */
        .nrn-badge-num {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #EF4444; /* red-500 */
            color: white;
            font-size: 0.6rem;
            font-weight: 800;
            min-width: 16px;
            height: 16px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 4px;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* ── Dropdown panel ─────────────────────────── */
        .nrn-dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 320px;
            max-width: 90vw;
            background: white;
            border: 1px solid rgba(11,30,63,0.1);
            border-radius: 2px;
            box-shadow: 0 16px 48px rgba(11,30,63,0.12), 0 4px 16px rgba(11,30,63,0.06);
            overflow: hidden;
            animation: nrn-dropdown-in 0.2s ease both;
            z-index: 100;
        }
        @keyframes nrn-dropdown-in {
            from { opacity: 0; transform: translateY(-6px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .nrn-dropdown.hidden { display: none !important; }

        .nrn-dd-head {
            padding: 0.85rem 1.1rem;
            border-bottom: 1px solid rgba(11,30,63,0.07);
            background: var(--nav-navy);
        }
        .nrn-dd-head-label {
            font-size: 0.5rem;
            font-weight: 700;
            letter-spacing: 0.22em;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            margin-bottom: 0.2rem;
        }
        .nrn-dd-head-title {
            font-family: var(--font-display);
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--nav-gold);
        }

        /* ── Student Specific Dropdown ───────────────── */
        #nrNotifMenu .nrn-lesson-card {
            display: flex;
            gap: 1rem;
            padding: 1rem;
            border: 1px solid #F1F5F9;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 0.5rem;
            transition: all 0.2s;
            position: relative;
            background: white;
        }
        #nrNotifMenu .nrn-lesson-card:hover {
            background: #F8FAFC;
            border-color: #E2E8F0;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .nrn-notif-icon-box {
            width: 42px;
            height: 42px;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--nav-teal);
            flex-shrink: 0;
        }
        .nrn-notif-icon-box-recommend { background: #ECFDF5; }
        .nrn-notif-icon-box-unread    { background: #F0FDF4; }
        .nrn-notif-icon-box-read      { background: #F8FAFC; }

        .nrn-notif-content-wrap { flex: 1; min-width: 0; }
        .nrn-notif-eyebrow      { font-size: 0.55rem; font-weight: 800; color: #94A3B8; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.15rem; }
        .nrn-notif-main-title   { font-size: 0.85rem; font-weight: 800; color: var(--nav-navy); line-height: 1.3; }
        .nrn-notif-main-title-sm { font-size: 0.82rem; font-weight: 700; color: var(--nav-navy); line-height: 1.3; }
        .nrn-notif-desc-text    { font-size: 0.7rem; font-weight: 600; color: #64748B; margin-top: 0.25rem; }
        .nrn-notif-desc-text-sm { font-size: 0.7rem; font-weight: 500; color: #64748B; margin-top: 0.15rem; }
        
        .nrn-notif-unread-indicator {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 6px;
            height: 6px;
            background: var(--nav-teal);
            border-radius: 50%;
        }

        .nrn-dd-body {
            padding: 0.6rem;
            max-height: 380px;
            overflow-y: auto;
        }
        .nrn-dd-body::-webkit-scrollbar { width: 4px; }
        .nrn-dd-body::-webkit-scrollbar-track { background: transparent; }
        .nrn-dd-body::-webkit-scrollbar-thumb { background: rgba(11,30,63,0.1); border-radius: 2px; }

        /* Notification item */
        .nrn-notif-item {
            display: block;
            padding: 0.75rem 0.85rem;
            margin-bottom: 0.35rem;
            border: 1px solid rgba(11,30,63,0.06);
            border-radius: 2px;
            background: #FAFAFA;
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: default;
        }
        .nrn-notif-item:last-child { margin-bottom: 0; }
        .nrn-notif-item:hover { background: white; border-color: rgba(11,30,63,0.12); box-shadow: 0 2px 8px rgba(11,30,63,0.06); }
        a.nrn-notif-item { cursor: pointer; }

        .nrn-notif-inner { display: flex; align-items: flex-start; gap: 0.65rem; }

        .nrn-notif-icon {
            width: 36px;
            height: 36px;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 0.8rem;
        }
        .nrn-notif-icon-orange { background: rgba(249,115,22,0.08); color: #EA580C; border: 1px solid rgba(249,115,22,0.15); }
        .nrn-notif-icon-teal   { background: rgba(15,126,110,0.08); color: var(--nav-teal); border: 1px solid rgba(15,126,110,0.15); }

        .nrn-notif-body { min-width: 0; flex: 1; }
        .nrn-notif-time {
            font-size: 0.5rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: rgba(107,114,128,0.7);
            text-transform: uppercase;
            margin-bottom: 0.2rem;
        }
        .nrn-notif-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--nav-ink);
            line-height: 1.4;
            margin-bottom: 0.2rem;
        }
        .nrn-notif-title strong { color: var(--nav-teal); font-weight: 700; }
        .nrn-notif-sub {
            font-size: 0.65rem;
            color: var(--nav-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0.35rem;
        }
        .nrn-score-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.15rem 0.5rem;
            background: rgba(11,30,63,0.05);
            border: 1px solid rgba(11,30,63,0.08);
            border-radius: 2px;
            font-family: var(--font-mono);
            font-size: 0.58rem;
            font-weight: 600;
            color: var(--nav-muted);
            letter-spacing: 0.05em;
        }
        .nrn-score-pass { color: var(--nav-teal); }
        .nrn-score-fail { color: var(--nav-red); }

        .nrn-dd-empty {
            padding: 1.5rem 1rem;
            text-align: center;
        }
        .nrn-dd-empty-icon {
            width: 40px; height: 40px;
            background: rgba(11,30,63,0.03);
            border: 1px solid rgba(11,30,63,0.07);
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            color: #D1D5DB;
            margin: 0 auto 0.6rem;
        }
        .nrn-dd-empty-text {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--nav-ink);
            margin-bottom: 0.25rem;
        }
        .nrn-dd-empty-sub {
            font-size: 0.62rem;
            color: var(--nav-muted);
            line-height: 1.5;
        }

        .nrn-dd-footer {
            display: block;
            padding: 0.85rem;
            text-align: center;
            background: #F8FAFC;
            border-top: 1px solid #F1F5F9;
            font-size: 0.7rem;
            font-weight: 800;
            color: var(--nav-teal);
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: background 0.2s ease;
        }
        .nrn-dd-footer:hover { background: #F1F5F9; }
        .nrn-dd-footer .fas { margin-left: 0.4rem; font-size: 0.5rem; }

        /* Lesson notif card (student) */
        .nrn-lesson-card {
            display: flex;
            align-items: flex-start;
            gap: 0.65rem;
            padding: 0.75rem 0.85rem;
            border: 1px solid rgba(15,126,110,0.12);
            border-radius: 2px;
            background: rgba(15,126,110,0.03);
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .nrn-lesson-card:hover {
            background: rgba(15,126,110,0.06);
            border-color: rgba(15,126,110,0.22);
            box-shadow: 0 2px 8px rgba(15,126,110,0.08);
        }

        /* ── User menu button ───────────────────────── */
        .nrn-user-btn {
            display: none;
            align-items: center;
            gap: 0.6rem;
            padding: 0.4rem 0.75rem 0.4rem 0.5rem;
            background: transparent;
            border: 1px solid var(--nav-border);
            border-radius: 2px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        @media (min-width: 640px) { .nrn-user-btn { display: flex; } }
        .nrn-user-btn:hover {
            background: rgba(11,30,63,0.03);
            border-color: rgba(11,30,63,0.15);
        }
        .nrn-user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 2px;
            background: var(--nav-navy);
            color: var(--nav-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            flex-shrink: 0;
        }
        /* Student avatar uses teal */
        .nrn-user-avatar-student {
            background: rgba(15,126,110,0.1);
            color: var(--nav-teal);
            border: 1px solid rgba(15,126,110,0.2);
        }
        .nrn-user-name {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--nav-ink);
            max-width: 160px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .nrn-user-chevron {
            width: 12px;
            height: 12px;
            color: #9CA3AF;
            flex-shrink: 0;
            transition: transform 0.2s ease;
        }
        .nrn-user-btn[aria-expanded="true"] .nrn-user-chevron { transform: rotate(180deg); }

        /* User dropdown */
        .nrn-user-dd {
            width: 220px;
        }
        .nrn-user-dd-head {
            padding: 0.85rem 1.1rem;
            border-bottom: 1px solid rgba(11,30,63,0.07);
            background: var(--nav-navy);
        }
        .nrn-user-dd-label {
            font-size: 0.5rem;
            font-weight: 700;
            letter-spacing: 0.22em;
            color: rgba(255,255,255,0.35);
            text-transform: uppercase;
            margin-bottom: 0.15rem;
        }
        .nrn-user-dd-name {
            font-family: var(--font-display);
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--nav-gold);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .nrn-user-dd-links { padding: 0.4rem 0; }
        .nrn-user-dd-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.55rem 1.1rem;
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--nav-ink);
            text-decoration: none;
            transition: background 0.15s ease;
        }
        .nrn-user-dd-link:hover { background: rgba(11,30,63,0.04); }
        .nrn-user-dd-link span { color: #D1D5DB; font-size: 0.8rem; }
        .nrn-user-dd-sep { height: 1px; background: rgba(11,30,63,0.07); margin: 0.25rem 0; }
        .nrn-user-dd-logout-wrap { padding: 0.4rem 0.5rem; }
        .nrn-user-dd-logout {
            width: 100%;
            display: block;
            padding: 0.5rem 0.75rem;
            border-radius: 2px;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--nav-red);
            background: transparent;
            border: none;
            cursor: pointer;
            text-align: left;
            transition: background 0.15s ease;
            letter-spacing: 0.03em;
        }
        .nrn-user-dd-logout:hover { background: rgba(192,17,30,0.05); }

        /* ══════════════════════════════════════════════
           BOTTOM MOBILE NAV — Admin (Original Style)
        ══════════════════════════════════════════════ */
        .nrn-bottom-admin { display: none; }
        @media (max-width: 639px) { .nrn-bottom-admin { display: block; } }

        .nrn-bottom-wrap-admin {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 50;
            padding-bottom: env(safe-area-inset-bottom);
        }
        .nrn-bottom-inner {
            background: rgba(255,255,255,0.97);
            backdrop-filter: blur(16px);
            border-top: 2px solid var(--nav-red);
            display: flex; align-items: center; justify-content: space-around;
            padding: 0.5rem 0.25rem;
            box-shadow: 0 -4px 24px rgba(11,30,63,0.08);
        }
        .nrn-bottom-link {
            display: flex; flex-direction: column; align-items: center; gap: 0.2rem;
            padding: 0.4rem 0.75rem; color: #9CA3AF; text-decoration: none; transition: all 0.2s;
        }
        .nrn-bottom-link.nrn-btm-active { color: var(--nav-navy); background: rgba(11,30,63,0.07); }
        .nrn-bottom-icon { font-size: 1rem; }
        .nrn-bottom-label { font-size: 0.48rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.12em; }

        /* ══════════════════════════════════════════════
           BOTTOM MOBILE NAV — Student Redesign (App-Style)
        ══════════════════════════════════════════════ */
        .nrn-bottom-student { display: none; }
        @media (max-width: 639px) { .nrn-bottom-student { display: block; } }

        .nrn-bottom-wrap-student {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 50;
            padding-bottom: env(safe-area-inset-bottom);
            background: white;
            box-shadow: 0 -10px 25px rgba(0,0,0,0.05);
            height: 70px;
        }
        .nrn-bottom-inner-student {
            position: relative;
            display: flex; align-items: center; justify-content: space-between;
            height: 100%; padding: 0 10px;
        }

        .nrn-bottom-link-student {
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            text-decoration: none; color: #94A3B8; transition: all 0.3s;
            flex: 1; height: 100%;
        }
        .nrn-bottom-link-student.nrn-btm-active { color: var(--nav-teal); }

        .nrn-bottom-icon-student { margin-bottom: 4px; transition: transform 0.3s; }
        .nrn-bottom-link-student.nrn-btm-active .nrn-bottom-icon-student { transform: scale(1.1); }

        .nrn-bottom-label-student {
            font-size: 0.65rem; font-weight: 700; transition: all 0.3s;
        }

        /* Center Action Button (Belajar) */
        .nrn-center-wrap {
            position: absolute; left: 50%; top: -30px; transform: translateX(-50%);
            z-index: 60;
        }
        .nrn-center-btn {
            width: 64px; height: 64px;
            background: linear-gradient(135deg, var(--nav-teal), #14A88F);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 10px 20px rgba(15, 126, 110, 0.3), inset 0 0 0 4px rgba(255,255,255,0.1);
            color: white; border: 5px solid white;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .nrn-center-btn:active { transform: scale(0.9); }
        .nrn-center-label {
            position: absolute; bottom: -22px; left: 50%; transform: translateX(-50%);
            font-size: 0.65rem; font-weight: 800; color: var(--nav-teal);
            text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap;
        }

        /* Spacing for center button */
        .nrn-spacer { flex: 0.8; }

        /* ══════════════════════════════════════════════
           Relative wrapper for dropdowns
        ══════════════════════════════════════════════ */
        .nrn-dropdown-wrap { position: relative; }

        /* ══════════════════════════════════════════════
           FLASH MESSAGES
        ══════════════════════════════════════════════ */
        .nrn-flash {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1.25rem;
            border-left: 3px solid;
            border-radius: 0 2px 2px 0;
            font-size: 0.8rem;
            font-weight: 500;
        }
        .nrn-flash-success { background: #F0FDF4; border-color: #16A34A; color: #15803D; }
        .nrn-flash-error   { background: #FEF2F2; border-color: var(--nav-red); color: #B91C1C; }

        /* ── Modern Background & Container ──────────── */
        body {
            background-color: #f8fafc;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .bg-fixed-overlay {
            position: fixed;
            inset: 0;
            background: 
                linear-gradient(135deg, rgba(240, 253, 244, 0.70) 0%, rgba(248, 250, 252, 0.70) 100%),
                var(--bg-desktop) no-repeat center center;
            background-size: cover;
            background-attachment: fixed;
            z-index: -10;
            pointer-events: none;
        }

        .main-container {
            padding: 24px 0;
            position: relative;
            z-index: 1;
        }

        /* Upgrade Card Premium - Subtle/Seamless */
        .card, .nrn-card {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 20px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.02) !important;
            border: 1px solid rgba(255,255,255,0.3) !important;
            transition: all 0.3s ease !important;
        }

        .card:hover, .nrn-card:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.6);
            box-shadow: 0 10px 30px rgba(0,0,0,0.04) !important;
        }

        /* Optimasi Mobile */
        @media (max-width: 768px) {
            .bg-fixed-overlay {
                background: 
                    linear-gradient(135deg, rgba(240, 253, 244, 0.90) 0%, rgba(248, 250, 252, 0.90) 100%),
                    var(--bg-mobile) no-repeat center center;
                background-size: cover;
            }

            .main-container {
                padding: 16px 0;
            }

            .card, .nrn-card {
                background: rgba(255, 255, 255, 0.6);
                backdrop-filter: blur(4px);
                -webkit-backdrop-filter: blur(4px);
            }
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-text-main antialiased {{ Auth::check() && Auth::user()->role !== 'admin' ? 'nr-student' : '' }} @yield('body-class')"
        style="font-family: var(--font-body); --bg-image: url('{{ route('brand.bg-lms') }}'); --bg-desktop: url('{{ route('brand.bg-desktop') }}'); --bg-mobile: url('{{ route('brand.bg-mobile') }}');">

<div class="bg-fixed-overlay"></div>

{{-- ════════════════════════════════════════════════════
     PAGE LOADER
════════════════════════════════════════════════════ --}}
<div id="nrLoader" class="fixed inset-0 bg-white flex items-center justify-center z-[9999] opacity-100 transition-opacity duration-500" style="display:none">
    <div class="flex flex-col items-center gap-4">
        <img src="{{ route('brand.logo') }}" alt="Nutrition Rescue Mission" class="w-24 h-24 sm:w-28 sm:h-28 object-contain">
        <div style="font-family:var(--font-body);font-size:0.6rem;font-weight:700;letter-spacing:0.22em;color:var(--nav-navy);text-transform:uppercase">NUTRITION RESCUE MISSION</div>
        <div class="w-8 h-8 border-2 border-gray-200 rounded-none" style="border-top-color:var(--nav-red);animation:spin 0.8s linear infinite"></div>
    </div>
</div>
<style>@keyframes spin { to { transform: rotate(360deg); } }</style>
<script>
    try {
        if (!sessionStorage.getItem('nrmlms_loaded')) {
            const loader = document.getElementById('nrLoader');
            if (loader) loader.style.display = 'flex';
        }
    } catch (e) {}
</script>

@auth
@php
    $nextLesson = null;
    $nextCourse = null;
    $studentNotifications = collect();
    $adminNotifications = collect();

    if (Auth::check()) {
        if (Auth::user()->role === 'student') {
            $user_id = Auth::id();

            // Proactive Check: Create "Post Test" notification if lessons completed but post-test not taken
            $allCourses = \App\Models\Course::with('lessons')->get();
            foreach ($allCourses as $c) {
                $totalL = $c->lessons->count();
                if ($totalL > 0) {
                    $doneL = \App\Models\UserProgress::where('user_id', $user_id)
                        ->whereIn('lesson_id', $c->lessons->pluck('id'))
                        ->where('is_completed', true)
                        ->count();
                    
                    $testDone = \App\Models\Result::where('user_id', $user_id)
                        ->where('course_id', $c->id)
                        ->first();

                    if ($doneL === $totalL && !$testDone) {
                        $targetUrl = route('tests.index', $c->id);
                        $existsNotif = \App\Models\Notification::where('user_id', $user_id)
                            ->where('action_url', $targetUrl)
                            ->exists();

                        if (!$existsNotif) {
                            \App\Models\Notification::create([
                                'user_id' => $user_id,
                                'title' => "Materi Tuntas: " . $c->title,
                                'message' => "Selamat! Kamu telah menyelesaikan semua materi di " . $c->title . ". Ayo ambil Post Test sekarang untuk mendapatkan nilai!",
                                'type' => 'result',
                                'action_url' => $targetUrl,
                                'is_read' => false,
                            ]);
                        }
                    } elseif ($testDone) {
                        // Also proactively check if "Result" notification exists
                        $resultUrl = route('results.show', $testDone->id);
                        $existsResultNotif = \App\Models\Notification::where('user_id', $user_id)
                            ->where('action_url', $resultUrl)
                            ->exists();
                        
                        if (!$existsResultNotif) {
                            \App\Models\Notification::create([
                                'user_id' => $user_id,
                                'title' => "Post Test Selesai: " . $c->title,
                                'message' => "Selamat! Kamu telah menyelesaikan Post Test untuk " . $c->title . " dengan nilai " . $testDone->score . ". Klik di sini untuk melihat detail hasil belajarmu.",
                                'type' => 'result',
                                'action_url' => $resultUrl,
                                'is_read' => false,
                            ]);
                        }
                    }
                }
            }

            // Fetch real notifications after proactive creation
             $studentNotifications = \App\Models\Notification::where('user_id', $user_id)
                 ->latest()
                 ->take(5)
                 ->get();
             
             $unreadCount = \App\Models\Notification::where('user_id', $user_id)
                 ->where('is_read', false)
                 ->count();

            // Learning recommendation logic
            $latestProgress = \App\Models\UserProgress::where('user_id', Auth::id())
                ->where('is_completed', true)
                ->with('lesson.course.lessons')
                ->latest('updated_at')
                ->first();

            if ($latestProgress && $latestProgress->lesson && $latestProgress->lesson->course) {
                $nextCourse = $latestProgress->lesson->course;
                $courseLessonIds = $nextCourse->lessons->pluck('id');
                $completedLessonIds = \App\Models\UserProgress::where('user_id', Auth::id())
                    ->where('is_completed', true)
                    ->whereIn('lesson_id', $courseLessonIds)
                    ->pluck('lesson_id')
                    ->all();

                $currentOrder = (int) $latestProgress->lesson->order_number;
                $nextLesson = $nextCourse->lessons->first(function ($lesson) use ($completedLessonIds, $currentOrder) {
                    return (int) $lesson->order_number > $currentOrder && !in_array($lesson->id, $completedLessonIds, true);
                });

                if (!$nextLesson) {
                    $nextLesson = $nextCourse->lessons->first(function ($lesson) use ($completedLessonIds) {
                        return !in_array($lesson->id, $completedLessonIds, true);
                    });
                }
            }
        } elseif (Auth::user()->role === 'admin') {
            $adminNotifications = \App\Models\Result::with(['user', 'course'])
                ->latest()
                ->take(5)
                ->get();
            
            // For admin, let's say "unread" means notifications from today
            $unreadCount = \App\Models\Result::whereDate('created_at', \Carbon\Carbon::today())->count();
        }
    }
@endphp

{{-- ════════════════════════════════════════════════════
     MAIN NAVBAR
════════════════════════════════════════════════════ --}}
<nav class="nrn-bar">
    <div class="nrn-bar-inner">

        {{-- Logo --}}
        <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}" class="nrn-logo-link">
            <img src="{{ route('brand.logo') }}" alt="Nutrition Rescue Mission" class="nrn-logo-img">
            <div class="nrn-logo-wordmark">
                <span class="nrn-logo-word1">Nutrition Rescue</span>
                <span class="nrn-logo-word2">Portal Nasional</span>
            </div>
        </a>

        <div class="nrn-bar-rule hidden md:block"></div>

        {{-- Desktop nav links --}}
        <div class="nrn-links">
            @if(Auth::user()->role !== 'admin')
                <a href="{{ route('dashboard') }}"
                   class="nrn-link {{ request()->routeIs('dashboard') ? 'nrn-active-student' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('courses.index') }}"
                   class="nrn-link {{ request()->routeIs('courses.*') ? 'nrn-active-student' : '' }}">
                    Pembelajaran
                </a>
                <a href="{{ route('results.index') }}"
                   class="nrn-link {{ request()->routeIs('results.*') ? 'nrn-active-student' : '' }}">
                    Nilai
                </a>
            @else
                <a href="{{ route('admin.dashboard') }}"
                   class="nrn-link {{ request()->routeIs('admin.dashboard') ? 'nrn-active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.schools.index') }}"
                   class="nrn-link {{ request()->routeIs('admin.schools.*') ? 'nrn-active' : '' }}">
                    Sekolah
                </a>
                <a href="{{ route('admin.students.index') }}"
                   class="nrn-link {{ request()->routeIs('admin.students.*') ? 'nrn-active' : '' }}">
                    Siswa
                </a>
                <a href="{{ route('admin.courses.index') }}"
                   class="nrn-link {{ request()->routeIs('admin.courses.*') ? 'nrn-active' : '' }}">
                    Kursus
                </a>
                <a href="{{ route('admin.results.index') }}"
                   class="nrn-link {{ request()->routeIs('admin.results.*') ? 'nrn-active' : '' }}">
                    Nilai
                </a>
            @endif
        </div>

        {{-- Right actions --}}
        <div class="nrn-actions">

            {{-- ADMIN notification bell --}}
            @if(Auth::user()->role === 'admin')
            <div class="nrn-dropdown-wrap">
                <button id="nrAdminNotifBtn" type="button"
                        class="nrn-icon-btn"
                        aria-expanded="false"
                        aria-controls="nrAdminNotifMenu"
                        aria-label="Notifikasi Admin">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 7h18s-3 0-3-7"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="nrn-badge-num">{{ $unreadCount }}</span>
                    @endif
                </button>

                <div id="nrAdminNotifMenu" class="nrn-dropdown hidden">
                    <div class="nrn-dd-head">
                        <div class="nrn-dd-head-label">Notifikasi Admin</div>
                        <div class="nrn-dd-head-title">Aktivitas Siswa</div>
                    </div>
                    <div class="nrn-dd-body">
                        @forelse($adminNotifications as $notif)
                        <div class="nrn-notif-item">
                            <div class="nrn-notif-inner">
                                <div class="nrn-notif-icon nrn-notif-icon-orange">
                                    <i class="fas fa-user-check"></i>
                                </div>
                                <div class="nrn-notif-body">
                                    <div class="nrn-notif-time">{{ $notif->created_at->diffForHumans() }}</div>
                                    <div class="nrn-notif-title">
                                        <strong>{{ $notif->user->name }}</strong> menyelesaikan post-test
                                    </div>
                                    <div class="nrn-notif-sub">{{ $notif->course->title }}</div>
                                    <span class="nrn-score-chip">
                                        SKOR: <span class="{{ $notif->score >= 70 ? 'nrn-score-pass' : 'nrn-score-fail' }}">{{ $notif->score }}</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="nrn-dd-empty">
                            <div class="nrn-dd-empty-icon"><i class="fas fa-bell-slash"></i></div>
                            <div class="nrn-dd-empty-text">Belum ada aktivitas.</div>
                            <div class="nrn-dd-empty-sub">Notifikasi muncul saat siswa menyelesaikan test.</div>
                        </div>
                        @endforelse
                    </div>
                    <a href="{{ route('admin.results.index') }}" class="nrn-dd-footer">
                        Lihat Semua Hasil <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            @endif

            {{-- STUDENT notification bell --}}
            @if(Auth::user()->role !== 'admin')
            <div class="nrn-dropdown-wrap">
                <button id="nrNotifBtn" type="button"
                        class="nrn-icon-btn"
                        aria-expanded="false"
                        aria-controls="nrNotifMenu"
                        aria-label="Notifikasi">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M18 8a6 6 0 1 0-12 0c0 7-3 7-3 7h18s-3 0-3-7"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="nrn-badge-num">{{ $unreadCount }}</span>
                    @endif
                </button>

                <div id="nrNotifMenu" class="nrn-dropdown hidden">
                    <div class="nrn-dd-head" style="background: var(--nav-navy); padding: 1.25rem 1.5rem;">
                        <div class="nrn-dd-head-label" style="color: rgba(255,255,255,0.5); font-weight: 800; font-size: 0.55rem; letter-spacing: 0.15em; text-transform: uppercase;">Notifikasi</div>
                        <div class="nrn-dd-head-title" style="color: var(--nav-gold); font-family: var(--font-display); font-size: 1.1rem; font-weight: 700; margin-top: 0.25rem;">Aktivitas Pembelajaran</div>
                    </div>
                    <div class="nrn-dd-body" style="padding: 0.75rem;">
                        {{-- Priority Recommendation --}}
                        @if($nextLesson && $nextCourse)
                        <a href="{{ route('lessons.show', $nextLesson->id) }}" class="nrn-lesson-card">
                            <div class="nrn-notif-icon-box nrn-notif-icon-box-recommend">
                                <i data-lucide="list" style="width: 20px; height: 20px;"></i>
                            </div>
                            <div class="nrn-notif-content-wrap">
                                <div class="nrn-notif-eyebrow">Lanjutkan materi berikutnya</div>
                                <div class="nrn-notif-main-title">Bab {{ $nextLesson->order_number }}: {{ $nextLesson->title }}</div>
                                <div class="nrn-notif-desc-text">{{ $nextCourse->title }}</div>
                            </div>
                        </a>
                        @endif

                        {{-- Real Notifications --}}
                        @forelse($studentNotifications as $notif)
                        <a href="{{ $notif->action_url ? route('notifications.read', $notif->id) : '#' }}" class="nrn-lesson-card">
                            <div class="nrn-notif-icon-box {{ $notif->is_read ? 'nrn-notif-icon-box-read' : 'nrn-notif-icon-box-unread' }}">
                                @if($notif->type == 'course') <i data-lucide="book-open" style="width: 18px; height: 18px;"></i>
                                @elseif($notif->type == 'result') <i data-lucide="award" style="width: 18px; height: 18px;"></i>
                                @else <i data-lucide="bell" style="width: 18px; height: 18px;"></i> @endif
                            </div>
                            <div class="nrn-notif-content-wrap">
                                <div class="nrn-notif-eyebrow">{{ $notif->created_at->diffForHumans() }}</div>
                                <div class="nrn-notif-main-title-sm">{{ $notif->title }}</div>
                                <div class="nrn-notif-desc-text-sm">{{ Str::limit($notif->message, 45) }}</div>
                            </div>
                            @if(!$notif->is_read)
                                <div class="nrn-notif-unread-indicator"></div>
                            @endif
                        </a>
                        @empty
                            @if(!$nextLesson)
                            <div class="nrn-dd-empty" style="padding: 3rem 1.5rem; text-align: center;">
                                <div class="nrn-dd-empty-icon" style="font-size: 1.5rem; color: #CBD5E1; margin-bottom: 0.75rem;"><i class="fas fa-bell-slash"></i></div>
                                <div class="nrn-dd-empty-text" style="font-size: 0.8rem; font-weight: 700; color: var(--nav-navy);">Belum ada notifikasi.</div>
                                <div class="nrn-dd-empty-sub" style="font-size: 0.65rem; color: #94A3B8; margin-top: 0.25rem;">Kabar terbaru seputar belajarmu akan muncul di sini.</div>
                            </div>
                            @endif
                        @endforelse
                    </div>
                    @if($studentNotifications->isNotEmpty())
                    <a href="{{ route('notifications.index') }}" class="nrn-dd-footer">
                        Lihat Semua Notifikasi <i class="fas fa-arrow-right" style="font-size: 0.6rem; margin-left: 0.25rem;"></i>
                    </a>
                    @endif
                </div>
            </div>
            @endif

            {{-- User menu --}}
            <div class="nrn-dropdown-wrap">
                <button id="nrUserMenuBtn" type="button"
                        class="nrn-user-btn"
                        aria-expanded="false"
                        aria-controls="nrUserMenu">
                    <div class="nrn-user-avatar {{ Auth::user()->role !== 'admin' ? 'nrn-user-avatar-student' : '' }}">
                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="nrn-user-name hidden md:block">{{ Auth::user()->name }}</span>
                    <svg class="nrn-user-chevron" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.24 4.5a.75.75 0 0 1-1.08 0l-4.24-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/>
                    </svg>
                </button>

                <div id="nrUserMenu" class="nrn-dropdown nrn-user-dd hidden">
                    <div class="nrn-user-dd-head">
                        <div class="nrn-user-dd-label">Akun Aktif</div>
                        <div class="nrn-user-dd-name">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="nrn-user-dd-links">
                        @if(Auth::user()->role !== 'admin')
                        <a href="{{ route('dashboard') }}" class="nrn-user-dd-link">
                            Dashboard <span>&rarr;</span>
                        </a>
                        <a href="{{ route('profile') }}" class="nrn-user-dd-link">
                            Profil <span>&rarr;</span>
                        </a>
                        <a href="{{ route('results.index') }}" class="nrn-user-dd-link">
                            Nilai <span>&rarr;</span>
                        </a>
                        @else
                        <a href="{{ route('admin.dashboard') }}" class="nrn-user-dd-link">
                            Admin Panel <span>&rarr;</span>
                        </a>
                        @endif
                    </div>
                    <div class="nrn-user-dd-sep"></div>
                    <div class="nrn-user-dd-logout-wrap">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="nrn-user-dd-logout">
                                <i class="fas fa-sign-out-alt" style="margin-right:0.4rem;font-size:0.7rem"></i>Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>{{-- /nrn-actions --}}
    </div>
</nav>
@endauth

{{-- ════════════════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════════════════ --}}
@hasSection('no-container')
    @yield('content')
@else
<main class="nr-main py-6 sm:py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="main-container">
            @if(session('success'))
            <div class="nrn-flash nrn-flash-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="nrn-flash nrn-flash-error">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
            @endif

            @yield('content')
        </div>
    </div>
</main>
@endif

{{-- ════════════════════════════════════════════════════
     MOBILE BOTTOM NAV — Student
════════════════════════════════════════════════════ --}}
@auth
@if(Auth::user()->role === 'student')
<div class="nrn-bottom-student">
    <div class="nrn-bottom-wrap-student">
        <div class="nrn-bottom-inner-student">
            
            <a href="{{ route('dashboard') }}"
               class="nrn-bottom-link-student {{ request()->routeIs('dashboard') ? 'nrn-btm-active' : '' }}">
                <i data-lucide="home" class="nrn-bottom-icon-student" style="width:24px;height:24px"></i>
                <span class="nrn-bottom-label-student">Home</span>
            </a>

            <a href="{{ route('results.index') }}"
               class="nrn-bottom-link-student {{ request()->routeIs('results.*') ? 'nrn-btm-active' : '' }}">
                <i data-lucide="line-chart" class="nrn-bottom-icon-student" style="width:24px;height:24px"></i>
                <span class="nrn-bottom-label-student">Nilai</span>
            </a>

            {{-- Center Button --}}
            <div class="nrn-spacer"></div>
            <div class="nrn-center-wrap">
                <a href="{{ route('courses.index') }}" class="nrn-center-btn">
                    <i data-lucide="book-open" style="width:28px;height:28px"></i>
                </a>
                <span class="nrn-center-label">Belajar</span>
            </div>

            <a href="{{ route('notifications.index') }}"
               class="nrn-bottom-link-student {{ request()->routeIs('notifications.*') ? 'nrn-btm-active' : '' }}">
                <div class="relative">
                    <i data-lucide="bell" class="nrn-bottom-icon-student" style="width:24px;height:24px"></i>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="nrn-badge-num" style="top: -8px; right: -8px; min-width: 14px; height: 14px; font-size: 0.55rem;">{{ $unreadCount }}</span>
                    @endif
                </div>
                <span class="nrn-bottom-label-student">Notif</span>
            </a>

            <a href="{{ route('profile') }}"
               class="nrn-bottom-link-student {{ request()->routeIs('profile') ? 'nrn-btm-active' : '' }}">
                <i data-lucide="user" class="nrn-bottom-icon-student" style="width:24px;height:24px"></i>
                <span class="nrn-bottom-label-student">Profil</span>
            </a>

        </div>
    </div>
</div>
@endif

{{-- ════════════════════════════════════════════════════
     MOBILE BOTTOM NAV — Admin
════════════════════════════════════════════════════ --}}
@if(Auth::user()->role === 'admin')
<div class="nrn-bottom-admin">
    <div class="nrn-bottom-wrap-admin">
        <div class="nrn-bottom-inner">
            <a href="{{ route('admin.dashboard') }}"
               class="nrn-bottom-link {{ request()->routeIs('admin.dashboard') ? 'nrn-btm-active' : '' }}">
                <i class="fas fa-home nrn-bottom-icon"></i>
                <span class="nrn-bottom-label">Home</span>
            </a>
            <a href="{{ route('admin.schools.index') }}"
               class="nrn-bottom-link {{ request()->routeIs('admin.schools.*') ? 'nrn-btm-active' : '' }}">
                <i class="fas fa-school nrn-bottom-icon"></i>
                <span class="nrn-bottom-label">Sekolah</span>
            </a>
            <a href="{{ route('admin.students.index') }}"
               class="nrn-bottom-link {{ request()->routeIs('admin.students.*') ? 'nrn-btm-active' : '' }}">
                <i class="fas fa-user-graduate nrn-bottom-icon"></i>
                <span class="nrn-bottom-label">Siswa</span>
            </a>
            <a href="{{ route('admin.courses.index') }}"
               class="nrn-bottom-link {{ request()->routeIs('admin.courses.*') ? 'nrn-btm-active' : '' }}">
                <i class="fas fa-book-open nrn-bottom-icon"></i>
                <span class="nrn-bottom-label">Kursus</span>
            </a>
            <a href="{{ route('admin.results.index') }}"
               class="nrn-bottom-link {{ request()->routeIs('admin.results.*') ? 'nrn-btm-active' : '' }}">
                <div class="relative inline-block">
                    <i class="fas fa-poll nrn-bottom-icon"></i>
                    @if(isset($unreadCount) && $unreadCount > 0)
                        <span class="nrn-badge-num" style="top: -8px; right: -8px; min-width: 14px; height: 14px; font-size: 0.55rem;">{{ $unreadCount }}</span>
                    @endif
                </div>
                <span class="nrn-bottom-label">Nilai</span>
            </a>
        </div>
    </div>
</div>
@endif
@endauth

{{-- ════════════════════════════════════════════════════
     SCRIPTS — unchanged logic + clock
════════════════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', () => {

    /* ── Page loader ─────────────────────────────── */
    const loader = document.getElementById('nrLoader');
    if (loader && loader.style.display === 'flex') {
        requestAnimationFrame(() => {
            loader.classList.add('opacity-0');
            window.setTimeout(() => { loader.style.display = 'none'; }, 500);
        });
        try { sessionStorage.setItem('nrmlms_loaded', '1'); } catch (e) {}
    }

    /* ── Dropdown helpers ────────────────────────── */
    const userBtn        = document.getElementById('nrUserMenuBtn');
    const userMenu       = document.getElementById('nrUserMenu');
    const notifBtn       = document.getElementById('nrNotifBtn');
    const notifMenu      = document.getElementById('nrNotifMenu');
    const adminNotifBtn  = document.getElementById('nrAdminNotifBtn');
    const adminNotifMenu = document.getElementById('nrAdminNotifMenu');

    const closeUserMenu       = () => { if (!userMenu  || !userBtn)        return; userMenu.classList.add('hidden');       userBtn.setAttribute('aria-expanded','false'); };
    const closeNotifMenu      = () => { if (!notifMenu || !notifBtn)       return; notifMenu.classList.add('hidden');      notifBtn.setAttribute('aria-expanded','false'); };
    const closeAdminNotifMenu = () => { if (!adminNotifMenu || !adminNotifBtn) return; adminNotifMenu.classList.add('hidden'); adminNotifBtn.setAttribute('aria-expanded','false'); };

    if (userBtn && userMenu) {
        userBtn.addEventListener('click', e => {
            e.stopPropagation();
            const hidden = userMenu.classList.contains('hidden');
            closeNotifMenu(); closeAdminNotifMenu();
            userMenu.classList.toggle('hidden', !hidden);
            userBtn.setAttribute('aria-expanded', hidden ? 'true' : 'false');
        });
    }
    if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', e => {
            e.stopPropagation();
            const hidden = notifMenu.classList.contains('hidden');
            closeUserMenu(); closeAdminNotifMenu();
            notifMenu.classList.toggle('hidden', !hidden);
            notifBtn.setAttribute('aria-expanded', hidden ? 'true' : 'false');
        });
    }
    if (adminNotifBtn && adminNotifMenu) {
        adminNotifBtn.addEventListener('click', e => {
            e.stopPropagation();
            const hidden = adminNotifMenu.classList.contains('hidden');
            closeUserMenu(); closeNotifMenu();
            adminNotifMenu.classList.toggle('hidden', !hidden);
            adminNotifBtn.setAttribute('aria-expanded', hidden ? 'true' : 'false');
        });
    }

    document.addEventListener('click', () => { closeUserMenu(); closeNotifMenu(); closeAdminNotifMenu(); });
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') { closeUserMenu(); closeNotifMenu(); closeAdminNotifMenu(); }
    });

    /* ── Progress bars ───────────────────────────── */
    document.querySelectorAll('[data-progress]').forEach(el => {
        const raw = el.getAttribute('data-progress');
        const value = Number.parseFloat(raw ?? '');
        if (!Number.isFinite(value)) return;
        el.style.width = `${Math.max(0, Math.min(100, value))}%`;
    });

    /* ── Lucide Icons ────────────────────────────── */
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

@yield('scripts')

</body>
</html>
