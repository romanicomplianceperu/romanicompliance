<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingGlossaryTerm extends Model
{
    protected $fillable = ['training_id', 'term', 'definition', 'example', 'order'];

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }
}
