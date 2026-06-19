@extends('layouts.admin')
@section('title', 'Laporan Mutasi Stok')
@section('content')

<div class="space-y-6">

    <!-- ==================== HEADER & FILTER ==================== -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-800 tracking-tight flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-tema-marun to-red-800 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    Laporan Mutasi Stok
                </h2>
                <p class="text-sm text-gray-500 mt-1 ml-[52px]">Analisis dan cetak riwayat mutasi masuk dan keluar barang.</p>
            </div>
            
            <form method="GET" action="{{ route('reports.movements') }}" class="flex flex-col md:flex-row gap-3 w-full md:w-auto items-end">
                <div class="w-full md:w-48">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Cari Barang</label>
                    <input type="text" name="search" value="{{ $search }}" placeholder="SKU, Nama, Keterangan..." class="w-full rounded-lg border-2 border-gray-200 text-sm font-semibold text-gray-700 px-3 py-2 focus:ring-tema-marun focus:border-tema-marun bg-gray-50 shadow-sm">
                </div>
                <div class="w-full md:w-48">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Status Invoice</label>
                    <select name="status" class="w-full rounded-lg border-2 border-gray-200 text-sm font-semibold text-gray-700 px-3 py-2.5 focus:ring-tema-marun focus:border-tema-marun bg-gray-50 shadow-sm">
                        <option value="semua" {{ $status == 'semua' ? 'selected' : '' }}>-- Semua Status --</option>
                        <option value="sudah_invoice" {{ $status == 'sudah_invoice' ? 'selected' : '' }}>✅ Sudah Jadi Invoice</option>
                        <option value="belum_invoice" {{ $status == 'belum_invoice' ? 'selected' : '' }}>⏳ Belum Di-Invoice</option>
                        <option value="lainnya" {{ $status == 'lainnya' ? 'selected' : '' }}>🏢 Lainnya (Internal/Kantor)</option>
                        <option value="masuk" {{ $status == 'masuk' ? 'selected' : '' }}>📥 Khusus Barang Masuk</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Mulai Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full sm:w-36 rounded-lg border-2 border-gray-200 text-sm font-semibold text-gray-700 px-3 py-2 focus:ring-tema-marun focus:border-tema-marun bg-gray-50 shadow-sm">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full sm:w-36 rounded-lg border-2 border-gray-200 text-sm font-semibold text-gray-700 px-3 py-2 focus:ring-tema-marun focus:border-tema-marun bg-gray-50 shadow-sm">
                </div>
                <div class="flex items-end gap-2 w-full md:w-auto">
                    <button type="submit" class="bg-tema-hitam hover:bg-black text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all shadow-sm flex items-center justify-center gap-2 hover:scale-105 duration-200 w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    <a href="{{ route('reports.movements.print', ['start_date' => $startDate, 'end_date' => $endDate, 'status' => $status, 'search' => $search]) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 shadow-sm hover:scale-105 duration-200 w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak
                    </a>
                    <a href="{{ route('reports.movements.excel', ['start_date' => $startDate, 'end_date' => $endDate, 'status' => $status, 'search' => $search]) }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center justify-center gap-2 shadow-sm hover:scale-105 duration-200 w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== SUMMARY WIDGET ==================== -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5 shadow-sm transition-all duration-300 hover:shadow-md flex flex-col justify-between">
            <span class="text-xs font-bold text-blue-800 uppercase tracking-wider mb-2">Total Barang Masuk</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-blue-700">{{ $countMasuk }}</span>
                <span class="text-xs text-blue-500 font-semibold">Mutasi</span>
            </div>
        </div>
        <div class="bg-green-50 border border-green-100 rounded-2xl p-5 shadow-sm transition-all duration-300 hover:shadow-md flex flex-col justify-between">
            <span class="text-xs font-bold text-green-800 uppercase tracking-wider mb-2">Keluar: Sudah Invoice</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-green-700">{{ $countSudahInvoice }}</span>
                <span class="text-xs text-green-500 font-semibold">Mutasi</span>
            </div>
        </div>
        <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-5 shadow-sm transition-all duration-300 hover:shadow-md flex flex-col justify-between">
            <span class="text-xs font-bold text-yellow-800 uppercase tracking-wider mb-2">Keluar: Belum Invoice</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-yellow-700">{{ $countBelumInvoice }}</span>
                <span class="text-xs text-yellow-500 font-semibold">Mutasi</span>
            </div>
        </div>
        <div class="bg-gray-50 border border-gray-100 rounded-2xl p-5 shadow-sm transition-all duration-300 hover:shadow-md flex flex-col justify-between">
            <span class="text-xs font-bold text-gray-800 uppercase tracking-wider mb-2">Keluar: Lainnya</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-gray-700">{{ $countLainnya }}</span>
                <span class="text-xs text-gray-500 font-semibold">Mutasi</span>
            </div>
        </div>
    </div>

    <!-- ==================== TABLE DATA MUTASI ==================== -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
            <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                <svg class="w-4 h-4 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                Rincian Pergerakan Barang
            </h3>
            <span class="text-xs font-bold text-white bg-tema-marun px-3 py-1.5 rounded-full shadow-sm">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-tema-hitam text-white">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center w-32">Tanggal</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Nama Barang / SKU</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Tipe</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-right w-24">Jumlah</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Keterangan</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Status Invoice</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($movements as $m)
                        <tr class="hover:bg-amber-50/50 transition-colors">
                            <td class="px-5 py-4 text-center text-gray-600 font-medium whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($m->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-bold text-gray-800 leading-tight">{{ $m->product->nama_barang ?? '-' }}</p>
                                <p class="text-xs text-gray-400 font-bold mt-0.5">SKU: {{ $m->product->sku ?? '-' }}</p>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($m->tipe_pergerakan === 'masuk')
                                    <span class="px-2.5 py-1 inline-flex text-[11px] leading-4 font-bold rounded-full bg-green-50 text-green-700 border border-green-200">
                                        Barang Masuk
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 inline-flex text-[11px] leading-4 font-bold rounded-full bg-red-50 text-red-700 border border-red-200">
                                        Barang Keluar
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right font-black {{ $m->tipe_pergerakan === 'masuk' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $m->tipe_pergerakan === 'masuk' ? '+' : '-' }}{{ $m->jumlah }}
                            </td>
                            <td class="px-5 py-4 text-gray-600">
                                {{ $m->keterangan ?: '-' }}
                            </td>
                            <td class="px-5 py-4 text-center whitespace-nowrap">
                                @if($m->tipe_pergerakan === 'keluar')
                                    @if(strpos($m->keterangan, 'Penjualan Invoice') !== false)
                                        <span class="px-2.5 py-1 inline-flex text-[11px] leading-4 font-black rounded-full bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                            ✓ Sudah Invoice
                                        </span>
                                    @elseif(strpos($m->keterangan, 'Penjualan manual') !== false || strpos($m->keterangan, 'Mutasi Manual') !== false || strpos($m->keterangan, 'TOKO') !== false || strpos($m->keterangan, 'KANTOR') !== false)
                                        @if(strpos($m->keterangan, 'Invoice') !== false || strpos($m->keterangan, 'INVOICE') !== false)
                                            <span class="px-2.5 py-1 inline-flex text-[11px] leading-4 font-black rounded-full bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                                ✓ Sudah Invoice
                                            </span>
                                        @else
                                            <span class="px-2.5 py-1 inline-flex text-[11px] leading-4 font-black rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                                ⏳ Belum Invoice
                                            </span>
                                        @endif
                                    @else
                                        <span class="px-2.5 py-1 inline-flex text-[11px] leading-4 font-black rounded-full bg-gray-100 text-gray-600 border border-gray-200 shadow-sm">
                                            Lainnya
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-300">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 font-medium">
                                Tidak ada mutasi stok ditemukan pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
