<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Course;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCourses = Course::where('is_published', true)
            ->with('category', 'project.company')
            ->latest()
            ->take(3)
            ->get();

        $recentArticles = Article::published()->with('author', 'category')->take(3)->get();

        return view('home', compact('featuredCourses', 'recentArticles'));
    }
}
