<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseModule;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $data['order'] = $course->modules()->max('order') + 1;
        $course->modules()->create($data);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Módulo agregado.');
    }

    public function update(Request $request, CourseModule $module)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        $module->update($data);

        return redirect()->route('admin.courses.edit', $module->course_id)->with('success', 'Módulo actualizado.');
    }

    public function destroy(CourseModule $module)
    {
        $courseId = $module->course_id;
        $module->delete();

        return redirect()->route('admin.courses.edit', $courseId)->with('success', 'Módulo eliminado.');
    }
}
