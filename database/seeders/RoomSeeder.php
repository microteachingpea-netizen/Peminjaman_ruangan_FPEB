<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['name' => 'Kelas FPEB (LT6)', 'code' => 'LT6', 'capacity' => 30],
            ['name' => 'Kelas FPEB (LT11)', 'code' => 'LT11', 'capacity' => 50],
            ['name' => 'Kelas FPEB (LT3)', 'code' => 'LT3', 'capacity' => 40],
            ['name' => 'Kelas FPEB (LT5)', 'code' => 'LT5', 'capacity' => 1],
            ['name' => 'Kelas FPEB (LT4)', 'code' => 'LT4', 'capacity' => 100],
            ['name' => 'Kelas FPEB (LT2)', 'code' => 'LT2', 'capacity' => 60],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(
                ['code' => $room['code']],
                [
                    'name' => $room['name'],
                    'capacity' => $room['capacity'],
                    'description' => 'Ruang kelas yang nyaman dan dilengkapi fasilitas lengkap untuk kegiatan belajar mengajar maupun rapat.',
                    'image' => 'https://picsum.photos/seed/'.$room['code'].'/600/400',
                    'facilities' => ['Meja', 'Kursi', 'AC', 'Proyektor'],
                ]
            );
        }
    }
}
