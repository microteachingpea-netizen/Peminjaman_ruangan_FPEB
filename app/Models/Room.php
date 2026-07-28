<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'name',
        'code',
        'capacity',
        'description',
        'image',
        'facilities',
    ];

    protected function casts(): array
    {
        return [
            'facilities' => 'array',
        ];
    }


    public function facilityList(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class, 'room_facility');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function getFacilityNamesAttribute(): array
{
    try {
        if ($this->facilityList()->exists() && $this->facilityList->isNotEmpty()) {
            return $this->facilityList->pluck('name')->all();
        }
    } catch (\Illuminate\Database\QueryException $e) {
        // Tabel belum ada, abaikan error dan gunakan kolom JSON
    }

    return $this->facilities ?? [];
}
}
