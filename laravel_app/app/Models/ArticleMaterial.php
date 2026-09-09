<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A downloadable file (PDF) attached to an article as supplementary
 * material — e.g. the full report, an annex, or source documents that
 * accompany the article body.
 */
class ArticleMaterial extends Model
{
    protected $fillable = [
        'article_id',
        'path',
        'original_name',
        'size',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    public function humanSize(): string
    {
        $bytes = (int) $this->size;

        if ($bytes <= 0) {
            return '';
        }

        if ($bytes < 1024) {
            return $bytes.' B';
        }

        if ($bytes < 1024 * 1024) {
            return round($bytes / 1024, 1).' KB';
        }

        return round($bytes / (1024 * 1024), 1).' MB';
    }
}
