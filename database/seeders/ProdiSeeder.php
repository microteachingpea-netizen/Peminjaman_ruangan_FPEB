<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    $prodis = [
        ['name' => 'Pendidikan Manajemen Perkantoran', 'email' => 'pmp@kampus.ac.id', 'password' => Hash::make('password123')],
        ['name' => 'Pendidikan Ekonomi', 'email' => 'pe@kampus.ac.id', 'password' => Hash::make('password123')],
        ['name' => 'Pendidikan Akuntansi', 'email' => 'pak@kampus.ac.id', 'password' => Hash::make('password123')],
        ['name' => 'Pendidikan Bisnis', 'email' => 'pb@kampus.ac.id', 'password' => Hash::make('password123')],
        ['name' => 'Manajemen', 'email' => 'manajemen@kampus.ac.id', 'password' => Hash::make('password123')],
        ['name' => 'Akuntansi', 'email' => 'akuntansi@kampus.ac.id', 'password' => Hash::make('password123')],
        ['name' => 'Ilmu Ekonomi dan Keuangan Islam', 'email' => 'ieki@kampus.ac.id', 'password' => Hash::make('password123')],
    ];

    foreach ($prodis as $prodi) {
        \App\Models\User::create($prodi);
    }
    }
}
