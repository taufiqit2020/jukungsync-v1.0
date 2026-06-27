@extends('layouts.admin')

@section('content')
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="flex justify-between items-center">
        <div>
            <h1 style="font-size:1.4rem;font-weight:900;color:#1f2937;margin:0;">Manajemen Pengguna</h1>
            <p style="font-size:0.8rem;color:#6b7280;margin-top:2px;">Kelola hak akses untuk internal dan pelanggan.</p>
        </div>
        <a href="{{ route('users.create') }}"
           style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);color:white;"
           class="flex items-center gap-2 px-5 py-2.5 text-sm font-bold rounded-xl shadow-md hover:opacity-90 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Pengguna
        </a>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:12px;" class="flex items-center gap-3 px-5 py-3.5">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#15803d;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span style="font-size:0.875rem;font-weight:600;color:#15803d;">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div style="background:#fff5f5;border:1px solid #fecaca;border-radius:12px;" class="flex items-center gap-3 px-5 py-3.5">
        <svg class="w-5 h-5 flex-shrink-0" style="color:#b91c1c;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span style="font-size:0.875rem;font-weight:600;color:#b91c1c;">{{ session('error') }}</span>
    </div>
    @endif

    {{-- Table Card --}}
    <div style="background:white;border-radius:16px;border:1px solid #f3f4f6;box-shadow:0 1px 4px rgba(0,0,0,0.07);" class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="background:#1f2937;">
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;">No</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Nama / Pengguna</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:left;letter-spacing:0.05em;">Role / Hak Akses</th>
                        <th style="color:white;font-size:0.7rem;font-weight:700;text-transform:uppercase;padding:12px 16px;text-align:center;letter-spacing:0.05em;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $idx => $user)
                    <tr class="hover:bg-gray-50/70 transition-colors" style="border-bottom:1px solid #f3f4f6;">
                        <td style="padding:14px 16px;text-align:center;font-size:0.8rem;font-weight:600;color:#9ca3af;">{{ $idx + 1 }}</td>
                        <td style="padding:14px 16px;">
                            <p style="font-weight:700;font-size:0.875rem;color:#1f2937;margin:0;">{{ $user->name }}</p>
                            <p style="font-size:0.75rem;color:#6b7280;margin:2px 0 0;">{{ $user->email }}</p>
                        </td>
                        <td style="padding:14px 16px;">
                            @php
                                $roleStyles = [
                                    'superadmin'  => 'background:#f3e8ff;color:#7e22ce;border:1px solid #d8b4fe;',
                                    'direktur'    => 'background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;',
                                    'bendahara'   => 'background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;',
                                    'staf_admin'  => 'background:#fefce8;color:#a16207;border:1px solid #fde68a;',
                                    'customer'    => 'background:#f9fafb;color:#374151;border:1px solid #e5e7eb;',
                                ];
                                $roleStyle = $roleStyles[$user->role] ?? 'background:#f9fafb;color:#374151;border:1px solid #e5e7eb;';
                                $roleLabel = $user->role === 'bendahara'
                                    ? 'KEPALA ADM. & KEUANGAN'
                                    : strtoupper(str_replace('_', ' ', $user->role));
                            @endphp
                            <div class="flex flex-col gap-1 items-start">
                                <span style="{{ $roleStyle }}font-size:0.65rem;font-weight:800;padding:3px 10px;border-radius:6px;letter-spacing:0.04em;">
                                    {{ $roleLabel }}
                                </span>
                                @if($user->role === 'customer')
                                    <span style="font-size:0.6rem;font-weight:800;padding:2px 8px;border-radius:999px;border:1px solid #e5e7eb;background:#f9fafb;color:#6b7280;">
                                        {{ strtoupper($user->getTierLabel()) }}
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td style="padding:14px 16px;text-align:center;">
                            <div class="flex items-center justify-center gap-1.5">
                                <a href="{{ route('users.edit', $user) }}"
                                   style="background:#fef08a;color:#713f12;border:1px solid #fde047;"
                                   class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold hover:opacity-80 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    Edit
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            style="background:#dc2626;color:white;"
                                            class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-xs font-bold hover:opacity-80 transition-all">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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
