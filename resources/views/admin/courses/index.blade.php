@extends('layouts.app')

@section('content')

<style>
:root {
    --c-navy:     #0B1E3F;
    --c-navy-md:  #122247;
    --c-red:      #C0111E;
    --c-gold:     #C9A84C;
    --c-gold-lt:  #E2C471;
    --c-teal:     #0F7E6E;
    --c-teal-lt:  #14A88F;
    --c-blue:     #1E40AF;
    --c-ink:      #111827;
    --c-muted:    #6B7280;
    --c-border:   #E5E7EB;
    --c-surface:  #F9FAFB;
    --c-white:    #FFFFFF;
    --font-body:    'DM Sans', 'Plus Jakarta Sans', sans-serif;
    --font-display: 'Playfair Display', Georgia, serif;
    --font-mono:    'JetBrains Mono', monospace;
}

.cp-root {
    padding-bottom: 5rem;
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

/* ══════════════════════════════════════════════
   HEADER BAND
══════════════════════════════════════════════ */
.cp-header {
    position: relative;
    background: var(--c-navy);
    border-radius: 2px;
    overflow: hidden;
    padding: 2.25rem 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.cp-header::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(rgba(201,168,76,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(201,168,76,0.06) 1px, transparent 1px);
    background-size: 48px 48px;
    pointer-events: none;
}
.cp-header::after {
    content: '';
    position: absolute;
    top: 0; left: 0; bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, var(--c-teal), rgba(15,126,110,0.3));
}
.cp-header-stripe {
    position: absolute;
    top: -20px; right: 100px;
    width: 200px; height: 200%;
    background: rgba(255,255,255,0.015);
    transform: skewX(-20deg);
    pointer-events: none;
}

.cp-header-left {
    position: relative;
    z-index: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}
.cp-header-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-family: var(--font-mono);
    font-size: 0.55rem;
    font-weight: 600;
    letter-spacing: 0.22em;
    color: var(--c-gold);
    text-transform: uppercase;
}
.cp-header-eyebrow-dot {
    width: 4px; height: 4px;
    background: var(--c-gold);
    border-radius: 50%;
}
.cp-header-title {
    font-family: var(--font-display);
    font-size: clamp(1.6rem, 3vw, 2.5rem);
    font-weight: 900;
    color: var(--c-white);
    line-height: 1.1;
}
.cp-header-title em {
    font-style: normal;
    color: var(--c-gold);
}
.cp-header-sub {
    font-size: 0.75rem;
    font-weight: 400;
    color: rgba(255,255,255,0.45);
    letter-spacing: 0.01em;
    max-width: 420px;
    margin-top: 0.1rem;
}

.cp-header-right {
    position: relative;
    z-index: 1;
}
.cp-add-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.85rem 2rem;
    background: var(--c-teal);
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
    box-shadow: 0 4px 20px rgba(15,126,110,0.35);
    white-space: nowrap;
}
.cp-add-btn:hover {
    background: var(--c-teal-lt);
    box-shadow: 0 6px 28px rgba(15,126,110,0.5);
    transform: translateY(-1px);
}

/* ══════════════════════════════════════════════
   COURSE GRID
══════════════════════════════════════════════ */
.cp-grid {
    display: grid;
    grid-template-columns: repeat(1, 1fr);
    gap: 2rem;
}
@media (min-width: 640px) { .cp-grid { grid-template-columns: repeat(2, 1fr); } }
@media (min-width: 1024px) { .cp-grid { grid-template-columns: repeat(3, 1fr); } }

.cp-card {
    background: var(--c-white);
    border: 1px solid var(--c-border);
    border-radius: 2px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    box-shadow: 0 4px 24px rgba(11,30,63,0.05);
}
.cp-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 48px rgba(11,30,63,0.1);
    border-color: rgba(11,30,63,0.15);
}

.cp-card-img-wrap {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: var(--c-navy);
}
.cp-card-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}
.cp-card:hover .cp-card-img { transform: scale(1.08); }
.cp-card-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(11,30,63,0.85), transparent);
}

.cp-card-badges {
    position: absolute;
    top: 1rem; left: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    z-index: 2;
}
.cp-badge {
    padding: 0.25rem 0.65rem;
    border-radius: 2px;
    font-size: 0.5rem;
    font-weight: 700;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: white;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,0.15);
}

.cp-card-title {
    position: absolute;
    bottom: 1.25rem; left: 1.25rem; right: 1.25rem;
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 700;
    color: white;
    line-height: 1.3;
    z-index: 2;
}

.cp-card-body {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.cp-card-meta {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.5rem;
    align-items: center;
}
.cp-meta-item {
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
.cp-meta-icon {
    width: 32px; height: 32px;
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
    color: var(--c-muted);
}
.cp-meta-text {
    display: flex;
    flex-direction: column;
}
.cp-meta-val {
    font-family: var(--font-mono);
    font-size: 0.85rem;
    font-weight: 600;
    color: var(--c-navy);
    line-height: 1;
}
.cp-meta-label {
    font-size: 0.48rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: var(--c-muted);
    text-transform: uppercase;
}

.cp-card-actions {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.5rem;
}
.cp-action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.35rem;
    padding: 0.75rem 0.25rem;
    border: 1px solid var(--c-border);
    border-radius: 2px;
    background: var(--c-surface);
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    color: var(--c-muted);
    text-transform: uppercase;
    text-decoration: none;
    transition: all 0.2s ease;
    text-align: center;
}
.cp-action-btn:hover {
    background: white;
    color: var(--c-navy);
    border-color: var(--c-navy-md);
    box-shadow: 0 4px 12px rgba(11,30,63,0.08);
}

.cp-card-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--c-border);
    display: flex;
    gap: 0.75rem;
}
.cp-footer-btn {
    flex: 1;
    padding: 0.6rem;
    border: 1px solid var(--c-border);
    border-radius: 2px;
    background: var(--c-white);
    font-size: 0.6rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s ease;
}
.cp-btn-edit:hover { color: var(--c-teal); border-color: var(--c-teal); background: rgba(15,126,110,0.04); }
.cp-btn-del:hover  { color: var(--c-red);  border-color: var(--c-red);  background: rgba(192,17,30,0.04); }

/* ══════════════════════════════════════════════
   MODALS
══════════════════════════════════════════════ */
.cp-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(11,30,63,0.65);
    backdrop-filter: blur(6px);
    z-index: 100;
    display: flex;
    align-items: flex-end;
    justify-content: center;
}
@media (min-width: 640px) { .cp-modal-backdrop { align-items: center; padding: 1.5rem; } }
.cp-modal-backdrop.hidden { display: none; }

.cp-modal {
    background: var(--c-white);
    width: 100%;
    max-width: 520px;
    border-radius: 2px 2px 0 0;
    display: flex;
    flex-direction: column;
    max-height: 92vh;
    box-shadow: 0 -8px 40px rgba(11,30,63,0.15);
}
@media (min-width: 640px) { .cp-modal { border-radius: 2px; } }

.cp-modal-head {
    background: var(--c-navy);
    padding: 1.1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.cp-modal-title {
    font-family: var(--font-display);
    font-size: 1.1rem;
    font-weight: 700;
    color: white;
}
.cp-modal-close {
    width: 32px; height: 32px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255,255,255,0.6);
    cursor: pointer;
}

.cp-modal-body {
    padding: 1.5rem;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
.cp-field { display: flex; flex-direction: column; gap: 0.4rem; }
.cp-label {
    font-size: 0.52rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    color: var(--c-muted);
    text-transform: uppercase;
}
.cp-input {
    width: 100%;
    padding: 0.8rem 1rem;
    background: var(--c-surface);
    border: 1px solid var(--c-border);
    border-radius: 2px;
    font-family: var(--font-body);
    font-size: 0.82rem;
    font-weight: 500;
    outline: none;
}
.cp-input:focus { border-color: var(--c-teal); background: white; }

.cp-modal-foot {
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--c-border);
    background: var(--c-surface);
}
.cp-submit-btn {
    width: 100%;
    padding: 0.85rem;
    background: var(--c-teal);
    color: white;
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.15em;
    text-transform: uppercase;
    border: none;
    border-radius: 2px;
    cursor: pointer;
}
</style>

<div class="cp-root">

    {{-- ═══ HEADER BAND ════════════════════════════ --}}
    <div class="cp-header">
        <div class="cp-header-stripe"></div>
        <div class="cp-header-left">
            <div class="cp-header-eyebrow">
                <span class="cp-header-eyebrow-dot"></span>
                Manajemen Kurikulum
            </div>
            <h1 class="cp-header-title">
                Kelola <em>Modul</em><br>Pembelajaran
            </h1>
            <p class="cp-header-sub">
                Pengaturan materi edukasi gizi nasional dan kuis sertifikasi untuk peserta program.
            </p>
        </div>

        <div class="cp-header-right">
            <button onclick="openAddModal()" class="cp-add-btn">
                <i class="fas fa-plus-circle"></i>
                Tambah Kursus
            </button>
        </div>
    </div>

    @if($errors->any())
    <div style="background:#FEF2F2; border:1px solid #FCA5A5; padding:1rem; border-radius:2px;">
        <ul style="font-size:0.75rem; color:#B91C1C; font-weight:600;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ═══ COURSE GRID ═════════════════════════════ --}}
    <div class="cp-grid">
        @foreach($courses as $course)
        <div class="cp-card">
            <div class="cp-card-img-wrap">
                <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?q=80&w=2070&auto=format&fit=crop' }}" 
                     class="cp-card-img" alt="{{ $course->title }}">
                <div class="cp-card-overlay"></div>
                
                <div class="cp-card-badges">
                    @if($course->type)
                    @php
                        $bgColor = match($course->type->color) {
                            'green' => '#10B981',
                            'red'   => '#EF4444',
                            'blue'  => '#3B82F6',
                            default => 'var(--c-teal)',
                        };
                    @endphp
                    <span class="cp-badge" @style(['background' => $bgColor])>
                        {{ $course->type->name }}
                    </span>
                    @endif
                    @if($course->label)
                    <span class="cp-badge" style="background: rgba(255,255,255,0.15)">{{ $course->label }}</span>
                    @endif
                </div>

                <h3 class="cp-card-title">{{ $course->title }}</h3>
            </div>

            <div class="cp-card-body">
                <div class="cp-card-meta">
                    <div class="cp-meta-item">
                        <div class="cp-meta-icon"><i class="fas fa-list-ol"></i></div>
                        <div class="cp-meta-text">
                            <span class="cp-meta-val">{{ $course->lessons->count() }}</span>
                            <span class="cp-meta-label">Bab Materi</span>
                        </div>
                    </div>
                    <div class="cp-meta-item">
                        <div class="cp-meta-icon"><i class="fas fa-file-signature"></i></div>
                        <div class="cp-meta-text">
                            <span class="cp-meta-val">{{ $course->preQuestions->count() }}</span>
                            <span class="cp-meta-label">Soal Pre-Test</span>
                        </div>
                    </div>
                    <div class="cp-meta-item">
                        <div class="cp-meta-icon"><i class="fas fa-tasks"></i></div>
                        <div class="cp-meta-text">
                            <span class="cp-meta-val">{{ $course->postQuestions->count() }}</span>
                            <span class="cp-meta-label">Soal Post-Test</span>
                        </div>
                    </div>
                </div>
                
                <div class="cp-card-actions">
                    <a href="{{ route('admin.pre_questions.index', $course->id) }}" class="cp-action-btn">
                        <i class="fas fa-file-signature text-[0.8rem]"></i>
                        Pre Test
                    </a>
                    <a href="{{ route('admin.lessons.index', $course->id) }}" class="cp-action-btn">
                        <i class="fas fa-book-reader text-[0.8rem]"></i>
                        Materi
                    </a>
                    <a href="{{ route('admin.questions.index', $course->id) }}" class="cp-action-btn">
                        <i class="fas fa-poll text-[0.8rem]"></i>
                        Post Test
                    </a>
                </div>
            </div>

            <div class="cp-card-footer">
                <button onclick="editCourse(this)" 
                        data-id="{{ $course->id }}" 
                        data-title="{{ $course->title }}" 
                        data-description="{{ $course->description }}"
                        data-school_id="{{ $course->school_id }}"
                        data-course_type_id="{{ $course->course_type_id }}"
                        data-label="{{ $course->label }}"
                        data-thumbnail="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : '' }}"
                        class="cp-footer-btn cp-btn-edit">EDIT</button>
                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="flex:1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kursus ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="cp-footer-btn cp-btn-del" style="width:100%">HAPUS</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- ═══ MODALS ══════════════════════════════════ --}}
<!-- Add Modal -->
<div id="addModal" class="cp-modal-backdrop hidden">
    <div class="cp-modal">
        <div class="cp-modal-head">
            <h2 class="cp-modal-title">Tambah Kursus</h2>
            <div onclick="closeAddModal()" class="cp-modal-close"><i class="fas fa-times"></i></div>
        </div>
        <div class="cp-modal-body">
            <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data" id="addForm" class="flex flex-col gap-5">
                @csrf
                <div class="cp-field">
                    <label class="cp-label">Judul Kursus</label>
                    <input type="text" name="title" required class="cp-input" placeholder="Masukkan judul materi">
                </div>
                <div class="cp-field">
                    <label class="cp-label">Deskripsi</label>
                    <textarea name="description" rows="3" class="cp-input" placeholder="Deskripsi materi"></textarea>
                </div>
                <div class="cp-field">
                    <label class="cp-label">Tipe Kursus</label>
                    <select name="course_type_id" required class="cp-input">
                        @foreach($courseTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cp-field">
                    <label class="cp-label">Label (Opsional)</label>
                    <input type="text" name="label" class="cp-input" placeholder="Contoh: Terpopuler, Baru, dll.">
                </div>
                <div class="cp-field">
                    <label class="cp-label">Target Sekolah</label>
                    <select name="school_id" class="cp-input">
                        <option value="">Semua Sekolah (Umum)</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cp-field">
                    <label class="cp-label">Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" class="cp-input" style="padding:0.4rem" onchange="checkFileSize(this)">
                    <small id="fileSizeError" style="color:var(--c-red); font-size:0.6rem; display:none;">File terlalu besar (Maksimal 5MB)</small>
                </div>
            </form>
        </div>
        <div class="cp-modal-foot">
            <button type="submit" form="addForm" class="cp-submit-btn">Simpan Materi</button>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="cp-modal-backdrop hidden">
    <div class="cp-modal">
        <div class="cp-modal-head">
            <h2 class="cp-modal-title">Edit Kursus</h2>
            <div onclick="closeEditModal()" class="cp-modal-close"><i class="fas fa-times"></i></div>
        </div>
        <div class="cp-modal-body">
            <form id="editForm" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5">
                @csrf
                @method('PUT')
                <div class="cp-field">
                    <label class="cp-label">Judul Kursus</label>
                    <input type="text" name="title" id="editTitle" required class="cp-input">
                </div>
                <div class="cp-field">
                    <label class="cp-label">Deskripsi</label>
                    <textarea name="description" id="editDescription" rows="3" class="cp-input"></textarea>
                </div>
                <div class="cp-field">
                    <label class="cp-label">Tipe Kursus</label>
                    <select name="course_type_id" id="editCourseTypeId" required class="cp-input">
                        @foreach($courseTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cp-field">
                    <label class="cp-label">Label</label>
                    <input type="text" name="label" id="editLabel" class="cp-input">
                </div>
                <div class="cp-field">
                    <label class="cp-label">Sekolah</label>
                    <select name="school_id" id="editSchoolId" class="cp-input">
                        <option value="">Semua Sekolah</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="cp-field">
                    <label class="cp-label">Thumbnail Baru</label>
                    <input type="file" name="thumbnail" accept="image/*" class="cp-input" style="padding:0.4rem" onchange="checkFileSizeEdit(this)">
                    <small id="fileSizeErrorEdit" style="color:var(--c-red); font-size:0.6rem; display:none;">File terlalu besar (Maksimal 5MB)</small>
                </div>
            </form>
        </div>
        <div class="cp-modal-foot">
            <button type="submit" form="editForm" class="cp-submit-btn">Update Materi</button>
        </div>
    </div>
</div>

<script>
function openAddModal() { document.getElementById('addModal').classList.remove('hidden'); }
function closeAddModal() { document.getElementById('addModal').classList.add('hidden'); }

function checkFileSize(input) {
    const errorMsg = document.getElementById('fileSizeError');
    const submitBtn = document.querySelector('button[form="addForm"]');
    
    if (input.files && input.files[0]) {
        const fileSize = input.files[0].size / 1024 / 1024; // in MB
        if (fileSize > 5) {
            errorMsg.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
        } else {
            errorMsg.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        }
    }
}

function checkFileSizeEdit(input) {
    const errorMsg = document.getElementById('fileSizeErrorEdit');
    const submitBtn = document.querySelector('button[form="editForm"]');
    
    if (input.files && input.files[0]) {
        const fileSize = input.files[0].size / 1024 / 1024; // in MB
        if (fileSize > 5) {
            errorMsg.style.display = 'block';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
        } else {
            errorMsg.style.display = 'none';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        }
    }
}

function editCourse(btn) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    
    form.action = `/admin/courses/${btn.dataset.id}`;
    document.getElementById('editTitle').value = btn.dataset.title;
    document.getElementById('editDescription').value = btn.dataset.description;
    document.getElementById('editCourseTypeId').value = btn.dataset.course_type_id;
    document.getElementById('editLabel').value = btn.dataset.label;
    document.getElementById('editSchoolId').value = btn.dataset.school_id || '';
    
    modal.classList.remove('hidden');
}

function closeEditModal() { document.getElementById('editModal').classList.add('hidden'); }

window.onclick = function(e) {
    if (e.target.classList.contains('cp-modal-backdrop')) {
        closeAddModal();
        closeEditModal();
    }
}
</script>
@endsection
