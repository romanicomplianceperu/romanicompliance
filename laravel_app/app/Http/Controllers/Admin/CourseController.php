<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')->withCount('enrollments')->latest()->get();

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $instructors = User::teamMembers()->get();

        return view('admin.courses.form', ['course' => new Course(), 'categories' => $categories, 'instructors' => $instructors]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['created_by'] = $request->user()->id;
        $data['is_published'] = $request->boolean('is_published');
        $data['duration_minutes'] = $this->hoursToMinutes($data);
        unset($data['duration_hours']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('courses/covers', 'public');
        }

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('success', 'Curso creado correctamente.');
    }

    public function edit(Course $course)
    {
        $categories = Category::orderBy('name')->get();
        $instructors = User::teamMembers()->get();
        $course->load('modules.lessons', 'exam.questions.options');

        return view('admin.courses.form', compact('course', 'categories', 'instructors'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $this->validated($request);

        if ($data['title'] !== $course->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $course->id);
        }

        $data['is_published'] = $request->boolean('is_published');
        $data['duration_minutes'] = $this->hoursToMinutes($data);
        unset($data['duration_hours']);

        if ($request->hasFile('cover_image')) {
            if ($course->cover_image) {
                Storage::disk('public')->delete($course->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('courses/covers', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.courses.edit', $course)->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course)
    {
        if ($course->cover_image) {
            Storage::disk('public')->delete($course->cover_image);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')->with('success', 'Curso eliminado.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'instructor_id' => ['nullable', 'exists:users,id'],
            'duration_hours' => ['nullable', 'numeric', 'min:0'],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'certificate_type' => ['required', 'in:gratuita,opcional'],
            'certificate_price' => ['required_if:certificate_type,opcional', 'nullable', 'numeric', 'min:0'],
        ]);
    }

    private function hoursToMinutes(array $data): ?int
    {
        return isset($data['duration_hours']) && $data['duration_hours'] !== ''
            ? (int) round(((float) $data['duration_hours']) * 60)
            : null;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (Course::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$base}-".++$i;
        }

        return $slug;
    }
}
