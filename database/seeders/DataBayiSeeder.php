<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Merk;
use App\Models\Product;
use Illuminate\Support\Str;

class DataBayiSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['C-001', 'Popok XL', 'POPOK', 'PCS', 'Perlengkapan Ibu&Bayi', 46000, 57000, 16],
            ['C-002', 'Popok L', 'POPOK', 'PCS', 'Perlengkapan Ibu&Bayi', 47000, 55000, 8],
            ['C-003', 'Korset', 'KORSET', 'PCS', 'Perlengkapan Ibu&Bayi', 25000, 33000, 0],
            ['C-004', 'Sarung Batik', 'SARUNG', 'PCS', 'Perlengkapan Ibu&Bayi', 25000, 37000, 0],
            ['C-005', 'Pembalut Bersalin Softex 45cm isi 20', 'PEMBALUT', 'PCS', 'Perlengkapan Ibu&Bayi', 39000, 43000, 6],
            ['C-006', 'Sleek baby bottle', 'SLEEK', 'PCS', 'Perlengkapan Ibu&Bayi', 31900, 33000, 0],
            ['C-007', 'Cukuran isi 5', 'CUKURAN', 'PCS', 'Perlengkapan Ibu&Bayi', 11500, 11500, 0],
            ['C-008', 'Kapas Wajah', 'KAPAS', 'PACK', 'Perlengkapan Ibu&Bayi', 9600, 11000, 2],
            ['C-009', 'Cotton bud', 'COTTON', 'PCS', 'Perlengkapan Ibu&Bayi', 6500, 7000, 0],
            ['C-010', 'Minyak kayu putih cap gajah 15ml', 'MINYAK', 'PCS', 'Perlengkapan Ibu&Bayi', 5750, 7000, 24],
            ['C-011', 'Minyak telon', 'MINYAK', 'PCS', 'Perlengkapan Ibu&Bayi', 8250, 11000, 0]
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
            $gambar = 'products/perawatan.png';
            if (str_contains($namaLower, 'popok') || str_contains($namaLower, 'pembalut')) {
                $gambar = 'products/popok.png';
            } elseif (str_contains($namaLower, 'minyak')) {
                $gambar = 'products/minyak.png';
            } elseif (str_contains($namaLower, 'sarung') || str_contains($namaLower, 'korset')) {
                $gambar = 'products/pakaian.png';
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
