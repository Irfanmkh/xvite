<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesanan extends Model
{
    //
    protected $fillable = [
        'user_id',
        'tema_id',
        'status_pembayaran',
        'keterangan',
        'kode_transaksi_woocommerce',
        'total_harga',
    ];

    // Relasi dengan User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan Tema
    public function tema(): BelongsTo
    {
        return $this->belongsTo(Tema::class);
    }
}

    // Relasi dengan JawabanPengguna
//     public function jawabanPenggunas(): HasMany
//     {
//         return $this->hasMany(JawabanPengguna::class);
//     }
// }
