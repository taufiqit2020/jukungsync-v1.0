<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Klien - JukungSync ERP</title>
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
<body class="bg-gray-50 flex items-center justify-center min-h-screen relative overflow-x-hidden font-sans py-10">
    
    <!-- Background Decoration -->
    <div class="fixed top-0 left-0 w-full h-1/2 bg-tema-hitam skew-y-6 transform origin-top-left -z-10 shadow-2xl"></div>
    <div class="fixed bottom-0 right-0 w-96 h-96 bg-tema-marun rounded-full mix-blend-multiply filter blur-3xl opacity-20 -z-10 animate-blob"></div>
    <div class="fixed top-0 left-0 w-96 h-96 bg-tema-kuning rounded-full mix-blend-multiply filter blur-3xl opacity-10 -z-10 animate-blob animation-delay-2000"></div>

    <div class="w-full max-w-2xl px-4 relative z-10">
        <!-- Register Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/50 overflow-hidden transform transition-all">
            <div class="p-8 sm:p-10">
                <!-- Logo Header Inside Card -->
                <div class="text-center mb-8">
                    <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo PT. UMAR" class="h-20 sm:h-24 mx-auto object-contain drop-shadow-sm mb-4">
                    <h2 class="text-2xl font-extrabold text-gray-800 tracking-tight">Pendaftaran Klien / Mitra</h2>
                    <p class="text-gray-500 font-medium text-sm mt-1">Buat akun untuk akses E-Catalog JukungSync</p>
                </div>

                <form method="POST" action="{{ route('register.post') }}" class="space-y-5">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-tema-marun focus:border-tema-marun sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="Cth: Umar" value="{{ old('name') }}" required autofocus>
                        </div>

                        <!-- Nama Perusahaan -->
                        <div>
                            <label for="perusahaan" class="block text-sm font-semibold text-gray-700 mb-1">Nama Perusahaan / Klinik</label>
                            <input type="text" name="perusahaan" id="perusahaan" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-tema-marun focus:border-tema-marun sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="Cth: PT. Utama Madani Raya Banjarbaru" value="{{ old('perusahaan') }}" required>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea name="alamat" id="alamat" rows="2" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-tema-marun focus:border-tema-marun sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="Masukkan alamat lengkap pengiriman" required>{{ old('alamat') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Nomor HP -->
                        <div>
                            <label for="nomor_hp" class="block text-sm font-semibold text-gray-700 mb-1">Nomor HP / WhatsApp</label>
                            <input type="text" name="nomor_hp" id="nomor_hp" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-tema-marun focus:border-tema-marun sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="Cth: 081234567890" value="{{ old('nomor_hp') }}" required>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email Aktif</label>
                            <input type="email" name="email" id="email" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-tema-marun focus:border-tema-marun sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="email@perusahaan.com" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                            <input type="password" name="password" id="password" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-tema-marun focus:border-tema-marun sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="Minimal 8 karakter" required>
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="block w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-tema-marun focus:border-tema-marun sm:text-sm transition-colors bg-gray-50 focus:bg-white" placeholder="Ulangi password" required>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-tema-hitam hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tema-hitam transition-all transform hover:-translate-y-0.5">
                            Daftar Akun Mitra
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600 mb-4">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-bold text-tema-marun hover:text-red-900 transition-colors">Masuk di sini</a>
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
    
    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Pendaftaran Gagal!',
                html: '<ul style="text-align: left;" class="text-sm mt-2">@foreach($errors->all() as $error)<li>&bull; {{ $error }}</li>@endforeach</ul>',
                confirmButtonColor: '#7f1d1d',
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif
</body>
</html>
