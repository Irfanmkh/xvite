<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('temas')->insert([
            [
                'nama_tema' => 'Tema 1',
                'fields' => json_encode([1, 2, 3, 4]), // ID dari tabel formfields
                'harga' => 150000,
                'code' => '<html><body><h1>Contoh Tema Romantis Floral</h1></body></html>',
                'ss1' => 'romantis1.png',
                'ss2' => 'romantis2.png',
                'ss3' => 'romantis3.png',
            ],
            [
                'nama_tema' => 'Tema 2',
                'fields' => json_encode([1, 2, 3]), // Misalnya hanya tiga field
                'harga' => 200000,
                'code' => '<html><body><h1>Contoh Tema Elegant Black Gold</h1></body></html>',
                'ss1' => 'elegant1.png',
                'ss2' => 'elegant2.png',
                'ss3' => 'elegant3.png',
            ]
        ]);
    }
}
