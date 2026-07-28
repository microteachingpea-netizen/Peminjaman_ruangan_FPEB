@extends('layouts.user')

@section('title', 'Notifikasi')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-gray-900">Notifikasi</h2>
    @if($notifs->count())
    <form action="{{ route('notifications.read-all') }}" method="POST">
        @csrf
        <button type="submit" class="text-sm font-bold text-fpeb-orange hover:underline px-3 py-1.5 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
            Tandai semua dibaca
        </button>
    </form>
    @endif
</div>

<div class="space-y-4">
    @forelse($notifs as $notif)
    <div class="bg-white rounded-xl border {{ $notif->is_read ? 'border-gray-200' : 'border-fpeb-orange bg-orange-50' }} p-5 shadow-sm transition-all">
        <div class="flex justify-between items-start gap-4">
            <div>
                <h3 class="font-bold text-gray-900 text-base">{{ $notif->title }}</h3>
                <p class="text-sm font-medium text-gray-700 mt-1.5 leading-relaxed">{{ $notif->message }}</p>
                <p class="text-xs font-semibold text-gray-500 mt-3 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ $notif->created_at->diffForHumans() }}
                </p>
            </div>
            @if(!$notif->is_read)
            <form action="{{ route('notifications.read', $notif) }}" method="POST" class="flex-shrink-0">
                @csrf @method('PATCH')
                <button type="submit" class="text-xs font-bold text-white bg-fpeb-orange hover:bg-fpeb-orange-dark px-3.5 py-2 rounded-lg shadow-sm transition-colors">
                    Tandai dibaca
                </button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div class="text-center py-20 bg-white rounded-xl border border-gray-200 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        <p class="text-base font-semibold text-gray-500">Tidak ada notifikasi saat ini.</p>
    </div>
    @endforelse
</div>

<div class="mt-6">{{ $notifs->links() }}</div>
@endsection