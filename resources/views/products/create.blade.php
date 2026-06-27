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
                <div class="relative mb-2">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" name="harga_grosir" id="harga_grosir" value="{{ old('harga_grosir') }}" class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" placeholder="Kosongkan jika tidak ada">
                </div>
                @error('harga_grosir')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                <!-- Quick Percentage Buttons (1% - 10%) -->
                <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:12px;" class="p-2.5 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <span style="font-size:0.65rem;font-weight:800;color:#6b7280;text-transform:uppercase;letter-spacing:0.05em;">⚡ Potongan Grosir Otomatis:</span>
                        <span id="grosir_info" style="font-size:0.7rem;font-weight:700;color:#15803d;"></span>
                    </div>
                    <div class="flex flex-wrap gap-1">
                        @foreach(range(1, 10) as $p)
                        <button type="button" onclick="setGrosirPersen({{ $p }})" class="btn-grosir-persen px-2 py-1 text-xs font-bold rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-red-800 hover:text-white transition-all">
                            {{ $p }}%
                        </button>
                        @endforeach
                    </div>
                </div>
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

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk (Maks. 5 Foto)</label>
                
                <!-- Grid Pratinjau Gambar -->
                <div class="grid grid-cols-5 gap-3 mb-3 hidden" id="preview-container">
                    <!-- Pratinjau gambar akan diisi via javascript -->
                </div>

                <input type="file" name="gambar[]" id="gambar" accept="image/*" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-tema-kuning file:text-tema-hitam hover:file:bg-yellow-500 border border-gray-300 rounded-md">
                <p class="text-xs text-gray-400 mt-1">Pilih hingga 5 foto. Foto pertama otomatis menjadi foto utama produk.</p>
                @error('gambar')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                @error('gambar.*')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
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

    const gambarInput = document.getElementById('gambar');
    const previewContainer = document.getElementById('preview-container');

    if (gambarInput && previewContainer) {
        gambarInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            
            const files = Array.from(this.files).slice(0, 5);
            
            if (files.length > 0) {
                previewContainer.classList.remove('hidden');
                
                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'relative aspect-square rounded-lg border border-gray-200 overflow-hidden bg-gray-50 flex items-center justify-center p-1';
                        
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'max-h-full max-w-full object-contain rounded';
                        
                        const badge = document.createElement('span');
                        badge.className = `absolute bottom-1 left-1 text-[8px] font-bold px-1.5 py-0.5 rounded text-white ${index === 0 ? 'bg-green-600' : 'bg-gray-600'}`;
                        badge.innerText = index === 0 ? 'Utama' : `Foto ${index + 1}`;
                        
                        wrapper.appendChild(img);
                        wrapper.appendChild(badge);
                        previewContainer.appendChild(wrapper);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                previewContainer.classList.add('hidden');
            }
        });
    }
});

let currentPersenGrosir = 0;

function setGrosirPersen(persen) {
    currentPersenGrosir = persen;
    calculateGrosir();
}

function calculateGrosir() {
    const hargaJualInput = document.getElementById('harga_jual');
    const hargaGrosirInput = document.getElementById('harga_grosir');
    const grosirInfo = document.getElementById('grosir_info');
    
    if (!hargaJualInput || !hargaGrosirInput) return;
    
    const hargaJual = parseFloat(hargaJualInput.value) || 0;
    if (hargaJual > 0 && currentPersenGrosir > 0) {
        const potongan = hargaJual * (currentPersenGrosir / 100);
        const hargaGrosir = Math.round(hargaJual - potongan);
        hargaGrosirInput.value = hargaGrosir;
        if (grosirInfo) {
            grosirInfo.innerText = `Disk. ${currentPersenGrosir}% (Hemat Rp ${new Intl.NumberFormat('id-ID').format(Math.round(potongan))})`;
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const hargaJualInput = document.getElementById('harga_jual');
    const hargaGrosirInput = document.getElementById('harga_grosir');
    if (hargaJualInput) {
        hargaJualInput.addEventListener('input', calculateGrosir);
    }
    if (hargaGrosirInput) {
        hargaGrosirInput.addEventListener('input', function() {
            currentPersenGrosir = 0;
            const grosirInfo = document.getElementById('grosir_info');
            if (grosirInfo) grosirInfo.innerText = '';
        });
    }
});
</script>
@endsection
