@extends('layouts.admin')
@section('title', 'Data Kasbon Customer')
@section('content')

<div class="space-y-5" x-data="kasbonPage()">

    {{-- Alerts --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;" class="flex items-center gap-3 px-5 py-3.5">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#15803d;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span style="font-size:0.875rem;font-weight:600;color:#15803d;">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div style="background:#fff5f5;border:1px solid #fecaca;border-radius:12px;" class="flex items-center gap-3 px-5 py-3.5">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#b91c1c;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:0.875rem;font-weight:600;color:#b91c1c;">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Page Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">Kasbon Customer</h1>
            <p style="font-size:0.8rem;color:#6b7280;margin-top:2px;">Pantau dan kelola piutang kasbon pelanggan.</p>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- Card 1: Piutang Belum Lunas --}}
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5 flex items-center gap-4">
            <div style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);border-radius:14px;width:52px;height:52px;flex-shrink:0;" class="flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 4px;">Total Piutang Belum Lunas</p>
                <p style="font-size:1.3rem;font-weight:900;color:#b91c1c;margin:0;">Rp {{ number_format($totalPiutangBelumLunas, 0, ',', '.') }}</p>
                <p style="font-size:0.7rem;color:#9ca3af;margin:2px 0 0;">Akumulasi tagihan kasbon aktif customer</p>
            </div>
        </div>

        {{-- Card 2: Kasbon Lunas --}}
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5 flex items-center gap-4">
            <div style="background:linear-gradient(135deg,#15803d,#16a34a);border-radius:14px;width:52px;height:52px;flex-shrink:0;" class="flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
            <div>
                <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 4px;">Total Terbayar / Lunas</p>
                <p style="font-size:1.3rem;font-weight:900;color:#15803d;margin:0;">Rp {{ number_format($totalKasbonLunas, 0, ',', '.') }}</p>
                <p style="font-size:0.7rem;color:#9ca3af;margin:2px 0 0;">Total piutang kasbon yang sudah diselesaikan</p>
            </div>
        </div>

        {{-- Card 3: Total Akumulasi --}}
        <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5 flex items-center gap-4">
            <div style="background:linear-gradient(135deg,#374151,#6b7280);border-radius:14px;width:52px;height:52px;flex-shrink:0;" class="flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;margin:0 0 4px;">Total Seluruh Piutang</p>
                <p style="font-size:1.3rem;font-weight:900;color:#1f2937;margin:0;">Rp {{ number_format($totalSeluruhKasbon, 0, ',', '.') }}</p>
                <p style="font-size:0.7rem;color:#9ca3af;margin:2px 0 0;">Gabungan kasbon lunas &amp; belum lunas</p>
            </div>
        </div>

    </div>

    {{-- Filter Panel --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-5">
        <p style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="flex items-center gap-1.5 mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
            Filter &amp; Pencarian
        </p>
        <form method="GET" action="{{ route('kasbons.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <div>
                <label style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="block mb-1.5">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Klien atau No. Invoice..." class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
            </div>
            <div>
                <label style="font-size:0.65rem;font-weight:800;color:#9ca3af;text-transform:uppercase;letter-spacing:0.08em;" class="block mb-1.5">Status Pembayaran</label>
                <select name="status" class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white outline-none transition-all">
                    <option value="">Semua Status</option>
                    <option value="belum_lunas" {{ request('status') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
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
            <div class="flex gap-2">
                <button type="submit"
                        style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;"
                        class="flex-1 flex items-center justify-center gap-1.5 px-4 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Cari
                </button>
                @if(request()->anyFilled(['search', 'status', 'dari', 'sampai']))
                <a href="{{ route('kasbons.index') }}"
                   style="background:#f3f4f6;color:#374151;border:1px solid #e5e7eb;"
                   class="px-3 py-2.5 rounded-xl text-sm font-bold flex items-center justify-center hover:bg-gray-200 transition-all" title="Reset Filter">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Data Table --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr style="background:#1f2937;">
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">No. Invoice</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Customer / Klien</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Tgl Kasbon</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:right;letter-spacing:0.05em;">Total Tagihan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:right;letter-spacing:0.05em;">Sudah Dibayar</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:right;letter-spacing:0.05em;">Sisa Tagihan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;">Status</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kasbons as $kasbon)
                    <tr class="hover:bg-gray-50/70 transition-colors" style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:14px 16px;font-weight:700;color:#1f2937;white-space:nowrap;">
                            @if($kasbon->invoice && $kasbon->invoice->jenis_transaksi === 'online')
                                <a href="{{ route('online-orders.show', $kasbon->invoice_id) }}" style="color:#b91c1c;" class="hover:underline">
                                    {{ $kasbon->nomor_invoice }}
                                </a>
                            @else
                                {{ $kasbon->nomor_invoice }}
                            @endif
                        </td>
                        <td style="padding:14px 16px;font-weight:600;color:#1f2937;white-space:nowrap;">{{ $kasbon->nama_klien }}</td>
                        <td style="padding:14px 16px;color:#6b7280;white-space:nowrap;">{{ $kasbon->tanggal_kasbon->translatedFormat('d M Y') }}</td>
                        <td style="padding:14px 16px;text-align:right;font-weight:600;color:#374151;white-space:nowrap;">Rp {{ number_format($kasbon->total_tagihan, 0, ',', '.') }}</td>
                        <td style="padding:14px 16px;text-align:right;font-weight:600;color:#15803d;white-space:nowrap;">Rp {{ number_format($kasbon->jumlah_dibayar, 0, ',', '.') }}</td>
                        <td style="padding:14px 16px;text-align:right;white-space:nowrap;">
                            @if($kasbon->piutang_lalu > 0)
                                <div style="font-weight:800;color:#b91c1c;font-size:0.95rem;">Rp {{ number_format($kasbon->total_sisa_akumulasi, 0, ',', '.') }}</div>
                                <div style="font-size:0.68rem;color:#6b7280;margin-top:2px;">(Tagihan Ini: Rp {{ number_format($kasbon->sisa_tagihan, 0, ',', '.') }} + Lalu: Rp {{ number_format($kasbon->piutang_lalu, 0, ',', '.') }})</div>
                            @else
                                <div style="font-weight:800;color:#b91c1c;">Rp {{ number_format($kasbon->sisa_tagihan, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td style="padding:14px 16px;text-align:center;">
                            @if($kasbon->status === 'lunas')
                                <span style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">Lunas</span>
                                <p style="font-size:0.65rem;color:#9ca3af;font-weight:600;margin:4px 0 0;">{{ $kasbon->tanggal_lunas ? $kasbon->tanggal_lunas->format('d/m/Y') : '-' }}</p>
                            @else
                                <span style="background:#fff5f5;color:#b91c1c;border:1px solid #fecaca;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">Belum Lunas</span>
                            @endif
                        </td>
                        <td style="padding:14px 16px;text-align:center;">
                            <div class="flex items-center justify-center gap-2">
                                @if($kasbon->status === 'belum_lunas')
                                <button type="button" @click="openPaymentModal({{ json_encode($kasbon) }})"
                                        style="background:linear-gradient(135deg,#15803d,#16a34a);color:white;"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold hover:opacity-90 transition-all shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Bayar / Cicil
                                </button>
                                @endif

                                @if(auth()->user()->role === 'superadmin')
                                <form action="{{ route('kasbons.destroy', $kasbon->id) }}" method="POST" onsubmit="return confirm('⚠️ HAPUS DATA KASBON\n\nApakah Anda yakin ingin menghapus data kasbon ini?\nTindakan ini akan mengembalikan status pembayaran invoice terkait.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="background:#fff5f5;color:#b91c1c;border:1px solid #fecaca;"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold hover:bg-red-100 transition-all">
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
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                            Tidak ada data kasbon.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kasbons->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $kasbons->links() }}
        </div>
        @endif
    </div>

    {{-- Modal Form Pembayaran Kasbon --}}
    <div x-show="isModalOpen" class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto p-4 bg-black/60 backdrop-blur-sm" style="display: none;" x-transition>
        <div class="bg-white rounded-2xl max-w-md w-full shadow-2xl border border-gray-200 overflow-hidden" @click.away="closePaymentModal()">
            <div class="bg-tema-hitam px-6 py-4 flex items-center justify-between">
                <h3 class="font-heading font-bold text-white text-lg flex items-center gap-1.5">
                    <span>💵 Pembayaran Kasbon</span>
                </h3>
                <button type="button" @click="closePaymentModal()" class="text-gray-400 hover:text-white transition-colors text-xl font-bold">&times;</button>
            </div>
            
            <form :action="'/kasbons/' + activeKasbon.id + '/bayar'" method="POST" class="p-6 space-y-4">
                @csrf
                <!-- Detail Kasbon Info -->
                <div class="bg-gray-50 p-4 border border-gray-150 rounded-xl space-y-2 text-xs">
                    <div class="flex justify-between">
                        <span class="text-gray-500 font-semibold">No. Invoice:</span>
                        <strong class="text-gray-800" x-text="activeKasbon.nomor_invoice"></strong>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500 font-semibold">Nama Customer:</span>
                        <strong class="text-gray-800" x-text="activeKasbon.nama_klien"></strong>
                    </div>
                    <div class="flex justify-between border-t border-gray-200 pt-2 text-xs">
                        <span class="text-gray-600 font-semibold">Tagihan Invoice Ini:</span>
                        <strong class="text-gray-800" x-text="formatRupiah(activeKasbon.sisa_tagihan)"></strong>
                    </div>
                    <template x-if="activeKasbon.piutang_lalu > 0">
                        <div class="flex justify-between text-xs text-amber-700">
                            <span class="font-semibold">Piutang Belum Lunas Lalu:</span>
                            <strong x-text="formatRupiah(activeKasbon.piutang_lalu)"></strong>
                        </div>
                    </template>
                    <div class="flex justify-between border-t border-gray-200 pt-2 font-bold text-sm">
                        <span class="text-tema-marun">Total Akumulasi Tagihan:</span>
                        <span class="text-tema-marun" x-text="formatRupiah(activeKasbon.total_sisa_akumulasi || activeKasbon.sisa_tagihan)"></span>
                    </div>
                </div>

                <!-- Input Nominal Bayar -->
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-700">Jumlah Pembayaran (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_bayar" :max="activeKasbon.total_sisa_akumulasi || activeKasbon.sisa_tagihan" min="1" :value="activeKasbon.total_sisa_akumulasi || activeKasbon.sisa_tagihan" required class="w-full text-sm border-gray-200 bg-gray-50 rounded-xl p-3 focus:ring-tema-marun focus:border-tema-marun focus:bg-white transition-all font-black text-tema-marun">
                </div>

                <!-- Input Tanggal Bayar -->
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-700">Tanggal Pembayaran <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_bayar" value="{{ date('Y-m-d') }}" required class="w-full text-xs border-gray-200 bg-gray-50 rounded-xl p-3 focus:ring-tema-marun focus:border-tema-marun focus:bg-white transition-all">
                </div>

                <!-- Input Keterangan -->
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-700">Catatan / Keterangan Pembayaran</label>
                    <input type="text" name="keterangan_pembayaran" placeholder="Contoh: Transfer BSI, Bayar Cash..." class="w-full text-xs border-gray-200 bg-gray-50 rounded-xl p-3 focus:ring-tema-marun focus:border-tema-marun focus:bg-white transition-all">
                </div>

                <!-- Modal Actions -->
                <div class="pt-4 flex gap-3 border-t border-gray-100">
                    <button type="button" @click="closePaymentModal()" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold py-3 rounded-xl border border-gray-200 transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white text-sm font-bold py-3 rounded-xl shadow-md transition-colors">
                        Simpan Pembayaran
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function kasbonPage() {
    return {
        isModalOpen: false,
        activeKasbon: {},
        
        openPaymentModal(kasbon) {
            this.activeKasbon = kasbon;
            this.isModalOpen = true;
        },
        
        closePaymentModal() {
            this.isModalOpen = false;
            this.activeKasbon = {};
        },

        formatRupiah(value) {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        }
    };
}
</script>

@endsection
