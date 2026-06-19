<?php
$b64 = file_get_contents('payload_edit.txt');
$b64 = trim($b64);

$php = "<?php\n\n";
$php .= "use Illuminate\\Support\\Facades\\Route;\n";
$php .= "use Illuminate\\Support\\Facades\\File;\n\n";

$php .= "// Rute Ajaib Fitur Edit & Hapus\n";
$php .= "Route::get('/pasang-fitur-edit', function() {\n";
$php .= "    try {\n";
$php .= "        \$base = base_path();\n";
$php .= "        \$payloadB64 = '" . $b64 . "';\n";
$php .= "        \$data = json_decode(base64_decode(\$payloadB64), true);\n";
$php .= "        \n";
$php .= "        File::put(\$base . '/app/Http/Controllers/InventoryMovementController.php', base64_decode(\$data['c']));\n";
$php .= "        File::put(\$base . '/resources/views/inventory-movements/index.blade.php', base64_decode(\$data['i']));\n";
$php .= "        File::put(\$base . '/resources/views/inventory-movements/edit.blade.php', base64_decode(\$data['e']));\n";
$php .= "        \n";
$php .= "        // Hapus route ini dari web.php agar bersih kembali dan kembalikan web.php ke versi baru\n";
$php .= "        \$webPhpPath = \$base . '/routes/web.php';\n";
$php .= "        \$webContent = File::get(\$webPhpPath);\n";
$php .= "        \$cleanContent = preg_replace('/\\/\\/ Rute Ajaib Fitur Edit.*?\\}\\);\\n\\n/s', '', \$webContent);\n";
$php .= "        File::put(\$webPhpPath, base64_decode(\$data['w']));\n\n";
$php .= "        return redirect('/inventory-movements')->with('success', 'Fitur Edit & Hapus Pergerakan Stok berhasil ditambahkan khusus untuk Superadmin!');\n";
$php .= "    } catch (\\Exception \$e) {\n";
$php .= "        return 'Terjadi Kesalahan: ' . \$e->getMessage();\n";
$php .= "    }\n";
$php .= "});\n\n";

$php .= "// Rute-rute aplikasi Anda yang lain tetap ada di bawah ini... (Paste kode di atas ke PALING ATAS file routes/web.php Anda)\n";

$output = "# Penambahan Fitur Edit & Hapus Mutasi\n\nPermintaan Anda sudah saya selesaikan! Saya telah menambahkan fitur **Edit** dan **Hapus** pada riwayat mutasi stok, dan memastikan tombol-tombol tersebut **HANYA muncul jika Anda login sebagai Owner / Superadmin**. Jika Staf Admin yang login, tombol tersebut tidak akan terlihat.\n\nSelain itu, sistem juga sudah saya lengkapi dengan logika otomatis: jika Anda mengedit atau menghapus riwayat, **stok barang akan otomatis menyesuaikan/kembali** seperti seharusnya!\n\nMari kita pasang fiturnya:\n\n1. Buka kembali File Manager Hostinger Anda, masuk ke folder `routes` lalu Edit file **`web.php`**.\n2. **Copy seluruh kode di bawah ini** lalu paste tepat di **BARIS PALING ATAS** file `web.php` tersebut.\n3. Simpan perubahannya.\n4. Buka tab baru di browser Anda dan kunjungi link: 👉 **`https://ptutamamadaniraya.com/pasang-fitur-edit`**\n\nSetelah itu, Anda akan otomatis kembali ke halaman Riwayat Pergerakan Stok dan melihat ada tambahan kolom \"Aksi\" yang berisi tombol Edit & Hapus! Silakan dicoba.\n\n```php\n" . $php . "```\n";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_artifact.md', $output);
?>
