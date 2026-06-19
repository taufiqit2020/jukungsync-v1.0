<?php
$b64_show = base64_encode(file_get_contents('resources/views/invoices/show.blade.php'));
$b64_struk = base64_encode(file_get_contents('resources/views/invoices/struk.blade.php'));
$b64_print = base64_encode(file_get_contents('resources/views/reports/print.blade.php'));
$b64_purchases = base64_encode(file_get_contents('resources/views/reports/print-purchases.blade.php'));

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
$php .= "    file_put_contents(\$laravelRoot . '/resources/views/invoices/show.blade.php', base64_decode('$b64_show'));\n";
$php .= "    file_put_contents(\$laravelRoot . '/resources/views/invoices/struk.blade.php', base64_decode('$b64_struk'));\n";
$php .= "    file_put_contents(\$laravelRoot . '/resources/views/reports/print.blade.php', base64_decode('$b64_print'));\n";
$php .= "    file_put_contents(\$laravelRoot . '/resources/views/reports/print-purchases.blade.php', base64_decode('$b64_purchases'));\n\n";
$php .= "    \$cacheDir = \$laravelRoot . '/bootstrap/cache';\n";
$php .= "    if (is_dir(\$cacheDir)) { \$files = glob(\$cacheDir . '/*.php'); foreach (\$files as \$f) @unlink(\$f); }\n\n";
$php .= "    echo \"<div style='font-family:sans-serif;text-align:center;margin-top:50px;'>\";\n";
$php .= "    echo \"<h1 style='color:#16a34a;'>✅ Perbaikan Tampilan Cetak Berhasil!</h1>\";\n";
$php .= "    echo \"<ul style='text-align:left;max-width:500px;margin:20px auto;color:#374151;font-size:15px;'><li>✅ Invoice Klien &amp; Internal: Header kolom gelap, nominal Rp rapi &amp; tidak mepet</li><li>✅ Struk: Kolom harga, jumlah, dan total sejajar sempurna</li><li>✅ Laporan Rekapitulasi Invoice: Nominal Rp + spasi</li><li>✅ Laporan Pembelian: Nominal Rp + spasi</li></ul>\";\n";
$php .= "    echo \"<a href='/invoices' style='display:inline-block;padding:10px 20px;background:#991b1b;color:white;text-decoration:none;border-radius:5px;margin-top:20px;'>Kembali ke Aplikasi</a>\";\n";
$php .= "    echo \"</div>\";\n";
$php .= "    @unlink(__FILE__);\n";
$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_customer_v18.md', $md);
echo "installer_customer_v18.md created!\n";
