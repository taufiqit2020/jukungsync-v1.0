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

    /* Autocomplete Search */
    .search-wrapper {
        position: relative;
    }
    .search-input {
        width: 100%;
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.625rem 0.875rem 0.625rem 2.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #111827;
        transition: all 0.2s;
        outline: none;
    }
    .search-input:focus {
        border-color: #991b1b;
        background: white;
        box-shadow: 0 0 0 3px rgba(153, 27, 27, 0.1);
    }
    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        pointer-events: none;
    }
    .search-badge {
        position: absolute;
        right: 0.5rem;
        top: 50%;
        transform: translateY(-50%);
        background: #991b1b;
        color: white;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 0.1rem 0.45rem;
        border-radius: 9999px;
        white-space: nowrap;
    }
    
    /* Dropdown Results — pakai position:fixed agar tidak terpotong overflow container */
    .search-dropdown {
        position: fixed;
        background: white;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.875rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.18), 0 4px 12px rgba(0,0,0,0.1);
        z-index: 99999;
        max-height: 280px;
        overflow-y: auto;
        overflow-x: hidden;
    }
    .search-dropdown::-webkit-scrollbar { width: 4px; }
    .search-dropdown::-webkit-scrollbar-track { background: #f9fafb; }
    .search-dropdown::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background 0.15s;
        border-bottom: 1px solid #f1f5f9;
        text-align: left;
    }
    .dropdown-item:last-child { border-bottom: none; }
    .dropdown-item:hover, .dropdown-item.highlighted { background: #fef2f2; }
    .dropdown-item-sku {
        background: linear-gradient(135deg, #7f1d1d, #991b1b);
        color: white;
        font-size: 0.65rem;
        font-weight: 800;
        padding: 0.2rem 0.5rem;
        border-radius: 0.375rem;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .dropdown-item-name {
        flex: 1;
        font-size: 0.8rem;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.3;
    }
    .dropdown-item-stock {
        font-size: 0.7rem;
        font-weight: 700;
        padding: 0.15rem 0.5rem;
        border-radius: 9999px;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .stock-ok { background: #dcfce7; color: #166534; }
    .stock-low { background: #fef3c7; color: #92400e; }
    .stock-zero { background: #fee2e2; color: #991b1b; }

    .dropdown-no-result {
        padding: 1.25rem 1rem;
        text-align: center;
        color: #9ca3af;
        font-size: 0.8rem;
    }
    
    /* Selected Product Display */
    .selected-product {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        background: #f0fdf4;
        border: 1.5px solid #86efac;
        border-radius: 0.625rem;
        padding: 0.5rem 0.75rem;
        text-align: left;
    }
    .selected-product-name {
        font-size: 0.8rem;
        font-weight: 700;
        color: #166534;
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .change-btn {
        font-size: 0.7rem;
        font-weight: 700;
        color: #991b1b;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.1rem 0.35rem;
        border-radius: 0.3rem;
        transition: background 0.15s;
        white-space: nowrap;
    }
    .change-btn:hover { background: #fee2e2; }

    /* Price Input */
    .price-input-wrapper {
        display: flex;
        align-items: stretch;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        overflow: hidden;
        background: #f9fafb;
        transition: all 0.2s;
    }
    .price-input-wrapper:focus-within {
        border-color: #991b1b;
        background: white;
        box-shadow: 0 0 0 3px rgba(153, 27, 27, 0.1);
    }
    .price-prefix {
        background: linear-gradient(135deg, #7f1d1d, #991b1b);
        color: white;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 0 0.75rem;
        display: flex;
        align-items: center;
        white-space: nowrap;
    }
    .price-input-field {
        flex: 1;
        border: none;
        background: transparent;
        padding: 0.625rem 0.75rem;
        font-size: 0.875rem;
        font-weight: 700;
        color: #1f2937;
        outline: none;
        min-width: 0;
    }

    /* Qty Input */
    .qty-wrapper {
        display: flex;
        align-items: center;
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        overflow: hidden;
        transition: all 0.2s;
    }
    .qty-wrapper:focus-within {
        border-color: #991b1b;
        background: white;
        box-shadow: 0 0 0 3px rgba(153, 27, 27, 0.1);
    }
    .qty-btn {
        background: none;
        border: none;
        width: 2rem;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #6b7280;
        font-size: 1.1rem;
        font-weight: 700;
        transition: all 0.15s;
        padding: 0.625rem 0;
        flex-shrink: 0;
    }
    .qty-btn:hover { background: #f1f5f9; color: #991b1b; }
    .qty-input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 0.625rem 0;
        font-size: 0.875rem;
        font-weight: 700;
        color: #1f2937;
        text-align: center;
        outline: none;
        min-width: 0;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
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
                 @click.away="closeModal()"
                 @click="closeAllDropdowns()">
                
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
                        </div>                         <!-- Tabel Barang -->
                        <div class="border-2 border-gray-200 rounded-xl overflow-hidden shadow-sm bg-white">
                            <table class="w-full divide-y divide-gray-200" style="table-layout: fixed;">
                                <colgroup>
                                    <col style="width: 50px;">
                                    <col style="width: auto;">
                                    <col style="width: 180px;">
                                    <col style="width: 160px;">
                                    <col style="width: 130px;">
                                    <col style="width: 150px;">
                                    <col style="width: 50px;">
                                </colgroup>
                                <thead class="bg-gray-100 border-b-2 border-gray-200">
                                    <tr>
                                        <th class="px-2 py-3 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider">#</th>
                                        <th class="px-2 py-3 text-left text-[11px] font-bold text-gray-700 uppercase tracking-wider">Nama Barang (Ketik Langsung)</th>
                                        <th class="px-2 py-3 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider">Harga Beli / Modal</th>
                                        <th class="px-2 py-3 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider">Harga Jual</th>
                                        <th class="px-2 py-3 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider">Qty</th>
                                        <th class="px-2 py-3 text-right text-[11px] font-bold text-gray-700 uppercase tracking-wider">Subtotal</th>
                                        <th class="px-1 py-3"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <template x-for="(item, index) in items" :key="item._uid">
                                        <tr class="hover:bg-amber-50/50 transition-colors">
                                            <!-- No -->
                                            <td class="px-2 py-3.5 text-center text-xs font-bold text-gray-500 align-top" style="padding-top: 1.15rem;" x-text="index + 1"></td>
                                            
                                            <!-- Product Search -->
                                            <td class="px-2 py-3.5 align-top">
                                                <input type="hidden" :name="'items['+index+'][product_id]'" x-model="item.product_id" required>
                                                
                                                <div class="search-wrapper" x-show="!item.product_id" @click.stop>
                                                    <svg class="search-icon" style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0"/></svg>
                                                    <input 
                                                        type="text" 
                                                        class="search-input"
                                                        :id="'search-'+index"
                                                        x-model="item.searchQuery"
                                                        @input="updateDropdownPos(index); searchProducts(index)"
                                                        @focus="updateDropdownPos(index); item.showDropdown = true; searchProducts(index)"
                                                        @keydown.escape="item.showDropdown = false"
                                                        @keydown.arrow-down.prevent="moveHighlight(index, 1)"
                                                        @keydown.arrow-up.prevent="moveHighlight(index, -1)"
                                                        @keydown.enter.prevent="selectHighlighted(index)"
                                                        placeholder="Ketik SKU atau nama barang..."
                                                        autocomplete="off"
                                                    >
                                                    <span class="search-badge" x-show="item.searchResults.length > 0" x-text="item.searchResults.length + ' produk'"></span>
                                                    
                                                    <!-- Dropdown — position:fixed agar tidak terpotong overflow container -->
                                                    <div 
                                                        class="search-dropdown" 
                                                        x-show="item.showDropdown && (item.searchQuery.length > 0 || item.searchResults.length > 0)" 
                                                        :style="'top:'+item.ddTop+'px;left:'+item.ddLeft+'px;width:'+item.ddWidth+'px;'"
                                                        style="display:none;"
                                                        @mousedown.prevent
                                                    >
                                                        <template x-if="item.searchResults.length === 0 && item.searchQuery.length > 0">
                                                            <div class="dropdown-no-result">
                                                                <svg style="width:1.5rem;height:1.5rem;margin:0 auto 0.5rem;color:#d1d5db;display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                Tidak ada produk yang cocok dengan "<strong x-text="item.searchQuery"></strong>"
                                                            </div>
                                                        </template>
                                                        <template x-if="item.searchResults.length === 0 && item.searchQuery.length === 0">
                                                            <div class="dropdown-no-result">
                                                                Mulai ketik SKU atau nama barang untuk mencari...
                                                            </div>
                                                        </template>
                                                        <template x-for="(product, pIdx) in item.searchResults" :key="product.id">
                                                            <div 
                                                                class="dropdown-item" 
                                                                :class="{ 'highlighted': item.highlightIndex === pIdx }"
                                                                @mousedown.prevent="selectProduct(index, product)"
                                                                @mouseenter="item.highlightIndex = pIdx"
                                                            >
                                                                <span class="dropdown-item-sku" x-text="product.sku"></span>
                                                                <span class="dropdown-item-name" x-text="product.nama_barang"></span>
                                                                <span class="dropdown-item-stock" 
                                                                    :class="product.stok_saat_ini > 10 ? 'stock-ok' : (product.stok_saat_ini > 0 ? 'stock-low' : 'stock-zero')"
                                                                    x-text="'Stok: ' + product.stok_saat_ini">
                                                                </span>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                                
                                                <!-- Selected Product Display -->
                                                <div class="selected-product" x-show="item.product_id" style="display:none;">
                                                    <svg style="width:1rem;height:1rem;color:#16a34a;flex-shrink:0;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                                    <span class="dropdown-item-sku" x-text="item.selectedSku" style="font-size:0.6rem;"></span>
                                                    <span class="selected-product-name" x-text="item.selectedName"></span>
                                                    <button type="button" class="change-btn" @click="clearProduct(index)">✕ Ganti</button>
                                                </div>
                                            </td>
                                            
                                            <!-- Harga Beli -->
                                            <td class="px-2 py-3.5 align-top">
                                                <div class="price-input-wrapper">
                                                    <span class="price-prefix">Rp</span>
                                                    <input 
                                                        type="number" 
                                                        class="price-input-field"
                                                        :name="'items['+index+'][harga_beli]'" 
                                                        x-model="item.harga_beli" 
                                                        @input="updateSubtotal(index)" 
                                                        min="0" 
                                                        placeholder="0"
                                                        required
                                                    >
                                                </div>
                                            </td>
                                            
                                            <!-- Harga Jual -->
                                            <td class="px-2 py-3.5 align-top">
                                                <div class="price-input-wrapper">
                                                    <span class="price-prefix">Rp</span>
                                                    <input 
                                                        type="number" 
                                                        class="price-input-field"
                                                        :name="'items['+index+'][harga_jual]'" 
                                                        x-model="item.harga_jual" 
                                                        min="0" 
                                                        placeholder="0"
                                                        required
                                                    >
                                                </div>
                                            </td>
                                            
                                            <!-- Qty -->
                                            <td class="px-2 py-3.5 align-top">
                                                <div class="qty-wrapper">
                                                    <button type="button" class="qty-btn" @click="decreaseQty(index)">−</button>
                                                    <input 
                                                        type="number" 
                                                        class="qty-input"
                                                        :name="'items['+index+'][jumlah]'" 
                                                        x-model="item.jumlah" 
                                                        @input="updateSubtotal(index)"
                                                        min="1" 
                                                        required
                                                    >
                                                    <button type="button" class="qty-btn" @click="increaseQty(index)">+</button>
                                                </div>
                                            </td>
                                            
                                            <!-- Subtotal -->
                                            <td class="px-2 py-3.5 text-right align-top" style="padding-top: 1.15rem;">
                                                <span class="font-bold text-sm text-gray-900 whitespace-nowrap" x-text="'Rp ' + formatRupiah(item.subtotal)"></span>
                                            </td>
                                            
                                            <!-- Delete -->
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
                        </div>                </div>
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
</d    document.addEventListener('alpine:init', () => {
        Alpine.data('purchasePage', (productsData, hasErrors) => ({
            isModalOpen: hasErrors,
            products: productsData,
            _uidCounter: 0,
            items: [],
            
            init() {
                this.items = [this.newItem()];
            },

            newItem() {
                return { 
                    _uid: ++this._uidCounter,
                    product_id: '', 
                    jumlah: 1, 
                    harga_beli: 0,
                    harga_jual: 0,
                    subtotal: 0,
                    searchQuery: '',
                    searchResults: [],
                    showDropdown: false,
                    highlightIndex: -1,
                    selectedName: '',
                    selectedSku: '',
                    // posisi dropdown fixed (pixels)
                    ddTop: 0,
                    ddLeft: 0,
                    ddWidth: 320,
                };
            },
            
            openModal() {
                this.isModalOpen = true;
                document.body.style.overflow = 'hidden';
                this.items = [this.newItem()]; // reset items when opening modal
            },
            
            closeModal() {
                this.isModalOpen = false;
                document.body.style.overflow = '';
            },
            
            updateDropdownPos(index) {
                this.$nextTick(() => {
                    const el = document.getElementById('search-' + index);
                    if (!el) return;
                    const r = el.getBoundingClientRect();
                    this.items[index].ddTop  = r.bottom + 4;
                    this.items[index].ddLeft = r.left;
                    this.items[index].ddWidth = Math.max(r.width, 300);
                });
            },
            
            addItem() {
                this.items.push(this.newItem());
            },
            
            removeItem(index) {
                if (this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            },

            searchProducts(index) {
                const item = this.items[index];
                const q = item.searchQuery.toLowerCase().trim();
                if (q === '') {
                    item.searchResults = [];
                    item.highlightIndex = -1;
                    return;
                }
                item.searchResults = this.products.filter(p => 
                    p.sku.toLowerCase().includes(q) || 
                    p.nama_barang.toLowerCase().includes(q)
                ).slice(0, 12);
                item.highlightIndex = item.searchResults.length > 0 ? 0 : -1;
            },
            
            selectProduct(index, product) {
                const item = this.items[index];
                item.product_id = product.id;
                item.selectedName = product.nama_barang;
                item.selectedSku = product.sku;
                item.showDropdown = false;
                item.searchQuery = '';
                item.searchResults = [];
                // Autofill harga jual - parseInt agar tidak muncul desimal (misal 9000.00 → 9000)
                if (product.harga_jual && item.harga_jual === 0) {
                    item.harga_jual = parseInt(product.harga_jual) || 0;
                }
                // Autofill harga beli dari harga_modal jika belum diisi
                if (product.harga_modal && item.harga_beli === 0) {
                    item.harga_beli = parseInt(product.harga_modal) || 0;
                    this.updateSubtotal(index);
                }
            },

            clearProduct(index) {
                const item = this.items[index];
                item.product_id = '';
                item.selectedName = '';
                item.selectedSku = '';
                item.searchQuery = '';
                item.searchResults = [];
                item.subtotal = 0;
                // Focus the search input
                this.$nextTick(() => {
                    const inp = document.getElementById('search-' + index);
                    if (inp) inp.focus();
                });
            },

            moveHighlight(index, direction) {
                const item = this.items[index];
                if (!item.showDropdown || item.searchResults.length === 0) return;
                item.highlightIndex = Math.max(0, Math.min(item.searchResults.length - 1, item.highlightIndex + direction));
            },

            selectHighlighted(index) {
                const item = this.items[index];
                if (item.highlightIndex >= 0 && item.searchResults[item.highlightIndex]) {
                    this.selectProduct(index, item.searchResults[item.highlightIndex]);
                }
            },

            closeAllDropdowns() {
                this.items.forEach(item => { item.showDropdown = false; });
            },
            
            updateSubtotal(index) {
                const item = this.items[index];
                item.subtotal = (parseFloat(item.jumlah) || 0) * (parseFloat(item.harga_beli) || 0);
            },

            increaseQty(index) {
                this.items[index].jumlah = (parseInt(this.items[index].jumlah) || 0) + 1;
                this.updateSubtotal(index);
            },

            decreaseQty(index) {
                const current = parseInt(this.items[index].jumlah) || 1;
                if (current > 1) {
                    this.items[index].jumlah = current - 1;
                    this.updateSubtotal(index);
                }
            },
            
            calculateTotal() {
                return this.items.reduce((total, item) => total + (item.subtotal || 0), 0);
            },
            
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number || 0);
            }
        }));
    });
</script>
@endsection


