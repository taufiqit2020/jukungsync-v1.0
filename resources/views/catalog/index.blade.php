<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Catalog - PT Utama Madani Raya</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700;800;950&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans min-h-screen flex flex-col antialiased selection:bg-tema-marun selection:text-white" x-data="catalogApp()">

    <!-- Header (Glassmorphism Sticky) -->
    <header class="bg-tema-hitam/95 backdrop-blur-md text-white py-2.5 sm:py-4 px-3 sm:px-6 sticky top-0 z-50 shadow-lg border-b border-white/5">
        <div class="max-w-7xl mx-auto flex justify-between items-center gap-2 sm:gap-4">
            <div class="flex items-center gap-2 sm:gap-3 min-w-0">
                <div class="bg-white/95 rounded-lg sm:rounded-xl p-1.5 sm:p-2 shadow-md border border-white/20 flex items-center justify-center flex-shrink-0 hover:rotate-2 transition-transform">
                    <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo UMAR" class="h-6 sm:h-8 object-contain">
                </div>
                <div class="flex flex-col justify-center min-w-0">
                    <span class="text-[8px] sm:text-[9px] text-tema-kuning font-black tracking-widest uppercase mb-0.5 truncate">Powered by JukungSync</span>
                    <h1 class="font-heading font-black text-sm sm:text-xl leading-tight -mt-0.5 sm:-mt-1 tracking-tight truncate">E-Catalog UMAR<span class="text-tema-kuning">.</span></h1>
                    <div class="flex items-center gap-1 sm:gap-2 mt-0.5 min-w-0">
                        <p class="text-[9px] sm:text-[10px] text-gray-400 truncate">Halo, <span class="font-bold text-white">{{ auth()->user()->name ?? 'Tamu' }}</span></p>
                        @if(auth()->user()->tipe_pelanggan === 'premium')
                            <span class="inline-flex items-center bg-gradient-to-r from-amber-500 to-yellow-400 text-tema-hitam text-[8px] font-black px-1.5 py-0.5 rounded-full shadow-sm border border-amber-300 tracking-wider">🌟 Premium</span>
                        @elseif(auth()->user()->tipe_pelanggan === 'member')
                            <span class="inline-flex items-center bg-blue-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded-full shadow-sm border border-blue-500 tracking-wider">🔵 Member</span>
                        @else
                            <span class="inline-flex items-center bg-gray-700 text-gray-300 text-[8px] font-semibold px-1.5 py-0.5 rounded-full border border-gray-600">REG</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-1.5 sm:gap-4 flex-shrink-0">
                <!-- My Orders Button -->
                <a href="{{ route('catalog.orders') }}" class="relative flex items-center gap-1 sm:gap-2 p-1.5 text-gray-300 hover:text-white transition-colors text-xs sm:text-sm font-semibold border-r border-gray-700/60 pr-2.5 sm:pr-4 mr-0.5 sm:mr-2">
                    <svg class="w-4.5 h-4.5 sm:w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span class="hidden md:inline">Pesanan Saya</span>
                    
                    @php
                        $activeOrdersCount = \App\Models\Invoice::where('klien_id', auth()->id())
                            ->where('jenis_transaksi', 'online')
                            ->whereIn('status_pesanan', ['menunggu_konfirmasi', 'diproses'])
                            ->count();
                    @endphp
                    @if($activeOrdersCount > 0)
                        <span class="absolute top-0 right-1 -mt-0.5 -mr-0.5 sm:-mr-1 bg-tema-marun text-white text-[8px] sm:text-[9px] font-bold w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full flex items-center justify-center shadow-md animate-pulse">{{ $activeOrdersCount }}</span>
                    @endif
                </a>

                <!-- Cart Button -->
                <button @click="cartOpen = true" class="relative p-1.5 text-gray-300 hover:text-white transition-colors mr-1 sm:mr-2">
                    <svg class="w-5.5 h-5.5 sm:w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span x-show="totalItems > 0" x-text="totalItems" class="absolute top-0 right-0 -mt-0.5 -mr-0.5 sm:-mr-1 bg-tema-marun text-white text-[8px] sm:text-[9px] font-bold w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full flex items-center justify-center shadow-sm"></span>
                </button>

                <a href="{{ route('profile.edit') }}" class="text-xs sm:text-sm font-medium hover:text-tema-kuning flex items-center gap-1 transition-colors mr-1.5 sm:mr-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span class="hidden sm:inline">Profil</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-gray-800 hover:bg-black text-[9px] sm:text-[10px] font-bold px-2.5 py-1.5 rounded-lg transition-colors border border-gray-700/60 flex items-center gap-1">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 py-8">
        
        <!-- ==================== PREMIUM HERO BANNER ==================== -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-tema-hitam via-gray-900 to-tema-marun text-white p-8 sm:p-12 mb-8 shadow-xl border border-white/5">
            <!-- Luxury glow backgrounds -->
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-tema-kuning/5 rounded-full blur-3xl"></div>
            <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-tema-marun/15 rounded-full blur-3xl"></div>
            
            <div class="relative z-10 max-w-2xl">
                <span class="text-xs font-black text-tema-kuning uppercase tracking-[0.25em] mb-3 block">Mitra Distribusi Terpercaya</span>
                <h2 class="text-3xl sm:text-4xl font-heading font-black tracking-tight mb-4 leading-tight">
                    Belanja Kebutuhan Grosir <br class="hidden sm:inline"> Jadi Lebih Cepat & Mudah
                </h2>
                <p class="text-sm text-gray-300 font-medium leading-relaxed mb-6">
                    Selamat datang di layanan E-Catalog resmi PT Utama Madani Raya. Dapatkan harga grosir instan yang otomatis disesuaikan dengan kuantitas belanja Anda secara langsung.
                </p>
                <div class="flex flex-wrap gap-3">
                    <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-xl px-4 py-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-tema-kuning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        <span class="text-xs font-bold tracking-wide">100% Produk Original</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md border border-white/10 rounded-xl px-4 py-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-tema-kuning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-xs font-bold tracking-wide">Harga Grosir Otomatis</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Search & Filter Card -->
        <div class="mb-8 bg-white p-5 rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.02)] border border-gray-100 flex flex-col md:flex-row gap-4 items-center justify-between">
            <div>
                <h2 class="text-xl font-heading font-bold text-gray-800 tracking-tight">Katalog Produk</h2>
                <p class="text-xs text-gray-500 mt-0.5">Pilih produk dan masukkan kuantitas untuk checkout</p>
            </div>
            
            <form method="GET" action="{{ route('catalog.index') }}" class="w-full md:w-auto flex relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama barang atau SKU..." class="w-full md:w-80 pl-10 pr-16 py-2.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm focus:ring-tema-marun focus:border-tema-marun focus:bg-white outline-none transition-all">
                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <button type="submit" class="absolute right-2 top-1.5 bottom-1.5 bg-tema-hitam text-white text-xs px-3 rounded-xl hover:bg-black transition-colors font-bold shadow-sm">Cari</button>
            </form>
        </div>

        <!-- Categories Filter / Sticky Pills -->
        @if($groupedProducts->isNotEmpty())
        <div class="mb-8 flex gap-3 overflow-x-auto pb-3 pt-3 sticky top-[52px] sm:top-[76px] z-40 bg-gray-50/95 backdrop-blur-md -mx-4 px-4 sm:-mx-6 sm:px-6 border-b border-gray-200/50 shadow-[0_4px_12px_rgba(0,0,0,0.02)] scrollbar-hide" style="-ms-overflow-style: none; scrollbar-width: none;">
            <style>
                .scrollbar-hide::-webkit-scrollbar { display: none; }
            </style>
            <a href="#" @click.prevent="activeCategory = 'all'; window.scrollTo({top: 0, behavior: 'smooth'})" :class="activeCategory === 'all' ? 'bg-tema-marun text-white border-tema-marun shadow-md' : 'bg-white border-gray-200 text-gray-600 hover:border-tema-marun hover:text-tema-marun'" class="px-5 py-2.5 text-xs font-black uppercase tracking-wider rounded-full whitespace-nowrap shadow-sm hover:scale-105 transition-all flex-shrink-0 border">Semua Kategori</a>
            @foreach($groupedProducts->keys() as $kategoriName)
                @php $slug = Str::slug($kategoriName); @endphp
                <a href="#cat-{{ $slug }}" @click="activeCategory = '{{ $slug }}'" :class="activeCategory === '{{ $slug }}' ? 'bg-tema-marun text-white border-tema-marun shadow-md' : 'bg-white border-gray-200/80 text-gray-600 hover:border-tema-marun hover:text-tema-marun'" class="px-5 py-2.5 text-xs font-black uppercase tracking-wider rounded-full whitespace-nowrap shadow-sm hover:scale-105 transition-all flex-shrink-0 border">{{ $kategoriName }}</a>
            @endforeach
        </div>
        @endif

        <!-- Product Grid by Category -->
        <div class="space-y-12">
            @forelse($groupedProducts as $kategoriName => $productsGroup)
            <div id="cat-{{ Str::slug($kategoriName) }}" class="scroll-mt-[150px]">
                <!-- Category Header -->
                <div class="flex items-center justify-between mb-6 border-b border-gray-200/60 pb-3">
                    <h3 class="text-2xl font-heading font-black text-gray-800 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-tema-marun rounded-full"></span>
                        {{ $kategoriName }}
                    </h3>
                    <span class="bg-white text-gray-600 text-xs font-black px-3.5 py-1.5 rounded-full border border-gray-200 shadow-sm">{{ $productsGroup->count() }} Produk</span>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($productsGroup as $product)
                        @php
                            $productData = [
                                'id' => $product->id,
                                'name' => $product->nama_barang,
                                'sku' => $product->sku,
                                'category' => $product->category->nama_kategori ?? 'Umum',
                                'categorySlug' => Str::slug($product->category->nama_kategori ?? 'Umum'),
                                'description' => nl2br($product->deskripsi ?? 'Tidak ada deskripsi tersedia untuk produk ini.'),
                                'retailPrice' => $product->harga_jual,
                                'wholesalePrice' => $product->harga_grosir ?? 0,
                                'formattedRetailPrice' => number_format($product->harga_jual, 0, ',', '.'),
                                'formattedWholesalePrice' => $product->harga_grosir ? number_format($product->harga_grosir, 0, ',', '.') : '0',
                                'stock' => $product->stok_saat_ini,
                                'image' => $product->gambar ? asset('storage/' . $product->gambar) : ''
                            ];
                        @endphp
                        <div class="bg-white rounded-3xl shadow-[0_4px_20px_rgba(0,0,0,0.02)] border border-gray-100 overflow-hidden group hover:shadow-[0_20px_40px_rgba(127,29,29,0.08)] -translate-y-0 hover:-translate-y-1.5 transition-all duration-300 flex flex-col relative cursor-pointer" @click="openProductModal({{ json_encode($productData) }})">
                            <!-- Stock Badges -->
                            @if($product->stok_saat_ini > 0 && $product->stok_saat_ini < 5)
                                <div class="absolute top-3 right-3 z-10">
                                    <span class="bg-orange-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm">Stok Menipis</span>
                                </div>
                            @elseif($product->stok_saat_ini >= 50)
                                <div class="absolute top-3 right-3 z-10">
                                    <span class="bg-green-600 text-white text-[10px] font-bold px-2.5 py-1 rounded-full shadow-sm">Stok Tersedia</span>
                                </div>
                            @endif

                            <div class="h-48 bg-gray-50 flex items-center justify-center relative overflow-hidden border-b border-gray-100 p-4">
                                @if($product->gambar)
                                    <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama_barang }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                @endif
                                @if($product->stok_saat_ini <= 0)
                                    <div class="absolute inset-0 bg-white/70 backdrop-blur-[1px] flex items-center justify-center z-10">
                                        <span class="bg-red-500 text-white text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-wider shadow-md">Stok Habis</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-5 flex-1 flex flex-col">
                                <p @click.stop="filterCategoryFromModal('{{ Str::slug($product->category->nama_kategori ?? 'Umum') }}')" class="text-[9px] font-bold text-gray-400 hover:text-tema-marun uppercase tracking-widest mb-1 cursor-pointer transition-colors">{{ $product->category->nama_kategori ?? 'Umum' }}</p>
                                <h3 class="font-bold text-gray-800 leading-tight mb-3 flex-1 group-hover:text-tema-marun transition-colors line-clamp-2">{{ $product->nama_barang }}</h3>
                                
                                <div class="flex flex-col gap-2 mt-auto">
                                    <div>
                                        <p class="text-base font-black text-tema-marun">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</p>
                                        @if($product->harga_grosir > 0)
                                            <p class="text-[9px] font-bold text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded inline-block mt-1">
                                                Grosir: Rp {{ number_format($product->harga_grosir, 0, ',', '.') }} <span class="font-normal text-gray-500 text-[8px]">(Min. 12 Pcs)</span>
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex items-center justify-between mt-1 pt-2 border-t border-gray-100">
                                        <p class="text-xs text-gray-400">Sisa: <span class="font-bold text-gray-600">{{ $product->stok_saat_ini }} Pcs</span></p>
                                        @if($product->stok_saat_ini > 0)
                                            <button @click.stop="addToCart({{ $product->id }}, {{ json_encode($product->nama_barang) }}, {{ $product->harga_jual }}, {{ $product->stok_saat_ini }}, {{ $product->harga_grosir ?? 0 }}, '{{ $product->gambar ? asset('storage/' . $product->gambar) : '' }}')" class="w-9 h-9 bg-gray-100 text-gray-600 group-hover:bg-tema-marun group-hover:text-white rounded-xl flex items-center justify-center transition-all duration-300 shadow-sm hover:scale-105 active:scale-95">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center text-gray-500 bg-white rounded-3xl shadow-sm border border-gray-100">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Pencarian Tidak Ditemukan</h3>
                <p class="text-sm">Tidak ada barang yang cocok dengan kata kunci tersebut.</p>
            </div>
            @endforelse
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 flex flex-col items-center justify-center">
            <p class="text-xs text-gray-500">&copy; {{ date('Y') }} PT Utama Madani Raya. Hak Cipta Dilindungi.</p>
            <p class="text-[10px] text-gray-400 mt-1.5 flex items-center gap-1.5 font-semibold">
                Powered by <span class="font-black text-gray-500 flex items-center gap-1 uppercase tracking-wider text-[9px]"><svg class="w-3.5 h-3.5 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> JukungSync</span>
            </p>
        </div>
    </footer>

    <!-- Shopping Cart Slide-Over Drawer (AlpineJS) -->
    <div x-show="cartOpen" class="fixed inset-0 z-[60] overflow-hidden" style="display: none;">
        <div x-show="cartOpen" x-transition.opacity class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="cartOpen = false"></div>
        
        <div class="absolute inset-y-0 right-0 max-w-md w-full bg-white shadow-2xl flex flex-col transform transition-transform"
             x-show="cartOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full">
            
            <!-- Cart Header -->
            <div class="px-6 py-5 bg-gray-50 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-heading font-black text-gray-800">Keranjang Belanja</h2>
                    <p class="text-xs text-gray-400 mt-0.5" x-text="totalItems + ' item dipilih'"></p>
                </div>
                <div class="flex items-center gap-2">
                    <button x-show="cart.length > 0" @click="clearCart()" class="text-[11px] font-bold text-red-600 hover:text-red-800 hover:bg-red-50 px-2.5 py-1.5 rounded-xl border border-red-200 transition-all flex items-center gap-1 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        <span>Bersihkan</span>
                    </button>
                    <button @click="cartOpen = false" class="text-gray-400 hover:text-red-500 transition-colors w-8 h-8 rounded-full bg-gray-100 hover:bg-red-50 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                
                <!-- Success State -->
                <template x-if="successMessage">
                    <div class="flex flex-col items-center justify-center h-full text-center py-12">
                        <div class="w-20 h-20 bg-green-100 text-green-500 rounded-full flex items-center justify-center mb-5 mx-auto">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <h3 class="text-2xl font-black text-gray-800 mb-2">Hore, Pesanan Terkirim!</h3>
                        <p class="text-sm text-gray-500 font-medium px-4" x-text="successMessage"></p>
                    </div>
                </template>

                <template x-if="cart.length === 0 && !successMessage">
                    <div class="text-center py-20 text-gray-400 flex flex-col items-center justify-center h-full">
                        <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        <p class="text-sm font-bold text-gray-500">Keranjang belanja Anda masih kosong.</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-[200px]">Silakan klik tombol tambah (+) pada produk e-catalog.</p>
                    </div>
                </template>

                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex gap-3.5 p-3.5 border border-gray-100 rounded-2xl relative bg-white hover:border-gray-200 hover:shadow-md transition-all duration-300 items-center">
                        <!-- Product Image Thumbnail -->
                        <div class="w-16 h-16 bg-gray-50 rounded-xl flex-shrink-0 flex items-center justify-center border border-gray-100 p-1.5 overflow-hidden">
                            <template x-if="item.image">
                                <img :src="item.image" :alt="item.name" class="w-full h-full object-contain">
                            </template>
                            <template x-if="!item.image">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </template>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="flex-1 min-w-0">
                            <h4 class="text-xs font-bold text-gray-800 leading-tight line-clamp-2" x-text="item.name"></h4>
                            <div class="flex items-center gap-1.5 flex-wrap mt-1">
                                <span class="text-xs text-tema-marun font-black" x-text="'Rp ' + getItemPrice(item).toLocaleString('id-ID')"></span>
                                <template x-if="isItemEligible(item) && item.wholesalePrice > 0">
                                    <span class="text-[8px] bg-amber-50 text-amber-800 px-1.5 py-0.5 rounded font-black border border-amber-200 uppercase tracking-wide">
                                        Grosir <span x-text="diskonRate > 0 ? '+ ' + (diskonRate * 100).toFixed(1) + '%' : ''"></span> Applied
                                    </span>
                                </template>
                            </div>
                            
                            <div class="flex items-center justify-between mt-2.5">
                                <!-- Qty Counter -->
                                <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden shadow-sm bg-gray-50">
                                    <button type="button" @click="updateQty(index, -1)" class="w-7 h-7 flex items-center justify-center hover:bg-gray-200 text-gray-600 font-bold transition-colors text-xs">-</button>
                                    <input type="number" x-model.number="item.qty" class="w-8 text-center text-[11px] py-0.5 border-x border-gray-200 focus:outline-none bg-white font-bold" min="1" :max="item.maxStok" readonly>
                                    <button type="button" @click="updateQty(index, 1)" class="w-7 h-7 flex items-center justify-center hover:bg-gray-200 text-gray-600 font-bold transition-colors text-xs">+</button>
                                </div>
                                
                                <span class="text-[9px] text-gray-400 font-semibold">Stok: <span class="text-gray-600 font-bold" x-text="item.maxStok"></span></span>
                            </div>
                        </div>
                        
                        <!-- Delete & Total Subprice -->
                        <div class="text-right flex flex-col justify-between h-[84px] self-stretch pl-2">
                            <button @click="removeItem(index)" class="text-gray-400 hover:text-red-500 self-end w-7 h-7 rounded-full bg-gray-50 hover:bg-red-50 flex items-center justify-center transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                            <p class="text-xs font-black text-gray-800" x-text="'Rp ' + (getItemPrice(item) * item.qty).toLocaleString('id-ID')"></p>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Checkout Area -->
            <div class="p-6 bg-gray-50 border-t border-gray-200" x-show="cart.length > 0 && !successMessage">
                <div class="space-y-2 mb-4 border-b border-gray-200/60 pb-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-semibold">Subtotal Belanja</span>
                        <span class="text-gray-800 font-bold" x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="text-gray-500 font-semibold">Estimasi PPN (11%)</span>
                        <span class="text-gray-800 font-bold" x-text="'Rp ' + ppnEstimate.toLocaleString('id-ID')"></span>
                    </div>
                </div>
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-700 text-sm font-black uppercase tracking-wider">Total Pembayaran</p>
                    <p class="text-xl font-black text-tema-marun" x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></p>
                </div>
                <a href="{{ route('catalog.checkout') }}" class="w-full bg-tema-marun hover:bg-red-950 text-white text-sm font-black py-4 rounded-2xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5 active:scale-95 duration-200">
                    <span>Lanjut ke Checkout</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Product Detail Modal (AlpineJS) -->
    <div x-show="productModalOpen" class="fixed inset-0 z-[70] overflow-hidden flex items-center justify-center p-4 sm:p-6" style="display: none;">
        <div x-show="productModalOpen" x-transition.opacity class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" @click="productModalOpen = false"></div>
        
        <div class="relative bg-white rounded-3xl shadow-2xl max-w-3xl w-full max-h-full overflow-hidden flex flex-col sm:flex-row transform transition-all border border-gray-100"
             x-show="productModalOpen"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
             
            <!-- Close Button -->
            <button @click="productModalOpen = false" class="absolute top-4 right-4 z-10 w-9 h-9 bg-black/10 hover:bg-black/25 text-white rounded-full flex items-center justify-center backdrop-blur-md transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <!-- Product Image -->
            <div class="w-full sm:w-2/5 bg-gray-50 border-r border-gray-100 flex-shrink-0 flex items-center justify-center relative min-h-[240px] sm:min-h-0 p-8">
                <template x-if="activeProduct?.image">
                    <img :src="activeProduct.image" :alt="activeProduct?.name" class="absolute inset-0 w-full h-full p-8 object-contain">
                </template>
                <template x-if="!activeProduct?.image">
                    <svg class="w-20 h-20 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </template>
            </div>

            <!-- Product Details -->
            <div class="w-full sm:w-3/5 p-6 sm:p-8 flex flex-col overflow-y-auto">
                <div class="mb-4">
                    <button @click="filterCategoryFromModal(activeProduct?.categorySlug)" class="inline-block bg-gray-100 hover:bg-tema-marun hover:text-white text-gray-600 text-[10px] font-black px-2.5 py-1 rounded-md mb-2 uppercase tracking-widest border border-gray-200 hover:border-tema-marun shadow-sm transition-colors cursor-pointer self-start" x-text="activeProduct?.category"></button>
                    <h3 class="text-xl sm:text-2xl font-heading font-black text-gray-800 leading-tight mb-2" x-text="activeProduct?.name"></h3>
                    <p class="text-xs font-bold text-gray-400" x-text="'SKU: ' + activeProduct?.sku"></p>
                </div>
                
                <div class="mb-6">
                    <div class="flex flex-col gap-1 mb-2">
                        <p class="text-3xl font-black text-tema-marun" x-text="activeProduct ? 'Rp ' + activeProduct.formattedRetailPrice : ''"></p>
                        <template x-if="activeProduct?.wholesalePrice > 0">
                            <p class="text-xs font-bold text-amber-700 bg-amber-50 border border-amber-200 px-3 py-1 rounded-xl inline-block self-start mt-1">
                                Harga Grosir: <span class="font-black" x-text="'Rp ' + activeProduct.formattedWholesalePrice"></span> <span class="font-normal text-gray-500">(Min. 12 Pcs)</span>
                            </p>
                        </template>
                    </div>
                    <p class="text-xs font-bold uppercase tracking-wider" :class="activeProduct?.stock > 0 ? 'text-green-600' : 'text-red-500'">
                        <span x-text="activeProduct?.stock > 0 ? '● Stok Tersedia: ' + activeProduct?.stock + ' Pcs' : '● Stok Tidak Tersedia'"></span>
                    </p>
                </div>

                <div class="mb-8 flex-1">
                    <h4 class="text-xs font-black uppercase text-gray-400 tracking-widest mb-2">Deskripsi Produk</h4>
                    <div class="text-sm text-gray-600 leading-relaxed max-h-48 overflow-y-auto prose prose-sm" x-html="activeProduct?.description"></div>
                </div>

                <div class="mt-auto pt-4 border-t border-gray-100">
                    <template x-if="activeProduct?.stock > 0">
                        <button @click="addToCartFromModal()" class="w-full bg-tema-marun hover:bg-red-950 text-white text-sm font-black py-4 rounded-2xl shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2 transform hover:-translate-y-0.5 active:scale-95 duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            Masukkan Keranjang
                        </button>
                    </template>
                    <template x-if="activeProduct?.stock <= 0">
                        <button disabled class="w-full bg-gray-200 text-gray-500 text-sm font-bold py-4 rounded-2xl cursor-not-allowed">
                            Stok Tidak Tersedia
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- AlpineJS Logic -->
    <script>
        function catalogApp() {
            return {
                cartOpen: false,
                productModalOpen: false,
                activeProduct: null,
                cart: JSON.parse(localStorage.getItem('jukung_cart') || '[]'),
                isSubmitting: false,
                successMessage: '',
                errorMessage: '',
                activeCategory: window.location.hash ? window.location.hash.replace('#cat-', '') : 'all',
                showScrollTop: false,

                // === CONFIG TIER dari server ===
                tipePelanggan: '{{ auth()->user()->tipe_pelanggan ?? "reguler" }}',
                diskonRate: {{ auth()->user()->getDiskonRate() }},

                init() {
                    this.$watch('cart', value => {
                        localStorage.setItem('jukung_cart', JSON.stringify(value));
                    });
                    window.addEventListener('hashchange', () => {
                        this.activeCategory = window.location.hash ? window.location.hash.replace('#cat-', '') : 'all';
                    });
                    window.addEventListener('scroll', () => {
                        this.showScrollTop = window.scrollY > 400;
                    });
                },

                get totalItems() {
                    return this.cart.reduce((total, item) => total + item.qty, 0);
                },

                getItemPrice(item) {
                    const hargaJual   = item.retailPrice  || 0;
                    const hargaGrosir = item.wholesalePrice || 0;

                    let isEligible = false;
                    if (this.tipePelanggan === 'premium') {
                        isEligible = true;
                    } else if (this.tipePelanggan === 'member' && item.qty >= 12) {
                        isEligible = true;
                    }

                    if (isEligible && hargaGrosir > 0) {
                        return Math.round(hargaGrosir * (1 - this.diskonRate));
                    }
                    return hargaJual;
                },

                isItemEligible(item) {
                    if (this.tipePelanggan === 'premium') return true;
                    if (this.tipePelanggan === 'member' && item.qty >= 12) return true;
                    return false;
                },

                get cartTotal() {
                    return this.cart.reduce((total, item) => total + (this.getItemPrice(item) * item.qty), 0);
                },

                get ppnEstimate() {
                    return this.cartTotal * 0.11;
                },

                addToCart(id, name, retailPrice, maxStok, wholesalePrice = 0, image = '') {
                    const existing = this.cart.find(i => i.id === id);
                    if (existing) {
                        if (existing.qty < maxStok) {
                            existing.qty++;
                            this.cart = [...this.cart];
                        }
                    } else {
                        this.cart.push({ id, name, retailPrice, wholesalePrice, qty: 1, maxStok, image });
                    }
                    this.cartOpen = true;
                    this.successMessage = '';
                },

                updateQty(index, change) {
                    const item = this.cart[index];
                    const newQty = item.qty + change;
                    if (newQty >= 1 && newQty <= item.maxStok) {
                        item.qty = newQty;
                        this.cart = [...this.cart];
                    }
                },

                removeItem(index) {
                    this.cart.splice(index, 1);
                    this.cart = [...this.cart];
                },

                clearCart() {
                    Swal.fire({
                        title: 'Kosongkan Keranjang?',
                        text: "Semua item di keranjang belanja Anda akan dihapus.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#7f1d1d', // marun
                        cancelButtonColor: '#111827', // hitam
                        confirmButtonText: 'Ya, Kosongkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.cart = [];
                            this.successMessage = '';
                            Swal.fire({
                                icon: 'success',
                                title: 'Dibersihkan',
                                text: 'Keranjang belanja Anda telah dikosongkan.',
                                confirmButtonColor: '#111827',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    });
                },

                openProductModal(product) {
                    this.activeProduct = product;
                    this.productModalOpen = true;
                },

                filterCategoryFromModal(categorySlug) {
                    if (!categorySlug) return;
                    this.productModalOpen = false;
                    this.activeCategory = categorySlug;
                    
                    const element = document.getElementById('cat-' + categorySlug);
                    if (element) {
                        setTimeout(() => {
                            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            window.location.hash = 'cat-' + categorySlug;
                        }, 150);
                    }
                },

                addToCartFromModal() {
                    if (this.activeProduct && this.activeProduct.stock > 0) {
                        this.addToCart(
                            this.activeProduct.id, 
                            this.activeProduct.name, 
                            this.activeProduct.retailPrice, 
                            this.activeProduct.stock, 
                            this.activeProduct.wholesalePrice,
                            this.activeProduct.image
                        );
                        this.productModalOpen = false;
                    }
                }
            }
        }
    </script>

    <!-- SweetAlert2 untuk Notifikasi -->
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

    <!-- Scroll To Top Button -->
    <button x-show="showScrollTop" @click="window.scrollTo({top: 0, behavior: 'smooth'})" x-transition.opacity.scale class="fixed bottom-6 right-6 z-50 w-12 h-12 rounded-full bg-tema-marun hover:bg-red-950 text-white flex items-center justify-center shadow-lg border border-white/10 transition-all duration-300 hover:-translate-y-1 hover:scale-105 active:scale-95" style="display: none;">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
    </button>
</body>
</html>
