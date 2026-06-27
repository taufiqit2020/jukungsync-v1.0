<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
echo "<h1>Remote File Lister v3</h1>";
echo "<p>Laravel Root: $laravelRoot</p>";

$publicStorage = $laravelRoot . '/public/storage';
echo "<h2>Storage Link Diagnostics</h2>";
echo "Path: $publicStorage<br>";
echo "is_link: " . (is_link($publicStorage) ? "YES" : "NO") . "<br>";
echo "file_exists: " . (file_exists($publicStorage) ? "YES" : "NO") . "<br>";
echo "is_dir: " . (is_dir($publicStorage) ? "YES" : "NO") . "<br>";

$storageAppPublicProducts = $laravelRoot . '/storage/app/public/products';
echo "<h2>Checking storage/app/public/products</h2>";
echo "Path: $storageAppPublicProducts<br>";
echo "is_dir: " . (is_dir($storageAppPublicProducts) ? "YES" : "NO") . "<br>";
if (is_dir($storageAppPublicProducts)) {
    $files = scandir($storageAppPublicProducts);
    echo "File Count: " . count($files) . "<br>";
    echo "Sample files:<br>";
    echo "<ul>";
    $count = 0;
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        echo "<li>$file (" . filesize($storageAppPublicProducts . '/' . $file) . " bytes)</li>";
        $count++;
        if ($count > 10) {
            echo "<li>... and more</li>";
            break;
        }
    }
    echo "</ul>";
}
?>
