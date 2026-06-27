@extends('layouts.admin')
@section('title', 'Data Merk')
@section('content')
<div class="space-y-6">
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 style="font-size:1.5rem;font-weight:900;color:#1f2937;margin:0;">Data Merk Barang</h1>
            <p style="font-size:0.8rem;color:#6b7280;margin-top:2px;">Kelola daftar merk produk dan brand barang</p>
        </div>
        <a href="{{ route('merks.create') }}" 
           style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;" 
           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah Merk Baru
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;" class="flex items-center gap-3 px-5 py-3.5 shadow-sm">
        <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <span class="text-sm font-semibold text-green-800">{{ session('success') }}</span>
    </div>
    @endif

    {{-- Table Card --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr style="background:#1f2937;">
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-center w-16">No</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">Nama Merk</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">Slug</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($merks as $index => $merk)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="px-4 py-3.5 text-xs font-bold text-gray-400 text-center">
                            {{ $merks->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3.5 text-sm font-bold text-gray-800">
                            {{ $merk->nama_merk }}
                        </td>
                        <td class="px-4 py-3.5 text-xs font-mono text-gray-500">
                            {{ $merk->slug }}
                        </td>
                        <td class="px-4 py-3.5 text-center text-xs font-medium">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('merks.edit', $merk->id) }}" 
                                   style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition-all hover:opacity-80" title="Edit Merk">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('merks.destroy', $merk->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus Merk ini? Produk terkait akan menjadi tanpa merk.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            style="background:#fff5f5;color:#b91c1c;border:1px solid #fecaca;" 
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition-all hover:bg-red-100" title="Hapus Merk">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-400 font-semibold italic">
                            Belum ada data merk barang.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($merks->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $merks->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

