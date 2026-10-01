<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;

class TrainingController extends Controller
{
    public function index()
    {
        $trainings = Training::withCount(['attempts', 'questions'])
            ->withCount(['attempts as finished_attempts_count' => fn ($q) => $q->whereNotNull('finished_at')])
            ->orderByDesc('id')
            ->get();

        return view('admin.trainings.index', compact('trainings'));
    }

    public function show(Training $training)
    {
        $attempts = $training->attempts()
            ->orderByDesc('created_at')
            ->get();

        $finished = $attempts->whereNotNull('finished_at');
        $avgScore = $finished->avg('score_percent');

        return view('admin.trainings.show', compact('training', 'attempts', 'avgScore'));
    }
}
