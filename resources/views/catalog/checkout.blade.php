@extends('layouts.customer')
@section('title', 'Checkout - E-Catalog UMAR')

@section('content')
<div class="space-y-6 pb-12" x-data="checkoutApp()">
    
    <div class="flex items-center gap-3 mb-2">
        <a href="{{ route('catalog.index') }}" class="w-9 h-9 bg-white border border-gray-200 text-gray-700 rounded-xl flex items-center justify-center hover:bg-gray-100 hover:border-gray-300 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <div class="flex items-center gap-2">
                <h2 class="text-2xl font-heading font-bold text-gray-800">Checkout Pesanan</h2>
                {{-- Tier Badge --}}
                @php
                    $tier = $user->tipe_pelanggan ?? 'reguler';
                    $tierBadge = match($tier) {
                        'premium' => ['label' => '🌟 Premium', 'class' => 'bg-yellow-100 text-yellow-800 border-yellow-300'],
                        'member'  => ['label' => '🔵 Member',  'class' => 'bg-blue-100 text-blue-800 border-blue-300'],
                        default   => ['label' => '⬜ Reguler', 'class' => 'bg-gray-100 text-gray-600 border-gray-300'],
                    };
                @endphp
                <span class="text-xs font-bold px-2.5 py-1 rounded-full border {{ $tierBadge['class'] }}">{{ $tierBadge['label'] }}</span>
            </div>
            <p class="text-xs text-gray-500">Selesaikan detail pengiriman untuk memproses pesanan Anda</p>
        </div>
    </div>

    {{-- Peringatan Invoice Diblokir --}}
    @if($invoiceBlocked)
    <div class="bg-red-50 border-l-4 border-red-500 rounded-2xl p-4 flex items-start gap-3 shadow-sm">
        <div class="flex-shrink-0 w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mt-0.5">
            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <p class="text-sm font-black text-red-700">⚠ Metode Invoice 30 Hari Diblokir Sementara</p>
            <p class="text-xs text-red-600 mt-1 leading-relaxed">Anda memiliki invoice dengan metode <strong>Invoice 30 Hari</strong> yang telah melewati tanggal jatuh tempo lebih dari 3 hari dan <strong>belum dilunasi</strong>. Metode pembayaran Invoice 30 Hari tidak dapat digunakan hingga invoice tersebut diselesaikan. Silakan pilih <strong>Tunai</strong> atau <strong>Transfer</strong> untuk melanjutkan pesanan.</p>
        </div>
    </div>
    @endif

    <template x-if="cart.length === 0">
        <div class="bg-white border border-gray-200 rounded-2xl p-12 text-center shadow-sm">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Keranjang Belanja Kosong</h3>
            <p class="text-sm text-gray-500 mb-6 font-medium">Anda belum memilih produk apapun untuk dibeli.</p>
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center px-6 py-3 bg-[#111827] hover:bg-black text-[#FBBF24] font-bold text-sm rounded-xl transition-all shadow-md">
                Kembali ke Katalog
            </a>
        </div>
    </template>

    <template x-if="cart.length > 0">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            
            <!-- Left: Checkout Forms -->
            <form @submit.prevent="submitCheckout" class="lg:col-span-7 space-y-6">
                <!-- Shipping Address Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="font-heading font-bold text-gray-800 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Alamat Pengiriman
                    </h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Option 1: Profile Address -->
                        <label class="relative border-2 rounded-xl p-4 flex flex-col cursor-pointer transition-all focus-within:ring-2 focus-within:ring-tema-marun"
                            :class="shippingAddressType === 'default' ? 'border-[#111827] bg-gray-50' : 'border-gray-100 hover:border-gray-200 bg-white'">
                            <div class="flex items-center gap-2 mb-2">
                                <input type="radio" name="address_type" value="default" x-model="shippingAddressType" class="text-tema-marun focus:ring-tema-marun h-4 w-4 border-gray-300">
                                <span class="font-bold text-sm text-gray-800">Alamat Profil</span>
                            </div>
                            <span class="text-xs text-gray-500 leading-relaxed truncate-3-lines" x-text="defaultAddress || 'Alamat profil belum diisi. Lengkapi di halaman Profil.'"></span>
                        </label>

                        <!-- Option 2: Custom Address -->
                        <label class="relative border-2 rounded-xl p-4 flex flex-col cursor-pointer transition-all focus-within:ring-2 focus-within:ring-tema-marun"
                            :class="shippingAddressType === 'new' ? 'border-[#111827] bg-gray-50' : 'border-gray-100 hover:border-gray-200 bg-white'">
                            <div class="flex items-center gap-2 mb-2">
                                <input type="radio" name="address_type" value="new" x-model="shippingAddressType" class="text-tema-marun focus:ring-tema-marun h-4 w-4 border-gray-300">
                                <span class="font-bold text-sm text-gray-800">Kirim ke Alamat Baru</span>
                            </div>
                            <span class="text-xs text-gray-500 leading-relaxed">Tuliskan alamat tujuan pengiriman logistik baru Anda.</span>
                        </label>

                        <!-- Option 3: Pickup (Ambil Sendiri) -->
                        <label class="relative border-2 rounded-xl p-4 flex flex-col cursor-pointer transition-all focus-within:ring-2 focus-within:ring-tema-marun"
                            :class="shippingAddressType === 'pickup' ? 'border-[#111827] bg-gray-50' : 'border-gray-100 hover:border-gray-200 bg-white'">
                            <div class="flex items-center gap-2 mb-2">
                                <input type="radio" name="address_type" value="pickup" x-model="shippingAddressType" class="text-tema-marun focus:ring-tema-marun h-4 w-4 border-gray-300">
                                <span class="font-bold text-sm text-gray-800">Ambil Sendiri</span>
                            </div>
                            <span class="text-xs text-gray-500 leading-relaxed">Ambil pesanan secara langsung di toko / gudang utama kami.</span>
                        </label>
                    </div>

                    <!-- Custom Address Input with Autocomplete & Detail Fields -->
                    <div x-show="shippingAddressType === 'new'" x-transition class="space-y-4 pt-2 relative" x-data="{ clickOutside() { showSuggestions = false } }" @click.away="clickOutside()">
                        
                        <!-- Search / Autocomplete Bar -->
                        <div class="space-y-1.5 relative">
                            <label class="text-xs font-bold text-gray-700 block">Cari Alamat Lengkap (Google Maps / Autocomplete) <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input 
                                    type="text"
                                    x-model="customAddress" 
                                    @input="fetchAddressSuggestions()"
                                    @focus="showSuggestions = addressSuggestions.length > 0"
                                    placeholder="Ketik nama jalan, gedung, atau daerah untuk mencari otomatis..." 
                                    class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl p-3 pl-10 focus:ring-tema-marun focus:border-tema-marun transition-all" 
                                    :required="shippingAddressType === 'new'">
                                
                                <!-- Search Icon -->
                                <span class="absolute left-3 top-3.5 text-gray-400">🔍</span>

                                <!-- Loader -->
                                <div x-show="isSearchingAddress" class="absolute right-3 top-2.5 flex items-center gap-1.5 pointer-events-none select-none bg-gray-50/80 px-2 py-1 rounded-lg">
                                    <svg class="animate-spin h-3.5 w-3.5 text-tema-marun" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                            </div>

                            <!-- Suggestions Dropdown -->
                            <div x-show="showSuggestions" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="opacity-0 transform scale-95"
                                 x-transition:enter-end="opacity-100 transform scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 transform scale-100"
                                 x-transition:leave-end="opacity-0 transform scale-95"
                                 class="absolute left-0 right-0 mt-1 bg-white border border-gray-200 rounded-2xl shadow-xl z-50 overflow-hidden divide-y divide-gray-50 max-h-60 overflow-y-auto">
                                
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
                        <div class="bg-gray-50/50 p-4 border border-gray-150 rounded-2xl space-y-3">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Detail Alamat Pengiriman</p>
                            
                            <!-- Row 1: Nama Jalan -->
                            <div class="space-y-1">
                                <label class="text-[11px] font-semibold text-gray-600">Nama Jalan / Gedung / Patokan</label>
                                <input type="text" x-model="customRoad" @input="updateCustomAddress()" placeholder="Contoh: Jl. Panglima Batur" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all">
                            </div>

                            <!-- Row 2: No Rumah & RT/RW -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">Nomor Rumah / Blok</label>
                                    <input type="text" x-model="customHouseNumber" @input="updateCustomAddress()" placeholder="Contoh: No. 12B" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all">
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">RT / RW</label>
                                    <input type="text" x-model="customRtRw" @input="updateCustomAddress()" placeholder="Contoh: 003/002" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all">
                                </div>
                            </div>

                            <!-- Row 3: Provinsi & Kota / Kabupaten -->
                            <div class="grid grid-cols-2 gap-3">
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">Provinsi <span class="text-red-500">*</span></label>
                                    <select x-model="selectedProvinceId" @change="onProvinceChange()" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all" :required="shippingAddressType === 'new'">
                                        <option value="" x-text="isLoadingProvinces ? 'Memuat Provinsi...' : '-- Pilih Provinsi --'"></option>
                                        <template x-for="p in provinces" :key="p.id">
                                            <option :value="p.id" x-text="capitalizeWord(p.name)" :selected="p.id === selectedProvinceId"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">Kota / Kabupaten <span class="text-red-500">*</span></label>
                                    <select x-model="selectedRegencyId" @change="onRegencyChange()" :disabled="!selectedProvinceId || isLoadingRegencies" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all disabled:opacity-50 disabled:bg-gray-100" :required="shippingAddressType === 'new'">
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
                                    <label class="text-[11px] font-semibold text-gray-600">Kecamatan <span class="text-red-500">*</span></label>
                                    <select x-model="selectedDistrictId" @change="onDistrictChange()" :disabled="!selectedRegencyId || isLoadingDistricts" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all disabled:opacity-50 disabled:bg-gray-100" :required="shippingAddressType === 'new'">
                                        <option value="" x-text="isLoadingDistricts ? 'Memuat Kecamatan...' : '-- Pilih Kecamatan --'"></option>
                                        <template x-for="d in districts" :key="d.id">
                                            <option :value="d.id" x-text="capitalizeWord(d.name)" :selected="d.id === selectedDistrictId"></option>
                                        </template>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-[11px] font-semibold text-gray-600">Kelurahan / Desa <span class="text-red-500">*</span></label>
                                    <select x-model="selectedVillageId" @change="onVillageChange()" :disabled="!selectedDistrictId || isLoadingVillages" class="w-full text-xs bg-white border border-gray-200 rounded-lg p-2.5 focus:ring-tema-marun focus:border-tema-marun transition-all disabled:opacity-50 disabled:bg-gray-100" :required="shippingAddressType === 'new'">
                                        <option value="" x-text="isLoadingVillages ? 'Memuat Kelurahan/Desa...' : '-- Pilih Kelurahan/Desa --'"></option>
                                        <template x-for="v in villages" :key="v.id">
                                            <option :value="v.id" x-text="capitalizeWord(v.name)" :selected="v.id === selectedVillageId"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Info Box for Pickup -->
                    <div x-show="shippingAddressType === 'pickup'" x-transition class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3 mt-2">
                        <span class="text-lg">🏪</span>
                        <div>
                            <p class="text-xs font-bold text-amber-800">Informasi Pengambilan Sendiri</p>
                            <p class="text-[11px] text-amber-700 mt-0.5 leading-relaxed">Anda dapat mengambil barang pesanan langsung di toko / gudang utama <strong>PT Utama Madani Raya (UMAR)</strong> setelah pesanan dikonfirmasi oleh Admin. Tidak dikenakan biaya pengiriman (Ongkir Rp 0).</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Option Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4" x-show="shippingAddressType !== 'pickup'">
                    <h3 class="font-heading font-bold text-gray-800 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zm12 0a2 2 0 11-4 0 2 2 0 014 0zm0 0V9a2 2 0 00-2-2h-5M9 7V5a2 2 0 012-2h4a2 2 0 012 2v2m-3 5h3m-6 0h3m-3 0a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        Metode Pengiriman
                    </h3>

                    <div class="space-y-3">
                        <!-- Pilihan Metode Dinonaktifkan Sementara (Hanya Kurir Internal Toko yang Aktif) -->
                        <div class="hidden">
                            <input type="radio" name="shipping_type" value="internal" x-model="shippingType">
                        </div>

                        <!-- Kurir Toko Info Flat Tarif (Selalu Aktif) -->
                        <div class="p-3 bg-blue-50/50 border border-blue-200 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-2 transition-all">
                            <div class="flex items-center gap-2">
                                <span class="text-sm">🚚</span>
                                <div>
                                    <span class="text-[10px] text-gray-400 font-bold block uppercase tracking-wider">Kurir Internal</span>
                                    <span class="text-xs text-gray-800 font-black">Armada PT UMAR (Banjarbaru, Martapura & Banjarmasin)</span>
                                    <p class="text-[10px] text-gray-500 mt-0.5">Wilayah Terdeteksi: <strong class="text-gray-700" x-text="detectedRegion.name"></strong></p>
                                </div>
                            </div>
                            <div class="text-left sm:text-right">
                                <span class="text-[10px] text-gray-400 font-bold block uppercase tracking-wider">Tarif Pengiriman</span>
                                <span class="text-sm text-blue-800 font-black" x-text="shippingCost > 0 ? 'Rp ' + shippingCost.toLocaleString('id-ID') : 'Gratis / Rp 0'"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- === METODE PEMBAYARAN === -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="font-heading font-bold text-gray-800 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                        Metode Pembayaran
                    </h3>

                    <div class="space-y-3">
                        <!-- Opsi TUNAI -->
                        <label class="flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all"
                            :class="metodePembayaran === 'tunai' ? 'border-[#111827] bg-gray-50' : 'border-gray-100 hover:border-gray-200'">
                            <input type="radio" name="metode_pembayaran" value="tunai" x-model="metodePembayaran" class="mt-0.5 h-4 w-4 text-tema-marun border-gray-300 focus:ring-tema-marun">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">💵</span>
                                    <span class="font-bold text-sm text-gray-800">Tunai (Cash)</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Pembayaran dilakukan secara tunai saat barang diterima atau saat pengambilan.</p>
                            </div>
                        </label>

                        <!-- Opsi TRANSFER -->
                        <label class="flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all"
                            :class="metodePembayaran === 'transfer' ? 'border-[#111827] bg-gray-50' : 'border-gray-100 hover:border-gray-200'">
                            <input type="radio" name="metode_pembayaran" value="transfer" x-model="metodePembayaran" class="mt-0.5 h-4 w-4 text-tema-marun border-gray-300 focus:ring-tema-marun">
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg">🏦</span>
                                    <span class="font-bold text-sm text-gray-800">Transfer Bank</span>
                                </div>
                                <!-- Info Rekening BSI -->
                                <div class="mt-2 p-3 bg-green-50 border border-green-200 rounded-xl space-y-1">
                                    <p class="text-[10px] font-bold text-green-700 uppercase tracking-wide">Rekening Resmi Perusahaan</p>
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-black text-green-800">BSI</span>
                                            <span class="text-xs text-green-700">—</span>
                                            <span id="norek-bsi" class="text-sm font-mono font-black text-green-800 tracking-widest">7343793687</span>
                                        </div>
                                        {{-- Tombol Salin Nomor Rekening --}}
                                        <button
                                            type="button"
                                            onclick="salinNorek(this)"
                                            data-norek="7343793687"
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-600 hover:bg-green-700 active:scale-95 text-white text-[10px] font-black rounded-lg transition-all duration-150 shadow-sm select-none"
                                            title="Salin nomor rekening">
                                            <svg id="icon-copy" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="btn-label">Salin</span>
                                        </button>
                                    </div>
                                    <p class="text-[11px] text-green-700 font-semibold">A/N : PT Utama Madani Raya</p>
                                    <p class="text-[10px] text-green-600 mt-1">Lampirkan bukti transfer ke staf admin setelah melakukan pembayaran.</p>
                                </div>
                            </div>
                        </label>

                        {{-- Opsi INVOICE 30 HARI — hanya untuk Premium --}}
                        @if($user->tipe_pelanggan === 'premium')
                            @if($invoiceBlocked)
                            {{-- DIBLOKIR: tampilkan opsi dengan kunci dan pesan jelas --}}
                            <div class="flex items-start gap-3 p-4 border-2 border-dashed border-red-200 rounded-xl bg-red-50/50 cursor-not-allowed opacity-70">
                                <div class="mt-0.5 h-4 w-4 rounded-full border-2 border-red-300 bg-red-100 flex-shrink-0"></div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-lg grayscale">📋</span>
                                        <span class="font-bold text-sm text-red-500">Invoice Jatuh Tempo 30 Hari</span>
                                        <span class="text-[10px] font-bold bg-red-100 text-red-600 px-2 py-0.5 rounded-full border border-red-200">🔒 Diblokir</span>
                                    </div>
                                    <p class="text-xs text-red-500 mt-1">Opsi ini dinonaktifkan karena Anda memiliki invoice jatuh tempo yang belum dilunasi melewati masa tenggang 3 hari.</p>
                                </div>
                            </div>
                            @else
                            {{-- AKTIF: Invoice 30 hari tersedia --}}
                            <label class="flex items-start gap-3 p-4 border-2 rounded-xl cursor-pointer transition-all"
                                :class="metodePembayaran === 'invoice_30_hari' ? 'border-yellow-400 bg-yellow-50' : 'border-gray-100 hover:border-yellow-200'">
                                <input type="radio" name="metode_pembayaran" value="invoice_30_hari" x-model="metodePembayaran" class="mt-0.5 h-4 w-4 text-yellow-600 border-gray-300 focus:ring-yellow-500">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-lg">📋</span>
                                        <span class="font-bold text-sm text-gray-800">Invoice Jatuh Tempo 30 Hari</span>
                                        <span class="text-[10px] font-bold bg-yellow-200 text-yellow-800 px-2 py-0.5 rounded-full border border-yellow-300">Khusus Premium</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Invoice akan diterbitkan dan pembayaran dapat dilakukan dalam 30 hari setelah barang diterima.</p>
                                    <div class="mt-2 p-2.5 bg-amber-50 border border-amber-200 rounded-xl">
                                        <p class="text-[10px] font-bold text-amber-700">📌 Catatan Penting:</p>
                                        <p class="text-[10px] text-amber-700 mt-0.5 leading-relaxed">Invoice harus dilunasi sesuai tanggal jatuh tempo. Terdapat masa tenggang <strong>3 hari</strong> setelah jatuh tempo. Jika melewati masa tenggang dan belum lunas, metode pembayaran Invoice 30 Hari akan <strong>diblokir</strong> hingga seluruh tagihan diselesaikan.</p>
                                    </div>
                                </div>
                            </label>
                            @endif
                        @else
                        {{-- Non-Premium: tampilkan opsi terkunci --}}
                        <div class="flex items-start gap-3 p-4 border-2 border-dashed border-gray-200 rounded-xl opacity-50 cursor-not-allowed">
                            <div class="mt-0.5 h-4 w-4 rounded-full border-2 border-gray-300 bg-gray-100 flex-shrink-0"></div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-lg grayscale">📋</span>
                                    <span class="font-bold text-sm text-gray-400">Invoice Jatuh Tempo 30 Hari</span>
                                    <span class="text-[10px] font-bold bg-gray-100 text-gray-400 px-2 py-0.5 rounded-full border border-gray-200">🔒 Khusus Premium</span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Upgrade akun Anda ke tier <strong>Premium</strong> untuk mendapatkan akses metode pembayaran ini.</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Notes Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="font-heading font-bold text-gray-800 text-lg flex items-center gap-2">
                        <svg class="w-5 h-5 text-tema-marun" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Catatan Pengiriman
                    </h3>
                    <div class="space-y-1.5">
                        <textarea x-model="catatanPengiriman" rows="2" placeholder="Catatan opsional untuk kurir (misal: titipkan ke satpam, taruh di garasi samping...)" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl p-3 focus:ring-tema-marun focus:border-tema-marun transition-all"></textarea>
                    </div>
                </div>
            </form>

            <!-- Right: Order Summary -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <h3 class="font-heading font-bold text-gray-800 text-lg border-b border-gray-100 pb-3">Ringkasan Belanja</h3>
                    
                    <!-- Items List -->
                    <div class="divide-y divide-gray-100 overflow-y-auto max-h-[250px] pr-1">
                        <template x-for="item in cart" :key="item.id">
                            <div class="py-3 flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <h4 class="text-xs font-bold text-gray-800 leading-tight" x-text="item.name"></h4>
                                    <p class="text-[10px] text-gray-500 font-semibold mt-1" x-text="item.qty + ' pcs x Rp ' + getItemPrice(item).toLocaleString('id-ID')"></p>
                                    <!-- Tampilkan badge diskon jika ada -->
                                    <template x-if="getItemDiscount(item) > 0">
                                        <p class="text-[10px] text-green-600 font-bold mt-0.5" x-text="'Hemat Rp ' + getItemDiscount(item).toLocaleString('id-ID') + '/pcs'"></p>
                                    </template>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-black text-gray-800" x-text="'Rp ' + (getItemPrice(item) * item.qty).toLocaleString('id-ID')"></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Pricing Math -->
                    <div class="border-t border-gray-100 pt-4 space-y-2.5">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500 font-semibold">Subtotal</span>
                            <span class="text-gray-800 font-bold" x-text="'Rp ' + cartTotal.toLocaleString('id-ID')"></span>
                        </div>
                        <!-- Tampilkan total diskon jika ada -->
                        <template x-if="totalCartDiscount > 0">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-green-600 font-semibold">Total Diskon Tier</span>
                                <span class="text-green-600 font-bold" x-text="'- Rp ' + totalCartDiscount.toLocaleString('id-ID')"></span>
                            </div>
                        </template>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500 font-semibold">Estimasi PPN (11%)</span>
                            <span class="text-gray-800 font-bold text-gray-600" x-text="'Rp ' + ppnEstimate.toLocaleString('id-ID')"></span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-gray-500 font-semibold">Biaya Pengiriman (Ongkir)</span>
                            <span class="text-gray-800 font-bold" :class="shippingCost > 0 ? 'text-gray-850' : 'text-green-600 font-black'" x-text="shippingCost > 0 ? 'Rp ' + shippingCost.toLocaleString('id-ID') : 'Gratis / Rp 0'"></span>
                        </div>
                        <div class="border-t border-dashed border-gray-200 pt-3 flex justify-between items-center">
                            <span class="text-sm font-bold text-gray-800">Total Tagihan</span>
                            <span class="text-lg font-black text-tema-marun" x-text="'Rp ' + (cartTotal + shippingCost).toLocaleString('id-ID')"></span>
                        </div>
                        <!-- Info metode pembayaran yang dipilih -->
                        <template x-if="metodePembayaran">
                            <div class="flex items-center gap-2 pt-1">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                <span class="text-xs text-gray-500" x-text="'Bayar via: ' + getMetodeLabel()"></span>
                            </div>
                        </template>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4 border-t border-gray-100">
                        <button type="button" @click="submitCheckout" :disabled="isSubmitting || !metodePembayaran" class="w-full bg-[#111827] hover:bg-black text-[#FBBF24] text-sm font-bold py-4 rounded-xl shadow-lg transition-colors flex items-center justify-center disabled:opacity-50">
                            <span x-show="!isSubmitting">Buat Pesanan &amp; Kirim</span>
                            <span x-show="isSubmitting" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-[#FBBF24]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Memproses...
                            </span>
                        </button>
                        <p x-show="!metodePembayaran" class="mt-2 text-xs text-amber-600 text-center font-semibold">⚠ Silakan pilih metode pembayaran terlebih dahulu.</p>
                        <p x-show="errorMessage" class="mt-3 text-xs text-red-600 text-center font-bold" x-text="errorMessage"></p>
                    </div>
                </div>

                {{-- Info Tier Pelanggan --}}
                @php
                    $tier      = $user->tipe_pelanggan ?? 'reguler';
                    $diskonPct = match($tier) { 'premium' => '0.3%', 'member' => '0.2%', default => null };
                @endphp
                @if($tier !== 'reguler')
                <div class="bg-gradient-to-br {{ $tier === 'premium' ? 'from-yellow-50 to-amber-50 border-yellow-200' : 'from-blue-50 to-sky-50 border-blue-200' }} border rounded-2xl p-4">
                    <p class="text-xs font-bold {{ $tier === 'premium' ? 'text-yellow-700' : 'text-blue-700' }} mb-1">
                        {{ $tier === 'premium' ? '🌟 Keuntungan Pelanggan Premium' : '🔵 Keuntungan Pelanggan Member' }}
                    </p>
                    <ul class="text-xs {{ $tier === 'premium' ? 'text-yellow-700' : 'text-blue-700' }} space-y-1">
                        @if($tier === 'member')
                        <li>✅ Harga grosir berlaku otomatis saat beli min. 12 pcs per item</li>
                        <li>✅ Diskon tambahan <strong>0.2%</strong> di atas harga grosir</li>
                        <li>✅ Pembayaran: Tunai / Transfer Bank</li>
                        @elseif($tier === 'premium')
                        <li>✅ Harga grosir berlaku otomatis untuk semua pembelian</li>
                        <li>✅ Diskon tambahan <strong>0.3%</strong> di atas harga grosir</li>
                        <li>✅ Pembayaran: Tunai / Transfer Bank / Invoice 30 Hari</li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>

        </div>
    </template>
</div>

<script>
    function checkoutApp() {
        return {
            cart: JSON.parse(localStorage.getItem('jukung_cart') || '[]'),
            shippingAddressType: 'default',
            defaultAddress: '{{ addslashes($user->alamat ?? "") }}',
            customAddress: '',
            customRoad: '',
            customHouseNumber: '',
            customRtRw: '',
            customKelurahan: '',
            customKecamatan: '',
            customKota: '',

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
            shippingType: 'internal',
            ekspedisiName: '',
            selectedCourier: '',
            catatanPengiriman: '',
            metodePembayaran: 'tunai',
            isSubmitting: false,
            errorMessage: '',

            tipePelanggan: '{{ $user->tipe_pelanggan ?? "reguler" }}',
            diskonRate: {{ $user->getDiskonRate() }},
            invoiceBlocked: {{ $invoiceBlocked ? 'true' : 'false' }},

            get selectedAddressText() {
                if (this.shippingAddressType === 'default') {
                    return this.defaultAddress;
                } else if (this.shippingAddressType === 'new') {
                    return this.customAddress;
                } else {
                    return 'Ambil Sendiri di Toko/Gudang Utama UMAR';
                }
            },

            get detectedRegion() {
                const addr = this.selectedAddressText.toLowerCase();
                if (this.shippingAddressType === 'pickup') {
                    return { name: 'Ambil Sendiri (Toko/Gudang)', key: 'pickup' };
                }
                if (!addr.trim()) {
                    return { name: 'Belum Diisi', key: 'unknown' };
                }
                
                // 1. Banjarmasin
                if (addr.includes('banjarmasin') || addr.includes('bjm')) {
                    return { name: 'Banjarmasin (Armada UMAR - Berbayar)', key: 'banjarmasin' };
                }
                // 2. Martapura / Matapura / MTP / Sekumpul / Indrasari / Tanjung Rema
                if (
                    addr.includes('martapura') || 
                    addr.includes('matapura') || 
                    addr.includes('mtp') || 
                    addr.includes('sekumpul') || 
                    addr.includes('indrasari') || 
                    addr.includes('tanjung rema') ||
                    (addr.includes('banjar') && !addr.includes('banjarbaru') && !addr.includes('banjarmasin') && !addr.includes('gambut') && !addr.includes('aluh-aluh') && !addr.includes('aluh aluh') && !addr.includes('kertak hanyar') && !addr.includes('kertakhanyar') && !addr.includes('sungai tabuk'))
                ) {
                    return { name: 'Martapura (Armada UMAR - Gratis)', key: 'martapura' };
                }
                // 3. Banjarbaru Panglima Batur (Free Delivery)
                if (addr.includes('panglima batur')) {
                    return { name: 'Banjarbaru (Sekitar Jl. Panglima Batur - Gratis)', key: 'banjarbaru_dekat' };
                }
                // 4. Banjarbaru Kota (BJB / Banjarbaru / Loktabat / Komet / Mentaos / Sungai Ulin / Landasan Ulin / Cempaka / Liang Anggang / Guntung Payung / Guntung Manggis)
                if (
                    addr.includes('banjarbaru') || 
                    addr.includes('bjb') || 
                    addr.includes('loktabat') || 
                    addr.includes('komet') || 
                    addr.includes('mentaos') || 
                    addr.includes('sungai ulin') || 
                    addr.includes('landasann ulin') || 
                    addr.includes('landasan ulin') || 
                    addr.includes('cempaka') || 
                    addr.includes('liang anggang') || 
                    addr.includes('lianganggang') || 
                    addr.includes('guntung payung') || 
                    addr.includes('guntung manggis') || 
                    addr.includes('banjarbaru selatan') ||
                    addr.includes('banjarbaru utara')
                ) {
                    return { name: 'Banjarbaru Kota (Armada UMAR - Gratis)', key: 'banjarbaru_kota' };
                }
                // 5. Sekitar Banjarbaru (Gambut / Kertak Hanyar / Sungai Tabuk / Aluh-Aluh)
                if (addr.includes('gambut') || addr.includes('kertak hanyar') || addr.includes('kertakhanyar') || addr.includes('sungai tabuk') || addr.includes('aluh-aluh') || addr.includes('aluh aluh')) {
                    return { name: 'Sekitar Banjarbaru (Gambut/Luar Kota - Berbayar)', key: 'banjarbaru_sekitar' };
                }
                // 6. Kalimantan Selatan (Luar Wilayah Utama)
                if (addr.includes('kalsel') || addr.includes('kalimantan selatan') || addr.includes('kotabaru') || addr.includes('tabalong') || addr.includes('tanjung') || addr.includes('rantau') || addr.includes('kandangan') || addr.includes('barabai') || addr.includes('amuntai') || addr.includes('paringin') || addr.includes('batulicin') || addr.includes('pelaihari') || addr.includes('marabahan')) {
                    return { name: 'Kalimantan Selatan (Luar Banjarbaru/Martapura/Banjarmasin)', key: 'kalsel_lain' };
                }
                // 7. Kalimantan (Luar Kalsel)
                if (addr.includes('kalimantan') || addr.includes('kalbar') || addr.includes('kaltim') || addr.includes('kalteng') || addr.includes('kaltara') || addr.includes('pontianak') || addr.includes('samarinda') || addr.includes('balikpapan') || addr.includes('palangkaraya')) {
                    return { name: 'Kalimantan (Luar Kalsel)', key: 'kalimantan_lain' };
                }
                if (addr.includes('jakarta') || addr.includes('tangerang') || addr.includes('bekasi') || addr.includes('depok') || addr.includes('bogor') || addr.includes('jabodetabek') || addr.includes('banten') || addr.includes('dki')) {
                    return { name: 'Jabodetabek & Banten', key: 'jabodetabek' };
                }
                if (addr.includes('jawa') || addr.includes('jabar') || addr.includes('jateng') || addr.includes('jatim') || addr.includes('bandung') || addr.includes('surabaya') || addr.includes('semarang') || addr.includes('yogyakarta') || addr.includes('diy')) {
                    return { name: 'Pulau Jawa', key: 'jawa' };
                }
                if (addr.includes('sumatera') || addr.includes('sumbar') || addr.includes('sumut') || addr.includes('sumsel') || addr.includes('aceh') || addr.includes('medan') || addr.includes('palembang') || addr.includes('lampung') || addr.includes('padang') || addr.includes('riau') || addr.includes('pekanbaru') || addr.includes('jambi') || addr.includes('bengkulu') || addr.includes('babel')) {
                    return { name: 'Pulau Sumatera', key: 'sumatera' };
                }
                if (addr.includes('sulawesi') || addr.includes('sulsel') || addr.includes('sultra') || addr.includes('sulut') || addr.includes('makassar') || addr.includes('manado') || addr.includes('palu') || addr.includes('kendari') || addr.includes('gorontalo')) {
                    return { name: 'Pulau Sulawesi', key: 'sulawesi' };
                }
                if (addr.includes('papua') || addr.includes('maluku') || addr.includes('bali') || addr.includes('ntt') || addr.includes('ntb') || addr.includes('denpasar') || addr.includes('kupang') || addr.includes('mataram') || addr.includes('ambon') || addr.includes('jayapura')) {
                    return { name: 'Papua, Maluku & Nusa Tenggara', key: 'papua' };
                }
                
                return { name: 'Luar Wilayah Utama', key: 'default' };
            },

            get shippingCost() {
                if (this.shippingAddressType === 'pickup') {
                    return 0;
                }
                const regionKey = this.detectedRegion.key;
                if (this.shippingType === 'internal') {
                    if (regionKey === 'banjarbaru_dekat') return 0;
                    if (regionKey === 'banjarbaru_kota') return 0;
                    if (regionKey === 'martapura') return 0;
                    if (regionKey === 'banjarmasin') return 25000;
                    if (regionKey === 'banjarbaru_sekitar') return 20000;
                    if (regionKey === 'kalsel_lain') return 35000;
                    return 50000;
                }
                if (this.shippingType === 'eksternal') {
                    if (!this.selectedCourier) return 0;
                    
                    const rates = {
                        'banjarbaru_dekat': { 'jne_reg': 9000, 'jne_oke': 6000, 'jnt': 10000, 'sicepat': 8000, 'pos': 7000, 'indah_cargo': 12000 },
                        'banjarbaru_kota': { 'jne_reg': 10000, 'jne_oke': 7000, 'jnt': 11000, 'sicepat': 9000, 'pos': 8000, 'indah_cargo': 15000 },
                        'martapura': { 'jne_reg': 12000, 'jne_oke': 9000, 'jnt': 13000, 'sicepat': 11000, 'pos': 10000, 'indah_cargo': 18000 },
                        'banjarmasin': { 'jne_reg': 12000, 'jne_oke': 9000, 'jnt': 13000, 'sicepat': 11000, 'pos': 10000, 'indah_cargo': 18000 },
                        'banjarbaru_sekitar': { 'jne_reg': 12000, 'jne_oke': 9000, 'jnt': 13000, 'sicepat': 11000, 'pos': 10000, 'indah_cargo': 18000 },
                        'kalsel_lain': { 'jne_reg': 15000, 'jne_oke': 12000, 'jnt': 16000, 'sicepat': 14000, 'pos': 13000, 'indah_cargo': 25000 },
                        'kalimantan_lain': { 'jne_reg': 25000, 'jne_oke': 20000, 'jnt': 26000, 'sicepat': 24000, 'pos': 23000, 'indah_cargo': 35000 },
                        'jabodetabek': { 'jne_reg': 30000, 'jne_oke': 25000, 'jnt': 32000, 'sicepat': 28000, 'pos': 27000, 'indah_cargo': 45000 },
                        'jawa': { 'jne_reg': 35000, 'jne_oke': 30000, 'jnt': 37000, 'sicepat': 34000, 'pos': 32000, 'indah_cargo': 50000 },
                        'sumatera': { 'jne_reg': 38000, 'jne_oke': 32000, 'jnt': 40000, 'sicepat': 36000, 'pos': 35000, 'indah_cargo': 55000 },
                        'sulawesi': { 'jne_reg': 40000, 'jne_oke': 34000, 'jnt': 42000, 'sicepat': 38000, 'pos': 36000, 'indah_cargo': 60000 },
                        'papua': { 'jne_reg': 65000, 'jne_oke': 55000, 'jnt': 68000, 'sicepat': 60000, 'pos': 58000, 'indah_cargo': 90000 },
                        'default': { 'jne_reg': 30000, 'jne_oke': 25000, 'jnt': 32000, 'sicepat': 28000, 'pos': 27000, 'indah_cargo': 45000 },
                    };

                    const activeRates = rates[regionKey] || rates['default'];
                    const courierKey = this.selectedCourier;
                    
                    return activeRates[courierKey] || 0;
                }
                return 0;
            },

            getItemPrice(item) {
                const hargaJual   = item.retailPrice  || 0;
                const hargaGrosir = item.wholesalePrice || 0;

                let isEligible = false;
                if (this.tipePelanggan === 'premium') {
                    isEligible = true;
                } else if (this.tipePelanggan === 'member' && item.qty >= 12) {
                    isEligible = true;
                }

                if (isEligible && hargaGrosir > 0) {
                    return Math.round(hargaGrosir * (1 - this.diskonRate));
                }
                return hargaJual;
            },

            getItemDiscount(item) {
                const hargaGrosir  = item.wholesalePrice || 0;
                const hargaAkhir   = this.getItemPrice(item);
                let hargaSebelum   = hargaGrosir > 0 && this.isItemEligible(item) ? hargaGrosir : 0;
                if (hargaSebelum === 0) return 0;
                return Math.max(0, hargaSebelum - hargaAkhir);
            },

            isItemEligible(item) {
                if (this.tipePelanggan === 'premium') return true;
                if (this.tipePelanggan === 'member' && item.qty >= 12) return true;
                return false;
            },

            get cartTotal() {
                return this.cart.reduce((total, item) => total + (this.getItemPrice(item) * item.qty), 0);
            },

            get totalCartDiscount() {
                return this.cart.reduce((total, item) => {
                    const d = this.getItemDiscount(item);
                    return total + (d * item.qty);
                }, 0);
            },

            get ppnEstimate() {
                return Math.round(this.cartTotal * 0.11);
            },

            getMetodeLabel() {
                const labels = {
                    'tunai'           : '💵 Tunai (Cash)',
                    'transfer'        : '🏦 Transfer Bank BSI',
                    'invoice_30_hari' : '📋 Invoice 30 Hari',
                };
                return labels[this.metodePembayaran] || this.metodePembayaran;
            },

            init() {
                this.isLoadingProvinces = true;
                fetch('/api/wilayah/provinces')
                    .then(res => res.json())
                    .then(data => {
                        this.provinces = data;
                        this.isLoadingProvinces = false;
                    })
                    .catch(err => {
                        console.error('Gagal mengambil provinsi:', err);
                        this.isLoadingProvinces = false;
                    });
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
                                    provinsi: state || ''
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
                // Normalisasi: hapus prefix umum dengan word-boundary agar tidak merusak isi kata
                const norm = (str) => {
                    if (!str) return '';
                    return str.toUpperCase()
                        .replace(/\b(PROVINSI|KABUPATEN|KOTA|KECAMATAN|KELURAHAN|DESA|DAERAH ISTIMEWA|DAERAH KHUSUS IBUKOTA|DKI)\b/g, '')
                        .replace(/[^A-Z0-9]/g, '')
                        .trim();
                };

                // Fungsi match fleksibel: cek contains dua arah + cek similarity awal kata
                const flexMatch = (listName, queryStr) => {
                    const q = norm(queryStr);
                    if (!q || q.length < 2) return null;

                    // Exact normalized match
                    let match = listName.find(item => norm(item.name) === q);
                    if (match) return match;

                    // Contains match (bidirectional)
                    match = listName.find(item => {
                        const n = norm(item.name);
                        return n.includes(q) || q.includes(n);
                    });
                    if (match) return match;

                    // Prefix match (at least 4 chars)
                    if (q.length >= 4) {
                        match = listName.find(item => {
                            const n = norm(item.name);
                            return n.startsWith(q.substring(0, 4)) || q.startsWith(n.substring(0, 4));
                        });
                    }
                    return match || null;
                };

                // Jika tidak ada provinsi dari geocoding, coba tetap sinkron dari kota saja
                if (!details.provinsi && !details.kota) {
                    this.updateCustomAddress();
                    return;
                }

                console.log('[JukungSync] Syncing regions - Provinsi:', details.provinsi, '| Kota:', details.kota, '| Kecamatan:', details.kecamatan, '| Kelurahan:', details.kelurahan);

                // Pastikan provinces sudah di-load
                const doSync = () => {
                    // --- PROVINSI ---
                    let matchedProv = null;
                    if (details.provinsi) {
                        matchedProv = flexMatch(this.provinces, details.provinsi);
                        console.log('[JukungSync] Province match result:', matchedProv ? matchedProv.name : 'NOT FOUND', '(query:', details.provinsi, ')');
                    }

                    // Jika provinsi tidak ditemukan tapi ada nama kota, cari provinsi dari semua regencies
                    if (!matchedProv && details.kota) {
                        const kotaNorm = norm(details.kota);
                        console.log('[JukungSync] Province not found, searching by city name:', kotaNorm);
                        // Brute-force: coba setiap provinsi dan cari regency-nya
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
                // Fallback: cari kota di beberapa provinsi Kalimantan Selatan (prioritas untuk Banjarbaru)
                const priorityProvinces = this.provinces.filter(p => {
                    const n = norm(p.name);
                    return n.includes('KALIMANTANSELATAN') || n.includes('KALIMANTANTIMUR') || n.includes('KALIMANTANTENGAH') || n.includes('KALIMANTANBARAT') || n.includes('KALIMANTANUTARA');
                });
                const otherProvinces = this.provinces.filter(p => !priorityProvinces.includes(p));
                const allProvs = [...priorityProvinces, ...otherProvinces];

                let found = false;
                let checkedCount = 0;

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

                // Start checking provinces - prioritize Kalimantan
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
            },

            submitCheckout() {
                if (this.cart.length === 0) return;
                if (!this.metodePembayaran) {
                    this.errorMessage = 'Silakan pilih metode pembayaran.';
                    return;
                }

                // Validate address
                let finalAddress = '';
                if (this.shippingAddressType === 'default') {
                    if (!this.defaultAddress) {
                        this.errorMessage = 'Alamat profil default kosong. Silakan lengkapi profil Anda atau masukkan alamat baru.';
                        return;
                    }
                    finalAddress = this.defaultAddress;
                } else if (this.shippingAddressType === 'new') {
                    if (!this.customAddress.trim()) {
                        this.errorMessage = 'Silakan isi alamat pengiriman baru Anda.';
                        return;
                    }
                    finalAddress = this.customAddress;
                } else {
                    finalAddress = 'Ambil Sendiri di Toko/Gudang Utama UMAR';
                }

                let finalExpedition = '';
                if (this.shippingAddressType === 'pickup') {
                    finalExpedition = 'Ambil Sendiri (Pickup)';
                } else if (this.shippingType === 'internal') {
                    finalExpedition = 'Kurir Internal PT. UMAR';
                } else {
                    if (!this.selectedCourier) {
                        this.errorMessage = 'Silakan pilih ekspedisi eksternal yang Anda inginkan.';
                        return;
                    }
                    const courierNames = {
                        'jne_reg': 'JNE Reguler',
                        'jne_oke': 'JNE OKE',
                        'jnt': 'J&T Express',
                        'sicepat': 'SiCepat Reg',
                        'pos': 'POS Kilat Khusus',
                        'indah_cargo': 'Indah Cargo',
                    };
                    finalExpedition = 'Ekspedisi Eksternal: ' + (courierNames[this.selectedCourier] || this.selectedCourier);
                }

                this.isSubmitting = true;
                this.errorMessage = '';

                const payload = {
                    items: this.cart.map(i => ({ product_id: i.id, qty: i.qty })),
                    alamat_pengiriman: finalAddress,
                    ekspedisi: finalExpedition,
                    catatan_pengiriman: this.catatanPengiriman,
                    metode_pembayaran: this.metodePembayaran,
                    ongkir: this.shippingCost,
                };

                fetch('{{ route('catalog.order') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => response.json())
                .then(data => {
                    this.isSubmitting = false;
                    if (data.success) {
                        localStorage.removeItem('jukung_cart');

                        // Cek apakah ada upgrade tier
                        if (data.tier_upgrade) {
                            // Tentukan emoji dan warna berdasarkan tier baru
                            const tierEmoji = data.tier_upgrade === 'Premium' ? '🌟' : '🔵';
                            const tierColor = data.tier_upgrade === 'Premium' ? '#d97706' : '#1d4ed8';
                            const totalFmt  = 'Rp ' + parseInt(data.total_pembelian).toLocaleString('id-ID');

                            Swal.fire({
                                icon: 'success',
                                title: `${tierEmoji} Selamat! Akun Anda Naik ke Tier ${data.tier_upgrade}!`,
                                html: `
                                    <div style="text-align:center;">
                                        <p style="color:#374151;font-size:14px;margin-bottom:12px;">
                                            Pesanan Anda berhasil dikirim dan total pembelian kumulatif Anda telah mencapai<br>
                                            <strong style="font-size:18px;color:${tierColor}">${totalFmt}</strong>
                                        </p>
                                        <div style="background:${data.tier_upgrade === 'Premium' ? '#fef3c7' : '#eff6ff'};border:2px solid ${tierColor};border-radius:12px;padding:12px 16px;margin:12px 0;">
                                            <p style="font-size:13px;color:${tierColor};font-weight:700;margin:0;">
                                                ${tierEmoji} Anda kini terdaftar sebagai pelanggan <strong>${data.tier_upgrade}</strong>!
                                            </p>
                                            <p style="font-size:11px;color:#6b7280;margin:6px 0 0;">
                                                ${data.tier_upgrade === 'Premium'
                                                    ? 'Nikmati harga grosir otomatis, diskon 0.3%, dan metode pembayaran Invoice 30 Hari.'
                                                    : 'Nikmati harga grosir untuk pembelian ≥12 pcs dan diskon tambahan 0.2%.'}
                                            </p>
                                        </div>
                                    </div>`,
                                confirmButtonColor: '#111827',
                                confirmButtonText: 'Lihat Riwayat Pesanan',
                                allowOutsideClick: false,
                            }).then(() => {
                                window.location.href = '{{ route('catalog.orders') }}';
                            });
                        } else {
                            // Pesanan berhasil tanpa upgrade tier
                            Swal.fire({
                                icon: 'success',
                                title: 'Pesanan Berhasil Dibuat!',
                                text: data.message,
                                confirmButtonColor: '#111827',
                                confirmButtonText: 'Buka Riwayat Pesanan'
                            }).then(() => {
                                window.location.href = '{{ route('catalog.orders') }}';
                            });
                        }
                    } else {
                        this.errorMessage = data.message || 'Terjadi kesalahan saat memproses pesanan.';
                    }
                })
                .catch(() => {
                    this.isSubmitting = false;
                    this.errorMessage = 'Terjadi kesalahan jaringan atau koneksi.';
                });
            }
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function salinNorek(btn) {
        const norek = btn.getAttribute('data-norek');
        const label = btn.querySelector('.btn-label');
        const svgPath = btn.querySelector('svg path');

        // Copy to clipboard
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(norek);
        } else {
            // Fallback for non-https
            const el = document.createElement('textarea');
            el.value = norek;
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        }

        // Visual feedback: green checkmark
        btn.classList.remove('bg-green-600', 'hover:bg-green-700');
        btn.classList.add('bg-green-700', 'ring-2', 'ring-green-400');
        svgPath.setAttribute('d', 'M5 13l4 4L19 7');  // checkmark icon
        label.textContent = 'Tersalin!';

        setTimeout(() => {
            btn.classList.add('bg-green-600', 'hover:bg-green-700');
            btn.classList.remove('bg-green-700', 'ring-2', 'ring-green-400');
            svgPath.setAttribute('d', 'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z');
            label.textContent = 'Salin';
        }, 2000);
    }
</script>
@endsection
