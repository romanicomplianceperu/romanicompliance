<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Course::where('is_published', true)->with('category');

        if ($request->filled('categoria')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->string('categoria')));
        }

        $courses = $query->latest()->get();
        $categories = Category::orderBy('name')->get();

        $enrolledCourseIds = $request->user()
            ? $request->user()->enrollments()->pluck('course_id')
            : collect();

        return view('courses.catalog', compact('courses', 'categories', 'enrolledCourseIds'));
    }
}
