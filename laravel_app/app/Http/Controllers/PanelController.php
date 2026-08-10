<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function courses(Request $request)
    {
        $user = $request->user();

        $enrollments = $user->enrollments()->with('course')->latest()->get();
        $certificateNotices = $this->certificateNoticesFor($user, $enrollments);

        return view('panel.courses', compact('enrollments', 'certificateNotices'));
    }

    public function certificates(Request $request)
    {
        $user = $request->user();

        $certificates = $user->certificates()->with('course')->whereNull('revoked_at')->latest('issued_at')->get();

        $enrollments = $user->enrollments()->with('course')->latest()->get();
        $certificateNotices = $this->certificateNoticesFor($user, $enrollments);

        return view('panel.certificates', compact('certificates', 'certificateNotices'));
    }

    private function certificateNoticesFor($user, $enrollments)
    {
        return $enrollments
            ->map(fn ($enrollment) => ['course' => $enrollment->course, 'stage' => $enrollment->course->certificateStageFor($user)])
            ->filter(fn ($item) => in_array($item['stage'], ['awaiting_payment', 'processing'], true))
            ->values();
    }

    public function calendar(Request $request)
    {
        $user = $request->user();

        $events = collect();

        foreach ($user->enrollments()->with('course')->get() as $enrollment) {
            $events->push([
                'date' => $enrollment->created_at,
                'type' => 'enrollment',
                'label' => 'Inscripción: '.$enrollment->course->title,
            ]);
        }

        foreach ($user->certificates()->with('course')->whereNull('revoked_at')->get() as $certificate) {
            $events->push([
                'date' => $certificate->issued_at,
                'type' => 'certificate',
                'label' => 'Certificado emitido: '.$certificate->course->title,
            ]);
        }

        $events = $events->sortByDesc('date')->values();

        return view('panel.calendar', compact('events'));
    }

    public function profile(Request $request)
    {
        return view('panel.profile', ['user' => $request->user()]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        $isGoogleAccount = ! empty($user->google_id);

        $rules = [
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\s()-]{6,30}$/'],
        ];

        if (! $isGoogleAccount) {
            $rules['name'] = ['required', 'string', 'max:255'];
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        }

        $data = $request->validate($rules);

        $user->phone = $data['phone'];

        if (! $isGoogleAccount) {
            $user->name = $data['name'];
            if (! empty($data['password'])) {
                $user->password = $data['password'];
            }
        }

        $user->save();

        return redirect()->route('panel.profile')->with('success', 'Perfil actualizado correctamente.');
    }
}
