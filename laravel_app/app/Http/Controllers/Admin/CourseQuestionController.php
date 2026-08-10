<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseQuestion;
use Illuminate\Http\Request;

class CourseQuestionController extends Controller
{
    public function index()
    {
        $questions = CourseQuestion::with('user', 'course')->latest()->get();

        return view('admin.questions-support.index', compact('questions'));
    }

    public function answer(Request $request, CourseQuestion $question)
    {
        $data = $request->validate([
            'answer' => ['required', 'string', 'max:2000'],
        ]);

        $question->update(['answer' => $data['answer'], 'answered_at' => now()]);

        return back()->with('success', 'Respuesta enviada.');
    }
}
