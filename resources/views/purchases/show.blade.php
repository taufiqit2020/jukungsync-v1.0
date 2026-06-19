@extends('layouts.admin')
@section('title', 'Detail Nota Barang Masuk')
@section('content')
<div class="bg-white shadow rounded-lg p-8 max-w-4xl mx-auto">
    <div class="flex justify-between items-start border-b pb-6 mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 uppercase tracking-wide">NOTA PEMBELIAN / RESTOK</h2>
            <p class="text-sm text-gray-500 mt-1">Sistem Informasi Inventory & E-Catalog</p>
        </div>
        <div class="text-right">
            <h3 class="text-lg font-bold text-tema-marun">{{ $purchase->nomor_faktur }}</h3>
            <p class="text-sm text-gray-600 mt-1">
                Tanggal: <span class="font-medium">{{ \Carbon\Carbon::parse($purchase->tanggal_pembelian)->format('d F Y') }}</span>
            </p>
        </div>
    </div>

    <div class="mb-8 bg-gray-50 p-4 rounded border border-gray-200">
        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Informasi Supplier</h4>
        <p class="text-lg font-semibold text-gray-800">{{ $purchase->nama_supplier }}</p>
        @if($purchase->keterangan)
            <p class="text-sm text-gray-600 mt-2"><span class="font-medium">Keterangan:</span> {{ $purchase->keterangan }}</p>
        @endif
    </div>

    <div class="mb-8">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-gray-800">
                    <th class="py-3 px-2 text-sm font-bold text-gray-800 uppercase">No</th>
                    <th class="py-3 px-2 text-sm font-bold text-gray-800 uppercase">Kode / Barang</th>
                    <th class="py-3 px-2 text-sm font-bold text-gray-800 uppercase text-right">Harga Beli</th>
                    <th class="py-3 px-2 text-sm font-bold text-gray-800 uppercase text-right">Harga Jual</th>
                    <th class="py-3 px-2 text-sm font-bold text-gray-800 uppercase text-center">Qty</th>
                    <th class="py-3 px-2 text-sm font-bold text-gray-800 uppercase text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($purchase->purchaseItems as $index => $item)
                <tr>
                    <td class="py-3 px-2 text-sm text-gray-600">{{ $index + 1 }}</td>
                    <td class="py-3 px-2">
                        <p class="text-sm font-bold text-gray-800">{{ $item->product->nama_barang }}</p>
                        <p class="text-xs text-gray-500">{{ $item->product->sku }} | Kategori: {{ $item->product->category->nama_kategori ?? '-' }}</p>
                    </td>
                    <td class="py-3 px-2 text-sm text-gray-700 text-right">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                    <td class="py-3 px-2 text-sm text-gray-700 text-right">Rp {{ number_format($item->harga_jual ?? $item->product->harga_jual, 0, ',', '.') }}</td>
                    <td class="py-3 px-2 text-sm text-gray-700 text-center font-bold">{{ $item->jumlah }}</td>
                    <td class="py-3 px-2 text-sm font-medium text-gray-900 text-right">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="py-4 px-2 text-right text-sm font-bold text-gray-800 uppercase">Total Biaya:</td>
                    <td class="py-4 px-2 text-right text-lg font-bold text-red-600">Rp {{ number_format($purchase->total_biaya, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="flex justify-between items-center border-t pt-6 mt-8 print:hidden">
        <a href="{{ route('purchases.index') }}" class="text-gray-500 hover:text-gray-800 text-sm font-medium transition-colors">
            &larr; Kembali ke Daftar
        </a>
        <button onclick="window.print()" class="bg-tema-hitam hover:bg-gray-800 text-white font-medium py-2 px-6 rounded-md transition-colors text-sm shadow-sm flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Cetak Bukti Restok
        </button>
    </div>
</div>

<style>
    @media print {
        body { background-color: white !important; }
        .bg-white { box-shadow: none !important; }
        .print\:hidden { display: none !important; }
        nav, aside, header { display: none !important; }
        main { padding: 0 !important; margin: 0 !important; }
        .max-w-4xl { max-width: 100% !important; }
    }
</style>
@endsection
