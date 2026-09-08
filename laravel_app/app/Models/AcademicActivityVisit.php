<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicActivityVisit extends Model
{
    protected $fillable = ['academic_activity_id', 'ip_address', 'user_agent', 'visited_at'];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(AcademicActivity::class, 'academic_activity_id');
    }
}
