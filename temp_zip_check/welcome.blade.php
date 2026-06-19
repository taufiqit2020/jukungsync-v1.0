<!DOCTYPE html>
<html lang="id" class="scroll-smooth overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JukungSync - PT. Utama Madani Raya</title>
    
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Alpine.js untuk Interaktivitas Ringan (Mobile Menu) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-tema-hitam { background-color: #1a1a1a; }
        .text-tema-hitam { color: #1a1a1a; }
        .bg-tema-marun { background-color: #7f1d1d; }
        .text-tema-marun { color: #7f1d1d; }
        .bg-tema-kuning { background-color: #fbbf24; }
        .text-tema-kuning { color: #fbbf24; }
        
        /* Custom Gradient for Hero */
        .hero-gradient {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        }
        .text-gradient {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800 overflow-x-hidden" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    <!-- Navbar -->
    <nav :class="{ 'bg-white shadow-md py-3': scrolled, 'bg-transparent py-5': !scrolled }" class="fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-white rounded-xl shadow-lg border border-gray-100 flex items-center justify-center p-1.5 transition-transform hover:scale-105">
                        <img src="{{ asset('img/watermark-tengah.png') }}" alt="Logo PT UMAR" class="w-full h-full object-contain drop-shadow-sm">
                    </div>
                    <div class="flex flex-col justify-center">
                        <span :class="{ 'text-tema-hitam': scrolled, 'text-white': !scrolled }" class="font-black text-xl tracking-tight transition-colors leading-none mb-0.5">
                            PT. UMAR
                        </span>
                        <span :class="{ 'text-tema-marun': scrolled, 'text-tema-kuning': !scrolled }" class="text-xs font-bold tracking-widest uppercase transition-colors">
                            JukungSync
                        </span>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#beranda" :class="{ 'text-gray-600 hover:text-tema-marun': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="text-sm font-semibold transition-colors">Beranda</a>
                    <a href="#tentang" :class="{ 'text-gray-600 hover:text-tema-marun': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="text-sm font-semibold transition-colors">Tentang Kami</a>
                    <a href="#layanan" :class="{ 'text-gray-600 hover:text-tema-marun': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="text-sm font-semibold transition-colors">Layanan</a>
                    <a href="#kontak" :class="{ 'text-gray-600 hover:text-tema-marun': scrolled, 'text-gray-200 hover:text-white': !scrolled }" class="text-sm font-semibold transition-colors">Kontak</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <a href="{{ route('catalog.index') }}" class="bg-tema-kuning hover:bg-yellow-500 text-black px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                                E-Catalog
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white backdrop-blur-sm border border-white/20 px-5 py-2.5 rounded-xl text-sm font-bold transition-all">
                                Dashboard ERP
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold px-4 py-2 rounded-xl transition-colors" :class="{ 'text-tema-marun hover:bg-red-50': scrolled, 'text-white hover:bg-white/10': !scrolled }">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-tema-kuning hover:bg-yellow-500 text-black px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            Daftar Klien
                        </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" :class="{ 'text-tema-hitam': scrolled, 'text-white': !scrolled }" class="focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!mobileMenuOpen">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="mobileMenuOpen" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden absolute top-full left-0 w-full bg-white shadow-xl border-t border-gray-100" style="display: none;">
            <div class="px-4 pt-2 pb-6 space-y-1">
                <a href="#beranda" @click="mobileMenuOpen = false" class="block px-3 py-3 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg">Beranda</a>
                <a href="#tentang" @click="mobileMenuOpen = false" class="block px-3 py-3 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg">Tentang Kami</a>
                <a href="#layanan" @click="mobileMenuOpen = false" class="block px-3 py-3 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg">Layanan</a>
                <a href="#kontak" @click="mobileMenuOpen = false" class="block px-3 py-3 text-base font-semibold text-gray-800 hover:bg-gray-50 rounded-lg">Kontak</a>
                <div class="pt-4 mt-2 border-t border-gray-100 flex flex-col gap-3">
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <a href="{{ route('catalog.index') }}" class="block text-center bg-tema-kuning text-black px-5 py-3 rounded-xl text-base font-bold shadow-sm">
                                Buka E-Catalog
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="block text-center bg-tema-hitam text-white px-5 py-3 rounded-xl text-base font-bold shadow-sm">
                                Dashboard ERP
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="block text-center border border-gray-300 text-gray-800 px-5 py-3 rounded-xl text-base font-bold">
                            Masuk / Login
                        </a>
                        <a href="{{ route('register') }}" class="block text-center bg-tema-kuning text-black px-5 py-3 rounded-xl text-base font-bold shadow-sm">
                            Daftar Klien Baru
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-gradient">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-tema-marun/20 rounded-full blur-3xl -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-tema-kuning/10 rounded-full blur-3xl -ml-20 -mb-20"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto">
                <span class="inline-block py-1.5 px-4 rounded-full bg-white/10 border border-white/20 text-tema-kuning text-sm font-bold tracking-wide uppercase mb-6 backdrop-blur-sm">
                    Mitra Pengadaan & Distributor Resmi
                </span>
                <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white leading-tight mb-8 tracking-tight">
                    Solusi Distribusi Terpadu <br class="hidden md:block"/>
                    <span class="text-gradient">Untuk Skala Bisnis Besar, Menengah, & Kecil</span>
                </h1>
                <p class="text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto leading-relaxed">
                    PT. Utama Madani Raya berkomitmen penuh menghadirkan produk berkualitas unggul dengan efisiensi rantai pasok yang andal, transparan, dan terintegrasi secara digital.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        @if(auth()->user()->role === 'customer')
                            <a href="{{ route('catalog.index') }}" class="w-full sm:w-auto px-8 py-4 bg-tema-kuning hover:bg-yellow-500 text-black rounded-2xl text-lg font-black shadow-xl shadow-yellow-500/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                                Buka E-Catalog
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="w-full sm:w-auto px-8 py-4 bg-tema-kuning hover:bg-yellow-500 text-black rounded-2xl text-lg font-black shadow-xl shadow-yellow-500/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                Masuk Dashboard
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-tema-kuning hover:bg-yellow-500 text-black rounded-2xl text-lg font-black shadow-xl shadow-yellow-500/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            Jelajahi Katalog
                        </a>
                    @endauth
                    
                    <a href="#tentang" class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 text-white border border-white/20 backdrop-blur-sm rounded-2xl text-lg font-bold transition-all">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Logo Cloud (Mitra/Brands) -->
    <section class="py-10 bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm font-bold text-gray-400 uppercase tracking-widest mb-6">Mendistribusikan Berbagai Merek Terkemuka</p>
            <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-50 grayscale">
                <!-- Placeholder SVG Logos -->
                <svg class="h-8 md:h-10 text-gray-800" viewBox="0 0 100 30" fill="currentColor"><path d="M10 15a5 5 0 100-10 5 5 0 000 10zm0 15a5 5 0 100-10 5 5 0 000 10zm15-15a5 5 0 100-10 5 5 0 000 10zm15 15a5 5 0 100-10 5 5 0 000 10z"/></svg>
                <svg class="h-8 md:h-10 text-gray-800" viewBox="0 0 100 30" fill="currentColor"><rect width="30" height="30" rx="5"/><circle cx="50" cy="15" r="10"/><polygon points="75,5 95,5 85,25"/></svg>
                <svg class="h-8 md:h-10 text-gray-800" viewBox="0 0 100 30" fill="currentColor"><path d="M0 0h20v30H0zM30 10h20v20H30zM60 20h20v10H60z"/></svg>
                <svg class="h-8 md:h-10 text-gray-800" viewBox="0 0 100 30" fill="currentColor"><ellipse cx="50" cy="15" rx="40" ry="15" fill="none" stroke="currentColor" stroke-width="4"/><circle cx="50" cy="15" r="5"/></svg>
            </div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section id="tentang" class="py-20 lg:py-32 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="relative">
                    <div class="aspect-square rounded-3xl overflow-hidden shadow-2xl relative z-10">
                        <img src="{{ asset('img/profil-umar-pro.png') }}" alt="Gudang Distribusi PT UMAR" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-tema-hitam/80 to-transparent"></div>
                        <div class="absolute bottom-8 left-8 right-8">
                            <p class="text-white font-bold text-xl">Infrastruktur Modern</p>
                            <p class="text-gray-300 text-sm mt-1">Gudang berkapasitas besar dengan manajemen stok digital terintegrasi.</p>
                        </div>
                    </div>
                    <!-- Dekorasi -->
                    <div class="absolute -top-6 -right-6 w-32 h-32 bg-tema-kuning rounded-2xl -z-10 rotate-12 opacity-50"></div>
                    <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-tema-marun rounded-2xl -z-10 -rotate-12 opacity-50"></div>
                </div>
                
                <div>
                    <span class="text-tema-marun font-black uppercase tracking-wider text-sm mb-3 block">Tentang Kami</span>
                    <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6 leading-tight">Membangun Rantai Pasok Yang <span class="text-tema-marun">Kuat & Efisien</span></h2>
                    <p class="text-gray-600 text-base md:text-lg mb-5 leading-relaxed">
                        <strong class="text-gray-800">PT. Utama Madani Raya (UMAR)</strong> adalah perusahaan distributor dan mitra pengadaan resmi yang bergerak di bidang penyediaan berbagai kebutuhan barang untuk instansi, rumah sakit, dan pelaku usaha di wilayah <strong class="text-gray-800">Kalimantan Selatan</strong>. Berdiri dengan semangat melayani, kami berkomitmen menghadirkan produk berkualitas tinggi dengan harga yang kompetitif dan pengiriman yang tepat waktu.
                    </p>
                    <p class="text-gray-600 text-base md:text-lg mb-5 leading-relaxed">
                        Berkantor pusat di <strong class="text-gray-800">Jl. Panglima Batur, Kelurahan Loktabat Utara, Kecamatan Banjarbaru Utara, Kota Banjarbaru, Provinsi Kalimantan Selatan</strong>, kami didukung oleh infrastruktur pergudangan modern dan armada logistik internal yang siap menjangkau seluruh wilayah Kalimantan Selatan dan sekitarnya.
                    </p>
                    <p class="text-gray-600 text-base md:text-lg mb-8 leading-relaxed">
                        Seluruh operasional kami diperkuat oleh sistem <strong class="text-gray-800">Enterprise Resource Planning (ERP)</strong> buatan mandiri, sehingga setiap pergerakan stok, faktur, dan pesanan pelanggan terpantau secara <em>real-time</em> untuk menjamin transparansi dan akurasi layanan.
                    </p>
                    
                    <div class="grid grid-cols-2 gap-6">
                        <div class="border-l-4 border-tema-kuning pl-4">
                            <h4 class="text-3xl font-black text-gray-900">500+</h4>
                            <p class="text-sm font-semibold text-gray-500 mt-1">Klien B2B Aktif</p>
                        </div>
                        <div class="border-l-4 border-tema-marun pl-4">
                            <h4 class="text-3xl font-black text-gray-900">99%</h4>
                            <p class="text-sm font-semibold text-gray-500 mt-1">Ketepatan Waktu Pengiriman</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filosofi JukungSync -->
    <section class="py-20 lg:py-28 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-tema-kuning font-black uppercase tracking-wider text-sm mb-3 block">Filosofi Aplikasi</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-4 leading-tight">Mengapa Dinamakan <span class="text-tema-marun">JukungSync</span>?</h2>
            </div>
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-3xl p-8 md:p-12 border border-gray-200 shadow-lg relative overflow-hidden">
                <!-- Dekorasi wave -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-tema-kuning/5 rounded-full blur-3xl -mr-20 -mt-20"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-tema-marun/5 rounded-full blur-3xl -ml-10 -mb-10"></div>
                
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8 md:gap-12">
                    <!-- Icon Jukung -->
                    <div class="flex-shrink-0">
                        <div class="w-28 h-28 md:w-36 md:h-36 bg-gradient-to-br from-tema-marun to-red-900 rounded-3xl flex items-center justify-center shadow-xl shadow-red-900/20 rotate-3 hover:rotate-0 transition-transform duration-300">
                            <svg class="w-16 h-16 md:w-20 md:h-20 text-tema-kuning" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 17.5C3 17.5 5.5 20 12 20s9-2.5 9-2.5M3 17.5c0 0 1-3.5 9-3.5s9 3.5 9 3.5M6 14l1-7h10l1 7M12 7V3m0 0l-2 2m2-2l2 2"></path>
                            </svg>
                        </div>
                    </div>
                    <!-- Teks Filosofi -->
                    <div class="flex-1 text-center md:text-left">
                        <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-4">
                            Nama <strong class="text-tema-marun text-xl">JukungSync</strong> lahir dari filosofi yang mendalam tentang kearifan lokal Kalimantan Selatan. <strong class="text-gray-800">Jukung</strong> adalah perahu tradisional khas sungai-sungai Banjar yang telah menjadi urat nadi perdagangan dan penghubung masyarakat selama berabad-abad &mdash; lincah, tangguh, dan selalu menemukan jalur terbaik di setiap aliran sungai.
                        </p>
                        <p class="text-gray-700 text-base md:text-lg leading-relaxed mb-4">
                            Kata <strong class="text-gray-800">Sync</strong> (sinkronisasi) melambangkan keselarasan digital: data yang terhubung, informasi yang <em>real-time</em>, dan koordinasi yang mulus antara gudang, administrasi, dan pelanggan.
                        </p>
                        <p class="text-gray-700 text-base md:text-lg leading-relaxed">
                            Gabungan keduanya, <strong class="text-tema-marun">JukungSync</strong>, merepresentasikan visi kami: <em class="text-gray-800 not-italic font-semibold">"Pergerakan logistik yang lancar dan tersinkronisasi, layaknya perahu Jukung yang melaju gesit di sungai-sungai Kalimantan Selatan &mdash; menghubungkan setiap titik distribusi dengan efisien, andal, dan penuh kepercayaan."</em>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Layanan / Keunggulan -->
    <section id="layanan" class="py-20 lg:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-tema-kuning font-black uppercase tracking-wider text-sm mb-3 block">Keunggulan Kami</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-6">Mengapa Memilih <span class="text-tema-marun">PT. UMAR</span> Sebagai Mitra Anda?</h2>
                <p class="text-gray-600 text-lg">Kami menghadirkan pengalaman distribusi terbaik dengan memadukan keandalan operasional, teknologi modern, dan layanan yang berpusat pada kepuasan klien.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-transparent hover:border-gray-100 group">
                    <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Kualitas Terjamin</h3>
                    <p class="text-gray-600 leading-relaxed">Seluruh produk melalui proses <em>Quality Control</em> ketat sebelum masuk dan keluar dari gudang kami, memastikan hanya barang terbaik yang sampai ke tangan Anda.</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-transparent hover:border-gray-100 group">
                    <div class="w-14 h-14 bg-tema-kuning/20 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pengiriman Cepat & Tepat</h3>
                    <p class="text-gray-600 leading-relaxed">Armada logistik internal kami siap mendistribusikan pesanan tepat waktu tanpa kompromi, menjangkau seluruh wilayah Kalimantan Selatan dan sekitarnya.</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-transparent hover:border-gray-100 group">
                    <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">E-Catalog Digital</h3>
                    <p class="text-gray-600 leading-relaxed">Pemesanan B2B kini lebih mudah melalui portal digital kami. Cek ketersediaan stok, lihat harga, dan ajukan pesanan langsung secara <em>online</em> kapan saja.</p>
                </div>

                <!-- Card 4 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-transparent hover:border-gray-100 group">
                    <div class="w-14 h-14 bg-red-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Kompetitif</h3>
                    <p class="text-gray-600 leading-relaxed">Hubungan langsung dengan pabrikan dan prinsipal resmi memastikan Anda selalu mendapatkan harga terbaik dan paling kompetitif di pasaran.</p>
                </div>

                <!-- Card 5 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-transparent hover:border-gray-100 group">
                    <div class="w-14 h-14 bg-purple-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Laporan Transparan</h3>
                    <p class="text-gray-600 leading-relaxed">Sistem ERP terintegrasi kami menyediakan laporan transaksi, stok, dan invoice yang akurat dan transparan untuk kepercayaan penuh mitra bisnis kami.</p>
                </div>

                <!-- Card 6 -->
                <div class="bg-gray-50 rounded-3xl p-8 hover:bg-white hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-transparent hover:border-gray-100 group">
                    <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Tim Profesional</h3>
                    <p class="text-gray-600 leading-relaxed">Didukung oleh tim berpengalaman yang siap memberikan konsultasi dan solusi terbaik untuk setiap kebutuhan pengadaan barang perusahaan Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 relative overflow-hidden bg-tema-hitam">
        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-block py-1.5 px-4 rounded-full bg-white/10 border border-white/20 text-tema-kuning text-sm font-bold tracking-wide uppercase mb-6 backdrop-blur-sm">Bergabung Bersama Kami</span>
            <h2 class="text-3xl md:text-5xl font-black text-white mb-6">Siap Bermitra dengan PT. UMAR?</h2>
            <p class="text-xl text-gray-300 mb-10 max-w-2xl mx-auto">Daftarkan perusahaan Anda sekarang dan dapatkan akses eksklusif ke harga grosir, sistem pemesanan digital, serta manajemen invoice yang cerdas dan terintegrasi.</p>
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 flex-wrap">
                <a href="{{ route('register') }}" class="px-8 py-4 bg-tema-kuning hover:bg-yellow-500 text-black rounded-2xl text-lg font-black shadow-xl transition-all transform hover:-translate-y-1 w-full sm:w-auto">
                    Daftar Sebagai Klien
                </a>
                <a href="https://wa.me/6285166657171" target="_blank" class="px-8 py-4 bg-green-600 hover:bg-green-500 text-white rounded-2xl text-lg font-bold transition-all transform hover:-translate-y-1 w-full sm:w-auto flex items-center justify-center gap-2 shadow-xl shadow-green-900/20">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.183-.573c.978.58 1.711.883 2.81.884 3.18 0 5.766-2.585 5.768-5.766 0-3.181-2.585-5.766-5.768-5.766zm3.332 8.163c-.159.453-.94.887-1.319.923-.339.032-.782.1-1.892-.353-1.332-.544-2.181-1.921-2.247-2.009-.065-.088-.535-.713-.535-1.36 0-.648.337-.968.455-1.09.117-.122.254-.153.338-.153s.169-.004.241-.004c.071 0 .17-.027.266.204.098.232.336.822.366.883.03.061.05.132.016.204-.035.071-.05.116-.1.177-.049.061-.106.133-.146.183-.045.051-.093.107-.04.204.053.096.237.396.508.64.351.314.646.406.744.457.098.051.155.04.213-.026.058-.066.248-.285.313-.383.066-.098.131-.082.222-.048.092.034.58.273.68.323s.166.075.19.117c.024.041.024.244-.135.697zm-3.332-10.457c4.619 0 8.375 3.756 8.375 8.375 0 4.619-3.756 8.375-8.375 8.375-1.554 0-3.003-.42-4.238-1.154l-4.708 1.236 1.263-4.593c-.808-1.285-1.268-2.813-1.268-4.464 0-4.619 3.756-8.375 8.375-8.375z"/></svg>
                    Hubungi via WhatsApp
                </a>
                <a href="mailto:ptutamamadaniraya@gmail.com" class="px-8 py-4 bg-transparent hover:bg-white/10 text-white border-2 border-white/30 rounded-2xl text-lg font-bold transition-all w-full sm:w-auto flex items-center justify-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Kirim Email
                </a>
            </div>
        </div>
    </section>

    <!-- Footer / Kontak -->
    <footer id="kontak" class="bg-gray-900 pt-20 pb-10 border-t-4 border-tema-marun">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                <!-- Kolom 1 -->
                <div class="lg:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-14 h-14 bg-white rounded-xl shadow-lg flex items-center justify-center p-2">
                            <img src="{{ asset('img/watermark-tengah.png') }}" alt="Logo PT UMAR" class="w-full h-full object-contain drop-shadow-sm">
                        </div>
                        <div class="flex flex-col justify-center">
                            <span class="text-white font-black text-2xl tracking-tight leading-none mb-1">PT. UMAR</span>
                            <span class="text-tema-kuning text-xs font-bold tracking-widest uppercase">PT. Utama Madani Raya</span>
                        </div>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-sm leading-relaxed">
                        Distributor dan mitra pengadaan resmi yang menyediakan berbagai produk berkualitas untuk kebutuhan bisnis Anda. Didukung sistem ERP <strong class="text-gray-300">JukungSync</strong> yang terintegrasi penuh untuk transparansi dan efisiensi operasional.
                    </p>
                </div>

                <!-- Kolom 2 -->
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Navigasi</h4>
                    <ul class="space-y-3">
                        <li><a href="#beranda" class="text-gray-400 hover:text-tema-kuning transition-colors">Beranda</a></li>
                        <li><a href="#tentang" class="text-gray-400 hover:text-tema-kuning transition-colors">Tentang Perusahaan</a></li>
                        <li><a href="#layanan" class="text-gray-400 hover:text-tema-kuning transition-colors">Keunggulan Kami</a></li>
                        <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-tema-kuning transition-colors">Portal Klien (Login)</a></li>
                        <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-tema-kuning transition-colors">Daftar Akun Baru</a></li>
                    </ul>
                </div>

                <!-- Kolom 3 -->
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm">Hubungi Kami</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-tema-marun flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span class="text-gray-400 text-sm">Jl. Panglima Batur, Kel. Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-tema-marun flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <a href="tel:+6285166657171" class="text-gray-400 hover:text-tema-kuning text-sm transition-colors">0851-6665-7171</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-tema-marun flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <a href="mailto:ptutamamadaniraya@gmail.com" class="text-gray-400 hover:text-tema-kuning text-sm transition-colors">ptutamamadaniraya@gmail.com</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-tema-marun flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                            <a href="https://instagram.com/pt_umar" target="_blank" class="text-gray-400 hover:text-tema-kuning text-sm transition-colors">@pt_umar</a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="pt-8 border-t border-gray-800 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} PT. Utama Madani Raya (UMAR). Seluruh Hak Cipta Dilindungi Undang-Undang.
                </p>
                <div class="text-gray-600 text-sm flex items-center gap-2">
                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Sistem JukungSync Aktif &mdash; ERP & E-Catalog Terintegrasi
                </div>
            </div>
        </div>
    </footer>

    <!-- SweetAlert2 untuk Notifikasi Logout/Lainnya -->
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

</body>
</html>
