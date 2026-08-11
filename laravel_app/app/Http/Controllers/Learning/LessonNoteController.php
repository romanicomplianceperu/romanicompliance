<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonNote;
use Illuminate\Http\Request;

class LessonNoteController extends Controller
{
    public function store(Request $request, Lesson $lesson)
    {
        $course = $lesson->module->course;
        abort_unless($course->isEnrolledBy($request->user()) || $request->user()->isAdmin(), 403);

        $data = $request->validate([
            'content' => ['nullable', 'string', 'max:20000'],
        ]);

        LessonNote::updateOrCreate(
            ['user_id' => $request->user()->id, 'lesson_id' => $lesson->id],
            ['content' => $data['content'] ?? '']
        );

        return response()->json(['saved' => true]);
    }
}
