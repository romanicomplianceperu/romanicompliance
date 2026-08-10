<?php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\AnswerOption;
use App\Models\Course;
use App\Models\ExamAttempt;
use App\Services\CertificateService;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function show(Request $request, Course $course)
    {
        $user = $request->user();
        abort_unless($course->isEnrolledBy($user) || $user->isAdmin(), 403);

        $exam = $course->exam()->with('questions')->firstOrFail();

        $attempts = $exam->attempts()->where('user_id', $user->id)->orderByDesc('attempt_number')->get();
        $inProgress = $attempts->firstWhere('status', 'in_progress');
        $attemptsUsed = $attempts->where('status', '!=', 'in_progress')->count();
        $canStart = $attemptsUsed < $exam->max_attempts && ! $inProgress;

        return view('exams.show', compact('course', 'exam', 'attempts', 'inProgress', 'canStart'));
    }

    public function start(Request $request, Course $course)
    {
        $user = $request->user();
        abort_unless($course->isEnrolledBy($user), 403);

        $data = $request->validate([
            'certificate_name' => ['required', 'string', 'max:255'],
        ]);

        $exam = $course->exam()->with('questions')->firstOrFail();
        abort_if($exam->questions->isEmpty(), 422, 'Este examen todavía no tiene preguntas.');

        $attempts = $exam->attempts()->where('user_id', $user->id);
        $inProgress = $attempts->clone()->where('status', 'in_progress')->first();
        if ($inProgress) {
            return redirect()->route('exams.take', $inProgress);
        }

        $attemptsUsed = $attempts->clone()->where('status', '!=', 'in_progress')->count();
        abort_if($attemptsUsed >= $exam->max_attempts, 422, 'Has alcanzado el número máximo de intentos.');

        $attempt = $exam->attempts()->create([
            'user_id' => $user->id,
            'holder_name' => $data['certificate_name'],
            'attempt_number' => $attemptsUsed + 1,
            'status' => 'in_progress',
            'started_at' => now(),
        ]);

        return redirect()->route('exams.take', $attempt);
    }

    public function take(Request $request, ExamAttempt $attempt)
    {
        $this->authorizeAttempt($request, $attempt);
        abort_unless($attempt->status === 'in_progress', 404);

        $attempt->load('exam.questions.options', 'exam.course');

        return view('exams.take', ['attempt' => $attempt, 'exam' => $attempt->exam, 'course' => $attempt->exam->course]);
    }

    public function submit(Request $request, ExamAttempt $attempt)
    {
        $this->authorizeAttempt($request, $attempt);
        abort_unless($attempt->status === 'in_progress', 404);

        $exam = $attempt->exam()->with('questions.options')->first();
        $answers = $request->input('answers', []);

        $correctCount = 0;
        foreach ($exam->questions as $question) {
            $selectedId = $answers[$question->id] ?? null;
            $selected = $selectedId ? AnswerOption::find($selectedId) : null;
            $isCorrect = $selected && $selected->question_id === $question->id && $selected->is_correct;

            if ($isCorrect) {
                $correctCount++;
            }

            $attempt->answers()->create([
                'question_id' => $question->id,
                'answer_option_id' => $selected?->id,
                'is_correct' => (bool) $isCorrect,
            ]);
        }

        $total = $exam->questions->count();
        $score = $total > 0 ? round(($correctCount / $total) * 100, 2) : 0;
        $finishedAt = now();

        $passed = $score >= $exam->passing_score;

        $attempt->update([
            'score' => $score,
            'status' => $passed ? 'passed' : 'failed',
            'finished_at' => $finishedAt,
            'time_spent_seconds' => $finishedAt->diffInSeconds($attempt->started_at, absolute: true),
        ]);

        if ($passed) {
            $course = $exam->course()->first();
            $hasCertificate = $course->certificates()->where('user_id', $attempt->user_id)->whereNull('revoked_at')->exists();

            if (! $hasCertificate && ($course->certificate_type ?? 'gratuita') !== 'opcional') {
                app(CertificateService::class)->issue($request->user(), $course, $attempt, $attempt->holder_name);
            }
        }

        return redirect()->route('exams.result', $attempt);
    }

    public function result(Request $request, ExamAttempt $attempt)
    {
        $this->authorizeAttempt($request, $attempt);
        abort_if($attempt->status === 'in_progress', 404);

        $attempt->load('exam.course', 'answers.question', 'answers.answerOption');

        $course = $attempt->exam->course;

        $certificate = $attempt->status === 'passed'
            ? $course->certificates()->where('user_id', $attempt->user_id)->whereNull('revoked_at')->first()
            : null;

        $certificateStage = $attempt->status === 'passed' ? $course->certificateStageFor($request->user()) : 'none';

        return view('exams.result', [
            'attempt' => $attempt,
            'exam' => $attempt->exam,
            'course' => $course,
            'certificate' => $certificate,
            'pendingCertificate' => $certificateStage === 'processing',
            'awaitingPayment' => $certificateStage === 'awaiting_payment',
        ]);
    }

    private function authorizeAttempt(Request $request, ExamAttempt $attempt): void
    {
        abort_unless($attempt->user_id === $request->user()->id, 403);
    }
}
