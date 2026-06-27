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

// Helper function to copy folders recursively
function copyFolderRecursive($src, $dst) {
    if (!is_dir($src)) return 0;
    @mkdir($dst, 0777, true);
    $count = 0;
    $files = array_diff(scandir($src), array('.','..'));
    foreach ($files as $file) {
        if (is_dir("$src/$file")) {
            $count += copyFolderRecursive("$src/$file", "$dst/$file");
        } else {
            if (@copy("$src/$file", "$dst/$file")) {
                $count++;
            }
        }
    }
    return $count;
}

try {
    // 1. Bersihkan link/file lama di public/storage
    if (is_link($publicStorage)) {
        if (@unlink($publicStorage)) {
            $log .= "✔ Berhasil menghapus symbolic link lama: $publicStorage\n";
        } else {
            $log .= "❌ Gagal menghapus symbolic link lama: $publicStorage\n";
        }
    } elseif (file_exists($publicStorage) && !is_dir($publicStorage)) {
        if (@unlink($publicStorage)) {
            $log .= "✔ Berhasil menghapus file lama di public/storage: $publicStorage\n";
        }
    }

    // 2. Buat direktori fisik public/storage
    if (!is_dir($publicStorage)) {
        if (@mkdir($publicStorage, 0777, true)) {
            $log .= "✔ Berhasil membuat direktori fisik public/storage\n";
        } else {
            $log .= "❌ Gagal membuat direktori fisik public/storage\n";
        }
    } else {
        $log .= "✔ Direktori fisik public/storage sudah ada\n";
    }

    // 3. Buat subdirektori products & bukti_invoices
    $subDirs = ['products', 'bukti_invoices'];
    foreach ($subDirs as $sub) {
        $subPath = $publicStorage . '/' . $sub;
        if (!is_dir($subPath)) {
            if (@mkdir($subPath, 0777, true)) {
                $log .= "✔ Berhasil membuat subdirektori: public/storage/$sub\n";
            }
        }
    }

    // 4. Salin file dari storage/app/public (jika ada) ke public/storage
    if (is_dir($storageAppPublic)) {
        $copiedStorage = copyFolderRecursive($storageAppPublic, $publicStorage);
        $log .= "✔ Berhasil menyalin $copiedStorage file dari storage/app/public ke public/storage\n";
    } else {
        $log .= "ℹ storage/app/public tidak ditemukan atau bukan direktori\n";
    }

    // 5. Salin file dari public/img/products ke public/storage/products (untuk seeder images)
    $imgProducts = $laravelRoot . '/public/img/products';
    if (is_dir($imgProducts)) {
        $copiedImg = copyFolderRecursive($imgProducts, $publicStorage . '/products');
        $log .= "✔ Berhasil menyalin $copiedImg file seeder dari public/img/products ke public/storage/products\n";
    } else {
        $log .= "ℹ public/img/products tidak ditemukan atau bukan direktori\n";
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
