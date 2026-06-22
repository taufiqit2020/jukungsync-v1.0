<?php
$projectRoot = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1';
$files = [
    'app/Http/Controllers/OnlineOrderController.php',
    'app/Http/Controllers/KasbonController.php',
    'app/Models/User.php',
    'app/Models/Kasbon.php',
    'routes/web.php',
    'resources/views/online-orders/show.blade.php',
    'resources/views/online-orders/surat-jalan.blade.php',
    'resources/views/layouts/admin.blade.php',
    'resources/views/kasbons/index.blade.php',
    'database/migrations/2026_06_20_000002_create_kasbons_table.php',
    'public/jalankan_migrasi_direk.php',
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
foreach ($files as $f) {
    $fullPath = "$projectRoot/$f";
    if (!file_exists($fullPath)) {
        die("Error: File not found: $fullPath\n");
    }
    $b64 = base64_encode(file_get_contents($fullPath));
    $php .= "    @mkdir(dirname(\$laravelRoot . '/$f'), 0777, true);\n";
    $php .= "    file_put_contents(\$laravelRoot . '/$f', base64_decode('$b64'));\n";
    if ($f === 'public/jalankan_migrasi_direk.php') {
        $php .= "    file_put_contents(__DIR__ . '/jalankan_migrasi_direk.php', base64_decode('$b64'));\n";
    }
}

$php .= "    // Bersihkan cache Laravel\n";
$php .= "    \$cacheDir = \$laravelRoot . '/bootstrap/cache';\n";
$php .= "    if (is_dir(\$cacheDir)) { \$caches = glob(\$cacheDir . '/*.php'); foreach (\$caches as \$cf) @unlink(\$cf); }\n\n";
$php .= "    if (function_exists('apc_clear_cache')) { apc_clear_cache(); }\n";
$php .= "    if (function_exists('opcache_reset')) { opcache_reset(); }\n\n";

$php .= "    echo \"<div style='font-family:sans-serif;text-align:center;margin-top:50px;padding:20px;'>\";  \n";
$php .= "    echo \"<h1 style='color:#16a34a;'>✅ Pembaruan Fitur Kasbon & Bugfix Checkout Sukses!</h1>\";\n";
$php .= "    echo \"<p style='color:#374151;max-width:600px;margin:0 auto 20px;'>File-file perbaikan telah berhasil diekstrak dan disinkronkan ke live server.</p>\";\n";

$php .= "    echo \"<div style='background:#fef9c3;border:1px solid #ca8a04;padding:15px;border-radius:8px;max-width:600px;margin:0 auto 20px;text-align:left;'>\";  \n";
$php .= "    echo \"<strong style='color:#92400e;'>⚠ PENTING: Jalankan migrasi database!</strong><br>\";  \n";
$php .= "    echo \"<span style='font-size:14px;color:#1e293b;'>Buka tautan berikut di tab baru untuk memigrasi tabel database kasbon:</span><br>\";  \n";
$php .= "    echo \"<a href='/jalankan_migrasi_direk.php' target='_blank' style='display:inline-block;margin-top:10px;padding:8px 16px;background:#ca8a04;color:white;text-decoration:none;border-radius:6px;font-weight:bold;font-size:14px;'>Jalankan Migrasi Database Otomatis</a>\";  \n";
$php .= "    echo \"</div>\";\n\n";

$php .= "    echo \"<a href='/catalog/checkout' style='display:inline-block;padding:12px 28px;background:#7f1d1d;color:white;text-decoration:none;border-radius:8px;font-weight:bold;font-size:16px;'>Buka Halaman Checkout Belanja</a>\";\n";
$php .= "    echo \"</div>\";\n";
$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_customer_v47.md', $md);
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_customer_v47.php', $php);
file_put_contents('C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1/public/installer_customer_v47.php', $php);
echo "✅ installer_customer_v47.md and installer_customer_v47.php created successfully in brain and public folder!\n";
?>
