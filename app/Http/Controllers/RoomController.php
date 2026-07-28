<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Tambahkan facade Storage

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::latest()->get();

        return view('user.rooms.index', compact('rooms'));
    }

    public function show(Room $room, Request $request)
    {
        // Ambil tanggal dari URL, jika kosong gunakan tanggal hari ini
        $selectedDate = $request->query('date', now()->format('Y-m-d'));

        // Mengatasi bug pergeseran 1 hari akibat timezone
        try {
            $selectedDate = \Carbon\Carbon::parse($selectedDate)->toDateString();
        } catch (\Exception $e) {
            $selectedDate = now()->toDateString();
        }

        $bookingsOnDate = Booking::where('room_id', $room->id)
            ->where('date', $selectedDate)
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('start_time')
            ->get();

        return view('user.rooms.show', compact('room', 'selectedDate', 'bookingsOnDate'));
    }

    public function adminIndex()
    {
        $rooms = Room::latest()->get();
        $facilities = Facility::orderBy('name')->get();

        return view('admin.rooms.index', compact('rooms', 'facilities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi file gambar
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
        ]);

        // Handle upload file gambar
        $imagePath = 'https://picsum.photos/seed/'.time().'/600/400';
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        $room = Room::create([
            'name' => $data['name'],
            'code' => strtoupper(substr(md5($data['name'].time()), 0, 6)),
            'capacity' => $data['capacity'],
            'description' => $data['description'] ?? null,
            'image' => $imagePath,
            'facilities' => Facility::whereIn('id', $data['facilities'] ?? [])->pluck('name')->all(),
        ]);

        if (! empty($data['facilities'])) {
            $room->facilityList()->sync($data['facilities']);
        }

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi file gambar
            'facilities' => 'nullable|array',
            'facilities.*' => 'exists:facilities,id',
        ]);

        $imagePath = $room->image; // Tetap pakai foto lama jika tidak ada upload baru
        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada di storage dan bukan gambar default picsum
            if ($room->image && Storage::disk('public')->exists($room->image)) {
                Storage::disk('public')->delete($room->image);
            }
            // Simpan foto baru
            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        $room->update([
            'name' => $data['name'],
            'capacity' => $data['capacity'],
            'description' => $data['description'] ?? null,
            'image' => $imagePath,
            'facilities' => Facility::whereIn('id', $data['facilities'] ?? [])->pluck('name')->all(),
        ]);

        $room->facilityList()->sync($data['facilities'] ?? []);

        return redirect()->back()->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        // Hapus file gambar dari storage saat ruangan dihapus (opsional agar bersih)
        if ($room->image && Storage::disk('public')->exists($room->image)) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->back()->with('success', 'Ruangan berhasil dihapus.');
    }
}