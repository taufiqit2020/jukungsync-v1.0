<?php
$projectRoot = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1';
$files = [
    'public/perbaiki_storage_link.php',
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
}

$php .= "\n    // --- LOGIC PERBAIKAN STORAGE LINK OTOMATIS ---\n";
$php .= "    \$publicStoragePath = \$laravelRoot . '/public/storage';\n";
$php .= "    \$targetStoragePath = \$laravelRoot . '/storage/app/public';\n";
$php .= "    \$linkSuccess = false;\n";
$php .= "    \$linkMessage = '';\n\n";

$php .= "    if (!is_dir(\$targetStoragePath)) {\n";
$php .= "        @mkdir(\$targetStoragePath, 0777, true);\n";
$php .= "    }\n\n";

$php .= "    if (file_exists(\$publicStoragePath) || is_link(\$publicStoragePath)) {\n";
$php .= "        if (is_link(\$publicStoragePath)) {\n";
$php .= "            if (realpath(\$publicStoragePath) === realpath(\$targetStoragePath)) {\n";
$php .= "                \$linkSuccess = true;\n";
$php .= "                \$linkMessage = 'Symbolic link storage sudah valid dan aktif.';\n";
$php .= "            } else {\n";
$php .= "                @unlink(\$publicStoragePath);\n";
$php .= "            }\n";
$php .= "        } else {\n";
$php .= "            // Jika berupa direktori biasa, coba hapus\n";
$php .= "            function deleteFolderRecursive(\$dir) {\n";
$php .= "                if (!is_dir(\$dir)) return false;\n";
$php .= "                \$files = array_diff(scandir(\$dir), array('.','..'));\n";
$php .= "                foreach (\$files as \$file) {\n";
$php .= "                    (is_dir(\"\$dir/\$file\")) ? deleteFolderRecursive(\"\$dir/\$file\") : unlink(\"\$dir/\$file\");\n";
$php .= "                }\n";
$php .= "                return rmdir(\$dir);\n";
$php .= "            }\n";
$php .= "            deleteFolderRecursive(\$publicStoragePath);\n";
$php .= "        }\n";
$php .= "    }\n\n";

$php .= "    if (!\$linkSuccess) {\n";
$php .= "        if (@symlink(\$targetStoragePath, \$publicStoragePath)) {\n";
$php .= "            \$linkSuccess = true;\n";
$php .= "            \$linkMessage = 'Symbolic link storage berhasil dibuat menggunakan PHP symlink()!';\n";
$php .= "        } else {\n";
$php .= "            try {\n";
$php .= "                if (file_exists(\$laravelRoot . '/vendor/autoload.php')) {\n";
$php .= "                    require_once \$laravelRoot . '/vendor/autoload.php';\n";
$php .= "                    \$app = require_once \$laravelRoot . '/bootstrap/app.php';\n";
$php .= "                    \$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();\n";
$php .= "                    \\Illuminate\\Support\\Facades\\Artisan::call('storage:link');\n";
$php .= "                    \$linkSuccess = true;\n";
$php .= "                    \$linkMessage = 'Symbolic link storage berhasil dibuat menggunakan php artisan storage:link!';\n";
$php .= "                }\n";
$php .= "            } catch (\\Throwable \$e) {\n";
$php .= "                \$linkMessage = 'Gagal membuat symbolic link: ' . \$e->getMessage();\n";
$php .= "            }\n";
$php .= "        }\n";
$php .= "    }\n\n";

$php .= "    // Bersihkan cache Laravel\n";
$php .= "    \$cacheDir = \$laravelRoot . '/bootstrap/cache';\n";
$php .= "    if (is_dir(\$cacheDir)) { \$caches = glob(\$cacheDir . '/*.php'); foreach (\$caches as \$cf) @unlink(\$cf); }\n\n";
$php .= "    if (function_exists('opcache_reset')) { opcache_reset(); }\n\n";

$php .= "    echo \"<div style='font-family:Inter,sans-serif;max-width:640px;margin:60px auto;padding:0 20px;'>\";  \n";
$php .= "    echo \"<div style='background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:1.25rem;padding:2rem;color:white;text-align:center;margin-bottom:1.5rem;'>\";  \n";
$php .= "    echo \"<div style='font-size:3rem;margin-bottom:0.75rem;'>🖼️</div>\";  \n";
$php .= "    echo \"<h1 style='margin:0;font-size:1.5rem;font-weight:900;'>Pembaruan & Perbaikan Berhasil!</h1>\";  \n";
$php .= "    echo \"<p style='margin:0.5rem 0 0;opacity:0.8;font-size:0.9rem;'>Perbaikan Bug Upload & Tampilan Gambar Produk</p>\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='background:white;border:1px solid #e5e7eb;border-radius:1rem;padding:1.5rem;margin-bottom:1.25rem;box-shadow:0 4px 16px rgba(0,0,0,0.06);'>\";  \n";
$php .= "    echo \"<h2 style='margin:0 0 1rem;color:#1f2937;font-size:1rem;font-weight:800;'>Status Link Storage:</h2>\";  \n";
$php .= "    if (\$linkSuccess) {\n";
$php .= "        echo \"<div style='background:#dcfce7;border:1.5px solid #86efac;color:#166534;border-radius:0.75rem;padding:1rem;font-size:0.875rem;font-weight:600;'>✔ \" . htmlspecialchars(\$linkMessage) . \"</div>\";\n";
$php .= "    } else {\n";
$php .= "        echo \"<div style='background:#fee2e2;border:1.5px solid #fecaca;color:#991b1b;border-radius:0.75rem;padding:1rem;font-size:0.875rem;font-weight:600;'>❌ \" . htmlspecialchars(\$linkMessage) . \"</div>\";\n";
$php .= "    }\n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='text-align:center;'>\";  \n";
$php .= "    echo \"<a href='/products' style='display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;background:linear-gradient(135deg,#ca8a04,#d97706);color:#111827;text-decoration:none;border-radius:0.875rem;font-weight:800;font-size:0.95rem;box-shadow:0 4px 16px rgba(202,138,4,0.35);'>📦 Buka Data Barang</a>\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"</div>\";  \n";

$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_image_fix_v51.php', $php);
file_put_contents('C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1/public/installer_image_fix_v51.php', $php);
echo "✅ installer_image_fix_v51.php created successfully!\n";
?>
