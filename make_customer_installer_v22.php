<?php
$v11 = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1';
$files = [
    // Controllers
    'app/Http/Controllers/CatalogController.php',
    'app/Http/Controllers/UserController.php',
    // Models
    'app/Models/User.php',
    // Migration
    'database/migrations/2026_06_14_000001_update_tipe_pelanggan_add_metode_pembayaran.php',
    // Views
    'resources/views/catalog/checkout.blade.php',
    'resources/views/users/form.blade.php',
    'resources/views/layouts/customer.blade.php',
    'resources/views/catalog/index.blade.php',
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
    $fullPath = "$v11/$f";
    if (!file_exists($fullPath)) {
        die("Error: File not found: $fullPath\n");
    }
    $b64 = base64_encode(file_get_contents($fullPath));
    $php .= "    @mkdir(dirname(\$laravelRoot . '/$f'), 0777, true);\n";
    $php .= "    file_put_contents(\$laravelRoot . '/$f', base64_decode('$b64'));\n";
}

$php .= "    // Bersihkan cache Laravel\n";
$php .= "    \$cacheDir = \$laravelRoot . '/bootstrap/cache';\n";
$php .= "    if (is_dir(\$cacheDir)) { \$caches = glob(\$cacheDir . '/*.php'); foreach (\$caches as \$cf) @unlink(\$cf); }\n\n";

$php .= "    echo \"<div style='font-family:sans-serif;text-align:center;margin-top:50px;padding:20px;'>\";  \n";
$php .= "    echo \"<h1 style='color:#16a34a;'>✅ Update Sistem Kategori Pelanggan V22 Berhasil!</h1>\";\n";
$php .= "    echo \"<p style='color:#374151;max-width:600px;margin:0 auto 20px;'>Sistem 3 tier pelanggan (Reguler / Member / Premium), logika harga grosir+diskon, info rekening BSI, metode pembayaran, perbaikan badge dan integrasi Alpine.js telah dipasang dengan sempurna.</p>\";\n";
$php .= "    echo \"<div style='background:#fef9c3;border:1px solid #ca8a04;padding:15px;border-radius:8px;max-width:600px;margin:0 auto 20px;text-align:left;'>\";  \n";
$php .= "    echo \"<strong style='color:#92400e;'>⚠ PENTING: Jalankan migrasi database jika belum!</strong><br>\";  \n";
$php .= "    echo \"<code style='font-size:13px;color:#1e293b;'>php artisan migrate --force</code>\";  \n";
$php .= "    echo \"<br><small style='color:#78716c;'>Atau buka: <a href='/jalankan-otomatis'>/jalankan-otomatis</a></small>\";  \n";
$php .= "    echo \"</div>\";\n";
$php .= "    echo \"<a href='/catalog' style='display:inline-block;padding:10px 24px;background:#1e293b;color:white;text-decoration:none;border-radius:8px;font-weight:bold;margin-right:10px;'>Buka Catalog</a>\";\n";
$php .= "    echo \"<a href='/dashboard' style='display:inline-block;padding:10px 24px;background:#e2e8f0;color:#1e293b;text-decoration:none;border-radius:8px;font-weight:bold;'>Buka Dashboard</a>\";\n";
$php .= "    echo \"</div>\";\n";
$php .= "    @unlink(__FILE__);\n";
$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_customer_v22.md', $md);
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_customer_v22.php', $php);
echo "✅ installer_customer_v22.md and installer_customer_v22.php created successfully!\n";
