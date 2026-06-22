<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JukungSync - @yield('title', 'Admin Panel')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700|outfit:500,600,700,800" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        h1, h2, h3, h4, h5, h6, .font-heading { font-family: 'Outfit', sans-serif; }
        
        /* Custom scrollbar untuk sidebar */
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(251,191,36,0.3); border-radius: 4px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(251,191,36,0.5); }

        /* Active menu glow */
        .menu-active { 
            background: linear-gradient(135deg, rgba(251,191,36,0.15) 0%, rgba(251,191,36,0.05) 100%);
            border-left: 3px solid #FBBF24;
        }
        .menu-item { border-left: 3px solid transparent; }
        .menu-item:hover { 
            background: rgba(255,255,255,0.05);
            border-left-color: rgba(251,191,36,0.4);
        }
    </style>
    <script>
    function globalSearch() {
        return {
            query: '',
            isOpen: false,
            results: { products: [], invoices: [], customers: [] },
            async doSearch() {
                if (this.query.length < 2) { 
                    this.results = { products: [], invoices: [], customers: [] }; 
                    return; 
                }
                try {
                    const res = await fetch('/api/search?q=' + encodeURIComponent(this.query));
                    const data = await res.json();
                    this.results = data.results || { products: [], invoices: [], customers: [] };
                    this.isOpen = true;
                } catch (e) {
                    console.error("Search failed:", e);
                }
            }
        };
    }
    document.addEventListener('alpine:init', () => {
        if (typeof Alpine !== 'undefined') {
            Alpine.data('globalSearch', globalSearch);
        }
    });
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

    <!-- Mobile sidebar backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300" 
         x-transition:enter-start="opacity-0" 
         x-transition:enter-end="opacity-100" 
         x-transition:leave="transition-opacity ease-linear duration-300" 
         x-transition:leave-start="opacity-100" 
         x-transition:leave-end="opacity-0" 
         class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden" 
         @click="sidebarOpen = false" style="display: none;"></div>

    <!-- ==================== ROOT FLEX CONTAINER ==================== -->
    <div class="flex h-screen overflow-hidden">

        <!-- ==================== SIDEBAR ==================== -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-72 flex flex-col bg-gradient-to-b from-tema-hitam via-gray-900 to-tema-hitam transition-transform duration-300 ease-in-out lg:translate-x-0 lg:relative lg:z-auto shadow-2xl flex-shrink-0">
            
            <!-- Logo Area -->
            <div class="flex h-16 items-center px-6 border-b border-white/10 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="bg-white/95 backdrop-blur-sm rounded-xl p-1.5 shadow-[0_0_10px_rgba(255,255,255,0.2)] border border-white/40 flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo UMAR" class="h-7 object-contain">
                    </div>
                    <div>
                        <h1 class="font-heading text-lg font-extrabold tracking-wider text-white leading-tight">JukungSync</h1>
                        <p class="text-[9px] text-tema-kuning/70 font-medium tracking-widest uppercase">PT. Utama Madani Raya</p>
                    </div>
                </div>
                <!-- Close button mobile -->
                <button @click="sidebarOpen = false" class="ml-auto lg:hidden text-gray-400 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto custom-scrollbar">
                
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('dashboard') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </a>

                @if(in_array(auth()->user()->role, ['superadmin', 'staf_admin']))
                <div class="pt-5 pb-2">
                    <p class="px-4 text-[11px] font-bold text-gray-600 uppercase tracking-[0.15em]">Master Data</p>
                </div>
                
                <a href="{{ route('customers.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('customers.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Data Customer
                </a>

                <a href="{{ route('categories.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('categories.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Kategori Barang
                </a>

                <a href="{{ route('merks.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('merks.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    Data Merk
                </a>
                
                <a href="{{ route('products.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('products.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    Data Barang (Stok)
                </a>
                @endif

                <div class="pt-5 pb-2">
                    <p class="px-4 text-[11px] font-bold text-gray-600 uppercase tracking-[0.15em]">Transaksi</p>
                </div>

                @if(in_array(auth()->user()->role, ['superadmin', 'staf_admin', 'bendahara']))
                <a href="{{ route('purchases.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('purchases.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Barang Masuk (Beli)
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['superadmin', 'staf_admin']))
                <a href="{{ route('inventory-movements.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('inventory-movements.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    Mutasi Keluar Manual
                </a>
                @endif

                @if(in_array(auth()->user()->role, ['superadmin', 'bendahara']))
                <a href="{{ route('expenses.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('expenses.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Pengeluaran
                </a>
                @endif

                <a href="{{ route('online-orders.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('online-orders.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="flex-1">Pesanan E-Catalog</span>
                    @php
                        $pendingCount = \App\Models\Invoice::where('jenis_transaksi', 'online')->where('status_pesanan', 'menunggu_konfirmasi')->count();
                    @endphp
                    @if($pendingCount > 0)
                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full min-w-[20px] text-center">{{ $pendingCount }}</span>
                    @endif
                </a>

                <a href="{{ route('invoices.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('invoices.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Invoice
                </a>

                @if(in_array(auth()->user()->role, ['superadmin', 'staf_admin', 'bendahara']))
                <a href="{{ route('kasbons.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('kasbons.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Data Kasbon
                </a>
                @endif

                <div class="pt-5 pb-2">
                    <p class="px-4 text-[11px] font-bold text-gray-600 uppercase tracking-[0.15em]">Analitik</p>
                </div>
                <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.index') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Invoice
                </a>
                @if(in_array(auth()->user()->role, ['superadmin', 'bendahara']))
                <a href="{{ route('reports.bukti-invoices') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.bukti-invoices') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Laporan Bukti Claim
                </a>
                @endif
                <a href="{{ route('reports.online-orders') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.online-orders') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Laporan E-Catalog
                </a>
                <a href="{{ route('reports.purchases') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.purchases') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Laporan Pembelian
                </a>
                
                @if(in_array(auth()->user()->role, ['superadmin', 'bendahara']))
                <a href="{{ route('reports.expenses') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.expenses') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Pengeluaran
                </a>
                @endif
                <a href="{{ route('reports.stock') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.stock') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Kartu Stok
                </a>
                <a href="{{ route('reports.movements') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.movements') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Laporan Mutasi Stok
                </a>
                <a href="{{ route('reports.jatuh-tempo') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('reports.jatuh-tempo') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                    Laporan Jatuh Tempo
                </a>

                @if(auth()->user()->role === 'superadmin')
                <div class="pt-5 pb-2">
                    <p class="px-4 text-[11px] font-bold text-gray-600 uppercase tracking-[0.15em]">Sistem</p>
                </div>
                <a href="{{ route('users.index') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('users.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manajemen Pengguna
                </a>
                <a href="{{ route('settings.landing-page') }}" class="flex items-center px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('settings.*') ? 'menu-active text-tema-kuning' : 'menu-item text-gray-400 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan Landing Page
                </a>
                @endif
            </nav>

            <!-- Sidebar Footer: User Info -->
            <div class="px-5 py-4 border-t border-white/10 flex-shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-tema-marun to-red-900 flex items-center justify-center text-white text-sm font-bold shadow-md flex-shrink-0">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name ?? 'Admin UMAR' }}</p>
                        <p class="text-[11px] text-gray-500 truncate {{ auth()->user()->role === 'bendahara' ? 'uppercase' : 'capitalize' }}">
                            {{ auth()->user()->role === 'bendahara' ? 'KEPALA ADMINISTRASI DAN KEUANGAN' : (auth()->user()->role ?? 'superadmin') }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ==================== RIGHT COLUMN (Navbar + Content + Footer) ==================== -->
        <div class="flex-1 flex flex-col min-h-0 overflow-hidden">
            
            <!-- Top Navbar — tingginya sama dengan logo sidebar (h-16) -->
            <header class="flex h-16 items-center justify-between bg-white border-b border-gray-200 px-4 sm:px-6 lg:px-8 flex-shrink-0 z-10">
                
                <!-- Left: Hamburger + Page Title -->
                <div class="flex items-center gap-4">
                    <button type="button" class="lg:hidden -m-2 p-2 text-gray-600 hover:text-tema-hitam transition-colors" @click="sidebarOpen = true">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                    </button>
                    <h2 class="font-heading text-lg font-semibold text-tema-hitam">@yield('title', 'Admin Panel')</h2>
                </div>
                
                <!-- Right: Date + User + Logout -->
                <div class="flex items-center gap-3 lg:gap-5">
                    <!-- FR-04: Global Search -->
                    <div class="relative hidden md:block" x-data="globalSearch()">
                        <div class="relative">
                            <svg class="absolute left-3 w-4 h-4 text-gray-400" style="top: 50%; transform: translateY(-50%);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            <input type="text" x-model="query" @input.debounce.300ms="doSearch()" @focus="isOpen=true" @keydown.escape="isOpen=false" placeholder="Cari barang, invoice, customer..." class="pr-4 py-2 text-sm border border-gray-200 rounded-xl bg-gray-50 focus:bg-white focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-20 transition-all w-72 outline-none" style="padding-left: 2.5rem;">
                        </div>
                        <!-- Dropdown Results -->
                        <div x-show="isOpen && (results.products.length > 0 || results.invoices.length > 0 || results.customers.length > 0)" 
                             x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0"
                             @click.away="isOpen=false"
                             class="absolute top-full left-0 right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-2xl z-50 max-h-80 overflow-y-auto" style="display:none;">
                            <template x-if="results.products.length > 0">
                                <div>
                                    <div class="px-3 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider bg-gray-50 border-b">📦 Barang</div>
                                    <template x-for="p in results.products" :key="p.id">
                                        <a :href="'/products'" class="flex items-center px-3 py-2 hover:bg-amber-50 transition-colors text-sm gap-2">
                                            <span class="bg-tema-marun text-white text-[10px] font-bold px-1.5 py-0.5 rounded" x-text="p.sku"></span>
                                            <span class="flex-1 font-medium text-gray-800" x-text="p.nama_barang"></span>
                                            <span class="text-xs text-gray-400" x-text="'Stok: ' + p.stok_saat_ini"></span>
                                        </a>
                                    </template>
                                </div>
                            </template>
                            <template x-if="results.invoices.length > 0">
                                <div>
                                    <div class="px-3 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider bg-gray-50 border-b">🧾 Invoice</div>
                                    <template x-for="inv in results.invoices" :key="inv.id">
                                        <a :href="'/invoices/' + inv.id" class="flex items-center px-3 py-2 hover:bg-amber-50 transition-colors text-sm gap-2">
                                            <span class="font-bold text-gray-800" x-text="inv.nomor_invoice"></span>
                                            <span class="text-gray-500 flex-1" x-text="inv.nama_klien"></span>
                                            <span class="text-xs font-semibold text-green-700" x-text="'Rp ' + Number(inv.total_tagihan).toLocaleString('id-ID')"></span>
                                        </a>
                                    </template>
                                </div>
                            </template>
                            <template x-if="results.customers.length > 0">
                                <div>
                                    <div class="px-3 py-2 text-[10px] font-bold text-gray-400 uppercase tracking-wider bg-gray-50 border-b">👤 Customer</div>
                                    <template x-for="c in results.customers" :key="c.id">
                                        <a :href="'/customers'" class="flex items-center px-3 py-2 hover:bg-amber-50 transition-colors text-sm">
                                            <span class="font-medium text-gray-800" x-text="c.nama_klien"></span>
                                        </a>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="hidden md:flex items-center text-sm text-gray-500 gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ now()->translatedFormat('l, d M Y') }}
                    </div>

                    <div class="hidden md:block h-6 w-px bg-gray-200"></div>

                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-tema-kuning to-yellow-500 flex items-center justify-center text-tema-hitam text-xs font-bold shadow-sm">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="hidden sm:block text-sm font-semibold text-gray-700">
                            {{ auth()->user()->name ?? 'Admin UMAR' }}
                        </span>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-1.5 rounded-lg bg-gray-100 hover:bg-gray-200 px-3 py-2 text-sm font-medium text-gray-600 transition-all duration-200 border border-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <span class="hidden sm:inline">Profil</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center gap-1.5 rounded-lg bg-gray-100 hover:bg-red-50 hover:text-red-600 px-3 py-2 text-sm font-medium text-gray-600 transition-all duration-200 border border-gray-200 hover:border-red-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <!-- Main Content Area — scrollable -->
            <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6 lg:p-8">
                <!-- Alert Error -->
                @if(session('error'))
                <div class="mb-6 rounded-lg bg-red-50 p-4 shadow-sm border border-red-200 flex items-start gap-3" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-red-800">{{ session('error') }}</h3>
                    </div>
                    <button @click="show = false" class="text-red-400 hover:text-red-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                @endif

                @if(session('success'))
                <div class="mb-6 rounded-lg bg-emerald-50 p-4 shadow-sm border border-emerald-200 flex items-start gap-3" x-data="{ show: true }" x-show="show" x-transition>
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="h-5 w-5 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-emerald-800">{{ session('success') }}</h3>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                @endif

                <div class="mx-auto max-w-7xl">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="border-t border-gray-200 bg-white px-6 py-3 flex-shrink-0">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-400">
                    <p>&copy; {{ date('Y') }} <span class="font-semibold text-gray-600">PT. Utama Madani Raya</span>. All rights reserved.</p>
                    <p>JukungSync <span class="text-tema-kuning font-bold">v1.0</span> &mdash; ERP Mini & E-Catalog</p>
                </div>
            </footer>
        </div>

    </div>

    <!-- SweetAlert2 untuk Notifikasi Login -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{!! session('success') !!}',
                confirmButtonColor: '#7f1d1d',
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif
</body>
</html>
