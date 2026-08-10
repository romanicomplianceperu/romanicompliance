<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectParticipant;
use App\Services\CertificateService;
use Illuminate\Http\Request;

class ProjectCertificateController extends Controller
{
    public function store(Request $request, Project $project, CertificateService $service)
    {
        $data = $request->validate([
            'participant_id' => ['nullable', 'exists:project_participants,id'],
            'holder_name' => ['required_without:participant_id', 'nullable', 'string', 'max:255'],
        ]);

        $participant = isset($data['participant_id'])
            ? ProjectParticipant::where('project_id', $project->id)->findOrFail($data['participant_id'])
            : null;

        $holderName = ($data['holder_name'] ?? null) ?: $participant?->full_name;

        abort_if(! $holderName, 422, 'Falta el nombre del participante.');

        $service->issueManual($project, $holderName, $participant);

        return back()->with('success', 'Certificado generado correctamente.');
    }
}
