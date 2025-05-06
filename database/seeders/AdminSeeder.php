<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        $data = [
            'name' => 'rusdi',
            'email' => 'rusdi@a.com',
            'password' => Hash::make('rusdi'),
        ];

        DB::table('admins')->insert($data);
    }
}
