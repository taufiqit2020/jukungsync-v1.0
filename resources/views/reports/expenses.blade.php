@extends('layouts.admin')

@section('title', 'Laporan Pengeluaran')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Pengeluaran</h1>
            <p class="text-sm text-gray-500 mt-1">Rekapitulasi pengeluaran kas dan operasional.</p>
        </div>
    </div>

    <!-- Filter & Print Actions -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex flex-col lg:flex-row justify-between items-start lg:items-end gap-4">
        <form action="{{ route('reports.expenses') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4 w-full lg:w-auto">
            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Mulai Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full sm:w-40 border px-3 py-2 bg-gray-50 rounded-lg border-gray-200 focus:bg-white focus:border-tema-marun text-sm">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full sm:w-40 border px-3 py-2 bg-gray-50 rounded-lg border-gray-200 focus:bg-white focus:border-tema-marun text-sm">
            </div>
            <div>
                <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kategori</label>
                <select name="kategori" class="w-full sm:w-48 border px-3 py-2 bg-gray-50 rounded-lg border-gray-200 focus:bg-white focus:border-tema-marun text-sm">
                    <option value="">Semua Kategori</option>
                    <option value="Pembelian Barang" {{ request('kategori') == 'Pembelian Barang' ? 'selected' : '' }}>Pembelian Barang</option>
                    <option value="Listrik" {{ request('kategori') == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                    <option value="Gaji Karyawan" {{ request('kategori') == 'Gaji Karyawan' ? 'selected' : '' }}>Gaji Karyawan</option>
                    <option value="Operasional" {{ request('kategori') == 'Operasional' ? 'selected' : '' }}>Operasional</option>
                    <option value="Lainnya" {{ request('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">Filter</button>
            </div>
        </form>

        <div class="flex gap-2 w-full lg:w-auto">
            <a href="{{ route('reports.expenses.print', ['start_date' => $startDate, 'end_date' => $endDate, 'kategori' => $kategori]) }}" target="_blank" 
               class="flex-1 lg:flex-none inline-flex justify-center items-center px-4 py-2 bg-tema-marun hover:bg-red-800 text-white text-sm font-semibold rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-gradient-to-r from-red-50 to-orange-50 border border-red-100 p-5 rounded-2xl">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-red-800 mb-1">Total Pengeluaran</p>
                    <p class="text-sm text-red-600 font-medium">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
                </div>
                <div class="p-3 bg-red-100/50 rounded-xl">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <p class="text-2xl font-black text-red-700 mt-2">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
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
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($expenses as $idx => $expense)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-center font-medium text-gray-500">{{ $idx + 1 }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-800 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($expense->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded-md border text-[10px] font-bold uppercase bg-gray-100 text-gray-700 border-gray-200">
                                {{ $expense->kategori }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 max-w-xs truncate" title="{{ $expense->keterangan }}">
                            {{ $expense->keterangan }}
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-red-600 whitespace-nowrap">
                            Rp {{ number_format($expense->nominal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-sm font-medium">Belum ada data pengeluaran pada periode ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
