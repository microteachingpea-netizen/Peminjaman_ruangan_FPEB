<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showMain()
    {
        return view('main');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin' || $user->role === 'prodi') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('rooms.index');
        }

        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cek role untuk mengarahkan halaman
            // Contoh di dalam method login() AuthController.php

if (auth()->user()->role === 'admin') {
    return redirect()->route('admin.dashboard');
} elseif (auth()->user()->role === 'prodi') {
    return redirect()->route('prodi.dashboard'); // Pastikan ini mengarah ke route prodi.dashboard
} else {
    return redirect()->route('rooms.index'); // Untuk user biasa
}

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'loginError' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('main');
    }
}