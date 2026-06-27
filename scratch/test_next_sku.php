<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

config(['database.default' => 'sqlite']);
config(['database.connections.sqlite' => [
    'driver' => 'sqlite',
    'database' => __DIR__ . '/../database/database.sqlite',
    'prefix' => '',
]]);

use App\Models\Category;
use App\Models\Product;

function getNextSkuSimulated($category) {
    // Tentukan prefix berdasarkan kategori secara ketat (strict mapping)
    $name = strtolower($category->nama_kategori);
    if (str_contains($name, 'atk')) {
        $prefix = 'A';
    } elseif (str_contains($name, 'kebersihan')) {
        $prefix = 'B';
    } elseif (str_contains($name, 'ibu') || str_contains($name, 'bayi')) {
        $prefix = 'C';
    } elseif (str_contains($name, 'ipsrs')) {
        $prefix = 'D';
    } elseif (str_contains($name, 'lainnya')) {
        $prefix = 'E';
    } elseif (str_contains($name, 'plastik')) {
        $prefix = 'P';
    } else {
        // Gunakan huruf pertama nama kategori jika tidak cocok
        $prefix = strtoupper(substr($category->nama_kategori, 0, 1));
        if (!$prefix || !preg_match('/[A-Z]/', $prefix)) {
            $prefix = 'BRG';
        }
    }

    $skus = Product::where('sku', 'like', $prefix . '%')
        ->pluck('sku')
        ->toArray();

    $maxNum = 0;
    foreach ($skus as $sku) {
        if (preg_match('/^' . preg_quote($prefix, '/') . '-?([0-9]+)$/i', $sku, $matches)) {
            $num = (int)$matches[1];
            if ($num > $maxNum) {
                $maxNum = $num;
            }
        }
    }

    $nextNum = $maxNum + 1;
    return $prefix . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);
}

try {
    $categories = Category::all();
    foreach ($categories as $cat) {
        $nextSku = getNextSkuSimulated($cat);
        echo "Category: {$cat->nama_kategori} -> Next SKU: {$nextSku}\n";
    }

    // Test a virtual 'Lainnya' category as well
    $virtualLainnya = new Category(['nama_kategori' => 'Lainnya']);
    $nextSkuLainnya = getNextSkuSimulated($virtualLainnya);
    echo "Category: Lainnya -> Next SKU: {$nextSkuLainnya}\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
