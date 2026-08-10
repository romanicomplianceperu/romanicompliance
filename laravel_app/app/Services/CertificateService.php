<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\ExamAttempt;
use App\Models\Project;
use App\Models\ProjectParticipant;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CertificateService
{
    public function issue(User $user, Course $course, ?ExamAttempt $examAttempt = null, ?string $holderName = null): Certificate
    {
        $certificate = Certificate::firstOrNew([
            'user_id' => $user->id,
            'course_id' => $course->id,
        ]);

        $certificate->fill([
            'exam_attempt_id' => $examAttempt?->id,
            'holder_name' => $holderName ?: $user->name,
            'code' => $certificate->code ?? $this->generateCode(),
            'issued_at' => now(),
            'revoked_at' => null,
        ]);
        $certificate->save();

        $certificate->pdf_path = $this->generatePdf($certificate->fresh(['user', 'course.modules.lessons']));
        $certificate->save();

        return $certificate;
    }

    /**
     * Emite un certificado manual para un proyecto empresarial, sin requerir
     * que el participante tenga una cuenta de usuario en la plataforma.
     * Reutiliza el mismo flujo de numeración, PDF, QR y verificación pública
     * que los certificados de cursos normales.
     */
    public function issueManual(Project $project, string $holderName, ?ProjectParticipant $participant = null): Certificate
    {
        abort_if($project->course === null, 422, 'Este proyecto no tiene un curso asociado; no se puede emitir un certificado.');

        $certificate = Certificate::firstOrNew([
            'project_id' => $project->id,
            'project_participant_id' => $participant?->id,
            'holder_name' => $holderName,
        ]);

        $certificate->fill([
            'user_id' => null,
            'course_id' => $project->course_id,
            'holder_name' => $holderName,
            'code' => $certificate->code ?? $this->generateCode(),
            'issued_at' => now(),
            'revoked_at' => null,
        ]);
        $certificate->save();

        $certificate->pdf_path = $this->generatePdf($certificate->fresh(['course.modules.lessons']));
        $certificate->save();

        return $certificate;
    }

    public function regeneratePdf(Certificate $certificate): Certificate
    {
        $certificate->load('user', 'course.modules.lessons');
        $certificate->pdf_path = $this->generatePdf($certificate);
        $certificate->save();

        return $certificate;
    }

    private function generatePdf(Certificate $certificate): string
    {
        $verifyUrl = route('certificates.verify', $certificate->code);

        $qrCode = (new Builder(
            writer: new PngWriter(),
            data: $verifyUrl,
            size: 220,
            margin: 6,
        ))->build();

        $qrDataUri = $qrCode->getDataUri();
        $signatureDataUri = $this->signatureDataUri();

        $pdf = Pdf::loadView('certificates.pdf', [
            'certificate' => $certificate,
            'qrDataUri' => $qrDataUri,
            'verifyUrl' => $verifyUrl,
            'signatureDataUri' => $signatureDataUri,
        ])->setPaper('a4', 'landscape');

        $path = 'certificates/'.$certificate->code.'.pdf';
        Storage::disk('public')->put($path, $pdf->output());

        return $path;
    }

    private function signatureDataUri(): string
    {
        $path = public_path('images/firma-denis-romani.png');
        $contents = File::get($path);

        return 'data:image/png;base64,'.base64_encode($contents);
    }

    private function generateCode(): string
    {
        do {
            $code = 'RC-'.now()->format('Y').'-'.strtoupper(Str::random(6));
        } while (Certificate::where('code', $code)->exists());

        return $code;
    }
}
