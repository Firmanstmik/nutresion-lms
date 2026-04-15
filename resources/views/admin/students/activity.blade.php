@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div class="min-w-0">
            <div class="text-xs font-semibold tracking-widest text-gray-500 uppercase">
                <a href="{{ route('admin.students.index') }}" class="hover:text-gray-900">Siswa</a>
                <span class="mx-1 text-gray-300">/</span>
                <span class="text-gray-900">Aktivitas</span>
            </div>
            <h1 class="mt-2 text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">
                Aktivitas: {{ $student->name }}
            </h1>
            <div class="mt-1 text-sm text-gray-600">
                NISN/Username: <span class="font-semibold text-gray-900">{{ $student->username }}</span>
                <span class="mx-2 text-gray-300">·</span>
                Sekolah: <span class="font-semibold text-gray-900">{{ $student->school->name ?? 'Belum Ditetapkan' }}</span>
            </div>
        </div>

        <form action="{{ route('admin.students.activity.reset-all', $student->id) }}" method="POST"
              onsubmit="return confirm('Reset semua aktivitas siswa ini? Ini akan menghapus progres bab dan semua hasil test (pre/post).')">
            @csrf
            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-sm bg-red-600 text-white text-xs font-extrabold tracking-widest uppercase hover:bg-red-700">
                <i class="fas fa-rotate-left"></i>
                Reset Semua Aktivitas
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="mt-5 rounded-sm border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mt-5 rounded-sm border border-red-200 bg-red-50 px-4 py-3 text-red-800 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="mt-6 flex flex-col gap-4">
        @forelse($courses as $course)
            @php
                $lessons = $course->lessons;
                $completedCount = 0;
                foreach ($lessons as $lesson) {
                    $p = $progressByLessonId[$lesson->id] ?? null;
                    if ($p && $p->is_completed) {
                        $completedCount++;
                    }
                }
                $totalLessons = $lessons->count();
                $pre = $resultsByCourse[$course->id]['pre'] ?? null;
                $post = $resultsByCourse[$course->id]['post'] ?? null;
            @endphp

            <div class="rounded-sm border border-gray-200 bg-white overflow-hidden">
                <div class="px-4 sm:px-6 py-4 bg-gray-50 border-b border-gray-200 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <div class="text-xs font-semibold tracking-widest text-gray-500 uppercase">Kursus</div>
                        <div class="mt-1 text-lg font-extrabold text-gray-900 truncate">{{ $course->title }}</div>
                        <div class="mt-1 text-sm text-gray-600 flex flex-wrap items-center gap-x-3 gap-y-1">
                            <span class="inline-flex items-center gap-2">
                                <span class="font-semibold text-gray-900">{{ $completedCount }}</span>/<span class="font-semibold text-gray-900">{{ $totalLessons }}</span> bab selesai
                            </span>
                            @if($pre)
                                <span class="inline-flex items-center gap-2 px-2 py-1 rounded-sm bg-amber-50 text-amber-800 border border-amber-200 text-xs font-bold">
                                    Pre Test: {{ $pre->score }}
                                </span>
                            @endif
                            @if($post)
                                <span class="inline-flex items-center gap-2 px-2 py-1 rounded-sm bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold">
                                    Post Test: {{ $post->score }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <form action="{{ route('admin.students.activity.reset-course', ['id' => $student->id, 'course_id' => $course->id]) }}" method="POST"
                          onsubmit="return confirm('Reset aktivitas kursus ini? Ini akan menghapus progres bab dan hasil test (pre/post) untuk kursus ini.')">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-sm bg-gray-900 text-white text-xs font-extrabold tracking-widest uppercase hover:bg-black">
                            <i class="fas fa-rotate-left"></i>
                            Reset Kursus
                        </button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-white">
                            <tr class="text-left text-xs font-extrabold tracking-widest uppercase text-gray-500 border-b border-gray-200">
                                <th class="px-4 sm:px-6 py-3 w-20">Bab</th>
                                <th class="px-4 sm:px-6 py-3">Judul</th>
                                <th class="px-4 sm:px-6 py-3 w-40">Status</th>
                                <th class="px-4 sm:px-6 py-3 w-52">Terakhir</th>
                                <th class="px-4 sm:px-6 py-3 w-28 text-right">Reset</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($lessons as $lesson)
                                @php
                                    $p = $progressByLessonId[$lesson->id] ?? null;
                                    $done = $p && $p->is_completed;
                                @endphp
                                <tr class="text-sm text-gray-800">
                                    <td class="px-4 sm:px-6 py-3 font-bold text-gray-900">
                                        {{ $lesson->order_number }}
                                    </td>
                                    <td class="px-4 sm:px-6 py-3">
                                        <div class="font-semibold text-gray-900">{{ $lesson->title }}</div>
                                    </td>
                                    <td class="px-4 sm:px-6 py-3">
                                        @if($done)
                                            <span class="inline-flex items-center gap-2 px-2 py-1 rounded-sm bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-bold">
                                                <i class="fas fa-check-circle"></i>
                                                Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-2 px-2 py-1 rounded-sm bg-gray-50 text-gray-700 border border-gray-200 text-xs font-bold">
                                                <i class="fas fa-circle"></i>
                                                Belum
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 text-gray-600">
                                        @if($p)
                                            {{ $p->updated_at?->format('d/m/Y H:i') }}
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td class="px-4 sm:px-6 py-3 text-right">
                                        <form action="{{ route('admin.students.activity.reset-lesson', ['id' => $student->id, 'lesson_id' => $lesson->id]) }}" method="POST"
                                              onsubmit="return confirm('Reset aktivitas bab ini?')">
                                            @csrf
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center w-10 h-9 rounded-sm border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 {{ $done ? '' : 'opacity-40 pointer-events-none' }}">
                                                <i class="fas fa-rotate-left"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 sm:px-6 py-6 text-center text-sm text-gray-500">
                                        Belum ada bab untuk kursus ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @empty
            <div class="rounded-sm border border-gray-200 bg-white px-6 py-10 text-center text-gray-600">
                Tidak ada kursus yang tersedia untuk siswa ini.
            </div>
        @endforelse
    </div>
</div>
@endsection

