<?php
$projectRoot = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1';
$files = [
    'app/Http/Controllers/StorageController.php',
    'routes/web.php',
    'config/filesystems.php',
    'public/fix_storage.php',
    'public/test_serve.php',
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

$php .= "\n    // Jalankan fix_storage.php secara internal untuk memperbarui direktori fisik dan menyalin gambar\n";
$php .= "    \$fixStoragePath = \$laravelRoot . '/public/fix_storage.php';\n";
$php .= "    if (file_exists(\$fixStoragePath)) {\n";
$php .= "        ob_start();\n";
$php .= "        include \$fixStoragePath;\n";
$php .= "        \$fixOutput = ob_get_clean();\n";
$php .= "        \$log .= '\\n--- Hasil Eksekusi fix_storage.php ---\\n' . strip_tags(\$fixOutput) . '\\n';\n";
$php .= "    }\n";

$php .= "\n    echo \"<div style='font-family:Inter,sans-serif;max-width:640px;margin:60px auto;padding:0 20px;'>\";  \n";
$php .= "    echo \"<div style='background:linear-gradient(135deg,#059669,#10b981);border-radius:1.25rem;padding:2rem;color:white;text-align:center;margin-bottom:1.5rem;'>\";  \n";
$php .= "    echo \"<div style='font-size:3rem;margin-bottom:0.75rem;'>🖼️</div>\";  \n";
$php .= "    echo \"<h1 style='margin:0;font-size:1.5rem;font-weight:900;'>Perbaikan Gambar & E-Catalog Berhasil!</h1>\";  \n";
$php .= "    echo \"<p style='margin:0.5rem 0 0;opacity:0.8;font-size:0.9rem;'>Bypass Symlink & Dynamic Fallback Servicing (v57)</p>\n\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='background:white;border:1px solid #e5e7eb;border-radius:1rem;padding:1.5rem;margin-bottom:1.25rem;box-shadow:0 4px 16px rgba(0,0,0,0.06);'>\";  \n";
$php .= "    echo \"<h2 style='margin:0 0 1rem;color:#1f2937;font-size:1rem;font-weight:800;'>Log Pembaruan:</h2>\";  \n";
$php .= "    echo \"<pre style='background:#f3f4f6;padding:1rem;border-radius:0.5rem;font-size:0.8rem;line-height:1.6;'>\" . htmlspecialchars(\$log) . \"</pre>\";\n";
$php .= "    echo \"<p style='font-size:0.875rem;color:#4b5563;'>Sistem sekarang menggunakan custom routing untuk serving file dari folder storage. Jika gambar tidak ditemukan, sistem akan menyajikan gambar fallback yang sesuai.</p>\n\";\n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='text-align:center;'>\";  \n";
$php .= "    echo \"<a href='/catalog' style='display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;background:linear-gradient(135deg,#ca8a04,#d97706);color:#111827;text-decoration:none;border-radius:0.875rem;font-weight:800;font-size:0.95rem;box-shadow:0 4px 16px rgba(202,138,4,0.35);'>🌐 Buka E-Catalog</a>\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"</div>\";  \n";

$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_v57.php', $php);
file_put_contents('C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1/public/installer_v57.php', $php);
echo "✅ installer_v57.php compiled successfully!\n";
?>
