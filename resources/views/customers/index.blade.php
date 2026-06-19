@extends('layouts.admin')
@section('title', 'Data Customer')
@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Customer</h2>
        
        <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
            <form action="{{ route('customers.index') }}" method="GET" class="flex-1 md:w-80 relative" x-data="{ search: '{{ addslashes(request('search')) }}' }">
                <input type="text" name="search" x-model="search" placeholder="Cari nama, telp, email, npwp..." 
                       @input.debounce.500ms="$el.closest('form').submit()"
                       class="w-full pl-10 pr-10 py-2 rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 border text-sm" autofocus>
                
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>

                <div class="absolute inset-y-0 right-0 pr-3 flex items-center" x-show="search.length > 0" style="display: none;">
                    <button type="button" @click="search = ''; $nextTick(() => $el.closest('form').submit())" class="text-gray-400 hover:text-red-500 focus:outline-none transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </form>
            
            <a href="{{ route('customers.create') }}" class="bg-tema-marun hover:bg-red-900 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm shadow-sm flex items-center gap-2 hover:scale-105 duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Customer
            </a>
        </div>
    </div>

    <div class="overflow-x-auto rounded-md border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-tema-hitam">
                <tr>
                    <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-12">No</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Customer</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-28">Tipe</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-36">No. Telepon / WA</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-40">Email</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider w-36">NPWP</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Alamat</th>
                    <th scope="col" class="px-4 py-3 text-center text-xs font-medium text-white uppercase tracking-wider w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($customers as $index => $customer)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center">
                        {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm font-semibold text-gray-900">
                        <a href="{{ route('customers.show', $customer->id) }}" class="text-tema-marun hover:text-red-700 hover:underline">
                            {{ $customer->nama_klien }}
                        </a>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                        <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-bold rounded-full {{ $customer->tipe_customer === 'Instansi' ? 'bg-indigo-100 text-indigo-800' : 'bg-green-100 text-green-800' }}">
                            {{ $customer->tipe_customer }}
                        </span>
                    </td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $customer->no_telp ?: '-' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 truncate max-w-[150px]" title="{{ $customer->email }}">{{ $customer->email ?: '-' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $customer->npwp ?: '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500 truncate max-w-[150px]" title="{{ $customer->alamat }}">{{ $customer->alamat ?: '-' }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-center text-sm font-medium">
                        <div class="flex justify-center gap-1.5">
                            <a href="{{ route('customers.show', $customer->id) }}" class="inline-flex items-center px-2 py-1 bg-blue-500 text-white hover:bg-blue-600 rounded text-[10px] font-bold transition-colors shadow-sm" title="Lihat Profil">
                                <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                Profil
                            </a>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="inline-flex items-center px-2 py-1 bg-yellow-400 text-yellow-900 hover:bg-yellow-500 rounded text-[10px] font-bold transition-colors shadow-sm" title="Edit Customer">
                                <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Edit
                            </a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus Customer ini? Histori transaksi customer tidak akan terhapus namun relasinya akan kosong.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-2 py-1 bg-red-600 text-white hover:bg-red-700 rounded text-[10px] font-bold transition-colors shadow-sm" title="Hapus Customer">
                                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data customer.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-4">
        {{ $customers->links() }}
    </div>
</div>
@endsection
