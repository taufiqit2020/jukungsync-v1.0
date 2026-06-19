<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Saya - E-Catalog UMAR</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;700;800&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans min-h-screen flex flex-col antialiased selection:bg-tema-marun selection:text-white">

    <!-- Header (Glassmorphism Sticky) -->
    <header class="bg-tema-hitam/95 backdrop-blur-md text-white py-4 px-4 sm:px-6 sticky top-0 z-50 shadow-lg border-b border-white/5">
        <div class="max-w-7xl mx-auto flex justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="{{ route('catalog.index') }}" class="bg-white/95 rounded-xl p-2 shadow-md border border-white/20 flex items-center justify-center flex-shrink-0 hover:rotate-2 transition-transform">
                    <img src="{{ asset('img/invoice-watermark.png') }}" alt="Logo UMAR" class="h-8 object-contain">
                </a>
                <div class="flex flex-col justify-center">
                    <span class="text-[9px] text-tema-kuning font-black tracking-widest uppercase mb-0.5">Powered by JukungSync</span>
                    <h1 class="font-heading font-black text-lg sm:text-xl leading-tight -mt-1 tracking-tight">Riwayat Pesanan<span class="text-tema-kuning">.</span></h1>
                    <div class="flex items-center gap-2 mt-0.5">
                        <p class="text-[10px] text-gray-400">Pelanggan: <span class="font-bold text-white">{{ auth()->user()->name ?? 'Tamu' }}</span></p>
                        @if(auth()->user()->tipe_pelanggan === 'premium')
                            <span class="inline-flex items-center bg-gradient-to-r from-amber-500 to-yellow-400 text-tema-hitam text-[8px] font-black px-1.5 py-0.5 rounded-full shadow-sm border border-amber-300 tracking-wider">🌟 Premium</span>
                        @elseif(auth()->user()->tipe_pelanggan === 'member')
                            <span class="inline-flex items-center bg-blue-600 text-white text-[8px] font-black px-1.5 py-0.5 rounded-full shadow-sm border border-blue-500 tracking-wider">🔵 Member</span>
                        @else
                            <span class="inline-flex items-center bg-gray-700 text-gray-300 text-[8px] font-semibold px-1.5 py-0.5 rounded-full border border-gray-600">REGULER</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex items-center gap-2 sm:gap-4">
                <a href="{{ route('catalog.index') }}" class="text-xs sm:text-sm font-bold bg-gradient-to-r from-tema-kuning to-amber-500 hover:from-yellow-400 hover:to-amber-450 text-tema-hitam px-4 py-2 rounded-xl transition-all shadow-md transform hover:-translate-y-0.5 duration-200 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    <span>Belanja Lagi</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-gray-800 hover:bg-black text-[10px] font-bold px-3 py-2 rounded-xl transition-colors border border-gray-700/60">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-4xl mx-auto w-full p-4 sm:p-6 lg:p-8 mt-6">
        
        @forelse($orders as $order)
        <div class="bg-white border border-gray-100 rounded-3xl mb-8 overflow-hidden shadow-[0_4px_20px_rgba(0,0,0,0.02)] hover:shadow-[0_12px_30px_rgba(0,0,0,0.05)] transition-all duration-300">
            <!-- Order Header -->
            <div class="bg-gray-50/80 border-b border-gray-150 px-5 py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-3 sm:gap-6">
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Tanggal Pesanan</p>
                        <p class="text-xs sm:text-sm font-black text-gray-800">{{ \Carbon\Carbon::parse($order->tanggal_invoice)->translatedFormat('d M Y') }}</p>
                    </div>
                    <div class="hidden sm:block w-px h-8 bg-gray-200"></div>
                    <div>
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider mb-0.5">Nomor Invoice</p>
                        <p class="text-xs sm:text-sm font-extrabold text-tema-marun">{{ $order->nomor_invoice }}</p>
                    </div>
                </div>
                
                <!-- Status Badge -->
                <div>
                    @if($order->status_pesanan === 'menunggu_konfirmasi')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-amber-50 text-amber-800 border border-amber-200 shadow-sm">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-500 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                            </span>
                            Menunggu Konfirmasi
                        </span>
                    @elseif($order->status_pesanan === 'diproses')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-blue-50 text-blue-800 border border-blue-200 shadow-sm">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-500 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                            </span>
                            Diproses
                        </span>
                    @elseif($order->status_pesanan === 'selesai')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-green-50 text-green-800 border border-green-200 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            Selesai
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-red-50 text-red-800 border border-red-200 shadow-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Dibatalkan
                        </span>
                    @endif
                </div>
            </div>
            
            <!-- Visual Stepper Progress -->
            <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/30">
                <div class="max-w-md mx-auto relative flex items-center justify-between">
                    <!-- Background Line -->
                    <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-0.5 bg-gray-200 z-0"></div>
                    
                    <!-- Active Progress Line -->
                    <div class="absolute left-0 top-1/2 -translate-y-1/2 h-0.5 z-0 transition-all duration-500"
                         style="width: 
                         @if($order->status_pesanan === 'menunggu_konfirmasi') 0% 
                         @elseif($order->status_pesanan === 'diproses') 50% 
                         @elseif($order->status_pesanan === 'selesai') 100% 
                         @else 100% @endif;
                         background-color: @if($order->status_pesanan === 'dibatalkan') #ef4444 @else #FBBF24 @endif">
                    </div>
                    
                    <!-- Step 1: Dibuat -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shadow-md border-2 transition-colors duration-300
                             bg-tema-hitam text-white border-tema-hitam">
                            1
                        </div>
                        <span class="text-[10px] font-black text-gray-800 mt-1.5">Dibuat</span>
                    </div>

                    <!-- Step 2: Diproses -->
                    <div class="flex flex-col items-center z-10 relative">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shadow-md border-2 transition-colors duration-300
                             @if($order->status_pesanan === 'diproses' || $order->status_pesanan === 'selesai') bg-tema-hitam text-white border-tema-hitam @else bg-white text-gray-400 border-gray-200 @endif">
                            @if($order->status_pesanan === 'diproses')
                                <span class="relative flex h-3 w-3">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-tema-kuning opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-3 w-3 bg-tema-kuning"></span>
                                </span>
                            @else
                                2
                            @endif
                        </div>
                        <span class="text-[10px] font-black mt-1.5 @if($order->status_pesanan === 'diproses' || $order->status_pesanan === 'selesai') text-gray-800 @else text-gray-400 @endif">Diproses</span>
                    </div>

                    <!-- Step 3: Selesai / Batal -->
                    <div class="flex flex-col items-center z-10 relative">
                        @if($order->status_pesanan === 'dibatalkan')
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shadow-md border-2 bg-red-600 text-white border-red-600">
                                ✕
                            </div>
                            <span class="text-[10px] font-black text-red-600 mt-1.5">Batal</span>
                        @else
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs shadow-md border-2 transition-colors duration-300
                                 @if($order->status_pesanan === 'selesai') bg-tema-marun text-white border-tema-marun @else bg-white text-gray-400 border-gray-200 @endif">
                                3
                            </div>
                            <span class="text-[10px] font-black mt-1.5 @if($order->status_pesanan === 'selesai') text-gray-800 @else text-gray-400 @endif">Selesai</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="px-5 py-4 divide-y divide-gray-100">
                @foreach($order->invoiceItems as $item)
                <div class="py-3.5 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 first:pt-0 last:pb-0">
                    <div class="flex items-center gap-4 flex-1">
                        <!-- Image Thumbnail -->
                        <div class="w-14 h-14 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0 border border-gray-100 p-1 overflow-hidden shadow-sm">
                            @if($item->product && $item->product->gambar)
                                <img src="{{ asset('storage/' . $item->product->gambar) }}" alt="{{ $item->product->nama_barang }}" class="w-full h-full object-contain">
                            @else
                                <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="font-bold text-gray-800 text-sm leading-tight line-clamp-2">{{ $item->product->nama_barang ?? 'Barang Dihapus' }}</h4>
                            <p class="text-xs text-gray-500 mt-1 font-medium">{{ $item->jumlah }} Pcs <span class="text-gray-300 mx-1">|</span> Rp {{ number_format($item->harga_jual_snapshot, 0, ',', '.') }} per pcs</p>
                        </div>
                    </div>
                    <div class="text-right sm:w-36 flex flex-row sm:flex-col justify-between sm:justify-start w-full border-t sm:border-t-0 pt-2 sm:pt-0 border-gray-50">
                        <span class="text-[10px] text-gray-400 uppercase font-bold tracking-wider sm:mb-0.5 block">Subtotal</span>
                        <span class="font-extrabold text-gray-800 text-sm block">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Shipping Details -->
            @if($order->alamat_pengiriman || $order->ekspedisi)
            <div class="px-5 py-4 bg-gray-50/60 border-t border-gray-100 text-xs text-gray-600 grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($order->alamat_pengiriman)
                <div class="bg-white p-3.5 rounded-2xl border border-gray-100 shadow-sm">
                    <span class="font-black text-gray-700 flex items-center gap-1.5 mb-1.5">
                        <svg class="w-4 h-4 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Alamat Pengiriman
                    </span>
                    <span class="leading-relaxed font-medium text-gray-600 block pl-5.5">{{ $order->alamat_pengiriman }}</span>
                </div>
                @endif
                <div class="space-y-3">
                    @if($order->ekspedisi)
                    <div class="bg-white p-3 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-amber-50 border border-amber-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4.5 h-4.5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zm12 0a2 2 0 11-4 0 2 2 0 014 0zm0 0V9a2 2 0 00-2-2h-5M9 7V5a2 2 0 012-2h4a2 2 0 012 2v2m-3 5h3m-6 0h3m-3 0a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="font-black text-gray-700 block text-[10px] uppercase tracking-wider">Metode Pengiriman</span>
                            <span class="font-bold text-gray-600 block mt-0.5 truncate">{{ $order->ekspedisi }}</span>
                        </div>
                    </div>
                    @endif
                    @if($order->catatan_pengiriman)
                    <div class="bg-white p-3 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-red-50 border border-red-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4.5 h-4.5 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="font-black text-gray-700 block text-[10px] uppercase tracking-wider">Catatan Kurir</span>
                            <span class="italic text-gray-500 font-medium block mt-0.5">"{{ $order->catatan_pengiriman }}"</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Order Footer -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100/50 border-t border-gray-150 px-5 py-4 flex flex-col sm:flex-row justify-between items-center gap-3">
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500 font-medium">Metode Pembayaran:</span>
                    @if($order->metode_pembayaran === 'transfer')
                        <span class="bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">Manual Transfer</span>
                    @elseif($order->metode_pembayaran === 'invoice_30_hari')
                        <span class="bg-purple-50 text-purple-700 border border-purple-200 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">Claim Invoice (Tempo)</span>
                    @else
                        <span class="bg-green-50 text-green-700 border border-green-200 text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">Cash / Tunai</span>
                    @endif
                </div>
                <div class="text-right flex items-center gap-4">
                    @if($order->status_pesanan !== 'menunggu_konfirmasi')
                    <a href="{{ route('invoices.surat-jalan', $order->id) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-tema-marun hover:bg-red-800 text-white font-bold text-xs rounded-xl shadow-sm transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        <span>Cetak Tanda Terima</span>
                    </a>
                    @endif
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Total Pembayaran</span>
                        <span class="text-xl font-black text-tema-marun">Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white border border-gray-100 rounded-3xl p-12 text-center shadow-lg relative overflow-hidden max-w-xl mx-auto my-12">
            <div class="absolute -right-16 -top-16 w-40 h-40 bg-tema-kuning/5 rounded-full blur-2xl"></div>
            <div class="absolute -left-16 -bottom-16 w-40 h-40 bg-tema-marun/5 rounded-full blur-2xl"></div>
            
            <div class="w-20 h-20 bg-gray-50 rounded-2xl flex items-center justify-center mx-auto mb-6 border border-gray-100 shadow-sm relative z-10">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            
            <h3 class="text-xl font-heading font-black text-gray-800 mb-2 relative z-10">Belum Ada Riwayat Pesanan</h3>
            <p class="text-sm text-gray-500 mb-8 font-medium max-w-sm mx-auto relative z-10 leading-relaxed">
                Anda belum pernah melakukan pesanan apapun dari E-Catalog kami. Silakan pilih produk favorit Anda dan buat pesanan pertama Anda sekarang.
            </p>
            
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-2 px-6 py-3.5 bg-gradient-to-r from-tema-kuning to-amber-500 hover:from-yellow-400 hover:to-amber-450 text-tema-hitam font-black text-sm rounded-xl shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5 active:scale-95 relative z-10">
                <span>Mulai Belanja Sekarang</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
        @endforelse

        @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
        @endif
        
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-8 mt-12 flex-shrink-0">
        <div class="max-w-7xl mx-auto px-4 flex flex-col items-center justify-center">
            <p class="text-xs text-gray-500">&copy; {{ date('Y') }} PT Utama Madani Raya. Hak Cipta Dilindungi.</p>
            <p class="text-[10px] text-gray-400 mt-1.5 flex items-center gap-1.5 font-semibold">
                Powered by <span class="font-black text-gray-500 flex items-center gap-1 uppercase tracking-wider text-[9px]"><svg class="w-3.5 h-3.5 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg> JukungSync</span>
            </p>
        </div>
    </footer>

    </body>
</html>
