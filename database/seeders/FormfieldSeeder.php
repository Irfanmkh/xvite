<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FormfieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('formfields')->insert([
            [
                'nama' => 'nama_mempelai_pria',
                'label' => 'Nama Mempelai Pria',
                'tipe' => 'text',
                'is_required' => true,
                'order' => 1,
            ],
            [
                'nama' => 'nama_mempelai_wanita',
                'label' => 'Nama Mempelai Wanita',
                'tipe' => 'text',
                'is_required' => true,
                'order' => 2,
            ],
            [
                'nama' => 'tanggal_akad',
                'label' => 'Tanggal Akad',
                'tipe' => 'date',
                'is_required' => true,
                'order' => 3,
            ],
            [
                'nama' => 'foto_pasangan',
                'label' => 'Foto Pasangan',
                'tipe' => 'file',
                'is_required' => false,
                'order' => 4,
            ],
        ]);
    }
}
