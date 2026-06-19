@extends('layouts.admin')

@section('content')
<div class="space-y-6 max-w-3xl">
    <div class="flex items-center gap-4">
        <a href="{{ route('users.index') }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-colors shadow-sm border border-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">{{ isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h2>
            <p class="text-sm text-gray-500 mt-1">Formulir pengaturan akses pengguna sistem.</p>
        </div>
    </div>

    @if($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 font-medium">Terdapat kesalahan dalam pengisian formulir:</p>
                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ isset($user) ? route('users.update', $user) : route('users.store') }}" method="POST" autocomplete="off">
            @csrf
            @if(isset($user)) @method('PUT') @endif
            
            <div class="p-6 md:p-8 space-y-6">
                <!-- Nama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 transition-colors" placeholder="Contoh: Karyawan PT. UMAR" required autocomplete="off">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 transition-colors" placeholder="Contoh: staf@umar.com" required autocomplete="off">
                </div>

                <!-- Nomor HP -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Handphone (WhatsApp)</label>
                    <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $user->nomor_hp ?? '') }}" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 transition-colors" placeholder="Contoh: 081234567890" autocomplete="off">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Hak Akses (Role)</label>
                    <select name="role" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 transition-colors" required>
                        <option value="" disabled {{ !isset($user) ? 'selected' : '' }}>-- Pilih Role --</option>
                        @php $roles = ['superadmin' => 'Super Admin (Staff IT)', 'direktur' => 'Direktur (CEO)', 'bendahara' => 'Bendahara (Keuangan)', 'staf_admin' => 'Staf Admin (Gudang & Penjualan)', 'customer' => 'Pelanggan (Customer)']; @endphp
                        @foreach($roles as $key => $label)
                            <option value="{{ $key }}" {{ old('role', $user->role ?? '') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tipe Pelanggan -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Pelanggan (Khusus Role Customer)</label>
                    <select name="tipe_pelanggan" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 transition-colors">
                        <option value="reguler" {{ old('tipe_pelanggan', $user->tipe_pelanggan ?? 'reguler') == 'reguler' ? 'selected' : '' }}>Reguler (Harga Jual Standar)</option>
                        <option value="grosir" {{ old('tipe_pelanggan', $user->tipe_pelanggan ?? '') == 'grosir' ? 'selected' : '' }}>Grosir (Harga Khusus Grosir)</option>
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi (Password)</label>
                    <input type="password" name="password" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 transition-colors" placeholder="{{ isset($user) ? 'Biarkan kosong jika tidak ingin mengubah password' : 'Minimal 6 karakter' }}" {{ !isset($user) ? 'required' : '' }} autocomplete="new-password">
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                <a href="{{ route('users.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-bold text-white bg-tema-marun hover:bg-red-800 rounded-xl shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-tema-marun transition-all">
                    {{ isset($user) ? 'Simpan Perubahan' : 'Buat Pengguna' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
