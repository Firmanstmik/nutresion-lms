@extends('layouts.app')

@section('hero')
<div class="nrs-root" style="padding-top: 0.5px;">
    {{-- ═══════════════════════════════════════════════════════════════
         HERO SECTION — Completely Unchanged
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="relative overflow-visible mb-6">
        <div class="hero-img-box relative h-[170px] sm:h-[260px] lg:h-[320px] w-full rounded-t-none rounded-b-3xl overflow-hidden shadow-2xl shadow-gray-200/60 border border-gray-100 ring-1 ring-black/5">
            <img src="{{ route('brand.hero') }}" alt="Hero" class="absolute inset-0 w-full h-full object-cover object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-black/55 via-black/20 to-transparent"></div>
            <div class="absolute inset-0 bg-[radial-gradient(70%_60%_at_85%_10%,rgba(255,255,255,0.18),rgba(255,255,255,0)_55%)]"></div>
        </div>

        <style>
        .fabric-zone{position:relative;z-index:30;margin:-22px 1rem 0;animation:fabricRise .85s cubic-bezier(.16,1,.3,1) .12s both}
        @media (min-width:640px){.fabric-zone{margin:-30px 1.5rem 0}}
        @media (min-width:768px){.fabric-zone{max-width:660px;margin:-30px auto 0}}
        @media (min-width:1024px){.fabric-zone{max-width:740px}}

        .fabric-pins{display:flex;justify-content:space-between;padding:0 22px;position:relative;z-index:3;pointer-events:none}
        .fpin{display:flex;flex-direction:column;align-items:center}
        .fpin::before{content:'';width:2px;height:12px;background:linear-gradient(180deg,rgba(255,255,255,.55),rgba(200,200,200,.25))}
        .fpin::after{content:'';width:9px;height:16px;background:linear-gradient(180deg,#FFE082 0%,#F5A623 55%,#C87D0E 100%);border-radius:4px 4px 3px 3px;box-shadow:0 3px 7px rgba(0,0,0,.26),inset 0 1px 0 rgba(255,255,255,.45),inset 1px 0 0 rgba(255,255,255,.15),inset -1px 0 0 rgba(0,0,0,.10)}

        .fabric-card{position:relative;background:linear-gradient(155deg,#0D5C34 0%,#187945 28%,#1E9152 58%,#23A85D 82%,#2BBF68 100%);border-radius:0 0 4px 4px;padding:12px 16px 28px;box-shadow:0 14px 42px rgba(10,50,28,.40),0 5px 12px rgba(10,50,28,.16),inset 0 1px 0 rgba(255,255,255,.14),inset 0 -1px 0 rgba(0,0,0,.12);overflow:hidden;transform-origin:top center;animation:fabricWave 7s ease-in-out infinite;will-change:transform;clip-path:polygon(0% 0%,100% 0%,100% 84%,97.5% 92%,95% 100%,92.5% 92%,90% 84%,87.5% 92%,85% 100%,82.5% 92%,80% 84%,77.5% 92%,75% 100%,72.5% 92%,70% 84%,67.5% 92%,65% 100%,62.5% 92%,60% 84%,57.5% 92%,55% 100%,52.5% 92%,50% 84%,47.5% 92%,45% 100%,42.5% 92%,40% 84%,37.5% 92%,35% 100%,32.5% 92%,30% 84%,27.5% 92%,25% 100%,22.5% 92%,20% 84%,17.5% 92%,15% 100%,12.5% 92%,10% 84%,7.5% 92%,5% 100%,2.5% 92%,0% 84%)}
        .fabric-card::before{content:'';position:absolute;inset:0;background-image:repeating-linear-gradient(45deg,rgba(255,255,255,.028) 0,rgba(255,255,255,.028) 1px,transparent 1px,transparent 9px),repeating-linear-gradient(-45deg,rgba(255,255,255,.028) 0,rgba(255,255,255,.028) 1px,transparent 1px,transparent 9px);z-index:0;pointer-events:none}
        .fabric-card::after{content:'';position:absolute;inset:0;background:linear-gradient(112deg,transparent 20%,rgba(255,255,255,.07) 38%,rgba(255,255,255,.18) 50%,rgba(255,255,255,.07) 62%,transparent 80%);animation:sheenSweep 5.5s ease-in-out 2.5s infinite;z-index:1;pointer-events:none}

        @keyframes fabricWave{0%{transform:perspective(900px) rotateX(2.4deg) skewX(-0.5deg) translateY(0) scaleY(1)}18%{transform:perspective(900px) rotateX(-0.7deg) skewX(1.1deg) translateY(-5px) scaleY(.998)}38%{transform:perspective(900px) rotateX(1.6deg) skewX(-0.8deg) translateY(-2px) scaleY(1.001)}55%{transform:perspective(900px) rotateX(-1.5deg) skewX(1deg) translateY(-7px) scaleY(.997)}74%{transform:perspective(900px) rotateX(1deg) skewX(-0.4deg) translateY(-3px) scaleY(1)}100%{transform:perspective(900px) rotateX(2.4deg) skewX(-0.5deg) translateY(0) scaleY(1)}}
        @keyframes sheenSweep{0%{transform:translateX(-115%);opacity:0}12%{opacity:1}88%{opacity:1}100%{transform:translateX(115%);opacity:0}}
        @keyframes fabricRise{from{opacity:0;transform:translateY(22px)}to{opacity:1;transform:translateY(0)}}

        .fabric-fold-l,.fabric-fold-r{position:absolute;top:0;bottom:0;width:30px;pointer-events:none;z-index:2}
        .fabric-fold-l{left:0;background:linear-gradient(90deg,rgba(0,0,0,.20),transparent)}
        .fabric-fold-r{right:0;background:linear-gradient(-90deg,rgba(0,0,0,.20),transparent)}

        .fabric-inner{position:relative;z-index:3}
        .fabric-eyebrow{display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.26);border-radius:100px;padding:3px 10px 3px 7px;font-family:var(--font-sans);font-size:8px;font-weight:800;color:rgba(255,255,255,0.90);letter-spacing:0.08em;text-transform:uppercase;margin-bottom:7px}
        .pulse-dot{width:8px;height:8px;border-radius:50%;background:#FFD166;animation:pulseRing 2.2s ease-out infinite}
        @keyframes pulseRing{0%{box-shadow:0 0 0 0 rgba(255,209,102,0.75)}65%{box-shadow:0 0 0 8px rgba(255,209,102,0)}100%{box-shadow:0 0 0 0 rgba(255,209,102,0)}}

        .fabric-greeting{font-family:var(--font-heading);font-size:18px;font-weight:500;color:rgba(255,255,255,0.78);line-height:1.05;letter-spacing:0.01em}
        @media (min-width:640px){.fabric-greeting{font-size:24px}}
        .fabric-name{font-family:var(--font-heading);font-size:24px;font-weight:700;color:#fff;line-height:1;letter-spacing:-0.01em;display:flex;align-items:center;gap:8px;flex-wrap:wrap}
        @media (min-width:640px){.fabric-name{font-size:32px}}
        .fabric-desc{margin-top:6px;font-family:var(--font-sans);font-size:10px;font-weight:600;color:rgba(255,255,255,0.68);line-height:1.45;max-width:360px;display:-webkit-box;-webkit-line-clamp:2;line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
        @media (min-width:640px){.fabric-desc{font-size:11px}}
        .fabric-deco{position:absolute;top:-14px;right:-10px;width:78px;height:78px;opacity:0.10;transform:rotate(-18deg);pointer-events:none;z-index:1;user-select:none}
        @media (max-width:639px){.fabric-deco{display:none}}
        </style>

        <div class="fabric-zone">
            <div class="fabric-pins" aria-hidden="true">
                <div class="fpin"></div>
                <div class="fpin"></div>
                <div class="fpin"></div>
                <div class="fpin"></div>
                <div class="fpin"></div>
            </div>

            <div class="fabric-card">
                <svg class="fabric-deco" viewBox="0 0 128 128" fill="none" aria-hidden="true">
                    <path d="M86 16c-8 10-10 22-5 34 6 15 5 30-5 45-11 16-31 29-53 33 9-15 10-29 2-42-7-12-22-21-40-24 23-5 42-17 53-33 10-15 11-30 5-45 12 6 24 9 43 32Z" fill="rgba(255,255,255,0.55)"/>
                </svg>

                <div class="fabric-fold-l" aria-hidden="true"></div>
                <div class="fabric-fold-r" aria-hidden="true"></div>

                <div class="fabric-inner">
                    <div class="fabric-eyebrow">
                        <span class="pulse-dot"></span>
                        Aktif Hari Ini
                    </div>

                    <div class="fabric-greeting">Selamat Datang,</div>

                    <div class="fabric-name">
                        {{ Auth::user()->name }}
                    </div>

                    <p class="fabric-desc">
                        Selamat datang di Nutrition Rescue Mission. Mari lanjutkan perjalanan belajarmu hari ini.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- Google Fonts --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500;9..40,600;9..40,700&family=JetBrains+Mono:wght@400;600&swap" rel="stylesheet">

<div class="nrs-root">
    {{-- ═══════════════════════════════════════════════════════════════
         KPI STRIP — Three Key Stats
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="nrs-kpi-strip">

        <div class="nrs-kpi-card" style="--accent: var(--nrs-green)">
            <div class="nrs-kpi-index">01</div>
            <div class="nrs-kpi-body">
                <div class="nrs-kpi-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <div class="nrs-kpi-info">
                    <div class="nrs-kpi-label">Total Pembelajaran</div>
                    <div class="nrs-kpi-value">{{ $total_courses }}</div>
                    <div class="nrs-kpi-unit">Kursus Tersedia</div>
                </div>
            </div>
            <div class="nrs-kpi-arrow"><i class="fas fa-arrow-up-right"></i></div>
            <div class="nrs-kpi-accent-line"></div>
        </div>

        <div class="nrs-kpi-card" style="--accent: var(--nrs-teal)">
            <div class="nrs-kpi-index">02</div>
            <div class="nrs-kpi-body">
                <div class="nrs-kpi-icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <div class="nrs-kpi-info">
                    <div class="nrs-kpi-label">Kursus Selesai</div>
                    <div class="nrs-kpi-value">{{ $completed_courses }}</div>
                    <div class="nrs-kpi-unit">Materi Tuntas</div>
                </div>
            </div>
            <div class="nrs-kpi-arrow"><i class="fas fa-arrow-up-right"></i></div>
            <div class="nrs-kpi-accent-line"></div>
        </div>

        <div class="nrs-kpi-card" style="--accent: var(--nrs-gold)">
            <div class="nrs-kpi-index">03</div>
            <div class="nrs-kpi-body">
                <div class="nrs-kpi-icon">
                    <i class="fas fa-award"></i>
                </div>
                <div class="nrs-kpi-info">
                    <div class="nrs-kpi-label">Total Skor</div>
                    <div class="nrs-kpi-value">{{ Auth::user()->results->sum('score') }}</div>
                    <div class="nrs-kpi-unit">Poin Diraih</div>
                </div>
            </div>
            <div class="nrs-kpi-arrow"><i class="fas fa-arrow-up-right"></i></div>
            <div class="nrs-kpi-accent-line"></div>
        </div>

    </div>

    {{-- ═══════════════════════════════════════════════════════════════
         MAIN BODY
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="nrs-body">

        {{-- ─── Calendar Panel ─────────────────────────────────────── --}}
        @php
            $selectedKey = $calendarDate->format('Y-m-d');
            $selOpened = (int) ($calendarLessonsOpenedByDay[$selectedKey] ?? 0);
            $selDone = (int) ($calendarProgressDoneByDay[$selectedKey] ?? 0);
            $selTests = (int) ($calendarTestsByDay[$selectedKey] ?? 0);
            $selTotal = $selOpened + $selDone + $selTests;
        @endphp

        <section id="nrCalendarDetails" class="nrs-panel">

            {{-- Panel Header --}}
            <div class="nrs-panel-head">
                <div class="nrs-panel-title-group">
                    <div class="nrs-panel-tag">
                        <span class="nrs-tag-dot"></span>
                        JADWAL BELAJAR
                    </div>
                    <h2 class="nrs-panel-title">Aktivitas <span class="nrs-panel-title-em">Harianmu</span></h2>
                </div>
                <div class="nrs-panel-head-right">
                    <div class="nrs-date-badge">
                        <i class="fas fa-calendar-alt"></i>
                        <span>{{ $calendarDate->format('d M Y') }}</span>
                    </div>
                    <div class="nrs-activity-chip {{ $selTotal > 0 ? 'nrs-chip-active' : 'nrs-chip-empty' }}">
                        {{ $selTotal > 0 ? $selTotal . ' aktivitas' : 'Belum ada aktivitas' }}
                    </div>
                </div>
            </div>

            <div class="nrs-panel-body">

                {{-- Month Navigator --}}
                <div class="nrs-month-nav">
                    <div class="nrs-month-left">
                        <div class="nrs-month-badge">
                            <span class="nrs-month-num">{{ $calendarMonthDate->format('m') }}</span>
                        </div>
                        <div>
                            <p class="nrs-month-eyebrow">Bulan Aktif</p>
                            <p class="nrs-month-name">{{ $calendarMonthDate->format('F Y') }}</p>
                        </div>
                    </div>
                    <div class="nrs-month-nav-btns">
                        @php
                            $prevMonthFirstDate = $calendarMonthDate->copy()->subMonth()->startOfMonth()->format('Y-m-d');
                            $nextMonthFirstDate = $calendarMonthDate->copy()->addMonth()->startOfMonth()->format('Y-m-d');
                        @endphp
                        <a href="{{ route('dashboard', ['calendar_course' => $calendarCourseId, 'calendar_month' => $calendarPrevMonth, 'calendar_date' => $prevMonthFirstDate]) }}" class="nrs-nav-btn">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="{{ route('dashboard', ['calendar_course' => $calendarCourseId, 'calendar_month' => $calendarNextMonth, 'calendar_date' => $nextMonthFirstDate]) }}" class="nrs-nav-btn">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>

                {{-- Day Labels --}}
                <div class="nrs-cal-days-label">
                    <div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div><div>Min</div>
                </div>

                {{-- Calendar Grid --}}
                <div class="nrs-cal-grid">
                    @php
                        $todayKey = now()->format('Y-m-d');
                        $selectedKey = $calendarDate->format('Y-m-d');
                    @endphp
                    @foreach($calendarGrid as $gridDate)
                        @php
                            $dateKey = $gridDate->format('Y-m-d');
                            $inMonth = $gridDate->format('Y-m') === $calendarMonth;
                            $opened = (int) ($calendarLessonsOpenedByDay[$dateKey] ?? 0);
                            $done = (int) ($calendarProgressDoneByDay[$dateKey] ?? 0);
                            $tests = (int) ($calendarTestsByDay[$dateKey] ?? 0);
                            $hasActivity = ($opened + $done + $tests) > 0;
                            $cellHref = route('dashboard', [
                                'calendar_course' => $calendarCourseId,
                                'calendar_month' => $gridDate->format('Y-m'),
                                'calendar_date' => $dateKey,
                            ]);
                        @endphp
                        <a href="{{ $cellHref }}"
                           class="nrs-cal-cell
                               {{ !$inMonth ? 'nrs-cal-out' : '' }}
                               {{ $dateKey === $selectedKey ? 'nrs-cal-selected' : '' }}
                               {{ $dateKey === $todayKey && $dateKey !== $selectedKey ? 'nrs-cal-today' : '' }}">
                            <span class="nrs-cal-num">{{ $gridDate->format('j') }}</span>
                            @if($hasActivity)
                                <div class="nrs-cal-dots">
                                    @if($opened > 0)<span class="nrs-dot nrs-dot-blue"></span>@endif
                                    @if($done > 0)<span class="nrs-dot nrs-dot-green"></span>@endif
                                    @if($tests > 0)<span class="nrs-dot nrs-dot-gold"></span>@endif
                                </div>
                            @endif
                        </a>
                    @endforeach
                </div>

                {{-- Legend --}}
                <div class="nrs-cal-legend">
                    <span class="nrs-legend-item"><span class="nrs-dot nrs-dot-blue"></span> Dibuka</span>
                    <span class="nrs-legend-item"><span class="nrs-dot nrs-dot-green"></span> Selesai</span>
                    <span class="nrs-legend-item"><span class="nrs-dot nrs-dot-gold"></span> Kuis</span>
                </div>

                {{-- Activity List --}}
                <div class="nrs-agenda-section">
                    <h3 class="nrs-agenda-title">
                        <span class="nrs-agenda-bar"></span>
                        Aktivitas — {{ $calendarDate->format('d M Y') }}
                    </h3>

                    @if(empty($calendarAgenda))
                        <div class="nrs-empty-state">
                            <div class="nrs-empty-icon"><i class="fas fa-seedling"></i></div>
                            <p class="nrs-empty-title">Belum ada aktivitas belajar</p>
                            <p class="nrs-empty-sub">Pilih tanggal lain atau mulai pelajaran baru hari ini!</p>
                        </div>
                    @else
                        <div class="nrs-agenda-grid">
                            @foreach(array_slice($calendarAgenda, 0, 6) as $item)
                                <a href="{{ $item['url'] }}" class="nrs-agenda-card">
                                    <div class="nrs-agenda-icon-wrap {{ $item['type'] === 'Materi Selesai' ? 'nrs-agenda-done' : ($item['type'] === 'Kuis' ? 'nrs-agenda-quiz' : 'nrs-agenda-open') }}">
                                        <i class="fas {{ $item['type'] === 'Materi Dibuka' ? 'fa-book-open' : ($item['type'] === 'Materi Selesai' ? 'fa-check-circle' : 'fa-vial') }}"></i>
                                    </div>
                                    <div class="nrs-agenda-info">
                                        <span class="nrs-agenda-type">{{ $item['type'] }}</span>
                                        <span class="nrs-agenda-name">{{ $item['title'] }}</span>
                                    </div>
                                    <div class="nrs-agenda-time">
                                        <span>{{ \Illuminate\Support\Carbon::parse($item['ts'])->timezone(config('app.timezone', 'Asia/Makassar'))->format('H:i') }}</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </section>

        {{-- ─── Recent Courses Panel ────────────────────────────────── --}}
        <section class="nrs-panel">

            <div class="nrs-panel-head">
                <div class="nrs-panel-title-group">
                    <div class="nrs-panel-tag">
                        <span class="nrs-tag-dot nrs-tag-dot-gold"></span>
                        MODUL AKTIF
                    </div>
                    <h2 class="nrs-panel-title">Pembelajaran <span class="nrs-panel-title-em">Terbaru</span></h2>
                </div>
                <a href="{{ route('courses.index') }}" class="nrs-link-btn">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="nrs-panel-body">
                <div class="nrs-courses-grid">
                    @foreach($recent_courses as $course)
                        @php
                            $lessonIds = $course->lessons()->pluck('id');
                            $lessonTotal = $lessonIds->count();
                            $lessonCompleted = $lessonTotal > 0
                                ? \App\Models\UserProgress::where('user_id', Auth::id())->whereIn('lesson_id', $lessonIds)->where('is_completed', true)->count()
                                : 0;
                            $progressPercent = $lessonTotal > 0 ? (int) round(($lessonCompleted / $lessonTotal) * 100) : 0;
                            $progressPercent = max(0, min(100, $progressPercent));
                        @endphp

                        <div class="nrs-course-card">

                            {{-- Thumbnail --}}
                            <div class="nrs-course-thumb">
                                <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=2070&auto=format&fit=crop' }}"
                                     class="nrs-course-img" alt="{{ $course->title }}">
                                <div class="nrs-course-thumb-overlay"></div>

                                {{-- Badges --}}
                                <div class="nrs-course-badges">
                                    @if($course->type)
                                    <span class="nrs-badge-type
                                        @if($course->type->color == 'green') nrs-type-green
                                        @elseif($course->type->color == 'emerald') nrs-type-emerald
                                        @elseif($course->type->color == 'teal') nrs-type-teal
                                        @elseif($course->type->color == 'lime') nrs-type-lime
                                        @elseif($course->type->color == 'orange') nrs-type-orange
                                        @elseif($course->type->color == 'red') nrs-type-red
                                        @elseif($course->type->color == 'yellow') nrs-type-yellow
                                        @elseif($course->type->color == 'blue') nrs-type-blue
                                        @elseif($course->type->color == 'purple') nrs-type-purple
                                        @else nrs-type-gray
                                        @endif">
                                        {{ $course->type->name }}
                                    </span>
                                    @endif
                                    @if($course->label)
                                    <span class="nrs-badge-label">{{ $course->label }}</span>
                                    @endif
                                </div>

                                {{-- Progress Ring overlay --}}
                                <div class="nrs-thumb-progress">
                                    <svg viewBox="0 0 36 36" class="nrs-progress-ring">
                                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="2.5"/>
                                        <circle cx="18" cy="18" r="15.9" fill="none" stroke="#4ADE80" stroke-width="2.5"
                                            stroke-dasharray="{{ $progressPercent }} {{ 100 - $progressPercent }}"
                                            stroke-dashoffset="25"
                                            stroke-linecap="round"/>
                                    </svg>
                                    <span class="nrs-ring-pct">{{ $progressPercent }}%</span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="nrs-course-body">
                                <div class="nrs-course-meta">
                                    <i class="fas fa-school"></i>
                                    <span>{{ $course->school->name ?? 'Semua Sekolah' }}</span>
                                </div>
                                <h3 class="nrs-course-title">{{ $course->title }}</h3>

                                {{-- Progress Bar --}}
                                <div class="nrs-progress-wrap">
                                    <div class="nrs-progress-labels">
                                        <span>Progres Belajar</span>
                                        <span class="nrs-progress-pct">{{ $progressPercent }}%</span>
                                    </div>
                                    <div class="nrs-progress-track">
                                        <div class="nrs-progress-fill {{ $progressPercent >= 100 ? 'nrs-fill-done' : '' }}"
                                             @style(['width' => $progressPercent . '%'])></div>
                                    </div>
                                    <div class="nrs-progress-lessons">
                                        {{ $lessonCompleted }} / {{ $lessonTotal }} materi selesai
                                    </div>
                                </div>

                                {{-- CTA --}}
                                <a href="{{ route('courses.detail', $course->id) }}" class="nrs-btn-primary">
                                    @if($progressPercent >= 100)
                                        <i class="fas fa-redo"></i> Ulangi Kursus
                                    @elseif($progressPercent > 0)
                                        <i class="fas fa-play"></i> Lanjutkan Belajar
                                    @else
                                        <i class="fas fa-rocket"></i> Mulai Sekarang
                                    @endif
                                </a>
                            </div>
                        </div>

                    @endforeach
                </div>
            </div>
        </section>

    </div>{{-- end nrs-body --}}

</div>{{-- end nrs-root --}}


{{-- ═══════════════════════════════════════════════════════════════
     STYLES
═══════════════════════════════════════════════════════════════ --}}
<style>
:root {
    --nrs-green:      #0D5C34;
    --nrs-green-mid:  #187945;
    --nrs-green-lt:   #1E9152;
    --nrs-green-vlt:  #4ADE80;
    --nrs-teal:       #0E7490;
    --nrs-teal-lt:    #22D3EE;
    --nrs-gold:       #C9A84C;
    --nrs-gold-lt:    #F6D860;
    --nrs-ink:        #0F1A12;
    --nrs-muted:      #6B7280;
    --nrs-border:     #E5E7EB;
    --nrs-surface:    #F7FAF8;
    --nrs-white:      #FFFFFF;
    --nrs-font-display: var(--font-heading, var(--font-sans, ui-sans-serif, system-ui, sans-serif));
    --nrs-font-body:    var(--font-sans, ui-sans-serif, system-ui, sans-serif);
    --nrs-font-mono:    var(--font-mono, ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace);
    --nrs-shadow-sm:  0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.04);
    --nrs-shadow:     0 4px 16px rgba(13,92,52,0.07), 0 2px 6px rgba(0,0,0,0.04);
    --nrs-shadow-lg:  0 20px 60px rgba(13,92,52,0.10), 0 8px 24px rgba(0,0,0,0.05);
}

/* ── Root ───────────────────────────────────────── */
.nrs-root {
    font-family: var(--nrs-font-body);
    color: var(--nrs-ink);
    display: flex;
    flex-direction: column;
    gap: 0;
    padding-bottom: 5rem;
}

/* ── KPI Strip ──────────────────────────────────── */
.nrs-kpi-strip {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    background: var(--nrs-green);
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    margin-bottom: 2rem;
    box-shadow: 0 8px 40px rgba(13,92,52,0.25);
}
.nrs-kpi-strip::before {
    content: '';
    position: absolute;
    inset: 0;
    background: repeating-linear-gradient(
        90deg,
        transparent,
        transparent 60px,
        rgba(255,255,255,0.025) 60px,
        rgba(255,255,255,0.025) 61px
    );
    pointer-events: none;
}
@media (min-width: 640px) { .nrs-kpi-strip { grid-template-columns: repeat(3, 1fr); } }

.nrs-kpi-card {
    position: relative;
    padding: 1.5rem 1.75rem;
    border-right: 1px solid rgba(255,255,255,0.08);
    border-bottom: 1px solid rgba(255,255,255,0.06);
    text-decoration: none;
    overflow: hidden;
    transition: background 0.25s ease;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    cursor: default;
}
.nrs-kpi-card:last-child { border-right: none; }

.nrs-kpi-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 80% 50%, rgba(255,255,255,0.04), transparent 60%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}
.nrs-kpi-card:hover::after { opacity: 1; }

.nrs-kpi-accent-line {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 2px;
    background: var(--accent);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.35s ease;
}
.nrs-kpi-card:hover .nrs-kpi-accent-line { transform: scaleX(1); }

.nrs-kpi-index {
    font-family: var(--nrs-font-mono);
    font-size: 0.6rem;
    font-weight: 600;
    color: rgba(255,255,255,0.2);
    letter-spacing: 0.1em;
}
.nrs-kpi-body {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.nrs-kpi-icon {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 10px;
    font-size: 1rem;
    color: var(--accent);
    flex-shrink: 0;
    transition: all 0.3s ease;
}
.nrs-kpi-card:hover .nrs-kpi-icon {
    background: rgba(255,255,255,0.16);
    border-color: rgba(255,255,255,0.22);
    color: rgba(255,255,255,0.95);
    box-shadow: 0 10px 26px rgba(0,0,0,0.16);
    transform: translateY(-1px);
}
.nrs-kpi-info { display: flex; flex-direction: column; gap: 0.1rem; }
.nrs-kpi-label {
    font-size: 0.6rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    color: rgba(255,255,255,0.45);
    text-transform: uppercase;
}
.nrs-kpi-value {
    font-family: var(--nrs-font-mono);
    font-size: 1.9rem;
    font-weight: 600;
    color: var(--nrs-white);
    line-height: 1;
}
.nrs-kpi-unit {
    font-size: 0.55rem;
    color: rgba(255,255,255,0.25);
    text-transform: uppercase;
    letter-spacing: 0.12em;
}
.nrs-kpi-arrow {
    position: absolute;
    top: 1.25rem;
    right: 1.25rem;
    font-size: 0.7rem;
    color: rgba(255,255,255,0.12);
    transition: all 0.3s ease;
}
.nrs-kpi-card:hover .nrs-kpi-arrow {
    color: var(--accent);
    transform: translate(2px, -2px);
}

/* ── Body ───────────────────────────────────────── */
.nrs-body {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* ── Panel ──────────────────────────────────────── */
.nrs-panel {
    background: var(--nrs-white);
    border: 1px solid var(--nrs-border);
    border-radius: 16px;
    overflow: hidden;
    box-shadow: var(--nrs-shadow);
    transition: box-shadow 0.3s ease;
}
.nrs-panel:hover { box-shadow: var(--nrs-shadow-lg); }

.nrs-panel-head {
    padding: 1.25rem 1.75rem;
    border-bottom: 1px solid var(--nrs-border);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    background: var(--nrs-surface);
    flex-wrap: wrap;
}
.nrs-panel-title-group { display: flex; flex-direction: column; gap: 0.2rem; }

.nrs-panel-tag {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    color: var(--nrs-green-mid);
    text-transform: uppercase;
}
.nrs-tag-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--nrs-green-lt);
    box-shadow: 0 0 6px rgba(30,145,82,0.6);
    animation: nrs-pulse 2s infinite;
}
.nrs-tag-dot-gold {
    background: var(--nrs-gold);
    box-shadow: 0 0 6px rgba(201,168,76,0.6);
}
@keyframes nrs-pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.nrs-panel-title {
    font-family: var(--nrs-font-display);
    font-size: 1.2rem;
    font-weight: 700;
    color: var(--nrs-ink);
    line-height: 1.2;
}
.nrs-panel-title-em { color: var(--nrs-green-lt); }

.nrs-panel-head-right {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex-wrap: wrap;
}
.nrs-date-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.35rem 0.85rem;
    background: var(--nrs-white);
    border: 1px solid var(--nrs-border);
    border-radius: 8px;
    font-size: 0.68rem;
    font-weight: 600;
    color: var(--nrs-muted);
}
.nrs-date-badge .fas { font-size: 0.6rem; color: var(--nrs-green-lt); }

.nrs-activity-chip {
    display: inline-flex;
    align-items: center;
    padding: 0.3rem 0.85rem;
    border-radius: 100px;
    font-size: 0.62rem;
    font-weight: 700;
    letter-spacing: 0.05em;
}
.nrs-chip-active {
    background: rgba(30,145,82,0.1);
    color: var(--nrs-green-lt);
    border: 1px solid rgba(30,145,82,0.2);
}
.nrs-chip-empty {
    background: rgba(107,114,128,0.07);
    color: var(--nrs-muted);
    border: 1px solid var(--nrs-border);
}

.nrs-panel-body { padding: 1.1rem 1.25rem; }

.nrs-link-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.45rem 1rem;
    background: rgba(13,92,52,0.06);
    border: 1px solid rgba(13,92,52,0.15);
    border-radius: 8px;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--nrs-green-mid);
    text-decoration: none;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.nrs-link-btn:hover {
    background: var(--nrs-green);
    color: white;
    border-color: var(--nrs-green);
}

/* ── Month Navigator ─────────────────────────────── */
.nrs-month-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}
.nrs-month-left {
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
.nrs-month-badge {
    width: 40px;
    height: 40px;
    background: var(--nrs-green);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(13,92,52,0.25);
}
.nrs-month-num {
    font-family: var(--nrs-font-mono);
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--nrs-gold-lt);
}
.nrs-month-eyebrow {
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    color: var(--nrs-muted);
    margin-bottom: 0.15rem;
}
.nrs-month-name {
    font-family: var(--nrs-font-display);
    font-size: 0.9rem;
    font-weight: 700;
    color: var(--nrs-ink);
}
.nrs-month-nav-btns { display: flex; gap: 0.4rem; }
.nrs-nav-btn {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    border: 1px solid var(--nrs-border);
    background: var(--nrs-white);
    color: var(--nrs-muted);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.65rem;
    text-decoration: none;
    transition: all 0.2s ease;
}
.nrs-nav-btn:hover {
    background: var(--nrs-green);
    color: white;
    border-color: var(--nrs-green);
    transform: scale(1.05);
}

/* ── Calendar Grid ───────────────────────────────── */
.nrs-cal-days-label {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 0.25rem;
    margin-bottom: 0.45rem;
    text-align: center;
}
.nrs-cal-days-label > div {
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: var(--nrs-muted);
    padding: 0.2rem 0;
}

.nrs-cal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 0.25rem;
    margin-bottom: 0.75rem;
}
.nrs-cal-cell {
    position: relative;
    height: clamp(38px, 5.2vw, 52px);
    border-radius: 10px;
    border: 1px solid var(--nrs-border);
    background: var(--nrs-white);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 2px;
    text-decoration: none;
    transition: all 0.2s ease;
    cursor: pointer;
}
.nrs-cal-cell:hover {
    border-color: var(--nrs-green-lt);
    box-shadow: 0 0 0 3px rgba(30,145,82,0.08);
    transform: translateY(-1px);
}
.nrs-cal-out { border-color: transparent; opacity: 0.25; pointer-events: none; }
.nrs-cal-selected {
    background: var(--nrs-green) !important;
    border-color: var(--nrs-green) !important;
    box-shadow: 0 4px 16px rgba(13,92,52,0.3) !important;
}
.nrs-cal-selected .nrs-cal-num { color: white !important; }
.nrs-cal-selected .nrs-dot { filter: brightness(1.5); }
.nrs-cal-today { border-color: var(--nrs-green-lt); border-width: 2px; }
.nrs-cal-today .nrs-cal-num { color: var(--nrs-green-mid); font-weight: 700; }

.nrs-cal-num {
    font-family: var(--nrs-font-mono);
    font-size: 0.74rem;
    font-weight: 600;
    color: var(--nrs-ink);
    line-height: 1;
}

.nrs-cal-dots { display: flex; gap: 2px; align-items: center; }
.nrs-dot {
    width: 3px;
    height: 3px;
    border-radius: 50%;
}
.nrs-dot-blue  { background: #60A5FA; }
.nrs-dot-green { background: var(--nrs-green-vlt); }
.nrs-dot-gold  { background: var(--nrs-gold); }

/* Legend */
.nrs-cal-legend {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}
.nrs-legend-item {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.62rem;
    font-weight: 600;
    color: var(--nrs-muted);
}
.nrs-legend-item .nrs-dot { width: 6px; height: 6px; }

/* ── Agenda ──────────────────────────────────────── */
.nrs-agenda-section { margin-top: 0.5rem; }
.nrs-agenda-title {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-family: var(--nrs-font-display);
    font-size: 0.88rem;
    font-weight: 700;
    color: var(--nrs-ink);
    margin-bottom: 0.75rem;
}
.nrs-agenda-bar {
    width: 3px;
    height: 16px;
    background: var(--nrs-green-lt);
    border-radius: 2px;
}

.nrs-empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 1.5rem 1rem;
    text-align: center;
    border: 1px dashed var(--nrs-border);
    border-radius: 12px;
    background: var(--nrs-surface);
}
.nrs-empty-icon {
    width: 52px;
    height: 52px;
    background: rgba(30,145,82,0.08);
    border: 1px solid rgba(30,145,82,0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--nrs-green-lt);
}
.nrs-empty-title {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--nrs-ink);
}
.nrs-empty-sub {
    font-size: 0.7rem;
    color: var(--nrs-muted);
}

.nrs-agenda-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.45rem;
}
@media (min-width: 640px) { .nrs-agenda-grid { grid-template-columns: repeat(2, 1fr); } }

.nrs-agenda-card {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.65rem 0.75rem;
    border: 1px solid var(--nrs-border);
    border-radius: 12px;
    text-decoration: none;
    background: var(--nrs-white);
    transition: all 0.2s ease;
}
.nrs-agenda-card:hover {
    border-color: var(--nrs-green-lt);
    box-shadow: var(--nrs-shadow);
    transform: translateY(-1px);
}
.nrs-agenda-card:hover .nrs-agenda-name { color: var(--nrs-green-mid); }

.nrs-agenda-icon-wrap {
    width: 32px;
    height: 32px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.78rem;
    flex-shrink: 0;
    transition: all 0.2s ease;
}
.nrs-agenda-open  { background: rgba(96,165,250,0.1); color: #3B82F6; border: 1px solid rgba(96,165,250,0.2); }
.nrs-agenda-done  { background: rgba(74,222,128,0.1); color: var(--nrs-green-lt); border: 1px solid rgba(74,222,128,0.2); }
.nrs-agenda-quiz  { background: rgba(201,168,76,0.1); color: var(--nrs-gold); border: 1px solid rgba(201,168,76,0.2); }

.nrs-agenda-card:hover .nrs-agenda-icon-wrap {
    background: var(--nrs-green);
    color: white;
    border-color: var(--nrs-green);
}
.nrs-agenda-info {
    display: flex;
    flex-direction: column;
    gap: 0.1rem;
    flex: 1;
    min-width: 0;
}
.nrs-agenda-type {
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    color: var(--nrs-muted);
}
.nrs-agenda-name {
    font-size: 0.76rem;
    font-weight: 600;
    color: var(--nrs-ink);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color 0.2s ease;
}
.nrs-agenda-time {
    display: flex;
    flex-direction: row;
    align-items: flex-end;
    gap: 0.45rem;
    flex-shrink: 0;
}
.nrs-agenda-time span {
    font-family: var(--nrs-font-mono);
    font-size: 0.62rem;
    font-weight: 600;
    color: var(--nrs-muted);
}
.nrs-agenda-time .fas {
    font-size: 0.55rem;
    color: #D1D5DB;
    transition: color 0.2s ease;
}
.nrs-agenda-card:hover .nrs-agenda-time .fas { color: var(--nrs-green-lt); }

/* ── Courses Grid ────────────────────────────────── */
.nrs-courses-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.25rem;
}
@media (min-width: 640px)  { .nrs-courses-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .nrs-courses-grid { grid-template-columns: repeat(3, 1fr); } }

.nrs-course-card {
    border: 1px solid var(--nrs-border);
    border-radius: 14px;
    overflow: hidden;
    background: var(--nrs-white);
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    box-shadow: var(--nrs-shadow-sm);
}
.nrs-course-card:hover {
    border-color: rgba(30,145,82,0.2);
    box-shadow: var(--nrs-shadow-lg);
    transform: translateY(-3px);
}

.nrs-course-thumb {
    position: relative;
    height: 180px;
    overflow: hidden;
    flex-shrink: 0;
}
.nrs-course-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}
.nrs-course-card:hover .nrs-course-img { transform: scale(1.06); }
.nrs-course-thumb-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.55) 0%, transparent 55%);
}
.nrs-course-badges {
    position: absolute;
    top: 0.85rem;
    left: 0.85rem;
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}

.nrs-badge-type {
    display: inline-block;
    padding: 0.25rem 0.7rem;
    border-radius: 100px;
    font-size: 0.55rem;
    font-weight: 800;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    backdrop-filter: blur(8px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.nrs-type-green   { background: rgba(34,197,94,0.85); color: white; }
.nrs-type-emerald { background: rgba(16,185,129,0.85); color: white; }
.nrs-type-teal    { background: rgba(20,184,166,0.85); color: white; }
.nrs-type-lime    { background: rgba(132,204,22,0.85); color: white; }
.nrs-type-orange  { background: rgba(249,115,22,0.85); color: white; }
.nrs-type-red     { background: rgba(239,68,68,0.85); color: white; }
.nrs-type-yellow  { background: rgba(234,179,8,0.85); color: #1a1a1a; }
.nrs-type-blue    { background: rgba(59,130,246,0.85); color: white; }
.nrs-type-purple  { background: rgba(168,85,247,0.85); color: white; }
.nrs-type-gray    { background: rgba(107,114,128,0.85); color: white; }

.nrs-badge-label {
    display: inline-block;
    padding: 0.2rem 0.6rem;
    border-radius: 100px;
    font-size: 0.5rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    background: rgba(255,255,255,0.18);
    color: white;
    border: 1px solid rgba(255,255,255,0.3);
    backdrop-filter: blur(6px);
    width: fit-content;
}

/* Progress Ring in thumbnail */
.nrs-thumb-progress {
    position: absolute;
    bottom: 0.75rem;
    right: 0.85rem;
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.nrs-progress-ring {
    position: absolute;
    inset: 0;
    transform: rotate(-90deg);
}
.nrs-ring-pct {
    position: relative;
    z-index: 1;
    font-family: var(--nrs-font-mono);
    font-size: 0.55rem;
    font-weight: 700;
    color: white;
    text-shadow: 0 1px 4px rgba(0,0,0,0.4);
}

/* Course Card Body */
.nrs-course-body {
    padding: 1.1rem 1.25rem 1.25rem;
    display: flex;
    flex-direction: column;
    flex: 1;
    gap: 0.6rem;
}
.nrs-course-meta {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.65rem;
    font-weight: 600;
    color: var(--nrs-muted);
}
.nrs-course-meta .fas { font-size: 0.55rem; color: var(--nrs-green-lt); }
.nrs-course-title {
    font-family: var(--nrs-font-display);
    font-size: 1rem;
    font-weight: 700;
    color: var(--nrs-ink);
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 2.6em;
}
.nrs-course-card:hover .nrs-course-title { color: var(--nrs-green-mid); }

/* Progress */
.nrs-progress-wrap {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
    margin-top: 0.25rem;
}
.nrs-progress-labels {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    color: var(--nrs-muted);
}
.nrs-progress-pct { color: var(--nrs-green-mid); }
.nrs-progress-track {
    height: 5px;
    background: rgba(13,92,52,0.08);
    border-radius: 100px;
    overflow: hidden;
}
.nrs-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--nrs-green-lt), var(--nrs-green-vlt));
    border-radius: 100px;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}
.nrs-fill-done {
    background: linear-gradient(90deg, var(--nrs-gold), var(--nrs-gold-lt));
}
.nrs-progress-lessons {
    font-size: 0.58rem;
    color: var(--nrs-muted);
    font-weight: 500;
}

.nrs-btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.7rem 1.25rem;
    background: var(--nrs-green);
    color: white;
    border: none;
    border-radius: 10px;
    font-family: var(--nrs-font-body);
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 4px 14px rgba(13,92,52,0.25);
    margin-top: auto;
    width: 100%;
    position: relative;
    overflow: hidden;
}
.nrs-btn-primary::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.12), transparent);
    transform: translateX(-100%);
    transition: transform 0.4s ease;
}
.nrs-btn-primary:hover::after { transform: translateX(100%); }
.nrs-btn-primary:hover {
    background: var(--nrs-green-mid);
    box-shadow: 0 6px 20px rgba(13,92,52,0.35);
    transform: translateY(-1px);
}
.nrs-btn-primary .fas { font-size: 0.75rem; }

/* ── Entry Animations ────────────────────────────── */
@keyframes nrs-fade-up {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: translateY(0); }
}
.nrs-kpi-strip { animation: nrs-fade-up 0.55s 0.1s ease both; }
.nrs-body > *:nth-child(1) { animation: nrs-fade-up 0.55s 0.2s ease both; }
.nrs-body > *:nth-child(2) { animation: nrs-fade-up 0.55s 0.32s ease both; }

/* ── Mobile ──────────────────────────────────────── */
@media (max-width: 639px) {
    .nrs-panel-body { padding: 1.1rem 1.1rem; }
    .nrs-panel-head { padding: 1rem 1.1rem; }
    .nrs-kpi-strip {
        grid-template-columns: repeat(3, minmax(0, 1fr));
        background: transparent;
        box-shadow: none;
        border-radius: 0;
        overflow: visible;
        gap: 0.6rem;
        margin-bottom: 1.25rem;
        padding: 0 0.25rem;
    }
    .nrs-kpi-strip::before { display: none; }

    .nrs-kpi-card {
        padding: 0.85rem 0.85rem;
        border: 1px solid rgba(13,92,52,0.10);
        border-radius: 16px;
        background: linear-gradient(155deg, #0D5C34 0%, #187945 52%, #0B4A2B 100%);
        box-shadow: 0 12px 32px rgba(13,92,52,0.18);
    }
    .nrs-kpi-card::after { opacity: 1; }
    .nrs-kpi-card:last-child { border-right: 1px solid rgba(13,92,52,0.10); }

    .nrs-kpi-index { font-size: 0.55rem; color: rgba(255,255,255,0.28); }
    .nrs-kpi-body { gap: 0.55rem; flex-direction: column; align-items: flex-start; }
    .nrs-kpi-icon {
        width: 34px;
        height: 34px;
        border-radius: 12px;
        background: rgba(255,255,255,0.12);
        border-color: rgba(255,255,255,0.16);
        color: rgba(255,255,255,0.92);
        font-size: 0.85rem;
    }
    .nrs-kpi-arrow { display: none; }
    .nrs-kpi-value { font-size: 1.25rem; }
    .nrs-kpi-label { font-size: 0.52rem; letter-spacing: 0.1em; }
    .nrs-kpi-unit { font-size: 0.5rem; letter-spacing: 0.1em; }
    .nrs-month-nav { margin-bottom: 1rem; }
    .nr-student main.nr-main { padding-bottom: 8rem; }
}
</style>

@endsection
