<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'passing_score' => ['required', 'integer', 'min:1', 'max:100'],
            'max_attempts' => ['required', 'integer', 'min:1', 'max:20'],
            'time_limit_minutes' => ['nullable', 'integer', 'min:1'],
        ]);

        $course->exam()->updateOrCreate([], $data);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Examen guardado correctamente.');
    }
}
