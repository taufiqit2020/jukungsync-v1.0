@extends('layouts.admin')
@section('title', 'Edit Barang')
@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-4xl mx-auto">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-semibold text-gray-800">Edit Barang: {{ $product->nama_barang }}</h2>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="sku" class="block text-sm font-medium text-gray-700 mb-1">SKU (Stock Keeping Unit)</label>
                <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                @error('sku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select name="category_id" id="category_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border bg-white" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                    @endforeach
                </select>
                @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="merk_id" class="block text-sm font-medium text-gray-700 mb-1">Merk (Opsional)</label>
                <select name="merk_id" id="merk_id" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border bg-white">
                    <option value="">-- Tanpa Merk --</option>
                    @foreach($merks as $merk)
                        <option value="{{ $merk->id }}" {{ old('merk_id', $product->merk_id) == $merk->id ? 'selected' : '' }}>{{ $merk->nama_merk }}</option>
                    @endforeach
                </select>
                @error('merk_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="nama_barang" class="block text-sm font-medium text-gray-700 mb-1">Nama Barang</label>
                <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang', $product->nama_barang) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                @error('nama_barang')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="satuan" class="block text-sm font-medium text-gray-700 mb-1">Satuan Barang (Opsional)</label>
                <input type="text" name="satuan" id="satuan" value="{{ old('satuan', $product->satuan) }}" placeholder="Contoh: Pcs, Box, Rim, Lusin" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border">
                @error('satuan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Barang</label>
                <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                @error('deskripsi')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="harga_modal" class="block text-sm font-medium text-gray-700 mb-1">Harga Modal</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="harga_modal" id="harga_modal" value="{{ old('harga_modal', intval($product->harga_modal)) }}" class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                </div>
                @error('harga_modal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="harga_jual" class="block text-sm font-medium text-gray-700 mb-1">Harga Jual</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', intval($product->harga_jual)) }}" class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                </div>
                @error('harga_jual')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="harga_grosir" class="block text-sm font-medium text-gray-700 mb-1">Harga Grosir (Opsional)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="harga_grosir" id="harga_grosir" value="{{ old('harga_grosir', intval($product->harga_grosir)) }}" class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" placeholder="Kosongkan jika tidak ada">
                </div>
                @error('harga_grosir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="stok_saat_ini" class="block text-sm font-medium text-gray-700 mb-1">Stok Saat Ini</label>
                <input type="number" name="stok_saat_ini" id="stok_saat_ini" value="{{ old('stok_saat_ini', $product->stok_saat_ini) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                @error('stok_saat_ini')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="stok_minimum" class="block text-sm font-medium text-gray-700 mb-1">Batas Minimum Stok</label>
                <input type="number" name="stok_minimum" id="stok_minimum" value="{{ old('stok_minimum', $product->stok_minimum) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                @error('stok_minimum')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Manajemen Gambar Produk (Maks. 5 Foto)</label>
                
                <!-- Grid Gambar yang Ada & yang Baru Di-upload -->
                <div class="grid grid-cols-5 gap-3 mb-3" id="preview-container">
                    @foreach($product->all_images as $index => $img)
                        <div class="relative aspect-square rounded-lg border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center p-1 existing-img-wrapper">
                            <img src="{{ Storage::url($img) }}" class="max-h-full max-w-full object-contain rounded">
                            <span class="absolute bottom-1 left-1 text-[8px] font-bold px-1.5 py-0.5 rounded text-white bg-green-600 index-badge">
                                {{ $index === 0 ? 'Utama' : 'Foto ' . ($index + 1) }}
                            </span>
                            <input type="hidden" name="existing_images[]" value="{{ $img }}" class="existing-image-input">
                            <button type="button" class="absolute -top-1 -right-1 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center shadow btn-delete-existing cursor-pointer">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    @endforeach
                </div>

                <input type="file" name="gambar[]" id="gambar" accept="image/*" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-tema-kuning file:text-tema-hitam hover:file:bg-yellow-500 border border-gray-300 rounded-md">
                <p class="text-xs text-gray-400 mt-1">Pilih foto baru jika ingin menambahkan. Total foto (lama + baru) tidak boleh melebihi 5. Foto di urutan pertama otomatis menjadi foto utama.</p>
                @error('gambar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                @error('gambar.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex justify-end gap-3 mt-6 border-t pt-4">
            <a href="{{ route('products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">Batal</a>
            <button type="submit" class="bg-tema-kuning hover:bg-yellow-500 text-tema-hitam font-medium py-2 px-4 rounded-md transition-colors shadow-sm">Update</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const previewContainer = document.getElementById('preview-container');
    const gambarInput = document.getElementById('gambar');

    // Fungsi untuk merapikan badge indeks gambar yang tersisa
    function refreshImageBadges() {
        const wrappers = previewContainer.querySelectorAll('.existing-img-wrapper, .new-img-wrapper');
        wrappers.forEach((wrapper, index) => {
            const badge = wrapper.querySelector('.index-badge');
            if (badge) {
                badge.className = `absolute bottom-1 left-1 text-[8px] font-bold px-1.5 py-0.5 rounded text-white ${index === 0 ? 'bg-green-600' : 'bg-gray-600'}`;
                badge.innerText = index === 0 ? 'Utama' : `Foto ${index + 1}`;
            }
        });
    }

    // Event listener untuk tombol hapus gambar yang sudah ada
    previewContainer.addEventListener('click', function(e) {
        const btnDelete = e.target.closest('.btn-delete-existing');
        if (btnDelete) {
            const wrapper = btnDelete.closest('.existing-img-wrapper');
            if (wrapper) {
                wrapper.remove();
                refreshImageBadges();
                // Reset file input agar tidak konflik
                gambarInput.value = '';
                const newWrappers = previewContainer.querySelectorAll('.new-img-wrapper');
                newWrappers.forEach(w => w.remove());
            }
        }
    });

    if (gambarInput && previewContainer) {
        gambarInput.addEventListener('change', function() {
            // Hapus pratinjau baru yang sebelumnya ditambahkan
            const newWrappers = previewContainer.querySelectorAll('.new-img-wrapper');
            newWrappers.forEach(w => w.remove());

            const existingCount = previewContainer.querySelectorAll('.existing-img-wrapper').length;
            const maxAllowedNew = 5 - existingCount;

            if (maxAllowedNew <= 0) {
                alert('Maksimal 5 foto. Silakan hapus beberapa foto lama terlebih dahulu sebelum menambahkan yang baru.');
                this.value = '';
                return;
            }

            const files = Array.from(this.files).slice(0, maxAllowedNew);
            
            files.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'relative aspect-square rounded-lg border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center p-1 new-img-wrapper';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'max-h-full max-w-full object-contain rounded';
                    
                    const badge = document.createElement('span');
                    badge.className = 'absolute bottom-1 left-1 text-[8px] font-bold px-1.5 py-0.5 rounded text-white index-badge';
                    
                    wrapper.appendChild(img);
                    wrapper.appendChild(badge);
                    previewContainer.appendChild(wrapper);
                    refreshImageBadges();
                }
                reader.readAsDataURL(file);
            });
        });
    }
});
</script>
@endsection
