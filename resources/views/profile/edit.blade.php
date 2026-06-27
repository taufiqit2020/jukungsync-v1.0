@php
    $layout = in_array(auth()->user()->role, ['superadmin', 'direktur', 'bendahara', 'staf_admin']) ? 'layouts.admin' : 'layouts.customer';
@endphp

@extends($layout)

@section('title', 'Profil Saya')

@section('content')
<div x-data="profileApp()">

    {{-- ── Hero Banner ── --}}
    <div style="background:linear-gradient(135deg,#7f1d1d 0%,#991b1b 50%,#b91c1c 100%);" class="rounded-2xl p-6 md:p-8 mb-6 relative overflow-hidden shadow-lg">
        {{-- Dekorasi bulatan --}}
        <div style="position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:rgba(255,255,255,0.06);border-radius:50%;"></div>
        <div style="position:absolute;bottom:-60px;left:-20px;width:160px;height:160px;background:rgba(255,255,255,0.04);border-radius:50%;"></div>

        <div class="relative flex items-center gap-5">
            {{-- Avatar Besar --}}
            <div style="width:72px;height:72px;min-width:72px;background:linear-gradient(135deg,#FBBF24,#F59E0B);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:900;color:#1c1917;box-shadow:0 8px 24px rgba(0,0,0,0.3);">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
            <div>
                <p style="color:rgba(255,255,255,0.7);font-size:0.75rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:2px;">Akun Saya</p>
                <h1 style="color:white;font-size:1.5rem;font-weight:900;margin:0 0 6px;">{{ auth()->user()->name ?? 'Admin' }}</h1>
                <span style="display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.15);color:white;font-size:0.72rem;font-weight:700;padding:3px 12px;border-radius:999px;letter-spacing:0.05em;border:1px solid rgba(255,255,255,0.2);">
                    <svg style="width:10px;height:10px;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                    {{ strtoupper(auth()->user()->role ?? 'ADMIN') }}
                </span>
            </div>
            <div class="ml-auto hidden md:block text-right">
                <p style="color:rgba(255,255,255,0.6);font-size:0.75rem;">Email</p>
                <p style="color:white;font-weight:700;font-size:0.875rem;">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    {{-- ── Alerts ── --}}
    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 rounded-xl shadow-sm">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
        <p class="text-sm font-semibold">{{ session('success') }}</p>
    </div>
    @endif

    @if($errors->any())
    <div class="mb-5 flex items-start gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl shadow-sm">
        <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/></svg>
        <div>
            <p class="text-sm font-bold mb-1">Terdapat kesalahan:</p>
            <ul class="text-sm list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    </div>
    @endif

    {{-- ── Form ── --}}
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- ── Kolom Kiri: Info Pribadi & Kata Sandi ── --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Card: Informasi Pribadi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100" style="background:linear-gradient(to right,#fef9f0,#fff);">
                        <div style="width:36px;height:36px;background:linear-gradient(135deg,#FBBF24,#F59E0B);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:18px;height:18px;color:white;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">Informasi Pribadi</h3>
                            <p class="text-xs text-gray-500">Nama, email, dan nomor kontak</p>
                        </div>
                    </div>
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full border border-gray-200 px-4 py-3 bg-gray-50 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:border-red-700 focus:ring focus:ring-red-700 focus:ring-opacity-20 transition-all outline-none"
                                    placeholder="Nama lengkap Anda" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full border border-gray-200 px-4 py-3 bg-gray-50 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:border-red-700 focus:ring focus:ring-red-700 focus:ring-opacity-20 transition-all outline-none"
                                    required>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Nomor HP / WhatsApp <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm">📱</span>
                                    <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $user->nomor_hp) }}"
                                        placeholder="08123456789"
                                        class="w-full border border-gray-200 pl-9 pr-4 py-3 bg-gray-50 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:border-red-700 focus:ring focus:ring-red-700 focus:ring-opacity-20 transition-all outline-none"
                                        required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Nama Perusahaan / Toko</label>
                                <div class="relative">
                                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🏢</span>
                                    <input type="text" name="perusahaan" value="{{ old('perusahaan', $user->perusahaan) }}"
                                        placeholder="Contoh: UD. Berkah Jaya"
                                        class="w-full border border-gray-200 pl-9 pr-4 py-3 bg-gray-50 rounded-xl text-sm font-medium text-gray-800 focus:bg-white focus:border-red-700 focus:ring focus:ring-red-700 focus:ring-opacity-20 transition-all outline-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card: Ubah Kata Sandi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100" style="background:linear-gradient(to right,#fff5f5,#fff);">
                        <div style="width:36px;height:36px;background:linear-gradient(135deg,#991b1b,#b91c1c);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:18px;height:18px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">Ubah Kata Sandi</h3>
                            <p class="text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah</p>
                        </div>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Kata Sandi Baru</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔒</span>
                                <input type="password" name="password"
                                    class="w-full border border-gray-200 pl-9 pr-4 py-3 bg-gray-50 rounded-xl text-sm focus:bg-white focus:border-red-700 focus:ring focus:ring-red-700 focus:ring-opacity-20 transition-all outline-none"
                                    placeholder="Min. 8 karakter">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-600 mb-1.5 uppercase tracking-wide">Konfirmasi Kata Sandi</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔑</span>
                                <input type="password" name="password_confirmation"
                                    class="w-full border border-gray-200 pl-9 pr-4 py-3 bg-gray-50 rounded-xl text-sm focus:bg-white focus:border-red-700 focus:ring focus:ring-red-700 focus:ring-opacity-20 transition-all outline-none"
                                    placeholder="Ulangi kata sandi baru">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex items-center justify-between gap-3 pt-1">
                    <a href="{{ in_array(auth()->user()->role, ['customer']) ? route('catalog.index') : route('dashboard') }}"
                        class="flex items-center gap-2 px-6 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 transition-all shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Kembali
                    </a>
                    <button type="submit"
                        style="background:linear-gradient(135deg,#7f1d1d,#b91c1c);"
                        class="flex items-center gap-2 px-8 py-3 text-sm font-bold text-white rounded-xl hover:opacity-90 transition-all shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </div>

            {{-- ── Kolom Kanan: Alamat ── --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden sticky top-4" x-data="{ clickOutside() { showSuggestions = false } }" @click.away="clickOutside()">
                    <div class="flex items-center gap-3 px-5 py-4 border-b border-gray-100" style="background:linear-gradient(to right,#f0fdf4,#fff);">
                        <div style="width:36px;height:36px;background:linear-gradient(135deg,#15803d,#16a34a);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <svg style="width:18px;height:18px;" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-gray-800">Alamat Pengiriman</h3>
                            <p class="text-xs text-gray-500">Lokasi & detail wilayah</p>
                        </div>
                    </div>

                    <div class="p-5 space-y-4">
                        <input type="hidden" name="alamat" x-model="customAddress">

                        {{-- Search Autocomplete --}}
                        <div class="space-y-1.5 relative">
                            <label class="text-xs font-bold text-gray-600 uppercase tracking-wide block">Cari Alamat Otomatis</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">📍</span>
                                <input
                                    type="text"
                                    x-model="customAddress"
                                    @input="fetchAddressSuggestions()"
                                    @focus="showSuggestions = addressSuggestions.length > 0"
                                    placeholder="Ketik nama jalan, gedung..."
                                    class="w-full border border-gray-200 pl-9 pr-4 py-2.5 text-sm bg-gray-50 rounded-xl focus:bg-white focus:border-green-600 focus:ring focus:ring-green-600 focus:ring-opacity-20 transition-all outline-none">
                                <div x-show="isSearchingAddress" class="absolute right-3 top-1/2 -translate-y-1/2">
                                    <svg class="animate-spin h-4 w-4 text-red-800" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>
                                </div>
                            </div>
                            <div x-show="showSuggestions"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-2xl shadow-xl z-50 overflow-hidden divide-y divide-gray-50 max-h-60 overflow-y-auto" style="display:none;">
                                <template x-for="(item, idx) in addressSuggestions" :key="idx">
                                    <div @click="selectSuggestion(item)" class="p-3 hover:bg-gray-50 cursor-pointer flex items-start gap-2.5 transition-colors">
                                        <span class="text-sm mt-0.5 flex-shrink-0">📍</span>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-xs font-bold text-gray-800 truncate" x-text="item.title"></p>
                                            <p class="text-[10px] text-gray-400 truncate mt-0.5" x-text="item.subtitle || item.fullAddress"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Detail Alamat --}}
                        <div class="bg-gray-50 rounded-xl p-4 space-y-3 border border-gray-100">
                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Detail Alamat</p>

                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-gray-600">Nama Jalan / Gedung / Patokan</label>
                                <input type="text" x-model="customRoad" @input="updateCustomAddress()" placeholder="Jl. Panglima Batur"
                                    class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-green-600 focus:border-green-600 transition-all outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-gray-600">No. Rumah / Blok</label>
                                    <input type="text" x-model="customHouseNumber" @input="updateCustomAddress()" placeholder="No. 12B"
                                        class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-green-600 focus:border-green-600 transition-all outline-none">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-gray-600">RT / RW</label>
                                    <input type="text" x-model="customRtRw" @input="updateCustomAddress()" placeholder="003/002"
                                        class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-green-600 focus:border-green-600 transition-all outline-none">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-gray-600">Provinsi</label>
                                    <select x-model="selectedProvinceId" @change="onProvinceChange()"
                                        class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-green-600 focus:border-green-600 transition-all outline-none">
                                        <option value="" x-text="isLoadingProvinces ? 'Memuat...' : '-- Pilih --'"></option>
                                        <template x-for="p in provinces" :key="p.id">
                                            <option :value="p.id" x-text="capitalizeWord(p.name)" :selected="p.id === selectedProvinceId"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-gray-600">Kota / Kabupaten</label>
                                    <select x-model="selectedRegencyId" @change="onRegencyChange()" :disabled="!selectedProvinceId || isLoadingRegencies"
                                        class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-green-600 focus:border-green-600 transition-all outline-none disabled:opacity-50 disabled:bg-gray-100">
                                        <option value="" x-text="isLoadingRegencies ? 'Memuat...' : '-- Pilih --'"></option>
                                        <template x-for="r in regencies" :key="r.id">
                                            <option :value="r.id" x-text="capitalizeWord(r.name)" :selected="r.id === selectedRegencyId"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-gray-600">Kecamatan</label>
                                    <select x-model="selectedDistrictId" @change="onDistrictChange()" :disabled="!selectedRegencyId || isLoadingDistricts"
                                        class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-green-600 focus:border-green-600 transition-all outline-none disabled:opacity-50 disabled:bg-gray-100">
                                        <option value="" x-text="isLoadingDistricts ? 'Memuat...' : '-- Pilih --'"></option>
                                        <template x-for="d in districts" :key="d.id">
                                            <option :value="d.id" x-text="capitalizeWord(d.name)" :selected="d.id === selectedDistrictId"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-bold text-gray-600">Kelurahan / Desa</label>
                                    <select x-model="selectedVillageId" @change="onVillageChange()" :disabled="!selectedDistrictId || isLoadingVillages"
                                        class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-green-600 focus:border-green-600 transition-all outline-none disabled:opacity-50 disabled:bg-gray-100">
                                        <option value="" x-text="isLoadingVillages ? 'Memuat...' : '-- Pilih --'"></option>
                                        <template x-for="v in villages" :key="v.id">
                                            <option :value="v.id" x-text="capitalizeWord(v.name)" :selected="v.id === selectedVillageId"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Preview Alamat Lengkap --}}
                        <div x-show="customAddress" class="bg-green-50 border border-green-100 rounded-xl p-3">
                            <p class="text-[10px] font-bold text-green-700 uppercase tracking-wide mb-1">📋 Pratinjau Alamat</p>
                            <p class="text-xs text-green-800 leading-relaxed" x-text="customAddress"></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>{{-- end grid --}}
    </form>

</div>

                                
                                <template x-for="(item, idx) in addressSuggestions" :key="idx">
                                    <div @click="selectSuggestion(item)" class="p-3 hover:bg-gray-50 cursor-pointer flex items-start gap-2.5 transition-colors">
                                        <span class="text-sm mt-0.5 flex-shrink-0">📍</span>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-xs font-bold text-gray-800 truncate" x-text="item.title"></p>
                                            <p class="text-[10px] text-gray-400 truncate mt-0.5" x-text="item.subtitle || item.fullAddress"></p>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Detail Fields (Nama Jalan, No. Rumah, RT/RW, Provinsi, Kota, Kecamatan, Kelurahan) -->
                        <div class="bg-gray-50/50 p-4 border border-gray-200 rounded-2xl space-y-3">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Detail Alamat</p>
                            
                            <!-- Row 1: Nama Jalan -->
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-gray-600">Nama Jalan / Gedung / Patokan</label>
                                <input type="text" x-model="customRoad" @input="updateCustomAddress()" placeholder="Contoh: Jl. Panglima Batur" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-red-800 focus:border-red-800 transition-all">
                            </div>

                            <!-- Row 2: No Rumah & RT/RW -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">Nomor Rumah / Blok</label>
                                    <input type="text" x-model="customHouseNumber" @input="updateCustomAddress()" placeholder="Contoh: No. 12B" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-red-800 focus:border-red-800 transition-all">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">RT / RW</label>
                                    <input type="text" x-model="customRtRw" @input="updateCustomAddress()" placeholder="Contoh: 003/002" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-red-800 focus:border-red-800 transition-all">
                                </div>
                            </div>

                            <!-- Row 3: Provinsi & Kota / Kabupaten -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">Provinsi</label>
                                    <select x-model="selectedProvinceId" @change="onProvinceChange()" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-red-800 focus:border-red-800 transition-all">
                                        <option value="" x-text="isLoadingProvinces ? 'Memuat Provinsi...' : '-- Pilih Provinsi --'"></option>
                                        <template x-for="p in provinces" :key="p.id">
                                            <option :value="p.id" x-text="capitalizeWord(p.name)" :selected="p.id === selectedProvinceId"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">Kota / Kabupaten</label>
                                    <select x-model="selectedRegencyId" @change="onRegencyChange()" :disabled="!selectedProvinceId || isLoadingRegencies" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-red-800 focus:border-red-800 transition-all disabled:opacity-50 disabled:bg-gray-100">
                                        <option value="" x-text="isLoadingRegencies ? 'Memuat Kota/Kabupaten...' : '-- Pilih Kota/Kabupaten --'"></option>
                                        <template x-for="r in regencies" :key="r.id">
                                            <option :value="r.id" x-text="capitalizeWord(r.name)" :selected="r.id === selectedRegencyId"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <!-- Row 4: Kecamatan & Kelurahan / Desa -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">Kecamatan</label>
                                    <select x-model="selectedDistrictId" @change="onDistrictChange()" :disabled="!selectedRegencyId || isLoadingDistricts" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-red-800 focus:border-red-800 transition-all disabled:opacity-50 disabled:bg-gray-100">
                                        <option value="" x-text="isLoadingDistricts ? 'Memuat Kecamatan...' : '-- Pilih Kecamatan --'"></option>
                                        <template x-for="d in districts" :key="d.id">
                                            <option :value="d.id" x-text="capitalizeWord(d.name)" :selected="d.id === selectedDistrictId"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">Kelurahan / Desa</label>
                                    <select x-model="selectedVillageId" @change="onVillageChange()" :disabled="!selectedDistrictId || isLoadingVillages" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-red-800 focus:border-red-800 transition-all disabled:opacity-50 disabled:bg-gray-100">
                                        <option value="" x-text="isLoadingVillages ? 'Memuat Kelurahan/Desa...' : '-- Pilih Kelurahan/Desa --'"></option>
                                        <template x-for="v in villages" :key="v.id">
                                            <option :value="v.id" x-text="capitalizeWord(v.name)" :selected="v.id === selectedVillageId"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Ubah Kata Sandi</h3>
                        <p class="text-sm text-gray-500 mb-4">Biarkan kosong jika Anda tidak ingin mengubah kata sandi.</p>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Kata Sandi Baru</label>
                                <input type="password" name="password" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-red-800 focus:ring focus:ring-red-800 focus:ring-opacity-50">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-red-800 focus:ring focus:ring-red-800 focus:ring-opacity-50">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                    <a href="{{ in_array(auth()->user()->role, ['customer']) ? route('catalog.index') : route('dashboard') }}" class="px-6 py-2.5 text-sm font-bold text-black bg-[#FBBF24] hover:bg-yellow-500 rounded-xl shadow-md transition-all">
                        Kembali / Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-red-900 hover:bg-red-800 rounded-xl shadow-md transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function profileApp() {
            return {
                customAddress: '{{ addslashes(old('alamat', $user->alamat ?? '')) }}',
                customRoad: '',
                customHouseNumber: '',
                customRtRw: '',
                
                provinces: [],
                regencies: [],
                districts: [],
                villages: [],
                
                selectedProvinceId: '',
                selectedRegencyId: '',
                selectedDistrictId: '',
                selectedVillageId: '',
                
                isLoadingProvinces: false,
                isLoadingRegencies: false,
                isLoadingDistricts: false,
                isLoadingVillages: false,
                
                addressSuggestions: [],
                showSuggestions: false,
                isSearchingAddress: false,
                searchTimeout: null,
                searchController: null,

                init() {
                    this.isLoadingProvinces = true;
                    fetch('/api/wilayah/provinces')
                        .then(res => res.json())
                        .then(data => {
                            this.provinces = data;
                            this.isLoadingProvinces = false;
                            
                            // Parse existing address
                            this.parseExistingAddress();
                        })
                        .catch(err => {
                            console.error('Gagal mengambil provinsi:', err);
                            this.isLoadingProvinces = false;
                        });
                },
                
                parseExistingAddress() {
                    const addr = this.customAddress;
                    if (!addr) return;
                    
                    console.log('[JukungSync] Parsing existing address:', addr);
                    
                    // Parse jalan
                    const roadMatch = addr.match(/Jl\.\s*([^,]+)/i);
                    if (roadMatch) this.customRoad = roadMatch[1].trim();
                    
                    // Parse no rumah
                    const noMatch = addr.match(/No\.\s*([^,]+)/i);
                    if (noMatch) this.customHouseNumber = noMatch[1].trim();
                    
                    // Parse RT/RW
                    const rtrwMatch = addr.match(/RT\/RW\s*([^,]+)/i);
                    if (rtrwMatch) this.customRtRw = rtrwMatch[1].trim();
                    
                    // Parse Kelurahan
                    let kel = '';
                    const kelMatch = addr.match(/Kel\.\s*([^,]+)/i) || addr.match(/Kelurahan\s*([^,]+)/i) || addr.match(/Desa\s*([^,]+)/i);
                    if (kelMatch) kel = kelMatch[1].trim();
                    
                    // Parse Kecamatan
                    let kec = '';
                    const kecMatch = addr.match(/Kec\.\s*([^,]+)/i) || addr.match(/Kecamatan\s*([^,]+)/i);
                    if (kecMatch) kec = kecMatch[1].trim();
                    
                    // Parse Kota/Kabupaten
                    let kota = '';
                    const kotaMatch = addr.match(/(Kota|Kab\.|Kabupaten)\s*([^,]+)/i);
                    if (kotaMatch) {
                        kota = kotaMatch[2].trim();
                    } else {
                        // Cek jika ada kota penting kalsel
                        const cities = ['Banjarbaru', 'Banjarmasin', 'Martapura', 'Balikpapan', 'Samarinda', 'Jakarta', 'Surabaya', 'Bandung'];
                        for (const c of cities) {
                            if (addr.includes(c)) {
                                kota = c;
                                break;
                            }
                        }
                    }
                    
                    // Parse Provinsi
                    let prov = '';
                    const provMatch = addr.match(/Prov\.\s*([^,]+)/i) || addr.match(/Provinsi\s*([^,]+)/i);
                    if (provMatch) {
                        prov = provMatch[1].trim();
                    } else if (addr.includes('Kalimantan Selatan')) {
                        prov = 'Kalimantan Selatan';
                    }
                    
                    if (prov || kota || kec || kel) {
                        console.log('[JukungSync] Parsed parts:', { prov, kota, kec, kel });
                        this.syncRegionsFromAutocomplete({
                            provinsi: prov,
                            kota: kota,
                            kecamatan: kec,
                            kelurahan: kel
                        });
                    }
                },

                fetchAddressSuggestions() {
                    const query = this.customAddress;
                    if (!query || query.trim().length < 3) {
                        this.addressSuggestions = [];
                        this.showSuggestions = false;
                        return;
                    }

                    if (this.searchTimeout) {
                        clearTimeout(this.searchTimeout);
                    }

                    if (this.searchController) {
                        this.searchController.abort();
                    }
                    this.searchController = new AbortController();
                    const signal = this.searchController.signal;

                    this.searchTimeout = setTimeout(() => {
                        this.isSearchingAddress = true;
                        
                        fetch(`https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&limit=15`, { signal })
                            .then(res => res.json())
                            .then(data => {
                                if (data && data.features && data.features.length > 0) {
                                    const indonesianFeatures = data.features.filter(f => {
                                        const cc = (f.properties.countrycode || '').toLowerCase();
                                        const c = (f.properties.country || '').toLowerCase();
                                        return cc === 'id' || c.includes('indonesia');
                                    });
                                    
                                    const featuresToUse = indonesianFeatures.length > 0 ? indonesianFeatures : data.features.slice(0, 6);
                                    
                                    this.addressSuggestions = featuresToUse.map(feat => {
                                        const props = feat.properties || {};
                                        const name = props.name || '';
                                        const road = props.street || '';
                                        const houseNumber = props.housenumber || '';
                                        const kelurahan = props.locality || props.suburb || props.village || '';
                                        const kecamatan = props.district || props.city_district || '';
                                        const city = props.city || props.town || '';
                                        const state = props.state || '';
                                        
                                        const title = name || road || 'Alamat Terdeteksi';
                                        const subtitleParts = [road, kelurahan, kecamatan, city, state].filter(Boolean);
                                        const subtitle = subtitleParts.join(', ');
                                        const fullAddress = [name, road, kelurahan, kecamatan, city, state, 'Indonesia'].filter(Boolean).join(', ');
                                        
                                        return {
                                            title: title,
                                            fullAddress: fullAddress,
                                            subtitle: subtitle,
                                            details: {
                                                road: road || name,
                                                houseNumber: houseNumber,
                                                kelurahan: kelurahan,
                                                kecamatan: kecamatan,
                                                kota: city,
                                                provinsi: state
                                            }
                                        };
                                    });
                                    this.showSuggestions = this.addressSuggestions.length > 0;
                                } else {
                                    this.fetchNominatimFallback(query, signal);
                                }
                            })
                            .catch(err => {
                                if (err.name !== 'AbortError') {
                                    console.warn('Photon API failed, falling back to Nominatim:', err);
                                    this.fetchNominatimFallback(query, signal);
                                }
                            })
                            .finally(() => {
                                this.isSearchingAddress = false;
                            });
                    }, 200);
                },

                fetchNominatimFallback(query, signal) {
                    this.isSearchingAddress = true;
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&limit=6&addressdetails=1`, { signal })
                        .then(res => res.json())
                        .then(data => {
                            this.addressSuggestions = data.map(item => {
                                const name = item.name || '';
                                const address = item.address || {};
                                const road = address.road || '';
                                const subdistrict = address.village || address.suburb || address.town || address.neighbourhood || '';
                                const district = address.city_district || address.county || address.district || '';
                                const city = address.city || address.town || address.municipality || '';
                                const state = address.state || '';
                                
                                return {
                                    title: name || road || 'Alamat Terdeteksi',
                                    fullAddress: item.display_name,
                                    subtitle: [road, subdistrict, district, city, state].filter(Boolean).join(', '),
                                    details: {
                                        road: road || name,
                                        houseNumber: address.house_number || '',
                                        kelurahan: subdistrict || '',
                                        kecamatan: district || '',
                                        kota: city || '',
                                        provinsi: state
                                    }
                                };
                            });
                            this.showSuggestions = this.addressSuggestions.length > 0;
                        })
                        .catch(err => {
                            if (err.name !== 'AbortError') {
                                console.error('Error fetching suggestions from Nominatim:', err);
                            }
                        })
                        .finally(() => {
                            this.isSearchingAddress = false;
                        });
                },

                selectSuggestion(item) {
                    this.customRoad = item.details.road || '';
                    this.customHouseNumber = item.details.houseNumber || '';
                    this.customRtRw = '';
                    this.addressSuggestions = [];
                    this.showSuggestions = false;

                    console.log('[JukungSync] Selected suggestion details:', JSON.stringify(item.details));
                    this.syncRegionsFromAutocomplete(item.details);
                },

                syncRegionsFromAutocomplete(details) {
                    const norm = (str) => {
                        if (!str) return '';
                        return str.toUpperCase()
                            .replace(/\b(PROVINSI|KABUPATEN|KOTA|KECAMATAN|KELURAHAN|DESA|DAERAH ISTIMEWA|DAERAH KHUSUS IBUKOTA|DKI)\b/g, '')
                            .replace(/[^A-Z0-9]/g, '')
                            .trim();
                    };

                    const flexMatch = (listName, queryStr) => {
                        const q = norm(queryStr);
                        if (!q || q.length < 2) return null;

                        let match = listName.find(item => norm(item.name) === q);
                        if (match) return match;

                        match = listName.find(item => {
                            const n = norm(item.name);
                            return n.includes(q) || q.includes(n);
                        });
                        if (match) return match;

                        if (q.length >= 4) {
                            match = listName.find(item => {
                                const n = norm(item.name);
                                return n.startsWith(q.substring(0, 4)) || q.startsWith(n.substring(0, 4));
                            });
                        }
                        return match || null;
                    };

                    if (!details.provinsi && !details.kota) {
                        this.updateCustomAddress();
                        return;
                    }

                    console.log('[JukungSync] Syncing regions - Provinsi:', details.provinsi, '| Kota:', details.kota, '| Kecamatan:', details.kecamatan, '| Kelurahan:', details.kelurahan);

                    const doSync = () => {
                        let matchedProv = null;
                        if (details.provinsi) {
                            matchedProv = flexMatch(this.provinces, details.provinsi);
                            console.log('[JukungSync] Province match result:', matchedProv ? matchedProv.name : 'NOT FOUND', '(query:', details.provinsi, ')');
                        }

                        if (!matchedProv && details.kota) {
                            const kotaNorm = norm(details.kota);
                            console.log('[JukungSync] Province not found, searching by city name:', kotaNorm);
                            this.findProvinceByCity(details, norm, flexMatch);
                            return;
                        }

                        if (!matchedProv) {
                            console.warn('[JukungSync] No province matched for:', details.provinsi);
                            this.updateCustomAddress();
                            return;
                        }

                        this.selectedProvinceId = matchedProv.id;
                        this.isLoadingRegencies = true;
                        
                        fetch(`/api/wilayah/regencies/${matchedProv.id}`)
                            .then(res => res.json())
                            .then(regencies => {
                                this.regencies = regencies;
                                this.isLoadingRegencies = false;
                                
                                if (!details.kota) {
                                    this.updateCustomAddress();
                                    return;
                                }
                                const matchedReg = flexMatch(regencies, details.kota);
                                console.log('[JukungSync] Regency match result:', matchedReg ? matchedReg.name : 'NOT FOUND', '(query:', details.kota, ')');
                                
                                if (matchedReg) {
                                    this.selectedRegencyId = matchedReg.id;
                                    this.cascadeDistricts(matchedReg.id, details, norm, flexMatch);
                                } else {
                                    this.updateCustomAddress();
                                }
                            })
                            .catch(err => {
                                console.error('[JukungSync] Error fetching regencies:', err);
                                this.isLoadingRegencies = false;
                                this.updateCustomAddress();
                            });
                    };

                    if (this.provinces.length === 0) {
                        console.log('[JukungSync] Provinces not loaded yet, fetching first...');
                        this.isLoadingProvinces = true;
                        fetch('/api/wilayah/provinces')
                            .then(res => res.json())
                            .then(data => {
                                this.provinces = data;
                                this.isLoadingProvinces = false;
                                doSync();
                            })
                            .catch(err => {
                                console.error('[JukungSync] Error fetching provinces:', err);
                                this.isLoadingProvinces = false;
                            });
                    } else {
                        doSync();
                    }
                },

                findProvinceByCity(details, norm, flexMatch) {
                    const priorityProvinces = this.provinces.filter(p => {
                        const n = norm(p.name);
                        return n.includes('KALIMANTANSELATAN') || n.includes('KALIMANTANTIMUR') || n.includes('KALIMANTANTENGAH') || n.includes('KALIMANTANBARAT') || n.includes('KALIMANTANUTARA');
                    });
                    const otherProvinces = this.provinces.filter(p => !priorityProvinces.includes(p));
                    const allProvs = [...priorityProvinces, ...otherProvinces];

                    let found = false;

                    const checkNextProvince = (index) => {
                        if (index >= allProvs.length || found) {
                            if (!found) {
                                console.warn('[JukungSync] City not found in any province:', details.kota);
                                this.updateCustomAddress();
                            }
                            return;
                        }

                        const prov = allProvs[index];
                        fetch(`/api/wilayah/regencies/${prov.id}`)
                            .then(res => res.json())
                            .then(regencies => {
                                const matchedReg = flexMatch(regencies, details.kota);
                                if (matchedReg && !found) {
                                    found = true;
                                    console.log('[JukungSync] Found city', details.kota, 'in province', prov.name);
                                    this.selectedProvinceId = prov.id;
                                    this.regencies = regencies;
                                    this.selectedRegencyId = matchedReg.id;
                                    this.cascadeDistricts(matchedReg.id, details, norm, flexMatch);
                                } else {
                                    checkNextProvince(index + 1);
                                }
                            })
                            .catch(() => {
                                checkNextProvince(index + 1);
                            });
                    };

                    this.isLoadingRegencies = true;
                    checkNextProvince(0);
                },

                cascadeDistricts(regencyId, details, norm, flexMatch) {
                    this.isLoadingDistricts = true;
                    
                    fetch(`/api/wilayah/districts/${regencyId}`)
                        .then(res => res.json())
                        .then(districts => {
                            this.districts = districts;
                            this.isLoadingDistricts = false;
                            
                            if (!details.kecamatan) {
                                this.updateCustomAddress();
                                return;
                            }
                            const matchedDist = flexMatch(districts, details.kecamatan);
                            console.log('[JukungSync] District match result:', matchedDist ? matchedDist.name : 'NOT FOUND', '(query:', details.kecamatan, ')');
                            
                            if (matchedDist) {
                                this.selectedDistrictId = matchedDist.id;
                                this.cascadeVillages(matchedDist.id, details, norm, flexMatch);
                            } else {
                                this.updateCustomAddress();
                            }
                        })
                        .catch(() => { this.isLoadingDistricts = false; this.updateCustomAddress(); });
                },

                cascadeVillages(districtId, details, norm, flexMatch) {
                    this.isLoadingVillages = true;
                    
                    fetch(`/api/wilayah/villages/${districtId}`)
                        .then(res => res.json())
                        .then(villages => {
                            this.villages = villages;
                            this.isLoadingVillages = false;
                            
                            if (details.kelurahan) {
                                const matchedVill = flexMatch(villages, details.kelurahan);
                                console.log('[JukungSync] Village match result:', matchedVill ? matchedVill.name : 'NOT FOUND', '(query:', details.kelurahan, ')');
                                if (matchedVill) {
                                    this.selectedVillageId = matchedVill.id;
                                }
                            }
                            this.updateCustomAddress();
                        })
                        .catch(() => { this.isLoadingVillages = false; this.updateCustomAddress(); });
                },

                onProvinceChange() {
                    this.selectedRegencyId = '';
                    this.selectedDistrictId = '';
                    this.selectedVillageId = '';
                    this.regencies = [];
                    this.districts = [];
                    this.villages = [];
                    this.updateCustomAddress();

                    if (!this.selectedProvinceId) return;

                    this.isLoadingRegencies = true;
                    fetch(`/api/wilayah/regencies/${this.selectedProvinceId}`)
                        .then(res => res.json())
                        .then(data => {
                            this.regencies = data;
                            this.isLoadingRegencies = false;
                        })
                        .catch(() => {
                            this.isLoadingRegencies = false;
                        });
                },

                onRegencyChange() {
                    this.selectedDistrictId = '';
                    this.selectedVillageId = '';
                    this.districts = [];
                    this.villages = [];
                    this.updateCustomAddress();

                    if (!this.selectedRegencyId) return;

                    this.isLoadingDistricts = true;
                    fetch(`/api/wilayah/districts/${this.selectedRegencyId}`)
                        .then(res => res.json())
                        .then(data => {
                            this.districts = data;
                            this.isLoadingDistricts = false;
                        })
                        .catch(() => {
                            this.isLoadingDistricts = false;
                        });
                },

                onDistrictChange() {
                    this.selectedVillageId = '';
                    this.villages = [];
                    this.updateCustomAddress();

                    if (!this.selectedDistrictId) return;

                    this.isLoadingVillages = true;
                    fetch(`/api/wilayah/villages/${this.selectedDistrictId}`)
                        .then(res => res.json())
                        .then(data => {
                            this.villages = data;
                            this.isLoadingVillages = false;
                        })
                        .catch(() => {
                            this.isLoadingVillages = false;
                        });
                },

                onVillageChange() {
                    this.updateCustomAddress();
                },

                getProvinceName() {
                    const item = this.provinces.find(p => p.id === this.selectedProvinceId);
                    return item ? this.capitalizeWord(item.name) : '';
                },
                getRegencyName() {
                    const item = this.regencies.find(r => r.id === this.selectedRegencyId);
                    return item ? this.capitalizeWord(item.name) : '';
                },
                getDistrictName() {
                    const item = this.districts.find(d => d.id === this.selectedDistrictId);
                    return item ? this.capitalizeWord(item.name) : '';
                },
                getVillageName() {
                    const item = this.villages.find(v => v.id === this.selectedVillageId);
                    return item ? this.capitalizeWord(item.name) : '';
                },
                capitalizeWord(str) {
                    if (!str) return '';
                    return str.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase()).join(' ');
                },

                updateCustomAddress() {
                    const prov = this.getProvinceName();
                    const kab  = this.getRegencyName();
                    const kec  = this.getDistrictName();
                    const kel  = this.getVillageName();

                    const parts = [
                        this.customRoad ? 'Jl. ' + this.customRoad : '',
                        this.customHouseNumber ? 'No. ' + this.customHouseNumber : '',
                        this.customRtRw ? 'RT/RW ' + this.customRtRw : '',
                        kel ? 'Kel. ' + kel : '',
                        kec ? 'Kec. ' + kec : '',
                        kab ? kab : '',
                        prov ? 'Prov. ' + prov : ''
                    ];
                    this.customAddress = parts.filter(p => p.trim().length > 0).join(', ');
                }
            };
        }
    </script>
@endsection
