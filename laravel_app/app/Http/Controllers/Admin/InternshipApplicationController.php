<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipApplication;
use Illuminate\Http\Request;

class InternshipApplicationController extends Controller
{
    public function index()
    {
        $applications = InternshipApplication::latest()->get();

        return view('admin.internships.index', compact('applications'));
    }

    public function show(InternshipApplication $internship)
    {
        return view('admin.internships.show', ['application' => $internship]);
    }

    public function updateStatus(Request $request, InternshipApplication $internship)
    {
        $data = $request->validate([
            'status' => ['required', 'in:'.implode(',', array_keys(InternshipApplication::STATUSES))],
        ]);

        $internship->update($data);

        return back()->with('success', 'Estado actualizado.');
    }
}
