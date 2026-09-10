<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicActivity extends Model
{
    protected $fillable = [
        'academic_course_id', 'slug', 'week_number', 'type', 'title',
        'case_title', 'unit', 'modality', 'group_size', 'case_body',
        'case_document_path', 'status', 'access_code', 'due_at', 'pass_percent',
    ];

    protected $casts = [
        'due_at' => 'datetime',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(AcademicCourse::class, 'academic_course_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AcademicActivityQuestion::class, 'academic_activity_id')->orderBy('order');
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(AcademicActivityExercise::class, 'academic_activity_id')->orderBy('order');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(AcademicSubmission::class, 'academic_activity_id')->latest();
    }

    public function visits(): HasMany
    {
        return $this->hasMany(AcademicActivityVisit::class, 'academic_activity_id')->latest('visited_at');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'disponible';
    }

    public function requiresAccessCode(): bool
    {
        return ! empty($this->access_code);
    }

    public function checkAccessCode(?string $code): bool
    {
        return $this->access_code && trim((string) $code) !== '' && hash_equals(
            strtolower(trim($this->access_code)),
            strtolower(trim((string) $code))
        );
    }

    public function isPastDue(): bool
    {
        return $this->due_at && now()->greaterThan($this->due_at);
    }

    public function caseBodyParagraphs(): array
    {
        if (! $this->case_body) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode("\n\n", $this->case_body))));
    }

    /**
     * Same source text as caseBodyParagraphs(), but splitting each block into
     * a heading (when its first line reads like "BASE NORMATIVA DE REFERENCIA")
     * and the lines under it, so the case text can be rendered with proper
     * visual structure instead of one wall of paragraphs.
     */
    public function caseBodySections(): array
    {
        $sections = [];

        foreach ($this->caseBodyParagraphs() as $block) {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $block))));
            if (empty($lines)) {
                continue;
            }

            $first = $lines[0];
            $looksLikeHeading = mb_strlen($first) <= 70
                && $first === mb_strtoupper($first)
                && preg_match('/[A-ZÁÉÍÓÚÑ]/u', $first)
                && ! str_ends_with($first, '.');

            if ($looksLikeHeading) {
                $sections[] = ['heading' => $first, 'items' => array_slice($lines, 1)];
            } else {
                $sections[] = ['heading' => null, 'items' => $lines];
            }
        }

        return $sections;
    }

    /**
     * Grade a submission against this activity's auto-gradable exercises.
     * Returns null if there are no exercises to grade.
     */
    public function grade(AcademicSubmission $submission): ?array
    {
        $exercises = $this->exercises;
        if ($exercises->isEmpty()) {
            return null;
        }

        $answers = ($submission->answers ?: [])['exercises'] ?? [];
        $items = [];
        $correctCount = 0;
        $totalPoints = 0;
        $earnedPoints = 0;
        $byType = [];

        foreach ($exercises as $exercise) {
            $studentAnswer = $answers[$exercise->id] ?? null;
            $isCorrect = $exercise->isCorrect($studentAnswer);
            $totalPoints += $exercise->points;
            if ($isCorrect) {
                $correctCount++;
                $earnedPoints += $exercise->points;
            }
            $items[$exercise->id] = $exercise->toGradedArray($studentAnswer);

            $byType[$exercise->type] ??= ['total' => 0, 'correct' => 0];
            $byType[$exercise->type]['total']++;
            if ($isCorrect) {
                $byType[$exercise->type]['correct']++;
            }
        }

        return [
            'total' => $exercises->count(),
            'correct' => $correctCount,
            'total_points' => $totalPoints,
            'earned_points' => $earnedPoints,
            'percent' => $totalPoints > 0 ? (int) round($earnedPoints / $totalPoints * 100) : 0,
            'items' => $items,
            'by_type' => $byType,
        ];
    }

    /**
     * Human-readable Spanish label for an exercise type, used in the results/statistics view.
     */
    public static function exerciseTypeLabel(string $type): string
    {
        return match ($type) {
            'vf' => 'Verdadero / Falso',
            'mcq' => 'Opción múltiple',
            'matching' => 'Emparejar',
            'ordering' => 'Ordenar',
            'memory' => 'Juego de memoria',
            'fillblank' => 'Completar palabras',
            default => ucfirst($type),
        };
    }
}
