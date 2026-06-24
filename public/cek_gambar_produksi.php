<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\Storage;

echo "<h1>Diagnostik Gambar Produksi</h1>";

try {
    $products = Product::limit(45)->get();
    echo "<table border='1' cellpadding='5' style='border-collapse:collapse;font-family:sans-serif;font-size:12px;'>";
    echo "<tr style='background:#eee;'><th>SKU</th><th>Nama Barang</th><th>DB Gambar</th><th>Storage URL</th><th>Physical Path</th><th>Exists?</th><th>Alternate (public/img/products) Exists?</th></tr>";
    
    foreach ($products as $p) {
        $dbGambar = $p->gambar;
        $url = Storage::url($dbGambar);
        $physicalPath = public_path('storage/' . $dbGambar);
        $exists = file_exists($physicalPath) ? "✔ YES" : "❌ NO";
        
        // Cek jika ada di public/img/products
        $altFilename = basename($dbGambar);
        $altPath = public_path('img/products/' . $altFilename);
        $altExists = file_exists($altPath) ? "✔ YES" : "❌ NO";
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($p->sku) . "</td>";
        echo "<td>" . htmlspecialchars($p->nama_barang) . "</td>";
        echo "<td>" . htmlspecialchars($dbGambar) . "</td>";
        echo "<td>" . htmlspecialchars($url) . "</td>";
        echo "<td style='font-family:monospace;'>" . htmlspecialchars($physicalPath) . "</td>";
        echo "<td style='font-weight:bold;color:" . ($exists === "✔ YES" ? "green" : "red") . "'>" . $exists . "</td>";
        echo "<td style='font-weight:bold;color:" . ($altExists === "✔ YES" ? "green" : "red") . "'>" . $altExists . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
