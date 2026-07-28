@extends('layouts.user1')

@section('title', 'Notifikasi')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Notifikasi</h2>
    @if($notifications->count())
    <form action="{{ route('notifications.read-all') }}" method="POST">
        @csrf
        <button type="submit" class="text-base font-semibold text-fpeb-orange hover:underline">Tandai semua dibaca</button>
    </form>
    @endif
</div>

<div class="space-y-4">
    @forelse($notifications as $notif)
    <div class="bg-white rounded-lg border {{ $notif->is_read ? 'border-gray-200' : 'border-fpeb-orange bg-orange-50' }} p-5 shadow-sm">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="font-bold text-lg text-gray-900">{{ $notif->title }}</h3>
                <p class="text-base text-gray-700 mt-1.5 leading-relaxed">{{ $notif->message }}</p>
                <p class="text-sm font-medium text-gray-500 mt-2">{{ $notif->created_at->diffForHumans() }}</p>
            </div>
            @if(!$notif->is_read)
            <form action="{{ route('notifications.read', $notif) }}" method="POST" class="ml-4 flex-shrink-0">
                @csrf @method('PATCH')
                <button type="submit" class="text-sm font-bold text-fpeb-orange hover:underline bg-white px-3 py-1.5 rounded border border-orange-200 shadow-sm">Tandai dibaca</button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center py-16 text-gray-500 font-semibold text-lg">
        <p>Tidak ada notifikasi.</p>
    </div>
    @endforelse
</div>

<div class="mt-6">{{ $notifications->links() }}</div>
@endsection