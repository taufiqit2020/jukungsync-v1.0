@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Manajemen Pengguna</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola hak akses untuk internal dan pelanggan.</p>
        </div>
        <a href="{{ route('users.create') }}" class="bg-tema-hitam hover:bg-black text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Pengguna
        </a>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
        <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
        <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-100 text-[11px] uppercase font-bold text-gray-400 tracking-wider">
                    <tr>
                        <th class="px-6 py-4 w-12 text-center">No</th>
                        <th class="px-6 py-4">Nama / Pengguna</th>
                        <th class="px-6 py-4">Role / Hak Akses</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $idx => $user)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-center font-medium text-gray-500">{{ $idx + 1 }}</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-800">{{ $user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $roleColors = [
                                    'superadmin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                    'direktur' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'bendahara' => 'bg-green-100 text-green-700 border-green-200',
                                    'staf_admin' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    'customer' => 'bg-gray-100 text-gray-700 border-gray-200',
                                ];
                                $colorClass = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                            @endphp
                            <div class="flex flex-col gap-1 items-start">
                                <span class="px-2.5 py-1 rounded-md border text-xs font-bold uppercase {{ $colorClass }}">
                                    {{ $user->role === 'bendahara' ? 'KEPALA ADMINISTRASI DAN KEUANGAN' : str_replace('_', ' ', $user->role) }}
                                </span>
                                @if($user->role === 'customer')
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $user->getTierBadgeClass() }}">
                                        {{ strtoupper($user->getTierLabel()) }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center px-2.5 py-1.5 bg-yellow-400 text-yellow-900 hover:bg-yellow-500 rounded text-[10px] font-bold transition-colors shadow-sm" title="Edit Pengguna">
                                    <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-1.5 bg-red-600 text-white hover:bg-red-700 rounded text-[10px] font-bold transition-colors shadow-sm" title="Hapus Pengguna">
                                        <svg class="w-3.5 h-3.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
