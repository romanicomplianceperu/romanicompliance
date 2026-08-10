<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;

class CourseQuestionController extends Controller
{
    public function index(Request $request)
    {
        $questions = $request->user()->courseQuestions()->with('course')->latest()->get();
        $courses = $request->user()->enrollments()->with('course')->get()->pluck('course');

        return view('panel.questions', compact('questions', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'subject' => ['required', 'string', 'max:255'],
            'question' => ['required', 'string', 'max:2000'],
        ]);

        $course = Course::findOrFail($data['course_id']);
        abort_unless($course->isEnrolledBy($request->user()), 403);

        CourseQuestion::create([
            'user_id' => $request->user()->id,
            'course_id' => $course->id,
            'subject' => $data['subject'],
            'question' => $data['question'],
        ]);

        return back()->with('success', 'Tu pregunta fue enviada. Te responderemos pronto.');
    }
}
