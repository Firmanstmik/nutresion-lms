@extends('layouts.app')

@section('content')
<div id="pst-timer-bar" class="pst-timer-bar">
    <div class="pst-timer-inner">
        <div class="pst-timer-left">
            <div class="pst-timer-icon">
                <i class="fas fa-hourglass-half" id="pst-hourglass-icon"></i>
            </div>
            <div class="pst-timer-info">
                <span class="pst-timer-label">WAKTU TERSISA</span>
                <span class="pst-timer-display" id="pst-timer-display">00:00</span>
            </div>
        </div>
        <div class="pst-timer-right">
            <div class="pst-progress-wrap">
                <div class="pst-progress-track">
                    <div class="pst-progress-fill" id="pst-progress-fill"></div>
                </div>
                <span class="pst-progress-label" id="pst-progress-label">0/{{ $course->postQuestions->count() }}</span>
            </div>
            <div class="pst-mins-chip" id="pst-mins-chip">Sisa 0 menit</div>
            <div class="pst-course-info">
                <i class="fas fa-medal"></i>
                <span>{{ Str::limit($course->title, 28) }}</span>
            </div>
        </div>
    </div>
</div>

<div class="pst-header">
    <div class="pst-header-inner">
        <div class="pst-badge">
            <i class="fas fa-trophy"></i>
            POST TEST
        </div>
        <h1 class="pst-title">
            Post Test: <span class="pst-title-accent">{{ $course->title }}</span>
        </h1>
        <div class="pst-meta-row">
            <div class="pst-meta-card">
                <div class="pst-meta-icon" style="background:rgba(20,168,143,0.12);color:#14A88F;">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div>
                    <p class="pst-meta-label">Total Soal</p>
                    <p class="pst-meta-val">{{ $course->postQuestions->count() }} Soal</p>
                </div>
            </div>
            <div class="pst-meta-card">
                <div class="pst-meta-icon" style="background:rgba(201,168,76,0.16);color:#E2C471;">
                    <i class="fas fa-clock"></i>
                </div>
                <div>
                    <p class="pst-meta-label">Durasi</p>
                    <p class="pst-meta-val">{{ $duration_minutes }} Menit</p>
                </div>
            </div>
            <div class="pst-meta-card">
                <div class="pst-meta-icon" style="background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8);">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <p class="pst-meta-label">Kesempatan</p>
                    <p class="pst-meta-val">1 Kali</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="pst-content">
    <form id="pst-form" action="{{ route('tests.submit', $course->id) }}" method="POST"
          data-total-seconds="{{ $duration_seconds }}"
          data-course-id="{{ $course->id }}"
          data-question-count="{{ $course->postQuestions->count() }}">
        @csrf
        <input type="hidden" name="is_timeout" id="pst-is-timeout" value="0">

        @foreach($course->postQuestions as $question)
            <div class="pst-question-card" style="--qi: {{ $loop->index }}">
                <div class="pst-q-header">
                    <div class="pst-q-num">{{ $loop->iteration }}</div>
                    <h3 class="pst-q-text">{{ $question->question }}</h3>
                </div>

                <div class="pst-options">
                    @foreach(['A','B','C','D'] as $opt)
                        <label class="pst-option">
                            <input
                                type="radio"
                                name="question_{{ $question->id }}"
                                value="{{ $opt }}"
                                class="pst-radio"
                            >
                            <div class="pst-option-inner">
                                <span class="pst-opt-letter">{{ $opt }}</span>
                                <span class="pst-opt-text">{{ $question->{'option_' . strtolower($opt)} }}</span>
                                <span class="pst-opt-check"><i class="fas fa-check"></i></span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="pst-submit-bar">
            <div class="pst-submit-note">
                <i class="fas fa-info-circle"></i>
                Waktu habis = otomatis dikumpulkan. Jawaban yang belum diisi dianggap salah.
            </div>
            <button type="submit" class="pst-submit-btn" id="pst-submit-btn">
                <i class="fas fa-paper-plane"></i>
                SELESAIKAN POST TEST
            </button>
        </div>
    </form>
</div>

<div id="pst-timeout-modal" class="pst-modal" style="display:none;">
    <div class="pst-modal-box">
        <div class="pst-modal-icon">
            <i class="fas fa-hourglass-end"></i>
        </div>
        <h2 class="pst-modal-title">Waktu Habis!</h2>
        <p class="pst-modal-body">Waktu pengerjaan Post Test telah habis. Jawaban kamu otomatis dikumpulkan.</p>
        <div class="pst-modal-spinner">
            <div class="pst-spinner"></div>
            <span>Mengirim jawaban...</span>
        </div>
    </div>
</div>

<style>
:root {
    --pst-navy:     #0B1E3F;
    --pst-navy-md:  #122247;
    --pst-gold:     #C9A84C;
    --pst-gold-lt:  #E2C471;
    --pst-teal:     #0F7E6E;
    --pst-teal-lt:  #14A88F;
    --pst-ink:      #111827;
    --pst-muted:    #6B7280;
    --pst-border:   #E5E7EB;
    --pst-surface:  #F9FAFB;
    --pst-white:    #FFFFFF;
    --pst-nav-h:    60px;
    --pst-timer-h:  56px;
}

.pst-timer-bar {
    position: fixed;
    top: var(--pst-nav-h); left: 0; right: 0;
    z-index: 9999;
    background: rgba(11,30,63,0.98);
    border-bottom: 1px solid rgba(226,196,113,0.18);
    box-shadow: 0 6px 30px rgba(0,0,0,0.28);
}
.pst-timer-inner {
    max-width: 900px;
    margin: 0 auto;
    padding: 0.7rem 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
}
.pst-timer-left { display: flex; align-items: center; gap: 0.85rem; }
.pst-timer-icon {
    width: 38px; height: 38px;
    background: rgba(226,196,113,0.12);
    border: 1px solid rgba(226,196,113,0.22);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--pst-gold-lt);
    font-size: 1rem;
}
.pst-timer-info { display: flex; flex-direction: column; gap: 1px; }
.pst-timer-label {
    font-size: 0.5rem; font-weight: 800;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: rgba(255,255,255,0.35);
}
.pst-timer-display {
    font-size: 1.35rem; font-weight: 900;
    color: #fff; letter-spacing: -0.03em;
    font-variant-numeric: tabular-nums;
    transition: color 0.3s ease;
}
.pst-timer-display.pst-warning { color: #FCD34D; }
.pst-timer-display.pst-danger  { color: #FB7185; animation: pst-blink 0.8s infinite; }
@keyframes pst-blink { 0%,100%{opacity:1} 50%{opacity:0.55} }

.pst-timer-right { display: flex; flex-direction: column; align-items: flex-end; gap: 0.35rem; }
.pst-progress-wrap { display: flex; align-items: center; gap: 0.6rem; }
.pst-progress-track {
    width: 120px; height: 4px;
    background: rgba(255,255,255,0.1);
    border-radius: 100px; overflow: hidden;
}
@media (min-width:640px) { .pst-progress-track { width: 180px; } }
.pst-progress-fill {
    height: 100%; border-radius: 100px;
    background: linear-gradient(90deg, var(--pst-teal), var(--pst-teal-lt));
    transition: width 0.25s ease, background 0.5s ease;
}
.pst-progress-fill.pst-warn-fill { background: linear-gradient(90deg,#D97706,#FCD34D); }
.pst-progress-fill.pst-danger-fill { background: linear-gradient(90deg,#DC2626,#FB7185); }
.pst-progress-label {
    font-size: 0.6rem; font-weight: 800;
    color: rgba(255,255,255,0.5);
    min-width: 44px; text-align: right;
    font-variant-numeric: tabular-nums;
}
.pst-course-info {
    display: flex; align-items: center; gap: 0.35rem;
    font-size: 0.58rem; font-weight: 600;
    color: rgba(255,255,255,0.28);
}
.pst-course-info .fas { font-size: 0.52rem; }
.pst-mins-chip {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.6rem;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, 0.12);
    background: rgba(255, 255, 255, 0.06);
    font-size: 0.55rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: rgba(255, 255, 255, 0.55);
}

.pst-header {
    background: radial-gradient(70% 70% at 15% 10%, rgba(20,168,143,0.22), rgba(20,168,143,0) 55%),
                linear-gradient(135deg, var(--pst-navy) 0%, #08162F 100%);
    padding: calc(4.25rem + var(--pst-timer-h)) 1.25rem 2.5rem;
}
.pst-header-inner {
    max-width: 900px; margin: 0 auto;
    display: flex; flex-direction: column; gap: 1.25rem;
}
.pst-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.3rem 0.85rem;
    background: rgba(201,168,76,0.14);
    border: 1px solid rgba(201,168,76,0.28);
    border-radius: 100px;
    font-size: 0.58rem; font-weight: 800;
    letter-spacing: 0.18em; text-transform: uppercase;
    color: var(--pst-gold-lt);
    width: fit-content;
}
.pst-badge .fas { font-size: 0.56rem; }
.pst-title {
    font-size: clamp(1.4rem, 3.5vw, 2rem);
    font-weight: 900; color: #fff;
    letter-spacing: -0.02em; line-height: 1.15;
    margin: 0;
}
.pst-title-accent { color: var(--pst-gold-lt); }
.pst-meta-row { display: flex; flex-wrap: wrap; gap: 0.75rem; }
.pst-meta-card {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.65rem 1rem;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 12px;
    backdrop-filter: blur(8px);
}
.pst-meta-icon {
    width: 36px; height: 36px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; flex-shrink: 0;
}
.pst-meta-label {
    font-size: 0.55rem; font-weight: 700;
    letter-spacing: 0.12em; text-transform: uppercase;
    color: rgba(255,255,255,0.38);
    margin: 0 0 2px;
}
.pst-meta-val {
    font-size: 0.9rem; font-weight: 800;
    color: #fff; margin: 0;
}

.pst-content {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1.25rem 6rem;
    display: flex; flex-direction: column; gap: 1.25rem;
}

.pst-question-card {
    background: var(--pst-white);
    border: 1px solid var(--pst-border);
    border-radius: 18px;
    padding: 1.5rem;
    box-shadow: 0 4px 16px rgba(11,30,63,0.06);
    animation: pst-fade-up 0.4s ease both;
    animation-delay: calc(var(--qi) * 60ms);
}
@keyframes pst-fade-up {
    from { opacity:0; transform:translateY(14px); }
    to   { opacity:1; transform:translateY(0); }
}
.pst-q-header { display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 1.25rem; }
.pst-q-num {
    width: 40px; height: 40px; flex-shrink: 0;
    background: linear-gradient(135deg, var(--pst-navy), var(--pst-navy-md));
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem; font-weight: 900; color: #fff;
    box-shadow: 0 8px 22px rgba(11,30,63,0.18);
}
.pst-q-text {
    font-size: 0.95rem; font-weight: 700;
    color: var(--pst-ink); line-height: 1.55;
    margin: 0; padding-top: 0.3rem;
}

.pst-options { display: grid; grid-template-columns: 1fr; gap: 0.6rem; }
@media (min-width:640px) { .pst-options { grid-template-columns: 1fr 1fr; } }

.pst-option { cursor: pointer; display: block; }
.pst-radio { display: none; }
.pst-option-inner {
    display: flex; align-items: center; gap: 0.85rem;
    padding: 0.85rem 1rem;
    background: var(--pst-surface);
    border: 2px solid var(--pst-border);
    border-radius: 12px;
    transition: all 0.2s ease;
}
.pst-option:hover .pst-option-inner {
    background: var(--pst-white);
    border-color: rgba(20,168,143,0.25);
    box-shadow: 0 4px 16px rgba(15,126,110,0.07);
}
.pst-radio:checked + .pst-option-inner {
    background: linear-gradient(135deg, var(--pst-teal), var(--pst-teal-lt));
    border-color: var(--pst-teal);
    box-shadow: 0 10px 28px rgba(15,126,110,0.22);
}
.pst-opt-letter {
    width: 32px; height: 32px; flex-shrink: 0;
    background: var(--pst-white);
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; font-weight: 800;
    color: var(--pst-teal);
    border: 1px solid var(--pst-border);
    transition: all 0.2s ease;
}
.pst-radio:checked + .pst-option-inner .pst-opt-letter {
    background: rgba(255,255,255,0.22);
    border-color: rgba(255,255,255,0.3);
    color: #fff;
}
.pst-opt-text {
    font-size: 0.82rem; font-weight: 600;
    color: var(--pst-ink); flex: 1; line-height: 1.4;
    transition: color 0.2s ease;
}
.pst-radio:checked + .pst-option-inner .pst-opt-text { color: #fff; }
.pst-opt-check {
    width: 24px; height: 24px; flex-shrink: 0;
    border: 2px solid var(--pst-border);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.6rem; color: transparent;
    transition: all 0.2s ease;
}
.pst-radio:checked + .pst-option-inner .pst-opt-check {
    background: rgba(255,255,255,0.18);
    border-color: rgba(255,255,255,0.5);
    color: #fff;
}

.pst-submit-bar {
    display: flex; flex-direction: column;
    align-items: center; gap: 1rem;
    padding: 1.5rem;
    background: var(--pst-white);
    border: 1px solid var(--pst-border);
    border-radius: 18px;
    box-shadow: 0 4px 16px rgba(11,30,63,0.06);
}
@media (min-width:640px) { .pst-submit-bar { flex-direction: row; justify-content: space-between; } }
.pst-submit-note {
    display: flex; align-items: center; gap: 0.65rem;
    font-size: 0.72rem; font-weight: 600;
    color: var(--pst-muted); line-height: 1.5;
}
.pst-submit-note .fas { color: var(--pst-teal); font-size: 1rem; flex-shrink: 0; }
.pst-submit-btn {
    display: inline-flex; align-items: center; gap: 0.6rem;
    padding: 0.85rem 2rem;
    background: linear-gradient(135deg, var(--pst-navy), var(--pst-navy-md));
    color: #fff; border: none; border-radius: 12px;
    font-size: 0.7rem; font-weight: 800;
    letter-spacing: 0.12em; text-transform: uppercase;
    cursor: pointer; white-space: nowrap;
    box-shadow: 0 10px 28px rgba(11,30,63,0.24);
    transition: all 0.25s ease;
}
.pst-submit-btn:hover {
    background: linear-gradient(135deg, #0E2B59, #173063);
    transform: translateY(-1px);
    box-shadow: 0 14px 36px rgba(11,30,63,0.32);
}
.pst-submit-btn:active { transform: scale(0.97); }

.pst-modal {
    position: fixed; inset: 0; z-index: 99999;
    background: rgba(0,0,0,0.65);
    backdrop-filter: blur(6px);
    display: flex; align-items: center; justify-content: center;
    padding: 1rem;
}
.pst-modal-box {
    background: #fff; border-radius: 24px;
    padding: 2.5rem 2rem; max-width: 400px; width: 100%;
    text-align: center;
    box-shadow: 0 32px 80px rgba(0,0,0,0.3);
    animation: pst-pop 0.4s cubic-bezier(0.34,1.56,0.64,1) both;
}
@keyframes pst-pop { from { transform: scale(0.85); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.pst-modal-icon {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, var(--pst-navy), var(--pst-navy-md));
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem; color: #fff;
    margin: 0 auto 1.25rem;
    box-shadow: 0 12px 28px rgba(11,30,63,0.24);
}
.pst-modal-title { font-size: 1.4rem; font-weight: 900; color: var(--pst-ink); margin: 0 0 0.5rem; }
.pst-modal-body { font-size: 0.82rem; color: var(--pst-muted); line-height: 1.65; margin: 0 0 1.5rem; }
.pst-modal-spinner { display: flex; align-items: center; justify-content: center; gap: 0.65rem; font-size: 0.75rem; font-weight: 700; color: var(--pst-muted); }
.pst-spinner {
    width: 22px; height: 22px;
    border: 3px solid var(--pst-border);
    border-top-color: var(--pst-navy);
    border-radius: 50%;
    animation: pst-spin 0.7s linear infinite;
}
@keyframes pst-spin { to { transform: rotate(360deg); } }
</style>

<script>
(function () {
    const formEl = document.getElementById('pst-form');
    const TOTAL_SECONDS = Number(formEl?.dataset?.totalSeconds || '0');
    const courseId = Number(formEl?.dataset?.courseId || '0');
    const questionCount = Number(formEl?.dataset?.questionCount || '0');
    const storageKey = 'posttest_end_' + courseId;
    const now = Date.now();
    const storedEnd = Number(sessionStorage.getItem(storageKey) || '0');
    const endTime = storedEnd > now ? storedEnd : (now + (TOTAL_SECONDS * 1000));
    sessionStorage.setItem(storageKey, String(endTime));

    const displayEl = document.getElementById('pst-timer-display');
    const fillEl = document.getElementById('pst-progress-fill');
    const labelEl = document.getElementById('pst-progress-label');
    const modalEl = document.getElementById('pst-timeout-modal');
    const hourglassEl = document.getElementById('pst-hourglass-icon');
    const timeoutInputEl = document.getElementById('pst-is-timeout');
    const minsChipEl = document.getElementById('pst-mins-chip');

    let allowLeave = false;
    let lastWarnAt = 0;
    const warnText = 'Kamu sedang mengerjakan Post Test. Selesaikan terlebih dahulu untuk keluar dari halaman ini.';

    function warnOnce() {
        const now = Date.now();
        if (now - lastWarnAt < 1500) return;
        lastWarnAt = now;
        alert(warnText);
    }

    function beforeUnload(e) {
        if (allowLeave) return;
        e.preventDefault();
        e.returnValue = '';
        return '';
    }

    function setupGuards() {
        history.pushState({ pst_lock: true }, '', location.href);
        window.addEventListener('popstate', function () {
            if (allowLeave) return;
            history.pushState({ pst_lock: true }, '', location.href);
            warnOnce();
        });

        window.addEventListener('beforeunload', beforeUnload);

        document.addEventListener('click', function (e) {
            if (allowLeave) return;
            const a = e.target.closest('a');
            if (!a) return;
            e.preventDefault();
            e.stopPropagation();
            warnOnce();
        }, true);

        document.addEventListener('turbo:before-visit', function (e) {
            if (allowLeave) return;
            e.preventDefault();
            warnOnce();
        });
    }

    function formatTime(s) {
        const m = Math.floor(s / 60);
        const sec = s % 60;
        return String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
    }

    function computeRemaining() {
        const diff = Math.floor((endTime - Date.now()) / 1000);
        return Math.max(0, diff);
    }

    function answeredCount() {
        return document.querySelectorAll('#pst-form input[type="radio"]:checked').length;
    }

    function updateUI() {
        const remaining = computeRemaining();
        const answered = answeredCount();
        const pct = questionCount > 0 ? Math.max(0, (answered / questionCount) * 100) : 0;
        const remainingMinutes = Math.max(0, Math.ceil(remaining / 60));

        displayEl.textContent = formatTime(remaining);
        if (minsChipEl) minsChipEl.textContent = 'Sisa ' + remainingMinutes + ' menit';
        fillEl.style.width = pct + '%';
        labelEl.textContent = answered + '/' + questionCount;

        displayEl.classList.remove('pst-warning', 'pst-danger');
        fillEl.classList.remove('pst-warn-fill', 'pst-danger-fill');

        if (remaining <= 60) {
            displayEl.classList.add('pst-danger');
            fillEl.classList.add('pst-danger-fill');
            hourglassEl.className = 'fas fa-hourglass-end';
        } else if (remaining <= Math.max(120, Math.floor(TOTAL_SECONDS * 0.25))) {
            displayEl.classList.add('pst-warning');
            fillEl.classList.add('pst-warn-fill');
            hourglassEl.className = 'fas fa-hourglass-half';
        } else {
            hourglassEl.className = 'fas fa-hourglass-start';
        }
    }

    function tick() {
        if (computeRemaining() <= 0) {
            clearInterval(timer);
            updateUI();
            timeoutInputEl.value = '1';
            allowLeave = true;
            modalEl.style.display = 'flex';
            setTimeout(function () { formEl.submit(); }, 2000);
            return;
        }
        updateUI();
    }

    setupGuards();
    updateUI();
    const timer = setInterval(tick, 1000);

    formEl.addEventListener('submit', function () {
        allowLeave = true;
        window.removeEventListener('beforeunload', beforeUnload);
        sessionStorage.removeItem(storageKey);
        const btn = document.getElementById('pst-submit-btn');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<div class="pst-spinner" style="width:16px;height:16px;border-width:2px;margin-right:0.5rem;"></div> Mengirim...';
        }
    });

    formEl.addEventListener('change', function () {
        updateUI();
    });
})();
</script>
@endsection
