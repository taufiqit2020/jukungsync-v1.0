<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
echo "<h1>Fix Storage Link & Images v57</h1>";
echo "<p>Laravel Root: $laravelRoot</p>";

$publicStorage = $laravelRoot . '/public/storage';
$storageAppPublic = $laravelRoot . '/storage/app/public';

$log = '';

// Helper function to copy folders recursively safely without overwriting existing user files
function copyFolderRecursive($src, $dst, $overwrite = false) {
    if (!is_dir($src)) return 0;
    @mkdir($dst, 0777, true);
    $count = 0;
    $files = array_diff(scandir($src), array('.','..'));
    foreach ($files as $file) {
        if (is_dir("$src/$file")) {
            $count += copyFolderRecursive("$src/$file", "$dst/$file", $overwrite);
        } else {
            if (!$overwrite && file_exists("$dst/$file")) {
                continue; // Jangan timpa jika file sudah ada!
            }
            if (@copy("$src/$file", "$dst/$file")) {
                $count++;
            }
        }
    }
    return $count;
}

try {
    // 1. Pastikan tidak menghapus direktori/file di public/storage
    if (is_link($publicStorage)) {
        @unlink($publicStorage);
    }

    // 2. Buat direktori fisik public/storage
    if (!is_dir($publicStorage)) {
        @mkdir($publicStorage, 0777, true);
    }

    // 3. Buat subdirektori products & bukti_invoices
    $subDirs = ['products', 'bukti_invoices'];
    foreach ($subDirs as $sub) {
        $subPath = $publicStorage . '/' . $sub;
        if (!is_dir($subPath)) {
            @mkdir($subPath, 0777, true);
        }
    }

    // 4. Salin file dari storage/app/public ke public/storage (hanya jika belum ada di destination)
    if (is_dir($storageAppPublic)) {
        $copiedStorage = copyFolderRecursive($storageAppPublic, $publicStorage, false);
        $log .= "✔ Berhasil menyalin $copiedStorage file baru dari storage/app/public ke public/storage\n";
    }

    // 5. Salin file seeder dari public/img/products ke public/storage/products HANYA JIKA BELUM ADA FILE DENGAN NAMA SAMA
    $imgProducts = $laravelRoot . '/public/img/products';
    if (is_dir($imgProducts)) {
        $copiedImg = copyFolderRecursive($imgProducts, $publicStorage . '/products', false);
        $log .= "✔ Berhasil menyalin $copiedImg file seeder ke public/storage/products\n";
    }

    // 6. Set permission public/storage agar writable
    @chmod($publicStorage, 0777);
    @chmod($publicStorage . '/products', 0777);
    @chmod($publicStorage . '/bukti_invoices', 0777);
    $log .= "✔ Berhasil mengatur permission folder public/storage ke 0777\n";

    // 7. Reset OPcache & Cache Laravel
    if (function_exists('opcache_reset')) {
        opcache_reset();
        $log .= "✔ OPcache reset berhasil\n";
    }
    
    // Clear Laravel caches via bootstrap/cache deletion
    $cacheDir = $laravelRoot . '/bootstrap/cache';
    if (is_dir($cacheDir)) {
        $caches = glob($cacheDir . '/*.php');
        foreach ($caches as $cf) {
            @unlink($cf);
        }
        $log .= "✔ File cache Laravel berhasil dibersihkan\n";
    }

    echo "<h3>Log Pengerjaan:</h3>";
    echo "<pre style='background:#f3f4f6;padding:1rem;border-radius:0.5rem;'>" . htmlspecialchars($log) . "</pre>";
    echo "<p style='color:green;font-weight:bold;'>Selesai! Silakan cek kembali gambar produk Anda.</p>";

} catch (Exception $e) {
    echo "<h2 style='color:red;'>Terjadi Kesalahan:</h2>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}
?>
