<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Course;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('company', 'course')->withCount('participants', 'certificates')->latest()->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $courses = Course::orderBy('title')->get();

        return view('admin.projects.form', ['project' => new Project(), 'companies' => $companies, 'courses' => $courses]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['created_by'] = $request->user()->id;

        $project = Project::create($data);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Project $project)
    {
        $project->load(['company', 'course', 'participants', 'certificates' => fn ($q) => $q->latest('issued_at')]);

        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $companies = Company::orderBy('name')->get();
        $courses = Course::orderBy('title')->get();

        return view('admin.projects.form', compact('project', 'companies', 'courses'));
    }

    public function update(Request $request, Project $project)
    {
        $data = $this->validated($request);

        if ($data['name'] !== $project->name) {
            $data['slug'] = $this->uniqueSlug($data['name'], $project->id);
        }

        $project->update($data);

        return redirect()->route('admin.projects.show', $project)->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto eliminado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'company_id' => ['required', 'exists:companies,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'service' => ['nullable', 'string', 'max:255'],
            'modality' => ['nullable', 'string', 'max:100'],
            'duration_hours' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:draft,active,completed,cancelled'],
            'commercial_info' => ['nullable', 'string'],
            'observations' => ['nullable', 'string'],
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name);
        $slug = $base;
        $i = 1;

        while (Project::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-".++$i;
        }

        return $slug;
    }
}
