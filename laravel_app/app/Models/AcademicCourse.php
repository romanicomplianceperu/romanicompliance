<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicCourse extends Model
{
    protected $fillable = ['university_id', 'slug', 'name', 'subtitle', 'faculty', 'period', 'total_weeks', 'status'];

    public function university(): BelongsTo
    {
        return $this->belongsTo(AcademicUniversity::class, 'university_id');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(AcademicActivity::class, 'academic_course_id')->orderBy('week_number');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
