@extends('layouts.admin')
@section('title', 'Tambah Barang')
@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-4xl mx-auto">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Barang Baru</h2>
    </div>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU (Stock Keeping Unit)</label>
                <input type="text" name="sku" id="sku" value="{{ old('sku') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                @error('sku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border bg-white" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="merk_id" class="block text-sm font-medium text-gray-700 mb-1">Merk (Opsional)</label>
                <select name="merk_id" id="merk_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border bg-white">
                    <option value="">-- Tanpa Merk --</option>
                    @foreach($merks as $merk)
                        <option value="{{ $merk->id }}" {{ old('merk_id') == $merk->id ? 'selected' : '' }}>{{ $merk->nama_merk }}</option>
                    @endforeach
                </select>
                @error('merk_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang') }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                @error('nama_barang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">Satuan Barang (Opsional)</label>
                <input type="text" name="satuan" id="satuan" value="{{ old('satuan') }}" placeholder="Contoh: Pcs, Box, Rim, Lusin" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border">
                @error('satuan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Barang</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="harga_modal" class="block text-sm font-medium text-gray-700 mb-1">Harga Modal</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="harga_modal" id="harga_modal" value="{{ old('harga_modal') }}" class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                </div>
                @error('harga_modal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual') }}" class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                </div>
                @error('harga_jual')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="harga_grosir" class="block text-sm font-medium text-gray-700 mb-1">Harga Grosir (Opsional)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="harga_grosir" id="harga_grosir" value="{{ old('harga_grosir') }}" class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" placeholder="Kosongkan jika tidak ada">
                </div>
                @error('harga_grosir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="stok_saat_ini" class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                <input type="number" name="stok_saat_ini" id="stok_saat_ini" value="{{ old('stok_saat_ini', 0) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                @error('stok_saat_ini')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="stok_minimum" class="block text-sm font-medium text-gray-700 mb-1">Batas Minimum Stok (Default: 5)</label>
                <input type="number" name="stok_minimum" id="stok_minimum" value="{{ old('stok_minimum', 5) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                @error('stok_minimum')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                <input type="file" name="gambar" id="gambar" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-tema-kuning file:text-tema-hitam hover:file:bg-yellow-500 border border-gray-300 rounded-md">
                @error('gambar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6 border-t pt-4">
            <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">Batal</a>
            <button type="submit" class="bg-tema-kuning hover:bg-yellow-500 text-tema-hitam font-medium py-2 px-4 rounded-md transition-colors shadow-sm">Simpan</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category_id');
    const skuInput = document.getElementById('sku');

    if (categorySelect && skuInput) {
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            if (!categoryId) {
                skuInput.value = '';
                return;
            }

            // Tampilkan status memuat
            skuInput.placeholder = 'Memuat SKU otomatis...';
            skuInput.value = '';

            fetch(`/products/next-sku?category_id=${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.sku) {
                        skuInput.value = data.sku;
                    }
                })
                .catch(error => {
                    console.error('Error fetching SKU:', error);
                });
        });
    }
});
</script>
@endsection
