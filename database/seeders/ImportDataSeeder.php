<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class ImportDataSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'ATK' => Category::firstOrCreate(['nama_kategori' => 'ATK'], ['slug' => Str::slug('ATK')]),
            'IPSRS' => Category::firstOrCreate(['nama_kategori' => 'IPSRS'], ['slug' => Str::slug('IPSRS')]),
            'Kebersihan' => Category::firstOrCreate(['nama_kategori' => 'Kebersihan'], ['slug' => Str::slug('Kebersihan')]),
            'Perlengkapan Ibu&Bayi' => Category::firstOrCreate(['nama_kategori' => 'Perlengkapan Ibu&Bayi'], ['slug' => Str::slug('Perlengkapan Ibu&Bayi')]),
        ];

        Product::updateOrCreate(
            ['sku' => 'A-001'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Kertas A4',
                'deskripsi' => 'Satuan: RIM',
                'harga_modal' => 197000.0,
                'harga_jual' => 215000.0,
                'stok_saat_ini' => 8,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-002'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Kertas F4',
                'deskripsi' => 'Satuan: RIM',
                'harga_modal' => 220000.0,
                'harga_jual' => 230000.0,
                'stok_saat_ini' => 3,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-003'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Bantex Display Book 60 pockets',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 30000.0,
                'harga_jual' => 60000.0,
                'stok_saat_ini' => 6,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-004'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Bantex Display Book 40 pockets',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 58000.0,
                'harga_jual' => 50000.0,
                'stok_saat_ini' => 1,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-005'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Bantex ERD Box',
                'deskripsi' => 'Satuan: BOX',
                'harga_modal' => 37000.0,
                'harga_jual' => 40000.0,
                'stok_saat_ini' => 16,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-006'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Business File Benefit isi 12',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 23000.0,
                'harga_jual' => 25000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-007'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Business File Jennia isi 12',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 22000.0,
                'harga_jual' => 24000.0,
                'stok_saat_ini' => 60,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-008'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Binder Clips Benefit No. 107',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 1,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-009'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Binder Clips Benefit No. 105',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 35000.0,
                'harga_jual' => 35000.0,
                'stok_saat_ini' => 1,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-010'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Binder Clips Benefit No. 260',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 14000.0,
                'harga_jual' => 15000.0,
                'stok_saat_ini' => 14,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-011'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Stopmap Folio isi 50',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 23000.0,
                'harga_jual' => 35000.0,
                'stok_saat_ini' => 4,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-012'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Kertas Bufallo Super',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 22000.0,
                'harga_jual' => 30000.0,
                'stok_saat_ini' => 1,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-013'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Kertas Buffalo F4',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 22000.0,
                'harga_jual' => 26000.0,
                'stok_saat_ini' => 3,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-014'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Pulpen Gel lnk ball clip 0.5 blue',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 27000.0,
                'harga_jual' => 30000.0,
                'stok_saat_ini' => 210,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-015'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Pulpen Cool 520 Gel 0.5 fine black',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 25000.0,
                'harga_jual' => 28000.0,
                'stok_saat_ini' => 155,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-016'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Pulpen Pilot Black',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 36000.0,
                'harga_jual' => 38000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-017'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Pulpen Pilot Blue',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 36000.0,
                'harga_jual' => 38000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-018'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Pulpen V-Tec Table Gel Pen',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 6600.0,
                'harga_jual' => 8000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-019'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Faber Castell Spidol Permanen',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 66000.0,
                'harga_jual' => 70000.0,
                'stok_saat_ini' => 14,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-020'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Fabel Castell Spidol White board marker',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 66000.0,
                'harga_jual' => 70000.0,
                'stok_saat_ini' => 14,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-021'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Snowman Spidol Boardmark Hitam',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 85000.0,
                'harga_jual' => 87000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-022'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Snowman Spidol Boardmark Red',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 85000.0,
                'harga_jual' => 87000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-023'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Lakban 48mmx90 Bening(putih)',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 8000.0,
                'harga_jual' => 13000.0,
                'stok_saat_ini' => 1,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-024'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Lakban 48mmx90 Kuning',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 8000.0,
                'harga_jual' => 13000.0,
                'stok_saat_ini' => 23,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-025'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Lakban 48mmx90 Hitam (Borneo)',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 8000.0,
                'harga_jual' => 18000.0,
                'stok_saat_ini' => 32,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-026'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Lakban 48mmx90 Hitam (OKKEY)',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 8000.0,
                'harga_jual' => 13000.0,
                'stok_saat_ini' => 11,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-027'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Lakban 48mmx90 Coklat',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 8000.0,
                'harga_jual' => 13000.0,
                'stok_saat_ini' => 56,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-028'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Isolasi Borneo Cello 12mmx10',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 1100.0,
                'harga_jual' => 1300.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-029'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Isolasi Borneo Cello 12mmx25',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 1800.0,
                'harga_jual' => 3000.0,
                'stok_saat_ini' => 32,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-030'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Kenko Double Tape Kecil',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 2800.0,
                'harga_jual' => 5000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-031'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Borneo Double Tape Kecil',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 2800.0,
                'harga_jual' => 5000.0,
                'stok_saat_ini' => 18,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-032'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Borneo Double Tape Sedang',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 3000.0,
                'harga_jual' => 5000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-033'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Paperline Countinus 3 play 9,5inc',
                'deskripsi' => 'Satuan: BOX',
                'harga_modal' => 470000.0,
                'harga_jual' => 560000.0,
                'stok_saat_ini' => 1000,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-034'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Thermal Paper Roll 80 Kuning',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 20000.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 4,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-035'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Nota Kontan Hvs 1 play 50L',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 1800.0,
                'harga_jual' => 4000.0,
                'stok_saat_ini' => 40,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-036'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Nota Kontan Ncr 2 play 25L',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 2600.0,
                'harga_jual' => 5000.0,
                'stok_saat_ini' => 88,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-037'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Nota Kontan Ncr 3 play 25L',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 3700.0,
                'harga_jual' => 6000.0,
                'stok_saat_ini' => 56,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-038'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Amplop Merpati 152x90mm',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 26000.0,
                'harga_jual' => 30000.0,
                'stok_saat_ini' => 7,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-039'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Amplop Paper Line 110pps',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 19500.0,
                'harga_jual' => 21000.0,
                'stok_saat_ini' => 6,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-040'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Amplop Paper Line 90pps',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 21000.0,
                'harga_jual' => 22500.0,
                'stok_saat_ini' => 6,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-041'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Themper Line 57x30mm',
                'deskripsi' => 'Satuan: ROOL',
                'harga_modal' => 24500.0,
                'harga_jual' => 24500.0,
                'stok_saat_ini' => 38,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-042'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Themper Paper  80x80mm',
                'deskripsi' => 'Satuan: ROOL',
                'harga_modal' => 22000.0,
                'harga_jual' => 22000.0,
                'stok_saat_ini' => 11,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-043'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'J-Plus seal 80gsm (mapcoklat)',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 48000.0,
                'harga_jual' => 52000.0,
                'stok_saat_ini' => 6,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-044'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Sticky Notes 3x2inch isi 100 sheets',
                'deskripsi' => 'Satuan: SET',
                'harga_modal' => 6000.0,
                'harga_jual' => 7000.0,
                'stok_saat_ini' => 12,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-045'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Sticky Notes 3x3inch isi 100 sheets',
                'deskripsi' => 'Satuan: SET',
                'harga_modal' => 6000.0,
                'harga_jual' => 7000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-046'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Push Pins V-Tro',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 4000.0,
                'harga_jual' => 5000.0,
                'stok_saat_ini' => 120,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-047'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Lem Glue Stick',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 3500.0,
                'harga_jual' => 3500.0,
                'stok_saat_ini' => 10,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-048'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Trigonal Paper Clips No.3',
                'deskripsi' => 'Satuan: BOXES',
                'harga_modal' => 28000.0,
                'harga_jual' => 30000.0,
                'stok_saat_ini' => 3,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-049'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Batrai Alkaline AA',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 33000.0,
                'harga_jual' => 33000.0,
                'stok_saat_ini' => 156,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-050'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Batrai Alkaline AAA',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 33000.0,
                'harga_jual' => 33000.0,
                'stok_saat_ini' => 149,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-051'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Batrai ABC R14',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 8000.0,
                'harga_jual' => 12000.0,
                'stok_saat_ini' => 24,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-052'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Batrai ABC R205',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 10000.0,
                'harga_jual' => 12000.0,
                'stok_saat_ini' => 44,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-053'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Stapler Max HD-10 Magenta',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 18500.0,
                'harga_jual' => 20000.0,
                'stok_saat_ini' => 5,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-054'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Stapler Max HD-10 R. yellow',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 9,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-055'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Stapler Max HD-10D Rose',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 10,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-056'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Stapler Max HD-10D Black',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 10,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-057'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Stapler Ergonomic HD-50',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 8,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-058'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Staples Max No. 3',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 15,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-059'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Staples Max No. 10',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 24,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-060'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Staples Max No. 10 (Menko) isi 20',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 4,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-061'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Staple Remover V-Tac Type SR-45',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 3,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-062'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Durable Punch 5530 (Pelubang Kertas)',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 28000.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 5,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-063'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Joyko Date Stamp Stempel Tanggal D-3 5mm',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 8000.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 2,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-064'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Hero Stamp Pad (Bantalan Cap)',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 2,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-065'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Sunwell Cutter Small CT-120',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 12,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-066'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Binder Clips No.200',
                'deskripsi' => 'Satuan: KOTAK',
                'harga_modal' => 14000.0,
                'harga_jual' => 14000.0,
                'stok_saat_ini' => 6,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-067'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => '2 Hole Punch PF-30',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 13000.0,
                'harga_jual' => 18000.0,
                'stok_saat_ini' => 8,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-068'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Pet Index&Mark 45x12',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 24,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-069'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Stopmap Folio 5002 Biola',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 2,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-070'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Tinta Printer Epson 003 Black',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 86000.0,
                'harga_jual' => 96000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-071'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Tinta Printer Epson 003 Cyan',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 86000.0,
                'harga_jual' => 96000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-072'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Tinta Printer Epson 003 Magenta',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 86000.0,
                'harga_jual' => 96000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-073'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Tinta Printer Epson 003 Yellow',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 86000.0,
                'harga_jual' => 96000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-074'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Tinta Printer Epson T6641 Black',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 86500.0,
                'harga_jual' => 96500.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-075'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Tinta Printer Epson T6641 Cyan',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 86500.0,
                'harga_jual' => 96500.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-076'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Tinta Printer Epson T6641 Magenta',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 86500.0,
                'harga_jual' => 96500.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-077'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => 'Mouse Wireless F. W193D Black',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 78000.0,
                'harga_jual' => 120000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-078'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-079'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-080'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-081'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-082'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-083'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-084'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-085'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-086'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-087'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-088'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-089'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-090'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-091'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-092'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-093'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-094'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-095'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-096'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-097'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-098'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-099'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-100'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-101'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-102'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-103'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-104'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-105'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-106'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-107'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-108'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-109'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-110'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-111'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-112'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-113'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-114'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-115'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-116'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-117'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-118'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-119'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-120'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-121'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-122'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-123'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-124'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-125'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-126'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-127'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-128'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-129'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-130'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-131'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-132'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-133'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-134'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-135'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-136'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-137'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-138'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-139'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-140'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-141'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-142'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-143'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-144'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-145'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-146'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-147'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-148'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-149'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-150'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-151'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-152'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-153'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-154'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-155'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-156'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-157'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-158'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-159'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-160'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-161'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-162'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-163'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-164'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-165'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-166'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-167'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-168'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-169'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-170'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-171'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-172'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-173'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-174'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-175'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-176'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-177'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-178'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-179'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-180'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-181'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-182'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-183'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-184'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-185'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-186'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-187'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-188'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-189'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-190'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-191'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-192'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-193'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-194'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-195'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-196'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-197'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-198'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-199'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-200'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-201'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-202'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-203'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-204'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-205'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-206'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'A-207'],
            [
                'category_id' => $categories['ATK']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-001'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Sabun Deterjen',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 300100.0,
                'harga_jual' => 34000.0,
                'stok_saat_ini' => 24,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-002'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'So Klin Lantai',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 10900.0,
                'harga_jual' => 14000.0,
                'stok_saat_ini' => 39,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-003'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Pewangi Ruangan Glade',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 12,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-004'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Pewangi R. Bay Fresh',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 11000.0,
                'harga_jual' => 11500.0,
                'stok_saat_ini' => 22,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-005'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Swallow pengharum WC',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 19200.0,
                'harga_jual' => 19500.0,
                'stok_saat_ini' => 3,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-006'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Kapur Ajaib isi 6',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 20550.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 2,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-007'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Bayclin Pemutih 1 L',
                'deskripsi' => 'Satuan: Botol',
                'harga_modal' => 19801.0,
                'harga_jual' => 26001.0,
                'stok_saat_ini' => 17,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-008'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Wipol isi 40',
                'deskripsi' => 'Satuan: BOX',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 1,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-009'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Sabun Daia Softener',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 10000.0,
                'harga_jual' => 10000.0,
                'stok_saat_ini' => 14,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-010'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Baygon Spray 75 ml',
                'deskripsi' => 'Satuan: Botol',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 12,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-011'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Hit Spray',
                'deskripsi' => 'Satuan: Botol',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 12,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-012'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Vixal 750gr',
                'deskripsi' => 'Satuan: BOTOL',
                'harga_modal' => 16500.0,
                'harga_jual' => 18000.0,
                'stok_saat_ini' => 2,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-013'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Sabun Cuci Tangan S.O.S',
                'deskripsi' => 'Satuan: Tank',
                'harga_modal' => 74800.0,
                'harga_jual' => 76000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-014'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Sabun Cuci K.Nipis 210ml',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 24,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-015'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Sabun attack jazz 100gr',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 30200.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-016'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Wipol Karbol Cemara 750 Ml',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 14500.0,
                'harga_jual' => 18000.0,
                'stok_saat_ini' => 6,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-017'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Parfum Loundry Presh Poin',
                'deskripsi' => 'Satuan: BOTOL',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 12,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-018'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Stella Spray Refil 60 ml',
                'deskripsi' => 'Satuan: BOTOL',
                'harga_modal' => 32750.0,
                'harga_jual' => 34000.0,
                'stok_saat_ini' => 10,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-019'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Stella Spray Air Frash 400 ml',
                'deskripsi' => 'Satuan: BOTOL',
                'harga_modal' => 26000.0,
                'harga_jual' => 28000.0,
                'stok_saat_ini' => 10,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-020'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Sunlight 1500 gr',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 24000.0,
                'harga_jual' => 25000.0,
                'stok_saat_ini' => -1,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-021'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Cling pembersih kaca',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 12,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-022'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => 'Mama Lemon 1,5L',
                'deskripsi' => 'Satuan: PCS',
                'harga_modal' => 22000.0,
                'harga_jual' => 28000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-023'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-024'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-025'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-026'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-027'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-028'],
            [
                'category_id' => $categories['Kebersihan']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-029'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-030'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-031'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-032'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-033'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-034'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-035'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-036'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-037'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-038'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-039'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-040'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-041'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-042'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-043'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-044'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-045'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-046'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-047'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-048'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-049'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-050'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-051'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-052'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-053'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-054'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-055'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-056'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-057'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-058'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-059'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-060'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-061'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-062'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-063'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-064'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-065'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-066'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-067'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-068'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-069'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-070'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-071'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-072'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-073'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-074'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-075'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-076'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-077'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-078'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-079'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-080'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-081'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-082'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-083'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-084'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-085'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-086'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-087'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-088'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-089'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-090'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-091'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-092'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-093'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-094'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-095'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-096'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-097'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-098'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-099'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-100'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-101'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-102'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-103'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-104'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-105'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-106'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-107'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-108'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-109'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-110'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-111'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-112'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-113'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-114'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-115'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-116'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-117'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-118'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-119'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-120'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-121'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-122'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-123'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-124'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-125'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-126'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-127'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-128'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-129'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-130'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-131'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-132'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-133'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-134'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-135'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-136'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-137'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-138'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-139'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-140'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-141'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-142'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-143'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-144'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-145'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-146'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-147'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-148'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-149'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-150'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-151'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-152'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-153'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-154'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-155'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-156'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-157'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-158'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-159'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-160'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-161'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-162'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-163'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-164'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-165'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-166'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-167'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-168'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-169'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-170'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-171'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-172'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'B-173'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-001'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Popok XL',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 46000.0,
                'harga_jual' => 57000.0,
                'stok_saat_ini' => 16,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-002'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Popok L',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 47000.0,
                'harga_jual' => 55000.0,
                'stok_saat_ini' => 8,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-003'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Popok M',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-004'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Popok Newborn',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-005'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Korset',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 25000.0,
                'harga_jual' => 33000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-006'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Sarung Batik',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 25000.0,
                'harga_jual' => 37000.0,
                'stok_saat_ini' => 1,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-007'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Pembalut Bersalin Softex 45cm isi 20',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 6,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-008'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Tisu basah Baby',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 12000.0,
                'harga_jual' => 12000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-009'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Sleek baby bottle',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 31900.0,
                'harga_jual' => 33000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-010'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Cukuran isi 5',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 11500.0,
                'harga_jual' => 11500.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-011'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Kapas Wajah',
                'deskripsi' => 'Satuan: PACK',
                'harga_modal' => 9600.0,
                'harga_jual' => 11000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-012'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Kapas wajah',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 9600.0,
                'harga_jual' => 11000.0,
                'stok_saat_ini' => -2,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-013'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Cotton bud',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 6500.0,
                'harga_jual' => 7000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-014'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Minyak kayu putih cap gajah 15ml',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 5750.0,
                'harga_jual' => 7000.0,
                'stok_saat_ini' => 24,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-015'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => 'Minyak telon',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 8250.0,
                'harga_jual' => 11000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-016'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-017'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-018'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-019'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-020'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-021'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-022'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-023'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-024'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-025'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-026'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-027'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-028'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-029'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-030'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-031'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-032'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-033'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-034'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-035'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-036'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-037'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-038'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-039'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-040'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-041'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-042'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-043'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-044'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-045'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-046'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-047'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-048'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-049'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-050'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-051'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-052'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-053'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-054'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-055'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-056'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-057'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-058'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-059'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-060'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-061'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-062'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-063'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-064'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-065'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-066'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-067'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-068'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-069'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-070'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-071'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-072'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-073'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-074'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-075'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-076'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-077'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-078'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-079'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-080'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-081'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-082'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-083'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-084'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-085'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-086'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-087'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-088'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-089'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-090'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-091'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-092'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-093'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-094'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-095'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-096'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-097'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-098'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-099'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-100'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-101'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-102'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-103'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-104'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-105'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-106'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-107'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-108'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-109'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-110'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-111'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-112'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-113'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-114'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-115'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-116'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-117'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-118'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-119'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-120'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-121'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-122'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-123'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-124'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-125'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-126'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-127'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-128'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-129'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-130'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-131'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-132'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-133'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-134'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-135'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-136'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-137'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-138'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-139'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-140'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-141'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-142'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-143'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-144'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-145'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-146'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-147'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-148'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-149'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-150'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-151'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-152'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-153'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-154'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-155'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-156'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-157'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-158'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-159'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-160'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-161'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-162'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-163'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-164'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-165'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-166'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-167'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-168'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-169'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-170'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-171'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-172'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-173'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-174'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-175'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-176'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-177'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-178'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-179'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-180'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-181'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-182'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-183'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-184'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-185'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-186'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-187'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-188'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-189'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-190'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-191'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-192'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-193'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-194'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-195'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-196'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-197'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-198'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-199'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'C-200'],
            [
                'category_id' => $categories['Perlengkapan Ibu&Bayi']->id,
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-001'],
            [
                'nama_barang' => 'Minyak Alif 2 Ltr',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 43000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-002'],
            [
                'nama_barang' => 'Gula 1kg',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 19000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-003'],
            [
                'nama_barang' => 'Kopi Kapal Api',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 10000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-004'],
            [
                'nama_barang' => 'Sirup Mawar',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 22000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-005'],
            [
                'nama_barang' => 'Bumbu Racik Tempe',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 20000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-006'],
            [
                'nama_barang' => 'Bumbu Racik Ikan',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 20000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-007'],
            [
                'nama_barang' => 'Bumbu Racik Ayam',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 20000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-008'],
            [
                'nama_barang' => 'Rayco Ayam',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 6000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-009'],
            [
                'nama_barang' => 'Ladaku',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 12000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-010'],
            [
                'nama_barang' => 'Kecap Sedap Hijau',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-011'],
            [
                'nama_barang' => 'Santan Kara',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 6000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-012'],
            [
                'nama_barang' => 'Tepung Curah',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-013'],
            [
                'nama_barang' => 'Telor',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-014'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-015'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-016'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-017'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-018'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-019'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-020'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-021'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-022'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-023'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-024'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-025'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-026'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-027'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-028'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-029'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-030'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-031'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-032'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-033'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-034'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-035'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-036'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-037'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-038'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-039'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-040'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-041'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-042'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-043'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-044'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-045'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-046'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-047'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-048'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-049'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-050'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-051'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-052'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-053'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-054'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-055'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-056'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-057'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-058'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-059'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-060'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-061'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-062'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-063'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-064'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-065'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-066'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-067'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-068'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-069'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-070'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-071'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-072'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-073'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-074'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-075'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-076'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-077'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-078'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-079'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'D-080'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-001'],
            [
                'category_id' => $categories['IPSRS']->id,
                'nama_barang' => 'Lampu Hannoch Sonic 10 W',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 110000.0,
                'harga_jual' => 152000.0,
                'stok_saat_ini' => -2,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-002'],
            [
                'category_id' => $categories['IPSRS']->id,
                'nama_barang' => 'Lampu Hannoch Sonic 18 W',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 145000.0,
                'harga_jual' => 152000.0,
                'stok_saat_ini' => -2,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-003'],
            [
                'category_id' => $categories['IPSRS']->id,
                'nama_barang' => 'MCB 16 A',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 38000.0,
                'harga_jual' => 39000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-004'],
            [
                'category_id' => $categories['IPSRS']->id,
                'nama_barang' => 'MCB 25 A',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 40000.0,
                'harga_jual' => 42000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-005'],
            [
                'nama_barang' => 'stop kontak5m 4l',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 35000.0,
                'harga_jual' => 40000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-006'],
            [
                'nama_barang' => 'push kloset',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 16000.0,
                'harga_jual' => 35000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-007'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-008'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-009'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-010'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-011'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-012'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-013'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-014'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-015'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-016'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-017'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-018'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-019'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-020'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-021'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-022'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-023'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-024'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-025'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-026'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-027'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-028'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-029'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-030'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-031'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-032'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-033'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-034'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-035'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-036'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-037'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-038'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-039'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-040'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-041'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-042'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-043'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-044'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-045'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-046'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-047'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-048'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-049'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-050'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-051'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-052'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-053'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-054'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-055'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-056'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-057'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-058'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-059'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-060'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-061'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-062'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-063'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-064'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-065'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-066'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-067'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-068'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-069'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-070'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-071'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-072'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-073'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-074'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-075'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-076'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-077'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-078'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-079'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-080'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-081'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-082'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-083'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'E-084'],
            [
                'nama_barang' => 'Stop kontak 3m 5l',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 30000.0,
                'harga_jual' => 32000.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-001'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-002'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-003'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-004'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-005'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-006'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-007'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-008'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-009'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-010'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-011'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-012'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-013'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-014'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-015'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-016'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-017'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-018'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-019'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-020'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-021'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-022'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-023'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-024'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-025'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-026'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-027'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-028'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-029'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-030'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-031'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-032'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-033'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-034'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-035'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-036'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-037'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-038'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-039'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-040'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-041'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-042'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-043'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-044'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-045'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-046'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-047'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-048'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-049'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-050'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-051'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-052'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-053'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-054'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-055'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-056'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-057'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-058'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-059'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-060'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-061'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-062'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-063'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-064'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'F-065'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-001'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-002'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-003'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-004'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-005'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-006'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-007'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-008'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-009'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-010'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-011'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-012'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-013'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-014'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-015'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-016'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-017'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-018'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-019'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-020'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-021'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-022'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-023'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-024'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-025'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-026'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-027'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-028'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-029'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-030'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-031'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-032'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-033'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-034'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-035'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-036'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-037'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-038'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-039'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-040'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-041'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-042'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-043'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-044'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-045'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-046'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-047'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-048'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-049'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

        Product::updateOrCreate(
            ['sku' => 'G-050'],
            [
                'nama_barang' => '',
                'deskripsi' => 'Satuan: ',
                'harga_modal' => 0.0,
                'harga_jual' => 0.0,
                'stok_saat_ini' => 0,
            ]
        );

    }
}
