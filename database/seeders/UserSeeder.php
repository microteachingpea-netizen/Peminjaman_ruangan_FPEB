<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin FPEB',
                'password' => 'password123',
                'role' => 'admin',
                'prodi' => 'Administrasi',
            ]
        );

        User::updateOrCreate(
            ['email' => 'prodi@gmail.com'],
            [
                'name' => 'Prodi Pendidikan Ekonomi',
                'password' => 'password123',
                'role' => 'dosen',
                'prodi' => 'Pendidikan Ekonomi',
            ]
        );
    }
}
