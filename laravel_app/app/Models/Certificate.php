<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'holder_name',
        'course_id',
        'project_id',
        'project_participant_id',
        'exam_attempt_id',
        'code',
        'pdf_path',
        'issued_at',
        'revoked_at',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function isRevoked(): bool
    {
        return $this->revoked_at !== null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function projectParticipant(): BelongsTo
    {
        return $this->belongsTo(ProjectParticipant::class);
    }

    public function examAttempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    public function isManual(): bool
    {
        return $this->user_id === null;
    }

    public function holderDisplayName(): string
    {
        return $this->holder_name ?: $this->user?->name ?? '—';
    }
}
