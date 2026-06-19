@extends('layouts.admin')
@section('title', 'Data Barang')
@section('content')
<div class="bg-white shadow rounded-lg p-6" x-data="{ isImageModalOpen: false, modalImageUrl: '', modalImageAlt: '' }">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Barang</h2>
        
        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <form action="{{ route('products.index') }}" method="GET" class="flex-1 md:w-80 relative" x-data="{ search: '{{ addslashes(request('search')) }}' }">
                <input type="text" name="search" x-model="search" placeholder="Ketik Kode / Nama Barang..." 
                       @input.debounce.500ms="$el.closest('form').submit()"
                       class="w-full pl-10 pr-10 py-2 rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 border text-sm" autofocus>
                
                <!-- Ikon Pencarian (Kiri) -->
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>

                <!-- Tombol Silang Hapus (Kanan) -->
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center" x-show="search.length > 0" style="display: none;">
                    <button type="button" @click="search = ''; $nextTick(() => $el.closest('form').submit())" class="text-gray-400 hover:text-red-500 focus:outline-none transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </form>
            
            <a href="{{ route('products.create') }}" class="bg-tema-marun hover:bg-red-900 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm flex-shrink-0">
                + Tambah Barang
            </a>
        </div>
    </div>

    <div class="overflow-x-auto rounded-md border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-tema-hitam">
                <tr>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-10">No</th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-16">Foto</th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-24">SKU</th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Barang</th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-20">Satuan</th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-24">Kategori</th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-24">Merk</th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-32">Harga Jual</th>
                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-32">Grosir</th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-16">Stok</th>
                    <th scope="col" class="px-3 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-24">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                <tr>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                        {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-center">
                        @if($product->gambar)
                            <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_barang }}" 
                                 class="h-9 w-9 object-cover rounded-md border border-gray-300 cursor-pointer hover:opacity-80 hover:scale-105 transition-all duration-200 shadow-sm mx-auto"
                                 @click="isImageModalOpen = true; modalImageUrl = '{{ Storage::url($product->gambar) }}'; modalImageAlt = '{{ addslashes($product->nama_barang) }}'">
                        @else
                            <div class="h-9 w-9 bg-gray-200 rounded-md flex items-center justify-center border border-gray-300 mx-auto">
                                <span class="text-[10px] text-gray-400">N/A</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm font-bold text-gray-900">{{ $product->sku }}</td>
                    <td class="px-3 py-3 text-sm text-gray-800 font-medium truncate max-w-[200px]" title="{{ $product->nama_barang }}">{{ $product->nama_barang }}</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->satuan ?? '-' }}</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->category->nama_kategori ?? '-' }}</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-500">{{ $product->merk->nama_merk ?? '-' }}</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm font-semibold text-tema-marun">
                        {{ $product->harga_grosir > 0 ? 'Rp ' . number_format($product->harga_grosir, 0, ',', '.') : '-' }}
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-900 text-center">
                        <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full {{ $product->stok_saat_ini > ($product->stok_minimum ?? 5) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->stok_saat_ini }}
                        </span>
                    </td>
                    <td class="px-3 py-3 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex justify-center gap-1.5">
                            <a href="{{ route('products.edit', $product->id) }}" class="inline-flex items-center px-2 py-1 bg-yellow-400 text-yellow-900 hover:bg-yellow-500 rounded text-[10px] font-bold transition-colors shadow-sm" title="Edit Barang">
                                <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-600 text-white hover:bg-red-700 rounded text-[10px] font-bold transition-colors shadow-sm" title="Hapus Barang">
                                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data barang.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $products->links() }}
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
         
        <div class="relative bg-white rounded-xl shadow-2xl max-w-xs w-full flex flex-col overflow-hidden" @click.away="isImageModalOpen = false"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <!-- Header Modal -->
            <div class="flex items-center justify-between p-3 border-b border-gray-100 bg-gray-50 flex-shrink-0">
                <h3 class="text-sm font-semibold text-gray-800 truncate pr-2" x-text="modalImageAlt"></h3>
                <button @click="isImageModalOpen = false" type="button" class="text-gray-500 bg-white border border-gray-200 hover:bg-red-50 hover:text-red-600 hover:border-red-200 rounded-md text-sm w-7 h-7 flex-shrink-0 inline-flex justify-center items-center transition-colors shadow-sm">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup modal</span>
                </button>
            </div>
            
            <!-- Body Modal -->
            <div class="p-4 flex-1 flex items-center justify-center bg-white">
                <img :src="modalImageUrl" :alt="modalImageAlt" class="max-w-full max-h-56 object-contain rounded shadow-sm border border-gray-200">
            </div>
        </div>
    </div>
</div>
@endsection
