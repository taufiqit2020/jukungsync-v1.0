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

        /* === Camera UI === */
        .camera-frame {
            position: relative;
            border: 3px dashed #d1d5db;
            border-radius: 16px;
            overflow: hidden;
            background: #f9fafb;
            transition: all 0.25s;
        }
        .camera-frame.active   { border-color: #7f1d1d; border-style: solid; background: #000; }
        .camera-frame.captured { border-color: #16a34a; border-style: solid; }
        .camera-frame.invalid  { border-color: #dc2626; border-style: solid; }
        .camera-frame.checking { border-color: #d97706; border-style: solid; }

        #ktpVideo  { width: 100%; display: block; }
        #ktpCanvas { width: 100%; display: none; }

        /* KTP overlay guide */
        .ktp-guide-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }
        .ktp-guide-box {
            border: 3px solid rgba(251,191,36,0.85);
            border-radius: 12px;
            width: 85%;
            aspect-ratio: 85.6 / 54;
            box-shadow: 0 0 0 9999px rgba(0,0,0,0.45);
            position: relative;
        }
        /* Corner marks */
        .ktp-guide-box::before,
        .ktp-guide-box::after {
            content: '';
            position: absolute;
            width: 24px;
            height: 24px;
        }
        .corner { position: absolute; width: 20px; height: 20px; border-color: #fbbf24; border-style: solid; }
        .corner-tl { top: -3px; left: -3px;  border-width: 3px 0 0 3px; border-radius: 4px 0 0 0; }
        .corner-tr { top: -3px; right: -3px; border-width: 3px 3px 0 0; border-radius: 0 4px 0 0; }
        .corner-bl { bottom: -3px; left: -3px;  border-width: 0 0 3px 3px; border-radius: 0 0 0 4px; }
        .corner-br { bottom: -3px; right: -3px; border-width: 0 3px 3px 0; border-radius: 0 0 4px 0; }

        /* OTP Method Cards */
        .otp-method-card {
            cursor: pointer;
            border: 2px solid #e5e7eb;
            border-radius: 14px;
            padding: 12px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
            background: #f9fafb;
        }
        .otp-method-card:hover { border-color: #7f1d1d; background: #fff7f7; }
        .otp-method-card.selected { border-color: #7f1d1d; background: #fff7f7; box-shadow: 0 0 0 3px rgba(127,29,29,0.12); }
        .otp-method-card input[type="radio"] { accent-color: #7f1d1d; width: 18px; height: 18px; }

        /* Animations */
        @keyframes pulse-ring {
            0%   { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(127,29,29,0.4); }
            70%  { transform: scale(1);    box-shadow: 0 0 0 8px rgba(127,29,29,0); }
            100% { transform: scale(0.95); }
        }
        .pulse-rec { animation: pulse-ring 1.5s infinite; }

        @keyframes spin { to { transform: rotate(360deg); } }
        .animate-spin { animation: spin 1s linear infinite; }

        /* Scanning animation bar */
        @keyframes scanline {
            0%   { top: 0; }
            50%  { top: calc(100% - 4px); }
            100% { top: 0; }
        }
        .scan-bar {
            position: absolute;
            left: 0; right: 0;
            height: 3px;
            background: linear-gradient(to right, transparent, #fbbf24, transparent);
            animation: scanline 1.8s ease-in-out infinite;
            border-radius: 2px;
        }

        /* OCR verifying overlay */
        #verifyingOverlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.70);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            z-index: 10;
            border-radius: 13px;
        }
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
            <span class="text-yellow-400 text-[10px] font-black uppercase tracking-[0.3em] mb-5 block">Portal Klien &amp; Mitra Resmi</span>
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
    <div class="flex-1 flex items-start justify-center p-6 sm:p-10 overflow-y-auto">
        <div class="w-full max-w-xl py-4">

            <div class="lg:hidden text-center mb-8">
                <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo" class="h-16 mx-auto mb-3 object-contain">
                <h2 class="font-heading font-black text-gray-800 text-2xl">Daftar Klien / Mitra</h2>
                <p class="text-gray-500 text-sm mt-1">Buat akun untuk akses E-Catalog JukungSync</p>
            </div>

            <div class="hidden lg:block mb-7">
                <h2 class="font-heading font-black text-gray-900 text-3xl mb-1">Buat Akun Baru</h2>
                <p class="text-gray-500 text-sm">Isi formulir di bawah untuk mendaftar sebagai mitra resmi PT Utama Madani Raya.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
                <form method="POST" action="{{ route('register.post') }}" class="space-y-5" id="registerForm">
                    @csrf

                    {{-- ===== DATA DIRI ===== --}}
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

                    {{-- ===== FOTO KTP (CAMERA + OCR VALIDATION) ===== --}}
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">
                            FOTO KTP <span class="text-red-500">*</span>
                            <span class="ml-1 text-[10px] text-red-700 font-bold normal-case">(Wajib – gunakan kamera, diverifikasi otomatis)</span>
                        </label>

                        {{-- Info box --}}
                        <div class="flex items-start gap-2.5 p-3 bg-amber-50 border border-amber-200 rounded-xl mb-3">
                            <svg class="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <p class="text-xs text-amber-800 font-medium">
                                Foto KTP <strong>hanya via kamera</strong> (tidak bisa dari galeri). Sistem akan <strong>memverifikasi otomatis</strong> bahwa foto adalah KTP Indonesia asli. Pastikan KTP terlihat jelas, terang, dan tidak buram.
                            </p>
                        </div>

                        {{-- === STATE 1: Belum buka kamera === --}}
                        <div id="cameraPlaceholder" class="camera-frame flex flex-col items-center justify-center gap-3 py-10 px-4 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-700">Klik tombol di bawah untuk membuka kamera</p>
                                <p class="text-xs text-gray-400 mt-1">Arahkan kamera ke KTP Anda, lalu ambil foto</p>
                            </div>
                            <button type="button" id="openCameraBtn"
                                class="mt-1 inline-flex items-center gap-2 px-5 py-2.5 bg-tema-marun hover:bg-red-900 text-white rounded-xl text-sm font-bold transition-all active:scale-95 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Buka Kamera
                            </button>
                        </div>

                        {{-- === STATE 2: Kamera aktif === --}}
                        <div id="cameraActive" class="camera-frame active hidden">
                            <div class="relative">
                                <video id="ktpVideo" autoplay playsinline></video>
                                {{-- KTP guide overlay --}}
                                <div class="ktp-guide-overlay">
                                    <div class="ktp-guide-box">
                                        <div class="corner corner-tl"></div>
                                        <div class="corner corner-tr"></div>
                                        <div class="corner corner-bl"></div>
                                        <div class="corner corner-br"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-3 flex items-center justify-between bg-gray-900/90 backdrop-blur-sm">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 bg-red-500 rounded-full pulse-rec"></span>
                                    <span class="text-white text-xs font-bold">Arahkan KTP ke kotak kuning</span>
                                </div>
                                <div class="flex gap-2">
                                    <button type="button" id="captureBtn"
                                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-gray-100 text-gray-900 rounded-lg text-xs font-black transition-all active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4" fill="currentColor"/></svg>
                                        Ambil Foto
                                    </button>
                                    <button type="button" id="closeCameraBtn"
                                        class="px-3 py-2 bg-gray-600 hover:bg-gray-500 text-white rounded-lg text-xs font-bold">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- === STATE 3: Sedang verifikasi OCR === --}}
                        <div id="cameraChecking" class="camera-frame checking hidden">
                            <div class="relative">
                                <canvas id="ktpCanvas"></canvas>
                                <div id="verifyingOverlay">
                                    <div class="scan-bar" style="position:relative;width:80%;height:3px;"></div>
                                    <svg class="w-8 h-8 text-yellow-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <p class="text-white font-bold text-sm">Memverifikasi KTP...</p>
                                    <p class="text-white/60 text-xs" id="ocrStatus">Membaca data KTP Indonesia</p>
                                </div>
                            </div>
                        </div>

                        {{-- === STATE 4: VALID – Foto KTP terverifikasi === --}}
                        <div id="cameraResult" class="camera-frame captured hidden">
                            <div class="relative">
                                <canvas id="ktpCanvasResult"></canvas>
                                <div class="absolute top-2 left-2 bg-green-600/90 backdrop-blur-sm text-white text-xs font-black px-3 py-1.5 rounded-xl flex items-center gap-1.5 shadow">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    KTP Terverifikasi
                                </div>
                            </div>
                            <div class="p-3 flex items-center justify-between bg-green-900/90 backdrop-blur-sm">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    <span class="text-white text-xs font-bold">Foto KTP Indonesia Valid</span>
                                </div>
                                <button type="button" id="retakeBtn"
                                    class="inline-flex items-center gap-1.5 px-3 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg text-xs font-bold transition-all active:scale-95">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    Ulangi Foto
                                </button>
                            </div>
                        </div>

                        {{-- Hidden input untuk base64 --}}
                        <input type="hidden" name="foto_ktp" id="ktpBase64">
                        @error('foto_ktp')<p class="text-red-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                    </div>

                    {{-- ===== METODE OTP ===== --}}
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-2 uppercase tracking-wider">
                            METODE VERIFIKASI OTP <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500 mb-3">Pilih cara pengiriman kode OTP 6-digit untuk verifikasi akun Anda:</p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="otp-method-card {{ old('otp_method', 'whatsapp') === 'whatsapp' ? 'selected' : '' }}" id="cardWhatsapp">
                                <input type="radio" name="otp_method" value="whatsapp"
                                    {{ old('otp_method', 'whatsapp') === 'whatsapp' ? 'checked' : '' }}
                                    onchange="selectOtpMethod(this)">
                                <div class="w-9 h-9 bg-green-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.183-.573c.978.58 1.711.883 2.81.884 3.18 0 5.766-2.585 5.768-5.766 0-3.181-2.585-5.766-5.768-5.766zm3.332 8.163c-.159.453-.94.887-1.319.923-.339.032-.782.1-1.892-.353-1.332-.544-2.181-1.921-2.247-2.009-.065-.088-.535-.713-.535-1.36 0-.648.337-.968.455-1.09.117-.122.254-.153.338-.153s.169-.004.241-.004c.071 0 .17-.027.266.204.098.232.336.822.366.883.03.061.05.132.016.204-.035.071-.05.116-.1.177-.049.061-.106.133-.146.183-.045.051-.093.107-.04.204.053.096.237.396.508.64.351.314.646.406.744.457.098.051.155.04.213-.026.058-.066.248-.285.313-.383.066-.098.131-.082.222-.048.092.034.58.273.68.323s.166.075.19.117c.024.041.024.244-.135.697zm-3.332-10.457c4.619 0 8.375 3.756 8.375 8.375 0 4.619-3.756 8.375-8.375 8.375-1.554 0-3.003-.42-4.238-1.154l-4.708 1.236 1.263-4.593c-.808-1.285-1.268-2.813-1.268-4.464 0-4.619 3.756-8.375 8.375-8.375z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-800">WhatsApp</p>
                                    <p class="text-xs text-gray-500 mt-0.5">OTP dikirim ke nomor HP aktif</p>
                                </div>
                            </label>
                            <label class="otp-method-card {{ old('otp_method') === 'email' ? 'selected' : '' }}" id="cardEmail">
                                <input type="radio" name="otp_method" value="email"
                                    {{ old('otp_method') === 'email' ? 'checked' : '' }}
                                    onchange="selectOtpMethod(this)">
                                <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-800">Email</p>
                                    <p class="text-xs text-gray-500 mt-0.5">OTP dikirim ke email aktif</p>
                                </div>
                            </label>
                        </div>
                        @error('otp_method')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- ===== PASSWORD ===== --}}
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

    {{-- SweetAlert & Tesseract.js OCR --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Tesseract.js v5 – OCR engine untuk validasi teks KTP --}}
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>

    <script>
    // ===========================
    //  Password Toggle
    // ===========================
    function togglePwd(id) {
        const el = document.getElementById(id);
        el.type = el.type === 'password' ? 'text' : 'password';
    }

    // ===========================
    //  OTP Method Selector
    // ===========================
    function selectOtpMethod(radio) {
        document.querySelectorAll('.otp-method-card').forEach(c => c.classList.remove('selected'));
        radio.closest('.otp-method-card').classList.add('selected');
    }

    // ===========================
    //  KTP Camera + OCR Validation
    // ===========================
    let stream          = null;
    let ktpValidated    = false;    // flag: foto sudah terbukti KTP valid
    let capturedDataUrl = null;     // simpan hasil foto

    const video           = document.getElementById('ktpVideo');
    const canvas          = document.getElementById('ktpCanvas');
    const canvasResult    = document.getElementById('ktpCanvasResult');
    const ktpBase64Input  = document.getElementById('ktpBase64');
    const ocrStatusEl     = document.getElementById('ocrStatus');

    const elPlaceholder   = document.getElementById('cameraPlaceholder');
    const elActive        = document.getElementById('cameraActive');
    const elChecking      = document.getElementById('cameraChecking');
    const elResult        = document.getElementById('cameraResult');

    // --- Buka Kamera ---
    document.getElementById('openCameraBtn').addEventListener('click', openCamera);

    async function openCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: { ideal: 'environment' },
                    width:  { ideal: 1920 },
                    height: { ideal: 1080 }
                },
                audio: false
            });
            video.srcObject = stream;
            showState('active');
        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Izin Kamera Ditolak',
                html: 'Browser tidak dapat mengakses kamera.<br><small class="text-gray-500">Izinkan akses kamera di pengaturan browser Anda, lalu coba lagi.</small>',
                confirmButtonColor: '#7f1d1d',
                confirmButtonText: 'Mengerti'
            });
        }
    }

    // --- Ambil Foto & Jalankan OCR ---
    document.getElementById('captureBtn').addEventListener('click', async function () {
        canvas.width  = video.videoWidth  || 1280;
        canvas.height = video.videoHeight || 720;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        capturedDataUrl = canvas.toDataURL('image/jpeg', 0.90);

        // Tampilkan di canvas checking
        canvas.style.display = 'block';

        stopCamera();
        showState('checking');
        ocrStatusEl.textContent = 'Memuat mesin OCR...';

        await runKtpOcr(capturedDataUrl);
    });

    // --- Batal Kamera ---
    document.getElementById('closeCameraBtn').addEventListener('click', function () {
        stopCamera();
        showState('placeholder');
    });

    // --- Ulangi Foto ---
    document.getElementById('retakeBtn').addEventListener('click', function () {
        ktpValidated    = false;
        capturedDataUrl = null;
        ktpBase64Input.value = '';
        canvas.style.display = 'none';
        openCamera();
    });

    // --- OCR Validation Menggunakan Tesseract.js ---
    async function runKtpOcr(dataUrl) {
        /**
         * Kata kunci KTP Indonesia (versi kapital & huruf kecil dicampur).
         * Minimal 3 dari daftar ini harus ditemukan untuk dianggap valid.
         */
        const KTP_KEYWORDS = [
            'REPUBLIK INDONESIA',
            'INDONESIA',
            'NIK',
            'NAMA',
            'Tempat',
            'Lahir',
            'TTL',
            'Jenis Kelamin',
            'LAKI',
            'PEREMPUAN',
            'Golongan Darah',
            'Alamat',
            'RT',
            'RW',
            'Kel',
            'Kec',
            'Agama',
            'Status Perkawinan',
            'Pekerjaan',
            'Kewarganegaraan',
            'WNI',
            'Berlaku Hingga',
            'SEUMUR HIDUP',
        ];

        try {
            ocrStatusEl.textContent = 'Membaca teks di foto...';

            // Buat worker Tesseract (Bahasa Indonesia + Inggris)
            const worker = await Tesseract.createWorker('ind+eng', 1, {
                logger: m => {
                    if (m.status === 'recognizing text') {
                        const pct = Math.round((m.progress || 0) * 100);
                        ocrStatusEl.textContent = `Membaca teks: ${pct}%`;
                    }
                }
            });

            const { data: { text } } = await worker.recognize(dataUrl);
            await worker.terminate();

            const upperText = text.toUpperCase();

            // Hitung berapa keyword yang ditemukan
            let found = 0;
            let foundWords = [];
            KTP_KEYWORDS.forEach(kw => {
                if (upperText.includes(kw.toUpperCase())) {
                    found++;
                    foundWords.push(kw);
                }
            });

            // Syarat minimum: ditemukan ≥ 3 kata kunci KTP
            const MIN_KEYWORDS = 3;

            if (found >= MIN_KEYWORDS) {
                // ✅ Valid KTP
                ktpValidated = true;
                ktpBase64Input.value = capturedDataUrl;

                // Salin gambar ke canvasResult untuk ditampilkan
                canvasResult.width  = canvas.width;
                canvasResult.height = canvas.height;
                canvasResult.getContext('2d').drawImage(canvas, 0, 0);
                canvasResult.style.display = 'block';

                showState('result');
            } else {
                // ❌ Bukan KTP
                ktpValidated = false;
                ktpBase64Input.value = '';
                showState('placeholder');

                Swal.fire({
                    icon: 'error',
                    title: '❌ Bukan KTP yang Terdeteksi',
                    html: `
                        <div style="text-align:left; font-size:14px; line-height:1.7;">
                            <p>Sistem tidak dapat mengenali foto ini sebagai <strong>KTP Indonesia</strong>.</p>
                            <br>
                            <p><strong>Kemungkinan penyebab:</strong></p>
                            <ul style="list-style:disc; padding-left:20px; color:#555;">
                                <li>Foto bukan KTP Indonesia</li>
                                <li>KTP terlalu jauh, buram, atau kurang cahaya</li>
                                <li>Sebagian teks KTP tertutup atau terpotong</li>
                                <li>Pantulan cahaya yang menutupi teks</li>
                            </ul>
                            <br>
                            <p><strong>Tips:</strong> Pastikan KTP terlihat jelas, rata, dan semua teks terbaca.</p>
                        </div>
                    `,
                    confirmButtonColor: '#7f1d1d',
                    confirmButtonText: '📷 Ulangi Foto',
                    showCancelButton: true,
                    cancelButtonText: 'Kembali',
                    cancelButtonColor: '#6b7280',
                }).then(result => {
                    if (result.isConfirmed) {
                        openCamera();
                    }
                });
            }

        } catch (err) {
            console.error('OCR Error:', err);
            showState('placeholder');
            Swal.fire({
                icon: 'warning',
                title: 'Gagal Memverifikasi',
                html: 'Terjadi kesalahan saat membaca foto KTP.<br><small>Pastikan koneksi internet stabil, lalu coba lagi.</small>',
                confirmButtonColor: '#7f1d1d',
                confirmButtonText: 'Coba Lagi',
            }).then(() => openCamera());
        }
    }

    // --- Helper: tampilkan state kamera ---
    function showState(state) {
        elPlaceholder.classList.add('hidden');
        elActive.classList.add('hidden');
        elChecking.classList.add('hidden');
        elResult.classList.add('hidden');

        if (state === 'placeholder') elPlaceholder.classList.remove('hidden');
        if (state === 'active')      elActive.classList.remove('hidden');
        if (state === 'checking')    elChecking.classList.remove('hidden');
        if (state === 'result')      elResult.classList.remove('hidden');
    }

    function stopCamera() {
        if (stream) {
            stream.getTracks().forEach(t => t.stop());
            stream = null;
        }
    }

    window.addEventListener('beforeunload', stopCamera);

    // ===========================
    //  Form Submit Validation
    // ===========================
    document.getElementById('registerForm').addEventListener('submit', function (e) {
        if (!ktpValidated || !ktpBase64Input.value) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Foto KTP Belum Diverifikasi',
                html: 'Anda wajib mengambil foto KTP yang <strong>terverifikasi</strong> menggunakan kamera sebelum mendaftar.',
                confirmButtonColor: '#7f1d1d',
                confirmButtonText: '📷 Ambil Foto KTP',
            }).then(() => {
                elPlaceholder.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });
            return;
        }

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