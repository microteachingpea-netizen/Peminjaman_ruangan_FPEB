<?php

use Illuminate\Support\Facades\Artisan;
use App\Models\User;

Artisan::command('make:admin {email}', function ($email) {
    $user = User::where('email', $email)->first();

    if ($user) {
        $user->role = 'admin';
        $user->save();
        $this->info("Berhasil! User dengan email {$email} sekarang adalah ADMIN.");
    } else {
        $this->error("Waduh, email {$email} tidak ditemukan di database.");
    }
})->purpose('Mengubah role user menjadi admin');