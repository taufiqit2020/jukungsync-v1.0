@extends('layouts.admin')
@section('title', 'Edit Data Customer')
@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl mx-auto">
    <div class="mb-6 border-b border-gray-200 pb-4">
        <h2 class="text-xl font-semibold text-gray-800">Edit Data Customer</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui detail klien atau instansi yang sudah ada.</p>
    </div>

    <form action="{{ route('customers.update', $customer->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label for="nama_klien" class="block text-sm font-medium text-gray-700 mb-1">Nama Klien / Instansi <span class="text-red-500">*</span></label>
            <input type="text" name="nama_klien" id="nama_klien" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required value="{{ old('nama_klien', $customer->nama_klien) }}">
            @error('nama_klien')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="no_telp" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon / WA</label>
            <input type="text" name="no_telp" id="no_telp" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" value="{{ old('no_telp', $customer->no_telp) }}">
            @error('no_telp')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" value="{{ old('email', $customer->email) }}">
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="npwp" class="block text-sm font-medium text-gray-700 mb-1">NPWP (Nomor Pokok Wajib Pajak)</label>
            <input type="text" name="npwp" id="npwp" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" value="{{ old('npwp', $customer->npwp) }}" placeholder="00.000.000.0-000.000">
            @error('npwp')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="tipe_customer" class="block text-sm font-medium text-gray-700 mb-1">Tipe Customer <span class="text-red-500">*</span></label>
            <select name="tipe_customer" id="tipe_customer" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border bg-white" required>
                <option value="Perorangan" {{ old('tipe_customer', $customer->tipe_customer) === 'Perorangan' ? 'selected' : '' }}>Perorangan</option>
                <option value="Instansi" {{ old('tipe_customer', $customer->tipe_customer) === 'Instansi' ? 'selected' : '' }}>Instansi</option>
            </select>
            @error('tipe_customer')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border">{{ old('alamat', $customer->alamat) }}</textarea>
            @error('alamat')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan Tambahan</label>
            <textarea name="keterangan" id="keterangan" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border">{{ old('keterangan', $customer->keterangan) }}</textarea>
            @error('keterangan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('customers.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors shadow-sm">
                Batal
            </a>
            <button type="submit" class="bg-tema-kuning hover:bg-yellow-500 text-tema-hitam font-medium py-2 px-6 rounded-md transition-colors shadow-sm flex items-center gap-2">
                Perbarui
            </button>
        </div>
    </form>
</div>
@endsection
