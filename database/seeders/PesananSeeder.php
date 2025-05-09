<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PesananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $data = [
            'user_id' => 1,
            'tema_id' => 1,
            'status_pembayaran' => 'sukses',
            'kode_transaksi_woocommerce' => '5jlyp',
            'keterangan' => 'tes',
            'total_harga' => 150000.00,
        ];

        DB::table('pesanans')->insert($data);
    }
}
