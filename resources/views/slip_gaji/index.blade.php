@extends('layouts.admin')

@section('title', 'Slip Gaji Karyawan')

@section('content')
<div class="space-y-5">

    {{-- ===== ALERTS ===== --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;" class="flex items-center gap-3 px-5 py-3.5">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:0.875rem;font-weight:600;color:#15803d;">{{ session('success') }}</span>
    </div>
    @endif

    {{-- ===== PAGE HEADER ===== --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">Slip Gaji Karyawan</h1>
            <p style="font-size:0.8rem;color:#6b7280;margin-top:2px;">Kelola pencatatan slip gaji, tunjangan, potongan BPJS, dan cetak slip pembayaran.</p>
        </div>
        <a href="{{ route('slip-gaji.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all"
           style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Slip Gaji Baru
        </a>
    </div>

    {{-- ===== FILTER CARD ===== --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5">
        <form action="{{ route('slip-gaji.index') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-4">
            <div class="w-full sm:w-1/2">
                <label class="block mb-1.5" style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Cari Karyawan / No. Slip</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama karyawan atau nomor slip..."
                       class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
            </div>
            <div class="w-full sm:w-1/4">
                <label class="block mb-1.5" style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;">Periode</label>
                <select name="periode"
                        class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
                    <option value="">Semua Periode</option>
                    @foreach($periodes as $p)
                    <option value="{{ $p }}" {{ request('periode') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2 w-full sm:w-1/4">
                <button type="submit"
                        class="flex-1 flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all"
                        style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;">
                    Filter
                </button>
                <a href="{{ route('slip-gaji.index') }}"
                   class="flex items-center justify-center px-4 py-2.5 text-sm font-bold rounded-xl transition-all"
                   style="background:#f3f4f6;color:#374151;">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ===== TABLE CARD ===== --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr style="background:#1f2937;">
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;width:52px;">No</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Nomor Slip</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Perusahaan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Nama Karyawan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Jabatan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;">Periode</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:right;letter-spacing:0.05em;">Gaji Bersih</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;width:200px;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($slipGajis as $idx => $slip)
                    <tr class="hover:bg-gray-50/70 transition-colors" style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:13px 16px;text-align:center;font-size:0.8rem;font-weight:600;color:#9ca3af;">
                            {{ $slipGajis->firstItem() + $idx }}
                        </td>
                        <td style="padding:13px 16px;font-family:monospace;font-size:0.85rem;font-weight:750;color:#1f2937;">
                            {{ $slip->nomor_slip }}
                        </td>
                        <td style="padding:13px 16px;font-size:0.85rem;font-weight:600;color:#374151;">
                            {{ $slip->perusahaan ?? 'PT. UTAMA MADANI RAYA' }}
                        </td>
                        <td style="padding:13px 16px;font-size:0.85rem;font-weight:700;color:#1f2937;">
                            {{ $slip->nama_karyawan }}
                        </td>
                        <td style="padding:13px 16px;font-size:0.85rem;color:#6b7280;">
                            {{ $slip->jabatan ?? '-' }}
                        </td>
                        <td style="padding:13px 16px;text-align:center;">
                            <span style="background:#eff6ff;color:#1e40af;border:1px solid #dbeafe;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:6px;text-transform:uppercase;letter-spacing:0.04em;">
                                {{ $slip->periode }}
                            </span>
                        </td>
                        <td style="padding:13px 16px;font-size:0.9rem;font-weight:800;color:#15803d;text-align:right;white-space:nowrap;">
                            Rp {{ number_format($slip->total_gaji, 0, ',', '.') }}
                        </td>
                        <td style="padding:13px 16px;text-align:center;">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('slip-gaji.show', $slip->id) }}"
                                   class="inline-flex items-center p-2 rounded-lg transition-colors"
                                   style="background:#fef3c7;color:#92400e;" title="Cetak / Tampilkan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                </a>
                                <a href="{{ route('slip-gaji.excel', $slip->id) }}"
                                   class="inline-flex items-center p-2 rounded-lg transition-colors"
                                   style="background:#d1fae5;color:#065f46;" title="Unduh Excel">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                                <a href="{{ route('slip-gaji.edit', $slip->id) }}"
                                   class="inline-flex items-center p-2 rounded-lg transition-colors"
                                   style="background:#dbeafe;color:#1e40af;" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('slip-gaji.destroy', $slip->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data slip gaji ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center p-2 rounded-lg transition-colors"
                                            style="background:#fee2e2;color:#991b1b;" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding:48px 16px;text-align:center;">
                            <svg class="w-12 h-12 mx-auto mb-3" style="color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4M8 16l-4-4 4-4m8 8l4-4-4-4"/></svg>
                            <p style="font-size:0.875rem;color:#9ca3af;font-weight:500;">Belum ada data slip gaji karyawan.</p>
                            <p style="font-size:0.75rem;color:#d1d5db;margin-top:4px;">Klik "Buat Slip Gaji Baru" untuk menambahkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($slipGajis->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $slipGajis->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
