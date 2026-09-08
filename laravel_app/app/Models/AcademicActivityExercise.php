<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicActivityExercise extends Model
{
    protected $fillable = [
        'academic_activity_id', 'order', 'type', 'prompt', 'payload', 'points',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(AcademicActivity::class, 'academic_activity_id');
    }

    /**
     * Public shape of this exercise, safe to send to the browser BEFORE the
     * student has submitted. Never includes the correct answer.
     */
    public function toPublicArray(): array
    {
        $base = [
            'id' => $this->id,
            'type' => $this->type,
            'prompt' => $this->prompt,
            'points' => $this->points,
        ];

        return match ($this->type) {
            'vf' => $base + [
                'statement' => $this->payload['statement'] ?? $this->prompt,
            ],
            'mcq' => $base + [
                'options' => array_values($this->payload['options'] ?? []),
            ],
            'matching' => $base + [
                'left' => $this->payload['left'] ?? [],
                'right' => $this->shuffledRight(),
            ],
            'ordering' => $base + [
                'items' => $this->shuffledItems(),
            ],
            default => $base,
        };
    }

    /**
     * Full shape including the correct answer, for after submission.
     */
    public function toGradedArray(mixed $studentAnswer): array
    {
        $public = $this->toPublicArray();
        $correct = $this->isCorrect($studentAnswer);

        return $public + [
            'student_answer' => $studentAnswer,
            'correct' => $correct,
            'correct_answer' => $this->correctAnswerForDisplay(),
        ];
    }

    public function isCorrect(mixed $studentAnswer): bool
    {
        if ($studentAnswer === null) {
            return false;
        }

        return match ($this->type) {
            'vf' => $this->normalizeBool($studentAnswer) === $this->normalizeBool($this->payload['answer'] ?? null),
            'mcq' => (int) $studentAnswer === (int) ($this->payload['correct'] ?? -1),
            'matching' => $this->matchingIsCorrect($studentAnswer),
            'ordering' => $this->orderingIsCorrect($studentAnswer),
            default => false,
        };
    }

    private function normalizeBool(mixed $v): ?bool
    {
        if (is_bool($v)) {
            return $v;
        }
        if ($v === 'true' || $v === '1' || $v === 1) {
            return true;
        }
        if ($v === 'false' || $v === '0' || $v === 0) {
            return false;
        }

        return null;
    }

    private function matchingIsCorrect(mixed $studentAnswer): bool
    {
        if (! is_array($studentAnswer)) {
            return false;
        }

        $correct = $this->payload['pairs'] ?? [];
        if (count($correct) !== count(array_filter($studentAnswer, fn ($v) => $v !== null && $v !== ''))) {
            return false;
        }

        foreach ($correct as $leftId => $rightId) {
            if (($studentAnswer[$leftId] ?? null) !== $rightId) {
                return false;
            }
        }

        return true;
    }

    private function orderingIsCorrect(mixed $studentAnswer): bool
    {
        if (! is_array($studentAnswer)) {
            return false;
        }

        $correctOrder = $this->payload['correctOrder'] ?? [];

        return array_values($studentAnswer) === array_values($correctOrder);
    }

    private function correctAnswerForDisplay(): mixed
    {
        return match ($this->type) {
            'vf' => (bool) ($this->payload['answer'] ?? false),
            'mcq' => $this->payload['correct'] ?? null,
            'matching' => $this->payload['pairs'] ?? [],
            'ordering' => $this->payload['correctOrder'] ?? [],
            default => null,
        };
    }

    private function shuffledRight(): array
    {
        $right = $this->payload['right'] ?? [];
        // Stable order based on the exercise id so it doesn't reshuffle on every request.
        mt_srand($this->id ?: 1);
        $right = collect($right)->shuffle()->values()->all();
        mt_srand();

        return $right;
    }

    private function shuffledItems(): array
    {
        $items = $this->payload['items'] ?? [];
        mt_srand(($this->id ?: 1) + 1000);
        $items = collect($items)->shuffle()->values()->all();
        mt_srand();

        return $items;
    }
}
