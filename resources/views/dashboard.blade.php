@extends('layouts.admin')
@section('title', 'Dashboard Utama')
@section('content')

<!-- Welcome Banner -->
<div class="relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-r from-tema-hitam via-gray-900 to-tema-hitam p-8 shadow-xl">
    <div class="absolute top-0 right-0 w-80 h-80 bg-tema-kuning/10 rounded-full -mr-20 -mt-20 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-tema-marun/10 rounded-full -ml-16 -mb-16 blur-3xl"></div>
    <div class="relative z-10">
        <h1 class="font-heading text-3xl font-extrabold text-white mb-2">Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}! 👋</h1>
        <p class="text-gray-400 text-sm max-w-xl">Pantau ringkasan performa bisnis PT. Utama Madani Raya secara real-time. Data di bawah ini diperbarui otomatis setiap kali ada transaksi baru.</p>
    </div>
</div>

<!-- Kartu Metrik Utama -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    
    <!-- Total Barang -->
    <div class="group bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md hover:border-gray-200 transition-all duration-300 flex items-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gray-50 rounded-full -mr-8 -mt-8 group-hover:bg-gray-100 transition-colors"></div>
        <div class="p-3.5 rounded-xl bg-gradient-to-br from-tema-hitam to-gray-800 text-white mr-5 shadow-lg shadow-gray-200/50 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Total Macam Barang</p>
            <p class="text-3xl font-extrabold text-tema-hitam">{{ $totalProducts }} <span class="text-base font-medium text-gray-400">SKU</span></p>
        </div>
    </div>

    <!-- Total Pendapatan Bulan Ini -->
    <div class="group bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md hover:border-yellow-100 transition-all duration-300 flex items-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-50/50 rounded-full -mr-8 -mt-8 group-hover:bg-yellow-50 transition-colors"></div>
        <div class="p-3.5 rounded-xl bg-gradient-to-br from-tema-kuning to-yellow-500 text-tema-hitam mr-5 shadow-lg shadow-yellow-200/50 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Omzet Bulan Ini</p>
            <p class="text-3xl font-extrabold text-tema-hitam">Rp {{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Total Transaksi Bulan Ini -->
    <div class="group bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md hover:border-red-100 transition-all duration-300 flex items-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-red-50/50 rounded-full -mr-8 -mt-8 group-hover:bg-red-50 transition-colors"></div>
        <div class="p-3.5 rounded-xl bg-gradient-to-br from-tema-marun to-red-800 text-white mr-5 shadow-lg shadow-red-200/50 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Invoice Bulan Ini</p>
            <p class="text-3xl font-extrabold text-tema-hitam">{{ $totalInvoicesThisMonth }} <span class="text-base font-medium text-gray-400">Transaksi</span></p>
        </div>
    </div>
</div>

<!-- FR-06: Secondary Alert Widgets Row -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Widget Stok Menipis -->
    <div class="group bg-white rounded-xl p-6 shadow-sm border border-amber-100 hover:shadow-md hover:border-amber-200 transition-all duration-300 flex items-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-amber-50/50 rounded-full -mr-8 -mt-8 group-hover:bg-amber-50 transition-colors"></div>
        <div class="p-3.5 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 text-white mr-5 shadow-lg shadow-amber-200/50 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Stok Menipis (&le; Min)</p>
            <p class="text-3xl font-extrabold text-amber-600">{{ $stokMenipis->count() }} <span class="text-base font-medium text-gray-400">Barang</span></p>
        </div>
    </div>

    <!-- Widget Mutasi Belum Invoice -->
    <div class="group bg-white rounded-xl p-6 shadow-sm border border-yellow-100 hover:shadow-md hover:border-yellow-200 transition-all duration-300 flex items-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-yellow-50/50 rounded-full -mr-8 -mt-8 group-hover:bg-yellow-50 transition-colors"></div>
        <div class="p-3.5 rounded-xl bg-gradient-to-br from-yellow-400 to-yellow-600 text-white mr-5 shadow-lg shadow-yellow-200/50 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Mutasi Belum Invoice</p>
            <p class="text-3xl font-extrabold text-yellow-600">{{ $mutasiPendingCount }} <span class="text-base font-medium text-gray-400">Entri</span></p>
        </div>
    </div>

    <!-- Widget Invoice Jatuh Tempo 7 Hari -->
    <div class="group bg-white rounded-xl p-6 shadow-sm border border-red-100 hover:shadow-md hover:border-red-200 transition-all duration-300 flex items-center relative overflow-hidden">
        <div class="absolute top-0 right-0 w-24 h-24 bg-red-50/50 rounded-full -mr-8 -mt-8 group-hover:bg-red-50 transition-colors"></div>
        <div class="p-3.5 rounded-xl bg-gradient-to-br from-red-500 to-red-700 text-white mr-5 shadow-lg shadow-red-200/50 group-hover:scale-110 transition-transform duration-300">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Jatuh Tempo &le; 7 Hari</p>
            <p class="text-3xl font-extrabold text-red-600">{{ $invoiceJatuhTempo->count() }} <span class="text-base font-medium text-gray-400">Invoice</span></p>
        </div>
    </div>
</div>

<!-- FR-06: Stok Perlu Diperhatikan Table -->
@if($stokMenipis->count() > 0)
<div class="bg-white rounded-xl shadow-sm border border-amber-100 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-amber-100 flex items-center gap-2.5 bg-gradient-to-r from-amber-50 to-white">
        <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
        </div>
        <h3 class="font-heading text-base font-bold text-gray-800">⚠️ Stok Perlu Diperhatikan</h3>
        <span class="ml-auto text-[11px] font-bold bg-amber-100 text-amber-700 px-2.5 py-1 rounded-full uppercase tracking-wider">&le; Limit Stok</span>
    </div>
    <table class="min-w-full">
        <thead>
            <tr class="bg-gray-50/80">
                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">SKU</th>
                <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Nama Barang</th>
                <th class="px-6 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider w-20">Limit</th>
                <th class="px-6 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider w-24">Sisa Stok</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50">
            @foreach($stokMenipis as $item)
            <tr class="hover:bg-amber-50/30 transition-colors">
                <td class="px-6 py-3.5">
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-tema-marun/10 text-tema-marun font-mono">{{ $item->sku }}</span>
                </td>
                <td class="px-6 py-3.5">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full {{ $item->stok_saat_ini == 0 ? 'bg-red-600 animate-pulse' : ($item->stok_saat_ini <= ($item->stok_minimum / 2) ? 'bg-red-500 animate-pulse' : 'bg-amber-500') }}"></div>
                        <span class="text-sm font-medium text-gray-900">{{ $item->nama_barang }}</span>
                    </div>
                </td>
                <td class="px-6 py-3.5 text-center text-sm font-medium text-gray-500">
                    {{ $item->stok_minimum ?? 5 }}
                </td>
                <td class="px-6 py-3.5 text-right">
                    <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2.5 py-1 text-sm font-bold rounded-full {{ $item->stok_saat_ini == 0 ? 'bg-red-100 text-red-700' : ($item->stok_saat_ini <= ($item->stok_minimum / 2) ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                        {{ $item->stok_saat_ini }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-3 bg-gray-50/50 border-t text-right">
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm text-amber-600 hover:text-amber-700 font-semibold transition-colors gap-1">
            Kelola Stok Barang
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>
</div>
@endif

<!-- Chart & Top Products Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Chart Penjualan & Perbandingan Bulanan -->
    <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="md:col-span-2">
            <h3 class="font-heading text-base font-bold text-gray-800 mb-4">Grafik Penjualan (7 Hari Terakhir)</h3>
            <div id="salesChart" class="w-full h-72"></div>
        </div>
        <div class="border-t md:border-t-0 md:border-l border-gray-100 pt-6 md:pt-0 md:pl-6 flex flex-col justify-between">
            <div>
                <h3 class="font-heading text-base font-bold text-gray-800 mb-2">Perbandingan Omzet</h3>
                <p class="text-xs text-gray-400 mb-4 font-medium">Omzet bulan ini vs bulan lalu.</p>
            </div>
            
            <div id="monthlyComparisonChart" class="w-full h-44"></div>
            
            <div class="mt-4 pt-4 border-t border-gray-50 flex items-center justify-between text-xs">
                <div>
                    <span class="block text-gray-400 font-medium">Bulan Lalu</span>
                    <span class="font-bold text-gray-700">Rp {{ number_format($omzetBulanLalu, 0, ',', '.') }}</span>
                </div>
                <div>
                    <span class="block text-gray-400 font-medium">Bulan Ini</span>
                    <span class="font-bold text-tema-marun">Rp {{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Right column: Top Produk + Top Customer stacked -->
    <div class="flex flex-col gap-6">
        <!-- Top Produk Terlaris -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2.5 bg-gradient-to-r from-yellow-50 to-white">
                <div class="w-8 h-8 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="font-heading text-base font-bold text-gray-800">5 Produk Terlaris</h3>
            </div>
            <div class="flex-1 overflow-y-auto">
                @forelse($topProducts as $index => $product)
                <div class="px-6 py-4 flex items-center gap-4 border-b border-gray-50 last:border-0 hover:bg-gray-50/50 transition-colors">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold {{ $index == 0 ? 'bg-yellow-400 text-white shadow-md shadow-yellow-200' : ($index == 1 ? 'bg-gray-300 text-white' : ($index == 2 ? 'bg-amber-600 text-white' : 'bg-gray-100 text-gray-500')) }}">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $product->nama_barang }}</p>
                        <p class="text-xs text-gray-400 font-mono">{{ $product->sku }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-700">
                            {{ $product->total_terjual }} Terjual
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center text-gray-500 text-sm">Belum ada data penjualan.</div>
                @endforelse
            </div>
        </div>

        <!-- FR-06: Top 3 Customer Bulan Ini -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2.5 bg-gradient-to-r from-blue-50 to-white">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <h3 class="font-heading text-base font-bold text-gray-800">🏆 Top 3 Customer Bulan Ini</h3>
            </div>
            <div class="flex-1">
                @forelse($topCustomers as $index => $cust)
                <div class="px-6 py-3.5 flex items-center gap-3 border-b border-gray-50 last:border-0 hover:bg-blue-50/30 transition-colors">
                    <div class="w-7 h-7 rounded-full flex items-center justify-center font-bold text-sm {{ $index == 0 ? 'bg-yellow-400 text-white' : ($index == 1 ? 'bg-gray-300 text-white' : 'bg-amber-600 text-white') }}">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 truncate">{{ $cust->nama_klien }}</p>
                    </div>
                    <div class="text-right flex-shrink-0">
                        <span class="text-xs font-bold text-green-700">Rp {{ number_format($cust->total_transaksi, 0, ',', '.') }}</span>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center text-gray-500 text-sm">Belum ada data transaksi bulan ini.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>


<!-- Section Bawah: 2 Kolom -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <!-- Peringatan Stok Tipis -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                </div>
                <h3 class="font-heading text-base font-bold text-gray-800">Peringatan Stok Tipis</h3>
            </div>
            <span class="text-[11px] font-bold bg-red-100 text-red-700 px-2.5 py-1 rounded-full uppercase tracking-wider">&lt; 10 Pcs</span>
        </div>
        <div>
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50/80">
                        <th class="px-6 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Barang</th>
                        <th class="px-6 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider">Sisa Stok</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($lowStockProducts as $item)
                    <tr class="hover:bg-red-50/50 transition-colors">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full {{ $item->stok_saat_ini <= 3 ? 'bg-red-500 animate-pulse' : 'bg-yellow-500' }}"></div>
                                <span class="text-sm font-medium text-gray-900">{{ $item->nama_barang }}</span>
                                <span class="text-xs text-gray-400 font-mono">[{{ $item->sku }}]</span>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-right">
                            <span class="inline-flex items-center justify-center min-w-[2.5rem] px-2.5 py-1 text-sm font-bold rounded-full {{ $item->stok_saat_ini <= 3 ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $item->stok_saat_ini }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center gap-2">
                                <div class="w-12 h-12 rounded-full bg-green-50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-sm text-gray-500 font-medium">Stok semua barang aman!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(count($lowStockProducts) > 0)
        <div class="px-6 py-3 bg-gray-50/50 border-t text-right">
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm text-tema-marun hover:text-red-700 font-semibold transition-colors gap-1">
                Lihat Semua Barang
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        @endif
    </div>

    <!-- Aktivitas Terakhir -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                <svg class="w-4.5 h-4.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
            </div>
            <h3 class="font-heading text-base font-bold text-gray-800">Aktivitas Stok Terakhir</h3>
        </div>
        <div>
            @forelse($recentMovements as $move)
            <div class="px-6 py-4 flex items-center gap-4 border-b border-gray-50 last:border-b-0 hover:bg-gray-50/50 transition-colors">
                <!-- Icon -->
                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $move->tipe_pergerakan == 'masuk' ? 'bg-emerald-50 text-emerald-500' : 'bg-red-50 text-red-500' }}">
                    @if($move->tipe_pergerakan == 'masuk')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                    @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                    @endif
                </div>
                <!-- Info -->
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $move->product->nama_barang ?? 'Barang Dihapus' }}</p>
                    <p class="text-xs text-gray-400 truncate mt-0.5">{{ $move->keterangan ?: 'Tidak ada catatan' }}</p>
                </div>
                <!-- Qty -->
                <div class="text-right flex-shrink-0">
                    <p class="text-sm font-bold {{ $move->tipe_pergerakan == 'masuk' ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $move->tipe_pergerakan == 'masuk' ? '+' : '-' }}{{ $move->jumlah }}
                    </p>
                    <p class="text-[11px] text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($move->tanggal)->diffForHumans() }}</p>
                </div>
            </div>
            @empty
            <div class="px-6 py-8 text-center">
                <div class="flex flex-col items-center gap-2">
                    <div class="w-12 h-12 rounded-full bg-gray-50 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    </div>
                    <p class="text-sm text-gray-500 font-medium">Belum ada aktivitas mutasi barang.</p>
                </div>
            </div>
            @endforelse
        </div>
        @if(count($recentMovements) > 0)
        <div class="px-6 py-3 bg-gray-50/50 border-t text-right">
            <a href="{{ route('inventory-movements.index') }}" class="inline-flex items-center text-sm text-tema-kuning hover:text-yellow-600 font-semibold transition-colors gap-1">
                Lihat Semua Riwayat
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
        @endif
    </div>
</div>

<!-- ApexCharts Script -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var options = {
            series: [{
                name: 'Omzet',
                data: {!! json_encode($chartRevenues) !!}
            }],
            chart: {
                height: 280,
                type: 'area',
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            colors: ['#FBBF24'], // tema-kuning
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100]
                }
            },
            xaxis: {
                categories: {!! json_encode($chartDates) !!},
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: '#9CA3AF', fontSize: '11px' }
                }
            },
            yaxis: {
                labels: {
                    style: { colors: '#9CA3AF', fontSize: '11px' },
                    formatter: function (value) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(value);
                    }
                }
            },
            grid: {
                borderColor: '#F3F4F6',
                strokeDashArray: 4,
                yaxis: { lines: { show: true } },
                padding: { top: 0, right: 0, bottom: 0, left: 10 }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#salesChart"), options);
        chart.render();

        // Monthly comparison chart
        var monthlyOptions = {
            series: [{
                name: 'Omzet',
                data: [{{ $omzetBulanLalu }}, {{ $totalRevenueThisMonth }}]
            }],
            chart: {
                height: 160,
                type: 'bar',
                fontFamily: 'Inter, sans-serif',
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    columnWidth: '55%',
                    distributed: true,
                    borderRadius: 4
                }
            },
            colors: ['#9CA3AF', '#7f1d1d'], // gray for last month, tema-marun for this month
            dataLabels: { enabled: false },
            legend: { show: false },
            xaxis: {
                categories: ['Bulan Lalu', 'Bulan Ini'],
                axisBorder: { show: false },
                axisTicks: { show: false },
                labels: {
                    style: { colors: '#9CA3AF', fontSize: '11px' }
                }
            },
            yaxis: {
                show: false
            },
            grid: {
                show: false
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function (val) {
                        return "Rp " + new Intl.NumberFormat('id-ID').format(val);
                    }
                }
            }
        };

        var monthlyChart = new ApexCharts(document.querySelector("#monthlyComparisonChart"), monthlyOptions);
        monthlyChart.render();
    });
</script>

@endsection
