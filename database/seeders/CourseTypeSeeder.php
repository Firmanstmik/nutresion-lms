<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\CourseType;

class CourseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['slug' => 'pelatihan', 'name' => 'Pelatihan', 'color' => 'green'],
            ['slug' => 'materi', 'name' => 'Materi', 'color' => 'emerald'],
            ['slug' => 'modul', 'name' => 'Modul', 'color' => 'teal'],
            ['slug' => 'bab', 'name' => 'Bab', 'color' => 'lime'],
            ['slug' => 'evaluasi', 'name' => 'Evaluasi', 'color' => 'orange'],
            ['slug' => 'post_test', 'name' => 'Post Test', 'color' => 'red'],
            ['slug' => 'pre_test', 'name' => 'Pre Test', 'color' => 'yellow'],
            ['slug' => 'quiz', 'name' => 'Quiz', 'color' => 'blue'],
            ['slug' => 'webinar', 'name' => 'Webinar', 'color' => 'purple'],
            ['slug' => 'tugas', 'name' => 'Tugas', 'color' => 'gray'],
        ];

        foreach ($types as $type) {
            CourseType::updateOrCreate(['slug' => $type['slug']], $type);
        }
    }
}
