<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectParticipant;
use Illuminate\Http\Request;

class ProjectParticipantController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
        ]);

        $data['project_id'] = $project->id;
        $data['user_id'] = ($data['email'] ?? null)
            ? \App\Models\User::where('email', $data['email'])->value('id')
            : null;

        ProjectParticipant::create($data);

        return back()->with('success', 'Participante agregado.');
    }

    public function destroy(Project $project, ProjectParticipant $participant)
    {
        abort_unless($participant->project_id === $project->id, 404);

        $participant->delete();

        return back()->with('success', 'Participante eliminado.');
    }
}
