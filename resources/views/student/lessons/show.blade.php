@extends('layouts.app')

@section('content')
@php
    $lessonTotalCount = $lesson->course->lessons->count();
    $lessonPct = $lessonTotalCount > 0 ? ($lesson->order_number / $lessonTotalCount) * 100 : 0;
    $lessonPct = max(0, min(100, $lessonPct));
@endphp

<div class="nrl-lesson-page min-h-screen -mx-4 sm:-mx-6 lg:-mx-8 -mt-6 sm:-mt-10 bg-bg-main">
    <div class="relative overflow-hidden pt-5 sm:pt-14 pb-5 sm:pb-10 px-4 sm:px-6 lg:px-8">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl opacity-60 hidden sm:block"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-secondary/5 rounded-full blur-3xl opacity-60 hidden sm:block"></div>

        <div class="relative max-w-5xl mx-auto">
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('courses.detail', $lesson->course_id) }}" class="inline-flex items-center gap-2.5 font-bold text-[11px] sm:text-xs uppercase tracking-widest text-primary hover:text-primary-light transition-colors">
                    <span class="w-9 h-9 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-white border border-border-subtle shadow-sm flex items-center justify-center">
                        <i class="fas fa-arrow-left text-xs sm:text-sm"></i>
                    </span>
                    <span class="hidden xs:inline sm:inline">Kembali</span>
                </a>

                <div class="flex items-center gap-3 min-w-0">
                    <div class="flex items-center gap-1.5 text-[10px] font-bold text-text-muted uppercase tracking-widest shrink-0">
                        <span>Bab {{ $lesson->order_number }}</span>
                        <span class="opacity-40">/</span>
                        <span>{{ $lessonTotalCount }}</span>
                    </div>
                    <div class="w-24 sm:w-56 h-1.5 sm:h-2 rounded-full bg-white border border-border-subtle overflow-hidden">
                        <div class="h-full bg-primary transition-all duration-700" @style(['width' => $lessonPct . '%'])></div>
                    </div>
                </div>
            </div>

            <div class="mt-4 sm:mt-8">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 sm:px-4 sm:py-2 rounded-xl sm:rounded-2xl bg-white border border-border-subtle shadow-sm text-[9px] sm:text-[10px] font-black uppercase tracking-widest text-text-secondary">
                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-primary"></span>
                    Materi Pembelajaran
                </div>
                <h1 class="mt-2.5 sm:mt-4 text-[1.35rem] sm:text-5xl font-extrabold tracking-tight leading-snug text-text-main">
                    {{ $lesson->title }}
                </h1>
                <div class="mt-2.5 sm:mt-3 flex flex-wrap items-center gap-2 sm:gap-3 text-[10px] sm:text-xs font-bold text-text-muted">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-xl sm:rounded-2xl bg-white border border-border-subtle">
                        <i class="fas fa-calendar-alt text-primary text-[10px]"></i>
                        {{ $lesson->updated_at?->format('d M Y') }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 sm:px-3 sm:py-2 rounded-xl sm:rounded-2xl bg-white border border-border-subtle max-w-full truncate">
                        <i class="fas fa-book text-primary text-[10px]"></i>
                        <span class="truncate">{{ $lesson->course->title }}</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-2 sm:px-6 lg:px-8 pb-28 sm:pb-24">
        <div class="card-premium overflow-hidden nrl-lesson-card">
            <div class="aspect-video bg-black relative overflow-hidden">
                @if($lesson->video_url)
                    @php
                        $videoUrl = trim((string) $lesson->video_url);
                        $embedUrl = null;
                        $videoId = null;
                        $params = [
                            'rel' => '0',
                            'modestbranding' => '1',
                            'playsinline' => '1',
                        ];

                        $toSeconds = function ($t) {
                            $t = trim((string) $t);
                            if ($t === '') return null;
                            if (ctype_digit($t)) return (int) $t;
                            if (preg_match('/^(?:(\d+)h)?(?:(\d+)m)?(?:(\d+)s)?$/i', $t, $m)) {
                                $h = isset($m[1]) && $m[1] !== '' ? (int) $m[1] : 0;
                                $min = isset($m[2]) && $m[2] !== '' ? (int) $m[2] : 0;
                                $s = isset($m[3]) && $m[3] !== '' ? (int) $m[3] : 0;
                                $total = ($h * 3600) + ($min * 60) + $s;
                                return $total > 0 ? $total : null;
                            }
                            return null;
                        };

                        $parts = @parse_url($videoUrl) ?: [];
                        $host = strtolower($parts['host'] ?? '');
                        $path = (string) ($parts['path'] ?? '');
                        $query = (string) ($parts['query'] ?? '');
                        $q = [];
                        parse_str($query, $q);

                        if ($host !== '' && str_contains($host, 'youtu.be')) {
                            $videoId = trim($path, '/');
                        } elseif ($host !== '' && (str_contains($host, 'youtube.com') || str_contains($host, 'youtube-nocookie.com'))) {
                            if (preg_match('#^/embed/([^/?]+)#', $path, $m)) {
                                $videoId = $m[1];
                            } elseif (preg_match('#^/shorts/([^/?]+)#', $path, $m)) {
                                $videoId = $m[1];
                            } elseif (preg_match('#^/live/([^/?]+)#', $path, $m)) {
                                $videoId = $m[1];
                            } elseif ($path === '/watch') {
                                $videoId = $q['v'] ?? null;
                            }

                            if (!empty($q['list'])) {
                                $params['list'] = $q['list'];
                            }
                            $start = $q['start'] ?? null;
                            $t = $q['t'] ?? null;
                            $sec = $toSeconds($start) ?? $toSeconds($t);
                            if ($sec !== null) {
                                $params['start'] = (string) $sec;
                            }
                        }

                        if (is_string($videoId)) {
                            $videoId = trim($videoId);
                            if ($videoId !== '') {
                                $embedUrl = 'https://www.youtube-nocookie.com/embed/'.$videoId;
                                if (count($params) > 0) {
                                    $embedUrl .= '?'.http_build_query($params);
                                }
                            }
                        }
                    @endphp

                    @if($embedUrl)
                        <iframe
                            class="w-full h-full"
                            src="{{ $embedUrl }}"
                            title="{{ $lesson->title }}"
                            frameborder="0"
                            loading="lazy"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen
                        ></iframe>
                    @else
                        <div class="absolute inset-0 flex items-center justify-center text-white text-sm font-bold px-6 text-center">
                            Link video tidak valid untuk diputar. Pastikan link YouTube benar (contoh: https://youtu.be/xxxx atau https://www.youtube.com/watch?v=xxxx).
                        </div>
                    @endif
                @else
                    <img src="{{ $lesson->course->thumbnail ? asset('storage/' . $lesson->course->thumbnail) : route('brand.hero') }}"
                         class="w-full h-full object-cover" alt="{{ $lesson->title }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
                    <div class="absolute top-6 left-6">
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/90 backdrop-blur border border-white/60 shadow-lg text-[10px] font-black uppercase tracking-widest text-gray-900">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Bab {{ $lesson->order_number }}
                        </span>
                    </div>
                    <div class="absolute bottom-6 left-6 right-6 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3">
                        <div class="text-white">
                            <div class="text-[10px] font-black uppercase tracking-widest opacity-70">Materi</div>
                            <div class="mt-1 text-lg sm:text-2xl font-extrabold tracking-tight leading-tight">
                                {{ $lesson->title }}
                            </div>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-2 px-3 py-2 rounded-2xl bg-white/10 border border-white/20 backdrop-blur text-[10px] font-black uppercase tracking-widest text-white">
                                <i class="fas fa-layer-group text-[10px]"></i>
                                {{ $lesson->course->lessons->count() }} Bab
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="nrl-lesson-body px-3 py-4 sm:p-10 lg:p-12">
                @php
                    $lessonContent = $lesson->content ?? '';
                    $hasHtml = \Illuminate\Support\Str::contains($lessonContent, ['<img', '<p', '<br', '<div', '<h', '<ul', '<ol', '<table']);
                @endphp
                <div class="nrl-lesson-content" id="nrlLessonContent">
                    {!! $hasHtml ? $lessonContent : nl2br(e($lessonContent)) !!}
                </div>

                <div class="mt-8 sm:mt-10 pt-6 sm:pt-8 border-t border-border-soft flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4 sm:gap-6">
                    <div class="flex items-center gap-3 p-3.5 sm:p-5 rounded-2xl bg-primary-soft/40 border border-border-subtle w-full sm:w-auto">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-primary flex items-center justify-center text-white shadow-sm shrink-0">
                            <i class="fas fa-lightbulb text-sm sm:text-base"></i>
                        </div>
                        <p class="text-xs sm:text-sm font-bold text-text-main leading-snug">Pastikan kamu sudah membaca seluruh materi dengan teliti.</p>
                    </div>

                    @if(!$is_completed)
                    <form action="{{ route('lessons.complete', $lesson->id) }}" method="POST" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="btn-primary w-full py-3.5 sm:py-4 px-8 sm:px-10 text-xs sm:text-sm uppercase tracking-widest font-extrabold flex items-center justify-center gap-3">
                            Tandai Selesai <i class="fas fa-check-circle text-xs"></i>
                        </button>
                    </form>
                    @else
                    <div class="flex items-center gap-3 px-6 sm:px-8 py-3.5 sm:py-4 bg-green-50 text-green-700 font-extrabold rounded-2xl border border-green-100 shadow-inner w-full sm:w-auto justify-center">
                        <i class="fas fa-check-double text-base sm:text-lg"></i>
                        <span class="uppercase tracking-widest text-[11px] sm:text-xs">Materi Selesai</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.nrl-lesson-page {
    --nrl-ink: #1e293b;
    --nrl-muted: #64748b;
    --nrl-line: #e2e8f0;
    --nrl-soft: #f8fafc;
    --nrl-accent: #0f7e6e;
}

.nrl-lesson-card {
    border-radius: 18px;
}
@media (max-width: 639px) {
    .nrl-lesson-card {
        border-radius: 14px;
        box-shadow: 0 8px 28px rgba(15, 23, 42, 0.06);
    }
}

.nrl-lesson-content {
    color: var(--nrl-muted);
    font-size: 0.9375rem;
    line-height: 1.7;
    font-weight: 500;
    letter-spacing: -0.01em;
    overflow-wrap: anywhere;
    word-break: break-word;
}
@media (min-width: 640px) {
    .nrl-lesson-content {
        font-size: 1rem;
        line-height: 1.75;
    }
}

/* Neutralize TinyMCE inline sizing / indent so mobile stays left-aligned */
.nrl-lesson-content,
.nrl-lesson-content * {
    max-width: 100%;
}
.nrl-lesson-content [style*="font-size"] {
    font-size: inherit !important;
}
.nrl-lesson-content [style*="line-height"] {
    line-height: inherit !important;
}
@media (max-width: 639px) {
    .nrl-lesson-content p,
    .nrl-lesson-content div,
    .nrl-lesson-content h1,
    .nrl-lesson-content h2,
    .nrl-lesson-content h3,
    .nrl-lesson-content h4,
    .nrl-lesson-content li,
    .nrl-lesson-content span {
        margin-left: 0 !important;
        text-indent: 0 !important;
        text-align: left !important;
    }
    .nrl-lesson-content [style*="padding-left"],
    .nrl-lesson-content [style*="margin-left"],
    .nrl-lesson-content [style*="text-indent"] {
        padding-left: 0 !important;
        margin-left: 0 !important;
        text-indent: 0 !important;
    }
    .nrl-lesson-content ul,
    .nrl-lesson-content ol {
        padding-left: 1.05rem !important;
        margin-left: 0 !important;
    }
    .nrl-lesson-content ul ul,
    .nrl-lesson-content ol ol,
    .nrl-lesson-content ul ol,
    .nrl-lesson-content ol ul {
        padding-left: 0.85rem !important;
    }
}

.nrl-lesson-content > *:first-child { margin-top: 0 !important; }
.nrl-lesson-content > *:last-child { margin-bottom: 0 !important; }

.nrl-lesson-content p {
    margin: 0 0 0.85rem;
    color: var(--nrl-muted);
}
.nrl-lesson-content br {
    display: block;
    content: "";
    margin-top: 0.55rem;
}

.nrl-lesson-content h1,
.nrl-lesson-content h2,
.nrl-lesson-content h3,
.nrl-lesson-content h4,
.nrl-lesson-content strong:has(+ br),
.nrl-lesson-content p > strong:only-child {
    color: var(--nrl-ink);
}

.nrl-lesson-content h1 {
    font-size: 1.15rem;
    line-height: 1.35;
    font-weight: 800;
    margin: 1.25rem 0 0.65rem;
    letter-spacing: -0.02em;
}
.nrl-lesson-content h2 {
    font-size: 1.05rem;
    line-height: 1.35;
    font-weight: 800;
    margin: 1.15rem 0 0.55rem;
}
.nrl-lesson-content h3,
.nrl-lesson-content h4 {
    font-size: 0.98rem;
    line-height: 1.4;
    font-weight: 700;
    margin: 1rem 0 0.45rem;
}
@media (min-width: 640px) {
    .nrl-lesson-content h1 { font-size: 1.4rem; }
    .nrl-lesson-content h2 { font-size: 1.2rem; }
    .nrl-lesson-content h3 { font-size: 1.05rem; }
}

.nrl-lesson-content img {
    display: block;
    max-width: 100%;
    height: auto;
    border-radius: 14px;
    margin: 0.85rem 0 1.1rem;
}
.nrl-lesson-content figure {
    margin: 0.85rem 0 1.1rem;
}
.nrl-lesson-content figcaption {
    margin-top: 0.4rem;
    font-size: 0.75rem;
    color: #94a3b8;
    text-align: center;
}

.nrl-lesson-content ul,
.nrl-lesson-content ol {
    padding-left: 1.05rem;
    margin: 0.45rem 0 0.85rem;
    list-style-position: outside;
}
.nrl-lesson-content ul { list-style: disc; }
.nrl-lesson-content ol { list-style: decimal; }
.nrl-lesson-content li {
    margin: 0.28rem 0;
    padding-left: 0.1rem;
}
.nrl-lesson-content li > p {
    margin: 0.2rem 0 0.45rem;
}
.nrl-lesson-content ul ul,
.nrl-lesson-content ol ol,
.nrl-lesson-content ul ol,
.nrl-lesson-content ol ul {
    padding-left: 0.9rem;
    margin: 0.25rem 0 0.45rem;
}
.nrl-lesson-content ul ul { list-style: circle; }
.nrl-lesson-content ol ol { list-style: lower-alpha; }
.nrl-lesson-content ol ol ol { list-style: lower-roman; }

.nrl-lesson-content a {
    color: var(--nrl-accent);
    text-decoration: underline;
    text-underline-offset: 2px;
}

.nrl-lesson-content blockquote {
    margin: 0.9rem 0;
    padding: 0.75rem 0.9rem;
    border-left: 3px solid var(--nrl-accent);
    background: var(--nrl-soft);
    border-radius: 0 12px 12px 0;
    color: var(--nrl-ink);
    font-size: 0.9rem;
}

/* Tables: scroll container + polished look */
.nrl-table-scroll {
    position: relative;
    margin: 0.85rem 0 1.15rem;
    border: 1px solid var(--nrl-line);
    border-radius: 14px;
    background: #fff;
    overflow: hidden;
}
.nrl-table-scroll::after {
    content: "Geser ← →";
    position: absolute;
    top: 0.45rem;
    right: 0.55rem;
    z-index: 2;
    padding: 0.2rem 0.45rem;
    border-radius: 999px;
    background: rgba(15, 23, 42, 0.72);
    color: #fff;
    font-size: 0.58rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.2s ease;
}
.nrl-table-scroll.is-scrollable::after { opacity: 1; }
@media (min-width: 640px) {
    .nrl-table-scroll::after { display: none; }
}

.nrl-table-scroll-inner {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    overscroll-behavior-x: contain;
    scrollbar-width: thin;
    scrollbar-color: #94a3b8 transparent;
}
.nrl-table-scroll-inner::-webkit-scrollbar {
    height: 6px;
}
.nrl-table-scroll-inner::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 999px;
}

.nrl-lesson-content table {
    width: max-content;
    min-width: 100%;
    max-width: none !important;
    border-collapse: separate;
    border-spacing: 0;
    margin: 0;
    font-size: 0.78rem;
    line-height: 1.45;
    color: var(--nrl-ink);
}
@media (min-width: 640px) {
    .nrl-lesson-content table { font-size: 0.875rem; }
}

.nrl-lesson-content table th,
.nrl-lesson-content table td {
    border: none;
    border-bottom: 1px solid var(--nrl-line);
    border-right: 1px solid var(--nrl-line);
    padding: 0.55rem 0.7rem;
    vertical-align: top;
    text-align: left;
    white-space: normal;
    min-width: 7.5rem;
}
.nrl-lesson-content table th:last-child,
.nrl-lesson-content table td:last-child {
    border-right: none;
}
.nrl-lesson-content table tr:last-child td {
    border-bottom: none;
}
.nrl-lesson-content table th {
    background: #f1f5f9;
    color: #0f172a;
    font-weight: 800;
    font-size: 0.72rem;
    letter-spacing: 0.02em;
    text-transform: none;
    position: sticky;
    top: 0;
    z-index: 1;
}
@media (min-width: 640px) {
    .nrl-lesson-content table th { font-size: 0.8rem; }
    .nrl-lesson-content table th,
    .nrl-lesson-content table td { padding: 0.7rem 0.85rem; }
}
.nrl-lesson-content table tbody tr:nth-child(even) td {
    background: #f8fafc;
}
.nrl-lesson-content table tbody tr:active td {
    background: #ecfeff;
}

.nrl-lesson-content iframe,
.nrl-lesson-content video {
    max-width: 100%;
    border-radius: 12px;
}
</style>

<script>
(function () {
    const root = document.getElementById('nrlLessonContent');
    if (!root) return;

    // Flatten excessive TinyMCE indents on mobile so text sits closer to the left
    const isMobile = window.matchMedia('(max-width: 639px)').matches;
    if (isMobile) {
        root.querySelectorAll('[style]').forEach((el) => {
            if (!el.style) return;
            el.style.marginLeft = '';
            el.style.paddingLeft = '';
            el.style.textIndent = '';
            if (el.style.textAlign === 'center' && !el.querySelector('img')) {
                el.style.textAlign = 'left';
            }
        });
        root.querySelectorAll('p, div, li, h1, h2, h3, h4').forEach((el) => {
            el.removeAttribute('data-mce-style');
        });
    }

    root.querySelectorAll('table').forEach((table) => {
        if (table.closest('.nrl-table-scroll')) return;

        table.removeAttribute('width');
        table.style.width = '';
        table.style.maxWidth = '';
        table.querySelectorAll('td, th, col').forEach((cell) => {
            cell.removeAttribute('width');
            if (cell.style) {
                cell.style.width = '';
                cell.style.minWidth = '';
            }
        });

        const wrap = document.createElement('div');
        wrap.className = 'nrl-table-scroll';
        const inner = document.createElement('div');
        inner.className = 'nrl-table-scroll-inner';

        table.parentNode.insertBefore(wrap, table);
        wrap.appendChild(inner);
        inner.appendChild(table);

        const markScrollable = () => {
            wrap.classList.toggle('is-scrollable', inner.scrollWidth > inner.clientWidth + 4);
        };
        markScrollable();
        window.addEventListener('resize', markScrollable, { passive: true });
        if (window.ResizeObserver) {
            new ResizeObserver(markScrollable).observe(inner);
        }
    });
})();
</script>
@endsection
