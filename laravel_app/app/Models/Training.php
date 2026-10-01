<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Training extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'organizer',
        'speaker_name',
        'speaker_title',
        'intro',
        'time_limit_minutes',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function materials(): HasMany
    {
        return $this->hasMany(TrainingMaterial::class)->orderBy('order');
    }

    public function glossaryTerms(): HasMany
    {
        return $this->hasMany(TrainingGlossaryTerm::class)->orderBy('order');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(TrainingQuestion::class)->orderBy('order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(TrainingAttempt::class);
    }
}
