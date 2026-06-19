@extends('layouts.admin')
@section('title', 'Profil Customer: ' . $customer->nama_klien)
@section('content')

<div class="space-y-6">
    <!-- Back Button & Title -->
    <div class="flex items-center gap-3">
        <a href="{{ route('customers.index') }}" class="inline-flex items-center justify-center p-2 rounded-lg bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="font-heading text-2xl font-bold text-gray-900">Profil Customer</h1>
            <p class="text-xs text-gray-500">Detail data dan histori transaksi customer.</p>
        </div>
    </div>

    <!-- Main Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Panel: Profile Card & Information -->
        <div class="lg:col-span-1 space-y-6">
            
            <!-- Customer Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-tema-kuning/5 to-transparent rounded-full -mr-8 -mt-8"></div>
                
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-tema-hitam to-gray-800 text-white flex items-center justify-center text-xl font-bold shadow-md mb-4 border-2 border-white">
                        {{ strtoupper(substr($customer->nama_klien, 0, 1)) }}
                    </div>
                    <h2 class="font-heading text-lg font-bold text-gray-900 mb-1">{{ $customer->nama_klien }}</h2>
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full uppercase tracking-wider {{ $customer->tipe_customer === 'Instansi' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-green-50 text-green-700 border border-green-100' }}">
                        {{ $customer->tipe_customer }}
                    </span>
                </div>

                <div class="border-t border-gray-100 mt-6 pt-6 space-y-4">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">No. Telepon / WA</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $customer->no_telp ?: 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Email</p>
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $customer->email ?: 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">NPWP</p>
                        <p class="text-sm font-semibold text-gray-800">{{ $customer->npwp ?: 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Alamat</p>
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $customer->alamat ?: 'Tidak ada' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Keterangan</p>
                        <p class="text-xs text-gray-500 italic">{{ $customer->keterangan ?: 'Tidak ada catatan khusus.' }}</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-2 border-t border-gray-100 pt-4">
                    <a href="{{ route('customers.edit', $customer->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-400 text-yellow-900 hover:bg-yellow-500 rounded-md text-xs font-bold transition-colors shadow-sm">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Profil
                    </a>
                </div>
            </div>
            
            <!-- Summary Stats -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 relative overflow-hidden">
                    <div class="p-2 bg-emerald-50 text-emerald-500 rounded-lg w-fit mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Total Transaksi</p>
                    <p class="text-base font-extrabold text-gray-900">Rp {{ number_format($totalTransaksi, 0, ',', '.') }}</p>
                </div>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 relative overflow-hidden">
                    <div class="p-2 bg-red-50 text-red-500 rounded-lg w-fit mb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">Outstanding</p>
                    <p class="text-base font-extrabold text-red-600">Rp {{ number_format($totalOutstanding, 0, ',', '.') }}</p>
                </div>
            </div>

        </div>

        <!-- Right Panel: Invoice History -->
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="font-heading text-base font-bold text-gray-800">🧾 Histori Invoice</h3>
                    <span class="ml-auto text-xs font-bold bg-gray-100 text-gray-600 px-2.5 py-1 rounded-full">{{ $invoices->count() }} Invoice</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No. Invoice</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Total Tagihan</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($invoices as $inv)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ $inv->nomor_invoice }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $inv->tanggal_invoice ? $inv->tanggal_invoice->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $inv->tanggal_jatuh_tempo ? $inv->tanggal_jatuh_tempo->format('d M Y') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">
                                    Rp {{ number_format($inv->total_tagihan, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full {{ $inv->status_pembayaran === 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $inv->status_pembayaran === 'lunas' ? 'Lunas' : 'Belum Lunas' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <a href="{{ route('invoices.show', $inv->id) }}" class="inline-flex items-center px-2.5 py-1 bg-tema-marun text-white hover:bg-red-900 rounded text-xs font-bold transition-colors shadow-sm">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-400 italic">
                                    Customer ini belum pernah memiliki histori transaksi invoice.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</div>

@endsection
