<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Peminjaman Ruangan') - FPEB UPI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        fpeb: { orange: '#F5821F', 'orange-dark': '#E06F0E', red: '#E8402C', cream: '#F3F1E9' }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen">

    <header class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center">
                    <img src="{{ asset('assets/img/download.png') }}" alt="Logo UPI FPEB" class="h-12 w-auto" onerror="this.style.display='none'">
                </a>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 leading-tight">Sistem Peminjaman Ruangan</h1>
                    <p class="text-sm font-medium text-gray-600">Fakultas Pendidikan Ekonomi dan Bisnis</p>
                </div>
            </div>
            
            <!-- Bagian Kanan yang disimetriskan secara presisi -->
            <div class="flex items-center space-x-3">
                @auth
                    <!-- Tombol Notifikasi -->
                    <a href="{{ route('notifications.index') }}" class="relative inline-flex items-center justify-center p-2.5 text-gray-700 hover:text-fpeb-orange transition-colors rounded-lg hover:bg-gray-100" title="Notifikasi">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @php 
                            $unread = 0;
                            try {
                                if (\Illuminate\Support\Facades\Schema::hasTable('notifs')) {
                                    $unread = auth()->user()->notifs()->where('is_read', false)->count();
                                }
                            } catch (\Exception $e) {
                                $unread = 0;
                            }
                        @endphp
                        @if($unread > 0)
                            <span class="absolute top-1 right-1 bg-fpeb-red text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold shadow-sm">{{ $unread }}</span>
                        @endif
                    </a>

                    <!-- Tombol Logout -->
                    <form action="{{ route('logout') }}" method="POST" class="inline-flex items-center m-0 p-0" onsubmit="return confirm('Yakin ingin keluar aplikasi?')">
                        @csrf
                        <button type="submit" class="inline-flex items-center justify-center p-2.5 text-gray-700 hover:text-fpeb-red transition-colors rounded-lg hover:bg-gray-100" title="Logout">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4">
            <div class="bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-lg font-semibold text-base shadow-sm flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-green-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-lg font-semibold text-base shadow-sm flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-red-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>