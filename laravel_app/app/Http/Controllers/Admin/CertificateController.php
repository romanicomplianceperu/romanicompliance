<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Services\CertificateService;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('user', 'course')->latest('issued_at')->get();

        $pendingEnrollments = Enrollment::with('user', 'course')
            ->whereNotNull('certificate_payment_claimed_at')
            ->whereHas('course', fn ($q) => $q->where('certificate_type', 'opcional'))
            ->get()
            ->filter(fn ($enrollment) => ! Certificate::where('user_id', $enrollment->user_id)
                ->where('course_id', $enrollment->course_id)
                ->whereNull('revoked_at')
                ->exists())
            ->sortByDesc('certificate_payment_claimed_at')
            ->values();

        return view('admin.certificates.index', compact('certificates', 'pendingEnrollments'));
    }

    public function issuePending(Enrollment $enrollment, CertificateService $service)
    {
        $course = $enrollment->course;

        $alreadyIssued = Certificate::where('user_id', $enrollment->user_id)
            ->where('course_id', $course->id)
            ->whereNull('revoked_at')
            ->exists();

        abort_if($alreadyIssued, 422, 'Este alumno ya tiene un certificado vigente para este curso.');

        $passedAttempt = $course->exam
            ?->attempts()
            ->where('user_id', $enrollment->user_id)
            ->where('status', 'passed')
            ->latest('finished_at')
            ->first();

        $holderName = $enrollment->certificate_name ?: $passedAttempt?->holder_name ?: $enrollment->user->name;

        $service->issue($enrollment->user, $course, $passedAttempt, $holderName);

        return back()->with('success', 'Certificado emitido correctamente.');
    }

    public function revoke(Certificate $certificate)
    {
        $certificate->update(['revoked_at' => now()]);

        return back()->with('success', 'Certificado revocado.');
    }

    public function reissue(Certificate $certificate, CertificateService $service)
    {
        $certificate->update(['revoked_at' => null, 'issued_at' => now()]);
        $service->regeneratePdf($certificate);

        return back()->with('success', 'Certificado reemitido correctamente.');
    }
}
