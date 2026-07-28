<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />
</head>
<body class="bg-gray-50 min-h-screen p-8">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-6">
        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="room_id" value="{{ $room->id }}">
            <input type="hidden" name="date" value="{{ request('date', date('Y-m-d')) }}">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Jam Mulai</label>
                <input type="time" name="jam_mulai" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Jam Selesai</label>
                <input type="time" name="jam_selesai" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Tujuan Peminjaman</label>
                <textarea name="tujuan" rows="3" class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-orange-500 focus:outline-none"></textarea>
            </div>

            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3.5 rounded-xl shadow transition-colors text-base">
                Ajukan Peminjaman
            </button>
        </form>

        <a href="{{ route('rooms.show', $room->id) }}" class="block text-center border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-xl transition-colors text-sm">
            + Pilih & Isi Formulir
        </a>

        <!-- Tempat kalender -->
        <div id="calendar" class="pt-4"></div>

        @php
            // $dateBox adalah tanggal pada kotak yang sedang digambar (misal: "2026-07-29")
            // request('date') adalah tanggal yang diklik dari URL
            $isActive = (isset($dateBox) && $dateBox === request('date'));
        @endphp

        <div class="p-4 rounded-xl text-center font-bold {{ $isActive ? 'border-2 border-orange-500 bg-orange-50 text-orange-900' : 'border border-gray-200 text-gray-700' }}">
            {{ $dayNumber ?? 'Contoh Tanggal' }}
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          timeZone: 'local',
          events: '/api/bookings/' + {{ $room->id }},
          
          dateClick: function(info) {
            window.location.href = "{{ route('rooms.show', $room->id) }}?date=" + info.dateStr;
          }
        });
        calendar.render();
      });
    </script>
</body>
</html>