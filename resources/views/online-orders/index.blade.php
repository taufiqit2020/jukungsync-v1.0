@extends('layouts.admin')
@section('title', 'Pesanan Online Masuk')
@section('content')

<div class="space-y-5">

    {{-- ===== ALERTS ===== --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;" class="flex items-center gap-3 px-5 py-3.5">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:0.875rem;font-weight:600;color:#15803d;">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div style="background:#fff5f5;border:1px solid #fecaca;border-radius:12px;" class="flex items-center gap-3 px-5 py-3.5">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#b91c1c;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:0.875rem;font-weight:600;color:#b91c1c;">{{ session('error') }}</span>
    </div>
    @endif

    {{-- ===== PAGE HEADER ===== --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">Pesanan Online Masuk</h1>
            <p style="font-size:0.8rem;color:#6b7280;margin-top:2px;">Daftar pesanan masuk dari E-Catalog yang perlu diproses.</p>
        </div>
    </div>

    {{-- ===== TABLE CARD ===== --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="background:#1f2937;">
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Tanggal</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">No. Pesanan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Pemesan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:right;letter-spacing:0.05em;">Total Tagihan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;">Status</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr class="hover:bg-gray-50/70 transition-colors" style="border-bottom:1px solid #f3f4f6;{{ $order->status_pesanan === 'menunggu_konfirmasi' ? 'background:#fffbeb;' : '' }}">
                        <td style="padding:13px 16px;font-size:0.85rem;color:#374151;white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($order->tanggal_invoice)->translatedFormat('d M Y') }}
                        </td>
                        <td style="padding:13px 16px;white-space:nowrap;">
                            <span style="font-size:0.85rem;font-weight:800;color:#1f2937;">{{ $order->nomor_invoice }}</span>
                        </td>
                        <td style="padding:13px 16px;">
                            <p style="font-size:0.85rem;font-weight:600;color:#1f2937;white-space:nowrap;">{{ $order->nama_klien }}</p>
                            <p style="font-size:0.75rem;color:#9ca3af;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">{{ $order->catatan }}</p>
                        </td>
                        <td style="padding:13px 16px;font-size:0.9rem;font-weight:900;color:#b91c1c;text-align:right;white-space:nowrap;">
                            Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}
                        </td>
                        <td style="padding:13px 16px;text-align:center;white-space:nowrap;">
                            @if($order->status_pesanan === 'menunggu_konfirmasi')
                                <span style="background:#fffbeb;color:#d97706;border:1px solid #fde68a;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                    Menunggu Konfirmasi
                                </span>
                            @elseif($order->status_pesanan === 'diproses')
                                <span style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                    Diproses
                                </span>
                            @elseif($order->status_pesanan === 'selesai')
                                <span style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                    Selesai
                                </span>
                            @else
                                <span style="background:#fff5f5;color:#b91c1c;border:1px solid #fecaca;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                    Dibatalkan
                                </span>
                            @endif
                        </td>
                        <td style="padding:13px 16px;text-align:center;">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('online-orders.show', $order->id) }}"
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-bold rounded-lg transition-colors"
                                   style="background:#fef3c7;color:#92400e;" title="Lihat Detail">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat Detail
                                </a>
                                @if(auth()->user()->role === 'superadmin')
                                <a href="{{ route('invoices.edit', $order->id) }}?from=online-orders"
                                   class="inline-flex items-center p-1.5 rounded-lg transition-colors"
                                   style="background:#dbeafe;color:#1e40af;" title="Edit">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('invoices.destroy', $order->id) }}?from=online-orders" method="POST"
                                      class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center p-1.5 rounded-lg transition-colors"
                                            style="background:#fee2e2;color:#991b1b;" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:48px 16px;text-align:center;">
                            <svg class="w-12 h-12 mx-auto mb-3" style="color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            <p style="font-size:0.875rem;color:#9ca3af;font-weight:500;">Tidak ada pesanan online.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($orders->hasPages())
        <div style="padding:14px 20px;border-top:1px solid #f3f4f6;">
            {{ $orders->links() }}
        </div>
        @endif
    </div>

</div>

@endsection
