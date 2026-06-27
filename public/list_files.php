<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
echo "<h1>Remote File Lister v4</h1>";
echo "<p>Laravel Root: $laravelRoot</p>";

$publicStorage = $laravelRoot . '/public/storage';
echo "<h2>Storage Link Diagnostics</h2>";
echo "Path: $publicStorage<br>";
echo "is_link: " . (is_link($publicStorage) ? "YES" : "NO") . "<br>";
echo "file_exists: " . (file_exists($publicStorage) ? "YES" : "NO") . "<br>";
echo "is_dir: " . (is_dir($publicStorage) ? "YES" : "NO") . "<br>";

$storageAppPublic = $laravelRoot . '/storage/app/public';
echo "<h2>Checking storage/app/public</h2>";
echo "Path: $storageAppPublic<br>";
echo "is_dir: " . (is_dir($storageAppPublic) ? "YES" : "NO") . "<br>";

if (is_dir($storageAppPublic)) {
    $items = scandir($storageAppPublic);
    echo "Items in storage/app/public:<br><ul>";
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $storageAppPublic . '/' . $item;
        $type = is_dir($path) ? "[DIR]" : "[FILE]";
        echo "<li>$type $item</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color:red;'>storage/app/public is not a directory!</p>";
}
?>
