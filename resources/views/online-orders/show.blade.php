@extends('layouts.admin')
@section('title', 'Detail Pesanan Online')
@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md flex items-center justify-between">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-green-800 text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md flex items-center justify-between">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-red-800 text-sm font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('online-orders.index') }}" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Detail Pesanan <span class="text-tema-marun">{{ $online_order->nomor_invoice }}</span></h2>
        </div>

        <div>
            @if($online_order->status_pesanan === 'menunggu_konfirmasi')
                <span class="px-3 py-1 text-sm font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">Menunggu Konfirmasi</span>
            @elseif($online_order->status_pesanan === 'diproses')
                <span class="px-3 py-1 text-sm font-bold rounded-full bg-blue-100 text-blue-800 border border-blue-200">Diproses</span>
            @elseif($online_order->status_pesanan === 'selesai')
                <span class="px-3 py-1 text-sm font-bold rounded-full bg-green-100 text-green-800 border border-green-200">Selesai</span>
            @else
                <span class="px-3 py-1 text-sm font-bold rounded-full bg-red-100 text-red-800 border border-red-200">Dibatalkan</span>
            @endif
        </div>
    </div>

    <!-- Informasi Pemesan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4">
            <h3 class="font-bold text-gray-800">Informasi Pemesan</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500 mb-1">Nama Pemesan</p>
                <p class="font-bold text-gray-800">{{ $online_order->nama_klien }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500 mb-1">Tanggal Pesanan</p>
                <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($online_order->tanggal_invoice)->translatedFormat('l, d F Y') }}</p>
            </div>
            @if($online_order->alamat_pengiriman)
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500 mb-1">📍 Alamat Pengiriman</p>
                <p class="font-bold text-gray-800 bg-gray-50 p-3 rounded-lg border border-gray-100 leading-relaxed">{{ $online_order->alamat_pengiriman }}</p>
            </div>
            @endif
            @if($online_order->ekspedisi)
            <div>
                <p class="text-sm text-gray-500 mb-1">🚚 Metode Pengiriman / Ekspedisi</p>
                <p class="font-bold text-gray-800">{{ $online_order->ekspedisi }}</p>
            </div>
            @endif
            @if($online_order->catatan_pengiriman)
            <div>
                <p class="text-sm text-gray-500 mb-1">📝 Catatan Pengiriman (dari Customer)</p>
                <p class="font-bold text-gray-800 italic">"{{ $online_order->catatan_pengiriman }}"</p>
            </div>
            @endif
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500 mb-1">Catatan Sistem</p>
                <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">{{ $online_order->catatan }}</p>
            </div>
        </div>
    </div>

    <!-- Rincian Pesanan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4">
            <h3 class="font-bold text-gray-800">Rincian Barang</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left font-bold text-gray-500 uppercase tracking-wider">SKU / Nama Barang</th>
                        <th class="px-6 py-3 text-right font-bold text-gray-500 uppercase tracking-wider">Harga Satuan</th>
                        <th class="px-6 py-3 text-center font-bold text-gray-500 uppercase tracking-wider">Jml Pesan</th>
                        <th class="px-6 py-3 text-center font-bold text-gray-500 uppercase tracking-wider">Stok Gudang</th>
                        <th class="px-6 py-3 text-right font-bold text-gray-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $stokAman = true; @endphp
                    @foreach($online_order->invoiceItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-block bg-tema-hitam text-white px-2 py-0.5 rounded text-[10px] font-bold mr-2">{{ $item->product->sku }}</span>
                            <span class="font-semibold text-gray-800">{{ $item->product->nama_barang }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-gray-600">
                            Rp {{ number_format($item->harga_jual_snapshot, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="font-bold text-gray-800">{{ $item->jumlah }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($item->product->stok_saat_ini >= $item->jumlah)
                                <span class="text-green-600 font-bold">{{ $item->product->stok_saat_ini }}</span>
                            @else
                                @php $stokAman = false; @endphp
                                <span class="text-red-600 font-bold flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    {{ $item->product->stok_saat_ini }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-gray-800">
                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t border-gray-200">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-right font-bold text-gray-600">TOTAL TAGIHAN</td>
                        <td class="px-6 py-4 text-right font-black text-xl text-tema-marun">Rp {{ number_format($online_order->total_tagihan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Aksi -->
    @if(in_array(auth()->user()->role, ['staf_admin', 'superadmin', 'bendahara']))
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="font-bold text-gray-800 mb-4">Tindakan</h3>
        
        <div class="flex flex-wrap gap-4">
            @if($online_order->status_pesanan === 'menunggu_konfirmasi')
                @if($stokAman)
                <form action="{{ route('online-orders.approve', $online_order->id) }}" method="POST" onsubmit="return confirm('⚠️ KONFIRMASI TERIMA PESANAN\n\nAnda yakin ingin memproses pesanan ini?\nLangkah ini akan secara otomatis memotong stok barang di gudang sesuai dengan jumlah yang dipesan.')">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-tema-hitam bg-tema-kuning hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tema-kuning transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Terima & Proses Pesanan
                    </button>
                </form>
                @else
                <div class="px-6 py-3 bg-red-50 text-red-600 text-sm font-bold rounded-lg border border-red-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Stok tidak cukup untuk memproses pesanan ini.
                </div>
                @endif

                <form action="{{ route('online-orders.reject', $online_order->id) }}" method="POST" onsubmit="return confirm('⛔ KONFIRMASI PENOLAKAN\n\nApakah Anda yakin ingin membatalkan dan menolak pesanan ini?\nTindakan ini tidak dapat dibatalkan.')">
                    @csrf
                    <button type="submit" style="background-color: #dc2626; color: white;" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Tolak / Batalkan
                    </button>
                </form>
            @elseif($online_order->status_pesanan === 'diproses')
                <!-- Container untuk Tindakan Diproses -->
                <div class="w-full space-y-6">
                    <!-- Bagian 1: Cetak Surat Jalan -->
                    <div class="p-5 bg-gray-50 border border-gray-200 rounded-xl">
                        <h4 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            1. Cetak Surat Jalan
                        </h4>
                        <form action="{{ route('online-orders.surat-jalan', $online_order->id) }}" method="GET" target="_blank" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Pengantar (Ke Lokasi)</label>
                                    <select name="staf_pengantar" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-tema-marun focus:ring-tema-marun">
                                        <option value="">-- Pilih Pengantar --</option>
                                        @foreach($stafList as $staf)
                                            <option value="{{ $staf['nama'] }}">{{ $staf['jabatan'] }} – {{ $staf['nama'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tanda Terima Surat Jalan</label>
                                    <select name="staf_penerima" required class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-tema-marun focus:ring-tema-marun">
                                        <option value="">-- Pilih Tanda Terima --</option>
                                        @foreach($stafList as $staf)
                                            <option value="{{ $staf['nama'] }}">{{ $staf['jabatan'] }} – {{ $staf['nama'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-tema-marun hover:bg-red-800 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                Cetak Surat Jalan
                            </button>
                        </form>
                    </div>

                    <!-- Bagian 2, 3 & Batalkan: Penyelesaian & Pembatalan Pesanan -->
                    <div class="p-5 bg-gray-50 border border-gray-200 rounded-xl">
                        <h4 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            Penyelesaian & Pembatalan Pesanan
                        </h4>
                        
                        <div class="flex flex-wrap gap-4">
                            <!-- Tandai Selesai & Lunas (Lunas) -->
                            <form action="{{ route('online-orders.complete-paid', $online_order->id) }}" method="POST" onsubmit="return confirm('✅ KONFIRMASI SELESAI & LUNAS\n\nPastikan pembayaran telah Anda terima secara penuh.\nTandai pesanan ini sebagai LUNAS dan SELESAI?')">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-tema-hitam bg-tema-kuning hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tema-kuning transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path></svg>
                                    2. Tandai Selesai & Lunas (Lunas)
                                </button>
                            </form>

                            <!-- Tandai Selesai & Belum Lunas Masuk Kasbon (Kasbon) -->
                            <div x-data="{ showKasbonModal: false, total: {{ $online_order->total_tagihan }}, dibayar: 0 }">
                                <button type="button" @click="showKasbonModal = true" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 rounded-lg shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tema-marun transition-colors">
                                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    3. Tandai Selesai & Belum Lunas Masuk Kasbon (Kasbon)
                                </button>

                                <!-- Premium Kasbon Modal -->
                                <div x-show="showKasbonModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <style>
                                        /* Hide spin buttons for the number input */
                                        input[type="number"]::-webkit-outer-spin-button, 
                                        input[type="number"]::-webkit-inner-spin-button {
                                            -webkit-appearance: none; margin: 0;
                                        }
                                        input[type="number"] { -moz-appearance: textfield; }
                                    </style>
                                    <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                                        <!-- Background overlay with blur -->
                                        <div x-show="showKasbonModal" 
                                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                                             @click="showKasbonModal = false" 
                                             class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" aria-hidden="true"></div>
                                        
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        
                                        <!-- Modal panel -->
                                        <div x-show="showKasbonModal" 
                                             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                                             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                                             class="relative inline-block px-4 pt-5 pb-8 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-2xl sm:my-8 sm:align-middle sm:w-full sm:p-10 border border-gray-100"
                                             style="background-color: #ffffff !important; color: #1f2937 !important; border-radius: 1.5rem; max-width: 500px; width: 100%;">
                                            
                                            <!-- Close button -->
                                            <div class="absolute top-0 right-0 hidden pt-6 pr-6 sm:block">
                                                <button type="button" @click="showKasbonModal = false" class="text-gray-400 bg-white rounded-md hover:text-gray-600 focus:outline-none transition-colors" style="background: transparent;">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>

                                            <div class="sm:flex sm:items-start">
                                                <div class="w-full text-center">
                                                    <!-- Icon -->
                                                    <div class="flex items-center justify-center w-20 h-20 mx-auto bg-orange-100 rounded-full mb-5 shadow-inner border border-orange-200" style="background-color: #ffedd5; border: 1px solid #fed7aa; border-radius: 9999px; width: 5rem; height: 5rem; display: flex; align-items: center; justify-content: center; margin-left: auto; margin-right: auto;">
                                                        <svg class="w-10 h-10 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 2.5rem; height: 2.5rem; color: #ea580c;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    </div>
                                                    
                                                    <h3 class="text-3xl font-black text-gray-900 tracking-tight" id="modal-title" style="font-size: 1.875rem; font-weight: 900; color: #111827; tracking-letter: -0.025em;">Konfirmasi Kasbon</h3>
                                                    <p class="mt-2 text-base text-gray-500 font-medium" style="font-size: 1rem; color: #6b7280; font-weight: 500;">Masukkan nominal pembayaran awal (DP) jika ada.</p>

                                                    <div class="mt-8 space-y-7" style="margin-top: 2rem;">
                                                        <!-- Total Tagihan -->
                                                        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-200 shadow-sm" style="background-color: #f9fafb; border-radius: 1rem; border: 1px solid #e5e7eb; padding: 1.25rem;">
                                                            <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-1.5" style="font-size: 0.75rem; font-weight: 700; color: #6b7280; letter-spacing: 0.1em; margin-bottom: 0.375rem;">Total Tagihan Pesanan</p>
                                                            <p class="text-4xl font-black text-gray-800" style="font-size: 2.25rem; font-weight: 900; color: #1f2937;">Rp {{ number_format($online_order->total_tagihan, 0, ',', '.') }}</p>
                                                        </div>

                                                        <form action="{{ route('online-orders.complete-unpaid', $online_order->id) }}" method="POST">
                                                            @csrf
                                                            <!-- Input Nominal DP -->
                                                            <div class="relative mt-2 text-left" style="margin-top: 0.5rem; text-align: left;">
                                                                <label for="nominal_dibayar" class="block text-sm font-bold text-gray-700 mb-3 ml-1" style="font-size: 0.875rem; font-weight: 700; color: #374151; margin-bottom: 0.75rem; margin-left: 0.25rem;">Nominal Uang Muka / Dibayar Sekarang</label>
                                                                <div class="relative rounded-2xl shadow-sm overflow-hidden border-2 border-orange-200 focus-within:border-orange-500 focus-within:ring-4 focus-within:ring-orange-100 transition-all duration-200" style="position: relative; border-radius: 1rem; border: 2px solid #fed7aa; background-color: #ffffff;">
                                                                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none" style="position: absolute; top: 0; bottom: 0; left: 0; display: flex; align-items: center; pointer-events: none; padding-left: 1.5rem;">
                                                                        <span class="text-gray-400 text-3xl font-bold" style="font-size: 1.875rem; font-weight: 700; color: #9ca3af;">Rp</span>
                                                                    </div>
                                                                    <input type="number" name="nominal_dibayar" id="nominal_dibayar" x-model.number="dibayar" 
                                                                           class="block w-full pr-6 py-5 text-gray-900 bg-white border-none focus:ring-0 placeholder-gray-200" 
                                                                           style="display: block; width: 100%; padding-left: 5.5rem; padding-right: 1.5rem; padding-top: 1.25rem; padding-bottom: 1.25rem; font-size: 2.25rem; font-weight: 900; color: #111827; background-color: #ffffff; border: none; outline: none; box-shadow: none;"
                                                                           placeholder="0" min="0" :max="total" required>
                                                                </div>
                                                                <p class="mt-3 text-xs font-bold text-gray-400 ml-1 flex items-center" style="font-size: 0.75rem; font-weight: 700; color: #9ca3af; margin-top: 0.75rem; margin-left: 0.25rem;">
                                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" style="width: 1rem; height: 1rem; margin-right: 0.25rem;"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                                                    Biarkan angka 0 jika tidak ada pembayaran sama sekali.
                                                                </p>
                                                            </div>
                                                            
                                                            <!-- Sisa Kasbon -->
                                                            <div class="mt-8 p-6 bg-red-50 rounded-2xl border border-red-200 shadow-inner relative overflow-hidden" style="margin-top: 2rem; padding: 1.5rem; background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 1rem; position: relative;">
                                                                <div class="absolute top-0 left-0 w-2 h-full bg-red-500" style="position: absolute; top: 0; left: 0; width: 0.5rem; height: 100%; background-color: #ef4444;"></div>
                                                                <p class="text-sm font-black text-red-800 uppercase tracking-widest mb-2" style="font-size: 0.875rem; font-weight: 900; color: #991b1b; letter-spacing: 0.05em; margin-bottom: 0.5rem; padding-left: 0.5rem; text-align: left;">SISA MENJADI KASBON (HUTANG)</p>
                                                                <div class="text-5xl font-black text-red-600 tracking-tight" style="font-size: 3rem; font-weight: 900; color: #dc2626; padding-left: 0.5rem; text-align: left; tracking-letter: -0.025em;">
                                                                    <span x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(total - dibayar)"></span>
                                                                </div>
                                                            </div>

                                                            <!-- Buttons -->
                                                            <div class="mt-10 grid grid-cols-2 gap-5" style="margin-top: 2.5rem; display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                                                                <button type="button" @click="showKasbonModal = false" class="w-full flex items-center justify-center px-6 py-4 text-lg font-bold text-gray-700 bg-white border-2 border-gray-300 rounded-2xl hover:bg-gray-50 focus:outline-none transition-colors" style="width: 100%; border-radius: 1rem; border: 2px solid #d1d5db; padding: 1rem; font-size: 1.125rem; font-weight: 700; color: #374151; background-color: #ffffff; display: flex; align-items: center; justify-content: center;">
                                                                    Batalkan
                                                                </button>
                                                                <button type="submit" class="w-full flex items-center justify-center px-6 py-4 text-lg font-black text-white bg-red-600 border border-transparent rounded-2xl hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-200 shadow-xl shadow-red-200 transition-all transform hover:-translate-y-1" style="width: 100%; border-radius: 1rem; padding: 1rem; font-size: 1.125rem; font-weight: 900; color: #ffffff; background-color: #ef4444; border: none; display: flex; align-items: center; justify-content: center;">
                                                                    Simpan Kasbon
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Batalkan Pesanan Kembalikan Stok (Batalkan) -->
                            <form action="{{ route('online-orders.reject', $online_order->id) }}" method="POST" onsubmit="return confirm('⛔ KONFIRMASI PEMBATALAN PESANAN DIPROSES\n\nAnda yakin ingin membatalkan pesanan yang sedang diproses ini?\nStok barang yang sebelumnya sudah terpotong akan otomatis dikembalikan lagi ke gudang.')">
                                @csrf
                                <button type="submit" style="background-color: #dc2626; color: white;" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Batalkan Pesanan Kembalikan Stok (Batalkan)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500 font-semibold italic">Tidak ada tindakan yang tersedia untuk status pesanan ini.</p>
            @endif
        </div>
    </div>
    @else
    <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 text-center">
        <p class="text-gray-500 text-sm">Hanya Staf Admin, Kepala Keuangan, dan Superadmin yang dapat melakukan tindakan persetujuan pada pesanan online.</p>
    </div>
    @endif
</div>

@endsection
