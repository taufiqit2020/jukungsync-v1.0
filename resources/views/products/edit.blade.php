@extends('layouts.admin')
@section('title', 'Edit Barang')
@section('content')

<div class="max-w-5xl mx-auto px-4 py-6">
    <!-- Header Card -->
    <div style="background: linear-gradient(135deg, #111827, #1f2937); border-radius: 16px 16px 0 0;" class="p-6 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4 shadow-lg">
        <div>
            <h2 class="text-2xl font-bold tracking-tight">Edit Barang: {{ $product->nama_barang }}</h2>
            <p class="text-xs text-gray-400 mt-1">Ubah formulir di bawah ini untuk memperbarui informasi barang di sistem inventory.</p>
        </div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-xl text-xs transition-all border border-gray-700">
            ← Kembali ke List
        </a>
    </div>

    <!-- Main Content Form -->
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-b-16 shadow-xl p-6 md:p-8 border-t-0 border border-gray-100" id="productForm">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Side: Data Utama -->
            <div class="lg:col-span-7 space-y-6">
                <div>
                    <h3 style="color:#7f1d1d; border-bottom: 2px solid rgba(127,29,29,0.15);" class="text-xs font-black uppercase tracking-widest pb-2 mb-4">📦 Informasi Barang</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="category_id" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" id="category_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border bg-white text-sm font-semibold" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="sku" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">SKU (Kode Barang) <span class="text-red-500">*</span></label>
                        <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border text-sm font-bold bg-gray-50" required>
                        @error('sku')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="md:col-span-2">
                        <label for="nama_barang" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Nama Barang / Deskripsi Singkat <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ old('nama_barang', $product->nama_barang) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border text-sm font-semibold" required>
                        @error('nama_barang')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="merk_id" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Merk / Brand (Opsional)</label>
                        <select name="merk_id" id="merk_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border bg-white text-sm font-semibold">
                            <option value="">-- Tanpa Merk --</option>
                            @foreach($merks as $merk)
                                <option value="{{ $merk->id }}" {{ old('merk_id', $product->merk_id) == $merk->id ? 'selected' : '' }}>{{ $merk->nama_merk }}</option>
                            @endforeach
                        </select>
                        @error('merk_id')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="satuan" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Satuan (Opsional)</label>
                        <input type="text" name="satuan" id="satuan" value="{{ old('satuan', $product->satuan) }}" placeholder="Contoh: PCS, BOX, RIM" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border text-sm font-semibold uppercase">
                        @error('satuan')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div>
                    <label for="deskripsi" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Deskripsi Lengkap Barang (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Tuliskan spesifikasi, warna, atau informasi tambahan barang di sini..." class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border text-sm">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    @error('deskripsi')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Right Side: Harga & Stok -->
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <h3 style="color:#7f1d1d; border-bottom: 2px solid rgba(127,29,29,0.15);" class="text-xs font-black uppercase tracking-widest pb-2 mb-4">💰 Harga &amp; Stok</h3>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="harga_modal" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Harga Modal <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 font-bold text-sm">Rp</span>
                            <input type="number" name="harga_modal" id="harga_modal" value="{{ old('harga_modal', intval($product->harga_modal)) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border text-sm font-bold" style="padding-left: 38px !important;" required>
                        </div>
                        @error('harga_modal')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="harga_jual" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Harga Jual <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 font-bold text-sm">Rp</span>
                            <input type="number" name="harga_jual" id="harga_jual" value="{{ old('harga_jual', intval($product->harga_jual)) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border text-sm font-bold" style="padding-left: 38px !important;" required>
                        </div>
                        @error('harga_jual')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="harga_grosir" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Harga Grosir (Opsional)</label>
                        <div class="relative mb-2">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 font-bold text-sm">Rp</span>
                            <input type="number" name="harga_grosir" id="harga_grosir" value="{{ old('harga_grosir', intval($product->harga_grosir)) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border text-sm font-bold" style="padding-left: 38px !important;">
                        </div>
                        @error('harga_grosir')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror

                        <!-- Quick Percentage Helper -->
                        <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px;" class="p-3">
                            <div class="flex items-center justify-between mb-2">
                                <span style="font-size:0.65rem; font-weight:800; color:#6b7280; text-transform:uppercase; letter-spacing:0.05em;">⚡ Potongan Grosir Otomatis:</span>
                                <span id="grosir_info" style="font-size:0.7rem; font-weight:800; color:#16a34a;"></span>
                            </div>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach(range(1, 10) as $p)
                                <button type="button" onclick="setGrosirPersen({{ $p }}, this)" class="btn-grosir-persen px-2 py-1 text-xs font-bold rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-red-800 hover:text-white hover:border-red-800 transition-all shadow-sm">
                                    {{ $p }}%
                                </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="stok_saat_ini" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Stok Saat Ini <span class="text-red-500">*</span></label>
                        <input type="number" name="stok_saat_ini" id="stok_saat_ini" value="{{ old('stok_saat_ini', $product->stok_saat_ini) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border text-sm font-bold" required>
                        @error('stok_saat_ini')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="stok_minimum" class="block text-xs font-black text-gray-700 uppercase tracking-wider mb-1.5">Stok Minimum <span class="text-red-500">*</span></label>
                        <input type="number" name="stok_minimum" id="stok_minimum" value="{{ old('stok_minimum', $product->stok_minimum) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-red-900 focus:ring focus:ring-red-900 focus:ring-opacity-20 py-2.5 px-3 border text-sm font-bold" required>
                        @error('stok_minimum')<p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Width: Image Upload Zone -->
        <div class="mt-8 pt-6 border-t border-gray-100">
            <h3 style="color:#7f1d1d; border-bottom: 2px solid rgba(127,29,29,0.15);" class="text-xs font-black uppercase tracking-widest pb-2 mb-4">🖼️ Manajemen Gambar Produk</h3>
            
            <!-- Grid Gambar yang Sudah Ada / Baru -->
            <div id="preview-grid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-4 mb-6">
                <!-- Gambar yang sudah ada dimuat secara dinamis via PHP dan dikontrol via JS -->
                @foreach($product->all_images as $index => $img)
                    <div style="border: 2px solid #e5e7eb;" class="relative aspect-square rounded-xl overflow-hidden bg-gray-50 flex items-center justify-center p-1 group shadow-sm existing-img-wrapper">
                        <!-- Gunakan secure /media/ route URL -->
                        <img src="{{ url('media/' . ltrim($img, '/')) }}" class="max-h-full max-w-full object-contain rounded-lg">
                        
                        <span class="absolute bottom-2 left-2 text-[8px] font-black tracking-wider uppercase px-2 py-0.5 rounded-full text-white index-badge {{ $index === 0 ? 'bg-green-600' : 'bg-gray-600' }}">
                            {{ $index === 0 ? 'Utama' : 'Foto ' . ($index + 1) }}
                        </span>
                        
                        <!-- Simpan path asli untuk dikirim ke controller -->
                        <input type="hidden" name="existing_images[]" value="{{ $img }}" class="existing-image-input">
                        
                        <button type="button" class="absolute top-1.5 right-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-lg transition-transform hover:scale-105 cursor-pointer btn-delete-existing">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Upload Drag Zone -->
            <div id="dropzone" style="border: 2px dashed #7f1d1d; background: #fff8f8; transition: all 0.2s; border-radius:14px;" class="p-8 text-center cursor-pointer hover:bg-red-50 flex flex-col items-center justify-center gap-2">
                <span class="text-4xl">📸</span>
                <p class="text-sm font-bold text-gray-700">Tarik &amp; Lepaskan foto baru di sini atau klik untuk memilih file</p>
                <p class="text-xs text-gray-400">Total foto (lama + baru) maksimal 5. JPG, PNG, WEBP (Maks. 4MB per foto)</p>
            </div>
            
            <!-- Input File Asli (Hidden) -->
            <input type="file" name="gambar[]" id="gambar_input" multiple accept="image/png,image/jpeg,image/jpg,image/webp" class="hidden">
            
            @error('gambar')<p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>@enderror
            @error('gambar.*')<p class="text-red-500 text-xs mt-2 font-bold">{{ $message }}</p>@enderror
        </div>

        <!-- Form Actions -->
        <div class="flex flex-col md:flex-row justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
            <a href="{{ route('products.index') }}" class="text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 px-6 rounded-xl text-sm transition-colors">
                Batal
            </a>
            <button type="submit" style="background: linear-gradient(135deg, #7f1d1d, #991b1b); box-shadow: 0 4px 16px rgba(127,29,29,0.35);" class="text-white font-bold py-3 px-8 rounded-xl text-sm transition-all hover:opacity-90">
                Update Barang
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // -------------------------------------------------------------
    // 1. DYNAMIC IMAGE MANAGEMENT SYSTEM
    // -------------------------------------------------------------
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('gambar_input');
    const previewGrid = document.getElementById('preview-grid');
    
    // Array internal untuk file baru yang dipilih
    let newFiles = [];

    // Trigger input file saat dropzone diklik
    dropzone.addEventListener('click', () => fileInput.click());

    // Drag-over styling
    dropzone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropzone.style.background = '#fecaca';
        dropzone.style.borderColor = '#991b1b';
    });

    dropzone.addEventListener('dragleave', () => {
        dropzone.style.background = '#fff8f8';
        dropzone.style.borderColor = '#7f1d1d';
    });

    // Handle files dropped
    dropzone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropzone.style.background = '#fff8f8';
        dropzone.style.borderColor = '#7f1d1d';
        
        if (e.dataTransfer.files.length > 0) {
            handleSelectedFiles(e.dataTransfer.files);
        }
    });

    // Handle files selected via file dialog
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            handleSelectedFiles(fileInput.files);
        }
    });

    // Event listener untuk hapus foto lama yang sudah ada di database
    previewGrid.addEventListener('click', function(e) {
        const btnDelete = e.target.closest('.btn-delete-existing');
        if (btnDelete) {
            const wrapper = btnDelete.closest('.existing-img-wrapper');
            if (wrapper) {
                wrapper.remove();
                refreshAllBadgesAndFileInput();
            }
        }
    });

    function handleSelectedFiles(filesList) {
        const existingCount = previewGrid.querySelectorAll('.existing-img-wrapper').length;
        const totalActive = existingCount + newFiles.length;
        const remainingQuota = 5 - totalActive;

        if (remainingQuota <= 0) {
            alert('Maksimal total foto produk adalah 5.');
            return;
        }

        const validFiles = Array.from(filesList).filter(file => {
            const isValidType = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp'].includes(file.type);
            const isValidSize = file.size <= 4 * 1024 * 1024; // 4MB
            if (!isValidType) alert(`File "${file.name}" tidak didukung. Gunakan format JPG, PNG, atau WEBP.`);
            if (!isValidSize) alert(`File "${file.name}" terlalu besar. Maksimal ukuran file 4MB.`);
            return isValidType && isValidSize;
        });

        const filesToAdd = validFiles.slice(0, remainingQuota);
        newFiles = newFiles.concat(filesToAdd);
        
        renderNewImagesPreview();
        refreshAllBadgesAndFileInput();
    }

    function renderNewImagesPreview() {
        // Hapus semua preview baru lama
        previewGrid.querySelectorAll('.new-img-wrapper').forEach(w => w.remove());

        newFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.style.border = '2px solid #e5e7eb';
                col.className = 'relative aspect-square rounded-xl overflow-hidden bg-gray-50 flex items-center justify-center p-1 group shadow-sm new-img-wrapper';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'max-h-full max-w-full object-contain rounded-lg';
                
                const badge = document.createElement('span');
                badge.className = 'absolute bottom-2 left-2 text-[8px] font-black tracking-wider uppercase px-2 py-0.5 rounded-full text-white index-badge bg-gray-600';
                badge.innerText = 'Memuat...';
                
                const delBtn = document.createElement('button');
                delBtn.type = 'button';
                delBtn.className = 'absolute top-1.5 right-1.5 bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-lg transition-transform hover:scale-105 cursor-pointer';
                delBtn.innerHTML = `
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                `;
                delBtn.onclick = function(e) {
                    e.stopPropagation();
                    newFiles.splice(index, 1);
                    renderNewImagesPreview();
                    refreshAllBadgesAndFileInput();
                };
                
                col.appendChild(img);
                col.appendChild(badge);
                col.appendChild(delBtn);
                previewGrid.appendChild(col);
                
                refreshAllBadgesAndFileInput();
            };
            reader.readAsDataURL(file);
        });
    }

    function refreshAllBadgesAndFileInput() {
        // Sync newFiles array to the hidden original file input
        const dt = new DataTransfer();
        newFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;

        // Loop all previews (existing + new) and update badges sequentially
        const allWrappers = previewGrid.querySelectorAll('.existing-img-wrapper, .new-img-wrapper');
        
        allWrappers.forEach((wrapper, idx) => {
            const badge = wrapper.querySelector('.index-badge');
            if (badge) {
                badge.className = `absolute bottom-2 left-2 text-[8px] font-black tracking-wider uppercase px-2 py-0.5 rounded-full text-white ${idx === 0 ? 'bg-green-600' : 'bg-gray-600'}`;
                badge.innerText = idx === 0 ? 'Utama' : `Foto ${idx + 1}`;
            }
        });
    }
});

// -------------------------------------------------------------
// 2. GROSIR PERCENTAGE AUTOMATIC CALCULATION
// -------------------------------------------------------------
let currentPersenGrosir = 0;

function setGrosirPersen(persen, btnElement) {
    const isDeactivating = (currentPersenGrosir === persen);

    // Reset all buttons
    document.querySelectorAll('.btn-grosir-persen').forEach(b => {
        b.style.backgroundColor = '#ffffff';
        b.style.color = '#374151';
        b.style.borderColor = '#e5e7eb';
    });

    if (isDeactivating) {
        currentPersenGrosir = 0;
    } else {
        currentPersenGrosir = persen;
        // Set active style (marun background, white text)
        btnElement.style.backgroundColor = '#7f1d1d';
        btnElement.style.color = '#ffffff';
        btnElement.style.borderColor = '#7f1d1d';
    }
    
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
            grosirInfo.innerText = `Hemat Rp ${new Intl.NumberFormat('id-ID').format(Math.round(potongan))} (${currentPersenGrosir}%)`;
        }
    } else if (currentPersenGrosir === 0 && grosirInfo) {
        grosirInfo.innerText = '';
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
            document.querySelectorAll('.btn-grosir-persen').forEach(b => {
                b.style.backgroundColor = '#ffffff';
                b.style.color = '#374151';
                b.style.borderColor = '#e5e7eb';
            });
            const grosirInfo = document.getElementById('grosir_info');
            if (grosirInfo) grosirInfo.innerText = '';
        });
    }
});
</script>

<style>
.rounded-b-16 {
    border-radius: 0 0 16px 16px;
}
</style>

@endsection
