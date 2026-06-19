@extends('layouts.admin')
@section('title', 'Pengaturan Landing Page')
@section('content')

@php
    $hero_title = \App\Models\Setting::get('hero_title', 'Solusi Distribusi Terpadu');
    $hero_subtitle = \App\Models\Setting::get('hero_subtitle', 'Untuk Skala Bisnis Besar, Menengah, & Kecil');
    $hero_desc = \App\Models\Setting::get('hero_desc', 'PT. Utama Madani Raya berkomitmen penuh menghadirkan produk berkualitas unggul dengan efisiensi rantai pasok yang andal, transparan, dan terintegrasi secara digital.');
    
    $tentang_p1 = \App\Models\Setting::get('tentang_p1', 'PT. Utama Madani Raya (UMAR) adalah perusahaan distributor dan mitra pengadaan resmi yang bergerak di bidang penyediaan berbagai kebutuhan barang untuk instansi, rumah sakit, dan pelaku usaha di wilayah Kalimantan Selatan. Berdiri dengan semangat melayani, kami berkomitmen menghadirkan produk berkualitas tinggi dengan harga yang kompetitif dan pengiriman yang tepat waktu.');
    $tentang_p2 = \App\Models\Setting::get('tentang_p2', 'Berkantor pusat di Jl. Panglima Batur, Kelurahan Loktabat Utara, Kecamatan Banjarbaru Utara, Kota Banjarbaru, Provinsi Kalimantan Selatan, kami didukung oleh infrastruktur pergudangan modern dan armada logistik internal yang siap menjangkau seluruh wilayah Kalimantan Selatan dan sekitarnya.');
    $tentang_p3 = \App\Models\Setting::get('tentang_p3', 'Seluruh operasional kami diperkuat oleh sistem Enterprise Resource Planning (ERP) buatan mandiri, sehingga setiap pergerakan stok, faktur, dan pesanan pelanggan terpantau secara real-time untuk menjamin transparansi dan akurasi layanan.');

    $kontak_alamat = \App\Models\Setting::get('kontak_alamat', 'Jl. Panglima Batur, Kel. Loktabat Utara, Kec. Banjarbaru Utara, Kota Banjarbaru, Kalimantan Selatan');
    $kontak_maps_link = \App\Models\Setting::get('kontak_maps_link', 'https://maps.app.goo.gl/VrDTohypqJf4KfRu9');
    $kontak_maps_iframe = \App\Models\Setting::get('kontak_maps_iframe', '-3.4392508,114.8387114');
    $kontak_phone = \App\Models\Setting::get('kontak_phone', '0851-6665-7171');
    $kontak_email = \App\Models\Setting::get('kontak_email', 'ptutamamadaniraya@gmail.com');
    $kontak_ig = \App\Models\Setting::get('kontak_ig', '@pt_umar');

    $jam_kantor_hari = \App\Models\Setting::get('jam_kantor_hari', '08.00 - 16.00 WITA');
    $jam_kantor_sabtu = \App\Models\Setting::get('jam_kantor_sabtu', '09.00 - 13.00 WITA');
    $jam_antar_hari = \App\Models\Setting::get('jam_antar_hari', '08.00 - 16.00 WITA');
    $jam_antar_sabtu = \App\Models\Setting::get('jam_antar_sabtu', '09.00 - 13.00 WITA');
@endphp

<div class="bg-white shadow rounded-lg p-6 max-w-5xl mx-auto mb-10">
    <div class="mb-6 border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-800">Pengaturan Landing Page</h2>
        <p class="text-sm text-gray-500 mt-1">Ubah teks dan informasi yang akan ditampilkan di halaman utama (Landing Page) perusahaan.</p>
    </div>

    <form action="{{ route('settings.landing-page.store') }}" method="POST">
        @csrf

        <!-- Section 1: Hero -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-tema-marun mb-4 border-b pb-2">Bagian 1: Layar Utama (Hero)</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul Utama</label>
                    <input type="text" name="hero_title" value="{{ old('hero_title', $hero_title) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sub-judul (Teks Kuning)</label>
                    <input type="text" name="hero_subtitle" value="{{ old('hero_subtitle', $hero_subtitle) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                    <textarea name="hero_desc" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>{{ old('hero_desc', $hero_desc) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 2: Tentang Kami -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-tema-marun mb-4 border-b pb-2">Bagian 2: Tentang Kami</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Paragraf 1 (Pengenalan)</label>
                    <textarea name="tentang_p1" rows="4" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>{{ old('tentang_p1', $tentang_p1) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Paragraf 2 (Lokasi & Infrastruktur)</label>
                    <textarea name="tentang_p2" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>{{ old('tentang_p2', $tentang_p2) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Paragraf 3 (Sistem ERP)</label>
                    <textarea name="tentang_p3" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>{{ old('tentang_p3', $tentang_p3) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Section 3: Kontak & Lokasi -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-tema-marun mb-4 border-b pb-2">Bagian 3: Hubungi Kami & Google Maps</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                    <textarea name="kontak_alamat" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>{{ old('kontak_alamat', $kontak_alamat) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Google Maps (Format Pendek)</label>
                    <input type="url" name="kontak_maps_link" value="{{ old('kontak_maps_link', $kontak_maps_link) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>
                    <p class="text-xs text-gray-500 mt-1">Contoh: https://maps.app.goo.gl/VrDTohypqJf4KfRu9</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Koordinat Iframe Maps</label>
                    <input type="text" name="kontak_maps_iframe" value="{{ old('kontak_maps_iframe', $kontak_maps_iframe) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>
                    <p class="text-xs text-gray-500 mt-1">Hanya masukkan koordinat atau query, contoh: -3.4392508,114.8387114</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon / WA</label>
                    <input type="text" name="kontak_phone" value="{{ old('kontak_phone', $kontak_phone) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="kontak_email" value="{{ old('kontak_email', $kontak_email) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username Instagram</label>
                    <input type="text" name="kontak_ig" value="{{ old('kontak_ig', $kontak_ig) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border" required>
                </div>
            </div>
        </div>

        <!-- Section 4: Jam Operasional -->
        <div class="mb-8">
            <h3 class="text-lg font-bold text-tema-marun mb-4 border-b pb-2">Bagian 4: Jam Operasional</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Kantor -->
                <div class="bg-gray-50 p-4 rounded-lg border">
                    <h4 class="font-bold text-gray-800 mb-3">Kantor / Karyawan</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Senin - Jum'at</label>
                            <input type="text" name="jam_kantor_hari" value="{{ old('jam_kantor_hari', $jam_kantor_hari) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Sabtu</label>
                            <input type="text" name="jam_kantor_sabtu" value="{{ old('jam_kantor_sabtu', $jam_kantor_sabtu) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border text-sm" required>
                        </div>
                    </div>
                </div>
                <!-- Pengantaran -->
                <div class="bg-gray-50 p-4 rounded-lg border">
                    <h4 class="font-bold text-gray-800 mb-3">Pengantaran Barang</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Senin - Jum'at</label>
                            <input type="text" name="jam_antar_hari" value="{{ old('jam_antar_hari', $jam_antar_hari) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border text-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Sabtu</label>
                            <input type="text" name="jam_antar_sabtu" value="{{ old('jam_antar_sabtu', $jam_antar_sabtu) }}" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun py-2 px-3 border text-sm" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 border-t pt-6">
            <button type="submit" class="bg-tema-kuning hover:bg-yellow-500 text-tema-hitam font-bold py-3 px-8 rounded-lg transition-colors shadow-md text-lg">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
