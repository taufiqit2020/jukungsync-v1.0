<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Merk;
use App\Models\Product;
use Illuminate\Support\Str;

class DataKebersihanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['B-001', 'Sabun Bubuk', 'DETERGEN', 'PCS', 'Kebersihan', 30100, 34000, 24],
            ['B-002', 'So Klin Lantai', 'SO KLIN', 'PCS', 'Kebersihan', 10900, 14000, 51],
            ['B-003', 'Pewangi Ruangan', 'GLADE', 'PCS', 'Kebersihan', 10500, 11500, 12],
            ['B-004', 'Pewangi Ruangan', 'BAYFRESH', 'PCS', 'Kebersihan', 11000, 11500, 23],
            ['B-005', 'Pengharum WC', 'SWALLOW', 'PCS', 'Kebersihan', 19200, 20000, 3],
            ['B-006', 'Kapur Ajaib isi 6', 'BAGUS', 'PACK', 'Kebersihan', 20550, 25000, 2],
            ['B-007', 'Bayclin Pemutih 1 L', 'BAYCLIN', 'Botol', 'Kebersihan', 19801, 26001, 18],
            ['B-008', 'Cling', 'WINGCARE', 'PCS', 'Kebersihan', 0, 0, 9],
            ['B-009', 'Sabun Softener', 'DAIA', 'PCS', 'Kebersihan', 10000, 10000, 14],
            ['B-010', 'Baygon Spray 75 ml', 'BAYGON', 'BOTOL', 'Kebersihan', 0, 0, 12],
            ['B-011', 'Hit Spray', 'AEROSOL', 'BOTOL', 'Kebersihan', 0, 0, 12],
            ['B-012', 'Vixal 750gr', 'VIXAL', 'BOTOL', 'Kebersihan', 16500, 18000, 6],
            ['B-013', 'Sabun Cuci Tangan', 'S.O.S', 'Tank', 'Kebersihan', 73900, 90000, 2],
            ['B-014', 'Sabun Cuci 210ml', 'K.NIPIS', 'PCS', 'Kebersihan', 0, 0, 24],
            ['B-015', 'Sabun attack jazz 100gr', 'JAZZ NO 1', 'PCS', 'Kebersihan', 30200, 34000, 6],
            ['B-016', 'Wipol 750 Ml', 'CEMARA', 'PCS', 'Kebersihan', 14500, 18000, 6],
            ['B-017', 'Parfum Loundry Presh Poin', 'PARFUM', 'BOTOL', 'Kebersihan', 65000, 70000, 12],
            ['B-018', 'Pengharum Ruangan 60 ml', 'STELLA REFIL', 'BOTOL', 'Kebersihan', 15000, 31000, 10],
            ['B-019', 'Pengharum Ruangan 400 ml', 'STELLA BAYFRESH', 'BOTOL', 'Kebersihan', 29000, 30000, 14],
            ['B-020', 'Sabun Cuci Piring 1500 gr', 'SUNLIGHT', 'PCS', 'Kebersihan', 24000, 25000, 3],
            ['B-021', 'Sabun cuci piring 1,5L', 'MAMA LEMON', 'PCS', 'Kebersihan', 22000, 28000, 8]
        ];

        foreach ($data as $row) {
            $sku = $row[0];
            $nama = $row[1];
            $merkName = $row[2];
            $satuan = $row[3];
            $kategoriName = $row[4];
            $beli = $row[5];
            $jual = $row[6];
            $stok = $row[7];

            $cat = Category::firstOrCreate(['nama_kategori' => $kategoriName], ['slug' => Str::slug($kategoriName)]);
            $merk = Merk::firstOrCreate(['nama_merk' => $merkName], ['slug' => Str::slug($merkName)]);

            // Tentukan gambar berdasarkan nama barang
            $namaLower = strtolower($nama);
            $gambar = 'products/sabun.png';
            if (str_contains($namaLower, 'pewangi') || str_contains($namaLower, 'pengharum') || str_contains($namaLower, 'parfum') || str_contains($namaLower, 'kapur')) {
                $gambar = 'products/pengharum.png';
            } elseif (str_contains($namaLower, 'spray')) {
                $gambar = 'products/spray.png';
            }

            Product::updateOrCreate(
                ['sku' => $sku],
                [
                    'category_id' => $cat->id,
                    'merk_id' => $merk->id,
                    'nama_barang' => $nama,
                    'deskripsi' => "Satuan: " . $satuan,
                    'harga_modal' => $beli,
                    'harga_jual' => $jual,
                    'stok_saat_ini' => $stok,
                    'gambar' => $gambar
                ]
            );
        }
    }
}
