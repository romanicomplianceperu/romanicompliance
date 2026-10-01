<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class UpdateRedHuanucoPdfSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::where('slug', 'cuestiones-problematicas-lavado-activos')->firstOrFail();
        $lesson = $course->lessons()->where('title', 'like', 'Cuaderno participante Red Huánuco%')->first();
        if ($lesson) {
            $lesson->update([
                'title' => 'Cuaderno participante Red Huánuco (PDF)',
                'type' => 'pdf',
                'file_path' => 'lessons/files/cuaderno-participante-red-huanuco.pdf',
            ]);
        }
    }
}
