<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'type',
        'video_url',
        'file_path',
        'content',
        'duration_minutes',
        'order',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function progress(): HasMany
    {
        return $this->hasMany(LessonProgress::class);
    }

    public function typeLabel(): string
    {
        if (in_array($this->type, ['file', 'pdf'], true) && $this->file_path) {
            $ext = strtolower(pathinfo($this->file_path, PATHINFO_EXTENSION));

            return match ($ext) {
                'docx', 'doc' => 'Documento Word',
                'xlsx', 'xls' => 'Hoja de cálculo Excel',
                'pptx', 'ppt' => 'Presentación PowerPoint',
                'pdf' => 'Documento PDF',
                default => $this->type === 'pdf' ? 'Documento PDF' : 'Archivo descargable',
            };
        }

        return match ($this->type) {
            'video' => 'Video',
            'pdf' => 'Documento PDF',
            'file' => 'Archivo descargable',
            'text' => 'Contenido teórico',
            'interactive' => 'Actividad interactiva',
            'glossary' => 'Glosario interactivo',
            'memory' => 'Juego de memoria',
            default => ucfirst($this->type),
        };
    }

    public function embedUrl(): ?string
    {
        if (! $this->video_url) {
            return null;
        }

        if (preg_match('/(?:youtu\.be\/|youtube\.com\/watch\?v=|youtube\.com\/embed\/)([\w-]+)/', $this->video_url, $m)) {
            return "https://www.youtube.com/embed/{$m[1]}";
        }

        if (preg_match('/vimeo\.com\/(\d+)/', $this->video_url, $m)) {
            return "https://player.vimeo.com/video/{$m[1]}";
        }

        return $this->video_url;
    }
}
