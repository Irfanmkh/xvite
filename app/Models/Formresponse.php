<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Formresponse extends Model
{
    protected $fillable = [
        'user_id',
        'tema_id',
        'isian',
    ];

    // Relasi ke user (pengisi form)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke tema (undangan yang dibeli)
    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class);
    }
}
