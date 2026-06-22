@extends('layouts.admin')
@section('title', 'Input Barang Masuk')
@section('content')

<style>
    /* =============================================
       PURCHASE FORM PREMIUM DESIGN
    ============================================= */
    .purchase-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f5 100%);
        min-height: 100vh;
        padding: 1.5rem;
    }
    
    /* Header Section */
    .page-header {
        background: linear-gradient(135deg, #7f1d1d 0%, #991b1b 50%, #b91c1c 100%);
        border-radius: 1.25rem;
        padding: 1.5rem 2rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 40px rgba(127, 29, 29, 0.3);
    }
    .page-header h1 {
        color: white;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 0;
    }
    .page-header p { color: rgba(255,255,255,0.7); margin: 0.25rem 0 0; font-size: 0.875rem; }
    .header-icon {
        width: 3.5rem; height: 3.5rem;
        background: rgba(255,255,255,0.15);
        border-radius: 1rem;
        display: flex; align-items: center; justify-content: center;
    }

    /* Info Cards Row */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 1024px) { .info-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px) { .info-grid { grid-template-columns: 1fr; } }

    .info-card {
        background: white;
        border-radius: 1rem;
        padding: 1.25rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }
    .info-card label {
        font-size: 0.7rem;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        display: block;
        margin-bottom: 0.5rem;
    }
    .info-card input, .info-card textarea {
        width: 100%;
        background: #f9fafb;
        border: 1.5px solid #e5e7eb;
        border-radius: 0.625rem;
        padding: 0.625rem 0.875rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: #111827;
        transition: all 0.2s;
        outline: none;
    }
    .info-card input:focus, .info-card textarea:focus {
        border-color: #991b1b;
        background: white;
        box-shadow: 0 0 0 3px rgba(153, 27, 27, 0.1);
    }

    /* Table Container */
    .table-card {
        background: white;
        border-radius: 1.25rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }
    .table-card-header {
        background: linear-gradient(135deg, #1f2937, #374151);
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .table-card-header h3 { color: white; font-weight: 700; font-size: 0.9rem; letter-spacing: 0.05em; margin: 0; }
    .table-card-header span { color: rgba(255,255,255,0.6); font-size: 0.8rem; }

    /* Table Styles */
    table.purchase-table { width: 100%; border-collapse: collapse; }
    table.purchase-table thead tr {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
    }
    table.purchase-table thead th {
        padding: 0.875rem 1rem;
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        text-align: left;
        white-space: nowrap;
    }
    table.purchase-table thead th.th-center { text-align: center; }
    table.purchase-table thead th.th-right { text-align: right; }
    
    table.purchase-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    table.purchase-table tbody tr:hover { background: #fafafa; }
    table.purchase-table tbody tr:last-child { border-bottom: none; }
    table.purchase-table td { padding: 0.875rem 1rem; vertical-align: middle; }

    /* Row Number Badge */
    .row-num {
        display: inline-flex; align-items: center; justify-content: center;
        width: 1.75rem; height: 1.75rem;
        background: linear-gradient(135deg, #7f1d1d, #991b1b);
        color: white;
        border-radius: 50%;
        font-size: 0.75rem;
        font-weight: 800;
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
        text-align: center;
        font-size: 0.875rem;
        font-weight: 800;
        color: #1f2937;
        outline: none;
        min-width: 2rem;
        padding: 0.625rem 0;
    }

    /* Subtotal Cell */
    .subtotal-cell {
        text-align: right;
        font-weight: 800;
        color: #1f2937;
        font-size: 0.9rem;
        white-space: nowrap;
    }

    /* Delete Button */
    .delete-row-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 0.5rem;
        background: #fee2e2;
        color: #dc2626;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        margin: auto;
    }
    .delete-row-btn:hover { background: #dc2626; color: white; transform: scale(1.1); }

    /* Footer: Add Row & Total */
    .table-footer {
        padding: 1rem 1.5rem;
        background: #f8fafc;
        border-top: 2px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .add-row-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        border: 2px dashed #cbd5e1;
        border-radius: 0.75rem;
        padding: 0.625rem 1.25rem;
        font-size: 0.8rem;
        font-weight: 700;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }
    .add-row-btn:hover {
        border-color: #991b1b;
        color: #991b1b;
        background: #fef2f2;
    }

    .total-display {
        display: flex;
        align-items: center;
        gap: 1rem;
        background: linear-gradient(135deg, #7f1d1d, #991b1b);
        color: white;
        border-radius: 1rem;
        padding: 0.875rem 1.5rem;
        box-shadow: 0 4px 16px rgba(127, 29, 29, 0.3);
    }
    .total-label { font-size: 0.75rem; font-weight: 700; opacity: 0.8; text-transform: uppercase; letter-spacing: 0.08em; }
    .total-amount { font-size: 1.5rem; font-weight: 900; }

    /* Action Buttons */
    .action-bar {
        background: white;
        border-radius: 1.25rem;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }
    .action-info { font-size: 0.8rem; color: #6b7280; display: flex; align-items: center; gap: 0.5rem; }
    .action-buttons { display: flex; gap: 0.875rem; }
    .btn-cancel {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: #f3f4f6;
        color: #374151;
        border: none;
        border-radius: 0.875rem;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-cancel:hover { background: #e5e7eb; }
    .btn-save {
        display: inline-flex; align-items: center; gap: 0.5rem;
        background: linear-gradient(135deg, #ca8a04, #d97706);
        color: #111827;
        border: none;
        border-radius: 0.875rem;
        padding: 0.75rem 2rem;
        font-size: 0.9rem;
        font-weight: 800;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.2s;
        box-shadow: 0 4px 16px rgba(202, 138, 4, 0.35);
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(202, 138, 4, 0.45);
    }

    /* Error Banner */
    .error-banner {
        background: #fef2f2;
        border: 1.5px solid #fecaca;
        border-radius: 1rem;
        padding: 1rem 1.25rem;
        margin-bottom: 1.25rem;
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
    }
</style>

<div x-data="purchaseForm({{ $products->toJson() }})" @click.away="closeAllDropdowns()">
    
    @if($errors->any())
    <div class="error-banner">
        <svg style="width:1.25rem;height:1.25rem;color:#dc2626;flex-shrink:0;margin-top:0.1rem" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <ul style="margin:0;padding:0;list-style:none;">
            @foreach($errors->all() as $error)
                <li style="font-size:0.875rem;font-weight:600;color:#991b1b;margin-bottom:0.2rem;">– {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('purchases.store') }}" method="POST" @submit.prevent="submitForm($event)">
        @csrf

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1>📦 Input Barang Masuk</h1>
                <p>Restok Produk / Pembelian Barang Baru — Stok akan otomatis bertambah</p>
            </div>
            <div class="header-icon">
                <svg style="width:1.75rem;height:1.75rem;color:white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>

        <!-- Info Fields -->
        <div class="info-grid">
            <div class="info-card">
                <label>📄 Nomor Faktur / Nota *</label>
                <input type="text" name="nomor_faktur" value="{{ old('nomor_faktur') }}" placeholder="Contoh: INV-001/VI/2026" required>
            </div>
            <div class="info-card">
                <label>🏪 Nama Supplier / Toko *</label>
                <input type="text" name="nama_supplier" value="{{ old('nama_supplier') }}" placeholder="Contoh: Toko Jaya Mas" required>
            </div>
            <div class="info-card">
                <label>📅 Tanggal Pembelian *</label>
                <input type="date" name="tanggal_pembelian" value="{{ old('tanggal_pembelian', date('Y-m-d')) }}" required>
            </div>
            <div class="info-card">
                <label>📝 Keterangan (Opsional)</label>
                <input type="text" name="keterangan" value="{{ old('keterangan') }}" placeholder="Catatan tambahan...">
            </div>
        </div>

        <!-- Items Table -->
        <div class="table-card">
            <div class="table-card-header">
                <h3>🛒 DAFTAR BARANG MASUK</h3>
                <span x-text="items.length + ' item'"></span>
            </div>
            
            <div style="overflow-x:auto;">
                <table class="purchase-table">
                    <thead>
                        <tr>
                            <th style="width:3.5rem;" class="th-center">No</th>
                            <th style="min-width:280px;">Nama Barang (Ketik Langsung untuk Cari)</th>
                            <th style="width:160px;">Harga Beli / Modal</th>
                            <th style="width:130px;" class="th-center">Harga Jual</th>
                            <th style="width:120px;" class="th-center">Qty Masuk</th>
                            <th style="width:150px;" class="th-right">Subtotal</th>
                            <th style="width:3.5rem;" class="th-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in items" :key="item._uid">
                            <tr>
                                <!-- No -->
                                <td class="th-center">
                                    <span class="row-num" x-text="index + 1"></span>
                                </td>
                                
                                <!-- Product Search -->
                                <td>
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
                                <td>
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
                                <td>
                                    <div class="price-input-wrapper">
                                        <span class="price-prefix">Rp</span>
                                        <input 
                                            type="number" 
                                            class="price-input-field"
                                            :name="'items['+index+'][harga_jual]'" 
                                            x-model="item.harga_jual" 
                                            min="0" 
                                            placeholder="0"
                                        >
                                    </div>
                                </td>
                                
                                <!-- Qty -->
                                <td>
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
                                <td class="subtotal-cell">
                                    <span x-text="'Rp ' + formatRupiah(item.subtotal)"></span>
                                </td>
                                
                                <!-- Delete -->
                                <td class="th-center">
                                    <button type="button" class="delete-row-btn" @click="removeItem(index)" x-show="items.length > 1" title="Hapus Baris">
                                        <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            
            <!-- Table Footer -->
            <div class="table-footer">
                <button type="button" class="add-row-btn" @click="addItem()">
                    <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Tambah Baris Barang
                </button>
                
                <div class="total-display">
                    <div>
                        <div class="total-label">Total Biaya Pembelian</div>
                        <div class="total-amount" x-text="'Rp ' + formatRupiah(calculateTotal())"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="action-bar">
            <div class="action-info">
                <svg style="width:1rem;height:1rem;color:#10b981;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                Stok barang akan otomatis bertambah setelah disimpan
            </div>
            <div class="action-buttons">
                <a href="{{ route('purchases.index') }}" class="btn-cancel">
                    <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali
                </a>
                <button type="submit" class="btn-save">
                    <svg style="width:1.1rem;height:1.1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan & Tambah Stok
                </button>
            </div>
        </div>

    </form>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('purchaseForm', (productsData) => ({
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

        // Hitung posisi dropdown pakai getBoundingClientRect agar tepat di bawah input
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
            // Autofill harga jual — parseInt agar tidak muncul desimal (misal 9000.00 → 9000)
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
        },

        submitForm(e) {
            // Validate all items have a product selected
            for (let i = 0; i < this.items.length; i++) {
                if (!this.items[i].product_id) {
                    alert('Baris ke-' + (i+1) + ': Silakan pilih barang terlebih dahulu!');
                    const inp = document.getElementById('search-' + i);
                    if (inp) { inp.focus(); this.items[i].showDropdown = true; this.searchProducts(i); }
                    return;
                }
            }
            e.target.submit();
        }
    }));
});
</script>
@endsection
