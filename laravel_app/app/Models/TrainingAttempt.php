<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingAttempt extends Model
{
    protected $fillable = [
        'training_id', 'full_name', 'position', 'position_other',
        'started_at', 'finished_at', 'time_limit_seconds',
        'total_questions', 'correct_count', 'score_percent', 'answers', 'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'answers' => 'array',
            'score_percent' => 'decimal:2',
        ];
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    public function positionLabel(): string
    {
        return match ($this->position) {
            'juez' => 'Juez',
            'fiscal' => 'Fiscal',
            default => $this->position_other ?: 'Otro',
        };
    }

    public function isExpired(): bool
    {
        if ($this->finished_at) {
            return false;
        }

        return now()->greaterThan($this->started_at->copy()->addSeconds($this->time_limit_seconds + 15));
    }

    public function remainingSeconds(): int
    {
        $deadline = $this->started_at->copy()->addSeconds($this->time_limit_seconds);

        return max(0, now()->diffInSeconds($deadline, false));
    }
}
