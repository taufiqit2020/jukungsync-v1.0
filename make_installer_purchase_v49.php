<?php
$projectRoot = 'C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1';
$files = [
    'app/Http/Controllers/PurchaseController.php',
    'resources/views/purchases/edit.blade.php',
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

$php .= "\n    // Bersihkan cache Laravel\n";
$php .= "    \$cacheDir = \$laravelRoot . '/bootstrap/cache';\n";
$php .= "    if (is_dir(\$cacheDir)) { \$caches = glob(\$cacheDir . '/*.php'); foreach (\$caches as \$cf) @unlink(\$cf); }\n\n";
$php .= "    if (function_exists('opcache_reset')) { opcache_reset(); }\n\n";

$php .= "    echo \"<div style='font-family:Inter,sans-serif;max-width:640px;margin:60px auto;padding:0 20px;'>\";  \n";
$php .= "    echo \"<div style='background:linear-gradient(135deg,#7f1d1d,#991b1b);border-radius:1.25rem;padding:2rem;color:white;text-align:center;margin-bottom:1.5rem;'>\";  \n";
$php .= "    echo \"<div style='font-size:3rem;margin-bottom:0.75rem;'>📦</div>\";  \n";
$php .= "    echo \"<h1 style='margin:0;font-size:1.5rem;font-weight:900;'>Pembaruan Berhasil!</h1>\";  \n";
$php .= "    echo \"<p style='margin:0.5rem 0 0;opacity:0.8;font-size:0.9rem;'>Edit Barang Masuk — Live Search & Redesign</p>\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"<div style='background:white;border:1px solid #e5e7eb;border-radius:1rem;padding:1.5rem;margin-bottom:1.25rem;box-shadow:0 4px 16px rgba(0,0,0,0.06);'>\";  \n";
$php .= "    echo \"<h2 style='margin:0 0 1rem;color:#1f2937;font-size:1rem;font-weight:800;'>✅ File yang Diperbarui:</h2>\";  \n";
$php .= "    echo \"<ul style='margin:0;padding:0 0 0 1.25rem;color:#374151;font-size:0.875rem;line-height:2;'>\";  \n";
$php .= "    echo \"<li><strong>edit.blade.php</strong> — Desain baru full-page dengan Live Search autocomplete (sama seperti halaman input)</li>\";  \n";
$php .= "    echo \"<li><strong>PurchaseController.php</strong> — Penanganan update item kompleks, penambahan baris, penghapusan baris, dan penyelarasan stok master</li>\";  \n";
$php .= "    echo \"</ul></div>\";  \n";
$php .= "    echo \"<div style='background:#f0fdf4;border:1.5px solid #86efac;border-radius:1rem;padding:1.25rem;margin-bottom:1.25rem;'>\";  \n";
$php .= "    echo \"<h3 style='margin:0 0 0.75rem;color:#166534;font-size:0.9rem;font-weight:800;'>🔍 Fitur Baru Halaman Edit:</h3>\";  \n";
$php .= "    echo \"<ul style='margin:0;padding:0 0 0 1.25rem;color:#166534;font-size:0.8rem;line-height:1.8;'>\";  \n";
$php .= "    echo \"<li>Edit header nota: No Faktur, Supplier, Tanggal, Keterangan</li>\";  \n";
$php .= "    echo \"<li>Edit barang yang ada: Ganti barang, ubah harga beli, harga jual, dan kuantitas</li>\";  \n";
$php .= "    echo \"<li>Tambah baris barang baru dengan pencarian live autocomplete</li>\";  \n";
$php .= "    echo \"<li>Hapus baris barang lama (otomatis mengurangi stok produk master terkait saat disimpan)</li>\";  \n";
$php .= "    echo \"<li>Perhitungan total biaya pembelian dan subtotal dinamis secara real-time</li>\";  \n";
$php .= "    echo \"</ul></div>\";  \n";
$php .= "    echo \"<div style='text-align:center;'>\";  \n";
$php .= "    echo \"<a href='/purchases' style='display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;background:linear-gradient(135deg,#ca8a04,#d97706);color:#111827;text-decoration:none;border-radius:0.875rem;font-weight:800;font-size:0.95rem;box-shadow:0 4px 16px rgba(202,138,4,0.35);'>📦 Buka Daftar Barang Masuk</a>\";  \n";
$php .= "    echo \"</div>\";  \n";
$php .= "    echo \"</div>\";  \n";

$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_purchase_redesign_v49.php', $php);
file_put_contents('C:/Users/USER/.gemini/antigravity/scratch/JukungSync-V1.1/public/installer_purchase_redesign_v49.php', $php);
echo "✅ installer_purchase_redesign_v49.php created successfully!\n";
?>
