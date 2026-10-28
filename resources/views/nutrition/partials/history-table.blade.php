{{-- Expects: $measurements (Collection), $linkToDetail (bool), optional $showRecorder (bool) --}}
@if($measurements->isEmpty())
    <div class="px-5 py-8 text-center text-sm text-slate-500">Belum ada riwayat pengukuran.</div>
@else
    {{-- Mobile: one card per measurement so status/IMT/Z-score are visible without sideways scrolling --}}
    <ul class="sm:hidden divide-y divide-slate-100" aria-label="Riwayat pengukuran status gizi">
        @foreach($measurements as $m)
            <li class="px-4 py-4 space-y-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <div class="text-sm font-bold text-slate-900">{{ $m->measured_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-slate-500">{{ $m->ageLabel() }}</div>
                    </div>
                    <span class="nt-badge nt-cat-{{ $m->category }}">{{ $m->categoryLabel() }}</span>
                </div>
                <dl class="grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                    <div><dt class="nt-stat-label">IMT (kg/m²)</dt><dd class="font-bold text-slate-900">{{ $m->bmiDisplay() }}</dd></div>
                    <div><dt class="nt-stat-label">Z-score</dt><dd class="font-bold text-slate-900">{{ $m->zScoreDisplay() }}</dd></div>
                    <div><dt class="nt-stat-label">Berat (kg)</dt><dd class="text-slate-900">{{ $m->weightDisplay() }}</dd></div>
                    <div><dt class="nt-stat-label">Tinggi (cm)</dt><dd class="text-slate-900">{{ $m->heightDisplay() }}</dd></div>
                    @if(!empty($showRecorder))
                        <div class="col-span-2"><dt class="nt-stat-label">Dicatat oleh</dt><dd class="text-slate-900">{{ $m->recorder->name ?? '—' }}</dd></div>
                    @endif
                </dl>
                @if($linkToDetail)
                    <a href="{{ route('nutrition.show', $m->id) }}" class="inline-flex items-center gap-1 text-sm font-bold text-emerald-700 hover:underline">
                        Lihat detail <i class="fas fa-arrow-right text-xs" aria-hidden="true"></i>
                    </a>
                @endif
            </li>
        @endforeach
    </ul>

    {{-- relative: keeps the sr-only header inside the scroll box so it can't widen the page --}}
    <div class="hidden sm:block relative overflow-x-auto">
        <table class="nt-table">
            <caption class="sr-only">Riwayat pengukuran status gizi</caption>
            <thead>
                <tr>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Usia</th>
                    <th scope="col">Berat (kg)</th>
                    <th scope="col">Tinggi (cm)</th>
                    <th scope="col">IMT (kg/m²)</th>
                    <th scope="col">Z-score</th>
                    <th scope="col">Status gizi</th>
                    @if(!empty($showRecorder))
                        <th scope="col">Dicatat oleh</th>
                    @endif
                    @if($linkToDetail)
                        <th scope="col"><span class="sr-only">Detail</span></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($measurements as $m)
                    <tr>
                        <td>{{ $m->measured_at->format('d/m/Y') }}</td>
                        <td>{{ $m->ageLabel() }}</td>
                        <td>{{ $m->weightDisplay() }}</td>
                        <td>{{ $m->heightDisplay() }}</td>
                        <td class="font-bold">{{ $m->bmiDisplay() }}</td>
                        <td class="font-bold">{{ $m->zScoreDisplay() }}</td>
                        <td><span class="nt-badge nt-cat-{{ $m->category }}">{{ $m->categoryLabel() }}</span></td>
                        @if(!empty($showRecorder))
                            <td>{{ $m->recorder->name ?? '—' }}</td>
                        @endif
                        @if($linkToDetail)
                            <td><a href="{{ route('nutrition.show', $m->id) }}" class="font-bold text-emerald-700 hover:underline">Detail</a></td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
