@php
    $layout = in_array(auth()->user()->role, ['superadmin', 'direktur', 'bendahara', 'staf_admin']) ? 'layouts.admin' : 'layouts.customer';
@endphp

@extends($layout)

@section('content')
    <div class="space-y-6 max-w-3xl {{ $layout === 'layouts.customer' ? 'mt-4' : '' }}" x-data="profileApp()">
        <div>
            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Profil & Pengaturan Akun</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi profil dan kata sandi Anda.</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md shadow-sm">
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-medium">Terdapat kesalahan:</p>
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
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="p-6 md:p-8 space-y-6">
                    <!-- Grid 2-kolom: Nama & Email -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-red-800 focus:ring focus:ring-red-800 focus:ring-opacity-50" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-red-800 focus:ring focus:ring-red-800 focus:ring-opacity-50" required>
                        </div>
                    </div>

                    <!-- Grid 2-kolom: Nomor HP & Nama Perusahaan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor HP / WhatsApp <span class="text-red-500">*</span></label>
                            <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $user->nomor_hp) }}" placeholder="Contoh: 08123456789" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-red-800 focus:ring focus:ring-red-800 focus:ring-opacity-50" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Perusahaan / Toko</label>
                            <input type="text" name="perusahaan" value="{{ old('perusahaan', $user->perusahaan) }}" placeholder="Contoh: UD. Berkah Jaya" class="w-full border px-4 py-3 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-red-800 focus:ring focus:ring-red-800 focus:ring-opacity-50">
                        </div>
                    </div>

                    <!-- Autocomplete Search Bar & Alamat Detail -->
                    <div class="space-y-4 pt-2 relative" x-data="{ clickOutside() { showSuggestions = false } }" @click.away="clickOutside()">
                        <input type="hidden" name="alamat" x-model="customAddress">
                        
                        <!-- Search / Autocomplete Bar -->
                        <div class="space-y-1.5 relative">
                            <label class="text-sm font-semibold text-gray-700 block">Cari Alamat Lengkap (Google Maps / Autocomplete)</label>
                            <div class="relative">
                                <input 
                                    type="text"
                                    x-model="customAddress" 
                                    @input="fetchAddressSuggestions()"
                                    @focus="showSuggestions = addressSuggestions.length > 0"
                                    placeholder="Ketik nama jalan, gedung, atau daerah untuk mencari otomatis..." 
                                    class="w-full border px-4 py-3 pl-10 bg-gray-50 rounded-xl border-gray-300 shadow-sm focus:bg-white focus:border-red-800 focus:ring focus:ring-red-800 focus:ring-opacity-50">
                                
                                <!-- Search Icon -->
                                <span class="absolute left-3.5 top-3.5 text-gray-400">🔍</span>

                                <!-- Loader -->
                                <div x-show="isSearchingAddress" class="absolute right-3.5 top-3 flex items-center gap-1.5 pointer-events-none select-none bg-gray-50/80 px-2 py-1 rounded-lg">
                                    <svg class="animate-spin h-4 w-4 text-red-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
