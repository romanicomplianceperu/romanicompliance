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
        'case_document_path', 'status',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(AcademicCourse::class, 'academic_course_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AcademicActivityQuestion::class, 'academic_activity_id')->orderBy('order');
    }

    public function isAvailable(): bool
    {
        return $this->status === 'disponible';
    }

    public function caseBodyParagraphs(): array
    {
        if (! $this->case_body) {
            return [];
        }

        return array_values(array_filter(array_map('trim', explode("\n\n", $this->case_body))));
    }
}
