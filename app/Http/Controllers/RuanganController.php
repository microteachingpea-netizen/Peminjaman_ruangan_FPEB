<?php

namespace App\Http\Controllers;

use App\Models\Ruangan; // Jangan lupa import modelnya

class RuanganController extends Controller
{
    public function index()
    {
        // Mengambil semua data ruangan
        $ruangans = Ruangan::all();
        
        // Mengirim data ke view ADMIN.ruangan
        return view('ADMIN.ruangan', compact('ruangans'));
    }
}