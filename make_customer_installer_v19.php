<?php
$v11 = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1';
$files = [
    'app/Http/Controllers/CustomerController.php',
    'app/Http/Controllers/DashboardController.php',
    'app/Http/Controllers/InvoiceController.php',
    'app/Http/Controllers/ProductController.php',
    'app/Http/Controllers/SearchController.php',
    'app/Models/Customer.php',
    'app/Models/Product.php',
    'database/migrations/2026_06_12_083207_add_stok_minimum_to_products_table.php',
    'database/migrations/2026_06_12_083213_add_extra_fields_to_customers_table.php',
    'resources/views/customers/create.blade.php',
    'resources/views/customers/edit.blade.php',
    'resources/views/customers/index.blade.php',
    'resources/views/customers/show.blade.php',
    'resources/views/dashboard.blade.php',
    'resources/views/invoices/index.blade.php',
    'resources/views/layouts/admin.blade.php',
    'resources/views/products/create.blade.php',
    'resources/views/products/edit.blade.php',
    'resources/views/products/index.blade.php',
    'routes/web.php',
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

$php .= "    \$cacheDir = \$laravelRoot . '/bootstrap/cache';\n";
$php .= "    if (is_dir(\$cacheDir)) { \$files = glob(\$cacheDir . '/*.php'); foreach (\$files as \$f) @unlink(\$f); }\n\n";

$php .= "    echo \"<div style='font-family:sans-serif;text-align:center;margin-top:50px;'>\";\n";
$php .= "    echo \"<h1 style='color:#16a34a;'>✅ Deployment JukungSync V1.1 Sprint 1 Berhasil!</h1>\";\n";
$php .= "    echo \"<p style='color:#374151;'>Seluruh file baru dan modifikasi telah dipasang.</p>\n\";\n";
$php .= "    echo \"<p style='color:#b91c1c;font-weight:bold;margin:20px 0;'>PENTING: Harap buka URL berikut untuk menjalankan migrasi database: <a href='/jalankan-otomatis' target='_blank'>/jalankan-otomatis</a></p>\n\";\n";
$php .= "    echo \"<a href='/dashboard' style='display:inline-block;padding:10px 20px;background:#1e293b;color:white;text-decoration:none;border-radius:5px;'>Masuk ke Dashboard</a>\";\n";
$php .= "    echo \"</div>\";\n";
$php .= "    @unlink(__FILE__);\n";
$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_customer_v19.md', $md);
echo "installer_customer_v19.md created successfully!\n";
