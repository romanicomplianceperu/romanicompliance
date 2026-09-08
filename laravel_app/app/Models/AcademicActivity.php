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
        'case_document_path', 'status', 'access_code', 'due_at',
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
}
