@extends('layouts.admin')
@section('title', 'Kartu Stok')
@section('content')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    /* Styling custom untuk Select2 agar cocok dengan tema Tailwind */
    .select2-container .select2-selection--single {
        height: 42px;
        border: 2px solid #e5e7eb;
        border-radius: 0.5rem;
        background-color: #f9fafb;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 40px;
        color: #374151;
        font-weight: 600;
        font-size: 0.875rem;
        padding-left: 12px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 40px;
    }
    .select2-container--default.select2-container--focus .select2-selection--single {
        border-color: #7f1d1d;
    }
</style>

<div class="space-y-6">

    <!-- ==================== HEADER & FILTER ==================== -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-800 tracking-tight flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-tema-marun to-red-800 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    Kartu Stok
                </h2>
                <p class="text-sm text-gray-500 mt-1 ml-[52px]">Pantau riwayat mutasi masuk dan keluar per barang.</p>
            </div>
            
            <form method="GET" action="{{ route('reports.stock') }}" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto items-end">
                <div class="w-full sm:w-64">
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Pilih Produk</label>
                    <select name="product_id" id="productSelect" class="w-full rounded-lg border-2 border-gray-200 text-sm font-semibold text-gray-700 px-3 py-2.5 focus:ring-tema-marun focus:border-tema-marun bg-gray-50 shadow-sm" required>
                        <option value="">-- Pilih Barang --</option>
                        <option value="all" {{ request('product_id') == 'all' ? 'selected' : '' }}>-- SEMUA PRODUK (Rekapitulasi) --</option>
                        @foreach($products as $p)
                            <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_barang }} ({{ $p->sku }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Mulai Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full sm:w-36 rounded-lg border-2 border-gray-200 text-sm font-semibold text-gray-700 px-3 py-2.5 focus:ring-tema-marun focus:border-tema-marun bg-gray-50 shadow-sm">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full sm:w-36 rounded-lg border-2 border-gray-200 text-sm font-semibold text-gray-700 px-3 py-2.5 focus:ring-tema-marun focus:border-tema-marun bg-gray-50 shadow-sm">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="bg-tema-hitam hover:bg-black text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all shadow-sm flex items-center gap-2 hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        Filter
                    </button>
                    @if(request('product_id'))
                    <a href="{{ route('reports.stock.print', ['product_id' => request('product_id'), 'start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2 shadow-sm hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                        PDF
                    </a>
                    <a href="{{ route('reports.stock.excel', ['product_id' => request('product_id'), 'start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg text-sm font-bold transition-all flex items-center gap-2 shadow-sm hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Excel
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if($selectedProduct)
    <!-- ==================== TABEL KARTU STOK ==================== -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-tema-hitam rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-tema-kuning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-base">{{ $selectedProduct->nama_barang }}</h3>
                    <p class="text-xs text-gray-500 font-semibold">{{ $selectedProduct->sku }}</p>
                </div>
            </div>
            <span class="text-xs font-bold text-white bg-tema-marun px-3 py-1.5 rounded-full shadow-sm">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-tema-hitam text-white">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center w-32">Tanggal</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Keterangan / Ref</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Masuk</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Keluar</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Saldo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="bg-gray-50">
                        <td class="px-5 py-3.5 text-center text-gray-500">-</td>
                        <td class="px-5 py-3.5 font-bold text-gray-700">SALDO AWAL</td>
                        <td class="px-5 py-3.5 text-center text-gray-500">-</td>
                        <td class="px-5 py-3.5 text-center text-gray-500">-</td>
                        <td class="px-5 py-3.5 text-center font-black text-gray-900 bg-yellow-50">{{ $saldoAwal }}</td>
                    </tr>
                    
                    @php $currentSaldo = $saldoAwal; @endphp
                    @forelse($movements as $m)
                        @php
                            if($m->tipe_pergerakan === 'masuk') {
                                $currentSaldo += $m->jumlah;
                            } else {
                                $currentSaldo -= $m->jumlah;
                            }
                        @endphp
                        <tr class="hover:bg-amber-50 transition-colors">
                            <td class="px-5 py-3.5 text-center text-gray-600 font-medium">
                                {{ \Carbon\Carbon::parse($m->tanggal)->format('d/m/Y') }}
                            </td>
                            <td class="px-5 py-3.5 font-medium text-gray-800">
                                {{ $m->keterangan }}
                            </td>
                            <td class="px-5 py-3.5 text-center font-bold text-green-600">
                                {{ $m->tipe_pergerakan === 'masuk' ? $m->jumlah : '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-center font-bold text-red-600">
                                {{ $m->tipe_pergerakan === 'keluar' ? $m->jumlah : '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-center font-black text-gray-900 bg-yellow-50/50">
                                {{ $currentSaldo }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-medium">
                                Tidak ada mutasi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-gray-100 border-t border-gray-200">
                    <tr>
                        <td colspan="4" class="px-5 py-3.5 text-right text-sm font-black text-gray-700 uppercase tracking-wider">SALDO AKHIR ({{ \Carbon\Carbon::parse($endDate)->format('d M Y') }})</td>
                        <td class="px-5 py-3.5 text-center font-black text-tema-marun text-lg bg-yellow-100">{{ $currentSaldo }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @elseif(isset($allProductsSummary) && request('product_id') === 'all')
    <!-- ==================== TABEL REKAPITULASI SEMUA PRODUK ==================== -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-tema-hitam rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-tema-kuning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-gray-800 text-base">Rekapitulasi Semua Produk</h3>
                    <p class="text-xs text-gray-500 font-semibold">Total: {{ $allProductsSummary->count() }} Barang</p>
                </div>
            </div>
            <span class="text-xs font-bold text-white bg-tema-marun px-3 py-1.5 rounded-full shadow-sm">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-tema-hitam text-white">
                    <tr>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider">Nama Barang / SKU</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Saldo Awal</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Mutasi Masuk</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center">Mutasi Keluar</th>
                        <th class="px-5 py-3.5 text-xs font-bold uppercase tracking-wider text-center bg-tema-marun/20">Saldo Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($allProductsSummary as $summary)
                        <tr class="hover:bg-amber-50 transition-colors">
                            <td class="px-5 py-3.5">
                                <p class="font-bold text-gray-800">{{ $summary->product->nama_barang }}</p>
                                <p class="text-xs text-gray-500 font-semibold">{{ $summary->product->sku }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-center font-bold text-gray-600 bg-gray-50/50">
                                {{ $summary->saldo_awal }}
                            </td>
                            <td class="px-5 py-3.5 text-center font-bold text-green-600">
                                {{ $summary->masuk }}
                            </td>
                            <td class="px-5 py-3.5 text-center font-bold text-red-600">
                                {{ $summary->keluar }}
                            </td>
                            <td class="px-5 py-3.5 text-center font-black text-gray-900 bg-yellow-50/50">
                                {{ $summary->saldo_akhir }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500 font-medium">
                                Belum ada data produk tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-12 flex flex-col items-center justify-center text-center">
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Pilih Produk</h3>
        <p class="text-gray-500 max-w-sm">Silakan pilih produk pada filter di atas untuk melihat riwayat kartu stoknya secara detail.</p>
    </div>
    @endif
</div>

<!-- jQuery (dibutuhkan oleh Select2) & Select2 JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#productSelect').select2({
            placeholder: "-- Pilih Barang --",
            allowClear: false,
            width: '100%' // Agar responsive dengan Tailwind
        });
    });
</script>
@endsection
