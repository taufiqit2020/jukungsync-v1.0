<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Klien / Mitra - JukungSync ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { tema: { hitam: '#111827', kuning: '#FBBF24', marun: '#7f1d1d' } },
                    fontFamily: { sans: ['Inter','sans-serif'], heading: ['Outfit','sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700;800;900&display=swap" rel="stylesheet">
    <style>
        .glass-panel { background: linear-gradient(145deg, #111827 0%, #1f2937 50%, #7f1d1d 100%); }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex">

    {{-- LEFT BRANDING --}}
    <div class="hidden lg:flex lg:w-5/12 xl:w-2/5 glass-panel flex-col justify-between p-12 relative overflow-hidden">
        <div class="absolute -top-24 -left-24 w-80 h-80 bg-white/5 rounded-full pointer-events-none"></div>
        <div class="absolute -bottom-40 -right-20 w-96 h-96 bg-yellow-300/10 rounded-full pointer-events-none"></div>

        <div class="relative z-10">
            <div class="inline-flex items-center gap-3 bg-white/10 border border-white/10 rounded-2xl px-4 py-3">
                <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo" class="h-10 object-contain">
                <div>
                    <p class="text-white/50 text-[9px] font-bold uppercase tracking-widest">Powered by</p>
                    <p class="text-white font-heading font-black text-lg leading-none">JukungSync<span class="text-yellow-400">.</span></p>
                </div>
            </div>
        </div>

        <div class="relative z-10">
            <span class="text-yellow-400 text-[10px] font-black uppercase tracking-[0.3em] mb-5 block">Portal Klien & Mitra Resmi</span>
            <h1 class="font-heading font-black text-white text-4xl xl:text-5xl leading-tight mb-5">
                Bergabung &amp;<br>Dapatkan Harga<br><span class="text-yellow-400">Terbaik.</span>
            </h1>
            <p class="text-white/55 text-sm leading-relaxed max-w-xs mb-8">
                Daftarkan bisnis Anda sebagai mitra resmi PT Utama Madani Raya dan nikmati akses ke E-Catalog dengan harga spesial.
            </p>
            <div class="space-y-3">
                @foreach(['Akses E-Catalog 24/7', 'Harga Grosir & Diskon Tier Member / Premium', 'Pembayaran Fleksibel: Tunai, Transfer, Invoice 30 Hari', 'Pengiriman ke seluruh wilayah Indonesia'] as $f)
                <div class="flex items-center gap-3">
                    <div class="w-5 h-5 rounded-full bg-yellow-400/20 border border-yellow-400/40 flex items-center justify-center flex-shrink-0">
                        <svg class="w-2.5 h-2.5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-white/75 text-sm">{{ $f }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <p class="relative z-10 text-white/25 text-xs">&copy; {{ date('Y') }} PT Utama Madani Raya. All rights reserved.</p>
    </div>

    {{-- RIGHT FORM --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-10 overflow-y-auto">
        <div class="w-full max-w-xl">

            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo" class="h-16 mx-auto mb-3 object-contain">
                <h2 class="font-heading font-black text-gray-800 text-2xl">Daftar Klien / Mitra</h2>
                <p class="text-gray-500 text-sm mt-1">Buat akun untuk akses E-Catalog JukungSync</p>
            </div>

            <div class="hidden lg:block mb-7">
                <h2 class="font-heading font-black text-gray-900 text-3xl mb-1">Buat Akun Baru</h2>
                <p class="text-gray-500 text-sm">Isi formulir di bawah untuk mendaftar sebagai mitra resmi PT Utama Madani Raya.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8" >
                <form method="POST" action="{{ route('register.post') }}" class="space-y-5" id="registerForm">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">NAMA LENGKAP <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name"
                                class="block w-full px-4 py-3 border {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 focus:bg-white transition-all"
                                placeholder="Cth: Umar" value="{{ old('name') }}" required autofocus>
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">NAMA PERUSAHAAN / KLINIK <span class="text-red-500">*</span></label>
                            <input type="text" name="perusahaan" id="perusahaan"
                                class="block w-full px-4 py-3 border {{ $errors->has('perusahaan') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 focus:bg-white transition-all"
                                placeholder="Cth: PT. Mitra Jaya" value="{{ old('perusahaan') }}" required>
                            @error('perusahaan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">ALAMAT LENGKAP PENGIRIMAN <span class="text-red-500">*</span></label>
                        <textarea name="alamat" id="alamat" rows="3"
                            class="block w-full px-4 py-3 border {{ $errors->has('alamat') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 focus:bg-white transition-all resize-none"
                            placeholder="Nama jalan, No., RT/RW, Kelurahan, Kecamatan, Kota..." required>{{ old('alamat') }}</textarea>
                        @error('alamat')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">NOMOR HP / WHATSAPP <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_hp" id="nomor_hp"
                                class="block w-full px-4 py-3 border {{ $errors->has('nomor_hp') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 focus:bg-white transition-all"
                                placeholder="08xxxxxxxxxx" value="{{ old('nomor_hp') }}" required>
                            @error('nomor_hp')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">EMAIL AKTIF <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email"
                                class="block w-full px-4 py-3 border {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 focus:bg-white transition-all"
                                placeholder="email@perusahaan.com" value="{{ old('email') }}" required>
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex items-start gap-2.5 p-3 bg-blue-50 border border-blue-100 rounded-xl">
                        <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <p class="text-xs text-blue-700 font-medium">Kode OTP 6 digit akan dikirim ke alamat email Anda setelah pendaftaran untuk verifikasi akun.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">PASSWORD <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="password" id="password"
                                    class="block w-full px-4 py-3 pr-11 border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-gray-50' }} rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 focus:bg-white transition-all"
                                    placeholder="Min. 8 karakter" required>
                                <button type="button" onclick="togglePwd('password')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700" tabindex="-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Konfirmasi PASSWORD <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="block w-full px-4 py-3 pr-11 border border-gray-200 bg-gray-50 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-800 focus:border-red-800 focus:bg-white transition-all"
                                    placeholder="Ulangi password" required>
                                <button type="button" onclick="togglePwd('password_confirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700" tabindex="-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" id="submitBtn"
                        class="w-full py-3.5 bg-gray-900 hover:bg-black text-yellow-400 font-heading font-black text-sm rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 active:scale-95 flex items-center justify-center gap-2 mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        Daftar Akun Mitra
                    </button>
                </form>

                <div class="mt-6 pt-5 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm">
                    <p class="text-gray-500">Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-bold text-red-800 hover:underline">Masuk di sini</a>
                    </p>
                    <a href="{{ route('welcome') }}" class="flex items-center gap-1.5 text-gray-400 hover:text-gray-700 transition-colors text-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Halaman Utama
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePwd(id) {
            const el = document.getElementById(id);
            el.type = el.type === 'password' ? 'text' : 'password';
        }
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> Memproses...';
        });

        
    </script>
    @if($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Pendaftaran Gagal!',
            html: '<ul style="text-align:left;" class="text-sm mt-2">@foreach($errors->all() as $error)<li>&bull; {{ $error }}</li>@endforeach</ul>',
            confirmButtonColor: '#7f1d1d',
            confirmButtonText: 'Perbaiki'
        });
    </script>
    @endif
</body>
</html>