<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tampilan extends Model
{
    //

    public function acara()
    {
        return $this->belongsTo(acara::class);
    }

    use HasFactory;

    protected $fillable = [
        'acara_id',
        'quotes',
        'bg_color',
        'backsound',
    ];
}
