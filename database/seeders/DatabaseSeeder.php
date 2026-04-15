<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseType;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Course Types
        $this->call(CourseTypeSeeder::class);

        // Create Admin
        User::create([
            'name' => 'Admin LMS',
            'username' => 'admin',
            'email' => 'admin@lms.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create School
        $school = School::create(['name' => 'SMA Negeri 1 Jakarta']);

        // Create Student
        User::create([
            'name' => 'Maoza Ramadhani',
            'username' => '12345678', // NISN as username
            'password' => Hash::make('12345678'), // NISN as password
            'school_id' => $school->id,
            'role' => 'student',
        ]);

        // Create Course
        $pelatihanType = CourseType::where('slug', 'pelatihan')->first();
        $course = Course::create([
            'title' => 'Deteksi Dini Kanker Serviks dan Payudara',
            'description' => 'Pelatihan untuk tenaga kesehatan dalam mendeteksi dini kanker serviks dan payudara menggunakan metode terbaru.',
            'school_id' => $school->id,
            'course_type_id' => $pelatihanType->id,
            'label' => 'Wajib',
        ]);

        // Create Lessons
        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Pengenalan Kanker Serviks',
            'content' => 'Kanker serviks adalah kanker yang tumbuh pada sel-sel di leher rahim. Umumnya, kanker serviks tidak menunjukkan gejala pada tahap awal.',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'order_number' => 1,
        ]);

        Lesson::create([
            'course_id' => $course->id,
            'title' => 'Metode Deteksi Dini IVA Test',
            'content' => 'IVA (Inspeksi Visual Asam Asetat) merupakan cara sederhana untuk mendeteksi kanker leher rahim sedini mungkin.',
            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'order_number' => 2,
        ]);

        // Create Questions
        Question::create([
            'course_id' => $course->id,
            'question' => 'Apa kepanjangan dari IVA Test?',
            'option_a' => 'Inspeksi Visual Asam Asetat',
            'option_b' => 'Internal Visual Acid',
            'option_c' => 'Inspeksi Vagina Akurat',
            'option_d' => 'Intensive Visual Assessment',
            'correct_answer' => 'A',
        ]);

        Question::create([
            'course_id' => $course->id,
            'question' => 'Kapan waktu terbaik melakukan SADARI (Periksa Payudara Sendiri)?',
            'option_a' => 'Saat sedang menstruasi',
            'option_b' => '7-10 hari setelah hari pertama menstruasi',
            'option_c' => 'Setiap hari tanpa kecuali',
            'option_d' => 'Setiap 6 bulan sekali',
            'correct_answer' => 'B',
        ]);
    }
}
