<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Notification;
use App\Models\Result;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        // Proactive check: if any course is 100% complete but post-test not taken, create notification
        $courses = Course::with('lessons')->get();
        foreach ($courses as $course) {
            $totalLessons = $course->lessons->count();
            if ($totalLessons > 0) {
                $completedCount = UserProgress::where('user_id', $user_id)
                    ->whereIn('lesson_id', $course->lessons->pluck('id'))
                    ->where('is_completed', true)
                    ->count();

                $postTestTaken = Result::where('user_id', $user_id)
                    ->where('course_id', $course->id)
                    ->exists();

                if ($completedCount === $totalLessons && ! $postTestTaken) {
                    $notifActionUrl = route('tests.index', $course->id);
                    $notifExists = Notification::where('user_id', $user_id)
                        ->where('action_url', $notifActionUrl)
                        ->exists();

                    if (! $notifExists) {
                        Notification::create([
                            'user_id' => $user_id,
                            'title' => 'Materi Tuntas: '.$course->title,
                            'message' => 'Selamat! Kamu telah menyelesaikan semua materi di '.$course->title.'. Ayo ambil Post Test sekarang untuk mendapatkan nilai!',
                            'type' => 'result',
                            'action_url' => $notifActionUrl,
                            'is_read' => false,
                        ]);
                    }
                }
            }
        }

        $notifications = Notification::where('user_id', $user_id)
            ->latest()
            ->get();

        return view('student.notifications.index', compact('notifications'));
    }

    public function read($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->update(['is_read' => true]);

        if ($notification->action_url) {
            return redirect($notification->action_url);
        }

        return back();
    }

    public function readAll()
    {
        Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }
}
