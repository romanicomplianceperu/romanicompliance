<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'password',
        'google_id',
        'avatar',
        'role',
        'is_guest',
        'title',
        'bio',
        'photo',
        'credentials',
        'linkedin_url',
        'is_team_member',
        'team_rank',
        'team_order',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_team_member' => 'boolean',
            'is_guest' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasCompletedPhoneProfile(): bool
    {
        return ! empty($this->phone);
    }

    public function displayPhoto(): ?string
    {
        return $this->photo ? asset('storage/'.$this->photo) : $this->avatar;
    }

    public function credentialsList(): array
    {
        return $this->credentials
            ? array_map('trim', explode(',', $this->credentials))
            : [];
    }

    public function scopeTeamMembers($query)
    {
        return $query->where('is_team_member', true)->orderBy('team_order');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function examAttempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'author_id');
    }

    public function courseQuestions(): HasMany
    {
        return $this->hasMany(CourseQuestion::class);
    }

    public function isGuest(): bool
    {
        return (bool) $this->is_guest;
    }
}
