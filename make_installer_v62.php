<?php
$projectRoot = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1';
$files = [
    'app/Http/Controllers/InvoiceController.php',
    'app/Http/Controllers/ProductController.php',
    'resources/views/invoices/invoice_lx310.blade.php',
    'resources/views/invoices/excel.blade.php',
    'resources/views/invoices/show.blade.php',
    'resources/views/products/create.blade.php',
    'resources/views/products/edit.blade.php',
    'routes/web.php',
    'storage/app/public/products/Ztxw9M1yS1hwyzMNDxvEQN4vHF9pv4BDbL9cSoOb.jpg',
    'public/storage/products/Ztxw9M1yS1hwyzMNDxvEQN4vHF9pv4BDbL9cSoOb.jpg',
    'public/dump_production_images.php',
    'database/migrations/2026_06_30_000001_create_slip_gajis_table.php',
    'database/migrations/2026_07_01_063905_add_perusahaan_to_slip_gajis_table.php',
    'app/Models/SlipGaji.php',
    'app/Http/Controllers/SlipGajiController.php',
    'resources/views/layouts/admin.blade.php',
    'resources/views/slip_gaji/index.blade.php',
    'resources/views/slip_gaji/create.blade.php',
    'resources/views/slip_gaji/edit.blade.php',
    'resources/views/slip_gaji/show.blade.php',
    'resources/views/slip_gaji/excel.blade.php',
    'public/img/logo-farma.png',
];

$php = "<?php\n";
$php .= "ini_set('display_errors', 1);\n";
$php .= "ini_set('display_startup_errors', 1);\n";
$php .= "error_reporting(E_ALL);\n\n";

$php .= "function findLaravelRoot(\$dir, \$depth = 0) {\n";
$php .= "    if (\$depth > 3) return null;\n";
$php .= "    if (!is_dir(\$dir)) return null;\n";
$php .= "    if (file_exists(\$dir . '/artisan') && file_exists(\$dir . '/bootstrap/app.php')) return \$dir;\n";
$php .= "    \$items = @scandir(\$dir);\n";
$php .= "    if (!\$items) return null;\n";
$php .= "    foreach (\$items as \$item) {\n";
$php .= "        if (\$item === '.' || \$item === '..') continue;\n";
$php .= "        \$path = \$dir . '/' . \$item;\n";
$php .= "        if (is_dir(\$path)) { \$found = findLaravelRoot(\$path, \$depth + 1); if (\$found) return \$found; }\n";
$php .= "    }\n";
$php .= "    return null;\n";
$php .= "}\n\n";

$php .= "\$laravelRoot = findLaravelRoot(dirname(__DIR__));\n";
$php .= "if (!\$laravelRoot) \$laravelRoot = __DIR__;\n\n";

$php .= "try {\n";
$php .= "    \$log = '';\n";
foreach ($files as $f) {
    $fullPath = "$projectRoot/$f";
    if (!file_exists($fullPath)) {
        die("Error: File not found: $fullPath\n");
    }
    $b64 = base64_encode(file_get_contents($fullPath));
    $php .= "    @mkdir(dirname(\$laravelRoot . '/$f'), 0777, true);\n";
    $php .= "    file_put_contents(\$laravelRoot . '/$f', base64_decode('$b64'));\n";
    $php .= "    \$log .= '✔ Berhasil memperbarui file: $f\\n';\n";
}

$php .= "\n";

// === SINKRONISASI DATABASE & CACHE ===
$php .= "    // Boot Laravel untuk artisan commands\n";
$php .= "    \$artisanLog = '';\n";
$php .= "    try {\n";
$php .= "        if (file_exists(\$laravelRoot . '/vendor/autoload.php') && file_exists(\$laravelRoot . '/bootstrap/app.php')) {\n";
$php .= "            require \$laravelRoot . '/vendor/autoload.php';\n";
$php .= "            \$app = require_once \$laravelRoot . '/bootstrap/app.php';\n";
$php .= "            \$kernel = \$app->make(Illuminate\\Contracts\\Console\\Kernel::class);\n";
$php .= "            \n";
$php .= "            // 1. Jalankan migrasi database\n";
$php .= "            try {\n";
$php .= "                \$status = \$kernel->handle(\n";
$php .= "                    \$input = new Symfony\\Component\\Console\\Input\\StringInput('migrate --force'),\n";
$php .= "                    \$output = new Symfony\\Component\\Console\\Output\\BufferedOutput\n";
$php .= "                );\n";
$php .= "                \$artisanLog .= \"=== Database Migration ===\\n\" . \$output->fetch() . \"\\n\";\n";
$php .= "                \$log .= '✔ Database migration selesai\\n';\n";
$php .= "            } catch (\\Throwable \$eMigrate) {\n";
$php .= "                \$artisanLog .= \"=== Database Migration Error ===\\n\" . \$eMigrate->getMessage() . \"\\n\";\n";
$php .= "                \$log .= '⚠ Database migration error\\n';\n";
$php .= "            }\n";
$php .= "            \n";
$php .= "            // 2. Bersihkan cache (optimize:clear)\n";
$php .= "            try {\n";
$php .= "                \$status2 = \$kernel->handle(\n";
$php .= "                    \$input2 = new Symfony\\Component\\Console\\Input\\StringInput('optimize:clear'),\n";
$php .= "                    \$output2 = new Symfony\\Component\\Console\\Output\\BufferedOutput\n";
$php .= "                );\n";
$php .= "                \$artisanLog .= \"=== Cache Clear ===\\n\" . \$output2->fetch() . \"\\n\";\n";
$php .= "                \$log .= '✔ Cache Laravel berhasil dibersihkan\\n';\n";
$php .= "            } catch (\\Throwable \$eCache) {\n";
$php .= "                \$artisanLog .= \"=== Cache Clear Error ===\\n\" . \$eCache->getMessage() . \"\\n\";\n";
$php .= "            }\n";
$php .= "            \n";
$php .= "            // 3. Jalankan optimize untuk reload cache terbaru\n";
$php .= "            try {\n";
$php .= "                \$status3 = \$kernel->handle(\n";
$php .= "                    \$input3 = new Symfony\\Component\\Console\\Input\\StringInput('optimize'),\n";
$php .= "                    \$output3 = new Symfony\\Component\\Console\\Output\\BufferedOutput\n";
$php .= "                );\n";
$php .= "                \$artisanLog .= \"=== Optimize ===\\n\" . \$output3->fetch() . \"\\n\";\n";
$php .= "                \$log .= '✔ Laravel optimized\\n';\n";
$php .= "            } catch (\\Throwable \$eOptimize) {\n";
$php .= "                \$artisanLog .= \"=== Optimize Error ===\\n\" . \$eOptimize->getMessage() . \"\\n\";\n";
$php .= "            }\n";
$php .= "        } else {\n";
$php .= "            \$log .= '⚠ Laravel bootstrap files not found, skip DB sync\\n';\n";
$php .= "        }\n";
$php .= "    } catch (\\Throwable \$eDb) {\n";
$php .= "        \$log .= '⚠ DB Sync: ' . \$eDb->getMessage() . '\\n';\n";
$php .= "        \$artisanLog .= 'Error: ' . \$eDb->getMessage() . '\\n';\n";
$php .= "    }\n";

$php .= "\n";
$php .= "    echo \"<div style='font-family:Inter,sans-serif;max-width:640px;margin:60px auto;padding:0 20px;'>\";  \n";
$php .= "    echo \"<div style='background:linear-gradient(135deg,#064e3b,#0d9488);border-radius:1.25rem;padding:2rem;color:white;text-align:center;margin-bottom:1.5rem;'>\";  \n";
$php .= "    echo \"<div style='font-size:3rem;margin-bottom:0.75rem;'>🖨️</div>\";  \n";
$php .= "    echo \"<h1 style='margin:0;font-size:1.5rem;font-weight:900;'>Pembaruan Slip Gaji PT Nur Madani Farma Berhasil!</h1>\";  \n";
$php .= "    echo \"<p style='margin:0.5rem 0 0;opacity:0.9;font-size:0.9rem;'>Pembaruan Fitur Multi-Company Slip Gaji (v62)</p>\\n\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='background:white;border:1px solid #e5e7eb;border-radius:1rem;padding:1.5rem;margin-bottom:1.25rem;box-shadow:0 4px 16px rgba(0,0,0,0.06);'>\";  \n";
$php .= "    echo \"<h2 style='margin:0 0 1rem;color:#1f2937;font-size:1rem;font-weight:800;'>Log Pembaruan File:</h2>\";  \n";
$php .= "    echo \"<pre style='background:#f3f4f6;padding:1rem;border-radius:0.5rem;font-size:0.8rem;line-height:1.6;'>\" . htmlspecialchars(\$log) . \"</pre>\";  \n";
$php .= "    if (!empty(\$artisanLog)) {\n";
$php .= "        echo \"<h2 style='margin:1rem 0 0.5rem;color:#1f2937;font-size:1rem;font-weight:800;'>Log Database & Cache:</h2>\";\n";
$php .= "        echo \"<pre style='background:#ecfdf5;padding:1rem;border-radius:0.5rem;font-size:0.75rem;line-height:1.5;border:1px solid #a7f3d0;'>\" . htmlspecialchars(\$artisanLog) . \"</pre>\";\n";
$php .= "    }\n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='text-align:center;'>\";  \n";
$php .= "    echo \"<a href='/slip-gaji' style='display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;background:linear-gradient(135deg,#064e3b,#0d9488);color:white;text-decoration:none;border-radius:0.875rem;font-weight:800;font-size:0.95rem;box-shadow:0 4px 16px rgba(6,78,59,0.35);'>📄 Buka Data Slip Gaji</a>\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"</div>\";  \n";

$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

file_put_contents('C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1/public/installer_v62.php', $php);
echo "✅ installer_v62.php compiled successfully!\n";
?>
