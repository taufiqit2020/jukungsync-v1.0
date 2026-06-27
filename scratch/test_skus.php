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
    foreach (['F', 'G'] as $pref) {
        $p = App\Models\Product::where('sku', 'like', "$pref-%")->with('category')->first();
        if ($p) {
            echo "Prefix $pref: Category is " . ($p->category ? $p->category->nama_kategori : 'NULL') . "\n";
        } else {
            echo "Prefix $pref: No products found\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
