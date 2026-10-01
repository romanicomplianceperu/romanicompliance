<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class UpdateCourseResourceSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::where('slug', 'cuestiones-problematicas-lavado-activos')->firstOrFail();
        $lesson = $course->lessons()->where('title', 'like', 'Caso ficticio%')->first();
        if ($lesson) {
            $lesson->update(['type' => 'file', 'file_path' => 'lessons/files/cuaderno-participante-red-huanuco.docx']);
        }
    }
}
