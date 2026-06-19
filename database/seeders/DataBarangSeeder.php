<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Merk;
use App\Models\Product;
use Illuminate\Support\Str;

class DataBarangSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['A-001', 'Kertas A4', 'COPY PAPER', 'BOX', 'ATK', 197000, 215000, 1],
            ['A-002', 'Kertas F4', 'COPY PAPER', 'BOX', 'ATK', 220000, 230000, 4],
            ['A-003', 'Kertas F4', 'AONE', 'BOX', 'ATK', 220000, 225000, 1],
            ['A-004', 'Bantex 60 pockets', 'DISPLAY BOOK', 'PACK', 'ATK', 30000, 60000, 6],
            ['A-005', 'Bantex 40 pockets', 'DISPLAY BOOK', 'PACK', 'ATK', 58000, 50000, 1],
            ['A-006', 'Bantex ERD', 'ERD BOX', 'BOX', 'ATK', 37000, 40000, 12],
            ['A-007', 'Business File', 'BENEFIT', 'PACK', 'ATK', 23000, 25000, 3],
            ['A-008', 'Business File', 'JENNIA', 'PACK', 'ATK', 22000, 24000, 61],
            ['A-009', 'Binder Clips Benefit No. 107', 'BENEFIT', 'PACK', 'ATK', 40000, 45000, 1],
            ['A-010', 'Binder Clips Benefit No. 105', 'BENEFIT', 'PACK', 'ATK', 35000, 45000, 2],
            ['A-011', 'Binder Clips Benefit No. 260', 'BENEFIT', 'PACK', 'ATK', 20000, 30000, 2],
            ['A-012', 'Kertas Buffallo Super', 'SUPER', 'PACK', 'ATK', 22000, 30000, 1],
            ['A-013', 'Kertas Buffallo F4', 'PYHTON', 'PACK', 'ATK', 22000, 30000, 3],
            ['A-014', 'Pulpen ball clip 0.5 blue', 'GEL LINK', 'KOTAK', 'ATK', 27000, 30000, 18],
            ['A-015', 'Pulpen 0.5 fine black', 'COOL 520', 'KOTAK', 'ATK', 25000, 28000, 14],
            ['A-016', 'Pulpen Black', 'PILOT', 'KOTAK', 'ATK', 36000, 38000, 7],
            ['A-017', 'Pulpen Blue', 'PILOT', 'KOTAK', 'ATK', 36000, 38000, 9],
            ['A-018', 'Pulpen meja', 'V-TEC', 'KOTAK', 'ATK', 6600, 8000, 8],
            ['A-019', 'Spidol Permanen', 'FABER CASTELL', 'KOTAK', 'ATK', 66000, 70000, 1],
            ['A-020', 'Spidol White board marker', 'FABER CASTELL', 'PCS', 'ATK', 66000, 70000, 1],
            ['A-021', 'Spidol Boardmark Hitam', 'SNOWMAN', 'KOTAK', 'ATK', 85000, 87000, 2],
            ['A-022', 'Spidol Boardmark Red', 'SNOWMAN', 'KOTAK', 'ATK', 85000, 87000, 1],
            ['A-023', 'Lakban 48mmx90 Bening(putih)', 'LAKBAN', 'PCS', 'ATK', 8000, 13000, 6],
            ['A-024', 'Lakban 48mmx90 Kuning', 'LAKBAN', 'PCS', 'ATK', 8000, 13000, 23],
            ['A-025', 'Lakban 48mmx12m Hitam (Borneo)', 'LAKBAN', 'PCS', 'ATK', 12000, 20500, 32],
            ['A-026', 'Lakban 48mmx90 Hitam (OKKEY)', 'LAKBAN', 'PCS', 'ATK', 12000, 20500, 12],
            ['A-027', 'Lakban 48mmx90 Coklat', 'LAKBAN', 'PCS', 'ATK', 8000, 13000, 56],
            ['A-028', 'Isolasi 12mmx10', 'BORNEO', 'PCS', 'ATK', 1100, 1300, 24],
            ['A-029', 'Isolasi 12mmx25', 'BORNEO', 'PCS', 'ATK', 1800, 3000, 32],
            ['A-030', 'Double Tape Kecil', 'KENKO', 'PCS', 'ATK', 2800, 5000, 5],
            ['A-031', 'Double Tape Kecil', 'BORNEO', 'PCS', 'ATK', 2800, 5000, 18],
            ['A-032', 'Double Tape Sedang', 'BORNEO', 'PCS', 'ATK', 3000, 5000, 12],
            ['A-033', 'Paperline Countinus 3 play 9.5inc', 'PAPERLINE', 'BOX', 'ATK', 470000, 560000, 1],
            ['A-034', 'Thermal Paper Roll 80 Kuning', 'THERMAL', 'PACK', 'ATK', 20000, 30000, 2],
            ['A-035', 'Nota Kontan Hvs 1 play 50L', 'NOTA', 'PCS', 'ATK', 1800, 4000, 40],
            ['A-036', 'Nota Kontan Ncr 2 play 25L', 'NOTA', 'PCS', 'ATK', 2600, 5000, 88],
            ['A-037', 'Nota Kontan Ncr 3 play 25L', 'NOTA', 'PCS', 'ATK', 3700, 6000, 56],
            ['A-038', 'Amplop Merpati 152x90mm', 'AMPLOP', 'KOTAK', 'ATK', 26000, 30000, 7],
            ['A-039', 'Amplop Paper Line 110pps', 'AMPLOP', 'KOTAK', 'ATK', 19500, 21000, 6],
            ['A-040', 'Amplop Paper Line 90pps', 'AMPLOP', 'KOTAK', 'ATK', 21000, 22500, 16],
            ['A-041', 'Themper Line 57x30mm', 'THEMPER', 'ROOL', 'ATK', 24500, 28500, 30],
            ['A-042', 'Themper Paper 80x80mm', 'THEMPER', 'ROOL', 'ATK', 22000, 26000, 5],
            ['A-043', 'J-Plus seal 80gsm (mapcoklat)', 'J', 'PACK', 'ATK', 48000, 58000, 6],
            ['A-044', 'Sticky Notes 3x2inch isi 100 sheets', 'STICKY', 'PCS', 'ATK', 5000, 8000, 12],
            ['A-045', 'Sticky Notes 3x3inch isi 100 sheets', 'STICKY', 'PCS', 'ATK', 6000, 9000, 12],
            ['A-046', 'Push Pins', 'V-TRO', 'PCS', 'ATK', 4000, 5000, 120],
            ['A-047', 'Lem Glue Stick', 'LEM', 'PCS', 'ATK', 3500, 5000, 11],
            ['A-048', 'Trigonal Paper Clips No.3', 'TRIGONAL', 'KOTAK', 'ATK', 28000, 30000, 5],
            ['A-049', 'Baterai Alkaline AA', 'BATRAI', 'PACK', 'ATK', 25500, 33000, 26],
            ['A-050', 'Baterai Alkaline AAA', 'BATRAI', 'PACK', 'ATK', 30000, 33000, 25],
            ['A-051', 'Baterai ABC R14', 'BATRAI', 'PCS', 'ATK', 8000, 12000, 24],
            ['A-052', 'Baterai ABC R205', 'BATRAI', 'PCS', 'ATK', 10000, 12000, 48],
            ['A-053', 'Stapler Max HD-10 Magenta', 'STAPLER', 'PCS', 'ATK', 18500, 22000, 5],
            ['A-054', 'Stapler Max HD-10 R yellow', 'STAPLER', 'PCS', 'ATK', 18500, 22000, 9],
            ['A-055', 'Stapler Max HD-10D Rose', 'STAPLER', 'PCS', 'ATK', 18500, 22000, 10],
            ['A-056', 'Stapler Max HD-10D Black', 'STAPLER', 'PCS', 'ATK', 18500, 22000, 10],
            ['A-057', 'Stapler Ergonomic HD-50', 'STAPLER', 'PCS', 'ATK', 60000, 65000, 8],
            ['A-058', 'Staples Max No. 3', 'STAPLES', 'PCS', 'ATK', 8000, 12000, 15],
            ['A-059', 'Staples Max No. 10', 'STAPLES', 'PCS', 'ATK', 8000, 12000, 24],
            ['A-060', 'Staples Max No. 10 (Menko) isi 20', 'STAPLES', 'PACK', 'ATK', 28000, 35000, 5],
            ['A-061', 'Staple Remover V-Tac Type SR-45', 'STAPLE', 'KOTAK', 'ATK', 0, 0, 3],
            ['A-062', 'Durable Punch 5530 (Pelubang Kertas)', 'DURABLE', 'KOTAK', 'ATK', 28000, 34000, 5],
            ['A-063', 'Joyko Date Stamp Stempel Tanggal D-3.5mm', 'JOYKO', 'PCS', 'ATK', 8000, 14000, 2],
            ['A-064', 'Hero Stamp Pad (Bantalan Cap)', 'HERO', 'KOTAK', 'ATK', 0, 0, 2],
            ['A-065', 'Sunwell Cutter Small CT-120', 'SUNWELL', 'PCS', 'ATK', 0, 0, 12],
            ['A-066', 'Binder Clips No.200', 'BINDER', 'KOTAK', 'ATK', 14000, 20000, 12],
            ['A-067', '2 Hole Punch PF-30', '2 HOLE', 'PCS', 'ATK', 13000, 18000, 5],
            ['A-068', 'Stopmap Folio isi 50', 'SEMIR', 'PACK', 'ATK', 23000, 35000, 4],
            ['A-069', 'Stopmap Folio 5002 Biola', 'STOPMAP', 'PCS', 'ATK', 32000, 28000, 1],
            ['A-070', 'Tinta Printer Epson 003 Black', 'TINTA', 'PCS', 'ATK', 86000, 96000, 5],
            ['A-071', 'Tinta Printer Epson 003 Cyan', 'TINTA', 'PCS', 'ATK', 86000, 96000, 2],
            ['A-072', 'Tinta Printer Epson 003 Magenta', 'TINTA', 'PCS', 'ATK', 86000, 96000, 2],
            ['A-073', 'Tinta Printer Epson 003 Yellow', 'TINTA', 'PCS', 'ATK', 86000, 96000, 2],
            ['A-074', 'Tinta Printer Epson T6641 Black', 'TINTA', 'PCS', 'ATK', 86500, 96500, 2],
            ['A-075', 'Tinta Printer Epson T6641 Cyan', 'TINTA', 'PCS', 'ATK', 86500, 96500, 2],
            ['A-076', 'Tinta Printer Epson T6641 Magenta', 'TINTA', 'PCS', 'ATK', 86500, 96500, 2],
            ['A-077', 'Mouse Wireless F. W193D Black', 'MOUSE', 'PCS', 'ATK', 78000, 120000, 1],
            ['A-078', 'Sticky Notes 3x1inch', 'STICKY', 'PCS', 'ATK', 5000, 8000, 0],
            ['A-079', 'Pet Index&Mark 45x12', 'PET', 'PCS', 'ATK', 0, 0, 12]
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
            $gambar = 'img/products/umum.png';
            if (str_contains($namaLower, 'kertas') || str_contains($namaLower, 'paper')) {
                $gambar = 'img/products/kertas.png';
            } elseif (str_contains($namaLower, 'pulpen') || str_contains($namaLower, 'spidol')) {
                $gambar = 'img/products/pulpen.png';
            } elseif (str_contains($namaLower, 'lakban') || str_contains($namaLower, 'isolasi') || str_contains($namaLower, 'double tape') || str_contains($namaLower, 'lem ')) {
                $gambar = 'img/products/lakban.png';
            } elseif (str_contains($namaLower, 'tinta')) {
                $gambar = 'img/products/tinta.png';
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
