<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Notif;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'applicant' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
            'reason' => 'required|string',
        ]);

        if (Booking::hasConflict($data['room_id'], $data['date'], $data['start_time'], $data['end_time'])) {
            return back()->withErrors(['conflict' => 'Jadwal bentrok dengan booking lain.'])->withInput();
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $data['room_id'],
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'applicant' => $data['applicant'],
            'prodi' => $data['prodi'],
            'reason' => $data['reason'],
            'status' => 'pending',
        ]);

        User::where('role', 'admin')->each(function ($admin) use ($booking) {
            Notif::send(
                $admin->id,
                'Pengajuan Booking Baru',
                "Pengajuan baru dari {$booking->applicant} ({$booking->prodi}) pada {$booking->date}."
            );
        });

        return redirect()->route('rooms.show', $booking->room_id)
            ->with('success', 'Peminjaman berhasil diajukan. Menunggu persetujuan admin.');
    }

    public function getEvents(int $roomId)
    {
        $bookings = Booking::where('room_id', $roomId)->get();

        $events = $bookings->map(function (Booking $booking) {
            $colors = [
                'pending' => '#FFC107',
                'approved' => '#DC3545',
                'rejected' => '#6C757D',
            ];

            return [
                'id' => $booking->id,
                'title' => ucfirst($booking->status),
                'start' => $booking->date.'T'.Carbon::parse($booking->start_time)->format('H:i:s'),
                'end' => $booking->date.'T'.Carbon::parse($booking->end_time)->format('H:i:s'),
                'backgroundColor' => $colors[$booking->status] ?? '#F5821F',
                'borderColor' => $colors[$booking->status] ?? '#F5821F',
                'extendedProps' => [
                    'status' => $booking->status,
                    'applicant' => $booking->applicant,
                ],
            ];
        });

        return response()->json($events);
    }
}
