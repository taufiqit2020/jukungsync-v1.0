@extends('layouts.admin')
@section('title', 'Data Kasbon Customer')
@section('content')

<div class="space-y-6" x-data="kasbonPage()">
    
    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-green-800 text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl flex items-center justify-between shadow-sm">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-red-800 text-sm font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Statistik Panel -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card 1: Piutang Belum Lunas -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-150 p-6 flex items-center justify-between">
            <div class="space-y-2">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Piutang Belum Lunas</p>
                <h3 class="text-2xl font-black text-tema-marun">Rp {{ number_format($totalPiutangBelumLunas, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-gray-500 font-semibold">Akumulasi tagihan kasbon aktif customer</p>
            </div>
            <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center border border-red-100">
                <svg class="w-6 h-6 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
        </div>

        <!-- Card 2: Kasbon Lunas -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-150 p-6 flex items-center justify-between">
            <div class="space-y-2">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Terbayar / Lunas</p>
                <h3 class="text-2xl font-black text-green-600">Rp {{ number_format($totalKasbonLunas, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-gray-500 font-semibold">Total piutang kasbon yang sudah diselesaikan</p>
            </div>
            <div class="w-12 h-12 bg-green-50 rounded-xl flex items-center justify-center border border-green-100">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
            </div>
        </div>

        <!-- Card 3: Total Akumulasi -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-150 p-6 flex items-center justify-between">
            <div class="space-y-2">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Seluruh Piutang</p>
                <h3 class="text-2xl font-black text-gray-800">Rp {{ number_format($totalSeluruhKasbon, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-gray-500 font-semibold">Gabungan kasbon lunas & belum lunas</p>
            </div>
            <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center border border-gray-200">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </div>

    <!-- Filter Panel -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-150 p-5">
        <form method="GET" action="{{ route('kasbons.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
            <!-- Search Input -->
            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-600">Pencarian</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Klien atau No. Invoice..." class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all">
            </div>

            <!-- Status Filter -->
            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-600">Status Pembayaran</label>
                <select name="status" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all">
                    <option value="">Semua Status</option>
                    <option value="belum_lunas" {{ request('status') === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                </select>
            </div>

            <!-- Dari Tanggal -->
            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-600">Dari Tanggal</label>
                <input type="date" name="dari" value="{{ request('dari') }}" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all">
            </div>

            <!-- Sampai Tanggal -->
            <div class="space-y-1">
                <label class="text-xs font-bold text-gray-600">Sampai Tanggal</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all">
            </div>

            <!-- Filter Buttons -->
            <div class="flex gap-2">
                <button type="submit" class="flex-1 bg-tema-hitam hover:bg-black text-tema-kuning text-xs font-bold py-3 rounded-xl transition-all shadow-md text-center">
                    Cari & Filter
                </button>
                @if(request()->anyFilled(['search', 'status', 'dari', 'sampai']))
                <a href="{{ route('kasbons.index') }}" class="px-3 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold py-3 rounded-xl transition-all border border-gray-200 flex items-center justify-center" title="Reset Filter">
                    🔄
                </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-150 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3.5 text-left font-bold text-gray-500 uppercase tracking-wider">No. Invoice</th>
                        <th class="px-6 py-3.5 text-left font-bold text-gray-500 uppercase tracking-wider">Customer / Klien</th>
                        <th class="px-6 py-3.5 text-left font-bold text-gray-500 uppercase tracking-wider">Tgl Kasbon</th>
                        <th class="px-6 py-3.5 text-right font-bold text-gray-500 uppercase tracking-wider">Total Tagihan</th>
                        <th class="px-6 py-3.5 text-right font-bold text-gray-500 uppercase tracking-wider">Sudah Dibayar</th>
                        <th class="px-6 py-3.5 text-right font-bold text-gray-500 uppercase tracking-wider">Sisa Tagihan</th>
                        <th class="px-6 py-3.5 text-center font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-center font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($kasbons as $kasbon)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-800">
                            <!-- Link ke detail pesanan online jika ada -->
                            @if($kasbon->invoice && $kasbon->invoice->jenis_transaksi === 'online')
                                <a href="{{ route('online-orders.show', $kasbon->invoice_id) }}" class="text-tema-marun hover:underline">
                                    {{ $kasbon->nomor_invoice }}
                                </a>
                            @else
                                {{ $kasbon->nomor_invoice }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-800 font-semibold">
                            {{ $kasbon->nama_klien }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">
                            {{ $kasbon->tanggal_kasbon->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right font-semibold text-gray-600">
                            Rp {{ number_format($kasbon->total_tagihan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right font-semibold text-green-600">
                            Rp {{ number_format($kasbon->jumlah_dibayar, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-tema-marun">
                            Rp {{ number_format($kasbon->sisa_tagihan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @if($kasbon->status === 'lunas')
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-green-50 text-green-700 border border-green-200">Lunas</span>
                                <p class="text-[9px] text-gray-400 mt-1 font-semibold">Lunas: {{ $kasbon->tanggal_lunas ? $kasbon->tanggal_lunas->format('d/m/Y') : '-' }}</p>
                            @else
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-red-50 text-red-700 border border-red-200">Belum Lunas</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-xs font-medium">
                            <div class="flex items-center justify-center gap-2">
                                @if($kasbon->status === 'belum_lunas')
                                <button type="button" @click="openPaymentModal({{ json_encode($kasbon) }})" class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-sm transition-colors">
                                    💵 Bayar / Cicil
                                </button>
                                @endif

                                @if(auth()->user()->role === 'superadmin')
                                <form action="{{ route('kasbons.destroy', $kasbon->id) }}" method="POST" onsubmit="return confirm('⚠️ HAPUS DATA KASBON\n\nApakah Anda yakin ingin menghapus data kasbon ini?\nTindakan ini akan mengembalikan status pembayaran invoice terkait.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 border border-red-200 rounded-lg transition-colors" title="Hapus Data">
                                        🗑️
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400 font-semibold italic">
                            Tidak ada data kasbon ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kasbons->hasPages())
        <div class="px-6 py-4 border-t border-gray-150 bg-gray-50/50">
            {{ $kasbons->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Form Pembayaran Kasbon -->
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
                    <div class="flex justify-between border-t border-gray-200 pt-2 font-bold text-sm">
                        <span class="text-tema-marun">Sisa Tagihan:</span>
                        <span class="text-tema-marun" x-text="formatRupiah(activeKasbon.sisa_tagihan)"></span>
                    </div>
                </div>

                <!-- Input Nominal Bayar -->
                <div class="space-y-1">
                    <label class="text-xs font-bold text-gray-700">Jumlah Pembayaran (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_bayar" :max="activeKasbon.sisa_tagihan" min="1" :value="activeKasbon.sisa_tagihan" required class="w-full text-sm border-gray-200 bg-gray-50 rounded-xl p-3 focus:ring-tema-marun focus:border-tema-marun focus:bg-white transition-all font-black text-tema-marun">
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
