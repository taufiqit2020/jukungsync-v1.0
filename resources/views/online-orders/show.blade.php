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
    @if(in_array(auth()->user()->role, ['staf_admin', 'superadmin']))
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
                <form action="{{ route('online-orders.complete', $online_order->id) }}" method="POST" onsubmit="return confirm('✅ KONFIRMASI PENYELESAIAN\n\nPastikan pembayaran telah Anda terima.\nTandai pesanan ini sebagai LUNAS dan SELESAI?')">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-tema-hitam bg-tema-kuning hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tema-kuning transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        Tandai Selesai & Lunas
                    </button>
                </form>

                <form action="{{ route('online-orders.reject', $online_order->id) }}" method="POST" onsubmit="return confirm('⛔ KONFIRMASI PEMBATALAN PESANAN DIPROSES\n\nAnda yakin ingin membatalkan pesanan yang sedang diproses ini?\nStok barang yang sebelumnya sudah terpotong akan otomatis dikembalikan lagi ke gudang.')">
                    @csrf
                    <button type="submit" style="background-color: #dc2626; color: white;" class="inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Batalkan (Kembalikan Stok)
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-500 font-semibold italic">Tidak ada tindakan yang tersedia untuk status pesanan ini.</p>
            @endif
        </div>
    </div>
    @else
    <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 text-center">
        <p class="text-gray-500 text-sm">Hanya Staf Admin dan Superadmin yang dapat melakukan tindakan persetujuan pada pesanan online.</p>
    </div>
    @endif
</div>

@endsection
