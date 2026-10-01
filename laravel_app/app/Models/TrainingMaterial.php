<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingMaterial extends Model
{
    protected $fillable = ['training_id', 'label', 'file_path', 'file_type', 'order'];

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }
}
