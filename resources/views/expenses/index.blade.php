@extends('layouts.admin')

@section('title', 'Data Pengeluaran')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Data Pengeluaran</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola pencatatan pengeluaran operasional dan pembayaran.</p>
        </div>
        <a href="{{ route('expenses.create') }}" class="inline-flex items-center justify-center px-4 py-2.5 bg-tema-marun hover:bg-red-800 text-white text-sm font-semibold rounded-xl shadow-sm transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Pengeluaran
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
    <div class="bg-green-50 text-green-700 p-4 rounded-xl flex items-center shadow-sm border border-green-100">
        <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        {{ session('success') }}
    </div>
    @endif

    <!-- Filter & Summary -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
        <form action="{{ route('expenses.index') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="w-full sm:w-1/4">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ request('dari') }}" class="w-full border px-3 py-2 bg-gray-50 rounded-lg border-gray-200 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20 text-sm">
            </div>
            <div class="w-full sm:w-1/4">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="w-full border px-3 py-2 bg-gray-50 rounded-lg border-gray-200 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20 text-sm">
            </div>
            <div class="w-full sm:w-1/4">
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kategori</label>
                <select name="kategori" class="w-full border px-3 py-2 bg-gray-50 rounded-lg border-gray-200 focus:bg-white focus:border-tema-marun focus:ring-2 focus:ring-tema-marun/20 text-sm">
                    <option value="">Semua Kategori</option>
                    <option value="Pembelian Barang" {{ request('kategori') == 'Pembelian Barang' ? 'selected' : '' }}>Pembelian Barang</option>
                    <option value="Listrik" {{ request('kategori') == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                    <option value="Gaji Karyawan" {{ request('kategori') == 'Gaji Karyawan' ? 'selected' : '' }}>Gaji Karyawan</option>
                    <option value="Operasional" {{ request('kategori') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                    <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="flex gap-2 w-full sm:w-1/4">
                <button type="submit" class="flex-1 bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">Filter</button>
                <a href="{{ route('expenses.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">Reset</a>
            </div>
        </form>
    </div>

    <!-- Total Pengeluaran (Tampil Sesuai Filter) -->
    <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-100 p-5 rounded-2xl flex justify-between items-center">
        <div>
            <h3 class="text-sm font-bold text-red-800 uppercase tracking-wide">Total Pengeluaran (Berdasarkan Filter)</h3>
        </div>
        <div class="text-2xl font-black text-red-700">
            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase font-bold text-gray-400 tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-12 text-center">No</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-right">Nominal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($expenses as $idx => $expense)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-center font-medium text-gray-500">
                            {{ $expenses->firstItem() + $idx }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-800 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($expense->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-md border text-[11px] font-bold uppercase bg-gray-100 text-gray-700 border-gray-200">
                                {{ $expense->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $expense->keterangan }}
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-red-600 whitespace-nowrap">
                            Rp {{ number_format($expense->nominal, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('expenses.edit', $expense) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pengeluaran ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4M8 16l-4-4 4-4m8 8l4-4-4-4"></path></svg>
                            <p class="text-sm font-medium">Belum ada data pengeluaran.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $expenses->links() }}
        </div>
    </div>
</div>
@endsection
