<?php
$b64 = file_get_contents('payload_create.txt');
$b64 = trim($b64);

$php = "<?php\n\n";
$php .= "use Illuminate\\Support\\Facades\\Route;\n";
$php .= "use Illuminate\\Support\\Facades\\File;\n\n";

$php .= "// Rute Ajaib Perbaikan Dropdown\n";
$php .= "Route::get('/perbaiki-dropdown', function() {\n";
$php .= "    try {\n";
$php .= "        \$base = base_path();\n";
$php .= "        \$payloadB64 = '" . $b64 . "';\n";
$php .= "        \$fullPath = \$base . '/resources/views/inventory-movements/create.blade.php';\n";
$php .= "        File::put(\$fullPath, base64_decode(\$payloadB64));\n\n";
$php .= "        // Hapus route ini dari web.php agar bersih kembali\n";
$php .= "        \$webPhpPath = \$base . '/routes/web.php';\n";
$php .= "        \$webContent = File::get(\$webPhpPath);\n";
$php .= "        \$cleanContent = preg_replace('/\\/\\/ Rute Ajaib Perbaikan Dropdown.*?\\}\\);\\n\\n/s', '', \$webContent);\n";
$php .= "        File::put(\$webPhpPath, \$cleanContent);\n\n";
$php .= "        return redirect('/inventory-movements/create')->with('success', 'Perbaikan Dropdown Berhasil!');\n";
$php .= "    } catch (\\Exception \$e) {\n";
$php .= "        return 'Terjadi Kesalahan: ' . \$e->getMessage();\n";
$php .= "    }\n";
$php .= "});\n\n";

$php .= "// Rute-rute aplikasi Anda yang lain tetap ada di bawah ini... (Paste kode di atas ke PALING ATAS file routes/web.php Anda)\n";

$output = "# Perbaikan Desain Dropdown Barang\n\nTentu saja, konsistensi desain itu sangat penting! Saya sudah menyamakan tampilan dropdown pemilih barang di **Mutasi Keluar Manual** agar terlihat persis sama canggihnya dengan yang ada di halaman **Barang Masuk**.\n\nMari kita update menggunakan trik yang sama:\n\n1. Buka kembali File Manager Hostinger Anda, masuk ke folder `routes` lalu Edit file **`web.php`**.\n2. **Copy seluruh kode di bawah ini** lalu paste tepat di **BARIS PALING ATAS** file `web.php` tersebut (di bawah `<?php`).\n3. Simpan perubahannya.\n4. Buka tab baru di browser Anda dan kunjungi link: 👉 **`https://ptutamamadaniraya.com/perbaiki-dropdown`**\n\nJika berhasil, Anda akan otomatis dibawa ke halaman Mutasi Manual dan melihat tampilan dropdown barangnya sudah sangat mewah dan elegan!\n\n```php\n" . $php . "```\n";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_artifact.md', $output);
?>
