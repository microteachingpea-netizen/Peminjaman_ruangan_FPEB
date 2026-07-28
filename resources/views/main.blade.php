<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Ruangan - FPEB UPI</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        fpeb: {
                            orange: '#F5821F',
                            'orange-dark': '#E06F0E',
                            red: '#E8402C',
                        }
                    }
                }
            }
        }
    </script>

   
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-white">

    
    <div class="bg-fpeb-orange">
        <div class="w-full px-6 md:px-20 py-3 flex justify-end">
            <a href="{{ route('login') }}"
               class="flex items-center gap-2 text-white font-semibold hover:opacity-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Login
            </a>
        </div>
    </div>
 
    
    <header class="border-b border-gray-200 bg-white">
        
        <div class="max-w-7xl ml-6 md:ml-20 mr-auto py-5 flex items-center gap-4">
            <div class="flex items-center gap-2 shrink-0">
                <img src="{{ asset('assets\img\download.png') }}" alt="Logo UPI FPEB" class="h-14 w-auto" onerror="this.style.display='none'">
            </div>

            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 leading-tight">
                    Sistem Peminjaman Ruangan
                </h1>
                <p class="text-gray-500 text-sm md:text-base">
                    Fakultas Pendidikan Ekonomi dan Bisnis
                </p>
            </div>
        </div>
    </header>

    
    <section class="relative overflow-hidden min-h-[85vh] flex items-center">

        <div class="absolute inset-0">
            <img src="{{ asset('assets\img\DEJJSnJ16L7yqmaTxpTZVBRuMIJ9pdyfWyQ26GG5.jpg') }}"
                 alt="Gedung FPEB UPI"
                 class="w-full h-full object-cover"
                 onerror="this.src='https://images.unsplash.com/photo-1562774053-701939374585?auto=format&fit=crop&w=1600&q=80'">
            <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-black/30"></div>
        </div>

      
        <div class="relative max-w-7xl ml-6 md:ml-20 mr-auto py-20 w-full flex flex-col items-start justify-start text-left">
            <h2 class="text-white font-extrabold uppercase leading-tight text-3xl sm:text-4xl md:text-5xl lg:text-6xl text-left">
                Selamat Datang di<br>
                Layanan Peminjaman<br>
                Ruangan Online FPEB
            </h2>

            <p class="mt-6 text-white/90 font-medium text-base md:text-lg max-w-xl text-left">
                Sistem resmi pengelolaan fasilitas gedung dan ruang kelas Fakultas Pendidikan Ekonomi dan Bisnis.
            </p>

            <div class="mt-10 flex flex-wrap gap-4 justify-start">
                <a href="{{ route('login') }}"
                   class="inline-block bg-fpeb-orange hover:bg-fpeb-orange-dark text-white font-semibold px-8 py-4 rounded-md shadow-lg transition">
                    Cek ketersedian ruangan
                </a>
            </div>
        </div>
    </section>


    <footer class="max-w-7xl mx-auto px-6 py-8">
        <p class="text-gray-400 text-sm text-center">
            &copy; 2026 FPEB UPI. All rights reserved.
        </p>
    </footer>

</body>
</html>