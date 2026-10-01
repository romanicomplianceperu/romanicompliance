<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingAttempt;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function show(Training $training)
    {
        abort_unless($training->is_active, 404);

        $training->load('materials', 'glossaryTerms');

        return view('trainings.show', compact('training'));
    }

    public function identifyForm(Training $training)
    {
        abort_unless($training->is_active, 404);

        return view('trainings.identify', compact('training'));
    }

    public function identifyStore(Request $request, Training $training)
    {
        abort_unless($training->is_active, 404);

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:150'],
            'position' => ['required', 'in:juez,fiscal,otro'],
            'position_other' => ['nullable', 'required_if:position,otro', 'string', 'max:100'],
        ], [
            'position_other.required_if' => 'Indique su cargo.',
        ]);

        $totalQuestions = $training->questions()->count();

        $attempt = TrainingAttempt::create([
            'training_id' => $training->id,
            'full_name' => $data['full_name'],
            'position' => $data['position'],
            'position_other' => $data['position'] === 'otro' ? $data['position_other'] : null,
            'started_at' => now(),
            'time_limit_seconds' => $training->time_limit_minutes * 60,
            'total_questions' => $totalQuestions,
            'ip_address' => $request->ip(),
        ]);

        session(["training_attempt_{$training->id}" => $attempt->id]);

        return redirect()->route('capacitacion.quiz', $training);
    }

    public function quiz(Training $training)
    {
        abort_unless($training->is_active, 404);

        $attempt = $this->currentAttempt($training);
        if (! $attempt) {
            return redirect()->route('capacitacion.identify', $training);
        }

        $questions = $training->questions;

        return view('trainings.quiz', compact('training', 'attempt', 'questions'));
    }

    public function submit(Request $request, Training $training)
    {
        abort_unless($training->is_active, 404);

        $attempt = $this->currentAttempt($training);
        if (! $attempt) {
            return redirect()->route('capacitacion.identify', $training);
        }

        $answers = $request->input('answers', []);

        $questions = $training->questions;
        $correct = 0;
        foreach ($questions as $question) {
            $given = $answers[$question->id] ?? null;
            if ($given === $question->correct_option) {
                $correct++;
            }
        }

        $total = $questions->count();
        $scorePercent = $total > 0 ? round(($correct / $total) * 100, 2) : 0;

        $attempt->update([
            'finished_at' => now(),
            'correct_count' => $correct,
            'score_percent' => $scorePercent,
            'answers' => $answers,
        ]);

        session()->forget("training_attempt_{$training->id}");

        return redirect()->route('capacitacion.result', [$training, $attempt]);
    }

    public function result(Training $training, TrainingAttempt $attempt)
    {
        abort_unless($attempt->training_id === $training->id, 404);
        abort_unless($attempt->finished_at, 404);

        return view('trainings.result', compact('training', 'attempt'));
    }

    private function currentAttempt(Training $training): ?TrainingAttempt
    {
        $attemptId = session("training_attempt_{$training->id}");
        if (! $attemptId) {
            return null;
        }

        $attempt = TrainingAttempt::where('id', $attemptId)
            ->where('training_id', $training->id)
            ->whereNull('finished_at')
            ->first();

        if ($attempt && $attempt->isExpired()) {
            return $attempt;
        }

        return $attempt;
    }
}
