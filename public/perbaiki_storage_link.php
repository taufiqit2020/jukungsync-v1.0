<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
$publicStoragePath = __DIR__ . '/storage';
$targetStoragePath = $laravelRoot . '/storage/app/public';

echo "<h1>Perbaikan Media Storage JukungSync (Tanpa Symlink)</h1>";
echo "Laravel Root: " . htmlspecialchars($laravelRoot) . "<br>";
echo "Public Storage Path: " . htmlspecialchars($publicStoragePath) . "<br>";
echo "Target Storage Path: " . htmlspecialchars($targetStoragePath) . "<br><br>";

// 1. Jika public/storage adalah symlink (baik aktif maupun broken), hapus
if (is_link($publicStoragePath)) {
    echo "Menghapus symbolic link lama yang bermasalah...<br>";
    if (@unlink($publicStoragePath)) {
        echo "✔ Symbolic link berhasil dihapus.<br>";
    } else {
        echo "❌ Gagal menghapus symbolic link!<br>";
    }
}

// 2. Buat direktori fisik public/storage jika belum ada
if (!is_dir($publicStoragePath)) {
    echo "Membuat direktori fisik public/storage...<br>";
    if (@mkdir($publicStoragePath, 0777, true)) {
        echo "✔ Direktori fisik public/storage berhasil dibuat.<br>";
    } else {
        echo "❌ Gagal membuat direktori fisik public/storage!<br>";
    }
} else {
    echo "✔ Direktori fisik public/storage sudah ada.<br>";
}

// 3. Buat subfolder yang dibutuhkan
$subfolders = ['products', 'bukti_invoices'];
foreach ($subfolders as $sub) {
    $subPath = $publicStoragePath . '/' . $sub;
    if (!is_dir($subPath)) {
        if (@mkdir($subPath, 0777, true)) {
            echo "✔ Subfolder '$sub' berhasil dibuat.<br>";
        } else {
            echo "❌ Gagal membuat subfolder '$sub'!<br>";
        }
    }
}

// 4. Salin file dari storage/app/public ke public/storage secara rekursif
function copyFolder($src, $dst) {
    if (!is_dir($src)) return;
    @mkdir($dst, 0777, true);
    $files = array_diff(scandir($src), array('.','..'));
    foreach ($files as $file) {
        if (is_dir("$src/$file")) {
            copyFolder("$src/$file", "$dst/$file");
        } else {
            if (@copy("$src/$file", "$dst/$file")) {
                echo "✔ Menyalin: " . htmlspecialchars("$file") . " ke public/storage<br>";
            } else {
                echo "❌ Gagal menyalin: " . htmlspecialchars("$file") . "<br>";
            }
        }
    }
}

echo "<br><b>Menyalin file aset lama...</b><br>";
copyFolder($targetStoragePath, $publicStoragePath);

echo "<br><h3 style='color:green;'>✔ SELESAI: Penyimpanan fisik media berhasil disiapkan tanpa kendala symlink!</h3>";
?>
