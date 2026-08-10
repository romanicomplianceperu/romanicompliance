<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'courses' => Course::count(),
            'published_courses' => Course::where('is_published', true)->count(),
            'students' => User::where('role', 'student')->count(),
            'enrollments' => Enrollment::count(),
            'certificates' => Certificate::whereNull('revoked_at')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
