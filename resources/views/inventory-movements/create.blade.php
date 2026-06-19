@extends('layouts.admin')
@section('title', 'Catat Pergerakan Stok')
@section('content')
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
<div class="bg-white shadow rounded-lg p-6 max-w-4xl mx-auto" x-data="inventoryForm()">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-semibold text-gray-800">Catat Pergerakan Stok</h2>
        <p class="text-sm text-gray-500 mt-1">Gunakan form ini untuk mencatat penambahan stok (Masuk) atau pengurangan stok (Keluar) secara banyak sekaligus.</p>
    </div>

    <form action="{{ route('inventory-movements.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="tipe_pergerakan" class="block text-sm font-medium text-gray-700 mb-1">Tipe Pergerakan</label>
                <select name="tipe_pergerakan" id="tipe_pergerakan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border bg-white" required>
                    <option value="masuk" {{ old('tipe_pergerakan') == 'masuk' ? 'selected' : '' }}>Barang Masuk (+)</option>
                    <option value="keluar" {{ old('tipe_pergerakan') == 'keluar' ? 'selected' : '' }}>Barang Keluar (-)</option>
                </select>
                @error('tipe_pergerakan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                @error('tanggal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mb-6">
            <label for="customer" class="block text-sm font-medium text-gray-700 mb-1">Customer / Klien (Opsional)</label>
            <select name="customer" id="customer" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border bg-white">
                <option value="">-- Pilih Customer --</option>
                @foreach($customers as $customer)
                    <option value="{{ $customer->nama_klien }}">{{ $customer->nama_klien }}</option>
                @endforeach
            </select>
            <p class="text-[10px] text-gray-500 mt-1 mb-4">Jika dipilih, nama customer akan otomatis ditambahkan ke Keterangan.</p>

            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" placeholder="Contoh: Tambahan stok dari supplier XYZ">{{ old('keterangan') }}</textarea>
            @error('keterangan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Form Multi Barang -->
        <div class="mb-6 border rounded-lg overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b flex justify-between items-center">
                <h3 class="text-sm font-bold text-gray-700">Daftar Barang</h3>
                <button type="button" @click="addItem()" class="text-xs bg-tema-marun hover:bg-red-800 text-white px-3 py-1.5 rounded-md transition-colors flex items-center gap-1 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Barang
                </button>
            </div>
            
            <div class="p-4 space-y-4">
                <template x-for="(item, index) in items" :key="item.id">
                    <div class="flex flex-col sm:flex-row gap-4 items-start p-3 bg-white rounded-lg border border-gray-200 relative shadow-sm">
                        <div class="flex-1 w-full" x-init="$nextTick(() => { initSelect(index) })">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Pilih Barang</label>
                            <select :name="`items[${index}][product_id]`" :id="`product_${item.id}`" class="w-full bg-white" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">
                                        [{{ $product->sku }}] {{ $product->nama_barang }} (Sisa Stok: {{ $product->stok_saat_ini }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="w-full sm:w-32">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Jumlah</label>
                            <input type="number" :name="`items[${index}][jumlah]`" x-model="item.jumlah" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>
                        </div>
                        <div class="pt-5 flex items-center h-full">
                            <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="text-red-500 hover:bg-red-100 p-2 rounded-md transition-colors" title="Hapus baris">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
            @error('items')<p class="text-red-500 text-xs mt-1 ml-4 mb-4">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end gap-3 border-t pt-4">
            <a href="{{ route('inventory-movements.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">Batal</a>
            <button type="submit" class="bg-tema-kuning hover:bg-yellow-500 text-tema-hitam font-medium py-2 px-4 rounded-md transition-colors shadow-sm">Simpan Pergerakan</button>
        </div>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('inventoryForm', () => ({
            items: [
                { id: Date.now(), product_id: '', jumlah: 1 }
            ],
            
            addItem() {
                this.items.push({
                    id: Date.now(),
                    product_id: '',
                    jumlah: 1
                });
            },
            
            removeItem(index) {
                if (this.items.length > 1) {
                    let elId = `product_${this.items[index].id}`;
                    let el = document.getElementById(elId);
                    if(el && el.tomselect){
                        el.tomselect.destroy();
                    }
                    this.items.splice(index, 1);
                }
            },

            initSelect(index) {
                let elId = `product_${this.items[index].id}`;
                new TomSelect(`#${elId}`, {
                    create: false,
                    dropdownParent: 'body',
                    placeholder: '🔍 Ketik kode / nama barang...',
                    sortField: { field: "text", direction: "asc" },
                    maxOptions: 50,
                    render: {
                        option: function(data, escape) {
                            let text = escape(data.text);
                            // Ekstrak informasi dari opsi "[SKU] Nama Barang (Sisa Stok: XX)"
                            let match = text.match(/^\[(.*?)\]\s*(.*?)\s*\(Sisa Stok:\s*(\d+)\)$/);
                            if (match) {
                                let sku = match[1];
                                let pname = match[2];
                                let stock = parseInt(match[3]);
                                let stockClass = stock > 10 ? 'stock-ok' : 'stock-low';
                                return '<div>' +
                                    '<span class=\"sku-badge\">' + escape(sku) + '</span>' +
                                    '<span class=\"product-name\">' + escape(pname) + '</span>' +
                                    '<span class=\"stock-info ' + stockClass + '\">' + stock + '</span>' +
                                    '</div>';
                            }
                            return '<div>' + text + '</div>';
                        },
                        item: function(data, escape) {
                            let text = escape(data.text);
                            let match = text.match(/^\[(.*?)\]\s*(.*?)\s*\(Sisa Stok:\s*(\d+)\)$/);
                            if (match) {
                                let sku = match[1];
                                let pname = match[2];
                                return '<div class=\"truncate w-full\" style=\"max-width:100%\"><span style=\"background:#7f1d1d;color:#fff;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:700;margin-right:6px\">' + escape(sku) + '</span>' + escape(pname) + '</div>';
                            }
                            return '<div>' + text + '</div>';
                        },
                        no_results: function() {
                            return '<div class=\"no-results\">Tidak ada barang ditemukan</div>';
                        }
                    }
                });
            }
        }));
    });
</script>

@endsection
