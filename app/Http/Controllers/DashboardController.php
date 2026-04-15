<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Result;
use App\Models\UserProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tz = config('app.timezone', 'Asia/Makassar');
        $user = Auth::user();
        $userId = $user->id;

        $coursesQuery = Course::query()->with('school');
        if ($user->role === 'student') {
            $coursesQuery->where(function ($q) use ($user) {
                $q->whereNull('school_id')->orWhere('school_id', $user->school_id);
            });
        }

        $availableCourses = $coursesQuery->orderBy('title')->get();
        $availableCourseIds = $availableCourses->pluck('id')->all();

        $total_courses = count($availableCourseIds);
        $completed_courses = Result::where('user_id', $userId)
            ->whereIn('course_id', $availableCourseIds)
            ->count();

        $recent_courses = Course::query()
            ->with(['school', 'type'])
            ->when($user->role === 'student', function ($q) use ($user) {
                $q->where(function ($qq) use ($user) {
                    $qq->whereNull('school_id')->orWhere('school_id', $user->school_id);
                });
            })
            ->latest()
            ->take(6)
            ->get();

        $calendarCourseId = $request->query('calendar_course');
        $calendarCourseId = is_numeric($calendarCourseId) ? (int) $calendarCourseId : null;
        if ($calendarCourseId !== null && ! in_array($calendarCourseId, $availableCourseIds, true)) {
            $calendarCourseId = null;
        }

        $calendarCourseIds = $calendarCourseId ? [$calendarCourseId] : $availableCourseIds;

        $calendarMonthRaw = (string) $request->query('calendar_month', '');
        $calendarMonth = preg_match('/^\d{4}-\d{2}$/', $calendarMonthRaw) ? $calendarMonthRaw : Carbon::now($tz)->format('Y-m');
        $calendarMonthDate = Carbon::createFromFormat('Y-m', $calendarMonth, $tz)->startOfMonth();

        $calendarDateRaw = (string) $request->query('calendar_date', '');
        $calendarDate = preg_match('/^\d{4}-\d{2}-\d{2}$/', $calendarDateRaw) ? Carbon::createFromFormat('Y-m-d', $calendarDateRaw, $tz) : Carbon::now($tz);
        if ($calendarDate->format('Y-m') !== $calendarMonth) {
            $calendarDate = $calendarMonthDate->copy();
        }

        $monthStart = $calendarMonthDate->copy()->startOfMonth()->startOfDay();
        $monthEnd = $calendarMonthDate->copy()->endOfMonth()->endOfDay();

        $calendarLessonsOpenedByDay = collect();
        $calendarProgressDoneByDay = collect();
        $calendarTestsByDay = collect();
        $calendarAgenda = [];

        if (! empty($calendarCourseIds)) {
            $calendarLessonsOpenedByDay = Lesson::query()
                ->whereIn('course_id', $calendarCourseIds)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->selectRaw('DATE(created_at) as day, COUNT(*) as count')
                ->groupBy('day')
                ->pluck('count', 'day');

            $calendarProgressDoneByDay = UserProgress::query()
                ->join('lessons', 'user_progress.lesson_id', '=', 'lessons.id')
                ->where('user_progress.user_id', $userId)
                ->where('user_progress.is_completed', true)
                ->whereIn('lessons.course_id', $calendarCourseIds)
                ->whereBetween('user_progress.updated_at', [$monthStart, $monthEnd])
                ->selectRaw('DATE(user_progress.updated_at) as day, COUNT(*) as count')
                ->groupBy('day')
                ->pluck('count', 'day');

            $calendarTestsByDay = Result::query()
                ->where('user_id', $userId)
                ->whereIn('course_id', $calendarCourseIds)
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->selectRaw('DATE(created_at) as day, COUNT(*) as count')
                ->groupBy('day')
                ->pluck('count', 'day');

            $dayStart = $calendarDate->copy()->startOfDay();
            $dayEnd = $calendarDate->copy()->endOfDay();

            $openedLessons = Lesson::query()
                ->with('course:id,title')
                ->whereIn('course_id', $calendarCourseIds)
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->orderBy('created_at')
                ->get();

            foreach ($openedLessons as $lesson) {
                $calendarAgenda[] = [
                    'ts' => $lesson->created_at,
                    'type' => 'Dibuka',
                    'title' => $lesson->title,
                    'meta' => $lesson->course?->title,
                    'url' => route('lessons.show', $lesson->id),
                ];
            }

            $doneProgress = UserProgress::query()
                ->with('lesson.course:id,title')
                ->where('user_id', $userId)
                ->where('is_completed', true)
                ->whereBetween('updated_at', [$dayStart, $dayEnd])
                ->orderBy('updated_at')
                ->get();

            foreach ($doneProgress as $progress) {
                $lesson = $progress->lesson;
                if (! $lesson || ! in_array($lesson->course_id, $calendarCourseIds, true)) {
                    continue;
                }
                $calendarAgenda[] = [
                    'ts' => $progress->updated_at,
                    'type' => 'Selesai',
                    'title' => 'Bab '.$lesson->order_number.': '.$lesson->title,
                    'meta' => $lesson->course?->title,
                    'url' => route('lessons.show', $lesson->id),
                ];
            }

            $tests = Result::query()
                ->with('course:id,title')
                ->where('user_id', $userId)
                ->whereIn('course_id', $calendarCourseIds)
                ->whereBetween('created_at', [$dayStart, $dayEnd])
                ->orderBy('created_at')
                ->get();

            foreach ($tests as $test) {
                $calendarAgenda[] = [
                    'ts' => $test->created_at,
                    'type' => 'Post-test',
                    'title' => $test->course?->title,
                    'meta' => 'Skor: '.$test->score,
                    'url' => route('results.show', $test->id),
                ];
            }

            usort($calendarAgenda, function ($a, $b) {
                return $a['ts'] <=> $b['ts'];
            });
        }

        $gridStart = $calendarMonthDate->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $gridEnd = $calendarMonthDate->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);
        $cursor = $gridStart->copy();
        $calendarGrid = [];
        while ($cursor->lte($gridEnd)) {
            $calendarGrid[] = $cursor->copy();
            $cursor->addDay();
        }

        $calendarPrevMonth = $calendarMonthDate->copy()->subMonth()->format('Y-m');
        $calendarNextMonth = $calendarMonthDate->copy()->addMonth()->format('Y-m');

        return view('student.dashboard', [
            'total_courses' => $total_courses,
            'completed_courses' => $completed_courses,
            'recent_courses' => $recent_courses,

            'availableCourses' => $availableCourses,
            'calendarMonth' => $calendarMonth,
            'calendarMonthDate' => $calendarMonthDate,
            'calendarPrevMonth' => $calendarPrevMonth,
            'calendarNextMonth' => $calendarNextMonth,
            'calendarDate' => $calendarDate,
            'calendarCourseId' => $calendarCourseId,
            'calendarGrid' => $calendarGrid,
            'calendarLessonsOpenedByDay' => $calendarLessonsOpenedByDay,
            'calendarProgressDoneByDay' => $calendarProgressDoneByDay,
            'calendarTestsByDay' => $calendarTestsByDay,
            'calendarAgenda' => $calendarAgenda,
        ]);
    }
}
