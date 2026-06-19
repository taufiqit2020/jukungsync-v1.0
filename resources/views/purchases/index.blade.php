@extends('layouts.admin')
@section('title', 'Data Barang Masuk')
@section('content')

<!-- TomSelect -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<!-- Custom TomSelect Styling -->
<style>
    .ts-wrapper .ts-control {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        padding: 6px 10px !important;
        font-size: 13px !important;
        background: #fff !important;
        min-height: 38px !important;
        transition: all 0.2s !important;
    }
    .ts-wrapper.focus .ts-control {
        border-color: #7f1d1d !important;
        box-shadow: 0 0 0 3px rgba(127, 29, 29, 0.1) !important;
    }
    .ts-wrapper .ts-dropdown {
        border: 1px solid #e5e7eb !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.3) !important;
        margin-top: 4px !important;
        z-index: 99999 !important;
        position: absolute !important;
        top: 100% !important;
        max-height: 220px !important;
        overflow-y: auto !important;
        animation: dropdownSlide 0.15s ease-out !important;
    }
    @keyframes dropdownSlide {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .ts-wrapper .ts-dropdown .ts-dropdown-content {
        max-height: 200px !important;
        padding: 4px !important;
    }
    .ts-wrapper .ts-dropdown .option {
        padding: 8px 10px !important;
        border-radius: 5px !important;
        margin-bottom: 1px !important;
        font-size: 12.5px !important;
        line-height: 1.4 !important;
        transition: all 0.15s ease !important;
        cursor: pointer !important;
    }
    .ts-wrapper .ts-dropdown .option:hover,
    .ts-wrapper .ts-dropdown .active {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
        color: #1f2937 !important;
    }
    .ts-wrapper .ts-dropdown .option .sku-badge {
        display: inline-block;
        background: #7f1d1d;
        color: #fff;
        padding: 1px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-right: 8px;
        vertical-align: middle;
    }
    .ts-wrapper .ts-dropdown .option .product-name {
        font-weight: 600;
        color: #1f2937;
        vertical-align: middle;
    }
    .ts-wrapper .ts-dropdown .option .stock-info {
        float: right;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 10px;
        vertical-align: middle;
    }
    .ts-wrapper .ts-dropdown .option .stock-ok {
        background: #d1fae5;
        color: #065f46;
    }
    .ts-wrapper .ts-dropdown .option .stock-low {
        background: #fee2e2;
        color: #991b1b;
    }
    .ts-wrapper .ts-dropdown .no-results {
        padding: 16px !important;
        text-align: center !important;
        color: #9ca3af !important;
        font-size: 13px !important;
    }
</style>

<div class="bg-white shadow rounded-lg p-6 relative" 
     x-data="purchasePage({{ $products->toJson() }}, {{ $errors->any() ? 'true' : 'false' }})">
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 shadow-sm" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Barang Masuk (Restok)</h2>
        <button @click="openModal()" class="bg-tema-marun hover:bg-red-900 text-white font-medium py-2 px-4 rounded-md transition-all shadow-sm flex items-center gap-2 hover:scale-105 duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Input Barang Masuk
        </button>
    </div>

    <!-- Tabel Daftar Pembelian -->
    <div class="overflow-x-auto rounded-md border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-tema-hitam">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No. Faktur</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Supplier</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Total Biaya</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($purchases as $purchase)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ \Carbon\Carbon::parse($purchase->tanggal_pembelian)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                        {{ $purchase->nomor_faktur }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $purchase->nama_supplier }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right text-red-600">
                        Rp {{ number_format($purchase->total_biaya, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('purchases.show', $purchase->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-yellow-100 text-yellow-800 hover:bg-yellow-200 rounded text-xs font-bold transition-colors shadow-sm" title="Lihat Detail">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Lihat Detail
                            </a>
                            <a href="{{ route('purchases.edit', $purchase->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-blue-100 text-blue-800 hover:bg-blue-200 rounded text-xs font-bold transition-colors shadow-sm" title="Edit">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </a>
                            <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi restock ini? Stok produk yang masuk akan otomatis dikurangi secara berkala.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-red-100 text-red-800 hover:bg-red-200 rounded text-xs font-bold transition-colors shadow-sm" title="Hapus">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        Tidak ada riwayat barang masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $purchases->links() }}
    </div>

    <!-- ==================== MODAL POPUP ==================== -->
    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div x-show="isModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-gray-900 bg-opacity-70 backdrop-blur-sm transition-opacity" 
             @click="closeModal()"></div>

        <!-- Panel -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="isModalOpen" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4" 
                 class="relative bg-white rounded-2xl text-left shadow-2xl transform transition-all w-full border border-gray-100"
                 style="max-width: 1000px;"
                 @click.away="closeModal()">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-tema-marun to-red-800 rounded-t-2xl px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 rounded-lg p-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Input Barang Masuk</h3>
                    </div>
                    <button type="button" @click="closeModal()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-1.5 transition-all">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-8 py-6 max-h-[80vh] overflow-y-auto">
                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-md mb-5">
                            <ul class="text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('purchases.store') }}" method="POST" id="purchase-form">
                        @csrf
                        
                        <!-- Info Faktur - Compact -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">No. Faktur *</label>
                                <input type="text" name="nomor_faktur" value="{{ old('nomor_faktur') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" required placeholder="001/V/UMAR/2026">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Supplier / Toko *</label>
                                <input type="text" name="nama_supplier" value="{{ old('nama_supplier') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" required placeholder="PT. UMAR Banjarbaru">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Tanggal *</label>
                                <input type="date" name="tanggal_pembelian" value="{{ old('tanggal_pembelian', date('Y-m-d')) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" required>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Keterangan</label>
                                <input type="text" name="keterangan" value="{{ old('keterangan') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" placeholder="Opsional">
                            </div>
                        </div>

                        <!-- Tabel Barang -->
                        <div class="border-2 border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <table class="w-full divide-y divide-gray-200" style="table-layout: fixed;">
                                <colgroup>
                                    <col style="width: 40px;">
                                    <col style="width: auto;">
                                    <col style="width: 175px;">
                                    <col style="width: 175px;">
                                    <col style="width: 90px;">
                                    <col style="width: 140px;">
                                    <col style="width: 50px;">
                                </colgroup>
                                <thead class="bg-gray-100 border-b-2 border-gray-200">
                                    <tr>
                                        <th class="px-2 py-3 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider">#</th>
                                        <th class="px-2 py-3 text-left text-[11px] font-bold text-gray-700 uppercase tracking-wider">Nama Barang</th>
                                        <th class="px-2 py-3 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider">Harga Beli / Modal</th>
                                        <th class="px-2 py-3 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider">Harga Jual</th>
                                        <th class="px-2 py-3 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider">Qty</th>
                                        <th class="px-2 py-3 text-right text-[11px] font-bold text-gray-700 uppercase tracking-wider">Subtotal</th>
                                        <th class="px-1 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <template x-for="(item, index) in items" :key="item.id">
                                        <tr class="hover:bg-amber-50/50 transition-colors">
                                            <td class="px-2 py-3.5 text-center text-xs font-bold text-gray-500 align-top" style="padding-top: 1.15rem;" x-text="index + 1"></td>
                                            <td class="px-2 py-3.5 align-top">
                                                <select x-model="item.product_id" :name="'items['+index+'][product_id]'"
                                                    @change="updatePrice(index)"
                                                    x-init="$nextTick(() => {
                                                        if (!item.ts) {
                                                            item.ts = new TomSelect($el, {
                                                                create: true,
                                                                dropdownParent: 'body',
                                                                placeholder: '🔍 Pilih / ketik nama barang baru...',
                                                                sortField: { field: 'text', direction: 'asc' },
                                                                maxOptions: 50,
                                                                render: {
                                                                    option: function(data, escape) {
                                                                        let text = escape(data.text);
                                                                        if (!text.includes(' - ')) {
                                                                            return '<div>' +
                                                                                '<span class=\"sku-badge bg-green-600\">NEW</span>' +
                                                                                '<span class=\"product-name font-bold text-green-700\">' + text + '</span>' +
                                                                                '</div>';
                                                                        }
                                                                        let parts = text.split(' - ');
                                                                        let sku = parts[0] || '';
                                                                        let rest = parts.slice(1).join(' - ');
                                                                        let nameMatch = rest.match(/^(.+?)\s*\(Sisa:\s*(\d+)\)$/);
                                                                        let pname = nameMatch ? nameMatch[1] : rest;
                                                                        let stock = nameMatch ? parseInt(nameMatch[2]) : 0;
                                                                        let stockClass = stock > 10 ? 'stock-ok' : 'stock-low';
                                                                        return '<div>' +
                                                                            '<span class=\"sku-badge\">' + escape(sku) + '</span>' +
                                                                            '<span class=\"product-name\">' + escape(pname) + '</span>' +
                                                                            '<span class=\"stock-info ' + stockClass + '\">' + stock + '</span>' +
                                                                            '</div>';
                                                                    },
                                                                    item: function(data, escape) {
                                                                        let text = escape(data.text);
                                                                        if (!text.includes(' - ')) {
                                                                            return '<div class=\"truncate w-full\" style=\"max-width:100%\"><span style=\"background:#16a34a;color:#fff;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:700;margin-right:6px\">NEW</span>' + text + '</div>';
                                                                        }
                                                                        let parts = text.split(' - ');
                                                                        let sku = parts[0] || '';
                                                                        let rest = parts.slice(1).join(' - ');
                                                                        let nameMatch = rest.match(/^(.+?)\s*\(Sisa:\s*\d+\)$/);
                                                                        let pname = nameMatch ? nameMatch[1] : rest;
                                                                        return '<div class=\"truncate w-full\" style=\"max-width:100%\"><span style=\"background:#7f1d1d;color:#fff;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:700;margin-right:6px\">' + escape(sku) + '</span>' + escape(pname) + '</div>';
                                                                    },
                                                                    no_results: function() {
                                                                        return '<div class=\"no-results\">Ketik nama barang baru untuk menambahkan secara manual</div>';
                                                                    }
                                                                },
                                                                onChange: function(value) {
                                                                    $el.dispatchEvent(new Event('input', { bubbles: true }));
                                                                    $el.dispatchEvent(new Event('change', { bubbles: true }));
                                                                }
                                                            });
                                                        }
                                                    })" class="w-full" required>
                                                    <option value="">Pilih / Ketik Barang...</option>
                                                    @foreach($products as $p)
                                                        <option value="{{ $p->id }}">{{ $p->sku }} - {{ $p->nama_barang }} (Sisa: {{ $p->stok_saat_ini }})</option>
                                                    @endforeach
                                                </select>
                                                
                                                <!-- Info Pilihan Harga Pintas -->
                                                <div class="mt-2 flex flex-col gap-1 items-start" x-show="item.product_id && isExistingProduct(item.product_id)">
                                                    <button type="button" @click="usePrice(index, 'dulu')" class="inline-flex items-center px-2 py-0.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-[10px] font-bold rounded transition-colors select-none whitespace-nowrap">
                                                        <span>📋 Harga Dulu: Beli Rp<span x-text="formatRupiah(getProductField(item.product_id, 'harga_modal'))"></span> / Jual Rp<span x-text="formatRupiah(getProductField(item.product_id, 'harga_jual'))"></span></span>
                                                    </button>
                                                    <button type="button" @click="usePrice(index, 'terakhir')" class="inline-flex items-center px-2 py-0.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-[10px] font-bold rounded transition-colors select-none whitespace-nowrap">
                                                        <span>⏱ Harga Terakhir: Beli Rp<span x-text="formatRupiah(getProductField(item.product_id, 'harga_beli_terakhir'))"></span> / Jual Rp<span x-text="formatRupiah(getProductField(item.product_id, 'harga_jual_terakhir'))"></span></span>
                                                    </button>
                                                    <button type="button" @click="item.showHistory = !item.showHistory" class="inline-flex items-center px-2 py-0.5 bg-purple-50 hover:bg-purple-100 text-purple-700 text-[10px] font-bold rounded transition-colors select-none whitespace-nowrap mt-0.5">
                                                        <span x-text="item.showHistory ? '📊 Sembunyikan Riwayat' : '📊 Lihat Riwayat Harga'"></span>
                                                    </button>
                                                    <div x-show="item.showHistory" class="mt-1 p-2 bg-purple-50/50 border border-purple-100 rounded-lg text-[10px] text-purple-950 space-y-1 w-full max-w-[280px]">
                                                        <div class="font-bold border-b border-purple-100 pb-0.5 mb-1 text-purple-900">5 Perubahan Harga Terakhir:</div>
                                                        <template x-for="hist in getProductField(item.product_id, 'history')" :key="hist.tanggal + hist.faktur">
                                                            <div class="flex flex-col border-b border-purple-100/50 pb-1 mb-1 last:border-b-0 last:pb-0 last:mb-0">
                                                                <div class="flex justify-between text-[9px] text-purple-800">
                                                                    <span x-text="hist.tanggal"></span>
                                                                    <span class="font-semibold truncate max-w-[120px]" x-text="hist.supplier"></span>
                                                                </div>
                                                                <div class="flex justify-between font-semibold mt-0.5">
                                                                    <span>Beli: Rp<span x-text="formatRupiah(hist.harga_beli)"></span></span>
                                                                    <span>Jual: Rp<span x-text="formatRupiah(hist.harga_jual)"></span></span>
                                                                </div>
                                                            </div>
                                                        </template>
                                                        <div x-show="!getProductField(item.product_id, 'history') || getProductField(item.product_id, 'history').length === 0" class="text-purple-400 italic text-center py-1">
                                                            Belum ada riwayat perubahan harga.
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-2 py-3.5 align-top">
                                                <div class="flex rounded-lg overflow-hidden border-2 border-gray-300 bg-white shadow-sm focus-within:border-tema-marun focus-within:ring-1 focus-within:ring-tema-marun">
                                                    <span class="inline-flex items-center px-2.5 bg-tema-marun text-white text-xs font-bold flex-shrink-0">Rp</span>
                                                    <input type="number" x-model.number="item.harga_beli" :name="'items['+index+'][harga_beli]'" @input="updateSubtotal(index)" class="flex-1 min-w-0 w-full px-2 py-2 text-sm font-bold text-gray-900 border-0 bg-white focus:ring-0 focus:border-0" required min="0">
                                                </div>
                                            </td>
                                            <td class="px-2 py-3.5 align-top">
                                                <div class="flex rounded-lg overflow-hidden border-2 border-gray-300 bg-white shadow-sm focus-within:border-tema-marun focus-within:ring-1 focus-within:ring-tema-marun">
                                                    <span class="inline-flex items-center px-2.5 bg-tema-marun text-white text-xs font-bold flex-shrink-0">Rp</span>
                                                    <input type="number" x-model.number="item.harga_jual" :name="'items['+index+'][harga_jual]'" class="flex-1 min-w-0 w-full px-2 py-2 text-sm font-bold text-gray-900 border-0 bg-white focus:ring-0 focus:border-0" required min="0">
                                                </div>
                                            </td>
                                            <td class="px-2 py-3.5 align-top">
                                                <input type="number" x-model.number="item.jumlah" :name="'items['+index+'][jumlah]'" @input="updateSubtotal(index)" class="w-full rounded-lg border-2 border-gray-300 focus:ring-tema-marun focus:border-tema-marun text-sm py-2 text-center font-bold text-gray-900 shadow-sm bg-white" min="1" required>
                                            </td>
                                            <td class="px-2 py-3.5 text-right align-top" style="padding-top: 1.15rem;">
                                                <span class="font-bold text-sm text-gray-900 whitespace-nowrap" x-text="'Rp ' + formatRupiah(item.subtotal)"></span>
                                            </td>
                                            <td class="px-1 py-3.5 text-center align-top" style="padding-top: 1rem;">
                                                <button type="button" @click="removeItem(index)" class="text-gray-300 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-full transition-all" title="Hapus" x-show="items.length > 1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer Tabel -->
                        <div class="mt-4 flex justify-between items-center">
                            <button type="button" @click="addItem()" class="bg-white border-2 border-dashed border-gray-400 hover:border-tema-marun hover:text-tema-marun text-gray-500 font-semibold py-2 px-5 rounded-lg text-sm flex items-center transition-all">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                + Tambah Baris
                            </button>
                            <div class="flex items-center gap-3 bg-gradient-to-r from-red-50 to-red-100 px-5 py-3 rounded-xl border-2 border-red-200">
                                <span class="text-sm font-bold text-red-900 uppercase tracking-wider">TOTAL:</span>
                                <span class="text-2xl font-black text-red-600" x-text="'Rp ' + formatRupiah(calculateTotal())"></span>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer Modal -->
                <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" @click="closeModal()" class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition-colors text-sm shadow-sm">
                        Batal
                    </button>
                    <button type="submit" form="purchase-form" class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-tema-hitam font-bold py-2.5 px-6 rounded-lg transition-all shadow-md text-sm flex items-center gap-2 hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan & Tambah Stok
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('purchasePage', (productsData, hasErrors) => ({
            isModalOpen: hasErrors,
            products: productsData,
            nextId: 2,
            items: [
                { id: 1, product_id: '', jumlah: 1, harga_beli: 0, harga_jual: 0, subtotal: 0, ts: null, showHistory: false }
            ],
            
            openModal() {
                this.isModalOpen = true;
                document.body.style.overflow = 'hidden';
            },
            
            closeModal() {
                this.isModalOpen = false;
                document.body.style.overflow = '';
            },
            
            addItem() {
                this.items.push({ id: this.nextId++, product_id: '', jumlah: 1, harga_beli: 0, harga_jual: 0, subtotal: 0, ts: null, showHistory: false });
            },
            
            removeItem(index) {
                if(this.items.length > 1) {
                    let item = this.items[index];
                    if(item.ts) item.ts.destroy();
                    this.items.splice(index, 1);
                }
            },
            
            getProductField(productId, fieldName) {
                const prod = this.products.find(p => p.id == productId);
                return prod ? (prod[fieldName] || 0) : 0;
            },
            
            isExistingProduct(productId) {
                return this.products.some(p => p.id == productId);
            },
            
            usePrice(index, type) {
                let item = this.items[index];
                if (!item.product_id) return;
                if (type === 'dulu') {
                    item.harga_beli = this.getProductField(item.product_id, 'harga_modal');
                    item.harga_jual = this.getProductField(item.product_id, 'harga_jual');
                } else if (type === 'terakhir') {
                    item.harga_beli = this.getProductField(item.product_id, 'harga_beli_terakhir');
                    item.harga_jual = this.getProductField(item.product_id, 'harga_jual_terakhir');
                }
                this.updateSubtotal(index);
            },
            
            updatePrice(index) {
                let item = this.items[index];
                if (item.product_id) {
                    const prod = this.products.find(p => p.id == item.product_id);
                    if (prod) {
                        item.harga_beli = prod.harga_modal ?? 0;
                        item.harga_jual = prod.harga_jual ?? 0;
                    } else {
                        item.harga_beli = 0;
                        item.harga_jual = 0;
                    }
                } else {
                    item.harga_beli = 0;
                    item.harga_jual = 0;
                }
                this.updateSubtotal(index);
            },
            
            updateSubtotal(index) {
                let item = this.items[index];
                item.subtotal = Number(item.jumlah) * Number(item.harga_beli);
            },
            
            calculateTotal() {
                return this.items.reduce((total, item) => total + (Number(item.jumlah) * Number(item.harga_beli)), 0);
            },
            
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
        }));
    });
</script>
@endsection


