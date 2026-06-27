@extends('layouts.admin')
@section('title', 'Laporan Invoice')
@section('content')
<div class="space-y-5">

    {{-- Page Header + Filter --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-5">
            <div>
                <h1 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;" class="flex items-center gap-3">
                    <div style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);border-radius:12px;width:40px;height:40px;flex-shrink:0;" class="flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    Laporan Invoice
                </h1>
                <p style="font-size:0.8rem;color:#6b7280;margin-top:6px;margin-left:52px;">Pantau performa penjualan dan laba kotor perusahaan.</p>
            </div>

            <form method="GET" action="{{ route('reports.index') }}" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto items-end">
                <div>
                    <label style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="block mb-1.5">Mulai Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm font-semibold text-gray-700 focus:bg-white outline-none transition-all" style="min-width:160px;">
                </div>
                <div>
                    <label style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="block mb-1.5">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm font-semibold text-gray-700 focus:bg-white outline-none transition-all" style="min-width:160px;">
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit"
                            style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;"
                            class="flex items-center gap-2 px-4 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filter
                    </button>
                    <a href="{{ route('reports.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank"
                       style="background:linear-gradient(135deg,#1d4ed8,#3b82f6);color:white;"
                       class="flex items-center gap-2 px-4 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        Cetak PDF
                    </a>
                    <a href="{{ route('reports.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                       style="background:linear-gradient(135deg,#15803d,#16a34a);color:white;"
                       class="flex items-center gap-2 px-4 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Excel
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- 1. Total Pendapatan --}}
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin:0;">Total Pendapatan</p>
                    <div style="background:linear-gradient(135deg,#1d4ed8,#3b82f6);border-radius:10px;width:36px;height:36px;" class="flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
                <h3 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <div class="mt-3">
                    <span style="background:#f0fdf4;color:#15803d;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;" class="inline-flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        + PPN Rp {{ number_format($totalPpn, 0, ',', '.') }}
                    </span>
                </div>
            </div>
            <div style="height:4px;background:linear-gradient(90deg,#3b82f6,#1d4ed8);"></div>
        </div>

        {{-- 2. Total Modal (HPP) --}}
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin:0;">Total Modal (HPP)</p>
                    <div style="background:linear-gradient(135deg,#d97706,#FBBF24);border-radius:10px;width:36px;height:36px;" class="flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
                <h3 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">Rp {{ number_format($totalModal, 0, ',', '.') }}</h3>
                <div class="mt-3">
                    <span style="font-size:0.75rem;color:#9ca3af;font-weight:600;">Nilai modal barang terjual</span>
                </div>
            </div>
            <div style="height:4px;background:linear-gradient(90deg,#FBBF24,#d97706);"></div>
        </div>

        {{-- 3. Laba Kotor (HIGHLIGHT) --}}
        <div style="background:linear-gradient(135deg,#7f1d1d,#b91c1c,#991b1b);border-radius:16px;box-shadow:0 4px 16px rgba(127,29,29,0.3);" class="overflow-hidden hover:shadow-xl transition-shadow">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <p style="font-size:0.65rem;font-weight:800;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:0.08em;margin:0;">Laba Kotor</p>
                    <div style="background:rgba(255,255,255,0.15);border-radius:10px;width:36px;height:36px;" class="flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                </div>
                <h3 style="font-size:1.6rem;font-weight:900;color:white;margin:0;">Rp {{ number_format($labaKotor, 0, ',', '.') }}</h3>
                <div class="mt-3">
                    <span style="background:rgba(255,255,255,0.12);color:#fbbf24;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                        Pendapatan − Modal
                    </span>
                </div>
            </div>
            <div style="height:4px;background:linear-gradient(90deg,#fbbf24,#f59e0b);"></div>
        </div>

        {{-- 4. Total Transaksi --}}
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden hover:shadow-md transition-shadow">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin:0;">Total Invoice</p>
                    <div style="background:linear-gradient(135deg,#6d28d9,#8b5cf6);border-radius:10px;width:36px;height:36px;" class="flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                </div>
                <h3 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">{{ $totalTransaksi }} <span style="font-size:0.9rem;font-weight:600;color:#9ca3af;">Transaksi</span></h3>
                <div class="mt-3">
                    <span style="font-size:0.75rem;color:#9ca3af;font-weight:600;">Dalam periode terpilih</span>
                </div>
            </div>
            <div style="height:4px;background:linear-gradient(90deg,#8b5cf6,#6d28d9);"></div>
        </div>

    </div>

    {{-- Tabel Rincian Invoice --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        {{-- Table Header --}}
        <div style="border-bottom:1px solid #f3f4f6;background:#fafafa;" class="px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div style="background:#1f2937;border-radius:8px;width:32px;height:32px;" class="flex items-center justify-center">
                    <svg class="w-4 h-4" style="color:#fbbf24;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 style="font-weight:800;color:#1f2937;font-size:0.95rem;margin:0;">Rincian Invoice</h3>
            </div>
            <span style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;font-size:0.7rem;font-weight:700;padding:4px 12px;border-radius:999px;">
                {{ $invoices->count() }} Data
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr style="background:#1f2937;">
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 20px;text-align:left;letter-spacing:0.05em;">Tanggal</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 20px;text-align:left;letter-spacing:0.05em;">No. Invoice</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 20px;text-align:left;letter-spacing:0.05em;">Klien</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 20px;text-align:right;letter-spacing:0.05em;">Pendapatan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 20px;text-align:right;letter-spacing:0.05em;">Modal</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 20px;text-align:right;letter-spacing:0.05em;">Laba</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $inv)
                    @php
                        $modalInv = 0;
                        foreach($inv->invoiceItems as $item) {
                            $modalInv += ($item->harga_modal_snapshot * $item->jumlah);
                        }
                        $labaInv = $inv->sub_total - $modalInv;
                    @endphp
                    <tr class="hover:bg-gray-50/70 transition-colors" style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:14px 20px;white-space:nowrap;color:#6b7280;font-size:0.85rem;font-weight:500;">
                            {{ \Carbon\Carbon::parse($inv->tanggal_invoice)->format('d M Y') }}
                        </td>
                        <td style="padding:14px 20px;">
                            <span style="font-weight:700;color:#1f2937;font-size:0.875rem;">{{ $inv->nomor_invoice }}</span>
                        </td>
                        <td style="padding:14px 20px;color:#374151;font-weight:500;max-width:180px;" class="truncate" title="{{ $inv->nama_klien }}">
                            {{ $inv->nama_klien }}
                        </td>
                        <td style="padding:14px 20px;text-align:right;font-weight:700;color:#1f2937;font-size:0.875rem;white-space:nowrap;">
                            Rp {{ number_format($inv->sub_total, 0, ',', '.') }}
                        </td>
                        <td style="padding:14px 20px;text-align:right;color:#6b7280;font-weight:500;font-size:0.875rem;white-space:nowrap;">
                            Rp {{ number_format($modalInv, 0, ',', '.') }}
                        </td>
                        <td style="padding:14px 20px;text-align:right;">
                            @if($labaInv >= 0)
                                <span style="background:#f0fdf4;color:#15803d;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                    +Rp {{ number_format($labaInv, 0, ',', '.') }}
                                </span>
                            @else
                                <span style="background:#fff5f5;color:#b91c1c;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                    Rp {{ number_format($labaInv, 0, ',', '.') }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:56px 16px;text-align:center;">
                            <div style="background:#f9fafb;border-radius:16px;width:64px;height:64px;margin:0 auto 16px;" class="flex items-center justify-center">
                                <svg class="w-8 h-8" style="color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <p style="font-size:0.875rem;font-weight:600;color:#9ca3af;margin:0;">Tidak ada transaksi pada periode ini.</p>
                            <p style="font-size:0.75rem;color:#d1d5db;margin:4px 0 0;">Coba ubah filter tanggal di atas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($invoices->count() > 0)
                <tfoot>
                    <tr style="background:#f9fafb;border-top:2px solid #e5e7eb;">
                        <td colspan="3" style="padding:14px 20px;font-size:0.8rem;font-weight:900;color:#374151;text-transform:uppercase;letter-spacing:0.05em;">TOTAL</td>
                        <td style="padding:14px 20px;text-align:right;font-weight:900;color:#1f2937;font-size:0.875rem;white-space:nowrap;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        <td style="padding:14px 20px;text-align:right;font-weight:700;color:#6b7280;font-size:0.875rem;white-space:nowrap;">Rp {{ number_format($totalModal, 0, ',', '.') }}</td>
                        <td style="padding:14px 20px;text-align:right;">
                            @if($labaKotor >= 0)
                                <span style="background:#f0fdf4;color:#15803d;font-size:0.75rem;font-weight:900;padding:4px 12px;border-radius:999px;">
                                    +Rp {{ number_format($labaKotor, 0, ',', '.') }}
                                </span>
                            @else
                                <span style="background:#fff5f5;color:#b91c1c;font-size:0.75rem;font-weight:900;padding:4px 12px;border-radius:999px;">
                                    Rp {{ number_format($labaKotor, 0, ',', '.') }}
                                </span>
                            @endif
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

</div>
@endsection
