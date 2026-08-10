<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateVerificationController extends Controller
{
    public function index()
    {
        return view('certificates.verify-form');
    }

    public function show(string $code)
    {
        $certificate = Certificate::with('user', 'course')->where('code', $code)->first();

        return view('certificates.verify-result', compact('certificate', 'code'));
    }
}
