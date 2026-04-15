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

/* ── Header ───────────────────────────────────── */
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
    max-width: 500px;
    margin-top: 0.1rem;
}

.cp-header-right {
    position: relative;
    z-index: 1;
    display: flex;
    gap: 1rem;
}
.cp-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.65rem;
    padding: 0.85rem 1.5rem;
    font-family: var(--font-body);
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 0.14em;
    text-transform: uppercase;
    border: none;
    border-radius: 2px;
    cursor: pointer;
    transition: all 0.2s ease;
    white-space: nowrap;
}
.cp-btn-back {
    background: rgba(255,255,255,0.05);
    color: rgba(255,255,255,0.6);
    border: 1px solid rgba(255,255,255,0.1);
}
.cp-btn-back:hover {
    background: rgba(255,255,255,0.1);
    color: white;
}
.cp-btn-add {
    background: var(--c-teal);
    color: white;
    box-shadow: 0 4px 20px rgba(15,126,110,0.35);
}
.cp-btn-add:hover {
    background: var(--c-teal-lt);
    box-shadow: 0 6px 28px rgba(15,126,110,0.5);
    transform: translateY(-1px);
}

/* ── Table ────────────────────────────────────── */
.cp-table-wrap {
    background: var(--c-white);
    border: 1px solid var(--c-border);
    border-radius: 2px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(11,30,63,0.05);
}
.cp-table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
}
.cp-table th {
    background: var(--c-surface);
    padding: 1.25rem 1.5rem;
    font-size: 0.55rem;
    font-weight: 700;
    letter-spacing: 0.2em;
    color: var(--c-muted);
    text-transform: uppercase;
    border-bottom: 1px solid var(--c-border);
}
.cp-table td {
    padding: 1.5rem;
    border-bottom: 1px solid var(--c-surface);
    vertical-align: middle;
}
.cp-table tr:last-child td { border-bottom: none; }
.cp-table tr:hover td { background: var(--c-surface); }

.cp-td-no {
    font-family: var(--font-mono);
    font-size: 0.75rem;
    color: var(--c-muted);
    width: 60px;
}
.cp-td-order { width: 100px; }
.cp-order-badge {
    display: inline-flex;
    padding: 0.35rem 0.85rem;
    background: var(--c-navy);
    color: var(--c-gold);
    font-family: var(--font-mono);
    font-size: 0.6rem;
    font-weight: 600;
    border-radius: 2px;
    letter-spacing: 0.1em;
}
.cp-td-title { font-weight: 600; color: var(--c-navy); font-size: 0.95rem; }
.cp-td-video {
    font-size: 0.75rem;
    color: var(--c-muted);
    max-width: 250px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.cp-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
}
.cp-action-btn {
    width: 34px; height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--c-border);
    border-radius: 2px;
    background: var(--c-white);
    color: var(--c-muted);
    cursor: pointer;
    transition: all 0.2s ease;
}
.cp-btn-edit:hover { color: var(--c-teal); border-color: var(--c-teal); background: rgba(15,126,110,0.04); }
.cp-btn-del:hover  { color: var(--c-red);  border-color: var(--c-red);  background: rgba(192,17,30,0.04); }

.cp-upload-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.55rem 0.9rem;
    border-radius: 2px;
    border: 1px solid rgba(11, 30, 63, 0.12);
    background: rgba(11, 30, 63, 0.04);
    color: var(--c-navy);
    font-size: 0.6rem;
    font-weight: 800;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s ease;
}
.cp-upload-btn:hover {
    background: rgba(15, 126, 110, 0.08);
    border-color: rgba(15, 126, 110, 0.25);
    color: var(--c-teal);
}

/* ── Mobile Cards ─────────────────────────────── */
.cp-mobile-grid { display: none; flex-direction: column; gap: 1.25rem; }
.cp-m-card {
    background: var(--c-white);
    border: 1px solid var(--c-border);
    border-radius: 2px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}
@media (max-width: 767px) {
    .cp-table-wrap { display: none; }
    .cp-mobile-grid { display: flex; }
}

/* ── Modals ───────────────────────────────────── */
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
    max-width: 640px;
    border-radius: 2px 2px 0 0;
    display: flex;
    flex-direction: column;
    max-height: 92vh;
}
@media (min-width: 640px) { .cp-modal { border-radius: 2px; } }

.cp-modal-head {
    background: var(--c-navy);
    padding: 1.1rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.cp-modal-title { font-family: var(--font-display); font-size: 1.1rem; font-weight: 700; color: white; }
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

.cp-modal-body { padding: 1.5rem; overflow-y: auto; display: flex; flex-direction: column; gap: 1.25rem; }
.cp-field { display: flex; flex-direction: column; gap: 0.4rem; }
.cp-label { font-size: 0.52rem; font-weight: 700; letter-spacing: 0.2em; color: var(--c-muted); text-transform: uppercase; }
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

.cp-modal-foot { padding: 1rem 1.5rem; border-top: 1px solid var(--c-border); background: var(--c-surface); }
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

    {{-- ═══ HEADER ═════════════════════════════════ --}}
    <div class="cp-header">
        <div class="cp-header-stripe"></div>
        <div class="cp-header-left">
            <div class="cp-header-eyebrow">
                <span class="cp-header-eyebrow-dot"></span>
                Manajemen Materi
            </div>
            <h1 class="cp-header-title">
                Kelola <em>Bab</em><br>Pembelajaran
            </h1>
            <p class="cp-header-sub">
                Materi untuk: <span style="color:var(--c-gold); font-weight:700;">{{ $course->title }}</span>
            </p>
        </div>

        <div class="cp-header-right">
            <a href="{{ route('admin.courses.index') }}" class="cp-btn cp-btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button onclick="openAddModal()" class="cp-btn cp-btn-add">
                <i class="fas fa-plus-circle"></i> Tambah Bab
            </button>
        </div>
    </div>

    {{-- ═══ DESKTOP TABLE ═══════════════════════════ --}}
    <div class="cp-table-wrap">
        <table class="cp-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Urutan</th>
                    <th>Judul Bab</th>
                    <th>Video URL</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lessons as $lesson)
                <tr>
                    <td class="cp-td-no">{{ $loop->iteration }}</td>
                    <td class="cp-td-order">
                        <span class="cp-order-badge">BAB {{ $lesson->order_number }}</span>
                    </td>
                    <td class="cp-td-title">{{ $lesson->title }}</td>
                    <td class="cp-td-video">{{ $lesson->video_url ?? '—' }}</td>
                    <td>
                        <div class="cp-actions">
                            <button onclick="editLesson(this)" 
                                    data-id="{{ $lesson->id }}" 
                                    data-title="{{ $lesson->title }}" 
                                    data-order="{{ $lesson->order_number }}" 
                                    data-video="{{ $lesson->video_url }}" 
                                    data-content="{{ $lesson->content }}"
                                    class="cp-action-btn cp-btn-edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" onsubmit="return confirm('Hapus bab ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="cp-action-btn cp-btn-del">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; padding:5rem; color:var(--c-muted); font-size:0.8rem; font-weight:600; letter-spacing:0.05em;">
                        Belum ada data materi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ═══ MOBILE CARDS ════════════════════════════ --}}
    <div class="cp-mobile-grid">
        @foreach($lessons as $lesson)
        <div class="cp-m-card">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <span class="cp-order-badge">BAB {{ $lesson->order_number }}</span>
                <span style="font-family:var(--font-mono); font-size:0.7rem; color:var(--c-muted);">#{{ $loop->iteration }}</span>
            </div>
            <h4 style="font-weight:700; color:var(--c-navy); font-size:1.1rem; line-height:1.3;">{{ $lesson->title }}</h4>
            <div style="font-size:0.75rem; color:var(--c-muted); display:flex; align-items:center; gap:0.5rem;">
                <i class="fab fa-youtube"></i> {{ $lesson->video_url ?? 'No video' }}
            </div>
            <div style="display:flex; gap:0.75rem; padding-top:0.5rem; border-top:1px solid var(--c-surface);">
                <button onclick="editLesson(this)" 
                        data-id="{{ $lesson->id }}" 
                        data-title="{{ $lesson->title }}" 
                        data-order="{{ $lesson->order_number }}" 
                        data-video="{{ $lesson->video_url }}" 
                        data-content='@json($lesson->content)'
                        class="cp-btn cp-btn-back" style="flex:1; justify-content:center; padding:0.6rem; color:var(--c-teal);">
                    EDIT
                </button>
                <form action="{{ route('admin.lessons.destroy', $lesson->id) }}" method="POST" style="flex:1;">
                    @csrf @method('DELETE')
                    <button type="submit" class="cp-btn cp-btn-back" style="width:100%; justify-content:center; padding:0.6rem; color:var(--c-red);">
                        HAPUS
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

</div>

{{-- ═══ MODALS ══════════════════════════════════ --}}
<div id="addModal" class="cp-modal-backdrop hidden">
    <div class="cp-modal">
        <div class="cp-modal-head">
            <h2 class="cp-modal-title">Tambah Bab</h2>
            <div onclick="closeAddModal()" class="cp-modal-close"><i class="fas fa-times"></i></div>
        </div>
        <div class="cp-modal-body">
            <form action="{{ route('admin.lessons.store', $course->id) }}" method="POST" id="addForm">
                @csrf
                <div style="display:grid; grid-template-columns:1fr 80px; gap:1rem;">
                    <div class="cp-field">
                        <label class="cp-label">Judul Bab</label>
                        <input type="text" name="title" required class="cp-input" placeholder="Judul materi">
                    </div>
                    <div class="cp-field">
                        <label class="cp-label">Order</label>
                        <input type="number" name="order_number" value="{{ $lessons->count() + 1 }}" required class="cp-input">
                    </div>
                </div>
                <div class="cp-field" style="margin-top:1.25rem;">
                    <label class="cp-label">Video URL (YT)</label>
                    <input type="url" name="video_url" class="cp-input" placeholder="https://youtube.com/...">
                </div>
                <div class="cp-field" style="margin-top:1.25rem;">
                    <label class="cp-label" style="margin:0;">Isi Materi</label>
                    <textarea name="content" id="addContent" rows="10" class="cp-input" placeholder="Tulis materi di sini..."></textarea>
                </div>
            </form>
        </div>
        <div class="cp-modal-foot">
            <button type="submit" form="addForm" class="cp-submit-btn">Simpan Bab</button>
        </div>
    </div>
</div>

<div id="editModal" class="cp-modal-backdrop hidden">
    <div class="cp-modal">
        <div class="cp-modal-head">
            <h2 class="cp-modal-title">Edit Bab</h2>
            <div onclick="closeEditModal()" class="cp-modal-close"><i class="fas fa-times"></i></div>
        </div>
        <div class="cp-modal-body">
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div style="display:grid; grid-template-columns:1fr 80px; gap:1rem;">
                    <div class="cp-field">
                        <label class="cp-label">Judul Bab</label>
                        <input type="text" name="title" id="editTitle" required class="cp-input">
                    </div>
                    <div class="cp-field">
                        <label class="cp-label">Order</label>
                        <input type="number" name="order_number" id="editOrderNumber" required class="cp-input">
                    </div>
                </div>
                <div class="cp-field" style="margin-top:1.25rem;">
                    <label class="cp-label">Video URL</label>
                    <input type="url" name="video_url" id="editVideoUrl" class="cp-input">
                </div>
                <div class="cp-field" style="margin-top:1.25rem;">
                    <label class="cp-label" style="margin:0;">Isi Materi</label>
                    <textarea name="content" id="editContent" rows="10" class="cp-input"></textarea>
                </div>
            </form>
        </div>
        <div class="cp-modal-foot">
            <button type="submit" form="editForm" class="cp-submit-btn">Update Bab</button>
        </div>
    </div>
</div>

<div id="lessonEditorConfig" data-upload-url="{{ route('admin.lessons.upload-image') }}" style="display:none;"></div>

<script src="https://cdn.jsdelivr.net/npm/tinymce@6/tinymce.min.js"></script>
<script>
function openAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
    const editor = window.tinymce?.get('addContent');
    if (editor) editor.setContent('');
}
function closeAddModal() { document.getElementById('addModal').classList.add('hidden'); }

function initLessonEditors() {
    const uploadUrl = document.getElementById('lessonEditorConfig')?.dataset?.uploadUrl || '';
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    if (!window.tinymce) return;
    if (window.tinymce.get('addContent') || window.tinymce.get('editContent')) return;

    async function compressImageBlob(blob) {
        try {
            if (!blob || !blob.type?.startsWith('image/')) return blob;
            if (blob.size <= 900 * 1024) return blob;

            const maxDim = 1600;
            const quality = 0.82;

            if ('createImageBitmap' in window) {
                const bmp = await createImageBitmap(blob);
                const scale = Math.min(1, maxDim / Math.max(bmp.width, bmp.height));
                if (scale >= 1 && blob.size <= 1400 * 1024) return blob;

                const w = Math.max(1, Math.round(bmp.width * scale));
                const h = Math.max(1, Math.round(bmp.height * scale));
                const canvas = document.createElement('canvas');
                canvas.width = w;
                canvas.height = h;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(bmp, 0, 0, w, h);

                const out = await new Promise((resolve) => canvas.toBlob(resolve, 'image/jpeg', quality));
                return out || blob;
            }

            return blob;
        } catch (e) {
            return blob;
        }
    }

    window.tinymce.init({
        selector: '#addContent,#editContent',
        height: 360,
        menubar: false,
        branding: false,
        resize: true,
        toolbar_mode: 'wrap',
        plugins: 'lists advlist link image table code autoresize',
        toolbar: 'undo redo | blocks | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent | link image table | removeformat | code',
        lists_indent_on_tab: true,
        setup: function (editor) {
            editor.on('keydown', function (e) {
                if (e.key !== 'Tab') return;
                const node = editor.selection.getNode();
                const li = editor.dom.getParent(node, 'li');
                if (!li) return;
                e.preventDefault();
                editor.execCommand(e.shiftKey ? 'Outdent' : 'Indent');
            });
        },
        content_style: 'body{font-family:DM Sans, Plus Jakarta Sans, sans-serif;font-size:14px;line-height:1.7} img{max-width:100%;height:auto;border-radius:16px}',
        image_caption: true,
        automatic_uploads: true,
        images_upload_handler: function (blobInfo) {
            return new Promise(async function (resolve, reject) {
                try {
                    const originalBlob = blobInfo.blob();
                    const compressedBlob = await compressImageBlob(originalBlob);
                    const formData = new FormData();
                    formData.append('image', compressedBlob, blobInfo.filename());

                    const res = await fetch(uploadUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    if (!res.ok) {
                        reject('Upload gagal');
                        return;
                    }

                    const data = await res.json();
                    const url = data?.url;
                    if (!url) {
                        reject('URL gambar tidak ditemukan');
                        return;
                    }

                    resolve(url);
                } catch (e) {
                    reject('Upload gagal');
                }
            });
        },
        style_formats: [
            { title: 'Paragraf', block: 'p' },
            { title: 'Judul 2', block: 'h2' },
            { title: 'Judul 3', block: 'h3' },
            { title: 'Highlight', inline: 'span', styles: { backgroundColor: '#FEF3C7', padding: '2px 6px', borderRadius: '8px' } },
            { title: 'Gambar - Kiri', selector: 'img', styles: { float: 'left', margin: '0 16px 16px 0', width: '45%' } },
            { title: 'Gambar - Kanan', selector: 'img', styles: { float: 'right', margin: '0 0 16px 16px', width: '45%' } },
            { title: 'Gambar - Penuh', selector: 'img', styles: { float: 'none', display: 'block', margin: '12px 0', width: '100%' } },
        ],
    });

    const addForm = document.getElementById('addForm');
    const editForm = document.getElementById('editForm');
    if (addForm) addForm.addEventListener('submit', function () { window.tinymce?.triggerSave(); });
    if (editForm) editForm.addEventListener('submit', function () { window.tinymce?.triggerSave(); });
}

function editLesson(btn) {
    const modal = document.getElementById('editModal');
    const form = document.getElementById('editForm');
    
    form.action = `/admin/lessons/${btn.dataset.id}`;
    document.getElementById('editTitle').value = btn.dataset.title;
    document.getElementById('editOrderNumber').value = btn.dataset.order;
    document.getElementById('editVideoUrl').value = (btn.dataset.video === 'Tidak ada video' || !btn.dataset.video || btn.dataset.video === 'null') ? '' : btn.dataset.video;
    
    modal.classList.remove('hidden');

    initLessonEditors();
    const editor = window.tinymce?.get('editContent');
    if (editor) {
        let content = '';
        try {
            content = JSON.parse(btn.dataset.content || '""') || '';
        } catch (e) {
            content = btn.dataset.content || '';
        }
        editor.setContent(content);
    } else {
        document.getElementById('editContent').value = btn.dataset.content;
    }
}

function closeEditModal() { document.getElementById('editModal').classList.add('hidden'); }

document.addEventListener('DOMContentLoaded', function () {
    initLessonEditors();
});

window.onclick = function(e) {
    if (e.target.classList.contains('cp-modal-backdrop')) {
        closeAddModal(); closeEditModal();
    }
}
</script>
@endsection
