<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Jalankan migrasi database agar kolom baru tersedia sebelum model Product diakses
try {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
} catch (\Exception $e) {
    echo "<p style='color:red;'>❌ Gagal menjalankan migrasi database: " . htmlspecialchars($e->getMessage()) . "</p>";
}

use App\Models\Product;
use Illuminate\Support\Facades\File;

echo "<h1>Restore Missing Images v59</h1>";

try {
    $products = Product::with('category')->get();
    $log = '';
    $restoreCount = 0;

    $publicStorage = public_path('storage');
    // Pastikan folder storage & products ada
    if (!is_dir($publicStorage)) {
        @mkdir($publicStorage, 0777, true);
    }
    if (!is_dir($publicStorage . '/products')) {
        @mkdir($publicStorage . '/products', 0777, true);
    }

    // Sinkronkan SEMUA file mentah yang diupload user via File Manager/dashboard dari storage/app/public/products ke public/storage/products
    $appPublicProd = storage_path('app/public/products');
    $pubProd = public_path('storage/products');
    if (is_dir($appPublicProd)) {
        @mkdir($pubProd, 0777, true);
        $rawFiles = array_diff(scandir($appPublicProd), array('.', '..'));
        foreach ($rawFiles as $rf) {
            $srcF = $appPublicProd . '/' . $rf;
            $dstF = $pubProd . '/' . $rf;
            if (is_file($srcF)) {
                if (@copy($srcF, $dstF)) {
                    $log .= "✔ Sync File Manager upload: $rf ke public/storage/products/\n";
                }
            }
        }
    }

    foreach ($products as $p) {
        $allImgs = $p->all_images;
        foreach ($allImgs as $imgItem) {
            if (empty($imgItem)) continue;
            $appPath = storage_path('app/public/' . $imgItem);
            $pubPath = public_path('storage/' . $imgItem);
            if (file_exists($appPath)) {
                @mkdir(dirname($pubPath), 0777, true);
                if (@copy($appPath, $pubPath)) {
                    $log .= "✔ Restored user upload: SKU {$p->sku} ({$p->nama_barang}) -> copied $imgItem to public/storage/\n";
                    $restoreCount++;
                }
            }
        }

        $dbGambar = $p->gambar;
        if (empty($dbGambar)) {
            // Jika kosong, set ke default umum
            $p->gambar = 'products/umum.png';
            $p->save();
            $dbGambar = $p->gambar;
        }

        // Path fisik di public/storage/ dan storage/app/public/
        $physicalPath = public_path('storage/' . $dbGambar);
        $appPublicPath = storage_path('app/public/' . $dbGambar);

        // Jika file asli dari user ada di storage/app/public, pastikan disalin ke public/storage
        if (file_exists($appPublicPath)) {
            @mkdir(dirname($physicalPath), 0777, true);
            @copy($appPublicPath, $physicalPath);
            continue;
        }

        // Jika file tidak ada sama sekali di kedua lokasi, baru gunakan default placeholder
        if (!file_exists($physicalPath)) {
            $catName = $p->category ? strtolower($p->category->nama_kategori) : '';
            $prodName = strtolower($p->nama_barang);

            // Tentukan default image berdasarkan kategori & nama barang
            $defaultFile = 'umum.png';

            if (str_contains($catName, 'atk')) {
                if (str_contains($prodName, 'kertas') || str_contains($prodName, 'paper')) {
                    $defaultFile = 'kertas.png';
                } elseif (str_contains($prodName, 'pulpen') || str_contains($prodName, 'spidol') || str_contains($prodName, 'marker')) {
                    $defaultFile = 'pulpen.png';
                } elseif (str_contains($prodName, 'lakban') || str_contains($prodName, 'isolasi') || str_contains($prodName, 'tape') || str_contains($prodName, 'lem')) {
                    $defaultFile = 'lakban.png';
                } elseif (str_contains($prodName, 'tinta')) {
                    $defaultFile = 'tinta.png';
                } else {
                    $defaultFile = 'umum.png';
                }
            } elseif (str_contains($catName, 'kebersihan')) {
                if (str_contains($prodName, 'pewangi') || str_contains($prodName, 'pengharum') || str_contains($prodName, 'parfum') || str_contains($prodName, 'stella') || str_contains($prodName, 'glade')) {
                    $defaultFile = 'pengharum.png';
                } elseif (str_contains($prodName, 'spray') || str_contains($prodName, 'baygon') || str_contains($prodName, 'hit')) {
                    $defaultFile = 'spray.png';
                } else {
                    $defaultFile = 'sabun.png';
                }
            } elseif (str_contains($catName, 'ibu') || str_contains($catName, 'bayi')) {
                if (str_contains($prodName, 'popok') || str_contains($prodName, 'pembalut') || str_contains($prodName, 'softex')) {
                    $defaultFile = 'popok.png';
                } elseif (str_contains($prodName, 'minyak') || str_contains($prodName, 'telon')) {
                    $defaultFile = 'minyak.png';
                } elseif (str_contains($prodName, 'pakaian') || str_contains($prodName, 'sarung') || str_contains($prodName, 'korset')) {
                    $defaultFile = 'pakaian.png';
                } else {
                    $defaultFile = 'perawatan.png';
                }
            }

            // Path asal di public/img/products/
            $srcPath = public_path('img/products/' . $defaultFile);

            if (file_exists($srcPath)) {
                // Buat folder parent jika belum ada
                @mkdir(dirname($physicalPath), 0777, true);
                if (@copy($srcPath, $physicalPath)) {
                    $log .= "✔ Restored: SKU {$p->sku} ({$p->nama_barang}) -> copied $defaultFile to public/storage/$dbGambar\n";
                    $restoreCount++;
                } else {
                    $log .= "❌ Failed copy: SKU {$p->sku} -> $defaultFile to public/storage/$dbGambar\n";
                }
            } else {
                $log .= "⚠ Default source image missing: $srcPath\n";
            }
        }
    }

    echo "<h3>Log Pemulihan Gambar:</h3>";
    echo "<pre style='background:#f3f4f6;padding:1rem;border-radius:0.5rem;font-size:12px;line-height:1.5;'>" . htmlspecialchars($log) . "</pre>";
    echo "<p style='color:green;font-weight:bold;'>Berhasil memulihkan $restoreCount gambar produk!</p>";

} catch (Exception $e) {
    echo "<h2 style='color:red;'>Error:</h2><pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}
?>
