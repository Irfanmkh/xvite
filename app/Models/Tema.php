<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tema extends Model
{
    //
    protected $fillable = [

        "formfield_id",
        "nama_tema",
        "fields",
        "harga",
        "code",
        "ss1",
        "ss2",
        "ss3",
    ];

    protected $casts = [
        'fields' => 'array',
    ];

            public function tema (): HasMany
    {
        return $this->hasMany(Formfields::class);
    }
    
}
