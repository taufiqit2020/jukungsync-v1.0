<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
require $laravelRoot . '/vendor/autoload.php';
$app = require_once $laravelRoot . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\File;

$path = 'products/at81mY6RQdBvGr4RYSyp0Bp3GT52wOEhFPLoX12u.jpg';
$filePath = storage_path('app/public/' . $path);
$fallbackPath = public_path('img/' . $path);
$generalDefault = public_path('img/products/umum.png');

echo "<h1>Testing serve logic</h1>";
echo "File path: $filePath | exists: " . (File::exists($filePath) ? "YES" : "NO") . "<br>";
echo "Fallback path: $fallbackPath | exists: " . (File::exists($fallbackPath) ? "YES" : "NO") . "<br>";
echo "General default: $generalDefault | exists: " . (File::exists($generalDefault) ? "YES" : "NO") . "<br>";

try {
    $controller = new \App\Http\Controllers\StorageController();
    $response = $controller->serve($path);
    echo "Controller serve succeeded! Response class: " . get_class($response) . "<br>";
} catch (Exception $e) {
    echo "Controller serve failed: " . $e->getMessage() . "<br>";
}
?>
