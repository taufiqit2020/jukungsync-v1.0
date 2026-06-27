@extends('layouts.admin')
@section('title', 'Pergerakan Stok')
@section('content')

<div class="space-y-5">

    {{-- ===== PAGE HEADER ===== --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">Pergerakan Stok</h1>
            <p style="font-size:0.8rem;color:#6b7280;margin-top:2px;">Riwayat semua mutasi stok barang masuk dan keluar.</p>
        </div>
        <a href="{{ route('inventory-movements.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all"
           style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Catat Pergerakan
        </a>
    </div>

    {{-- ===== SUMMARY STAT CARDS ===== --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        {{-- Masuk --}}
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5 flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#1d4ed8,#3b82f6);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
            </div>
            <div>
                <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Masuk</p>
                <p style="font-size:1.6rem;font-weight:900;color:#1d4ed8;line-height:1.1;">{{ $countMasuk }}</p>
            </div>
        </div>

        {{-- Sudah Invoice --}}
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5 flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#15803d,#16a34a);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Sudah Invoice</p>
                <p style="font-size:1.6rem;font-weight:900;color:#15803d;line-height:1.1;">{{ $countSudahInvoice }}</p>
            </div>
        </div>

        {{-- Belum Invoice --}}
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5 flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#d97706,#FBBF24);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Belum Invoice</p>
                <p style="font-size:1.6rem;font-weight:900;color:#d97706;line-height:1.1;">{{ $countBelumInvoice }}</p>
            </div>
        </div>

        {{-- Lainnya --}}
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5 flex items-center gap-4">
            <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center"
                 style="background:linear-gradient(135deg,#374151,#6b7280);">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Lainnya</p>
                <p style="font-size:1.6rem;font-weight:900;color:#374151;line-height:1.1;">{{ $countLainnya }}</p>
            </div>
        </div>

    </div>

    {{-- ===== FILTER CARD ===== --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5">
        <form action="{{ route('inventory-movements.index') }}" method="GET" class="flex flex-col md:flex-row gap-3 items-end">
            {{-- Search --}}
            <div class="flex-1">
                <label class="block mb-1.5" style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Cari Barang</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari Nama Barang / SKU / Keterangan..."
                           class="w-full border border-gray-200 bg-gray-50 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
                </div>
            </div>

            {{-- Status --}}
            <div class="w-full md:w-56">
                <label class="block mb-1.5" style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Status</label>
                <select name="status" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
                    <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>-- Semua Status --</option>
                    <option value="sudah_invoice" {{ request('status') == 'sudah_invoice' ? 'selected' : '' }}>✅ Sudah Jadi Invoice</option>
                    <option value="belum_invoice" {{ request('status') == 'belum_invoice' ? 'selected' : '' }}>⏳ Belum Di-Invoice</option>
                    <option value="lainnya" {{ request('status') == 'lainnya' ? 'selected' : '' }}>🏢 Lainnya (Kantor/Internal)</option>
                    <option value="masuk" {{ request('status') == 'masuk' ? 'selected' : '' }}>📥 Khusus Barang Masuk</option>
                </select>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-wrap gap-2">
                <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all"
                        style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;">
                    Terapkan
                </button>
                @if(request()->has('search') || request()->has('status'))
                    <a href="{{ route('inventory-movements.index') }}"
                       class="flex items-center gap-2 px-4 py-2.5 text-sm font-bold rounded-xl transition-all"
                       style="background:#f3f4f6;color:#374151;">
                        Reset
                    </a>
                @endif
                <a href="{{ route('reports.movements.print', ['status' => request('status', 'semua'), 'search' => request('search', ''), 'start_date' => '2000-01-01', 'end_date' => '2099-12-31']) }}"
                   target="_blank"
                   class="flex items-center gap-1.5 px-4 py-2.5 text-sm font-bold rounded-xl hover:opacity-90 transition-all"
                   style="background:linear-gradient(135deg,#1d4ed8,#3b82f6);color:white;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak PDF
                </a>
                <a href="{{ route('reports.movements.excel', ['status' => request('status', 'semua'), 'search' => request('search', ''), 'start_date' => '2000-01-01', 'end_date' => '2099-12-31']) }}"
                   class="flex items-center gap-1.5 px-4 py-2.5 text-sm font-bold rounded-xl hover:opacity-90 transition-all"
                   style="background:linear-gradient(135deg,#15803d,#16a34a);color:white;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Ekspor Excel
                </a>
            </div>
        </form>
    </div>

    {{-- ===== TABLE CARD ===== --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="background:#1f2937;">
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Tanggal</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Nama Barang</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Tipe</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:right;letter-spacing:0.05em;">Jumlah</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Keterangan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;">Status Invoice</th>
                        @if(auth()->user()->role === 'superadmin')
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($movements as $movement)
                    <tr class="hover:bg-gray-50/70 transition-colors" style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:13px 16px;font-size:0.85rem;color:#374151;white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($movement->tanggal)->format('d M Y') }}
                        </td>
                        <td style="padding:13px 16px;">
                            <p style="font-size:0.85rem;font-weight:600;color:#111827;white-space:nowrap;">{{ $movement->product->nama_barang ?? '-' }}</p>
                            <p style="font-size:0.75rem;color:#6b7280;margin-top:1px;">SKU: {{ $movement->product->sku ?? '-' }}</p>
                        </td>
                        <td style="padding:13px 16px;white-space:nowrap;">
                            @if($movement->tipe_pergerakan === 'masuk')
                                <span style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                    ↓ Barang Masuk
                                </span>
                            @else
                                <span style="background:#fff5f5;color:#b91c1c;border:1px solid #fecaca;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                    ↑ Barang Keluar
                                </span>
                            @endif
                        </td>
                        <td style="padding:13px 16px;font-size:0.9rem;font-weight:800;text-align:right;white-space:nowrap;color:{{ $movement->tipe_pergerakan === 'masuk' ? '#15803d' : '#b91c1c' }};">
                            {{ $movement->tipe_pergerakan === 'masuk' ? '+' : '-' }}{{ $movement->jumlah }}
                        </td>
                        <td style="padding:13px 16px;font-size:0.82rem;color:#6b7280;">
                            {{ $movement->keterangan ?: '-' }}
                        </td>
                        <td style="padding:13px 16px;text-align:center;">
                            @if($movement->tipe_pergerakan === 'keluar')
                                @if(strpos($movement->keterangan, 'Penjualan Invoice') !== false)
                                    <span style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                        ✓ Sudah Invoice
                                    </span>
                                @elseif(strpos($movement->keterangan, 'Mutasi Manual') !== false)
                                    <span style="background:#fffbeb;color:#d97706;border:1px solid #fde68a;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                        ⏳ Belum Invoice
                                    </span>
                                @else
                                    <span style="background:#f9fafb;color:#6b7280;border:1px solid #e5e7eb;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                        Lainnya
                                    </span>
                                @endif
                            @else
                                <span style="color:#d1d5db;font-weight:600;">—</span>
                            @endif
                        </td>
                        @if(auth()->user()->role === 'superadmin')
                        <td style="padding:13px 16px;text-align:center;white-space:nowrap;">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('inventory-movements.edit', $movement->id) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold rounded-lg transition-colors"
                                   style="background:#dbeafe;color:#1e40af;">Edit</a>
                                <form action="{{ route('inventory-movements.destroy', $movement->id) }}" method="POST"
                                      class="inline-block"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pergerakan stok ini? Stok barang akan dikembalikan seperti semula.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1.5 text-xs font-bold rounded-lg transition-colors"
                                            style="background:#fee2e2;color:#991b1b;">Hapus</button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'superadmin' ? '7' : '6' }}" style="padding:48px 16px;text-align:center;">
                            <svg class="w-12 h-12 mx-auto mb-3" style="color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p style="font-size:0.875rem;color:#9ca3af;font-weight:500;">Tidak ada riwayat pergerakan stok.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($movements->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #f3f4f6;">
            {{ $movements->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
