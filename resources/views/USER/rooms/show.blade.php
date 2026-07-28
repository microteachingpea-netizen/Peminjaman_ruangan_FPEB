@extends('layouts.user')

@section('title', $room->name)

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
@endpush

@section('content')
<a href="{{ route('rooms.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-gray-600 hover:text-fpeb-orange mb-6 transition-colors">
    &larr; Pilih ruangan lain
</a>

<div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
    <span class="inline-block bg-fpeb-red text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm mb-3">Ruangan terpilih</span>
    <div class="flex flex-col md:flex-row gap-6 justify-between items-start md:items-center">
        <div class="flex-1">
            <h2 class="text-2xl font-bold text-gray-900">{{ $room->name }}</h2>
            <p class="text-gray-600 text-sm font-medium mt-1.5 leading-relaxed">{{ $room->description }}</p>
            <div class="flex flex-wrap gap-2 mt-4">
                @foreach($room->facility_names as $f)
                    <span class="bg-gray-100 text-gray-700 text-xs font-semibold px-3 py-1.5 rounded-lg">{{ $f }}</span>
                @endforeach
            </div>
        </div>
        <div class="flex items-center gap-4 flex-shrink-0">
            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->name }}" class="rounded-xl shadow-sm object-cover" style="width: 110px; height: 110px;">
            @else
                <img src="{{ asset('images/default-room.png') }}" alt="Default" class="rounded-xl shadow-sm object-cover" style="width: 110px; height: 110px;">
            @endif
            <div class="border border-gray-200 rounded-xl px-5 py-3 text-center bg-gray-50 shadow-sm">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Kapasitas</p>
                <p class="text-2xl font-extrabold text-gray-900 mt-0.5">{{ $room->capacity }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Kalendar Peminjaman Ruangan</h3>
        <div class="flex flex-wrap gap-4 text-xs font-semibold text-gray-600 mb-5 bg-gray-50 p-3 rounded-xl border border-gray-100">
            <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-white border border-gray-300"></span> Masih Tersedia</span>
            <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-yellow-400"></span> Pending</span>
            <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-red-500"></span> Disetujui</span>
            <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-full bg-fpeb-orange"></span> Pilihan Saat Ini</span>
        </div>
        <div id="calendar"></div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden flex flex-col">
        <div class="bg-fpeb-orange text-white px-6 py-4 font-bold text-base tracking-wide">
            FORM PEMINJAMAN RUANGAN
        </div>
        <div class="bg-orange-50 px-6 py-3 text-sm font-bold text-fpeb-orange-dark border-b border-orange-100 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Tanggal peminjaman: {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('j F Y') }}
        </div>

        @if($bookingsOnDate->count())
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <p class="text-sm font-bold text-gray-800 mb-2.5">Daftar booking di tanggal ini ({{ $bookingsOnDate->count() }})</p>
            <div class="space-y-2">
                @foreach($bookingsOnDate as $b)
                <div class="text-xs p-3 rounded-xl {{ $b->status === 'pending' ? 'bg-yellow-50 border border-yellow-200 text-yellow-900' : 'bg-orange-50 border border-orange-200 text-orange-900' }} shadow-sm">
                    <strong class="font-bold text-gray-900">{{ $b->applicant }}</strong> |
                    <span class="font-semibold">{{ \Carbon\Carbon::parse($b->start_time)->format('H.i') }} - {{ \Carbon\Carbon::parse($b->end_time)->format('H.i') }}</span> |
                    keperluan: <span class="text-gray-700">{{ Str::limit($b->reason, 40) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <form action="{{ route('bookings.store') }}" method="POST" class="p-6 space-y-5 flex-1 flex flex-col justify-between">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            <input type="hidden" name="date" id="booking_date" value="{{ $selectedDate }}">

            @error('conflict')
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm font-semibold">
                    {{ $message }}
                </div>
            @enderror

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Pengaju / Program Studi</label>
                    <input type="text" name="applicant" value="{{ old('applicant', auth()->user()->name) }}" required
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-fpeb-orange focus:outline-none shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Program Studi</label>
                    <input type="text" name="prodi" value="{{ old('prodi', auth()->user()->prodi) }}" required
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-fpeb-orange focus:outline-none shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">Kegiatan</label>
                    <textarea name="reason" rows="3" required
                              class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-fpeb-orange focus:outline-none shadow-sm">{{ old('reason') }}</textarea>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Jam Mulai</label>
                        <select name="start_time" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-fpeb-orange focus:outline-none shadow-sm bg-white">
                            @for($h = 7; $h <= 20; $h++)
                                @foreach(['00','30'] as $m)
                                    @php $t = sprintf('%02d:%s', $h, $m); @endphp
                                    <option value="{{ $t }}" {{ old('start_time', '08:00') === $t ? 'selected' : '' }}>{{ str_replace(':', '.', $t) }}</option>
                                @endforeach
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1.5">Jam Selesai</label>
                        <select name="end_time" required class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-fpeb-orange focus:outline-none shadow-sm bg-white">
                            @for($h = 7; $h <= 21; $h++)
                                @foreach(['00','30'] as $m)
                                    @php $t = sprintf('%02d:%s', $h, $m); @endphp
                                    <option value="{{ $t }}" {{ old('end_time', '11:00') === $t ? 'selected' : '' }}>{{ str_replace(':', '.', $t) }}</option>
                                @endforeach
                            @endfor
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-fpeb-orange hover:bg-fpeb-orange-dark text-white font-bold py-3.5 rounded-xl shadow transition-colors text-base mt-2">
                Ajukan Peminjaman
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const dateInput = document.getElementById('booking_date');
    const selectedDate = '{{ $selectedDate }}';

    // Fungsi helper untuk mendapatkan format YYYY-MM-DD lokal secara akurat
    function formatLocalDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    const todayStr = formatLocalDate(new Date());

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        locale: 'id',
        height: 'auto',
        events: '/api/bookings/{{ $room->id }}',
        dateClick: function (info) {
            const clickedDateStr = formatLocalDate(info.date);
            if (clickedDateStr < todayStr) return;
            
            dateInput.value = clickedDateStr;
            window.location.href = '{{ route("rooms.show", $room) }}?date=' + clickedDateStr;
        },
        dayCellDidMount: function (arg) {
            const cellDateStr = formatLocalDate(arg.date);

            // Redupkan tanggal yang sudah lewat
            if (cellDateStr < todayStr) {
                arg.el.style.opacity = '0.4';
            }
            
            // Beri outline oranye persis pada tanggal yang dipilih
            if (cellDateStr === selectedDate) {
                arg.el.style.outline = '2px solid #F5821F';
                arg.el.style.backgroundColor = '#FFF7ED'; 
            }
        }
    });
    calendar.render();
});
</script>
@endpush