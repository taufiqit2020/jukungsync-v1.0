<?php
$b64 = file_get_contents('update_base64.txt');
$b64 = trim($b64);
$php = "<?php\n";
$php .= "\$zipB64 = '" . $b64 . "';\n";
$php .= "\$zipPath = __DIR__ . '/update_temp.zip';\n";
$php .= "file_put_contents(\$zipPath, base64_decode(\$zipB64));\n";
$php .= "\$zip = new ZipArchive;\n";
$php .= "if (\$zip->open(\$zipPath) === TRUE) {\n";
$php .= "    \$zip->extractTo(__DIR__);\n";
$php .= "    \$zip->close();\n";
$php .= "    unlink(\$zipPath);\n";
$php .= "    echo '<b>BERHASIL!</b> File berhasil di-update.<br>';\n";
$php .= "    echo 'Menjalankan migrasi database...<br>';\n";
$php .= "    exec('php artisan migrate --force 2>&1', \$output, \$return_var);\n";
$php .= "    echo '<pre>' . implode(\"\\n\", \$output) . '</pre>';\n";
$php .= "    if (\$return_var === 0 || strpos(implode('', \$output), 'Nothing to migrate') !== false || strpos(implode('', \$output), 'Migration table created successfully') !== false) {\n";
$php .= "        echo '<b style=\"color:green;\">Migrasi Selesai! Fitur Pengaturan Landing Page sudah aktif.</b><br>';\n";
$php .= "        echo '<a href=\"/\">Kembali ke Beranda</a> | <a href=\"/dashboard\">Ke Dashboard</a>';\n";
$php .= "    } else {\n";
$php .= "        echo '<b style=\"color:red;\">Ada kesalahan saat migrasi. Coba jalankan /jalankan-otomatis secara manual.</b>';\n";
$php .= "    }\n";
$php .= "} else {\n";
$php .= "    echo 'Gagal mengekstrak file ZIP.';\n";
$php .= "}\n";
$php .= "unlink(__FILE__);\n";
$php .= "?>";
file_put_contents('C:\\Users\\USER\\.gemini\\antigravity\\brain\\f12d4254-b154-471c-b76a-aa67f4e9fcf6\\installer.php', $php);
?>
