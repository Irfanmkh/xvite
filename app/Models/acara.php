<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class acara extends Model
{
    //

    use HasFactory;

    protected $fillable = [
        'user_id',
        'tgl_resepsi',
        'tgl_akad',
        'jam_akad',
        'jam_resepsi',
        'venue',
        'venue_akad',
        'link_maps',
        'zona_waktuAkad',
        'zona_waktuResepsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mempelai()
    {
        return $this->hasOne(mempelai::class);
    }

    public function tampilan()
    {
        return $this->hasOne(tampilan::class);
    }
}
