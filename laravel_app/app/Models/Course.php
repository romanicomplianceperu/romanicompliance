<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'created_by',
        'instructor_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'instructor_name',
        'duration_minutes',
        'is_published',
        'certificate_type',
        'certificate_price',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function modules(): HasMany
    {
        return $this->hasMany(CourseModule::class, 'course_id')->orderBy('order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function exam(): HasOne
    {
        return $this->hasOne(Exam::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function lessons()
    {
        return Lesson::whereIn('module_id', $this->modules()->pluck('id'));
    }

    public function enrollmentFor(User $user): ?Enrollment
    {
        return $this->enrollments()->where('user_id', $user->id)->first();
    }

    public function isEnrolledBy(User $user): bool
    {
        return $this->enrollmentFor($user) !== null;
    }

    public function hasPassedExamFor(User $user): bool
    {
        return $this->exam !== null
            && $this->exam->attempts()->where('user_id', $user->id)->where('status', 'passed')->exists();
    }

    /**
     * 'none' | 'awaiting_payment' | 'processing' | 'issued'
     */
    public function certificateStageFor(User $user): string
    {
        if (($this->certificate_type ?? 'gratuita') !== 'opcional') {
            return 'none';
        }

        if ($this->certificates()->where('user_id', $user->id)->whereNull('revoked_at')->exists()) {
            return 'issued';
        }

        $enrollment = $this->enrollmentFor($user);

        if ($enrollment && $enrollment->certificate_payment_claimed_at) {
            return 'processing';
        }

        $courseCompleted = $enrollment && $enrollment->progress_percent >= 100;

        if ($courseCompleted || $this->hasPassedExamFor($user)) {
            return 'awaiting_payment';
        }

        return 'none';
    }

    public function lectiveHours(): int
    {
        return max(1, (int) ceil(($this->duration_minutes ?? 0) / 60));
    }

    public function nextLessonFor(User $user): ?Lesson
    {
        $completedLessonIds = LessonProgress::where('user_id', $user->id)
            ->whereIn('lesson_id', $this->lessons()->pluck('id'))
            ->pluck('lesson_id');

        foreach ($this->modules as $module) {
            foreach ($module->lessons as $lesson) {
                if (! $completedLessonIds->contains($lesson->id)) {
                    return $lesson;
                }
            }
        }

        return null;
    }
}
