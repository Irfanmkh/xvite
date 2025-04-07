<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class mempelai extends Model
{
    //

       use HasFactory;

    protected $fillable = [
        'acara_id',
        'anakKe_pria',
'anakKe_wanita',
        'user_id',
        'fullname_pria',
        'nickname_pria',
        'ig_pria',
        'fullname_wanita',
        'nickname_wanita',
        'ig_wanita',
        'namaAyah_pria',
        'namaIbu_pria',
        'namaAyah_wanita',
        'namaIbu_wanita',
    ];

    public function acara()
    {
        return $this->belongsTo(Acara::class);
    }


}
