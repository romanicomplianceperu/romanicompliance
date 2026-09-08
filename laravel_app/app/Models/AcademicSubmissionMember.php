<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicSubmissionMember extends Model
{
    protected $fillable = ['academic_submission_id', 'full_name', 'email'];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(AcademicSubmission::class, 'academic_submission_id');
    }
}
