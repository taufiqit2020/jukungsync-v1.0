<?php
$projectRoot = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1';
$files = [
    'app/Http/Controllers/StorageController.php',
    'app/Http/Controllers/DatabaseBackupController.php',
    'routes/web.php',
    'config/filesystems.php',
    'public/fix_storage.php',
    'public/restore_missing_images.php',
    'resources/views/products/create.blade.php',
    'resources/views/products/edit.blade.php',
    'resources/views/products/index.blade.php',
    'resources/views/catalog/index.blade.php',
    'app/Models/Product.php',
    'app/Http/Controllers/ProductController.php',
    'database/migrations/2026_06_27_000001_add_gambar_tambahan_to_products_table.php',
    'resources/views/layouts/admin.blade.php',
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

$php .= "\n    // 1. Jalankan fix_storage.php secara internal untuk membuat folder public/storage\n";
$php .= "    \$fixStoragePath = \$laravelRoot . '/public/fix_storage.php';\n";
$php .= "    if (file_exists(\$fixStoragePath)) {\n";
$php .= "        ob_start();\n";
$php .= "        include \$fixStoragePath;\n";
$php .= "        \$fixOutput = ob_get_clean();\n";
$php .= "        \$log .= '\\n--- Hasil Eksekusi fix_storage.php ---\\n' . strip_tags(\$fixOutput) . '\\n';\n";
$php .= "    }\n";

$php .= "\n    // 2. Jalankan restore_missing_images.php secara internal untuk memulihkan gambar yang kosong/hilang dan menjalankan migrasi otomatis\n";
$php .= "    \$restoreImagesPath = \$laravelRoot . '/public/restore_missing_images.php';\n";
$php .= "    if (file_exists(\$restoreImagesPath)) {\n";
$php .= "        ob_start();\n";
$php .= "        include \$restoreImagesPath;\n";
$php .= "        \$restoreOutput = ob_get_clean();\n";
$php .= "        \$log .= '\\n--- Hasil Eksekusi restore_missing_images.php ---\\n' . strip_tags(\$restoreOutput) . '\\n';\n";
$php .= "    }\n";

$php .= "\n    echo \"<div style='font-family:Inter,sans-serif;max-width:640px;margin:60px auto;padding:0 20px;'>\";  \n";
$php .= "    echo \"<div style='background:linear-gradient(135deg,#0284c7,#0ea5e9);border-radius:1.25rem;padding:2rem;color:white;text-align:center;margin-bottom:1.5rem;'>\";  \n";
$php .= "    echo \"<div style='font-size:3rem;margin-bottom:0.75rem;'>🖼️</div>\";  \n";
$php .= "    echo \"<h1 style='margin:0;font-size:1.5rem;font-weight:900;'>Perbaikan & Restorasi Gambar Berhasil!</h1>\";  \n";
$php .= "    echo \"<p style='margin:0.5rem 0 0;opacity:0.8;font-size:0.9rem;'>Bypass Symlink & Direct Storage Upload (v59)</p>\n\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='background:white;border:1px solid #e5e7eb;border-radius:1rem;padding:1.5rem;margin-bottom:1.25rem;box-shadow:0 4px 16px rgba(0,0,0,0.06);'>\";  \n";
$php .= "    echo \"<h2 style='margin:0 0 1rem;color:#1f2937;font-size:1rem;font-weight:800;'>Log Pembaruan:</h2>\";  \n";
$php .= "    echo \"<pre style='background:#f3f4f6;padding:1rem;border-radius:0.5rem;font-size:0.8rem;line-height:1.6;'>\" . htmlspecialchars(\$log) . \"</pre>\";\n";
$php .= "    echo \"<p style='font-size:0.875rem;color:#4b5563;'>Semua gambar produk telah disesuaikan agar di-upload langsung ke folder public/storage/ sehingga langsung dapat diakses oleh browser.</p>\n\";\n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='text-align:center;'>\";  \n";
$php .= "    echo \"<a href='/products' style='display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;background:linear-gradient(135deg,#ca8a04,#d97706);color:#111827;text-decoration:none;border-radius:0.875rem;font-weight:800;font-size:0.95rem;box-shadow:0 4px 16px rgba(202,138,4,0.35);'>🌐 Buka Data Barang</a>\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"</div>\";  \n";

$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

file_put_contents('C:/Users/USER/.gemini/antigravity/brain/b0e98c3b-0322-4127-ab7c-34a3b69f6f66/installer_v59.php', $php);
file_put_contents('C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1/public/installer_v59.php', $php);
echo "✅ installer_v59.php compiled successfully!\n";
?>
