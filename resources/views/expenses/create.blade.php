@extends('layouts.admin')

@section('title', 'Tambah Pengeluaran')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('expenses.index') }}" class="p-2 bg-white text-gray-500 hover:text-gray-900 rounded-xl shadow-sm border border-gray-200 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Pengeluaran</h1>
            <p class="text-sm text-gray-500">Catat pengeluaran baru perusahaan.</p>
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

    <form action="{{ route('expenses.store') }}" method="POST" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pengeluaran</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required
                    class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                <select name="kategori" required class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20">
                    <option value="" disabled selected>-- Pilih Kategori --</option>
                    <option value="Pembelian Barang" {{ old('kategori') == 'Pembelian Barang' ? 'selected' : '' }}>Pembelian Barang (Faktur Masuk)</option>
                    <option value="Listrik" {{ old('kategori') == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                    <option value="Gaji Karyawan" {{ old('kategori') == 'Gaji Karyawan' ? 'selected' : '' }}>Gaji Karyawan</option>
                    <option value="Operasional" {{ old('kategori') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                    <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Nominal (Rp)</label>
            <input type="number" name="nominal" value="{{ old('nominal') }}" required min="0" step="1" placeholder="Misal: 500000"
                class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20">
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Keterangan / Rincian</label>
            <textarea name="keterangan" rows="3" required placeholder="Tuliskan keterangan detail pengeluaran..."
                class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20">{{ old('keterangan') }}</textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ route('expenses.index') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl transition-colors">Batal</a>
            <button type="submit" class="px-6 py-3 bg-tema-marun hover:bg-red-800 text-white font-bold rounded-xl shadow-sm transition-colors flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Data
            </button>
        </div>
    </form>
</div>
@endsection
