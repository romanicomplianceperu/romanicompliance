<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicUniversity extends Model
{
    protected $fillable = ['slug', 'name', 'short_name', 'logo_url', 'status', 'order'];

    public function courses(): HasMany
    {
        return $this->hasMany(AcademicCourse::class, 'university_id');
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
