<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifs = Notif::where('user_id', auth()->id())
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifs'));
    }

    public function markRead(Notif $notif)
    {
        if ($notif->user_id !== auth()->id()) {
            abort(403);
        }

        $notif->update(['is_read' => true]);

        return back();
    }

    public function markAllRead()
    {
        Notif::where('user_id', auth()->id())->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
