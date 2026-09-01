<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicResponse extends Model
{
    protected $fillable = ['academic_activity_question_id', 'user_id', 'body', 'status', 'grade', 'submitted_at'];

    protected function casts(): array
    {
        return ['submitted_at' => 'datetime'];
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(AcademicActivityQuestion::class, 'academic_activity_question_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
