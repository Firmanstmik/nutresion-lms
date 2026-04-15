@extends('layouts.app')

@section('content')

{{-- ═══════════════════════════════ PRETEST PAGE ═══════════════════════════════ --}}

{{-- ── Sticky Timer Bar ─────────────────────────────────────────────────────── --}}
<div id="pt-timer-bar" class="pt-timer-bar">
    <div class="pt-timer-inner">
        <div class="pt-timer-left">
            <div class="pt-timer-icon">
                <i class="fas fa-hourglass-half" id="pt-hourglass-icon"></i>
            </div>
            <div class="pt-timer-info">
                <span class="pt-timer-label">WAKTU TERSISA</span>
                <span class="pt-timer-display" id="pt-timer-display">00:00</span>
            </div>
        </div>
        <div class="pt-timer-right">
            <div class="pt-progress-wrap">
                <div class="pt-progress-track">
                    <div class="pt-progress-fill" id="pt-progress-fill"></div>
                </div>
                <span class="pt-progress-label" id="pt-progress-label">0/{{ $course->preQuestions->count() }}</span>
            </div>
            <div class="pt-course-info">
                <i class="fas fa-book-open"></i>
                <span>{{ Str::limit($course->title, 28) }}</span>
            </div>
        </div>
    </div>
</div>

{{-- ── Header ───────────────────────────────────────────────────────────────── --}}
<div class="pt-header">
    <div class="pt-header-inner">
        <div class="pt-badge">
            <i class="fas fa-clipboard-list"></i>
            PRE TEST
        </div>
        <h1 class="pt-title">
            Pre Test: <span class="pt-title-accent">{{ $course->title }}</span>
        </h1>
        <div class="pt-meta-row">
            <div class="pt-meta-card">
                <div class="pt-meta-icon" style="background:#FEF3C7;color:#D97706;">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div>
                    <p class="pt-meta-label">Total Soal</p>
                    <p class="pt-meta-val">{{ $course->preQuestions->count() }} Soal</p>
                </div>
            </div>
            <div class="pt-meta-card">
                <div class="pt-meta-icon" style="background:#FEE2E2;color:#DC2626;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="pt-meta-label">Durasi</p>
                    <p class="pt-meta-val">{{ $duration_minutes }} Menit</p>
                </div>
            </div>
            <div class="pt-meta-card">
                <div class="pt-meta-icon" style="background:#EDE9FE;color:#7C3AED;">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <p class="pt-meta-label">Kesempatan</p>
                    <p class="pt-meta-val">1 Kali</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Question Form ─────────────────────────────────────────────────────────── --}}
<div class="pt-content">
    <form id="pt-form"
          action="{{ route('tests.pre.submit', $course->id) }}"
          method="POST"
          data-total-seconds="{{ $duration_seconds }}"
          data-course-id="{{ $course->id }}"
          data-question-count="{{ $course->preQuestions->count() }}">
        @csrf
        <input type="hidden" name="is_timeout" id="pt-is-timeout" value="0">

        @foreach($course->preQuestions as $question)
        <div class="pt-question-card" style="--qi: {{ $loop->index }}">
            <div class="pt-q-header">
                <div class="pt-q-num">{{ $loop->iteration }}</div>
                <h3 class="pt-q-text">{{ $question->question }}</h3>
            </div>

            <div class="pt-options">
                @foreach(['A','B','C','D'] as $opt)
                <label class="pt-option">
                    <input
                        type="radio"
                        name="question_{{ $question->id }}"
                        value="{{ $opt }}"
                        class="pt-radio"
                    >
                    <div class="pt-option-inner">
                        <span class="pt-opt-letter">{{ $opt }}</span>
                        <span class="pt-opt-text">{{ $question->{'option_' . strtolower($opt)} }}</span>
                        <span class="pt-opt-check"><i class="fas fa-check"></i></span>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        {{-- ── Submit Bar ──────────────────────────────────────────────────── --}}
        <div class="pt-submit-bar">
            <div class="pt-submit-note">
                <i class="fas fa-info-circle"></i>
                Periksa kembali jawaban sebelum mengirim. Waktu habis = otomatis dikumpulkan.
            </div>
            <button type="submit" class="pt-submit-btn" id="pt-submit-btn">
                <i class="fas fa-paper-plane"></i>
                SELESAIKAN PRE TEST
            </button>
        </div>

    </form>
</div>

{{-- ── Time Up Modal ─────────────────────────────────────────────────────────── --}}
<div id="pt-timeout-modal" class="pt-modal" style="display:none;">
    <div class="pt-modal-box">
        <div class="pt-modal-icon">
            <i class="fas fa-hourglass-end"></i>
        </div>
        <h2 class="pt-modal-title">Waktu Habis!</h2>
        <p class="pt-modal-body">Waktu pengerjaan Pre Test telah habis. Jawaban kamu otomatis dikumpulkan.</p>
        <div class="pt-modal-spinner">
            <div class="pt-spinner"></div>
            <span>Mengirim jawaban...</span>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════ STYLES ═══════════════════════════════ --}}
<style>
/* ── Tokens ─────────────────────────────────────────────────── */
:root {
    --pt-amber:    #D97706;
    --pt-amber-lt: #FCD34D;
    --pt-amber-bg: #FEF3C7;
    --pt-green:    #0D5C34;
    --pt-green-lt: #4ADE80;
    --pt-ink:      #0F1A12;
    --pt-muted:    #6B7280;
    --pt-border:   #E5E7EB;
    --pt-surface:  #F7FAF8;
    --pt-white:    #FFFFFF;
    --pt-red:      #DC2626;
    --pt-red-lt:   #FEE2E2;
}

/* ── Timer Bar ───────────────────────────────────────────────── */
.pt-timer-bar {
    position: fixed;
    top: 0; left: 0; right: 0;
    z-index: 9999;
    background: #0A3D21;
    border-bottom: 1px solid rgba(74,222,128,0.2);
    box-shadow: 0 4px 20px rgba(0,0,0,0.25);
}
.pt-timer-inner {
    max-width: 900px;
    margin: 0 auto;
    padding: 0.7rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.pt-timer-left { display: flex; align-items: center; gap: 0.85rem; }
.pt-timer-icon {
    width: 38px; height: 38px;
    background: rgba(74,222,128,0.12);
    border: 1px solid rgba(74,222,128,0.25);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--pt-green-lt);
    font-size: 1rem;
}
.pt-timer-info { display: flex; flex-direction: column; gap: 1px; }
.pt-timer-label {
    font-size: 0.5rem; font-weight: 800;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: rgba(255,255,255,0.35);
}
.pt-timer-display {
    font-size: 1.35rem; font-weight: 900;
    color: #fff; letter-spacing: -0.03em;
    font-variant-numeric: tabular-nums;
    transition: color 0.3s ease;
}
.pt-timer-display.pt-warning { color: #FCD34D; }
.pt-timer-display.pt-danger  { color: #F87171; animation: pt-blink 0.8s infinite; }
@keyframes pt-blink { 0%,100%{opacity:1} 50%{opacity:0.5} }

.pt-timer-right {
    display: flex; flex-direction: column; align-items: flex-end; gap: 0.35rem;
}
.pt-progress-wrap { display: flex; align-items: center; gap: 0.6rem; }
.pt-progress-track {
    width: 120px; height: 4px;
    background: rgba(255,255,255,0.1);
    border-radius: 100px; overflow: hidden;
}
@media (min-width:640px) { .pt-progress-track { width: 180px; } }
.pt-progress-fill {
    height: 100%; border-radius: 100px;
    background: linear-gradient(90deg, #22C55E, #4ADE80);
    transition: width 1s linear, background 0.5s ease;
}
.pt-progress-fill.pt-warn-fill { background: linear-gradient(90deg,#D97706,#FCD34D); }
.pt-progress-fill.pt-danger-fill { background: linear-gradient(90deg,#DC2626,#F87171); }
.pt-progress-label {
    font-size: 0.6rem; font-weight: 800;
    color: rgba(255,255,255,0.5);
    min-width: 30px; text-align: right;
    font-variant-numeric: tabular-nums;
}
.pt-course-info {
    display: flex; align-items: center; gap: 0.35rem;
    font-size: 0.58rem; font-weight: 600;
    color: rgba(255,255,255,0.28);
}
.pt-course-info .fas { font-size: 0.52rem; }

/* ── Header ─────────────────────────────────────────────────── */
.pt-header {
    background: linear-gradient(135deg, #0D5C34 0%, #0A3D21 100%);
    padding: 5rem 1.25rem 2.5rem;
    margin-bottom: 0;
}
.pt-header-inner {
    max-width: 900px; margin: 0 auto;
    display: flex; flex-direction: column; gap: 1.25rem;
}
.pt-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.3rem 0.85rem;
    background: rgba(245,158,11,0.15);
    border: 1px solid rgba(245,158,11,0.35);
    border-radius: 100px;
    font-size: 0.58rem; font-weight: 800;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: #FCD34D;
    width: fit-content;
}
.pt-badge .fas { font-size: 0.56rem; }
.pt-title {
    font-size: clamp(1.4rem, 3.5vw, 2rem);
    font-weight: 900; color: #fff;
    letter-spacing: -0.02em; line-height: 1.15;
    margin: 0;
}
.pt-title-accent { color: var(--pt-green-lt); }
.pt-meta-row {
    display: flex; flex-wrap: wrap; gap: 0.75rem;
}
.pt-meta-card {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.65rem 1rem;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    backdrop-filter: blur(8px);
}
.pt-meta-icon {
    width: 36px; height: 36px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; flex-shrink: 0;
}
.pt-meta-label {
    font-size: 0.55rem; font-weight: 700;
    letter-spacing: 0.12em; text-transform: uppercase;
    color: rgba(255,255,255,0.38);
    margin: 0 0 2px;
}
.pt-meta-val {
    font-size: 0.9rem; font-weight: 800;
    color: #fff; margin: 0;
}

/* ── Content ─────────────────────────────────────────────────── */
.pt-content {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1.25rem 6rem;
    display: flex; flex-direction: column; gap: 1.25rem;
}

/* ── Question Card ───────────────────────────────────────────── */
.pt-question-card {
    background: var(--pt-white);
    border: 1px solid var(--pt-border);
    border-radius: 18px;
    padding: 1.5rem;
    box-shadow: 0 4px 16px rgba(13,92,52,0.06);
    animation: pt-fade-up 0.4s ease both;
    animation-delay: calc(var(--qi) * 60ms);
}
@keyframes pt-fade-up {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
.pt-q-header {
    display: flex; align-items: flex-start; gap: 1rem;
    margin-bottom: 1.25rem;
}
.pt-q-num {
    width: 40px; height: 40px; flex-shrink: 0;
    background: linear-gradient(135deg,#D97706,#F59E0B);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; font-weight: 900; color: #fff;
    box-shadow: 0 4px 12px rgba(217,119,6,0.3);
}
.pt-q-text {
    font-size: 0.95rem; font-weight: 700;
    color: var(--pt-ink); line-height: 1.55;
    margin: 0; padding-top: 0.3rem;
}

/* ── Options ─────────────────────────────────────────────────── */
.pt-options {
    display: grid;
    grid-template-columns: 1fr;
    gap: 0.6rem;
}
@media (min-width:640px) { .pt-options { grid-template-columns: 1fr 1fr; } }

.pt-option { cursor: pointer; display: block; }
.pt-radio { display: none; }
.pt-option-inner {
    display: flex; align-items: center; gap: 0.85rem;
    padding: 0.85rem 1rem;
    background: var(--pt-surface);
    border: 2px solid var(--pt-border);
    border-radius: 12px;
    transition: all 0.2s ease;
}
.pt-option:hover .pt-option-inner {
    background: var(--pt-white);
    border-color: rgba(217,119,6,0.3);
    box-shadow: 0 4px 14px rgba(217,119,6,0.08);
}
.pt-radio:checked + .pt-option-inner {
    background: linear-gradient(135deg,#D97706,#F59E0B);
    border-color: #D97706;
    box-shadow: 0 6px 20px rgba(217,119,6,0.3);
}
.pt-opt-letter {
    width: 32px; height: 32px; flex-shrink: 0;
    background: var(--pt-white);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; font-weight: 800;
    color: var(--pt-amber);
    border: 1px solid var(--pt-border);
    transition: all 0.2s ease;
}
.pt-radio:checked + .pt-option-inner .pt-opt-letter {
    background: rgba(255,255,255,0.25);
    border-color: rgba(255,255,255,0.3);
    color: #fff;
}
.pt-opt-text {
    font-size: 0.82rem; font-weight: 600;
    color: var(--pt-ink); flex: 1; line-height: 1.4;
    transition: color 0.2s ease;
}
.pt-radio:checked + .pt-option-inner .pt-opt-text { color: #fff; }
.pt-opt-check {
    width: 24px; height: 24px; flex-shrink: 0;
    border: 2px solid var(--pt-border);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.6rem; color: transparent;
    transition: all 0.2s ease;
}
.pt-radio:checked + .pt-option-inner .pt-opt-check {
    background: rgba(255,255,255,0.2);
    border-color: rgba(255,255,255,0.5);
    color: #fff;
}

/* ── Submit Bar ──────────────────────────────────────────────── */
.pt-submit-bar {
    display: flex; flex-direction: column;
    align-items: center; gap: 1rem;
    padding: 1.5rem;
    background: var(--pt-white);
    border: 1px solid var(--pt-border);
    border-radius: 18px;
    box-shadow: 0 4px 16px rgba(13,92,52,0.06);
}
@media (min-width:640px) {
    .pt-submit-bar { flex-direction: row; justify-content: space-between; }
}
.pt-submit-note {
    display: flex; align-items: center; gap: 0.65rem;
    font-size: 0.72rem; font-weight: 600;
    color: var(--pt-muted); line-height: 1.5;
}
.pt-submit-note .fas { color: var(--pt-amber); font-size: 1rem; flex-shrink: 0; }
.pt-submit-btn {
    display: inline-flex; align-items: center; gap: 0.6rem;
    padding: 0.85rem 2rem;
    background: linear-gradient(135deg,#0D5C34,#187945);
    color: #fff; border: none; border-radius: 12px;
    font-size: 0.7rem; font-weight: 800;
    letter-spacing: 0.12em; text-transform: uppercase;
    cursor: pointer; white-space: nowrap;
    box-shadow: 0 6px 20px rgba(13,92,52,0.3);
    transition: all 0.25s ease;
}
.pt-submit-btn:hover {
    background: linear-gradient(135deg,#187945,#1E9152);
    transform: translateY(-1px);
    box-shadow: 0 8px 26px rgba(13,92,52,0.4);
}
.pt-submit-btn:active { transform: scale(0.97); }

/* ── Timeout Modal ───────────────────────────────────────────── */
.pt-modal {
    position: fixed; inset: 0; z-index: 99999;
    background: rgba(0,0,0,0.65);
    backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
}
.pt-modal-box {
    background: #fff; border-radius: 24px;
    padding: 2.5rem 2rem; max-width: 400px; width: 100%;
    text-align: center;
    box-shadow: 0 32px 80px rgba(0,0,0,0.3);
    animation: pt-pop 0.4s cubic-bezier(0.34,1.56,0.64,1) both;
}
@keyframes pt-pop {
    from { transform: scale(0.85); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}
.pt-modal-icon {
    width: 72px; height: 72px;
    background: linear-gradient(135deg,#D97706,#F59E0B);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem; color: #fff;
    margin: 0 auto 1.25rem;
    box-shadow: 0 8px 24px rgba(217,119,6,0.3);
}
.pt-modal-title {
    font-size: 1.4rem; font-weight: 900;
    color: var(--pt-ink); margin: 0 0 0.5rem;
}
.pt-modal-body {
    font-size: 0.82rem; color: var(--pt-muted);
    line-height: 1.65; margin: 0 0 1.5rem;
}
.pt-modal-spinner {
    display: flex; align-items: center; justify-content: center; gap: 0.65rem;
    font-size: 0.75rem; font-weight: 700; color: var(--pt-muted);
}
.pt-spinner {
    width: 22px; height: 22px;
    border: 3px solid var(--pt-border);
    border-top-color: var(--pt-amber);
    border-radius: 50%;
    animation: pt-spin 0.7s linear infinite;
}
@keyframes pt-spin { to { transform: rotate(360deg); } }
</style>

{{-- ═══════════════════════════════ SCRIPTS ═══════════════════════════════ --}}
<script>
(function () {
    const formEl = document.getElementById('pt-form');
    const TOTAL_SECONDS = Number(formEl?.dataset?.totalSeconds || '0');
    const courseId = Number(formEl?.dataset?.courseId || '0');
    const questionCount = Number(formEl?.dataset?.questionCount || '0');
    const storageKey = 'pretest_end_' + courseId;
    const now = Date.now();
    const storedEnd = Number(sessionStorage.getItem(storageKey) || '0');
    const endTime = storedEnd > now ? storedEnd : (now + (TOTAL_SECONDS * 1000));
    sessionStorage.setItem(storageKey, String(endTime));

    const displayEl  = document.getElementById('pt-timer-display');
    const fillEl     = document.getElementById('pt-progress-fill');
    const labelEl    = document.getElementById('pt-progress-label');
    const modalEl    = document.getElementById('pt-timeout-modal');
    const hourglassEl= document.getElementById('pt-hourglass-icon');
    const timeoutInputEl = document.getElementById('pt-is-timeout');

    function formatTime(s) {
        const m = Math.floor(s / 60);
        const sec = s % 60;
        return String(m).padStart(2,'0') + ':' + String(sec).padStart(2,'0');
    }

    function computeRemaining() {
        const diff = Math.floor((endTime - Date.now()) / 1000);
        return Math.max(0, diff);
    }

    function answeredCount() {
        return document.querySelectorAll('#pt-form input[type="radio"]:checked').length;
    }

    function updateUI() {
        const remaining = computeRemaining();
        const answered = answeredCount();
        const pct = questionCount > 0 ? Math.max(0, (answered / questionCount) * 100) : 0;

        // Display
        displayEl.textContent = formatTime(remaining);

        // Progress bar
        fillEl.style.width = pct + '%';
        labelEl.textContent = answered + '/' + questionCount;

        // Color thresholds
        displayEl.classList.remove('pt-warning','pt-danger');
        fillEl.classList.remove('pt-warn-fill','pt-danger-fill');

        if (remaining <= 60) {
            displayEl.classList.add('pt-danger');
            fillEl.classList.add('pt-danger-fill');
            hourglassEl.className = 'fas fa-hourglass-end';
        } else if (remaining <= Math.max(120, Math.floor(TOTAL_SECONDS * 0.25))) {
            displayEl.classList.add('pt-warning');
            fillEl.classList.add('pt-warn-fill');
            hourglassEl.className = 'fas fa-hourglass-half';
        } else {
            hourglassEl.className = 'fas fa-hourglass-start';
        }
    }

    function tick() {
        const remaining = computeRemaining();
        if (remaining <= 0) {
            clearInterval(timer);
            updateUI();
            timeoutInputEl.value = '1';
            modalEl.style.display = 'flex';
            setTimeout(function () { formEl.submit(); }, 2000);
            return;
        }
        updateUI();
    }

    // Initialise
    updateUI();
    const timer = setInterval(tick, 1000);

    // Warn before submit
    formEl.addEventListener('submit', function () {
        sessionStorage.removeItem(storageKey);
        const btn = document.getElementById('pt-submit-btn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<div class="pt-spinner" style="width:16px;height:16px;border-width:2px;margin-right:0.5rem;"></div> Mengirim...';
        }
    });

    formEl.addEventListener('change', function () {
        updateUI();
    });
})();
</script>

@endsection
