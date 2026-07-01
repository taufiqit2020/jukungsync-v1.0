@extends('layouts.admin')

@section('title', 'Slip Gaji Karyawan')

@section('content')
<div class="space-y-6">

    {{-- ===== ALERTS ===== --}}
    @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 rounded-xl flex items-center gap-3 px-5 py-4 shadow-sm">
        <svg class="w-5 h-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span class="text-sm font-semibold text-emerald-800">{{ session('success') }}</span>
    </div>
    @endif

    @php
        // Fetch active database statistics dynamically
        $currentMonth = date('m');
        $currentYear = date('Y');
        $currentMonthName = \Carbon\Carbon::now()->translatedFormat('F Y');
        
        $totalGajiBulanIni = \App\Models\SlipGaji::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->sum('total_gaji');
            
        $totalSlipsBulanIni = \App\Models\SlipGaji::whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();
            
        $slipsUmar = \App\Models\SlipGaji::where('perusahaan', 'PT. UTAMA MADANI RAYA')->count();
        $slipsFarma = \App\Models\SlipGaji::where('perusahaan', 'PT. NUR MADANI FARMA')->count();
    @endphp

    {{-- ===== DASHBOARD STATISTICS CARD GRID ===== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Stat 1: Total Gaji Bulan Ini -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-200">
            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider leading-none mb-1">Gaji Bulan Ini</p>
                <h3 class="text-lg font-black text-gray-900">Rp {{ number_format($totalGajiBulanIni, 0, ',', '.') }}</h3>
                <p class="text-[10px] text-gray-500 font-medium mt-0.5">{{ $currentMonthName }}</p>
            </div>
        </div>

        <!-- Stat 2: Total Slip Bulan Ini -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-200">
            <div class="p-3.5 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider leading-none mb-1">Total Penerima</p>
                <h3 class="text-lg font-black text-gray-900">{{ $totalSlipsBulanIni }} Karyawan</h3>
                <p class="text-[10px] text-gray-500 font-medium mt-0.5">Bulan ini</p>
            </div>
        </div>

        <!-- Stat 3: Total Slip UMAR -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-200">
            <div class="p-3.5 bg-slate-100 text-slate-700 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider leading-none mb-1">PT. UTAMA MADANI RAYA</p>
                <h3 class="text-lg font-black text-gray-900">{{ $slipsUmar }} Slip</h3>
                <p class="text-[10px] text-gray-500 font-medium mt-0.5">Total Keseluruhan</p>
            </div>
        </div>

        <!-- Stat 4: Total Slip Farma -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center gap-4 hover:shadow-md transition-all duration-200">
            <div class="p-3.5 bg-teal-50 text-teal-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <div>
                <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider leading-none mb-1">PT. NUR MADANI FARMA</p>
                <h3 class="text-lg font-black text-gray-900">{{ $slipsFarma }} Slip</h3>
                <p class="text-[10px] text-gray-500 font-medium mt-0.5">Total Keseluruhan</p>
            </div>
        </div>
    </div>

    {{-- ===== PAGE HEADER ===== --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-gray-900 tracking-tight">Slip Gaji Karyawan</h1>
            <p class="text-xs text-gray-500 mt-1">Kelola pencatatan slip gaji, tunjangan, potongan BPJS, dan cetak slip pembayaran.</p>
        </div>
        <a href="{{ route('slip-gaji.create') }}"
           class="flex items-center gap-2 px-5 py-3 text-xs font-bold rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 text-white"
           style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Buat Slip Gaji Baru
        </a>
    </div>

    {{-- ===== FILTER CARD ===== --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
        <form action="{{ route('slip-gaji.index') }}" method="GET" class="flex flex-col md:flex-row items-end gap-4">
            <div class="w-full md:flex-1">
                <label class="block mb-1.5 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Cari Karyawan / No. Slip</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama karyawan atau nomor slip..."
                       class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-red-900 focus:ring-2 focus:ring-red-900/10 outline-none transition-all duration-150">
            </div>
            <div class="w-full md:w-1/4">
                <label class="block mb-1.5 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Periode</label>
                <select name="periode"
                        class="w-full border border-gray-200 bg-gray-50 rounded-xl px-4 py-2.5 text-sm focus:bg-white focus:border-red-900 outline-none transition-all duration-150 font-semibold">
                    <option value="">Semua Periode</option>
                    @foreach($periodes as $p)
                    <option value="{{ $p }}" {{ request('periode') == $p ? 'selected' : '' }}>{{ $p }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit"
                        class="flex-1 md:flex-initial flex items-center justify-center gap-2 px-6 py-2.5 text-xs font-bold rounded-xl shadow-md hover:opacity-90 transition-all duration-150 text-white"
                        style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);">
                    Filter
                </button>
                <a href="{{ route('slip-gaji.index') }}"
                   class="flex-1 md:flex-initial flex items-center justify-center px-5 py-2.5 text-xs font-bold rounded-xl bg-gray-50 border border-gray-200 text-gray-700 hover:bg-gray-100 transition-all duration-150">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- ===== TABLE CARD ===== --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-100">
                        <th class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider px-6 py-4 text-center w-14">No</th>
                        <th class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider px-6 py-4 w-48">Nomor Slip</th>
                        <th class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider px-6 py-4 w-56">Perusahaan</th>
                        <th class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider px-6 py-4">Nama Karyawan</th>
                        <th class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider px-6 py-4">Jabatan</th>
                        <th class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider px-6 py-4 text-center w-28">Periode</th>
                        <th class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider px-6 py-4 text-right w-36">Gaji Bersih</th>
                        <th class="text-[10px] font-extrabold text-slate-500 uppercase tracking-wider px-6 py-4 text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-700">
                    @forelse($slipGajis as $idx => $slip)
                    <tr class="hover:bg-slate-50/70 transition-all duration-150">
                        <td class="px-6 py-4 text-center font-bold text-gray-400 text-xs">
                            {{ $slipGajis->firstItem() + $idx }}
                        </td>
                        <td class="px-6 py-4 font-mono text-xs font-black text-gray-900">
                            {{ $slip->nomor_slip }}
                        </td>
                        <td class="px-6 py-4">
                            @if(isset($slip->perusahaan) && $slip->perusahaan === 'PT. NUR MADANI FARMA')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    PT. NUR MADANI FARMA
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    PT. UTAMA MADANI RAYA
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-gray-900">
                            {{ $slip->nama_karyawan }}
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500 font-medium">
                            {{ $slip->jabatan ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex px-2.5 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded bg-blue-50 text-blue-700 border border-blue-150">
                                {{ $slip->periode }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-black text-emerald-600 text-xs">
                            Rp {{ number_format($slip->total_gaji, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('slip-gaji.show', $slip->id) }}"
                                   class="p-2 rounded-xl transition-all duration-150 bg-amber-50 text-amber-600 border border-amber-200 hover:bg-amber-100/70 hover:scale-105"
                                   title="Cetak / Tampilkan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                </a>
                                <a href="{{ route('slip-gaji.excel', $slip->id) }}"
                                   class="p-2 rounded-xl transition-all duration-150 bg-emerald-50 text-emerald-600 border border-emerald-200 hover:bg-emerald-100/70 hover:scale-105"
                                   title="Unduh Excel">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </a>
                                <a href="{{ route('slip-gaji.edit', $slip->id) }}"
                                   class="p-2 rounded-xl transition-all duration-150 bg-blue-50 text-blue-600 border border-blue-200 hover:bg-blue-100/70 hover:scale-105"
                                   title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form action="{{ route('slip-gaji.destroy', $slip->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data slip gaji ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-xl transition-all duration-150 bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-100/70 hover:scale-105"
                                            title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <svg class="w-12 h-12 mx-auto mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 12H4M8 16l-4-4 4-4m8 8l4-4-4-4"/></svg>
                            <p class="text-sm text-slate-500 font-bold">Belum ada data slip gaji karyawan.</p>
                            <p class="text-xs text-slate-350 mt-1">Klik "Buat Slip Gaji Baru" untuk menambahkan.</p>
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
