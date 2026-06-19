<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JukungSync ERP</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tema: {
                            hitam: '#111827',
                            kuning: '#FBBF24',
                            marun: '#7f1d1d',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen relative overflow-x-hidden font-sans">
    
    <!-- Background Decoration -->
    <div class="absolute top-0 left-0 w-full h-1/2 bg-tema-hitam skew-y-6 transform origin-top-left -z-10 shadow-2xl"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-tema-marun rounded-full mix-blend-multiply filter blur-3xl opacity-20 -z-10 animate-blob"></div>
    <div class="absolute top-0 left-0 w-96 h-96 bg-tema-kuning rounded-full mix-blend-multiply filter blur-3xl opacity-10 -z-10 animate-blob animation-delay-2000"></div>

    <div class="w-full max-w-md px-4 relative z-10">
        <!-- Login Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/50 overflow-hidden transform transition-all">
            <div class="p-8 sm:p-10">
                <!-- Logo Header Inside Card -->
                <div class="text-center mb-8">
                    <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo PT. UMAR" class="h-24 sm:h-28 mx-auto object-contain drop-shadow-sm mb-4">
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Selamat Datang</h2>
                    <p class="text-gray-500 font-medium text-sm mt-1">PT Utama Madani Raya - ERP System</p>
                </div>

                <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email / Username</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" /></svg>
                            </div>
                            <input type="email" name="email" id="email" class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl focus:ring-tema-marun focus:border-tema-marun sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="admin@umar.com" value="{{ old('email') }}" required autofocus>
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                            </div>
                            <input type="password" name="password" id="password" class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-xl focus:ring-tema-marun focus:border-tema-marun sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-tema-marun focus:ring-tema-marun border-gray-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-gray-700">
                                Ingat Saya
                            </label>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-tema-hitam hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tema-hitam transition-all transform hover:-translate-y-0.5">
                            Masuk ke Sistem
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-4">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-bold text-tema-marun hover:text-red-900 transition-colors">Daftar Klien Baru</a>
                    </p>
                    <div class="pt-4 border-t border-gray-100">
                        <a href="{{ route('welcome') }}" class="inline-flex items-center justify-center text-sm font-semibold text-gray-500 hover:text-tema-hitam transition-colors">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Halaman Utama
                        </a>
                    </div>
                </div>
            </div>
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 text-center">
                <p class="text-xs text-gray-500">&copy; {{ date('Y') }} PT Utama Madani Raya. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{!! session('success') !!}',
                confirmButtonColor: '#111827',
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif
    
    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{!! $errors->first() !!}',
                confirmButtonColor: '#7f1d1d',
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif
</body>
</html>
