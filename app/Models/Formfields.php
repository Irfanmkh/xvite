<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Formfields extends Model
{
    //

    protected $fillable = [
        "nama",
        // "tema_id",
        "label",
        "tipe",
        "is_required",
        "order",
    ];

    public function tema (): BelongsTo
    {
        return $this->BelongsTo(Tema::class);
    }
}
