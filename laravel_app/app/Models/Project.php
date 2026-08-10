<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'company_id',
        'course_id',
        'created_by',
        'name',
        'slug',
        'description',
        'service',
        'modality',
        'duration_hours',
        'start_date',
        'end_date',
        'status',
        'commercial_info',
        'observations',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'duration_hours' => 'decimal:2',
        ];
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(ProjectParticipant::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'active' => 'Activo',
            'completed' => 'Completado',
            'cancelled' => 'Cancelado',
            default => 'Borrador',
        };
    }
}
