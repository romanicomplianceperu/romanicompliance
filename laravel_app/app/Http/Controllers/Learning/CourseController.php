<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function show(Request $request, Course $course)
    {
        $user = $request->user();
        abort_unless($course->is_published || ($user && $user->isAdmin()), 404);

        $course->load('modules.lessons', 'category', 'exam', 'instructor', 'project.company');
        $enrollment = $user ? $course->enrollmentFor($user) : null;

        $completedLessonIds = $enrollment
            ? \App\Models\LessonProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $course->lessons()->pluck('id'))
                ->pluck('lesson_id')
            : collect();

        $certificate = $enrollment
            ? $course->certificates()->where('user_id', $user->id)->whereNull('revoked_at')->first()
            : null;

        $certificateStage = $user ? $course->certificateStageFor($user) : 'none';
        $pendingCertificate = $certificateStage === 'processing';

        $view = $course->project ? 'courses.show-project' : 'courses.show';

        return view($view, compact('course', 'enrollment', 'completedLessonIds', 'certificate', 'pendingCertificate', 'certificateStage'));
    }

    public function enroll(Request $request, Course $course)
    {
        abort_unless($course->is_published || $request->user()->isAdmin(), 404);

        if (! $request->user()->hasCompletedPhoneProfile()) {
            return redirect()->route('profile.complete', ['next' => route('courses.show', $course)])
                ->with('info', 'Antes de inscribirte, completa tu perfil con tu número de teléfono.');
        }

        $course->enrollments()->firstOrCreate(
            ['user_id' => $request->user()->id],
            ['status' => 'active', 'progress_percent' => 0]
        );

        return redirect()->route('courses.show', ['course' => $course, 'bienvenida' => 1]);
    }

    public function claimPayment(Request $request, Course $course)
    {
        $user = $request->user();
        $enrollment = $course->enrollmentFor($user);

        abort_unless($enrollment, 403);

        $data = $request->validate([
            'certificate_name' => ['required', 'string', 'max:255'],
        ]);

        $enrollment->update([
            'certificate_name' => $data['certificate_name'],
            'certificate_payment_claimed_at' => now(),
        ]);

        return back()->with('success', 'Registramos tu solicitud. Confirmaremos tu pago y procesaremos tu certificado en breve.');
    }
}
