<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
echo "<h1>Remote File Lister v2</h1>";
echo "<p>Laravel Root: $laravelRoot</p>";

$publicStorage = $laravelRoot . '/public/storage';
echo "<h2>Storage Link Diagnostics</h2>";
echo "Path: $publicStorage<br>";
echo "is_link: " . (is_link($publicStorage) ? "YES" : "NO") . "<br>";
if (is_link($publicStorage)) {
    echo "readlink target: " . readlink($publicStorage) . "<br>";
}
echo "file_exists: " . (file_exists($publicStorage) ? "YES" : "NO") . "<br>";
echo "is_dir: " . (is_dir($publicStorage) ? "YES" : "NO") . "<br>";

function listDir($dir) {
    if (!is_dir($dir)) {
        echo "<p style='color:red;'>Not a directory or broken symlink: $dir</p>";
        return;
    }
    $items = scandir($dir);
    echo "<ul>";
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            echo "<li><strong>[DIR] $item</strong>";
            if (in_array($item, ['storage', 'public', 'app', 'img', 'products', 'bukti_invoices'])) {
                listDir($path);
            }
            echo "</li>";
        } else {
            $size = filesize($path);
            echo "<li>$item ($size bytes)</li>";
        }
    }
    echo "</ul>";
}

echo "<h2>Listing Public Storage Contents</h2>";
listDir($publicStorage);

echo "<h2>Listing Public Img Contents</h2>";
listDir($laravelRoot . '/public/img');

echo "<h2>Listing Storage App Public</h2>";
listDir($laravelRoot . '/storage/app/public');
?>
