@extends('layouts.admin')
@section('title', 'Edit Pergerakan Stok')
@section('content')
<style>
    .ts-wrapper .ts-control {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        padding: 8px 12px !important;
        font-size: 14px !important;
        background: #fff !important;
        min-height: 42px !important;
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
    }
    .ts-wrapper .ts-dropdown .option {
        padding: 8px 10px !important;
        font-size: 13.5px !important;
    }
</style>

<div class="bg-white shadow rounded-lg p-6 max-w-3xl mx-auto">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-semibold text-gray-800">Edit Pergerakan Stok</h2>
        <p class="text-sm text-gray-500 mt-1">Ubah data pergerakan stok. Sistem akan otomatis menyesuaikan kembali stok barang terkait.</p>
    </div>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <form action="{{ route('inventory-movements.update', $inventoryMovement->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="tipe_pergerakan" class="block text-sm font-medium text-gray-700 mb-1">Tipe Pergerakan</label>
                <select name="tipe_pergerakan" id="tipe_pergerakan" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2.5 px-3 border bg-white" required>
                    <option value="masuk" {{ old('tipe_pergerakan', $inventoryMovement->tipe_pergerakan) == 'masuk' ? 'selected' : '' }}>Barang Masuk (+)</option>
                    <option value="keluar" {{ old('tipe_pergerakan', $inventoryMovement->tipe_pergerakan) == 'keluar' ? 'selected' : '' }}>Barang Keluar (-)</option>
                </select>
                @error('tipe_pergerakan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', \Carbon\Carbon::parse($inventoryMovement->tanggal)->format('Y-m-d')) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
                @error('tanggal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="mb-4">
            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Barang</label>
            <select name="product_id" id="product_id" class="w-full bg-white" required>
                <option value="">-- Pilih Barang --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id', $inventoryMovement->product_id) == $product->id ? 'selected' : '' }}>
                        [{{ $product->sku }}] {{ $product->nama_barang }} (Stok saat ini: {{ $product->stok_saat_ini }})
                    </option>
                @endforeach
            </select>
            @error('product_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah', $inventoryMovement->jumlah) }}" min="1" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
            @error('jumlah')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
            <textarea name="keterangan" id="keterangan" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border">{{ old('keterangan', $inventoryMovement->keterangan) }}</textarea>
            @error('keterangan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex justify-end gap-3 border-t pt-4">
            <a href="{{ session('inventory_movements_url', route('inventory-movements.index')) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">Batal</a>
            <button type="submit" class="bg-tema-marun hover:bg-red-900 text-white font-medium py-2 px-4 rounded-md transition-colors shadow-sm">Simpan Perubahan</button>
        </div>
    </form>
</div>

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect("#product_id", {
            create: false,
            dropdownParent: 'body',
            sortField: { field: "text", direction: "asc" }
        });
    });
</script>
@endsection
