<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->latest()->get();
        $allRoles = Role::all(); // Mengambil semua data role secara dinamis dari database

        return view('admin.users.index', compact('users', 'allRoles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'prodi' => 'nullable|string|max:100',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'prodi' => $data['prodi'],
        ]);

        return back()->with('success', 'User berhasil ditambahkan.');
    }

    public function updateRoles(Request $request, User $user)
{
    // Ambil input berupa nama-nama role dari checkbox, lalu cari ID-nya di database
    $roleNames = $request->input('roles', []);
    $roleIds = Role::whereIn('nama', $roleNames)->pluck('id')->toArray();

    // Sinkronkan menggunakan ID role yang valid
    $user->roles()->sync($roleIds);

    return back()->with('success', 'Role user berhasil diperbarui.');
}

    public function destroy(User $user)
    {
        // Cek apakah user yang sedang login punya permission 'kelola-user'
        if (!auth()->user()->can('kelola-user')) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus pengguna.');
        }

        // Logika hapus data...
        $user->delete();
        
        return back()->with('success', 'User berhasil dihapus.');
    }
}