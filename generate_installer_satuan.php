<?php
$b64 = file_get_contents('payload_satuan.txt');
$b64 = trim($b64);

$php = "<?php\n\n";
$php .= "use Illuminate\\Support\\Facades\\Route;\n";
$php .= "use Illuminate\\Support\\Facades\\File;\n";
$php .= "use Illuminate\\Support\\Facades\\Artisan;\n\n";

$php .= "// Rute Ajaib Fitur Satuan Barang\n";
$php .= "Route::get('/pasang-fitur-satuan', function() {\n";
$php .= "    try {\n";
$php .= "        \$base = base_path();\n";
$php .= "        \$payloadB64 = '" . $b64 . "';\n";
$php .= "        \$data = json_decode(base64_decode(\$payloadB64), true);\n";
$php .= "        \n";
$php .= "        // 1. Tulis file migrasi database\n";
$php .= "        File::put(\$base . '/database/migrations/2026_06_09_063710_add_satuan_to_products_table.php', base64_decode(\$data['m']));\n";
$php .= "        // 2. Jalankan migrasi untuk menambah kolom satuan di database\n";
$php .= "        Artisan::call('migrate', ['--force' => true]);\n";
$php .= "        \n";
$php .= "        // 3. Update Model & Controller & View\n";
$php .= "        File::put(\$base . '/app/Models/Product.php', base64_decode(\$data['p']));\n";
$php .= "        File::put(\$base . '/app/Http/Controllers/ProductController.php', base64_decode(\$data['c']));\n";
$php .= "        File::put(\$base . '/resources/views/products/index.blade.php', base64_decode(\$data['i']));\n";
$php .= "        File::put(\$base . '/resources/views/products/create.blade.php', base64_decode(\$data['cr']));\n";
$php .= "        File::put(\$base . '/resources/views/products/edit.blade.php', base64_decode(\$data['e']));\n";
$php .= "        \n";
$php .= "        // Bersihkan cache dan opcache agar perubahannya langsung terlihat\n";
$php .= "        Artisan::call('optimize:clear');\n";
$php .= "        if (function_exists('opcache_reset')) { opcache_reset(); }\n";
$php .= "        \n";
$php .= "        // Hapus rute ini dari web.php\n";
$php .= "        \$webPhpPath = \$base . '/routes/web.php';\n";
$php .= "        \$webContent = File::get(\$webPhpPath);\n";
$php .= "        \$cleanContent = preg_replace('/\\/\\/ Rute Ajaib Fitur Satuan.*?\\}\\);\\n\\n/s', '', \$webContent);\n";
$php .= "        File::put(\$webPhpPath, \$cleanContent);\n\n";
$php .= "        return redirect('/products')->with('success', 'Berhasil! Kolom Satuan Barang telah ditambahkan.');\n";
$php .= "    } catch (\\Exception \$e) {\n";
$php .= "        return 'Terjadi Kesalahan: ' . \$e->getMessage();\n";
$php .= "    }\n";
$php .= "});\n\n";

$output = "# Penambahan Fitur Satuan Barang\n\nPermintaan Anda sudah saya selesaikan! Saya telah menambahkan kolom dan input khusus untuk **Satuan Barang** (misal: Pcs, Box, Rim, dsb).\n\nPerubahan yang dilakukan oleh sistem otomatis ini meliputi:\n1. **Database**: Menambahkan kolom `satuan` di tabel penyimpanan barang.\n2. **Tabel Data Barang**: Memunculkan kolom \"Satuan\" di sebelah nama barang.\n3. **Form Tambah & Edit**: Menambahkan form input untuk mengisi satuan barang.\n\nMari kita pasang dengan cara yang sama seperti sebelumnya:\n\n1. Buka File Manager Hostinger Anda, masuk ke folder `routes` lalu Edit file **`web.php`**.\n2. **Copy seluruh kode di bawah ini** lalu paste tepat di **BARIS PALING ATAS** file `web.php` Anda (timpa/hapus rute ajaib yang lama jika masih ada, agar tidak menumpuk).\n3. Simpan perubahannya.\n4. Buka tab baru di browser Anda dan kunjungi link: 👉 **`https://ptutamamadaniraya.com/pasang-fitur-satuan`**\n\nSetelah berhasil, sistem akan merestart cache secara otomatis dan membawa Anda kembali ke halaman Data Barang. Silakan coba tambahkan atau edit barang, Anda akan melihat form input satuannya di sana!\n\n```php\n" . $php . "```\n";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_artifact.md', $output);
?>
