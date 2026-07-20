@extends('layouts.app')

@section('content')
@php
    $answers = $answers ?? collect();
    $hasDetail = $hasDetail ?? false;
    $score = (int) $result->score;
    $pass = $score >= 70;
    $typeLabel = ($result->type ?? 'post') === 'pre' ? 'Pre Test' : 'Post Test';
    $typeIcon = ($result->type ?? 'post') === 'pre' ? 'fa-clipboard-list' : 'fa-trophy';
    $accent = $pass ? '#14B8A6' : '#F43F5E';
    $accentSoft = $pass ? 'rgba(20,184,166,0.18)' : 'rgba(244,63,94,0.18)';
    $badgeBg = $pass ? 'bg-emerald-500/15 border-emerald-300/25 text-emerald-50' : 'bg-rose-500/15 border-rose-300/25 text-rose-50';
    $badgeIcon = $pass ? 'fa-circle-check' : 'fa-circle-xmark';
    $correctCount = $hasDetail ? $answers->where('is_correct', true)->count() : 0;
    $answeredCount = $hasDetail ? $answers->whereNotNull('selected_answer')->count() : 0;
    $unansweredCount = $hasDetail ? ($answers->count() - $answeredCount) : 0;
    $wrongCount = $hasDetail ? max(0, $answers->count() - $correctCount - $unansweredCount) : 0;
@endphp

<div class="rsx-root">
    <div class="rsx-shell">
        <div class="rsx-hero">
            <div class="rsx-hero-bg"></div>
            <div class="rsx-hero-inner">
                <div class="rsx-hero-left">
                    <div class="rsx-chip">
                        <i class="fas {{ $typeIcon }}"></i>
                        <span>Hasil · {{ $typeLabel }}</span>
                    </div>
                    <h1 class="rsx-title">{{ $result->course->title }}</h1>
                    <div class="rsx-meta">
                        <div class="rsx-pill">
                            <i class="fas fa-calendar-day"></i>
                            <span>{{ $result->created_at?->translatedFormat('d M Y, H:i') ?? '' }}</span>
                        </div>
                        <div class="rsx-pill rsx-pill-status {{ $pass ? 'rsx-pass' : 'rsx-fail' }}">
                            <i class="fas {{ $badgeIcon }}"></i>
                            <span>{{ $pass ? 'LULUS' : 'TIDAK LULUS' }}</span>
                        </div>
                    </div>
                </div>

                <div class="rsx-hero-right">
                    <div class="rsx-ring" style="--p: {{ max(0, min(100, $score)) }}; --accent: {{ $accent }}; --accentSoft: {{ $accentSoft }};">
                        <div class="rsx-ring-inner">
                            <div class="rsx-ring-label">Skor</div>
                            <div class="rsx-ring-score">{{ $score }}</div>
                            <div class="rsx-ring-sub">/100</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="rsx-grid">
            <div class="rsx-card">
                <div class="rsx-card-head">
                    <div>
                        <div class="rsx-card-kicker">Performa</div>
                        <div class="rsx-card-title">Ringkasan</div>
                    </div>
                    <div class="rsx-mini-badge" style="--accent: {{ $accent }};">{{ $pass ? 'Memenuhi' : 'Perlu Ulang' }}</div>
                </div>

                <div class="rsx-stats">
                    <div class="rsx-stat">
                        <div class="rsx-stat-label">Hasil</div>
                        <div class="rsx-stat-val">{{ $pass ? 'Lulus' : 'Tidak Lulus' }}</div>
                    </div>
                    <div class="rsx-stat">
                        <div class="rsx-stat-label">Tes</div>
                        <div class="rsx-stat-val">{{ $typeLabel }}</div>
                    </div>
                    @if(!is_null($result->mc_score) || !is_null($result->likert_score))
                        <div class="rsx-stat">
                            <div class="rsx-stat-label">PG / Sikap</div>
                            <div class="rsx-stat-val">{{ $result->mc_score ?? '—' }} / {{ $result->likert_score ?? '—' }}</div>
                        </div>
                    @else
                        <div class="rsx-stat">
                            <div class="rsx-stat-label">Kursus</div>
                            <div class="rsx-stat-val">{{ Str::limit($result->course->title, 22) }}</div>
                        </div>
                    @endif
                </div>

                <div class="rsx-sep"></div>

                <div class="rsx-detailline">
                    <div class="rsx-detailline-left">
                        <div class="rsx-detailline-title">Ringkasan Jawaban</div>
                        <div class="rsx-detailline-sub">
                            @if($hasDetail)
                                {{ $answers->count() }} soal · {{ $answeredCount }} terjawab · {{ $unansweredCount }} kosong
                            @else
                                Detail jawaban belum tersedia pada perangkat/database ini.
                            @endif
                        </div>
                    </div>
                </div>

                @if($hasDetail)
                    <div class="rsx-breakdown">
                        <div class="rsx-break-item rsx-break-ok">
                            <div class="rsx-break-top">
                                <span>Benar</span>
                                <span>{{ $correctCount }}</span>
                            </div>
                            <div class="rsx-break-bar">
                                <div class="rsx-break-fill" style="--p: {{ $answers->count() > 0 ? (int) round(($correctCount / $answers->count()) * 100) : 0 }};"></div>
                            </div>
                        </div>
                        <div class="rsx-break-item rsx-break-bad">
                            <div class="rsx-break-top">
                                <span>Salah</span>
                                <span>{{ $wrongCount }}</span>
                            </div>
                            <div class="rsx-break-bar">
                                <div class="rsx-break-fill" style="--p: {{ $answers->count() > 0 ? (int) round(($wrongCount / $answers->count()) * 100) : 0 }};"></div>
                            </div>
                        </div>
                        <div class="rsx-break-item rsx-break-skip">
                            <div class="rsx-break-top">
                                <span>Kosong</span>
                                <span>{{ $unansweredCount }}</span>
                            </div>
                            <div class="rsx-break-bar">
                                <div class="rsx-break-fill" style="--p: {{ $answers->count() > 0 ? (int) round(($unansweredCount / $answers->count()) * 100) : 0 }};"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="rsx-card">
                <div class="rsx-card-head">
                    <div>
                        <div class="rsx-card-kicker">Aksi</div>
                        <div class="rsx-card-title">Langkah Selanjutnya</div>
                    </div>
                </div>

                <div class="rsx-actions">
                    <a class="rsx-btn rsx-btn-primary" href="{{ route('dashboard') }}" style="--accent: {{ $accent }};">
                        <span>Kembali ke Dashboard</span>
                        <i class="fas fa-home"></i>
                    </a>
                    <a class="rsx-btn rsx-btn-ghost" href="{{ route('courses.index') }}">
                        <span>Lanjut Belajar</span>
                        <i class="fas fa-book-open"></i>
                    </a>
                    <a class="rsx-btn rsx-btn-ghost" href="{{ route('results.index') }}">
                        <span>Semua Nilai</span>
                        <i class="fas fa-list-check"></i>
                    </a>
                </div>
            </div>
        </div>

        @if($hasDetail)
            <div class="rsx-card rsx-card-full">
                <div class="rsx-card-head rsx-card-head-tight">
                    <div>
                        <div class="rsx-card-kicker">Detail</div>
                        <div class="rsx-card-title">Jawaban Kamu</div>
                    </div>
                    <button type="button" id="rsxToggle" class="rsx-toggle">
                        <span id="rsxToggleText">Tampilkan</span>
                        <i class="fas fa-chevron-down" id="rsxToggleIcon"></i>
                    </button>
                </div>

                <div id="rsxAnswers" class="rsx-answers hidden">
                    @foreach($answers as $idx => $answer)
                        @php
                            $q = $answer->question;
                            $selected = $answer->selected_answer;
                            $isLikert = $q && method_exists($q, 'isLikert') ? $q->isLikert() : false;
                            $correct = $q?->correct_answer;
                            $isCorrect = (bool) $answer->is_correct;
                            $points = $answer->points;
                        @endphp
                        <div class="rsx-q">
                            <div class="rsx-q-head">
                                <div class="rsx-q-num {{ $isLikert ? ($points !== null && $points >= 4 ? 'rsx-q-ok' : 'rsx-q-bad') : ($isCorrect ? 'rsx-q-ok' : 'rsx-q-bad') }}">{{ $idx + 1 }}</div>
                                <div class="rsx-q-body">
                                    <div class="rsx-q-title">{{ $q?->question ?? 'Soal tidak ditemukan' }}</div>
                                    <div class="rsx-q-meta">
                                        @if($isLikert)
                                            <span class="rsx-q-tag rsx-tag-neutral">Sikap (Likert)</span>
                                            <span class="rsx-q-tag rsx-tag-neutral">Jawaban: <strong>{{ \App\Models\Question::likertLabel($selected) }}</strong></span>
                                            <span class="rsx-q-tag {{ $points !== null && $points >= 4 ? 'rsx-tag-ok' : 'rsx-tag-bad' }}">Poin: <strong>{{ $points ?? '—' }}/5</strong></span>
                                        @else
                                            <span class="rsx-q-tag {{ $isCorrect ? 'rsx-tag-ok' : 'rsx-tag-bad' }}">{{ $isCorrect ? 'Benar' : 'Salah' }}</span>
                                            <span class="rsx-q-tag rsx-tag-neutral">Jawaban kamu: <strong>{{ $selected ?? '—' }}</strong></span>
                                            <span class="rsx-q-tag rsx-tag-neutral">Kunci: <strong>{{ $correct ?? '—' }}</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($q && $isLikert)
                                <div class="rsx-opts">
                                    @foreach(\App\Models\Question::LIKERT_OPTIONS as $opt => $optText)
                                        @php
                                            $isPick = (string) $selected === (string) $opt;
                                            $state = $isPick ? 'picked_key' : 'default';
                                        @endphp
                                        <div class="rsx-opt {{ $isPick ? 'rsx-opt-picked-key' : '' }}">
                                            <div class="rsx-opt-letter">{{ $opt }}</div>
                                            <div class="rsx-opt-text">{{ $optText }}</div>
                                            <div class="rsx-opt-badges">
                                                @if($isPick)
                                                    <span class="rsx-opt-badge rsx-opt-badge-ok">
                                                        <i class="fas fa-check"></i>
                                                        Kamu
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($q)
                                <div class="rsx-opts">
                                    @foreach(['A','B','C','D'] as $opt)
                                        @php
                                            $optText = $q->{'option_' . strtolower($opt)};
                                            $isKey = $correct === $opt;
                                            $isPick = $selected === $opt;
                                            $state = 'default';
                                            if ($isKey && $isPick) $state = 'picked_key';
                                            elseif ($isKey) $state = 'key';
                                            elseif ($isPick) $state = 'picked_wrong';
                                        @endphp
                                        <div class="rsx-opt {{ $state === 'picked_key' ? 'rsx-opt-picked-key' : ($state === 'key' ? 'rsx-opt-key' : ($state === 'picked_wrong' ? 'rsx-opt-picked-wrong' : '')) }}">
                                            <div class="rsx-opt-letter">{{ $opt }}</div>
                                            <div class="rsx-opt-text">{{ $optText }}</div>
                                            <div class="rsx-opt-badges">
                                                @if($state === 'key' || $state === 'picked_key')
                                                        <span class="rsx-opt-badge rsx-opt-badge-key"><i class="fas fa-key"></i> Kunci</span>
                                                @endif
                                                @if($state === 'picked_wrong' || $state === 'picked_key')
                                                    <span class="rsx-opt-badge {{ $state === 'picked_key' ? 'rsx-opt-badge-ok' : 'rsx-opt-badge-bad' }}">
                                                        <i class="fas {{ $state === 'picked_key' ? 'fa-check' : 'fa-xmark' }}"></i>
                                                            Kamu
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    .rsx-root{padding:1.25rem 0 7rem}
    .rsx-shell{max-width:980px;margin:0 auto;padding:0 1rem}
    @media (min-width:640px){.rsx-shell{padding:0 1.25rem}}

    .rsx-hero{position:relative;border-radius:28px;overflow:hidden;border:1px solid rgba(15,23,42,0.08);box-shadow:0 30px 80px rgba(15,23,42,0.10),0 6px 18px rgba(15,23,42,0.06)}
    .rsx-hero-bg{position:absolute;inset:0;background:
        radial-gradient(70% 70% at 15% 20%, rgba(255,255,255,0.24), rgba(255,255,255,0) 55%),
        radial-gradient(60% 60% at 90% 10%, rgba(201,168,76,0.35), rgba(201,168,76,0) 55%),
        radial-gradient(60% 60% at 85% 85%, rgba(20,168,143,0.34), rgba(20,168,143,0) 55%),
        linear-gradient(135deg, #0B1E3F 0%, #122247 40%, #0F7E6E 100%)}
    .rsx-hero-inner{position:relative;z-index:2;padding:20px;display:flex;flex-direction:column;gap:18px}
    @media (min-width:768px){.rsx-hero-inner{padding:28px;flex-direction:row;align-items:center;justify-content:space-between;gap:26px}}

    .rsx-chip{display:inline-flex;align-items:center;gap:10px;padding:10px 14px;border-radius:999px;background:rgba(255,255,255,0.10);border:1px solid rgba(255,255,255,0.18);color:#fff;font-weight:800;font-size:11px;letter-spacing:.12em;text-transform:uppercase}
    .rsx-title{margin-top:12px;color:#fff;font-size:22px;line-height:1.12;font-weight:900;letter-spacing:-.02em}
    @media (min-width:640px){.rsx-title{font-size:30px}}

    .rsx-meta{display:flex;flex-wrap:wrap;gap:10px;margin-top:14px}
    .rsx-pill{display:inline-flex;align-items:center;gap:10px;padding:10px 14px;border-radius:999px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.14);color:rgba(255,255,255,0.92);font-weight:700;font-size:12px}
    .rsx-pill i{opacity:.9}
    .rsx-pill-status{font-weight:900;letter-spacing:.1em;text-transform:uppercase}
    .rsx-pass{background:rgba(16,185,129,0.14);border-color:rgba(16,185,129,0.22)}
    .rsx-fail{background:rgba(244,63,94,0.14);border-color:rgba(244,63,94,0.22)}

    .rsx-ring{width:118px;height:118px;border-radius:999px;position:relative;display:grid;place-items:center;background:conic-gradient(var(--accent) calc(var(--p)*1%), rgba(255,255,255,0.14) 0);box-shadow:0 18px 40px rgba(0,0,0,0.22);padding:10px}
    @media (min-width:640px){.rsx-ring{width:140px;height:140px;padding:12px}}
    .rsx-ring::after{content:'';position:absolute;inset:12px;border-radius:999px;background:rgba(255,255,255,0.10);border:1px solid rgba(255,255,255,0.18);backdrop-filter:blur(10px)}
    .rsx-ring-inner{position:relative;z-index:2;text-align:center;color:#fff}
    .rsx-ring-label{font-size:10px;font-weight:900;letter-spacing:.22em;text-transform:uppercase;color:rgba(255,255,255,0.7)}
    .rsx-ring-score{font-size:38px;font-weight:950;letter-spacing:-.04em;line-height:1;margin-top:4px}
    .rsx-ring-sub{font-size:12px;font-weight:800;color:rgba(255,255,255,0.7);margin-top:1px}

    .rsx-grid{display:grid;grid-template-columns:1fr;gap:14px;margin-top:14px}
    @media (min-width:768px){.rsx-grid{grid-template-columns:1.25fr .75fr;gap:16px;margin-top:16px}}
    .rsx-card{background:#fff;border:1px solid rgba(15,23,42,0.08);border-radius:24px;padding:18px;box-shadow:0 14px 34px rgba(15,23,42,0.06)}
    @media (min-width:640px){.rsx-card{padding:22px;border-radius:28px}}
    .rsx-card-full{margin-top:14px}
    .rsx-card-head{display:flex;align-items:flex-start;justify-content:space-between;gap:14px}
    .rsx-card-head-tight{align-items:center}
    .rsx-card-kicker{font-size:10px;font-weight:900;letter-spacing:.22em;text-transform:uppercase;color:rgba(15,23,42,0.48)}
    .rsx-card-title{font-size:18px;font-weight:950;letter-spacing:-.02em;color:#0f172a;margin-top:4px}
    .rsx-mini-badge{display:inline-flex;align-items:center;justify-content:center;padding:10px 12px;border-radius:999px;background:rgba(15,23,42,0.04);border:1px solid rgba(15,23,42,0.08);font-size:11px;font-weight:900;letter-spacing:.12em;text-transform:uppercase;color:rgba(15,23,42,0.72)}
    .rsx-mini-badge{box-shadow:0 10px 22px rgba(15,23,42,0.06)}

    .rsx-stats{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px;margin-top:14px}
    .rsx-stat{border-radius:20px;border:1px solid rgba(15,23,42,0.08);background:linear-gradient(180deg,#fff,rgba(15,23,42,0.02));padding:12px}
    .rsx-stat-label{font-size:10px;font-weight:900;letter-spacing:.18em;text-transform:uppercase;color:rgba(15,23,42,0.48)}
    .rsx-stat-val{font-size:13px;font-weight:900;color:#0f172a;margin-top:6px;line-height:1.2}
    @media (min-width:640px){.rsx-stat{padding:14px}.rsx-stat-val{font-size:14px}}

    .rsx-sep{height:1px;background:rgba(15,23,42,0.08);margin:16px 0}
    .rsx-detailline{display:flex;align-items:center;justify-content:space-between}
    .rsx-detailline-title{font-size:13px;font-weight:950;color:#0f172a}
    .rsx-detailline-sub{font-size:12px;font-weight:700;color:rgba(15,23,42,0.55);margin-top:4px}

    .rsx-breakdown{display:grid;grid-template-columns:1fr;gap:10px;margin-top:14px}
    @media (min-width:640px){.rsx-breakdown{grid-template-columns:repeat(3,minmax(0,1fr))}}
    .rsx-break-item{border-radius:22px;border:1px solid rgba(15,23,42,0.08);background:#fff;padding:12px}
    .rsx-break-top{display:flex;align-items:center;justify-content:space-between;font-size:12px;font-weight:900;color:#0f172a}
    .rsx-break-bar{height:8px;border-radius:999px;background:rgba(15,23,42,0.06);overflow:hidden;margin-top:10px}
    .rsx-break-fill{height:100%;width:calc(var(--p)*1%);border-radius:999px;background:var(--accent)}
    .rsx-break-ok{--accent:#14B8A6}
    .rsx-break-bad{--accent:#F43F5E}
    .rsx-break-skip{--accent:#64748B}

    .rsx-actions{display:flex;flex-direction:column;gap:10px;margin-top:14px}
    .rsx-btn{display:inline-flex;align-items:center;justify-content:space-between;gap:14px;width:100%;padding:14px 16px;border-radius:18px;font-size:12px;font-weight:950;letter-spacing:.14em;text-transform:uppercase;transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease}
    .rsx-btn:active{transform:scale(.98)}
    .rsx-btn-primary{background:linear-gradient(135deg,var(--accent),#0B1E3F);color:#fff;border:1px solid rgba(255,255,255,0.12);box-shadow:0 14px 30px rgba(15,23,42,0.12)}
    .rsx-btn-ghost{background:#fff;color:#0f172a;border:1px solid rgba(15,23,42,0.10);box-shadow:0 10px 22px rgba(15,23,42,0.06)}

    .rsx-toggle{display:inline-flex;align-items:center;gap:10px;padding:10px 12px;border-radius:999px;border:1px solid rgba(15,23,42,0.10);background:rgba(15,23,42,0.04);font-size:11px;font-weight:950;letter-spacing:.14em;text-transform:uppercase;color:rgba(15,23,42,0.78);transition:transform .15s ease}
    .rsx-toggle:active{transform:scale(.98)}
    .rsx-answers{margin-top:14px;display:flex;flex-direction:column;gap:12px}
    .rsx-q{border-radius:24px;border:1px solid rgba(15,23,42,0.08);background:linear-gradient(180deg,#fff,rgba(15,23,42,0.02));padding:14px}
    @media (min-width:640px){.rsx-q{padding:18px}}
    .rsx-q-head{display:flex;gap:12px}
    .rsx-q-num{width:42px;height:42px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-weight:950;color:#fff;flex-shrink:0}
    .rsx-q-ok{background:#14B8A6}
    .rsx-q-bad{background:#F43F5E}
    .rsx-q-title{font-size:14px;font-weight:950;color:#0f172a;line-height:1.35}
    .rsx-q-meta{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}
    .rsx-q-tag{display:inline-flex;align-items:center;gap:8px;padding:8px 10px;border-radius:999px;font-size:11px;font-weight:900;border:1px solid rgba(15,23,42,0.08);background:rgba(15,23,42,0.03);color:rgba(15,23,42,0.78)}
    .rsx-q-tag strong{color:#0f172a}
    .rsx-tag-ok{background:rgba(20,184,166,0.12);border-color:rgba(20,184,166,0.18);color:#0f766e}
    .rsx-tag-bad{background:rgba(244,63,94,0.12);border-color:rgba(244,63,94,0.18);color:#be123c}
    .rsx-tag-neutral{background:rgba(15,23,42,0.03)}

    .rsx-opts{margin-top:14px;display:grid;grid-template-columns:1fr;gap:10px}
    @media (min-width:640px){.rsx-opts{grid-template-columns:repeat(2,minmax(0,1fr))}}
    .rsx-opt{border-radius:20px;border:1px solid rgba(15,23,42,0.08);background:#fff;padding:12px;display:flex;gap:12px;align-items:flex-start}
    .rsx-opt-letter{width:36px;height:36px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-weight:950;background:rgba(15,23,42,0.05);border:1px solid rgba(15,23,42,0.10);color:#0f172a;flex-shrink:0}
    .rsx-opt-text{font-size:13px;font-weight:800;color:rgba(15,23,42,0.82);line-height:1.45}
    .rsx-opt-badges{margin-left:auto;display:flex;flex-direction:column;gap:8px;align-items:flex-end}
    .rsx-opt-badge{display:inline-flex;align-items:center;gap:8px;padding:7px 10px;border-radius:999px;font-size:10px;font-weight:950;letter-spacing:.1em;text-transform:uppercase;border:1px solid rgba(15,23,42,0.10);background:rgba(15,23,42,0.03);color:rgba(15,23,42,0.78);white-space:nowrap}
    .rsx-opt-badge i{font-size:10px}
    .rsx-opt-badge-key{border-color:rgba(20,184,166,0.18);background:rgba(20,184,166,0.10);color:#0f766e}
    .rsx-opt-badge-ok{border-color:rgba(20,184,166,0.18);background:rgba(20,184,166,0.10);color:#0f766e}
    .rsx-opt-badge-bad{border-color:rgba(244,63,94,0.18);background:rgba(244,63,94,0.10);color:#be123c}

    .rsx-opt-key{border-color:rgba(20,184,166,0.22);box-shadow:0 12px 22px rgba(20,184,166,0.08)}
    .rsx-opt-picked-key{border-color:rgba(20,184,166,0.22);background:linear-gradient(180deg,#fff,rgba(20,184,166,0.06));box-shadow:0 14px 26px rgba(20,184,166,0.10)}
    .rsx-opt-picked-wrong{border-color:rgba(244,63,94,0.22);background:linear-gradient(180deg,#fff,rgba(244,63,94,0.06));box-shadow:0 14px 26px rgba(244,63,94,0.10)}
</style>

<script>
    (function () {
        const btn = document.getElementById('rsxToggle');
        const wrap = document.getElementById('rsxAnswers');
        const text = document.getElementById('rsxToggleText');
        const icon = document.getElementById('rsxToggleIcon');
        if (!btn || !wrap || !text || !icon) return;

        btn.addEventListener('click', function () {
            const isOpen = !wrap.classList.contains('hidden');
            if (isOpen) {
                wrap.classList.add('hidden');
                text.textContent = 'Tampilkan';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            } else {
                wrap.classList.remove('hidden');
                text.textContent = 'Sembunyikan';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            }
        });
    })();
</script>
@endsection
