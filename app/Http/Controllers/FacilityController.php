<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function storeFacility(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Simpan ke database
        Facility::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Fasilitas berhasil ditambahkan!');
    }
    public function destroy($id)
    {
    $facility = \App\Models\Facility::findOrFail($id);
    $facility->delete();

    return redirect()->back()->with('success', 'Fasilitas berhasil dihapus!');
    }
    
}