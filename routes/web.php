<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PreTestController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/brand/logo.webp', function () {
    return response()->file(resource_path('img/Nutrition Rescue Mission Logo1.webp'));
})->name('brand.logo');

Route::get('/brand/bg-lms.webp', function () {
    return response()->file(resource_path('img/bg lms.webp'));
})->name('brand.bg-lms');

Route::get('/brand/bg-desktop.webp', function () {
    return response()->file(resource_path('img/bgdesktop.webp'));
})->name('brand.bg-desktop');

Route::get('/brand/bg-mobile.webp', function () {
    return response()->file(resource_path('img/bgmobile.webp'));
})->name('brand.bg-mobile');

Route::get('/brand/hero.webp', function () {
    return response()->file(resource_path('img/hero nutritiion.webp'));
})->name('brand.hero');

Route::get('/brand/hero-admin.webp', function () {
    return response()->file(resource_path('img/hero admin.webp'));
})->name('brand.hero-admin');

Route::get('/brand/belajar-nutrition.webp', function () {
    return response()->file(resource_path('img/belajar nutresion.webp'));
})->name('brand.belajar-nutrition');

// Auth Routes
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Student Routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{id}', [CourseController::class, 'detail'])->name('courses.detail');
    Route::get('/lessons/{id}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/lessons/{id}/complete', [LessonController::class, 'complete'])->name('lessons.complete');
    Route::get('/courses/{course_id}/test', [TestController::class, 'index'])->name('tests.index');
    Route::post('/courses/{course_id}/test', [TestController::class, 'submit'])->name('tests.submit');
    Route::get('/courses/{course_id}/pretest', [PreTestController::class, 'index'])->name('tests.pre.index');
    Route::post('/courses/{course_id}/pretest', [PreTestController::class, 'submit'])->name('tests.pre.submit');
    Route::get('/results/{id}', [TestController::class, 'result'])->name('results.show');
    Route::get('/results', [TestController::class, 'myResults'])->name('results.index');
    Route::view('/profile', 'student.profile')->name('profile');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // School Management
    Route::get('/schools', [AdminController::class, 'schools'])->name('schools.index');
    Route::post('/schools', [AdminController::class, 'storeSchool'])->name('schools.store');
    Route::put('/schools/{id}', [AdminController::class, 'updateSchool'])->name('schools.update');
    Route::delete('/schools/{id}', [AdminController::class, 'destroySchool'])->name('schools.destroy');

    // Student Management
    Route::get('/students', [AdminController::class, 'students'])->name('students.index');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
    Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('students.update');
    Route::delete('/students/{id}', [AdminController::class, 'destroyStudent'])->name('students.destroy');
    Route::get('/students/{id}/activity', [AdminController::class, 'studentActivity'])->name('students.activity');
    Route::post('/students/{id}/activity/reset-all', [AdminController::class, 'resetStudentActivityAll'])->name('students.activity.reset-all');
    Route::post('/students/{id}/activity/reset-course/{course_id}', [AdminController::class, 'resetStudentActivityCourse'])->name('students.activity.reset-course');
    Route::post('/students/{id}/activity/reset-lesson/{lesson_id}', [AdminController::class, 'resetStudentActivityLesson'])->name('students.activity.reset-lesson');

    // Course Management
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses.index');
    Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
    Route::put('/courses/{id}', [AdminController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{id}', [AdminController::class, 'destroyCourse'])->name('courses.destroy');

    // Lesson Management
    Route::get('/courses/{course_id}/lessons', [AdminController::class, 'lessons'])->name('lessons.index');
    Route::post('/courses/{course_id}/lessons', [AdminController::class, 'storeLesson'])->name('lessons.store');
    Route::put('/lessons/{id}', [AdminController::class, 'updateLesson'])->name('lessons.update');
    Route::delete('/lessons/{id}', [AdminController::class, 'destroyLesson'])->name('lessons.destroy');
    Route::post('/lessons/upload-image', [AdminController::class, 'uploadLessonImage'])->name('lessons.upload-image');

    // Question Management
    Route::get('/courses/{course_id}/questions', [AdminController::class, 'questions'])->name('questions.index');
    Route::get('/courses/{course_id}/pre-questions', [AdminController::class, 'preQuestions'])->name('pre_questions.index');
    Route::post('/courses/{course_id}/pre-questions', [AdminController::class, 'storePreQuestion'])->name('pre_questions.store');
    Route::delete('/pre-questions/{id}', [AdminController::class, 'destroyPreQuestion'])->name('pre_questions.destroy');
    Route::post('/courses/{course_id}/questions', [AdminController::class, 'storeQuestion'])->name('questions.store');
    Route::put('/questions/{id}', [AdminController::class, 'updateQuestion'])->name('questions.update');
    Route::delete('/questions/{id}', [AdminController::class, 'destroyQuestion'])->name('questions.destroy');

    // Result Monitoring
    Route::get('/results', [AdminController::class, 'results'])->name('results.index');
    Route::get('/results/trend-data', [AdminController::class, 'resultsTrendData'])->name('results.trend-data');
    Route::get('/results/export/{type}', [AdminController::class, 'resultsExport'])->name('results.export');
    Route::get('/results/{id}', [AdminController::class, 'resultShow'])->name('results.show');
});
