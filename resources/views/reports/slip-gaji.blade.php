@extends('layouts.admin')

@section('title', 'Laporan Gaji Karyawan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Laporan Gaji Karyawan</h1>
            <p class="text-xs text-gray-500 mt-1">Rekapitulasi total pengeluaran gaji karyawan per perusahaan dan periode.</p>
        </div>
    </div>

    <!-- Filter & Print Actions -->
    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
        <form action="{{ route('reports.slip-gaji') }}" method="GET" class="flex flex-col lg:flex-row items-end justify-between gap-5">
            <div class="flex flex-col sm:flex-row items-end gap-4 w-full lg:w-auto">
                <div class="w-full sm:w-64">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider mb-1.5">Perusahaan</label>
                    <select name="perusahaan" class="w-full border px-4 py-2.5 bg-gray-50 rounded-xl border-gray-200 focus:bg-white focus:border-red-900 focus:ring-2 focus:ring-red-900/10 outline-none transition-all duration-150 text-sm font-semibold text-gray-700">
                        <option value="">Semua Perusahaan</option>
                        <option value="PT. UTAMA MADANI RAYA" {{ $perusahaan == 'PT. UTAMA MADANI RAYA' ? 'selected' : '' }}>PT. UTAMA MADANI RAYA</option>
                        <option value="PT. NUR MADANI FARMA" {{ $perusahaan == 'PT. NUR MADANI FARMA' ? 'selected' : '' }}>PT. NUR MADANI FARMA</option>
                    </select>
                </div>
                <div class="w-full sm:w-48">
                    <label class="block text-[10px] font-extrabold text-gray-400 uppercase tracking-wider mb-1.5">Periode</label>
                    <select name="periode" class="w-full border px-4 py-2.5 bg-gray-50 rounded-xl border-gray-200 focus:bg-white focus:border-red-900 focus:ring-2 focus:ring-red-900/10 outline-none transition-all duration-150 text-sm font-semibold text-gray-700">
                        <option value="">Semua Periode</option>
                        @foreach($periodes as $p)
                        <option value="{{ $p }}" {{ $periode == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full sm:w-auto bg-slate-900 hover:bg-black text-white px-6 py-2.5 rounded-xl text-xs font-bold shadow-md hover:shadow-lg transition-all duration-150">
                    Filter
                </button>
            </div>
            
            <div class="flex gap-2 w-full lg:w-auto">
                <a href="{{ route('reports.slip-gaji.excel', ['perusahaan' => $perusahaan, 'periode' => $periode]) }}" 
                   class="flex-1 lg:flex-none inline-flex justify-center items-center px-5 py-2.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-black rounded-xl hover:bg-emerald-100/70 hover:scale-[1.02] active:scale-[0.98] transition-all duration-150">
                    📊 Export Excel
                </a>
                <a href="{{ route('reports.slip-gaji.print', ['perusahaan' => $perusahaan, 'periode' => $periode]) }}" target="_blank" 
                   class="flex-1 lg:flex-none inline-flex justify-center items-center px-5 py-2.5 text-xs font-black rounded-xl hover:opacity-90 hover:scale-[1.02] active:scale-[0.98] transition-all duration-150 text-white shadow-md"
                   style="background: linear-gradient(135deg, #7f1d1d, #b91c1c);">
                    🖨️ Cetak Laporan
                </a>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Card 1: Pendapatan Kotor -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex justify-between items-center hover:border-blue-200 transition-all duration-200">
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 mb-1">Total Pendapatan (Kotor)</p>
                <h3 class="text-xl font-black text-gray-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-gray-400 font-semibold mt-1">Akumulasi Pendapatan (A)</p>
            </div>
            <div class="p-3.5 bg-blue-50 text-blue-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            </div>
        </div>

        <!-- Card 2: Total Potongan -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex justify-between items-center hover:border-rose-200 transition-all duration-200">
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-wider text-gray-400 mb-1">Total Potongan (BPJS)</p>
                <h3 class="text-xl font-black text-rose-600">Rp {{ number_format($totalPotongan, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-gray-400 font-semibold mt-1">Akumulasi Potongan (B)</p>
            </div>
            <div class="p-3.5 bg-rose-50 text-rose-600 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
            </div>
        </div>

        <!-- Card 3: Total Gaji Bersih -->
        <div class="bg-emerald-50/30 p-5 rounded-2xl border border-emerald-100 shadow-sm flex justify-between items-center hover:border-emerald-250 transition-all duration-200">
            <div>
                <p class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-800 mb-1">Total Gaji Bersih (A - B)</p>
                <h3 class="text-xl font-black text-emerald-700">Rp {{ number_format($totalGaji, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-emerald-600 font-semibold mt-1">Total Pengeluaran Bersih</p>
            </div>
            <div class="p-3.5 bg-emerald-100 text-emerald-700 rounded-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead class="bg-slate-50 border-b border-gray-100 text-[10px] uppercase font-extrabold text-slate-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-14 text-center">No</th>
                        <th class="px-6 py-4 w-48">Nomor Slip</th>
                        <th class="px-6 py-4 w-56">Perusahaan</th>
                        <th class="px-6 py-4">Nama Karyawan</th>
                        <th class="px-6 py-4">Jabatan</th>
                        <th class="px-6 py-4 text-center w-28">Periode</th>
                        <th class="px-6 py-4 text-right w-36">Pendapatan (A)</th>
                        <th class="px-6 py-4 text-right w-36">Potongan (B)</th>
                        <th class="px-6 py-4 text-right w-40">Gaji Bersih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-700">
                    @forelse($slipGajis as $idx => $slip)
                    @php
                        $gapok = $slip->gaji_pokok;
                        $lembur = $slip->lembur;
                        $tunjangan = $slip->tunjangan_bonus;
                        $bpjsKes = $slip->bpjs_kesehatan;
                        $bpjsKet = $slip->bpjs_ketenagakerjaan;
                        
                        $pendapatan = $gapok + $lembur + $tunjangan;
                        $potongan = $bpjsKes + $bpjsKet;
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-all duration-150">
                        <td class="px-6 py-4 text-center font-bold text-gray-400 text-xs">{{ $idx + 1 }}</td>
                        <td class="px-6 py-4 font-mono text-xs font-black text-gray-900">{{ $slip->nomor_slip }}</td>
                        <td class="px-6 py-4">
                            @if(isset($slip->perusahaan) && $slip->perusahaan === 'PT. NUR MADANI FARMA')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    PT. NUR MADANI FARMA
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    PT. UTAMA MADANI RAYA
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-gray-900">{{ $slip->nama_karyawan }}</td>
                        <td class="px-6 py-4 text-xs text-gray-500 font-medium">{{ $slip->jabatan ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex px-2.5 py-0.5 text-[9px] font-bold uppercase rounded bg-blue-50 text-blue-700 border border-blue-150">
                                {{ $slip->periode }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-gray-900 whitespace-nowrap">
                            Rp {{ number_format($pendapatan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right font-semibold text-rose-600 whitespace-nowrap">
                            Rp {{ number_format($potongan, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right font-black text-emerald-600 whitespace-nowrap">
                            Rp {{ number_format($slip->total_gaji, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-355" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-sm font-bold text-slate-500">Belum ada data slip gaji pada kriteria filter ini.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
