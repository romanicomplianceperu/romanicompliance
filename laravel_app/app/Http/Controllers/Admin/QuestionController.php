<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function store(Request $request, Exam $exam)
    {
        $data = $this->validated($request);

        $question = $exam->questions()->create([
            'question_text' => $data['question_text'],
            'points' => $data['points'] ?? 1,
            'order' => $exam->questions()->max('order') + 1,
        ]);

        $this->syncOptions($question, $data);

        return redirect()->route('admin.courses.edit', $exam->course_id)->with('success', 'Pregunta agregada.');
    }

    public function update(Request $request, Question $question)
    {
        $data = $this->validated($request);

        $question->update([
            'question_text' => $data['question_text'],
            'points' => $data['points'] ?? 1,
        ]);

        $question->options()->delete();
        $this->syncOptions($question, $data);

        return redirect()->route('admin.courses.edit', $question->exam->course_id)->with('success', 'Pregunta actualizada.');
    }

    public function destroy(Question $question)
    {
        $courseId = $question->exam->course_id;
        $question->delete();

        return redirect()->route('admin.courses.edit', $courseId)->with('success', 'Pregunta eliminada.');
    }

    private function validated(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'question_text' => ['required', 'string'],
            'points' => ['nullable', 'integer', 'min:1'],
            'options' => ['required', 'array', 'max:6'],
            'options.*' => ['nullable', 'string', 'max:255'],
            'correct' => ['required', 'integer', 'min:0'],
        ]);

        $validator->after(function ($validator) use ($request) {
            $options = collect($request->input('options', []))->map(fn ($v) => trim((string) $v));
            $filled = $options->filter(fn ($v) => $v !== '');

            if ($filled->count() < 2) {
                $validator->errors()->add('options', 'Agrega al menos dos opciones de respuesta.');
            }

            $correctIndex = (int) $request->input('correct');
            if (($options[$correctIndex] ?? '') === '') {
                $validator->errors()->add('correct', 'La opción marcada como correcta no puede estar vacía.');
            }
        });

        return $validator->validate();
    }

    private function syncOptions(Question $question, array $data): void
    {
        $order = 0;
        foreach ($data['options'] as $i => $text) {
            $text = trim((string) $text);
            if ($text === '') {
                continue;
            }

            $question->options()->create([
                'option_text' => $text,
                'is_correct' => (int) $data['correct'] === $i,
                'order' => $order++,
            ]);
        }
    }
}
