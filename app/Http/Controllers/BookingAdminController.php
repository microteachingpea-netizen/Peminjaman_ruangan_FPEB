<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notif;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'room'])->latest()->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking sudah diproses.');
        }

        if (Booking::hasConflict(
            $booking->room_id,
            $booking->date,
            $booking->start_time,
            $booking->end_time,
            $booking->id
        )) {
            return back()->with('error', 'Tidak dapat disetujui karena jadwal bentrok.');
        }

        $booking->load('room');
        $booking->update(['status' => 'approved']);

        if ($booking->user_id) {
            Notif::send(
                $booking->user_id,
                'Booking Disetujui',
                "Pengajuan peminjaman ruangan {$booking->room->name} pada {$booking->date} telah disetujui."
            );
        }

        return back()->with('success', 'Booking berhasil disetujui.');
    }

    public function reject(Request $request, Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Booking sudah diproses.');
        }

        $data = $request->validate([
            'rejection_reason' => 'required|string|min:5',
        ]);

        $booking->load('room');
        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $data['rejection_reason'],
        ]);

        if ($booking->user_id) {
            Notif::send(
                $booking->user_id,
                'Booking Ditolak',
                "Pengajuan peminjaman ruangan {$booking->room->name} ditolak. Alasan: {$data['rejection_reason']}"
            );
        }

        return back()->with('success', 'Booking berhasil ditolak.');
    }
}
