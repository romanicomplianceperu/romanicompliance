<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseModule;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    public function store(Request $request, CourseModule $module)
    {
        $data = $this->validated($request);
        $data = $this->handleUpload($request, $data);
        $data['order'] = $module->lessons()->max('order') + 1;

        $module->lessons()->create($data);

        return redirect()->route('admin.courses.edit', $module->course_id)->with('success', 'Lección agregada.');
    }

    public function update(Request $request, Lesson $lesson)
    {
        $data = $this->validated($request);
        $data = $this->handleUpload($request, $data, $lesson);

        $lesson->update($data);

        return redirect()->route('admin.courses.edit', $lesson->module->course_id)->with('success', 'Lección actualizada.');
    }

    public function destroy(Lesson $lesson)
    {
        $courseId = $lesson->module->course_id;

        if ($lesson->file_path) {
            Storage::disk('public')->delete($lesson->file_path);
        }

        $lesson->delete();

        return redirect()->route('admin.courses.edit', $courseId)->with('success', 'Lección eliminada.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:video,pdf,file,text'],
            'video_url' => ['nullable', 'url'],
            'content' => ['nullable', 'string'],
            'duration_minutes' => ['nullable', 'integer', 'min:0'],
            'upload' => ['nullable', 'file', 'max:20480'],
        ]);
    }

    private function handleUpload(Request $request, array $data, ?Lesson $lesson = null): array
    {
        unset($data['upload']);

        if ($request->hasFile('upload')) {
            if ($lesson && $lesson->file_path) {
                Storage::disk('public')->delete($lesson->file_path);
            }
            $data['file_path'] = $request->file('upload')->store('lessons/files', 'public');
        }

        return $data;
    }
}
