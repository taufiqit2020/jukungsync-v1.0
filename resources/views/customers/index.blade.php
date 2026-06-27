@extends('layouts.admin')
@section('title', 'Data Customer')
@section('content')
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">Data Customer</h1>
            <p style="font-size:0.8rem;color:#6b7280;margin-top:2px;">Kelola daftar pelanggan Anda di sini.</p>
        </div>
        <a href="{{ route('customers.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all"
           style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;white-space:nowrap;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Customer
        </a>
    </div>

    {{-- Filter / Search Card --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-4">
        <form action="{{ route('customers.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-2 max-w-2xl">
            <div class="relative w-full flex-1">
                <div style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#9ca3af;pointer-events:none;" class="flex items-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, telp, email, npwp..." 
                       style="padding-left:42px;padding-right:36px;"
                       class="w-full border border-gray-200 bg-gray-50 rounded-xl py-2.5 text-sm font-medium text-gray-800 focus:bg-white outline-none transition-all" autofocus>
                
                @if(request('search'))
                <a href="{{ route('customers.index') }}" 
                   style="position:absolute;right:12px;top:50%;transform:translateY(-50%);color:#9ca3af;" 
                   class="hover:text-red-600 text-xs font-bold bg-gray-200 hover:bg-gray-300 rounded-full w-5 h-5 flex items-center justify-center transition-colors" title="Bersihkan Pencarian">
                    ✕
                </a>
                @endif
            </div>
            <button type="submit" 
                    style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;" 
                    class="w-full sm:w-auto px-6 py-2.5 text-sm font-bold rounded-xl shadow-sm hover:opacity-90 transition-all whitespace-nowrap flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <span>Cari</span>
            </button>
        </form>
    </div>

    {{-- Table Card --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="background:#1f2937;">
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;" class="w-12">No</th>
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Nama Customer</th>
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;" class="w-28">Tipe</th>
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;" class="w-36">No. Telepon / WA</th>
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;" class="w-40">Email</th>
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;" class="w-36">NPWP</th>
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Alamat</th>
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;" class="w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $index => $customer)
                    <tr class="hover:bg-gray-50/70 transition-colors" style="border-bottom:1px solid #f3f4f6;">
                        <td class="whitespace-nowrap text-sm text-gray-500 text-center" style="padding:12px 16px;">
                            {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                        </td>
                        <td class="whitespace-nowrap text-sm font-semibold" style="padding:12px 16px;">
                            <a href="{{ route('customers.show', $customer->id) }}" style="color:#b91c1c;" class="hover:underline">
                                {{ $customer->nama_klien }}
                            </a>
                        </td>
                        <td class="whitespace-nowrap text-sm" style="padding:12px 16px;">
                            @if($customer->tipe_customer === 'Instansi')
                                <span style="background:#eef2ff;color:#4338ca;border:1px solid #c7d2fe;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                    {{ $customer->tipe_customer }}
                                </span>
                            @else
                                <span style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;font-size:0.7rem;font-weight:700;padding:3px 10px;border-radius:999px;">
                                    {{ $customer->tipe_customer }}
                                </span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap text-sm text-gray-500" style="padding:12px 16px;">{{ $customer->no_telp ?: '-' }}</td>
                        <td class="whitespace-nowrap text-sm text-gray-500 truncate max-w-[150px]" style="padding:12px 16px;" title="{{ $customer->email }}">{{ $customer->email ?: '-' }}</td>
                        <td class="whitespace-nowrap text-sm text-gray-500" style="padding:12px 16px;">{{ $customer->npwp ?: '-' }}</td>
                        <td class="text-sm text-gray-500 truncate max-w-[150px]" style="padding:12px 16px;" title="{{ $customer->alamat }}">{{ $customer->alamat ?: '-' }}</td>
                        <td class="whitespace-nowrap text-center" style="padding:12px 16px;">
                            <div class="flex justify-center gap-1.5">
                                <a href="{{ route('customers.show', $customer->id) }}"
                                   class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold transition-colors shadow-sm"
                                   style="background:#3b82f6;color:white;" title="Lihat Profil">
                                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    Profil
                                </a>
                                <a href="{{ route('customers.edit', $customer->id) }}"
                                   class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold transition-colors shadow-sm"
                                   style="background:#fbbf24;color:#78350f;" title="Edit Customer">
                                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus Customer ini? Histori transaksi customer tidak akan terhapus namun relasinya akan kosong.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2 py-1 rounded text-[10px] font-bold transition-colors shadow-sm"
                                            style="background:#dc2626;color:white;" title="Hapus Customer">
                                        <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-16">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background:#f3f4f6;">
                                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-500">Tidak ada data customer.</p>
                                <p class="text-xs text-gray-400">Mulai tambahkan customer baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($customers->hasPages())
        <div class="px-5 py-4" style="border-top:1px solid #f3f4f6;">
            {{ $customers->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
