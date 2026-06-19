@extends('layouts.admin')

@section('title', 'Edit Barang Masuk')

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="purchaseEditPage({{ $purchase->purchaseItems->toJson() }})">
    <div class="flex items-center gap-4">
        <a href="{{ route('purchases.index') }}" class="p-2 bg-white text-gray-500 hover:text-gray-900 rounded-xl shadow-sm border border-gray-200 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Barang Masuk (Restock)</h1>
            <p class="text-sm text-gray-500">Ubah detail nota pembelian barang masuk.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 text-red-600 p-4 rounded-xl border border-red-100 mb-6">
        <ul class="list-disc pl-5 text-sm font-medium">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('purchases.update', $purchase) }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">No. Faktur *</label>
                <input type="text" name="nomor_faktur" value="{{ old('nomor_faktur', $purchase->nomor_faktur) }}" required
                    class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Supplier / Toko *</label>
                <input type="text" name="nama_supplier" value="{{ old('nama_supplier', $purchase->nama_supplier) }}" required
                    class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pembelian *</label>
                <input type="date" name="tanggal_pembelian" value="{{ old('tanggal_pembelian', \Carbon\Carbon::parse($purchase->tanggal_pembelian)->format('Y-m-d')) }}" required
                    class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan</label>
                <input type="text" name="keterangan" value="{{ old('keterangan', $purchase->keterangan) }}"
                    class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20" placeholder="Opsional">
            </div>
        </div>

        <!-- Rincian Barang (Edit Harga Beli & Harga Jual) -->
        <div class="pt-4 border-t border-gray-100">
            <h2 class="text-md font-bold text-gray-800 mb-3 flex items-center gap-2">
                📦 Rincian Barang Restok 
            </h2>
            <p class="text-xs text-gray-500 mb-4">Ubah Harga Beli / Modal dan Harga Jual pada kolom di bawah. Perubahan harga akan disinkronkan otomatis ke master data barang saat disimpan.</p>
            
            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200" style="table-layout: fixed;">
                    <colgroup>
                        <col style="width: 50px;">
                        <col style="width: auto;">
                        <col style="width: 180px;">
                        <col style="width: 180px;">
                        <col style="width: 90px;">
                        <col style="width: 150px;">
                    </colgroup>
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">#</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-gray-500 uppercase">Nama Barang</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Harga Beli / Modal</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Harga Jual</th>
                            <th class="px-4 py-3 text-center text-xs font-bold text-gray-500 uppercase">Qty</th>
                            <th class="px-4 py-3 text-right text-xs font-bold text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <template x-for="(item, index) in items" :key="item.id">
                            <tr class="hover:bg-amber-50/50 transition-colors">
                                <td class="px-4 py-3.5 text-sm font-semibold text-gray-500 align-top" style="padding-top: 1.15rem;" x-text="index + 1"></td>
                                <td class="px-4 py-3.5 text-sm font-bold text-gray-800 align-top" style="padding-top: 1.15rem;">
                                    <span class="bg-tema-marun text-white text-[10px] font-bold px-2 py-0.5 rounded-md mr-1.5" x-text="item.product ? item.product.sku : '-'"></span>
                                    <span class="text-gray-800" x-text="item.product ? item.product.nama_barang : '-'"></span>
                                </td>
                                <td class="px-2 py-3.5 align-top">
                                    <div class="flex rounded-lg overflow-hidden border-2 border-gray-300 bg-white shadow-sm focus-within:border-tema-marun focus-within:ring-1 focus-within:ring-tema-marun">
                                        <span class="inline-flex items-center px-2.5 bg-tema-marun text-white text-xs font-bold flex-shrink-0">Rp</span>
                                        <input type="number" x-model.number="item.harga_beli" :name="'items['+item.id+'][harga_beli]'" class="flex-1 min-w-0 w-full px-2 py-2 text-sm font-bold text-gray-900 border-0 bg-white focus:ring-0 focus:border-0" required min="0">
                                    </div>
                                </td>
                                <td class="px-2 py-3.5 align-top">
                                    <div class="flex rounded-lg overflow-hidden border-2 border-gray-300 bg-white shadow-sm focus-within:border-tema-marun focus-within:ring-1 focus-within:ring-tema-marun">
                                        <span class="inline-flex items-center px-2.5 bg-tema-marun text-white text-xs font-bold flex-shrink-0">Rp</span>
                                        <input type="number" x-model.number="item.harga_jual" :name="'items['+item.id+'][harga_jual]'" class="flex-1 min-w-0 w-full px-2 py-2 text-sm font-bold text-gray-900 border-0 bg-white focus:ring-0 focus:border-0" required min="0">
                                    </div>
                                </td>
                                <td class="px-4 py-3.5 text-sm font-bold text-gray-800 text-center align-top" style="padding-top: 1.15rem;" x-text="item.jumlah"></td>
                                <td class="px-4 py-3.5 text-sm font-black text-gray-900 text-right align-top" style="padding-top: 1.15rem;" x-text="'Rp ' + formatRupiah(item.harga_beli * item.jumlah)"></td>
                            </tr>
                        </template>
                    </tbody>
                    <tfoot class="bg-red-50/50">
                        <tr>
                            <td colspan="5" class="px-4 py-3.5 text-sm font-bold text-red-950 uppercase tracking-wider text-right">Total Biaya:</td>
                            <td class="px-4 py-3.5 text-base font-black text-red-600 text-right" x-text="'Rp ' + formatRupiah(calculateTotal())"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('purchases.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors text-sm shadow-sm">Batal</a>
            <button type="submit" class="px-6 py-3 bg-tema-marun hover:bg-red-800 text-white font-bold rounded-xl shadow-md transition-all flex items-center text-sm hover:scale-105 duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('purchaseEditPage', (itemsData) => ({
            items: itemsData,
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
