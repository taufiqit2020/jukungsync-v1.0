@extends('layouts.admin')
@section('title', 'Data Barang')
@section('content')
<div class="space-y-6" x-data="{ isImageModalOpen: false, modalImageUrl: '', modalImageAlt: '' }">
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 style="font-size:1.5rem;font-weight:900;color:#1f2937;margin:0;">Data Barang (Stok)</h1>
            <p style="font-size:0.8rem;color:#6b7280;margin-top:2px;">Kelola inventaris produk, harga jual, dan stok barang</p>
        </div>
        <a href="{{ route('products.create') }}" 
           style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;" 
           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Tambah Barang Baru
        </a>
    </div>

    {{-- Filter Card --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="p-4">
        <form action="{{ route('products.index') }}" method="GET" class="relative" x-data="{ search: '{{ addslashes(request('search')) }}' }">
            <div class="relative">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
                <input type="text" name="search" x-model="search" placeholder="Ketik Kode SKU / Nama Barang..." 
                       @input.debounce.500ms="$el.closest('form').submit()"
                       class="w-full pl-10 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-800 focus:bg-white outline-none transition-all" autofocus>
                
                <div class="absolute right-3 top-1/2 -translate-y-1/2" x-show="search.length > 0" style="display: none;">
                    <button type="button" @click="search = ''; $nextTick(() => $el.closest('form').submit())" class="text-gray-400 hover:text-red-500 transition-colors text-xs font-bold bg-gray-200 rounded-full w-5 h-5 flex items-center justify-center">
                        ✕
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Table Card --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead>
                    <tr style="background:#1f2937;">
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-center w-12">No</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-center w-16">Foto</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">SKU</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">Nama Barang</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">Satuan</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">Kategori</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-left">Merk</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-right">Harga Jual</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-right">Grosir</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-center w-20">Stok</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;letter-spacing:0.05em;" class="text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50/70 transition-colors">
                        <td class="px-4 py-3.5 text-xs font-bold text-gray-400 text-center">
                            {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-4 py-3.5 text-center">
                            @php
                                $imgUrl = $product->gambar ? Storage::url($product->gambar) : Storage::url('products/umum.png');
                                $extraCount = is_array($product->gambar_tambahan) ? count($product->gambar_tambahan) : 0;
                            @endphp
                            <div class="relative w-10 h-10 mx-auto">
                                <img src="{{ $imgUrl }}" alt="{{ $product->nama_barang }}" 
                                     class="h-10 w-10 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-80 hover:scale-105 transition-all shadow-sm"
                                     @click="isImageModalOpen = true; modalImageUrl = '{{ $imgUrl }}'; modalImageAlt = '{{ addslashes($product->nama_barang) }}'">
                                @if($extraCount > 0)
                                    <span style="background:#7f1d1d;color:white;border:1px solid white;" class="absolute -top-1.5 -right-1.5 text-[8px] font-black rounded-full w-4 h-4 flex items-center justify-center shadow-sm" title="Ada {{ $extraCount }} foto tambahan">
                                        +{{ $extraCount }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3.5 text-xs font-mono font-bold text-gray-700 whitespace-nowrap">
                            <span style="background:#f3f4f6;color:#374151;border:1px solid #e5e7eb;" class="px-2 py-1 rounded-md">
                                {{ $product->sku }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-sm font-bold text-gray-800 truncate max-w-[200px]" title="{{ $product->nama_barang }}">
                            {{ $product->nama_barang }}
                        </td>
                        <td class="px-4 py-3.5 text-xs text-gray-500 font-medium">
                            {{ $product->satuan ?? '-' }}
                        </td>
                        <td class="px-4 py-3.5 text-xs text-gray-600 font-medium">
                            {{ $product->category->nama_kategori ?? '-' }}
                        </td>
                        <td class="px-4 py-3.5 text-xs text-gray-600 font-medium">
                            {{ $product->merk->nama_merk ?? '-' }}
                        </td>
                        <td class="px-4 py-3.5 text-sm font-bold text-gray-900 text-right whitespace-nowrap">
                            Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-3.5 text-sm font-bold text-right whitespace-nowrap" style="color:#7f1d1d;">
                            {{ $product->harga_grosir > 0 ? 'Rp ' . number_format($product->harga_grosir, 0, ',', '.') : '-' }}
                        </td>
                        <td class="px-4 py-3.5 text-center whitespace-nowrap">
                            @php
                                $isStockOk = $product->stok_saat_ini > ($product->stok_minimum ?? 5);
                            @endphp
                            <span style="{{ $isStockOk ? 'background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;' : 'background:#fff5f5;color:#b91c1c;border:1px solid #fecaca;' }}"
                                  class="px-2.5 py-1 text-xs font-bold rounded-full inline-block">
                                {{ $product->stok_saat_ini }}
                            </span>
                        </td>
                        <td class="px-4 py-3.5 text-center text-xs font-medium">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('products.edit', $product->id) }}" 
                                   style="background:#fef3c7;color:#92400e;border:1px solid #fde68a;" 
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all hover:opacity-80" title="Edit Barang">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            style="background:#fff5f5;color:#b91c1c;border:1px solid #fecaca;" 
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold transition-all hover:bg-red-100" title="Hapus Barang">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-6 py-12 text-center text-gray-400 font-semibold italic">
                            Belum ada data barang.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
        <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $products->links() }}
        </div>
        @endif
    </div>

    <!-- Modal Preview Gambar -->
    <div x-cloak x-show="isImageModalOpen" class="fixed inset-0 z-[100] flex items-center justify-center bg-gray-900 bg-opacity-75 backdrop-blur-sm p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         style="display: none;">
         
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-xs w-full flex flex-col overflow-hidden" @click.away="isImageModalOpen = false">
            <div class="flex items-center justify-between p-3.5 border-b border-gray-100 bg-gray-50 flex-shrink-0">
                <h3 class="text-xs font-bold text-gray-800 truncate pr-2" x-text="modalImageAlt"></h3>
                <button @click="isImageModalOpen = false" type="button" class="text-gray-400 hover:text-red-600 font-bold text-base">✕</button>
            </div>
            <div class="p-4 flex items-center justify-center bg-white">
                <img :src="modalImageUrl" :alt="modalImageAlt" class="max-w-full max-h-60 object-contain rounded-xl shadow-sm border border-gray-100">
            </div>
        </div>
    </div>
</div>
@endsection

