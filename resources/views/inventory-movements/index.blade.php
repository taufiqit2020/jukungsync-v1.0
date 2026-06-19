@extends('layouts.admin')
@section('title', 'Pergerakan Stok')
@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Riwayat Pergerakan Stok</h2>
        <a href="{{ route('inventory-movements.create') }}" class="bg-tema-marun hover:bg-red-900 text-white font-medium py-2 px-4 rounded-md transition-colors shadow-sm flex items-center gap-2 hover:scale-105 duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Catat Pergerakan
        </a>
    </div>

    <!-- SUMMARY WIDGET -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 shadow-sm flex flex-col items-center justify-center">
            <span class="text-sm font-bold text-blue-800 uppercase tracking-wider mb-1 text-center">Masuk</span>
            <span class="text-2xl font-black text-blue-600">{{ $countMasuk }}</span>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 shadow-sm flex flex-col items-center justify-center">
            <span class="text-sm font-bold text-green-800 uppercase tracking-wider mb-1 text-center">Sudah Invoice</span>
            <span class="text-2xl font-black text-green-600">{{ $countSudahInvoice }}</span>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 shadow-sm flex flex-col items-center justify-center">
            <span class="text-sm font-bold text-yellow-800 uppercase tracking-wider mb-1 text-center">Belum Invoice</span>
            <span class="text-2xl font-black text-yellow-600">{{ $countBelumInvoice }}</span>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 shadow-sm flex flex-col items-center justify-center">
            <span class="text-sm font-bold text-gray-800 uppercase tracking-wider mb-1 text-center">Lainnya</span>
            <span class="text-2xl font-black text-gray-600">{{ $countLainnya }}</span>
        </div>
    </div>

    <!-- PENCARIAN & FILTER -->
    <form action="{{ route('inventory-movements.index') }}" method="GET" class="mb-6 flex flex-col md:flex-row gap-3">
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama Barang / SKU / Keterangan..." class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border bg-white text-sm">
            </div>
        </div>
        <div class="w-full md:w-64">
            <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border bg-white text-sm">
                <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>-- Semua Status --</option>
                <option value="sudah_invoice" {{ request('status') == 'sudah_invoice' ? 'selected' : '' }}>✅ Sudah Jadi Invoice</option>
                <option value="belum_invoice" {{ request('status') == 'belum_invoice' ? 'selected' : '' }}>⏳ Belum Di-Invoice</option>
                <option value="lainnya" {{ request('status') == 'lainnya' ? 'selected' : '' }}>🏢 Lainnya (Kantor/Internal)</option>
                <option value="masuk" {{ request('status') == 'masuk' ? 'selected' : '' }}>📥 Khusus Barang Masuk</option>
            </select>
        </div>
        <div class="flex flex-wrap gap-2">
            <button type="submit" class="bg-tema-marun hover:bg-red-900 text-white font-bold py-2 px-4 rounded-md transition-colors shadow-sm text-sm whitespace-nowrap">
                Terapkan
            </button>
            @if(request()->has('search') || request()->has('status'))
                <a href="{{ route('inventory-movements.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-md transition-colors shadow-sm text-sm whitespace-nowrap">
                    Reset
                </a>
            @endif
            <a href="{{ route('reports.movements.print', ['status' => request('status', 'semua'), 'search' => request('search', ''), 'start_date' => '2000-01-01', 'end_date' => '2099-12-31']) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors shadow-sm text-sm whitespace-nowrap flex items-center gap-1.5 hover:scale-105 duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak PDF
            </a>
            <a href="{{ route('reports.movements.excel', ['status' => request('status', 'semua'), 'search' => request('search', ''), 'start_date' => '2000-01-01', 'end_date' => '2099-12-31']) }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md transition-colors shadow-sm text-sm whitespace-nowrap flex items-center gap-1.5 hover:scale-105 duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Ekspor Excel
            </a>
        </div>
    </form>

    <div class="overflow-x-auto rounded-md border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-tema-hitam">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tanggal</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Barang</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Tipe</th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-white uppercase tracking-wider">Jumlah</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Keterangan</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Status Invoice</th>
                    @if(auth()->user()->role === 'superadmin')
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($movements as $movement)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        {{ \Carbon\Carbon::parse($movement->tanggal)->format('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $movement->product->nama_barang ?? '-' }}
                        <div class="text-xs text-gray-500">SKU: {{ $movement->product->sku ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($movement->tipe_pergerakan === 'masuk')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Barang Masuk
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Barang Keluar
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-right {{ $movement->tipe_pergerakan === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $movement->tipe_pergerakan === 'masuk' ? '+' : '-' }}{{ $movement->jumlah }}
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        {{ $movement->keterangan ?: '-' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                        @if($movement->tipe_pergerakan === 'keluar')
                            @if(strpos($movement->keterangan, 'Penjualan Invoice') !== false)
                                <span class="px-2 py-1 inline-flex text-[11px] leading-4 font-bold rounded-full bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                    ✓ Sudah Invoice
                                </span>
                            @elseif(strpos($movement->keterangan, 'Mutasi Manual') !== false)
                                <span class="px-2 py-1 inline-flex text-[11px] leading-4 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                    ⏳ Belum Invoice
                                </span>
                            @else
                                <span class="px-2 py-1 inline-flex text-[11px] leading-4 font-bold rounded-full bg-gray-100 text-gray-600 border border-gray-200 shadow-sm">
                                    Lainnya
                                </span>
                            @endif
                        @else
                            <span class="text-gray-400 font-medium">-</span>
                        @endif
                    </td>
                    @if(auth()->user()->role === 'superadmin')
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                        <a href="{{ route('inventory-movements.edit', $movement->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-md transition-colors mr-2">Edit</a>
                        <form action="{{ route('inventory-movements.destroy', $movement->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pergerakan stok ini? Stok barang akan dikembalikan seperti semula.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md transition-colors">Hapus</button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'superadmin' ? '7' : '6' }}" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada riwayat pergerakan stok.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $movements->links() }}
    </div>
</div>
@endsection
