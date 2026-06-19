@extends('layouts.admin')
@section('title', 'Input Barang Masuk')
@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-6xl mx-auto" x-data="purchaseForm({{ $products->toJson() }})">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-semibold text-gray-800">Input Barang Masuk (Restok / Pembelian)</h2>
    </div>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            <ul>
                @foreach($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchases.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Informasi Supplier -->
            <div class="bg-gray-50 p-4 rounded-md border border-gray-200">
                <h3 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Informasi Nota / Faktur</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nomor Faktur / Nota Pembelian *</label>
                        <input type="text" name="nomor_faktur" value="{{ old('nomor_faktur') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 text-sm py-1.5 px-3 border" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Nama Supplier / Toko *</label>
                        <input type="text" name="nama_supplier" value="{{ old('nama_supplier') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 text-sm py-1.5 px-3 border" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Pembelian *</label>
                        <input type="date" name="tanggal_pembelian" value="{{ old('tanggal_pembelian', date('Y-m-d')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 text-sm py-1.5 px-3 border" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 text-sm py-1.5 px-3 border">{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Barang -->
        <div class="mb-6">
            <h3 class="text-sm font-bold text-gray-700 mb-3 uppercase tracking-wide">Daftar Barang Masuk</h3>
            <div class="overflow-x-auto border border-gray-200 rounded-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase w-12 text-center">No</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase w-96">Nama Barang (Pencarian Cerdas)</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase w-32">Harga Beli / Pcs</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-600 uppercase w-24">Qty Masuk</th>
                            <th class="px-3 py-2 text-right text-xs font-medium text-gray-600 uppercase w-32">Subtotal</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-600 uppercase w-16">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td class="px-3 py-2 text-center text-sm font-medium text-gray-500" x-text="index + 1"></td>
                                <td class="px-3 py-2">
                                    <select x-model="item.product_id" :name="'items['+index+'][product_id]'" 
                                            x-init="$nextTick(() => { 
                                                let ts = new TomSelect($el, {
                                                    create: false,
                                                    placeholder: 'Ketik SKU / Nama Barang...',
                                                    sortField: { field: 'text', direction: 'asc' },
                                                    onChange: function(value) {
                                                        item.product_id = value;
                                                        updateSubtotal(index);
                                                    }
                                                });
                                            })" class="w-full" required>
                                        <option value="">Ketik SKU / Nama Barang...</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->sku }} - {{ $p->nama_barang }} (Sisa: {{ $p->stok_saat_ini }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-3 py-2">
                                    <div class="flex rounded-md shadow-sm">
                                        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                            Rp
                                        </span>
                                        <input type="number" x-model="item.harga_beli" :name="'items['+index+'][harga_beli]'" @input="updateSubtotal(index)" class="flex-1 min-w-0 block w-full px-3 py-1.5 rounded-none rounded-r-md focus:ring-tema-marun focus:border-tema-marun sm:text-sm border-gray-300 border" min="0" required>
                                    </div>
                                </td>
                                <td class="px-3 py-2">
                                    <input type="number" x-model="item.jumlah" :name="'items['+index+'][jumlah]'" @input="updateSubtotal(index)" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun text-sm py-1.5 px-2 border" min="1" required>
                                </td>
                                <td class="px-3 py-2 text-right font-medium text-sm text-gray-800" x-text="'Rp ' + formatRupiah(item.subtotal)"></td>
                                <td class="px-3 py-2 text-center">
                                    <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700 p-1" title="Hapus Baris" x-show="items.length > 1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-3 py-3 text-right text-sm font-bold text-gray-700 uppercase">Total Biaya Pembelian:</td>
                            <td class="px-3 py-3 text-right text-lg font-bold text-red-600" x-text="'Rp ' + formatRupiah(calculateTotal())"></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="mt-3">
                <button type="button" @click="addItem()" class="bg-gray-100 border border-gray-300 hover:bg-gray-200 text-gray-700 font-medium py-1.5 px-3 rounded text-sm flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Baris Barang
                </button>
            </div>
        </div>

        <div class="flex justify-end gap-3 border-t pt-6">
            <a href="{{ route('purchases.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2.5 px-5 rounded-md transition-colors text-sm">Batal</a>
            <button type="submit" class="bg-tema-kuning hover:bg-yellow-500 text-tema-hitam font-bold py-2.5 px-6 rounded-md transition-colors shadow-sm text-sm">
                Simpan & Tambah Stok
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('purchaseForm', (productsData) => ({
            products: productsData,
            items: [
                { product_id: '', jumlah: 1, harga_beli: 0, subtotal: 0 }
            ],
            
            addItem() {
                this.items.push({ product_id: '', jumlah: 1, harga_beli: 0, subtotal: 0 });
            },
            
            removeItem(index) {
                if(this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            },
            
            updateSubtotal(index) {
                let item = this.items[index];
                item.subtotal = item.jumlah * item.harga_beli;
            },
            
            calculateTotal() {
                return this.items.reduce((total, item) => total + item.subtotal, 0);
            },
            
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
        }));
    });
</script>
@endsection
