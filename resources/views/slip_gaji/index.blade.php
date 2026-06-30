@extends('layouts.admin')

@section('title', 'Slip Gaji Karyawan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Slip Gaji Karyawan</h1>
            <p class="text-sm text-gray-600">Manajemen slip gaji dan pembayaran karyawan</p>
        </div>
        <a href="{{ route('slip-gaji.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium px-4 py-2 rounded-lg inline-flex items-center gap-2 shadow-sm transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Slip Gaji Baru
        </a>
    </div>

    @if(session('success'))
    <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 mb-6 rounded shadow-sm flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">×</button>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <!-- Filter and Search -->
        <div class="p-5 border-b border-gray-100 bg-gray-50 bg-opacity-50">
            <form action="{{ route('slip-gaji.index') }}" method="GET" class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-gray-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama karyawan atau nomor slip..." class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <select name="periode" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Periode</option>
                        @foreach($periodes as $p)
                        <option value="{{ $p }}" {{ request('periode') == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white font-medium px-4 py-2 rounded-lg text-sm transition-all">
                        Filter
                    </button>
                    @if(request()->anyFilled(['search', 'periode']))
                    <a href="{{ route('slip-gaji.index') }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-600 uppercase">
                        <th class="px-6 py-3.5 text-center w-16">No</th>
                        <th class="px-6 py-3.5">Nomor Slip</th>
                        <th class="px-6 py-3.5">Nama Karyawan</th>
                        <th class="px-6 py-3.5">Jabatan</th>
                        <th class="px-6 py-3.5">Periode</th>
                        <th class="px-6 py-3.5 text-right">Gaji Bersih</th>
                        <th class="px-6 py-3.5 text-center w-56">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    @forelse($slipGajis as $index => $slip)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-center text-gray-400 font-medium">{{ $slipGajis->firstItem() + $index }}</td>
                        <td class="px-6 py-4 font-mono font-bold text-gray-800">{{ $slip->nomor_slip }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $slip->nama_karyawan }}</td>
                        <td class="px-6 py-4 text-gray-500">{{ $slip->jabatan ?? '-' }}</td>
                        <td class="px-6 py-4"><span class="bg-indigo-55 bg-indigo-50 text-indigo-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $slip->periode }}</span></td>
                        <td class="px-6 py-4 text-right font-bold text-gray-900">Rp {{ number_format($slip->total_gaji, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('slip-gaji.show', $slip->id) }}" class="text-blue-600 hover:text-blue-800 font-medium px-2 py-1 rounded hover:bg-blue-50 transition-all text-xs" title="Cetak / Tampilkan">
                                    🖨️ Cetak
                                </a>
                                <a href="{{ route('slip-gaji.excel', $slip->id) }}" class="text-emerald-600 hover:text-emerald-800 font-medium px-2 py-1 rounded hover:bg-emerald-50 transition-all text-xs" title="Unduh Excel">
                                    📊 Excel
                                </a>
                                <a href="{{ route('slip-gaji.edit', $slip->id) }}" class="text-amber-600 hover:text-amber-800 font-medium px-2 py-1 rounded hover:bg-amber-50 transition-all text-xs" title="Edit">
                                    📝 Edit
                                </a>
                                <form action="{{ route('slip-gaji.destroy', $slip->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slip gaji ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium px-2 py-1 rounded hover:bg-rose-50 transition-all text-xs" title="Hapus">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="text-base font-semibold text-gray-500">Tidak ada data slip gaji</p>
                            <p class="text-xs text-gray-400 mt-1">Silakan tambahkan data slip gaji karyawan baru.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($slipGajis->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $slipGajis->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
