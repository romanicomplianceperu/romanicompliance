<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicActivityQuestion extends Model
{
    protected $fillable = ['academic_activity_id', 'order', 'prompt'];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(AcademicActivity::class, 'academic_activity_id');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(AcademicResponse::class, 'academic_activity_question_id');
    }

    public function responseFor(?User $user): ?AcademicResponse
    {
        if (! $user) {
            return null;
        }

        return $this->responses->firstWhere('user_id', $user->id);
    }
}
