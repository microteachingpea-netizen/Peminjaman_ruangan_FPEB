<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Peminjaman Ruangan FPEB</title>
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-fpeb-cream">
    @error('loginError')
    <div class="mt-4 p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-md text-left font-medium flex items-center gap-2 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <span>{{ $message }}</span>
    </div>
@enderror

    <div class="min-h-screen flex flex-col lg:flex-row">

        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center px-8 sm:px-16 py-12 bg-fpeb-cream text-center">
            <div class="max-w-md w-full mx-auto">
                <a href="{{ route('main') }}">
                    <div class="flex items-center gap-2 mb-6 justify-center">
                        <img src="{{ asset('assets/img/download.png') }}" alt="Logo UPI FPEB" class="h-12 w-auto" onerror="this.style.display='none'">
                    </div>
                </a>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 leading-tight">
                    Sistem Peminjaman Ruangan
                </h1>
                <p class="text-gray-500 mt-1">Fakultas Pendidikan Ekonomi dan Bisnis</p>

                <p class="mt-6 text-xl sm:text-2xl font-bold text-gray-900">
                    Silahkan <span class="text-fpeb-orange">Login!</span>
                </p>
                <p class="text-gray-500 mt-1">Please login to your account</p>

                <form class="mt-8 space-y-5" action="{{ route('login.post') }}" method="POST">
    @csrf <div>
        <label for="email" class="sr-only">Email</label>
        <input id="email" name="email" type="email" placeholder="Email" required
               class="w-full px-5 py-4 bg-white border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-fpeb-orange focus:border-transparent text-left">
    </div>

    <div class="relative">
        <label for="password" class="sr-only">Password</label>
        <input id="password" name="password" type="password" placeholder="Password" required
               class="w-full px-5 py-4 bg-white border border-gray-300 rounded-md shadow-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-fpeb-orange focus:border-transparent text-left">
        
        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a20.29 20.29 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a20.29 20.29 0 0 1-3.22 4.19M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                <line x1="1" y1="1" x2="23" y2="23"/>
            </svg>
        </button>
    </div>

    <button type="submit"
            class="w-full bg-fpeb-orange hover:bg-fpeb-orange-dark text-white font-bold text-lg py-4 rounded-md shadow-md transition">
        LOGIN
    </button>
</form>

            </div>
        </div>

        <div class="hidden lg:flex w-1/2 bg-fpeb-orange items-center justify-center p-12">
            <img src="{{ asset('assets/img/auth.png') }}"
                 alt="Illustration"
                 class="w-4/5 h-auto max-h-[80vh] object-contain">
        </div>

    </div>

    <script>
        function togglePassword() {
            const pw = document.getElementById('password');
            pw.type = pw.type === 'password' ? 'text' : 'password';
        }
        function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
 
        const eyeOpenSvg = `
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
        `;
        
   
        const eyeClosedSvg = `
            <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a20.29 20.29 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a20.29 20.29 0 0 1-3.22 4.19M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
            <line x1="1" y1="1" x2="23" y2="23"/>
        `;

        if (passwordInput.type === 'password') {
          
            passwordInput.type = 'text';
            
            eyeIcon.innerHTML = eyeOpenSvg;
        } else {
         
            passwordInput.type = 'password';
       
            eyeIcon.innerHTML = eyeClosedSvg;
        }
    }
    </script>

</body>
</html>