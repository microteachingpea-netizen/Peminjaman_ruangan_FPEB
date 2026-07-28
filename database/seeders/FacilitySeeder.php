<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Meja', 'Kursi', 'AC', 'Proyektor', 'WiFi', 'Whiteboard'] as $name) {
            Facility::firstOrCreate(['name' => $name]);
        }
    }
}
