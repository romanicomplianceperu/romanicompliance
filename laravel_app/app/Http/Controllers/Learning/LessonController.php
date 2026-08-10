<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function show(Request $request, Lesson $lesson)
    {
        $course = $lesson->module->course;
        $user = $request->user();

        abort_unless($course->isEnrolledBy($user) || $user->isAdmin(), 403, 'Debes inscribirte en el curso para ver esta lección.');

        $course->load('modules.lessons', 'exam');

        $flatLessons = $course->modules->flatMap->lessons->values();
        $currentIndex = $flatLessons->search(fn ($l) => $l->id === $lesson->id);
        $previousLesson = $currentIndex > 0 ? $flatLessons->get($currentIndex - 1) : null;
        $nextLesson = $flatLessons->get($currentIndex + 1);

        $completedLessonIds = LessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $flatLessons->pluck('id'))
            ->pluck('lesson_id');

        $isCompleted = $completedLessonIds->contains($lesson->id);

        $totalLessons = $flatLessons->count();
        $progressPercent = $totalLessons > 0 ? (int) round(($completedLessonIds->count() / $totalLessons) * 100) : 0;

        $certificate = $course->certificates()->where('user_id', $user->id)->whereNull('revoked_at')->first();
        $pendingCertificate = ! $certificate && $course->hasPassedExamFor($user);

        return view('courses.lesson', compact(
            'course', 'lesson', 'previousLesson', 'nextLesson', 'completedLessonIds', 'isCompleted', 'progressPercent', 'certificate', 'pendingCertificate'
        ));
    }

    public function complete(Request $request, Lesson $lesson)
    {
        $course = $lesson->module->course;
        $user = $request->user();
        $enrollment = $course->enrollmentFor($user);

        abort_unless($enrollment, 403, 'Debes inscribirte en el curso para completar esta lección.');

        LessonProgress::firstOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lesson->id],
            ['completed_at' => now()]
        );

        $this->recalculateProgress($course, $enrollment);

        $nextLesson = $course->nextLessonFor($user);
        if ($nextLesson && $nextLesson->id !== $lesson->id) {
            return redirect()->route('lessons.show', $nextLesson)->with('success', 'Lección completada.');
        }

        return redirect()->route('courses.show', $course)->with('success', '¡Has completado todas las lecciones del curso!');
    }

    private function recalculateProgress($course, $enrollment): void
    {
        $totalLessons = $course->lessons()->count();
        $completedLessons = LessonProgress::where('user_id', $enrollment->user_id)
            ->whereIn('lesson_id', $course->lessons()->pluck('id'))
            ->count();

        $percent = $totalLessons > 0 ? (int) round(($completedLessons / $totalLessons) * 100) : 0;

        $enrollment->progress_percent = $percent;
        if ($percent >= 100 && ! $enrollment->completed_at) {
            $enrollment->status = 'completed';
            $enrollment->completed_at = now();
        }
        $enrollment->save();
    }
}
