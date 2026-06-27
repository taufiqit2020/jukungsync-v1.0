@extends('layouts.admin')
@section('title', 'Data Kategori')
@section('content')
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">Data Kategori</h1>
            <p style="font-size:0.8rem;color:#6b7280;margin-top:2px;">Kelola kategori produk Anda di sini.</p>
        </div>
        <a href="{{ route('categories.create') }}"
           class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all"
           style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;white-space:nowrap;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kategori
        </a>
    </div>

    {{-- Table Card --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="background:#1f2937;">
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;" class="w-16">No</th>
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Nama Kategori</th>
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Slug</th>
                        <th scope="col" style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:right;letter-spacing:0.05em;" class="w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    <tr class="hover:bg-gray-50/70 transition-colors" style="border-bottom:1px solid #f3f4f6;">
                        <td class="whitespace-nowrap text-sm text-gray-500" style="padding:12px 16px;">{{ $categories->firstItem() + $index }}</td>
                        <td class="whitespace-nowrap text-sm font-semibold text-gray-800" style="padding:12px 16px;">{{ $category->nama_kategori }}</td>
                        <td class="whitespace-nowrap text-sm text-gray-500" style="padding:12px 16px;">
                            <span style="background:#f3f4f6;color:#6b7280;font-size:0.7rem;font-weight:600;padding:2px 8px;border-radius:6px;font-family:monospace;">{{ $category->slug }}</span>
                        </td>
                        <td class="whitespace-nowrap text-right" style="padding:12px 16px;">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('categories.edit', $category->id) }}"
                                   class="inline-flex items-center px-2.5 py-1.5 rounded text-xs font-bold transition-colors shadow-sm"
                                   style="background:#fbbf24;color:#78350f;" title="Edit Kategori">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-2.5 py-1.5 rounded text-xs font-bold transition-colors shadow-sm"
                                            style="background:#dc2626;color:white;" title="Hapus Kategori">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        <td colspan="4" class="text-center py-16">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background:#f3f4f6;">
                                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-500">Tidak ada data kategori.</p>
                                <p class="text-xs text-gray-400">Mulai tambahkan kategori baru.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
        <div class="px-5 py-4" style="border-top:1px solid #f3f4f6;">
            {{ $categories->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
