<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicActivity;
use App\Models\AcademicSubmission;
use App\Models\AcademicUniversity;
use Illuminate\Http\Request;

class AcademicoController extends Controller
{
    public function index(Request $request)
    {
        $universityId = $request->query('university');
        $courseId = $request->query('course');
        $sort = $request->query('sort', 'recent');

        $query = AcademicActivity::with('course.university')
            ->withCount(['submissions', 'visits'])
            ->withMax('submissions', 'created_at');

        if ($universityId) {
            $query->whereHas('course', fn ($q) => $q->where('university_id', $universityId));
        }
        if ($courseId) {
            $query->where('academic_course_id', $courseId);
        }

        $activities = match ($sort) {
            'activity' => $query->orderByDesc('id')->get(),
            'due' => $query->orderByDesc('due_at')->get(),
            default => $query->orderByRaw('submissions_max_created_at IS NULL, submissions_max_created_at DESC')->get(),
        };

        $universities = AcademicUniversity::orderBy('order')->get();
        $courses = $universityId
            ? AcademicUniversity::findOrFail($universityId)->courses()->orderBy('name')->get()
            : collect();

        return view('admin.academico.index', compact('activities', 'universities', 'courses', 'universityId', 'courseId', 'sort'));
    }

    public function show(AcademicActivity $activity)
    {
        $activity->load('course.university', 'exercises', 'questions');

        $submissions = $activity->submissions()->with('members')->get();
        $visits = $activity->visits()->limit(200)->get();
        $visitsCount = $activity->visits()->count();
        $uniqueIpsCount = $activity->visits()->distinct('ip_address')->count('ip_address');

        return view('admin.academico.show', compact('activity', 'submissions', 'visits', 'visitsCount', 'uniqueIpsCount'));
    }

    public function update(Request $request, AcademicActivity $activity)
    {
        $data = $request->validate([
            'access_code' => ['nullable', 'string', 'max:100'],
            'due_at' => ['nullable', 'date'],
        ]);

        $activity->update([
            'access_code' => $data['access_code'] ?: null,
            'due_at' => $data['due_at'] ?: null,
        ]);

        return back()->with('success', 'Configuración de la actividad actualizada.');
    }

    public function updateStatus(Request $request, AcademicSubmission $submission)
    {
        $data = $request->validate([
            'status' => ['required', 'in:pendiente,aprobado,no_aprobado'],
        ]);

        $submission->update(['status' => $data['status']]);

        return back()->with('success', 'Estado del envío actualizado.');
    }
}
