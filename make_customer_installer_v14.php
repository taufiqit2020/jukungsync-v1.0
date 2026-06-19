<?php
$b64_print_view = base64_encode(file_get_contents('resources/views/invoices/show.blade.php'));

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
$php .= "        if (is_dir(\$path)) {\n";
$php .= "            \$found = findLaravelRoot(\$path, \$depth + 1);\n";
$php .= "            if (\$found) return \$found;\n";
$php .= "        }\n";
$php .= "    }\n";
$php .= "    return null;\n";
$php .= "}\n\n";

$php .= "\$baseSearch = dirname(__DIR__);\n";
$php .= "\$laravelRoot = findLaravelRoot(\$baseSearch);\n";
$php .= "if (!\$laravelRoot) {\n";
$php .= "    \$index = @file_get_contents(__DIR__ . '/index.php');\n";
$php .= "    if (\$index && preg_match('/require.*?__DIR__\s*\.\s*[\'\"](.*?)vendor\/autoload\.php[\'\"]/', \$index, \$m)) {\n";
$php .= "        \$rel = trim(\$m[1], '/');\n";
$php .= "        \$laravelRoot = \$rel === '..' ? realpath(__DIR__ . '/..') : realpath(__DIR__ . '/' . \$rel);\n";
$php .= "    }\n";
$php .= "}\n";
$php .= "if (!\$laravelRoot) \$laravelRoot = __DIR__;\n\n";

$php .= "try {\n";
$php .= "    file_put_contents(\$laravelRoot . '/resources/views/invoices/show.blade.php', base64_decode('$b64_print_view'));\n\n";

$php .= "    \$cacheDir = \$laravelRoot . '/bootstrap/cache';\n";
$php .= "    if (is_dir(\$cacheDir)) {\n";
$php .= "        \$files = glob(\$cacheDir . '/*.php');\n";
$php .= "        foreach (\$files as \$file) @unlink(\$file);\n";
$php .= "    }\n\n";

$php .= "    echo \"<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>\";\n";
$php .= "    echo \"<h1 style='color:#16a34a;'>✅ Perbaikan Tata Letak Cetak (Print) Berhasil!</h1>\";\n";
$php .= "    echo \"<p style='color:#4b5563;'>Footer/Catatan bawah pada cetakan Invoice kini tidak akan menutupi daftar barang lagi, baik untuk invoice Klien maupun Internal.</p>\";\n";
$php .= "    echo \"<a href='/invoices' style='display: inline-block; padding: 10px 20px; background: #991b1b; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px;'>Kembali ke Aplikasi</a>\";\n";
$php .= "    echo \"</div>\";\n\n";

$php .= "    @unlink(__FILE__);\n";
$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error Fatal:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_customer_v14.md', $md);
