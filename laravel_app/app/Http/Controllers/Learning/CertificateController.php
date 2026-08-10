<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function download(Request $request, Certificate $certificate)
    {
        $user = $request->user();
        abort_unless($certificate->user_id === $user->id || $user->isAdmin(), 403);
        abort_unless($certificate->pdf_path && Storage::disk('public')->exists($certificate->pdf_path), 404);

        $filename = 'Certificado-'.$certificate->code.'.pdf';

        return Storage::disk('public')->download($certificate->pdf_path, $filename);
    }
}
