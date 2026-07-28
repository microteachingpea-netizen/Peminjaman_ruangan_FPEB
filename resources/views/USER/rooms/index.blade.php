@extends('layouts.user')

@section('title', 'Daftar Ruangan')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-1">Daftar Ruangan FPEB UPI</h2>
    <p class="text-gray-600 text-base">Selamat datang, <span class="font-bold text-gray-900">{{ auth()->user()->name }}!</span> Silakan pilih ruangan yang ingin Anda gunakan.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($rooms as $room)
    <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-200 flex flex-col transition-all hover:shadow-lg">
        <div class="relative h-52">
            <img src="{{ $room->image ?? 'https://picsum.photos/seed/'.$room->id.'/600/400' }}"
                 alt="{{ $room->name }}" class="w-full h-full object-cover">
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent p-4 flex justify-between items-end">
                <span class="text-white font-bold text-lg leading-tight">{{ $room->name }}</span>
                <span class="bg-fpeb-red text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow">{{ $room->capacity }} Orang</span>
            </div>
        </div>
        <div class="p-5 flex-1 flex flex-col">
            <p class="text-gray-600 text-sm font-medium mb-4 line-clamp-2 leading-relaxed">{{ $room->description ?? 'Ruangan kelas FPEB UPI.' }}</p>
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach($room->facility_names as $f)
                    <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg">{{ $f }}</span>
                @endforeach
            </div>
            <a href="{{ route('rooms.show', $room) }}"
               class="mt-auto block text-center bg-gray-900 hover:bg-fpeb-orange text-white rounded-xl py-3 text-sm font-bold shadow transition-colors">
                + Pilih & Isi Formulir
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-full text-center py-20 bg-white rounded-2xl border border-gray-200 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
        <p class="text-base font-semibold text-gray-500">Belum ada ruangan tersedia saat ini.</p>
    </div>
    @endforelse
</div>
@endsection