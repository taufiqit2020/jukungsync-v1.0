@extends('layouts.admin')

@section('title', 'Laporan Bukti Claim Invoice')

@section('content')
<div class="mb-8">
    <h2 class="text-2xl font-black text-gray-800 tracking-tight flex items-center gap-2">
        <svg class="w-7 h-7 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Laporan Bukti Claim Invoice
    </h2>
    <p class="text-sm text-gray-500 mt-1">Laporan semua invoice yang memiliki lampiran bukti klaim/pembayaran.</p>
</div>

<!-- Header Card: Filter & Actions -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 mb-6">
    <div class="flex flex-col md:flex-row justify-between gap-4">
        <!-- Filter Form -->
        <form action="{{ route('reports.bukti-invoices') }}" method="GET" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded-xl border border-gray-200 focus-within:ring-2 focus-within:ring-tema-marun focus-within:border-transparent transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <input type="date" name="start_date" value="{{ $startDate }}" class="bg-transparent border-none text-sm font-semibold text-gray-700 focus:ring-0 p-0" required>
            </div>
            <span class="text-gray-400 font-medium text-sm">s/d</span>
            <div class="flex items-center gap-2 bg-gray-50 px-3 py-2 rounded-xl border border-gray-200 focus-within:ring-2 focus-within:ring-tema-marun focus-within:border-transparent transition-all">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <input type="date" name="end_date" value="{{ $endDate }}" class="bg-transparent border-none text-sm font-semibold text-gray-700 focus:ring-0 p-0" required>
            </div>
            <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-bold py-2 px-5 rounded-xl transition-all shadow-sm flex items-center gap-2 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                Filter
            </button>
        </form>

        <!-- Action Buttons -->
        <div class="flex items-center gap-2 w-full md:w-auto">
            <a href="{{ route('reports.bukti-invoices.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="flex-1 md:flex-none bg-gradient-to-r from-tema-marun to-red-800 hover:from-red-800 hover:to-red-900 text-white font-bold py-2 px-5 rounded-xl transition-all shadow-sm text-sm flex items-center justify-center gap-2 hover:-translate-y-0.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
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
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider">No. Invoice</th>
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider">Klien</th>
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider">File Bukti</th>
                    <th class="px-5 py-3.5 text-xs font-bold text-gray-500 uppercase tracking-wider">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($invoices as $inv)
                <tr class="hover:bg-amber-50 transition-colors group">
                    <td class="px-5 py-3.5 whitespace-nowrap text-sm text-gray-600 font-medium">
                        {{ \Carbon\Carbon::parse($inv->tanggal_invoice)->format('d M Y') }}
                    </td>
                    <td class="px-5 py-3.5">
                        <span class="font-bold text-gray-900 text-sm">{{ $inv->nomor_invoice }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-gray-700 font-medium">
                        {{ $inv->nama_klien }}
                    </td>
                    <td class="px-5 py-3.5">
                        <a href="{{ Storage::url($inv->bukti_file) }}" target="_blank" class="inline-flex items-center px-2.5 py-1.5 bg-purple-100 text-purple-800 hover:bg-purple-200 rounded text-xs font-bold transition-colors">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Lihat File
                        </a>
                    </td>
                    <td class="px-5 py-3.5 text-sm text-gray-600">
                        {{ $inv->bukti_keterangan ?: '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-sm font-semibold text-gray-400">Tidak ada bukti claim invoice pada periode ini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($invoices->hasPages())
    <div class="px-5 py-4 border-t border-gray-100">
        {{ $invoices->links() }}
    </div>
    @endif
</div>
@endsection
