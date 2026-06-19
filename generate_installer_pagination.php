<?php
$b64 = file_get_contents('payload_controllers_b64.txt');
$b64 = trim($b64);

$php = "<?php\n\n";
$php .= "use Illuminate\\Support\\Facades\\Route;\n";
$php .= "use Illuminate\\Support\\Facades\\File;\n";
$php .= "use Illuminate\\Support\\Facades\\Artisan;\n\n";

$php .= "// Rute Ajaib Perbaikan Halaman (Akan otomatis terhapus)\n";
$php .= "Route::get('/perbaiki-halaman', function() {\n";
$php .= "    try {\n";
$php .= "        \$base = base_path();\n";
$php .= "        \$payloadB64 = '" . $b64 . "';\n";
$php .= "        \$json = base64_decode(\$payloadB64);\n";
$php .= "        \$files = json_decode(\$json, true);\n";
$php .= "        if (!\$files) return 'Gagal membaca payload data.';\n\n";
$php .= "        foreach (\$files as \$path => \$contentB64) {\n";
$php .= "            if (\$path === 'routes/web.php') continue;\n";
$php .= "            \$fullPath = \$base . '/' . \$path;\n";
$php .= "            File::put(\$fullPath, base64_decode(\$contentB64));\n";
$php .= "        }\n\n";
$php .= "        // Hapus route ini dari web.php agar bersih kembali\n";
$php .= "        \$webPhpPath = \$base . '/routes/web.php';\n";
$php .= "        \$webContent = File::get(\$webPhpPath);\n";
$php .= "        // Menghapus blok route ini menggunakan regex (mulai dari // Rute Ajaib sampai });)\n";
$php .= "        \$cleanContent = preg_replace('/\\/\\/ Rute Ajaib Perbaikan Halaman.*?\\}\\);\\n\\n/s', '', \$webContent);\n";
$php .= "        File::put(\$webPhpPath, \$cleanContent);\n\n";
$php .= "        return redirect('/products')->with('success', 'Perbaikan berhasil! Sekarang saat Anda mengedit/menghapus, halaman akan tetap berada di nomor yang sama (misal Halaman 3 tetap di Halaman 3).');\n";
$php .= "    } catch (\\Exception \$e) {\n";
$php .= "        return 'Terjadi Kesalahan: ' . \$e->getMessage();\n";
$php .= "    }\n";
$php .= "});\n\n";

$php .= "// Rute-rute aplikasi Anda yang lain tetap ada di bawah ini... (Paste kode di atas ke PALING ATAS file routes/web.php Anda)\n";

$output = "# Perbaikan Posisi Halaman (Pagination)\n\nAh, pertanyaan yang sangat jeli dan bagus! Ya, secara default Laravel akan mengembalikan tampilan ke halaman pertama (Halaman 1) setelah kita menambah, mengubah, atau menghapus data.\n\nSaya telah memprogram fitur **Penyimpanan Jejak Halaman (Session Url Tracking)** agar posisi nomor halaman Anda (*seperti Halaman 3*) akan selalu terekam dan Anda tidak akan 'dilempar' kembali ke halaman pertama.\n\nSama seperti sebelumnya, kita gunakan **Jalur Dalam** agar pasti sukses:\n\n1. Di File Manager Hostinger Anda, masuk ke folder `routes` lalu klik Edit pada file **`web.php`**.\n2. **Copy seluruh kode di bawah ini** lalu paste tepat di **BARIS PALING ATAS** file `web.php` tersebut (di bawah `<?php`).\n3. Simpan perubahannya.\n4. Buka tab baru di browser Anda dan kunjungi link: 👉 **`https://ptutamamadaniraya.com/perbaiki-halaman`**\n\n*(Perbaikan ini sudah saya terapkan sekaligus untuk Data Barang, Kategori, Merk, dan Manajemen Pengguna)*\n\n```php\n" . $php . "```\n";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_artifact.md', $output);
?>
