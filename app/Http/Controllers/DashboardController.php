<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Room;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'bookings' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'rooms' => Room::count(),
            'users' => User::count(),
            'roles' => Role::count(),
        ];

        $recentBookings = Booking::with(['user', 'room'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }

    public function prodiIndex()
    {
        $stats = [
            'bookings' => Booking::where('prodi', auth()->user()->prodi)->count(),
            'pending' => Booking::where('prodi', auth()->user()->prodi)->where('status', 'pending')->count(),
            'rooms' => Room::count(),
        ];

        $recentBookings = Booking::with(['user', 'room'])
            ->where('prodi', auth()->user()->prodi)
            ->latest()
            ->take(5)
            ->get();

        return view('prodi.dashboard', compact('stats', 'recentBookings'));
    }
}
