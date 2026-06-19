@extends('layouts.admin')

@section('title', 'Laporan Tagihan Jatuh Tempo')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <svg class="w-7 h-7 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        Laporan Tagihan Jatuh Tempo
    </h2>
    <p class="text-sm text-gray-500 mt-1">Daftar tagihan yang belum dilunasi, diurutkan berdasarkan sisa waktu jatuh tempo terdekat.</p>
</div>

<!-- Header Card: Actions -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
    <div class="flex justify-between items-center">
        <div>
            <p class="text-sm font-semibold text-gray-600">Total Tagihan Belum Lunas: <span class="text-red-600">Rp {{ number_format($invoices->sum('total_tagihan'), 0, ',', '.') }}</span></p>
        </div>
        <!-- Action Buttons -->
        <div class="flex items-center gap-2">
            <a href="{{ route('reports.jatuh-tempo.print') }}" target="_blank" class="bg-gradient-to-r from-tema-marun to-red-800 hover:from-red-800 hover:to-red-900 text-white font-bold py-2 px-5 rounded-xl transition-all shadow-sm text-sm flex items-center gap-2 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Cetak Laporan
            </a>
        </div>
    </div>
</div>

<!-- Table Data -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider">Tgl Invoice</th>
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider">No. Invoice</th>
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider">Klien</th>
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider">Status Waktu</th>
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider text-right">Total Tagihan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($invoices as $inv)
                @php
                    $jatuhTempo = \Carbon\Carbon::parse($inv->tanggal_jatuh_tempo);
                    $now = \Carbon\Carbon::now();
                    $diffDays = $now->startOfDay()->diffInDays($jatuhTempo->startOfDay(), false);
                @endphp
                <tr class="hover:bg-amber-50 transition-colors group">
                    <td class="px-5 py-3.5 whitespace-nowrap text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($inv->tanggal_invoice)->format('d/m/Y') }}
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="font-bold text-gray-900 text-sm">{{ $inv->nomor_invoice }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-700 font-medium">
                        {{ $inv->nama_klien }}
                    </td>
                    <td class="px-5 py-3.5 whitespace-nowrap text-sm font-semibold text-gray-800">
                        {{ $jatuhTempo->format('d/m/Y') }}
                    </td>
                    <td class="px-5 py-3.5">
                        @if($diffDays < 0)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800">Lewat {{ abs($diffDays) }} hari</span>
                        @elseif($diffDays <= 7)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800">Sisa {{ $diffDays }} hari</span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-gray-100 text-gray-600">Sisa {{ $diffDays }} hari</span>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-right font-bold text-red-600">
                        Rp {{ number_format($inv->total_tagihan, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-400">Luar biasa! Tidak ada tagihan yang belum lunas.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
