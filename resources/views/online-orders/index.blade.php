@extends('layouts.admin')
@section('title', 'Pesanan Online Masuk')
@section('content')

<div class="bg-white shadow rounded-lg p-6">
    @if(session('success'))
        <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-md flex items-center justify-between">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span class="text-green-800 text-sm font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded-md flex items-center justify-between">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="text-red-800 text-sm font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-bold text-gray-800">Daftar Pesanan dari E-Catalog</h3>
    </div>

    <div class="overflow-x-auto border border-gray-200 rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-tema-hitam text-white">
                <tr>
                    <th class="px-6 py-3 text-left font-bold uppercase tracking-wider text-xs">Tanggal</th>
                    <th class="px-6 py-3 text-left font-bold uppercase tracking-wider text-xs">No. Pesanan</th>
                    <th class="px-6 py-3 text-left font-bold uppercase tracking-wider text-xs">Pemesan</th>
                    <th class="px-6 py-3 text-right font-bold uppercase tracking-wider text-xs">Total Tagihan</th>
                    <th class="px-6 py-3 text-center font-bold uppercase tracking-wider text-xs">Status</th>
                    <th class="px-6 py-3 text-center font-bold uppercase tracking-wider text-xs">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50 transition-colors {{ $order->status_pesanan === 'menunggu_konfirmasi' ? 'bg-yellow-50/30' : '' }}">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                        {{ \Carbon\Carbon::parse($order->tanggal_invoice)->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-bold text-tema-hitam">{{ $order->nomor_invoice }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="font-semibold text-gray-800">{{ $order->nama_klien }}</p>
                        <p class="text-[11px] text-gray-500 truncate max-w-[200px]">{{ $order->catatan }}</p>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right font-black text-tema-marun">
                        Rp {{ number_format($order->total_tagihan, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if($order->status_pesanan === 'menunggu_konfirmasi')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200">Menunggu Konfirmasi</span>
                        @elseif($order->status_pesanan === 'diproses')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-800 border border-blue-200">Diproses</span>
                        @elseif($order->status_pesanan === 'selesai')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200">Selesai</span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200">Dibatalkan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center flex items-center justify-center gap-1.5">
                        <a href="{{ route('online-orders.show', $order->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-yellow-100 text-yellow-800 hover:bg-yellow-200 rounded text-xs font-bold transition-colors shadow-sm" title="Lihat Detail">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Lihat Detail
                        </a>
                        @if(auth()->user()->role === 'superadmin')
                        <a href="{{ route('invoices.edit', $order->id) }}?from=online-orders" class="inline-flex items-center px-2.5 py-1.5 bg-blue-100 text-blue-800 hover:bg-blue-200 rounded text-xs font-bold transition-colors shadow-sm" title="Edit">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </a>
                        <form action="{{ route('invoices.destroy', $order->id) }}?from=online-orders" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus permanen pesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-red-100 text-red-800 hover:bg-red-200 rounded text-xs font-bold transition-colors shadow-sm" title="Hapus">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                        Tidak ada pesanan online.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>

@endsection
