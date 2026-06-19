@extends('layouts.admin')
@section('title', 'Laporan E-Catalog')
@section('content')
<div class="space-y-6">

    <!-- ==================== HEADER & FILTER ==================== -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-800 tracking-tight flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-tema-marun to-red-800 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                    Laporan Pesanan E-Catalog
                </h2>
                <p class="text-sm text-gray-500 mt-1 ml-[52px]">Pantau performa penjualan dari pesanan E-Catalog.</p>
            </div>
            
            <form method="GET" action="{{ route('reports.online-orders') }}" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
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
                    <a href="{{ route('reports.online-orders.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2 shadow-sm hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        Cetak PDF
                    </a>
                    <a href="{{ route('reports.online-orders.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2 shadow-sm hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== RINGKASAN KEUANGAN ==================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        
        <!-- 1. Total Pendapatan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Pendapatan</span>
                    <div class="w-9 h-9 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <div class="mt-3 flex items-center gap-2">
                        Total Pendapatan dari Pesanan Selesai
                    </span>
                </div>
            </div>
            <div class="h-1.5 bg-gradient-to-r from-blue-400 to-blue-600"></div>
        </div>

        <!-- 2. Total Modal (HPP) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Modal (HPP)</span>
                    <div class="w-9 h-9 bg-orange-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($totalModal, 0, ',', '.') }}</h3>
                <div class="mt-3">
                    <span class="text-xs font-semibold text-gray-400">Nilai modal barang terjual</span>
                </div>
            </div>
            <div class="h-1.5 bg-gradient-to-r from-orange-400 to-orange-600"></div>
        </div>

        <!-- 3. Laba Kotor (HIGHLIGHT) -->
        <div class="bg-gradient-to-br from-tema-marun via-red-800 to-red-900 rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-red-200 uppercase tracking-wider">Laba Kotor</span>
                    <div class="w-9 h-9 bg-white bg-opacity-15 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-tema-kuning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                </div>
                <h3 class="text-3xl font-black text-white">Rp {{ number_format($labaKotor, 0, ',', '.') }}</h3>
                <div class="mt-3 flex items-center gap-2">
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-tema-kuning bg-white bg-opacity-10 px-2.5 py-1 rounded-full">
                        Pendapatan − Modal
                    </span>
                </div>
            </div>
            <div class="h-1.5 bg-gradient-to-r from-tema-kuning to-yellow-500"></div>
        </div>

        <!-- 4. Total Transaksi -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-300">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Invoice</span>
                    <div class="w-9 h-9 bg-purple-100 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-gray-900">{{ $totalTransaksi }} <span class="text-base font-semibold text-gray-400">Transaksi</span></h3>
                <div class="mt-3">
                    <span class="text-xs font-semibold text-gray-400">Dalam periode terpilih</span>
                </div>
            </div>
            <div class="h-1.5 bg-gradient-to-r from-purple-400 to-purple-600"></div>
        </div>
    </div>

    <!-- ==================== TABEL RINCIAN & TOP PRODUCTS ==================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Tabel Rincian Invoice (2/3 width) -->
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-tema-hitam rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-tema-kuning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-800 text-base">Rincian Invoice</h3>
                </div>
                <span class="text-xs font-bold text-white bg-tema-marun px-3 py-1.5 rounded-full shadow-sm">{{ $orders->count() }} Data</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-tema-hitam text-white">
                        <tr>
                            <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Tanggal</th>
                            <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider">No. Pesanan</th>
                            <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Klien</th>
                            <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Status</th>
                            <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Pendapatan</th>
                            <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Modal</th>
                            <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-right">Laba</th>
                            @if(auth()->user()->role === 'superadmin')
                            <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($orders as $inv)
                        @php
                            $modalInv = 0;
                            foreach($inv->invoiceItems as $item) {
                                $modalInv += ($item->harga_modal_snapshot * $item->jumlah);
                            }
                            $labaInv = $inv->sub_total - $modalInv;
                        @endphp
                        <tr class="hover:bg-amber-50 transition-colors group">
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($inv->tanggal_invoice)->format('d M Y') }}
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-gray-900 text-sm">{{ $inv->nomor_invoice }}</span>
                            </td>
                            <td class="px-5 py-3.5 text-gray-700 truncate max-w-[180px] font-medium" title="{{ $inv->nama_klien }}">
                                {{ $inv->nama_klien }}
                            </td>
                            <td class="px-5 py-3.5 text-center">
                                @php
                                    $statusColors = [
                                        'menunggu_konfirmasi' => 'bg-yellow-100 text-yellow-800',
                                        'diproses' => 'bg-blue-100 text-blue-800',
                                        'selesai' => 'bg-green-100 text-green-800',
                                        'dibatalkan' => 'bg-red-100 text-red-800',
                                    ];
                                    $sColor = $statusColors[$inv->status_pesanan] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $sColor }}">
                                    {{ str_replace('_', ' ', $inv->status_pesanan) }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right font-bold text-gray-900 text-sm">
                                Rp {{ number_format($inv->sub_total, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-right text-gray-500 font-medium text-sm">
                                Rp {{ number_format($modalInv, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $labaInv >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $labaInv >= 0 ? '+' : '' }}Rp {{ number_format($labaInv, 0, ',', '.') }}
                                </span>
                            </td>
                            @if(auth()->user()->role === 'superadmin')
                            <td class="px-5 py-3.5 text-center whitespace-nowrap">
                                <a href="{{ route('invoices.edit', $inv->id) }}?from=reports" class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-800 hover:bg-blue-200 rounded text-xs font-bold transition-colors shadow-sm mr-1" title="Edit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('invoices.destroy', $inv->id) }}?from=reports" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-100 text-red-800 hover:bg-red-200 rounded text-xs font-bold transition-colors shadow-sm" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'superadmin' ? 8 : 7 }}" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-400">Tidak ada transaksi pada periode ini.</p>
                                    <p class="text-xs text-gray-300 mt-1">Coba ubah filter tanggal di atas.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($orders->count() > 0)
                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                        <tr>
                            <td colspan="4" class="px-5 py-3.5 text-sm font-black text-gray-700 uppercase tracking-wider">TOTAL (Pesanan Selesai)</td>
                            <td class="px-5 py-3.5 text-right font-black text-gray-900 text-sm">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-right font-bold text-gray-500 text-sm">Rp {{ number_format($totalModal, 0, ',', '.') }}</td>
                            <td class="px-5 py-3.5 text-right">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-black {{ $labaKotor >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $labaKotor >= 0 ? '+' : '' }}Rp {{ number_format($labaKotor, 0, ',', '.') }}
                                </span>
                            </td>
                            @if(auth()->user()->role === 'superadmin')
                            <td></td>
                            @endif
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <!-- Barang Terlaris (1/3 width) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex items-center gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-tema-kuning to-yellow-500 rounded-lg flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4 text-tema-hitam" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                </div>
                <h3 class="font-bold text-gray-800 text-base">Barang Terlaris</h3>
            </div>
            <div class="p-5 flex-1">
                @if($topProducts->count() > 0)
                    <div class="space-y-3">
                        @foreach($topProducts as $idx => $tp)
                        @php
                            $rankColors = [
                                0 => 'bg-gradient-to-r from-yellow-400 to-yellow-500 text-tema-hitam',
                                1 => 'bg-gradient-to-r from-gray-300 to-gray-400 text-gray-800',
                                2 => 'bg-gradient-to-r from-amber-600 to-amber-700 text-white',
                            ];
                            $rankClass = $rankColors[$idx] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-amber-50 hover:border-amber-200 transition-all duration-200">
                            <div class="w-9 h-9 rounded-xl {{ $rankClass }} flex items-center justify-center font-black text-sm flex-shrink-0 shadow-sm">
                                {{ $idx + 1 }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-900 truncate" title="{{ $tp->product->nama_barang ?? 'Deleted Product' }}">
                                    {{ $tp->product->nama_barang ?? 'Deleted Product' }}
                                </h4>
                                <p class="text-[11px] text-gray-500 font-semibold mt-0.5">
                                    <span class="inline-flex items-center bg-tema-marun text-white px-1.5 py-0.5 rounded text-[10px] font-bold">{{ $tp->product->sku ?? '-' }}</span>
                                </p>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-black bg-green-100 text-green-700">
                                    {{ $tp->total_qty }} Terjual
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="h-full flex flex-col items-center justify-center text-gray-400 py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-400">Belum ada data barang.</p>
                        <p class="text-xs text-gray-300 mt-1">Data muncul saat ada transaksi.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
