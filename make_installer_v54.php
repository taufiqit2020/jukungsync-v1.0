<?php
$projectRoot = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1';
$files = [
    'config/filesystems.php',
    'public/perbaiki_storage_link.php',
    'public/cek_gambar_produksi.php',
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

$php .= "\n    // --- LOGIC PERBAIKAN STORAGE LINK OTOMATIS (FISIK - TANPA SYMLINK) ---\n";
$php .= "    \$publicStoragePath = \$laravelRoot . '/public/storage';\n";
$php .= "    \$targetStoragePath = \$laravelRoot . '/storage/app/public';\n";
$php .= "    \$log = '';\n\n";

$php .= "    if (is_link(\$publicStoragePath)) {\n";
$php .= "        @unlink(\$publicStoragePath);\n";
$php .= "        \$log .= '✔ Symbolic link lama dihapus.\\n';\n";
$php .= "    }\n\n";

$php .= "    if (!is_dir(\$publicStoragePath)) {\n";
$php .= "        if (@mkdir(\$publicStoragePath, 0777, true)) {\n";
$php .= "            \$log .= '✔ Direktori fisik public/storage dibuat.\\n';\n";
$php .= "        } else {\n";
$php .= "            \$log .= '❌ Gagal membuat direktori fisik public/storage.\\n';\n";
$php .= "        }\n";
$php .= "    }\n\n";

$php .= "    // Buat subfolder\n";
$php .= "    foreach (['products', 'bukti_invoices'] as \$sub) {\n";
$php .= "        \$subPath = \$publicStoragePath . '/' . \$sub;\n";
$php .= "        if (!is_dir(\$subPath)) {\n";
$php .= "            @mkdir(\$subPath, 0777, true);\n";
$php .= "        }\n";
$php .= "    }\n\n";

$php .= "    // Salin file secara rekursif\n";
$php .= "    function copyFolderRecursive(\$src, \$dst) {\n";
$php .= "        if (!is_dir(\$src)) return 0;\n";
$php .= "        @mkdir(\$dst, 0777, true);\n";
$php .= "        \$count = 0;\n";
$php .= "        \$files = array_diff(scandir(\$src), array('.','..'));\n";
$php .= "        foreach (\$files as \$file) {\n";
$php .= "            if (is_dir(\"\$src/\$file\")) {\n";
$php .= "                \$count += copyFolderRecursive(\"\$src/\$file\", \"\$dst/\$file\");\n";
$php .= "            } else {\n";
$php .= "                if (@copy(\"\$src/\$file\", \"\$dst/\$file\")) {\n";
$php .= "                    \$count++;\n";
$php .= "                }\n";
$php .= "            }\n";
$php .= "        }\n";
$php .= "        return \$count;\n";
$php .= "    }\n\n";

$php .= "    // 1. Salin file dari folder storage/app/public\n";
$php .= "    \$copiedCount = copyFolderRecursive(\$targetStoragePath, \$publicStoragePath);\n";
$php .= "    \$log .= '✔ Berhasil menyalin ' . \$copiedCount . ' file media dari folder storage.\\n';\n\n";

$php .= "    // 2. Salin file seeder dari folder public/img/products ke public/storage/products\n";
$php .= "    \$imgProductsPath = \$laravelRoot . '/public/img/products';\n";
$php .= "    if (is_dir(\$imgProductsPath)) {\n";
$php .= "        \$copiedImg = copyFolderRecursive(\$imgProductsPath, \$publicStoragePath . '/products');\n";
$php .= "        \$log .= '✔ Berhasil menyalin ' . \$copiedImg . ' file seeder dari folder img/products.\\n';\n";
$php .= "    }\n\n";

$php .= "    // Bersihkan cache Laravel\n";
$php .= "    \$cacheDir = \$laravelRoot . '/bootstrap/cache';\n";
$php .= "    if (is_dir(\$cacheDir)) { \$caches = glob(\$cacheDir . '/*.php'); foreach (\$caches as \$cf) @unlink(\$cf); }\n\n";
$php .= "    if (function_exists('opcache_reset')) { opcache_reset(); }\n\n";

$php .= "    echo \"<div style='font-family:Inter,sans-serif;max-width:640px;margin:60px auto;padding:0 20px;'>\";  \n";
$php .= "    echo \"<div style='background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:1.25rem;padding:2rem;color:white;text-align:center;margin-bottom:1.5rem;'>\";  \n";
$php .= "    echo \"<div style='font-size:3rem;margin-bottom:0.75rem;'>🖼️</div>\";  \n";
$php .= "    echo \"<h1 style='margin:0;font-size:1.5rem;font-weight:900;'>Pembaruan & Migrasi Berhasil!</h1>\";  \n";
$php .= "    echo \"<p style='margin:0.5rem 0 0;opacity:0.8;font-size:0.9rem;'>Penyimpanan Fisik Tanpa Symlink Diaktifkan (v54)</p>\n\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='background:white;border:1px solid #e5e7eb;border-radius:1rem;padding:1.5rem;margin-bottom:1.25rem;box-shadow:0 4px 16px rgba(0,0,0,0.06);'>\";  \n";
$php .= "    echo \"<h2 style='margin:0 0 1rem;color:#1f2937;font-size:1rem;font-weight:800;'>Log Pembaruan:</h2>\";  \n";
$php .= "    echo \"<pre style='background:#f3f4f6;padding:1rem;border-radius:0.5rem;font-size:0.8rem;line-height:1.6;'>\" . htmlspecialchars(\$log) . \"</pre>\";\n";
$php .= "    echo \"<p style='font-size:0.875rem;color:#4b5563;'>Disk <code>public</code> telah dipindahkan ke folder fisik <code>public/storage</code>. Semua file media seeder berhasil disalin.</p>\";\n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='text-align:center;'>\";  \n";
$php .= "    echo \"<a href='/products' style='display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;background:linear-gradient(135deg,#ca8a04,#d97706);color:#111827;text-decoration:none;border-radius:0.875rem;font-weight:800;font-size:0.95rem;box-shadow:0 4px 16px rgba(202,138,4,0.35);'>📦 Buka Data Barang</a>\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"</div>\";  \n";

$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_image_fix_v54.php', $php);
file_put_contents('C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1/public/installer_image_fix_v54.php', $php);
echo "✅ installer_image_fix_v54.php created successfully!\n";
?>
