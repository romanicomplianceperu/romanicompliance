<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        abort_unless($project->course, 404);

        $project->load('company', 'course.modules.lessons');

        return view('projects.show', compact('project'));
    }
}
