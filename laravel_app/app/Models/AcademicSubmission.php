<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AcademicSubmission extends Model
{
    protected $fillable = [
        'academic_activity_id', 'mode', 'group_code', 'status',
        'answers', 'ip_address', 'user_agent', 'submitted_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(AcademicActivity::class, 'academic_activity_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(AcademicSubmissionMember::class, 'academic_submission_id');
    }

    public function isSubmitted(): bool
    {
        return ! is_null($this->submitted_at);
    }

    public function displayName(): string
    {
        if ($this->mode === 'grupal') {
            return $this->group_code ?? 'Grupo';
        }

        return $this->members->first()->full_name ?? 'Individual';
    }

    /**
     * Generate a unique group code like "UNP-MER-0292" for a given university/course pair.
     */
    public static function generateGroupCode(AcademicUniversity $university, AcademicCourse $course): string
    {
        $prefix = strtoupper($university->short_name).'-'.strtoupper($course->code_abbr ?: Str::substr($course->name, 0, 3));

        do {
            $code = $prefix.'-'.str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (static::where('group_code', $code)->exists());

        return $code;
    }
}
