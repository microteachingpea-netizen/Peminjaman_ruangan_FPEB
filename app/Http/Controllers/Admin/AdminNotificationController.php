<?php

namespace App\Http\Controllers\Admin; // Tambahkan \Admin di sini

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifs()->latest()->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }
}