@extends('layouts.admin')
@section('title', 'Data Invoice')
@section('content')

<!-- TomSelect -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<!-- Custom TomSelect Styling -->
<style>
    .ts-wrapper .ts-control {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        padding: 6px 10px !important;
        font-size: 13px !important;
        background: #fff !important;
        min-height: 38px !important;
        transition: all 0.2s !important;
    }
    .ts-wrapper.focus .ts-control {
        border-color: #7f1d1d !important;
        box-shadow: 0 0 0 3px rgba(127, 29, 29, 0.1) !important;
    }
    .ts-wrapper .ts-dropdown {
        border: 1px solid #e5e7eb !important;
        border-radius: 0.5rem !important;
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.3) !important;
        margin-top: 4px !important;
        z-index: 99999 !important;
        position: absolute !important;
        top: 100% !important;
        max-height: 220px !important;
        overflow-y: auto !important;
        animation: dropdownSlide 0.15s ease-out !important;
    }
    @keyframes dropdownSlide {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .ts-wrapper .ts-dropdown .ts-dropdown-content {
        max-height: 200px !important;
        padding: 4px !important;
    }
    .ts-wrapper .ts-dropdown .option {
        padding: 8px 10px !important;
        border-radius: 5px !important;
        margin-bottom: 1px !important;
        font-size: 12.5px !important;
        line-height: 1.4 !important;
        transition: all 0.15s ease !important;
        cursor: pointer !important;
    }
    .ts-wrapper .ts-dropdown .option:hover,
    .ts-wrapper .ts-dropdown .active {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%) !important;
        color: #1f2937 !important;
    }
    .ts-wrapper .ts-dropdown .option .sku-badge {
        display: inline-block;
        background: #7f1d1d;
        color: #fff;
        padding: 1px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        margin-right: 8px;
        vertical-align: middle;
    }
    .ts-wrapper .ts-dropdown .option .product-name {
        font-weight: 600;
        color: #1f2937;
        vertical-align: middle;
    }
    .ts-wrapper .ts-dropdown .option .stock-info {
        float: right;
        font-size: 11px;
        font-weight: 600;
        padding: 2px 8px;
        border-radius: 10px;
        vertical-align: middle;
    }
    .ts-wrapper .ts-dropdown .option .stock-ok {
        background: #d1fae5;
        color: #065f46;
    }
    .ts-wrapper .ts-dropdown .option .stock-low {
        background: #fee2e2;
        color: #991b1b;
    }
    .ts-wrapper .ts-dropdown .no-results {
        padding: 16px !important;
        text-align: center !important;
        color: #9ca3af !important;
        font-size: 13px !important;
    }
    .ts-wrapper .ts-control .item {
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        max-width: 100% !important;
        display: block !important;
    }
</style>

<div class="space-y-5" x-data="invoicePage({{ $products->toJson() }}, {{ $errors->any() ? 'true' : 'false' }})">

    {{-- Alerts --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;" class="flex items-center gap-3 px-5 py-3.5">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#15803d;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span style="font-size:0.875rem;font-weight:600;color:#15803d;">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">Daftar Invoice</h1>
            <p style="font-size:0.8rem;color:#6b7280;margin-top:2px;">Kelola dan pantau seluruh invoice penjualan.</p>
        </div>
        @if(in_array(auth()->user()->role, ['superadmin', 'staf_admin']))
        <button @click="openModal()"
                style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;"
                class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Invoice Baru
        </button>
        @endif
    </div>

    {{-- Filter & Pencarian Invoice --}}
    <form action="{{ route('invoices.index') }}" method="GET">
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5">
            <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="flex items-center gap-1.5 mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter &amp; Pencarian
            </p>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                <div>
                    <label style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="block mb-1.5">No. Invoice</label>
                    <input type="text" name="nomor" value="{{ request('nomor') }}" placeholder="Cari nomor..." class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
                </div>
                <div>
                    <label style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="block mb-1.5">Nama Klien</label>
                    <input type="text" name="customer" value="{{ request('customer') }}" placeholder="Cari klien..." class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
                </div>
                <div>
                    <label style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="block mb-1.5">Status Bayar</label>
                    <select name="status" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
                        <option value="">-- Semua --</option>
                        <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>✅ Lunas</option>
                        <option value="belum_lunas" {{ request('status') == 'belum_lunas' ? 'selected' : '' }}>⏳ Belum Lunas</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="block mb-1.5">Dari Tanggal</label>
                    <input type="date" name="dari" value="{{ request('dari') }}" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
                </div>
                <div>
                    <label style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="block mb-1.5">Sampai Tanggal</label>
                    <input type="date" name="sampai" value="{{ request('sampai') }}" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
                </div>
            </div>
            <div class="flex items-center justify-between mt-4 pt-4" style="border-top:1px solid #f3f4f6;">
                <div class="flex gap-2">
                    <button type="submit"
                            style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;"
                            class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold rounded-xl shadow-md hover:opacity-90 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Terapkan Filter
                    </button>
                    @if(request()->hasAny(['nomor','customer','status','dari','sampai']))
                    <a href="{{ route('invoices.index') }}"
                       style="background:#f3f4f6;color:#374151;"
                       class="flex items-center gap-1.5 px-4 py-2 text-xs font-bold rounded-xl hover:bg-gray-200 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Reset
                    </a>
                    @endif
                </div>
                @if(request()->hasAny(['nomor','customer','status','dari','sampai']))
                <div class="flex gap-4">
                    <div style="font-size:0.75rem;">
                        <span style="color:#6b7280;">Total Tagihan (Filter):</span>
                        <span style="font-weight:900;color:#1f2937;" class="ml-1">Rp {{ number_format($totalTagihanFilter, 0, ',', '.') }}</span>
                    </div>
                    <div style="font-size:0.75rem;">
                        <span style="color:#6b7280;">Outstanding:</span>
                        <span style="font-weight:900;color:#b91c1c;" class="ml-1">Rp {{ number_format($totalBelumLunasFilter, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </form>

    {{-- Tabel Daftar Invoice --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr style="background:#1f2937;">
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">Tanggal</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">No. Invoice</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">Nama Klien</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-center">Status</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">Jatuh Tempo</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-right">Total Tagihan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-center w-64">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($invoices as $invoice)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($invoice->tanggal_invoice)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs font-bold text-gray-900">
                            <span style="background:#f3f4f6;color:#1f2937;border:1px solid #e5e7eb;" class="px-2 py-1 rounded-md font-mono">
                                {{ $invoice->nomor_invoice }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-sm font-semibold text-gray-800">
                            {{ $invoice->nama_klien }}
                        </td>
                        <td class="px-4 py-3.5 text-center whitespace-nowrap">
                            <div class="flex flex-col items-center gap-1">
                                @if($invoice->status === 'draft')
                                    <span style="background:#fefce8;color:#a16207;border:1px solid #fde68a;" class="px-2 py-0.5 text-[10px] font-bold rounded-full">E-Catalog</span>
                                @else
                                    <span style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;" class="px-2 py-0.5 text-[10px] font-bold rounded-full">Selesai</span>
                                @endif
                                @if($invoice->status_pembayaran === 'lunas')
                                    <span style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;" class="px-2.5 py-0.5 text-xs font-bold rounded-full">Lunas</span>
                                @else
                                    <span style="background:#fff5f5;color:#b91c1c;border:1px solid #fecaca;" class="px-2.5 py-0.5 text-xs font-bold rounded-full">Belum Lunas</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-xs text-gray-700">
                            @if($invoice->tanggal_jatuh_tempo)
                                @php
                                    $jatuhTempo = \Carbon\Carbon::parse($invoice->tanggal_jatuh_tempo);
                                    $now = \Carbon\Carbon::now();
                                    $diffDays = $now->startOfDay()->diffInDays($jatuhTempo->startOfDay(), false);
                                @endphp
                                <div class="font-bold mb-0.5 text-gray-800">{{ $jatuhTempo->format('d M Y') }}</div>
                                @if($invoice->status_pembayaran === 'belum_lunas')
                                    @if($diffDays < 0)
                                        <span style="background:#fff5f5;color:#b91c1c;border:1px solid #fecaca;" class="px-2 py-0.5 text-[10px] font-bold rounded">Lewat {{ abs($diffDays) }} hari</span>
                                    @elseif($diffDays <= 7)
                                        <span style="background:#fefce8;color:#a16207;border:1px solid #fde68a;" class="px-2 py-0.5 text-[10px] font-bold rounded">Sisa {{ $diffDays }} hari</span>
                                    @else
                                        <span style="background:#f9fafb;color:#6b7280;border:1px solid #e5e7eb;" class="px-2 py-0.5 text-[10px] font-bold rounded">Sisa {{ $diffDays }} hari</span>
                                    @endif
                                @else
                                    <span style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;" class="px-2 py-0.5 text-[10px] font-bold rounded">Selesai</span>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3.5 whitespace-nowrap text-sm font-extrabold text-right" style="color:#15803d;">
                            Rp {{ number_format($invoice->total_tagihan, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3.5 text-center whitespace-nowrap">
                            <div class="flex items-center justify-center gap-1.5 flex-wrap">
                                {{-- Tombol Tandai Lunas --}}
                                @if($invoice->status_pembayaran === 'belum_lunas' && in_array(auth()->user()->role, ['staf_admin', 'bendahara', 'superadmin']))
                                    <form action="{{ route('invoices.mark-paid', $invoice->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menandai invoice ini sebagai LUNAS?');">
                                        @csrf
                                        <button type="submit" 
                                                style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all hover:bg-green-100" title="Tandai Lunas">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Lunas
                                        </button>
                                    </form>
                                @endif

                                {{-- Dropdown Cetak --}}
                                <div x-data="{ openCetak: false }" class="relative inline-block text-left">
                                    <button @click="openCetak = !openCetak" @click.away="openCetak = false" type="button" 
                                            style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all hover:opacity-80">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                        <span>Cetak</span>
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>

                                    <div x-show="openCetak" x-transition style="display:none;" 
                                         class="absolute right-0 mt-1 w-40 bg-white border border-gray-200 rounded-xl shadow-xl z-30 py-1 text-left">
                                        <a href="{{ route('invoices.show', $invoice->id) }}" target="_blank" class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-yellow-50 hover:text-yellow-900 transition-colors">
                                            <span>📄</span> A4 (Klien)
                                        </a>
                                        <a href="{{ route('invoices.struk', $invoice->id) }}" target="_blank" class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-blue-50 hover:text-blue-900 transition-colors">
                                            <span>🧾</span> Struk Thermal
                                        </a>
                                        <a href="{{ route('invoices.show', ['invoice' => $invoice->id, 'mode' => 'internal']) }}" target="_blank" class="flex items-center gap-2 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-red-50 hover:text-red-900 transition-colors">
                                            <span>📋</span> A4 (Internal)
                                        </a>
                                    </div>
                                </div>

                                {{-- Bukti Transfer / Pembayaran --}}
                                @if(in_array(auth()->user()->role, ['superadmin', 'bendahara']))
                                    @if($invoice->bukti_file)
                                        <button type="button" @click="openBuktiViewer('{{ Storage::url($invoice->bukti_file) }}', '{{ $invoice->bukti_keterangan }}')" 
                                                style="background:#f3e8ff;color:#6b21a8;border:1px solid #e9d5ff;" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all hover:bg-purple-100" title="Lihat Bukti">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Bukti
                                        </button>
                                    @else
                                        <button type="button" @click="openUploadBukti('{{ $invoice->id }}', '{{ $invoice->nomor_invoice }}')" 
                                                style="background:#f3f4f6;color:#374151;border:1px solid #e5e7eb;" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all hover:bg-gray-200" title="Upload Bukti">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                            Upload
                                        </button>
                                    @endif
                                @endif

                                {{-- Edit & Hapus (Superadmin) --}}
                                @if(auth()->user()->role === 'superadmin')
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" 
                                       style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;" 
                                       class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all hover:bg-blue-100" title="Edit Invoice">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" class="inline" onsubmit="return confirm('⚠️ PERINGATAN SUPERADMIN ⚠️\n\nAnda akan MENGHAPUS invoice {{ $invoice->nomor_invoice }}.\nStok barang akan dikembalikan secara otomatis.\n\nApakah Anda yakin?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                style="background:#fff5f5;color:#b91c1c;border:1px solid #fecaca;" 
                                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all hover:bg-red-100" title="Hapus Invoice">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding:48px 16px;text-align:center;">
                            <svg class="w-12 h-12 mx-auto mb-3" style="color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <p style="font-size:0.875rem;font-weight:600;color:#9ca3af;">Tidak ada riwayat invoice.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="border-top:1px solid #f3f4f6;" class="px-6 py-4">
            {{ $invoices->links() }}
        </div>
    </div>

    <!-- ==================== MODAL POPUP ==================== -->
    <div x-show="isModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div x-show="isModalOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-gray-900 bg-opacity-70 backdrop-blur-sm transition-opacity" 
             @click="closeModal()"></div>

        <!-- Panel -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div x-show="isModalOpen" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4" 
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0" 
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4" 
                 class="relative bg-white rounded-2xl text-left shadow-2xl transform transition-all w-full border border-gray-100"
                 style="max-width: 1000px;"
                 @click.away="closeModal()">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-tema-marun to-red-800 rounded-t-2xl px-6 py-4 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="bg-white bg-opacity-20 rounded-lg p-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-white">Buat Invoice Baru</h3>
                    </div>
                    <button type="button" @click="closeModal()" class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-1.5 transition-all">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Body -->
                <div class="px-8 py-6 max-h-[80vh] overflow-y-auto">
                    @if($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-3 rounded-md mb-5">
                            <ul class="text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('invoices.store') }}" method="POST" id="invoice-form">
                        @csrf
                        
                        <!-- Info Faktur - Compact -->
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-5 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">
                                    No. Invoice *
                                    @if(auth()->user()->role === 'superadmin')
                                        <span class="text-yellow-600 ml-1" title="Superadmin dapat mengedit nomor invoice">✏️ Editable</span>
                                    @endif
                                </label>
                                @if(auth()->user()->role === 'superadmin')
                                    <input type="text" name="nomor_invoice" value="{{ old('nomor_invoice', $nomor_invoice) }}" class="w-full rounded-lg border-yellow-400 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-400 focus:ring-opacity-30 text-sm py-2 px-3 border-2 bg-white font-bold" required>
                                @else
                                    <input type="text" name="nomor_invoice" value="{{ old('nomor_invoice', $nomor_invoice) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border bg-gray-100" required readonly>
                                @endif
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Nama Klien / Instansi *</label>
                                <select name="nama_klien" id="nama_klien" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border bg-white" required>
                                    <option value="">-- Pilih Customer / Klien --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->nama_klien }}">{{ $customer->nama_klien }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Tanggal Invoice *</label>
                                <input type="date" name="tanggal_invoice" x-model="tanggalInvoice" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" required>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider" title="Otomatis +30 Hari">Jatuh Tempo *</label>
                                <input type="date" name="tanggal_jatuh_tempo" x-model="tanggalJatuhTempo" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" required>
                            </div>
                        </div>

                        <!-- Opsi Grosir -->
                        <div class="mb-4 bg-yellow-50 border border-yellow-200 p-3 rounded-lg flex items-center gap-3">
                            <input type="checkbox" id="gunakan_grosir" name="is_grosir" value="1" x-model="isGrosir" @change="recalculateAllPrices()" class="w-5 h-5 text-tema-marun border-gray-300 rounded focus:ring-tema-marun focus:ring-2">
                            <label for="gunakan_grosir" class="text-sm font-bold text-yellow-800 cursor-pointer">Gunakan Harga Grosir</label>
                            <span class="text-xs text-yellow-600">(Berlaku untuk barang yang memiliki harga grosir)</span>
                        </div>

                        <!-- Banner Notifikasi Tarik Barang Keluar -->
                        <template x-if="manualMovements.length > 0">
                            <div class="mb-4 bg-blue-50 border border-blue-200 rounded-lg p-3 flex justify-between items-center shadow-sm">
                                <div class="flex items-center gap-3 text-blue-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span class="text-sm font-medium">Terdapat <strong x-text="manualMovements.length"></strong> data <em>Barang Keluar</em> manual di tanggal ini.</span>
                                </div>
                                <button type="button" @click="pullMovements()" class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-1.5 px-3 rounded shadow transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path></svg>
                                    Tarik ke Invoice
                                </button>
                            </div>
                        </template>



                        <!-- Tabel Barang -->
                        <div class="border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <table class="w-full divide-y divide-gray-200" style="table-layout: fixed;">
                                <colgroup>
                                    <col style="width: 5%;">
                                    <col style="width: 35%;">
                                    <col style="width: 25%;">
                                    <col style="width: 10%;">
                                    <col style="width: 20%;">
                                    <col style="width: 5%;">
                                </colgroup>
                                <thead class="bg-gray-100 border-b-2 border-gray-200">
                                    <tr>
                                        <th class="px-2 py-2.5 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider">#</th>
                                        <th class="px-2 py-2.5 text-left text-[11px] font-bold text-gray-700 uppercase tracking-wider">Barang</th>
                                        <th class="px-2 py-2.5 text-left text-[11px] font-bold text-gray-700 uppercase tracking-wider">Harga Satuan (Otomatis)</th>
                                        <th class="px-2 py-2.5 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider">Qty</th>
                                        <th class="px-2 py-2.5 text-right text-[11px] font-bold text-gray-700 uppercase tracking-wider">Subtotal</th>
                                        <th class="px-2 py-2.5 text-center text-[11px] font-bold text-gray-700 uppercase tracking-wider"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    <template x-for="(item, index) in items" :key="item.id">
                                        <tr class="hover:bg-amber-50 transition-colors">
                                            <template x-if="item.movement_id">
                                                <input type="hidden" :name="'items['+index+'][movement_id]'" :value="item.movement_id">
                                            </template>
                                            <td class="px-3 py-3 text-center text-sm font-bold text-gray-500" x-text="index + 1"></td>
                                            <td class="px-3 py-3">
                                                <select x-model="item.product_id" :name="'items['+index+'][product_id]'" 
                                                        @change="updatePrice(index)"
                                                        x-init="$nextTick(() => { 
                                                            if(!item.ts) {
                                                                item.ts = new TomSelect($el, {
                                                                    create: false,
                                                                    dropdownParent: 'body',
                                                                    placeholder: '🔍 Ketik kode / nama...',
                                                                    sortField: { field: 'text', direction: 'asc' },
                                                                    maxOptions: 50,
                                                                    render: {
                                                                        option: function(data, escape) {
                                                                            let text = escape(data.text);
                                                                            let parts = text.split(' - ');
                                                                            let sku = parts[0] || '';
                                                                            let rest = parts.slice(1).join(' - ');
                                                                            let nameMatch = rest.match(/^(.+?)\s*\(Sisa:\s*(\d+)\)$/);
                                                                            let name = nameMatch ? nameMatch[1] : rest;
                                                                            let stock = nameMatch ? parseInt(nameMatch[2]) : 0;
                                                                            let stockClass = stock > 10 ? 'stock-ok' : 'stock-low';
                                                                            return '<div>' +
                                                                                '<span class=\"sku-badge\">' + escape(sku) + '</span>' +
                                                                                '<span class=\"product-name\">' + escape(name) + '</span>' +
                                                                                '<span class=\"stock-info ' + stockClass + '\">' + stock + '</span>' +
                                                                                '</div>';
                                                                        },
                                                                        item: function(data, escape) {
                                                                            let text = escape(data.text);
                                                                            let parts = text.split(' - ');
                                                                            let sku = parts[0] || '';
                                                                            let rest = parts.slice(1).join(' - ');
                                                                            let nameMatch = rest.match(/^(.+?)\s*\(Sisa:\s*\d+\)$/);
                                                                            let name = nameMatch ? nameMatch[1] : rest;
                                                                            return '<div class=\"truncate w-full\" style=\"max-width:100%\"><span style=\"background:#7f1d1d;color:#fff;padding:1px 6px;border-radius:3px;font-size:11px;font-weight:700;margin-right:6px\">' + escape(sku) + '</span>' + escape(name) + '</div>';
                                                                        },
                                                                        no_results: function() {
                                                                            return '<div class=\"no-results\">Tidak ada barang ditemukan</div>';
                                                                        }
                                                                    },
                                                                    onChange: function(value) {
                                                                        $el.dispatchEvent(new Event('input', { bubbles: true }));
                                                                        $el.dispatchEvent(new Event('change', { bubbles: true }));
                                                                    }
                                                                });
                                                            }
                                                        })" class="w-full" required>
                                                    <option value="">Ketik SKU / Nama Barang...</option>
                                                    @foreach($products as $p)
                                                        <option value="{{ $p->id }}">{{ $p->sku }} - {{ $p->nama_barang }} (Sisa: {{ $p->stok_saat_ini }})</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="px-3 py-3">
                                                <div class="flex rounded-lg overflow-hidden border-2 border-gray-300 bg-gray-100 shadow-sm">
                                                    <span class="inline-flex items-center px-3 bg-tema-marun text-white text-sm font-bold border-r border-gray-300 flex-shrink-0">Rp</span>
                                                    <input type="text" :value="formatRupiah(item.harga_jual)" class="flex-1 min-w-0 w-full px-3 py-2.5 text-[15px] font-bold text-gray-900 border-0 bg-gray-100 cursor-not-allowed" readonly>
                                                </div>
                                            </td>
                                            <td class="px-3 py-3">
                                                <input type="number" x-model="item.jumlah" :name="'items['+index+'][jumlah]'" @input="updateSubtotal(index)" class="w-full rounded-lg border-2 border-gray-300 focus:ring-tema-marun focus:border-tema-marun text-[15px] py-2.5 text-center font-bold text-gray-900 shadow-sm" min="1" required>
                                            </td>
                                            <td class="px-3 py-3 text-right font-bold text-[15px] text-gray-900 whitespace-nowrap" x-text="'Rp ' + formatRupiah(item.subtotal)"></td>
                                            <td class="px-2 py-3 text-center">
                                                <button type="button" @click="removeItem(index)" class="text-gray-300 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-full transition-all" title="Hapus" x-show="items.length > 1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer Tabel -->
                        <div class="mt-3 flex justify-between items-center">
                            <button type="button" @click="addItem()" class="bg-white border border-dashed border-gray-400 hover:border-tema-marun hover:text-tema-marun text-gray-500 font-semibold py-1.5 px-4 rounded-lg text-xs flex items-center transition-all">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                Tambah Baris
                            </button>
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center justify-between text-xs font-semibold text-gray-500 px-4">
                                    <span>PPN (11%):</span>
                                    <span x-text="'Rp ' + formatRupiah(calculatePPN())"></span>
                                </div>
                                <div class="flex items-center gap-3 bg-red-50 px-4 py-2 rounded-lg border border-red-200">
                                    <span class="text-xs font-bold text-red-900 uppercase tracking-wider">Total Tagihan:</span>
                                    <span class="text-xl font-black text-red-600" x-text="'Rp ' + formatRupiah(calculateTotal())"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Footer Modal -->
                <div class="bg-gray-50 border-t border-gray-200 px-6 py-3.5 flex justify-end gap-3 rounded-b-2xl">
                    <button type="button" @click="closeModal()" class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-700 font-bold py-2 px-5 rounded-lg transition-colors text-sm shadow-sm">
                        Batal
                    </button>
                    <button type="submit" form="invoice-form" class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-600 text-tema-hitam font-bold py-2 px-6 rounded-lg transition-all shadow-md text-sm flex items-center gap-2 hover:scale-105 duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Simpan & Potong Stok
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL UPLOAD BUKTI ==================== -->
    <div x-show="isUploadModalOpen" style="display: none;" class="fixed inset-0 z-[60] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="isUploadModalOpen" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75 backdrop-blur-sm"></div>
            </div>

            <div x-show="isUploadModalOpen" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative inline-block w-full max-w-md p-6 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl border-t-4 border-tema-kuning">
                
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-tema-kuning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Upload Bukti Invoice
                    </h3>
                    <button @click="closeUploadModal()" class="text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="'/invoices/' + uploadInvoiceId + '/upload-bukti'" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Invoice</label>
                        <input type="text" x-model="uploadInvoiceNomor" class="w-full rounded-lg border-gray-300 bg-gray-100 text-gray-500 text-sm py-2 px-3 font-bold cursor-not-allowed" readonly>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Pilih File (JPG, PNG, PDF | Max: 5MB)</label>
                        <input type="file" name="bukti_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-tema-kuning file:text-black hover:file:bg-yellow-500 transition-colors border border-gray-300 rounded-lg p-1" required>
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Keterangan (Opsional)</label>
                        <textarea name="bukti_keterangan" rows="3" class="w-full rounded-lg border-gray-300 focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 text-sm" placeholder="Tambahkan catatan jika perlu..."></textarea>
                    </div>

                    <div class="flex justify-end gap-3 pt-3 border-t border-gray-100">
                        <button type="button" @click="closeUploadModal()" class="px-5 py-2 text-sm font-bold text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none transition-colors">Batal</button>
                        <button type="submit" class="px-5 py-2 text-sm font-bold text-white bg-tema-marun rounded-lg hover:bg-red-900 focus:outline-none shadow-md hover:shadow-lg transition-all flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Upload Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ==================== MODAL LIHAT BUKTI ==================== -->
    <div x-show="isBuktiViewerOpen" style="display: none;" class="fixed inset-0 z-[70] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div x-show="isBuktiViewerOpen" x-transition.opacity class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-90 backdrop-blur-sm"></div>
            </div>

            <div x-show="isBuktiViewerOpen" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 class="relative inline-block w-full max-w-4xl p-2 overflow-hidden text-left align-middle transition-all transform bg-white shadow-2xl rounded-2xl h-[85vh] flex flex-col">
                
                <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200 rounded-t-xl flex-shrink-0">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Lihat Bukti Invoice
                    </h3>
                    <button @click="isBuktiViewerOpen = false" class="text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <div class="flex-1 overflow-hidden bg-gray-200 flex items-center justify-center relative">
                    <template x-if="viewerUrl.endsWith('.pdf')">
                        <iframe :src="viewerUrl" class="w-full h-full" frameborder="0"></iframe>
                    </template>
                    <template x-if="!viewerUrl.endsWith('.pdf')">
                        <img :src="viewerUrl" class="max-w-full max-h-full object-contain p-2">
                    </template>
                </div>
                
                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 rounded-b-xl flex-shrink-0">
                    <p class="text-sm font-semibold text-gray-700">Keterangan:</p>
                    <p class="text-sm text-gray-600 mt-1" x-text="viewerKeterangan || '- Tidak ada keterangan -'"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('invoicePage', (productsData, hasErrors) => ({
            isModalOpen: hasErrors,
            products: productsData,
            nextId: 2,
            items: [
                { id: 1, product_id: '', jumlah: 1, harga_jual: 0, subtotal: 0, ts: null, movement_id: null }
            ],
            tanggalInvoice: new Date().toISOString().split('T')[0],
            tanggalJatuhTempo: new Date(new Date().setDate(new Date().getDate() + 30)).toISOString().split('T')[0],
            manualMovements: [],
            convertedMovementIds: [],
            isFetchingMovements: false,
            isGrosir: false,

            // Upload Modal State
            isUploadModalOpen: false,
            uploadInvoiceId: '',
            uploadInvoiceNomor: '',

            // Viewer Modal State
            isBuktiViewerOpen: false,
            viewerUrl: '',
            viewerKeterangan: '',

            openUploadBukti(id, nomor) {
                this.uploadInvoiceId = id;
                this.uploadInvoiceNomor = nomor;
                this.isUploadModalOpen = true;
                document.body.style.overflow = 'hidden';
            },

            closeUploadModal() {
                this.isUploadModalOpen = false;
                this.uploadInvoiceId = '';
                this.uploadInvoiceNomor = '';
                document.body.style.overflow = '';
            },

            openBuktiViewer(url, keterangan) {
                this.viewerUrl = url;
                this.viewerKeterangan = keterangan;
                this.isBuktiViewerOpen = true;
            },

            init() {
                this.$watch('tanggalInvoice', value => {
                    this.fetchManualMovements(value);
                });
                this.fetchManualMovements(this.tanggalInvoice);
            },

            async fetchManualMovements(date) {
                if (!date) return;
                this.isFetchingMovements = true;
                try {
                    let response = await fetch(`/api/movements/manual-out?tanggal=${date}`);
                    let data = await response.json();
                    // Exclude already converted ones
                    this.manualMovements = data.filter(m => !this.convertedMovementIds.includes(m.id));
                } catch (e) {
                    console.error('Failed to fetch movements', e);
                } finally {
                    this.isFetchingMovements = false;
                }
            },

            pullMovements() {
                if (this.manualMovements.length === 0) return;
                
                // Remove empty initial row if it's untouched
                if (this.items.length === 1 && !this.items[0].product_id) {
                    if (this.items[0].ts) this.items[0].ts.destroy();
                    this.items = [];
                }

                this.manualMovements.forEach(m => {
                    this.items.push({
                        id: this.nextId++,
                        product_id: m.product_id,
                        jumlah: m.jumlah,
                        harga_jual: m.product ? m.product.harga_jual : 0,
                        subtotal: (m.product ? m.product.harga_jual : 0) * m.jumlah,
                        ts: null,
                        movement_id: m.id
                    });
                    this.convertedMovementIds.push(m.id);
                });

                this.manualMovements = []; // Clear after pull
                // Re-init TomSelects
                this.$nextTick(() => { window.dispatchEvent(new Event('resize')); });
            },
            
            openModal() {
                this.isModalOpen = true;
                document.body.style.overflow = 'hidden';
                setTimeout(() => window.dispatchEvent(new Event('resize')), 80);
            },
            
            closeModal() {
                this.isModalOpen = false;
                document.body.style.overflow = '';
            },
            
            addItem() {
                this.items.push({ id: this.nextId++, product_id: '', jumlah: 1, harga_jual: 0, subtotal: 0, ts: null, movement_id: null });
            },
            
            removeItem(index) {
                if(this.items.length > 1) {
                    let item = this.items[index];
                    if(item.ts) item.ts.destroy();
                    if(item.movement_id) {
                        this.convertedMovementIds = this.convertedMovementIds.filter(id => id !== item.movement_id);
                        this.fetchManualMovements(this.tanggalInvoice);
                    }
                    this.items.splice(index, 1);
                }
            },
            
            updatePrice(index) {
                let item = this.items[index];
                let product = this.products.find(p => p.id == item.product_id);
                if (product) {
                    item.harga_jual = (this.isGrosir && product.harga_grosir > 0) ? product.harga_grosir : product.harga_jual;
                } else {
                    item.harga_jual = 0;
                }
                this.updateSubtotal(index);
            },

            recalculateAllPrices() {
                this.items.forEach((item, index) => {
                    if (item.product_id) {
                        this.updatePrice(index);
                    }
                });
            },

            updateSubtotal(index) {
                let item = this.items[index];
                item.subtotal = item.jumlah * item.harga_jual;
            },
            
            calculateSubTotal() {
                return this.items.reduce((total, item) => total + item.subtotal, 0);
            },

            calculatePPN() {
                return this.calculateSubTotal() * 0.11;
            },

            calculateTotal() {
                return this.calculateSubTotal(); // Total tagihan = subtotal 
            },
            
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
        }));
    });
</script>
@endsection
