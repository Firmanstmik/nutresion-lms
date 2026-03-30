@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<div class="ntf-root">

    {{-- ══════════════════════════════════════════════════════════════
         HERO BAND
    ══════════════════════════════════════════════════════════════ --}}
    <section class="ntf-hero">

        {{-- Ambient canvas --}}
        <div class="ntf-canvas" aria-hidden="true">
            <div class="ntf-canvas-mesh"></div>
            <div class="ntf-orb ntf-orb-a"></div>
            <div class="ntf-orb ntf-orb-b"></div>
            <div class="ntf-orb ntf-orb-c"></div>
            <div class="ntf-canvas-noise"></div>
        </div>

        <div class="ntf-hero-inner">

            {{-- Left: Content --}}
            <div class="ntf-hero-left">

                <div class="ntf-hero-pill">
                    <span class="ntf-pill-live"></span>
                    <span>Portal Aktivitas</span>
                    <span class="ntf-pill-sep">·</span>
                    <span>{{ now()->translatedFormat('l, d M Y') }}</span>
                </div>

                <h1 class="ntf-hero-heading">
                    Notifikasi
                    <span class="ntf-heading-accent">
                        Kamu
                        <svg class="ntf-heading-underline" viewBox="0 0 160 12" preserveAspectRatio="none" aria-hidden="true">
                            <path d="M3 9 C40 3, 120 3, 157 9" stroke="url(#nu1)" stroke-width="3.5" fill="none" stroke-linecap="round"/>
                            <defs>
                                <linearGradient id="nu1" x1="0" y1="0" x2="1" y2="0">
                                    <stop offset="0%" stop-color="#4ADE80"/>
                                    <stop offset="100%" stop-color="#34D399" stop-opacity="0"/>
                                </linearGradient>
                            </defs>
                        </svg>
                    </span>
                </h1>

                <p class="ntf-hero-body">
                    Pantau progres belajarmu dan dapatkan info terbaru seputar modul gizi secara real-time.
                </p>

                <form action="{{ route('notifications.read-all') }}" method="POST">
                    @csrf
                    <button type="submit" class="ntf-markall-btn">
                        <span class="ntf-markall-icon">
                            <i class="fas fa-check-double"></i>
                        </span>
                        <span>Tandai Semua Dibaca</span>
                        <span class="ntf-markall-arrow">
                            <i class="fas fa-arrow-right"></i>
                        </span>
                    </button>
                </form>

            </div>

            {{-- Right: KPI cards --}}
            <div class="ntf-hero-right">
                <div class="ntf-kpi-grid">

                    <div class="ntf-kpi ntf-kpi-unread">
                        <div class="ntf-kpi-top">
                            <div class="ntf-kpi-ico">
                                <i class="fas fa-envelope-open-text"></i>
                            </div>
                            <span class="ntf-kpi-tag">Belum Dibaca</span>
                        </div>
                        <div class="ntf-kpi-num">{{ $notifications->where('is_read', false)->count() }}</div>
                        <div class="ntf-kpi-sub">Pesan baru</div>
                        <div class="ntf-kpi-bar"></div>
                    </div>

                    <div class="ntf-kpi ntf-kpi-total">
                        <div class="ntf-kpi-top">
                            <div class="ntf-kpi-ico">
                                <i class="fas fa-inbox"></i>
                            </div>
                            <span class="ntf-kpi-tag">Total Histori</span>
                        </div>
                        <div class="ntf-kpi-num">{{ $notifications->count() }}</div>
                        <div class="ntf-kpi-sub">Aktivitas tercatat</div>
                        <div class="ntf-kpi-bar"></div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════════════
         STICKY RAIL
    ══════════════════════════════════════════════════════════════ --}}
    <div class="ntf-rail">
        <div class="ntf-rail-inner">
            <div class="ntf-rail-left">
                <span class="ntf-rail-label">Log Aktivitas</span>
                <span class="ntf-rail-sub">Timeline notifikasi terbaru</span>
            </div>
            @php $unreadCount = $notifications->where('is_read', false)->count(); @endphp
            @if($unreadCount > 0)
                <span class="ntf-unread-pill">
                    <span class="ntf-unread-dot"></span>
                    {{ $unreadCount }} belum dibaca
                </span>
            @else
                <span class="ntf-all-read-pill">
                    <i class="fas fa-check-circle"></i>
                    Semua sudah dibaca
                </span>
            @endif
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════
         MAIN CONTENT
    ══════════════════════════════════════════════════════════════ --}}
    <div class="ntf-body">

        {{-- ── Recommendation Banner ──────────────────────────── --}}
        @php
            $latestProgress = \App\Models\UserProgress::where('user_id', Auth::id())
                ->where('is_completed', true)
                ->with('lesson.course.lessons')
                ->latest('updated_at')
                ->first();

            $nextLesson = null;
            $nextCourse = null;

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
        @endphp

        @if($nextLesson && $nextCourse)
        <div class="ntf-rec-wrap">
            <a href="{{ route('lessons.show', $nextLesson->id) }}" class="ntf-rec-card">

                {{-- Ambient glow --}}
                <div class="ntf-rec-glow" aria-hidden="true"></div>

                <div class="ntf-rec-left">
                    <div class="ntf-rec-tag">
                        <i class="fas fa-bolt"></i>
                        Rekomendasi Untukmu
                    </div>
                    <div class="ntf-rec-course">{{ $nextCourse->title }}</div>
                    <h3 class="ntf-rec-lesson">{{ $nextLesson->title }}</h3>
                    <div class="ntf-rec-chapter">
                        <i class="fas fa-layer-group"></i>
                        Bab {{ $nextLesson->order_number }}
                    </div>
                </div>

                <div class="ntf-rec-right">
                    <div class="ntf-rec-play">
                        <i class="fas fa-play"></i>
                    </div>
                    <div class="ntf-rec-label">Lanjutkan</div>
                </div>

            </a>
        </div>
        @endif

        {{-- ── Timeline ───────────────────────────────────────── --}}
        <div class="ntf-timeline-wrap">

            @forelse($notifications as $i => $notif)

                @php
                    $icon = match($notif->type ?? '') {
                        'course' => 'fa-book-open',
                        'result' => 'fa-trophy',
                        default  => 'fa-bell',
                    };
                    $isUnread = !$notif->is_read;
                @endphp

                <article
                    class="ntf-item {{ $isUnread ? 'ntf-item-unread' : '' }}"
                    style="--i: {{ $i }}"
                >
                    {{-- Icon column --}}
                    <div class="ntf-item-icon-col">
                        <div class="ntf-item-ico {{ $isUnread ? 'ntf-ico-unread' : '' }}">
                            <i class="fas {{ $icon }}"></i>
                        </div>
                        @if($i < $notifications->count() - 1)
                            <div class="ntf-item-line" aria-hidden="true"></div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="ntf-item-content">
                        <div class="ntf-item-row">
                            <span class="ntf-item-time">
                                <i class="fas fa-clock"></i>
                                {{ $notif->created_at->diffForHumans() }}
                            </span>
                            @if($isUnread)
                                <span class="ntf-new-badge">Baru</span>
                            @endif
                        </div>
                        <h4 class="ntf-item-title">{{ $notif->title }}</h4>
                        <p class="ntf-item-msg">{{ $notif->message }}</p>
                        @if($notif->action_url)
                            <a href="{{ route('notifications.read', $notif->id) }}" class="ntf-item-cta">
                                <span>
                                    @if($notif->type === 'course')
                                        Lanjutkan Belajar
                                    @elseif($notif->type === 'result')
                                        Lihat Nilai
                                    @else
                                        Lihat Detail
                                    @endif
                                </span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>

                </article>

            @empty

                <div class="ntf-empty">
                    <div class="ntf-empty-visual">
                        <div class="ntf-empty-rings" aria-hidden="true">
                            <div class="ntf-er ntf-er1"></div>
                            <div class="ntf-er ntf-er2"></div>
                            <div class="ntf-er ntf-er3"></div>
                        </div>
                        <div class="ntf-empty-ico">
                            <i class="fas fa-inbox"></i>
                        </div>
                    </div>
                    <h3 class="ntf-empty-title">Belum Ada Notifikasi</h3>
                    <p class="ntf-empty-body">Kabar terbaru seputar aktivitas belajarmu akan muncul di sini.</p>
                </div>

            @endforelse

        </div>
    </div>

</div>{{-- ntf-root --}}


<style>
/* ╔══════════════════════════════════════════════════════════════════
   ║  DESIGN TOKENS  — identical palette to courses page
   ╚══════════════════════════════════════════════════════════════════ */
:root {
    --g900: #052E17;
    --g800: #0A3D21;
    --g700: #0D5C34;
    --g600: #187945;
    --g500: #1E9152;
    --g400: #22C55E;
    --g300: #4ADE80;
    --g200: #86EFAC;
    --g100: #DCFCE7;
    --g50:  #F0FDF4;

    --gold:    #D97706;
    --gold-lt: #FCD34D;

    --ink:    #0C1A12;
    --ink-80: #1C2B22;
    --muted:  #6B7280;
    --quiet:  #9CA3AF;
    --border: #E5E7EB;
    --surface:#F7FAF8;
    --white:  #FFFFFF;

    --s1: 0 1px 3px rgba(10,61,33,0.06), 0 1px 2px rgba(0,0,0,0.04);
    --s2: 0 4px 16px rgba(10,61,33,0.08), 0 2px 6px rgba(0,0,0,0.04);
    --s3: 0 12px 36px rgba(10,61,33,0.12), 0 4px 12px rgba(0,0,0,0.06);
    --s4: 0 24px 56px rgba(10,61,33,0.16), 0 8px 24px rgba(0,0,0,0.08);
    --s-glow: 0 0 0 3px rgba(74,222,128,0.18);

    --font: 'Plus Jakarta Sans', system-ui, sans-serif;

    --r-sm:   8px;
    --r-md:   12px;
    --r-lg:   16px;
    --r-xl:   20px;
    --r-2xl:  24px;
    --r-full: 9999px;

    --t-fast: 180ms cubic-bezier(0.4,0,0.2,1);
    --t-base: 260ms cubic-bezier(0.4,0,0.2,1);
    --t-slow: 400ms cubic-bezier(0.34,1.56,0.64,1);
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  ROOT
   ╚══════════════════════════════════════════════════════════════════ */
.ntf-root *,
.ntf-root *::before,
.ntf-root *::after { box-sizing: border-box; }

.ntf-root {
    font-family: var(--font);
    background: var(--surface);
    min-height: 100vh;
    margin: -1.5rem -1rem 0;
    overflow-x: hidden;
    color: var(--ink);
}
@media (min-width: 640px)  { .ntf-root { margin: -2.5rem -1.5rem 0; } }
@media (min-width: 1024px) { .ntf-root { margin: -2.5rem -2rem 0; } }

/* ╔══════════════════════════════════════════════════════════════════
   ║  HERO
   ╚══════════════════════════════════════════════════════════════════ */
.ntf-hero {
    position: relative;
    background: var(--g800);
    overflow: hidden;
    padding: 3.5rem 1.5rem 3.5rem;
}
@media (min-width: 840px)  { .ntf-hero { padding: 4.5rem 3.5rem; } }
@media (min-width: 1100px) { .ntf-hero { padding: 5rem 4.5rem; } }

/* Canvas */
.ntf-canvas {
    position: absolute;
    inset: 0;
    pointer-events: none;
    z-index: 1;
}
.ntf-canvas-mesh {
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
    background-size: 48px 48px;
}
.ntf-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(96px);
}
.ntf-orb-a { width: 500px; height: 500px; background: radial-gradient(circle, rgba(34,197,94,0.13), transparent 70%); top: -180px; right: -100px; }
.ntf-orb-b { width: 340px; height: 340px; background: radial-gradient(circle, rgba(217,119,6,0.07), transparent 70%); bottom: -80px; left: -60px; }
.ntf-orb-c { width: 240px; height: 240px; background: radial-gradient(circle, rgba(74,222,128,0.09), transparent 70%); top: 30%; left: 45%; }
.ntf-canvas-noise {
    position: absolute;
    inset: 0;
    opacity: 0.025;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
    background-size: 200px;
}

/* Inner layout */
.ntf-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    gap: 3rem;
}

/* ─── Left ──────────────────────────────────────────────────────── */
.ntf-hero-left {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0;
    min-width: 0;
}

.ntf-hero-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.3rem 0.85rem;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.13);
    border-radius: var(--r-full);
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: rgba(255,255,255,0.55);
    text-transform: uppercase;
    margin-bottom: 1.5rem;
    width: fit-content;
}
.ntf-pill-live {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--g300);
    animation: ntf-ping 2s infinite;
}
@keyframes ntf-ping {
    0%   { box-shadow: 0 0 0 0 rgba(74,222,128,0.6); }
    70%  { box-shadow: 0 0 0 7px rgba(74,222,128,0); }
    100% { box-shadow: 0 0 0 0 rgba(74,222,128,0); }
}
.ntf-pill-sep { opacity: 0.3; }

.ntf-hero-heading {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 900;
    line-height: 1.08;
    letter-spacing: -0.03em;
    color: #fff;
    margin-bottom: 1.1rem;
}
.ntf-heading-accent {
    color: var(--g300);
    position: relative;
    display: inline-block;
}
.ntf-heading-underline {
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 100%;
    height: 12px;
    overflow: visible;
}

.ntf-hero-body {
    font-size: 0.875rem;
    font-weight: 400;
    line-height: 1.75;
    color: rgba(255,255,255,0.5);
    max-width: 44ch;
    margin-bottom: 2rem;
}

/* Mark-all button */
.ntf-markall-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.85rem 1.35rem;
    background: rgba(255,255,255,0.08);
    border: 1.5px solid rgba(255,255,255,0.16);
    border-radius: var(--r-lg);
    font-family: var(--font);
    font-size: 0.78rem;
    font-weight: 700;
    color: rgba(255,255,255,0.85);
    cursor: pointer;
    transition: all var(--t-base);
    backdrop-filter: blur(12px);
    width: fit-content;
    letter-spacing: 0.02em;
}
.ntf-markall-btn:hover {
    background: rgba(255,255,255,0.14);
    border-color: rgba(74,222,128,0.4);
    color: #fff;
    box-shadow: var(--s-glow);
    transform: translateY(-1px);
}
.ntf-markall-icon {
    width: 28px; height: 28px;
    background: linear-gradient(135deg, var(--g400), var(--g500));
    border-radius: var(--r-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    color: var(--ink);
    flex-shrink: 0;
}
.ntf-markall-arrow {
    margin-left: auto;
    width: 22px; height: 22px;
    background: rgba(255,255,255,0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.55rem;
    color: rgba(255,255,255,0.6);
    transition: transform var(--t-fast);
}
.ntf-markall-btn:hover .ntf-markall-arrow { transform: translateX(2px); }

/* ─── Right: KPI grid ───────────────────────────────────────────── */
.ntf-hero-right {
    flex-shrink: 0;
    display: none;
}
@media (min-width: 760px) { .ntf-hero-right { display: block; } }

.ntf-kpi-grid {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
    width: 220px;
}

.ntf-kpi {
    position: relative;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.11);
    border-radius: var(--r-xl);
    padding: 1.1rem 1.25rem 1.25rem;
    backdrop-filter: blur(16px);
    overflow: hidden;
    transition: all var(--t-base);
}
.ntf-kpi:hover {
    background: rgba(255,255,255,0.10);
    border-color: rgba(255,255,255,0.18);
    transform: translateY(-2px);
}
.ntf-kpi-top {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    margin-bottom: 0.85rem;
}
.ntf-kpi-ico {
    width: 32px; height: 32px;
    border-radius: var(--r-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    flex-shrink: 0;
}
.ntf-kpi-unread .ntf-kpi-ico {
    background: rgba(252,211,77,0.18);
    color: var(--gold-lt);
}
.ntf-kpi-total .ntf-kpi-ico {
    background: rgba(74,222,128,0.15);
    color: var(--g300);
}
.ntf-kpi-tag {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.4);
}
.ntf-kpi-num {
    font-size: 2.25rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    letter-spacing: -0.04em;
    margin-bottom: 0.25rem;
}
.ntf-kpi-sub {
    font-size: 0.62rem;
    font-weight: 500;
    color: rgba(255,255,255,0.38);
}
.ntf-kpi-bar {
    position: absolute;
    bottom: 0; left: 0;
    height: 2.5px;
    width: 50%;
    border-radius: var(--r-full);
}
.ntf-kpi-unread .ntf-kpi-bar { background: linear-gradient(90deg, var(--gold), transparent); }
.ntf-kpi-total  .ntf-kpi-bar { background: linear-gradient(90deg, var(--g300), transparent); }

/* ╔══════════════════════════════════════════════════════════════════
   ║  STICKY RAIL
   ╚══════════════════════════════════════════════════════════════════ */
.ntf-rail {
    background: var(--white);
    border-bottom: 1px solid var(--border);
    position: sticky;
    top: 0;
    z-index: 30;
    box-shadow: 0 2px 16px rgba(10,61,33,0.06);
}
.ntf-rail-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0.85rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
@media (min-width: 640px) { .ntf-rail-inner { padding: 0.85rem 2rem; } }

.ntf-rail-left {
    display: flex;
    flex-direction: column;
    gap: 1px;
}
.ntf-rail-label {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--ink);
}
.ntf-rail-sub {
    font-size: 0.62rem;
    font-weight: 500;
    color: var(--quiet);
}
.ntf-unread-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.32rem 0.8rem;
    background: rgba(30,145,82,0.08);
    border: 1px solid rgba(30,145,82,0.18);
    border-radius: var(--r-full);
    font-size: 0.62rem;
    font-weight: 700;
    color: var(--g500);
    flex-shrink: 0;
}
.ntf-unread-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--g400);
    animation: ntf-ping 2s infinite;
}
.ntf-all-read-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.32rem 0.8rem;
    background: var(--g50);
    border: 1px solid var(--g100);
    border-radius: var(--r-full);
    font-size: 0.62rem;
    font-weight: 700;
    color: var(--g500);
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  BODY CONTAINER
   ╚══════════════════════════════════════════════════════════════════ */
.ntf-body {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2.5rem 1.5rem 6rem;
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}
@media (min-width: 640px) { .ntf-body { padding: 2.5rem 2rem 6rem; } }
@media (min-width: 1024px) { .ntf-body { padding: 3rem 2.5rem 7rem; } }

/* ╔══════════════════════════════════════════════════════════════════
   ║  RECOMMENDATION CARD
   ╚══════════════════════════════════════════════════════════════════ */
.ntf-rec-wrap {
    animation: ntf-fadein 0.5s ease both;
}
.ntf-rec-card {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    padding: 1.75rem 2rem;
    background: linear-gradient(135deg, var(--g800) 0%, var(--g700) 60%, var(--g600) 100%);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: var(--r-2xl);
    text-decoration: none;
    overflow: hidden;
    box-shadow: var(--s3);
    transition: all var(--t-base);
}
.ntf-rec-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--s4);
}
.ntf-rec-glow {
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(74,222,128,0.18), transparent 70%);
    pointer-events: none;
    filter: blur(30px);
}

.ntf-rec-left { display: flex; flex-direction: column; gap: 0.35rem; z-index: 1; }
.ntf-rec-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.58rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: var(--g300);
    margin-bottom: 0.1rem;
}
.ntf-rec-tag .fas { font-size: 0.55rem; }
.ntf-rec-course {
    font-size: 0.7rem;
    font-weight: 600;
    color: rgba(255,255,255,0.5);
    letter-spacing: 0.02em;
}
.ntf-rec-lesson {
    font-size: 1.1rem;
    font-weight: 800;
    color: #fff;
    line-height: 1.3;
    margin: 0;
    max-width: 36ch;
}
@media (min-width: 640px) { .ntf-rec-lesson { font-size: 1.2rem; } }
.ntf-rec-chapter {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.62rem;
    font-weight: 700;
    color: rgba(255,255,255,0.45);
    margin-top: 0.2rem;
}
.ntf-rec-chapter .fas { font-size: 0.52rem; color: var(--g300); }

.ntf-rec-right {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    flex-shrink: 0;
    z-index: 1;
}
.ntf-rec-play {
    width: 52px; height: 52px;
    background: linear-gradient(135deg, var(--g400), var(--g300));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    color: var(--ink);
    box-shadow: 0 6px 20px rgba(34,197,94,0.4);
    transition: all var(--t-base);
}
.ntf-rec-card:hover .ntf-rec-play {
    transform: scale(1.08);
    box-shadow: 0 10px 28px rgba(34,197,94,0.5);
}
.ntf-rec-label {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.4);
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  TIMELINE
   ╚══════════════════════════════════════════════════════════════════ */
.ntf-timeline-wrap {
    background: var(--white);
    border: 1px solid var(--border);
    border-radius: var(--r-2xl);
    overflow: hidden;
    box-shadow: var(--s2);
}

.ntf-item {
    display: flex;
    gap: 1rem;
    padding: 1.35rem 1.5rem;
    border-bottom: 1px solid var(--border);
    transition: background var(--t-fast);
    position: relative;

    opacity: 0;
    animation: ntf-fadein 0.45s calc(var(--i, 0) * 55ms) ease both;
}
.ntf-item:last-child { border-bottom: none; }
.ntf-item:hover { background: var(--g50); }
.ntf-item-unread { background: #F0FDF4; }
.ntf-item-unread:hover { background: #E7FAF0; }

/* Unread left accent */
.ntf-item-unread::before {
    content: '';
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, var(--g400), var(--g500));
    border-radius: 0 2px 2px 0;
}

/* Icon column */
.ntf-item-icon-col {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0;
    flex-shrink: 0;
    padding-top: 2px;
}
.ntf-item-ico {
    width: 38px; height: 38px;
    border-radius: var(--r-md);
    background: var(--surface);
    border: 1px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
    color: var(--muted);
    flex-shrink: 0;
    transition: all var(--t-fast);
}
.ntf-ico-unread {
    background: var(--g50);
    border-color: var(--g200);
    color: var(--g500);
}
.ntf-item:hover .ntf-item-ico { border-color: var(--g200); color: var(--g500); }

.ntf-item-line {
    flex: 1;
    width: 1px;
    background: linear-gradient(to bottom, var(--border), transparent);
    min-height: 16px;
    margin-top: 6px;
}

/* Content */
.ntf-item-content {
    flex: 1;
    min-width: 0;
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}
.ntf-item-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
}
.ntf-item-time {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.65rem;
    font-weight: 600;
    color: var(--quiet);
}
.ntf-item-time .fas { font-size: 0.55rem; }

.ntf-new-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.18rem 0.55rem;
    background: linear-gradient(135deg, var(--g500), var(--g400));
    color: #fff;
    border-radius: var(--r-full);
    font-size: 0.52rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    box-shadow: 0 2px 8px rgba(30,145,82,0.3);
    flex-shrink: 0;
}

.ntf-item-title {
    font-size: 0.9rem;
    font-weight: 800;
    color: var(--ink);
    line-height: 1.35;
    margin: 0;
}
.ntf-item-msg {
    font-size: 0.78rem;
    font-weight: 400;
    line-height: 1.65;
    color: var(--muted);
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.ntf-item-cta {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.7rem;
    font-weight: 800;
    color: var(--g500);
    text-decoration: none;
    letter-spacing: 0.03em;
    margin-top: 0.15rem;
    transition: color var(--t-fast);
}
.ntf-item-cta .fas {
    font-size: 0.58rem;
    transition: transform var(--t-fast);
}
.ntf-item-cta:hover { color: var(--g600); }
.ntf-item-cta:hover .fas { transform: translateX(3px); }

/* ╔══════════════════════════════════════════════════════════════════
   ║  EMPTY STATE
   ╚══════════════════════════════════════════════════════════════════ */
.ntf-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 1rem;
    padding: 5rem 1.5rem 6rem;
    text-align: center;
}
.ntf-empty-visual {
    position: relative;
    width: 100px; height: 100px;
    margin-bottom: 0.5rem;
}
.ntf-empty-rings {
    position: absolute;
    inset: 50%;
    transform: translate(-50%, -50%);
}
.ntf-er {
    position: absolute;
    border-radius: 50%;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
}
.ntf-er1 { width: 80px;  height: 80px;  border: 1px solid rgba(30,145,82,0.15); }
.ntf-er2 { width: 140px; height: 140px; border: 1px dashed rgba(30,145,82,0.08); }
.ntf-er3 { width: 200px; height: 200px; border: 1px solid rgba(30,145,82,0.04); }
.ntf-empty-ico {
    position: relative;
    z-index: 2;
    width: 56px; height: 56px;
    background: var(--g50);
    border: 2px solid var(--g100);
    border-radius: var(--r-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--g500);
    margin: 22px auto 0;
    box-shadow: var(--s2);
}
.ntf-empty-title {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--ink);
    letter-spacing: -0.02em;
    margin: 0;
}
.ntf-empty-body {
    font-size: 0.84rem;
    font-weight: 400;
    line-height: 1.7;
    color: var(--muted);
    max-width: 38ch;
    margin: 0;
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  ANIMATION
   ╚══════════════════════════════════════════════════════════════════ */
@keyframes ntf-fadein {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ╔══════════════════════════════════════════════════════════════════
   ║  MOBILE
   ╚══════════════════════════════════════════════════════════════════ */
@media (max-width: 559px) {
    .ntf-hero { padding: 2.75rem 1.25rem 3rem; }
    .ntf-hero-heading { font-size: 2.1rem; }
    .ntf-body { padding: 1.5rem 1rem 5rem; gap: 1.1rem; }
    .ntf-rec-card { padding: 1.35rem 1.25rem; }
    .ntf-rec-lesson { font-size: 1rem; }
    .ntf-rec-play { width: 44px; height: 44px; font-size: 0.75rem; }
    .ntf-item { padding: 1.1rem 1.1rem 1.1rem 1.3rem; }
    .ntf-item-ico { width: 34px; height: 34px; font-size: 0.65rem; }
    .ntf-markall-btn { font-size: 0.74rem; padding: 0.75rem 1.1rem; }
}
</style>

@endsection