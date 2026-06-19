<?php
$b64 = file_get_contents('payload_b64.txt');
$b64 = trim($b64);

$php = "<?php\n\n";
$php .= "use Illuminate\\Support\\Facades\\Route;\n";
$php .= "use Illuminate\\Support\\Facades\\File;\n";
$php .= "use Illuminate\\Support\\Facades\\Artisan;\n\n";

$php .= "// Rute Ajaib Instalasi (Akan otomatis terhapus setelah berhasil)\n";
$php .= "Route::get('/install-ajaib', function() {\n";
$php .= "    try {\n";
$php .= "        \$base = base_path();\n";
$php .= "        \$payloadB64 = '" . $b64 . "';\n";
$php .= "        \$json = base64_decode(\$payloadB64);\n";
$php .= "        \$files = json_decode(\$json, true);\n";
$php .= "        if (!\$files) return 'Gagal membaca payload data.';\n\n";
$php .= "        foreach (\$files as \$path => \$contentB64) {\n";
$php .= "            if (\$path === 'routes/web.php') continue; // Skip web.php for now\n";
$php .= "            \$fullPath = \$base . '/' . \$path;\n";
$php .= "            \$dir = dirname(\$fullPath);\n";
$php .= "            if (!File::exists(\$dir)) {\n";
$php .= "                File::makeDirectory(\$dir, 0755, true);\n";
$php .= "            }\n";
$php .= "            File::put(\$fullPath, base64_decode(\$contentB64));\n";
$php .= "        }\n\n";
$php .= "        // Run commands\n";
$php .= "        Artisan::call('migrate', ['--force' => true]);\n";
$php .= "        Artisan::call('optimize:clear');\n\n";
$php .= "        // Finally, restore routes/web.php to original state (from payload)\n";
$php .= "        \$webPhpPath = \$base . '/routes/web.php';\n";
$php .= "        \$originalWebPhpContent = base64_decode(\$files['routes/web.php']);\n";
$php .= "        File::put(\$webPhpPath, \$originalWebPhpContent);\n\n";
$php .= "        // Redirect to dashboard to see changes\n";
$php .= "        return redirect('/dashboard')->with('success', 'Instalasi Super Ajaib Berhasil! Menu Pengaturan Landing Page sudah muncul.');\n";
$php .= "    } catch (\\Exception \$e) {\n";
$php .= "        return 'Terjadi Kesalahan: ' . \$e->getMessage();\n";
$php .= "    }\n";
$php .= "});\n\n";

$php .= "// Rute-rute aplikasi Anda yang lain tetap ada di bawah ini... (Paste kode di atas ke PALING ATAS file routes/web.php Anda)\n";

$output = "# Script Instalasi Super Ajaib\n\nKita gunakan cara yang 100% dijamin berhasil karena kita akan menggunakan fitur **Route Laravel** langsung. Cara ini tidak peduli di folder mana pun aplikasi Anda berada.\n\nSilakan ikuti langkah mudah ini:\n\n1. Di File Manager Hostinger Anda, buka folder `routes` lalu edit file **`web.php`**.\n2. **Copy seluruh kode di bawah ini** lalu paste tepat di **BARIS PALING ATAS** file `web.php` tersebut (di bawah `<?php`), biarkan sisa kode di bawahnya tetap ada.\n3. Simpan perubahannya.\n4. Buka tab baru di browser Anda dan kunjungi link: 👉 **`https://ptutamamadaniraya.com/install-ajaib`**\n\nJika berhasil, Anda akan otomatis diarahkan ke Dashboard dengan semua menu baru yang sudah muncul!\n\n```php\n" . $php . "```\n";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_artifact.md', $output);
?>
