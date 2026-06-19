@extends('layouts.admin')
@section('title', 'Laporan Pembelian')
@section('content')
<div class="space-y-6">

    <!-- ==================== HEADER & FILTER ==================== -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-800 tracking-tight flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    Laporan Pembelian
                </h2>
                <p class="text-sm text-gray-500 mt-1 ml-[52px]">Rekap data belanja ke supplier per periode waktu.</p>
            </div>
            
            <form method="GET" action="{{ route('reports.purchases') }}" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Mulai Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full sm:w-44 rounded-lg border-2 border-gray-200 text-sm font-semibold text-gray-700 px-3 py-2.5 focus:ring-tema-marun focus:border-tema-marun bg-gray-50 shadow-sm">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full sm:w-44 rounded-lg border-2 border-gray-200 text-sm font-semibold text-gray-700 px-3 py-2.5 focus:ring-tema-marun focus:border-tema-marun bg-gray-50 shadow-sm">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-tema-hitam hover:bg-black text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all shadow-sm flex items-center gap-2 hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    <a href="{{ route('reports.purchases.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2 shadow-sm hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        PDF
                    </a>
                    <a href="{{ route('reports.purchases.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2 shadow-sm hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== RINGKASAN PEMBELIAN ==================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="bg-gradient-to-br from-blue-600 to-blue-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-blue-200 uppercase tracking-wider">Total Nilai Pembelian</span>
                    <div class="w-9 h-9 bg-white bg-opacity-15 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-white">Rp {{ number_format($totalPembelian, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Faktur Pembelian</span>
                    <div class="w-9 h-9 bg-gray-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-gray-900">{{ $purchases->count() }} <span class="text-lg font-semibold text-gray-400">Faktur</span></h3>
            </div>
        </div>
    </div>

    <!-- ==================== TABEL RINCIAN PEMBELIAN ==================== -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-tema-hitam rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                </div>
                <h3 class="font-bold text-gray-800 text-base">Rincian Faktur Pembelian</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-tema-hitam text-white">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider">No. Faktur</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Supplier</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Total Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($purchases as $p)
                    <tr class="hover:bg-amber-50 transition-colors group">
                        <td class="px-5 py-3.5 whitespace-nowrap text-sm text-gray-600 font-medium">
                            {{ \Carbon\Carbon::parse($p->tanggal_pembelian)->format('d M Y') }}
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="font-bold text-gray-900 text-sm">{{ $p->nomor_faktur }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-gray-700 font-medium">
                            {{ $p->nama_supplier }}
                        </td>
                        <td class="px-5 py-3.5 text-right font-bold text-tema-marun text-sm">
                            Rp {{ number_format($p->total_biaya, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-400">Tidak ada pembelian pada periode ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
