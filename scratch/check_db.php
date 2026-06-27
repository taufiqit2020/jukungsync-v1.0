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

try {
    echo "=== CATEGORIES ===\n";
    $categories = App\Models\Category::all();
    foreach ($categories as $cat) {
        $pCount = App\Models\Product::where('category_id', $cat->id)->count();
        $sampleProduct = App\Models\Product::where('category_id', $cat->id)->first();
        $sampleSku = $sampleProduct ? $sampleProduct->sku : 'N/A';
        echo "ID: {$cat->id} | Name: {$cat->nama_kategori} | Products: {$pCount} | Sample SKU: {$sampleSku}\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
