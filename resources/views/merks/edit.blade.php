@extends('layouts.admin')
@section('title', 'Edit Merk')
@section('content')
<div class="bg-white shadow rounded-lg p-6 max-w-2xl mx-auto">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-xl font-semibold text-gray-800">Edit Merk</h2>
    </div>

    <form action="{{ route('merks.update', $merk->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="nama_merk" class="block text-sm font-medium text-gray-700 mb-1">Nama Merk</label>
            <input type="text" name="nama_merk" id="nama_merk" value="{{ old('nama_merk', $merk->nama_merk) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" required>
            @error('nama_merk')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('merks.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md transition-colors">Batal</a>
            <button type="submit" class="bg-tema-kuning hover:bg-yellow-500 text-tema-hitam font-medium py-2 px-4 rounded-md transition-colors shadow-sm">Update</button>
        </div>
    </form>
</div>
@endsection
