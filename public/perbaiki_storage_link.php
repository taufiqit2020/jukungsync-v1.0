<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
$publicStoragePath = __DIR__ . '/storage';
$targetStoragePath = $laravelRoot . '/storage/app/public';

echo "<h1>Perbaikan Storage Symlink Laravel</h1>";
echo "Laravel Root: " . htmlspecialchars($laravelRoot) . "<br>";
echo "Public Storage Path: " . htmlspecialchars($publicStoragePath) . "<br>";
echo "Target Storage Path: " . htmlspecialchars($targetStoragePath) . "<br><br>";

// 1. Periksa target directory
if (!is_dir($targetStoragePath)) {
    echo "Membuat direktori target...<br>";
    if (@mkdir($targetStoragePath, 0777, true)) {
        echo "✔ Direktori target berhasil dibuat.<br>";
    } else {
        echo "❌ Gagal membuat direktori target!<br>";
    }
} else {
    echo "✔ Direktori target ada.<br>";
}

// 2. Periksa apakah public/storage sudah ada
$linkValid = false;
if (file_exists($publicStoragePath) || is_link($publicStoragePath)) {
    echo "Public storage link/folder sudah ada.<br>";
    
    // Periksa apakah itu symlink
    if (is_link($publicStoragePath)) {
        $linkTarget = @readlink($publicStoragePath);
        echo "Tipe: Symbolic Link<br>";
        echo "Menunjuk ke: " . htmlspecialchars($linkTarget) . "<br>";
        
        // Cek apakah link target valid
        if (realpath($publicStoragePath) === realpath($targetStoragePath)) {
            echo "✔ Symbolic link sudah benar dan valid!<br>";
            $linkValid = true;
        } else {
            echo "⚠ Symbolic link menunjuk ke tempat yang salah, menghapus link lama...<br>";
            if (@unlink($publicStoragePath)) {
                echo "✔ Link lama berhasil dihapus.<br>";
                $linkValid = false;
            } else {
                echo "❌ Gagal menghapus link lama!<br>";
                $linkValid = true; // prevent recreation if unlink fails
            }
        }
    } else {
        echo "Tipe: Direktori Biasa (Bukan Symlink)<br>";
        echo "⚠ Menghapus direktori biasa agar bisa digantikan oleh symlink...<br>";
        
        // Recursive helper to delete folder
        function deleteDir($dirPath) {
            if (!is_dir($dirPath)) return false;
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    deleteDir($file);
                } else {
                    @unlink($file);
                }
            }
            return @rmdir($dirPath);
        }
        
        if (deleteDir($publicStoragePath)) {
            echo "✔ Direktori biasa berhasil dihapus.<br>";
            $linkValid = false;
        } else {
            echo "❌ Gagal menghapus direktori biasa!<br>";
            $linkValid = true;
        }
    }
} else {
    echo "Public storage link belum ada.<br>";
    $linkValid = false;
}

// 3. Buat symlink baru jika tidak valid / belum ada
if (!$linkValid) {
    echo "Membuat symbolic link baru...<br>";
    if (@symlink($targetStoragePath, $publicStoragePath)) {
        echo "✔ Symbolic link baru berhasil dibuat!<br>";
    } else {
        echo "❌ Gagal menggunakan symlink(). Mencoba metode copy/artisan...<br>";
        // Alternatif: Jalankan command artisan
        try {
            if (file_exists($laravelRoot . '/vendor/autoload.php')) {
                require $laravelRoot . '/vendor/autoload.php';
                $app = require_once $laravelRoot . '/bootstrap/app.php';
                $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
                \Illuminate\Support\Facades\Artisan::call('storage:link');
                echo "✔ Storage link dibuat via Artisan: " . htmlspecialchars(\Illuminate\Support\Facades\Artisan::output()) . "<br>";
            }
        } catch (Throwable $e) {
            echo "❌ Gagal via Artisan: " . $e->getMessage() . "<br>";
        }
    }
}

// 4. Verifikasi akhir
if (file_exists($publicStoragePath) && is_link($publicStoragePath)) {
    echo "<br><h3 style='color:green;'>✔ SELESAI: Link storage berhasil diperbaiki dan valid!</h3>";
} else {
    echo "<br><h3 style='color:red;'>❌ GAGAL: Link storage tetap tidak valid. Hubungi admin.</h3>";
}
?>
