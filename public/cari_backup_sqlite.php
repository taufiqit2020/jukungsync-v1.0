<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);

echo "<h1>Scanning Hostinger Directory for SQLite Files</h1>";

function scanDirRecursive($dir, &$results = []) {
    $items = @scandir($dir);
    if (!$items) return;
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            // Skip vendor and node_modules
            if ($item === 'vendor' || $item === 'node_modules' || $item === '.git') continue;
            scanDirRecursive($path, $results);
        } else {
            // Check if file contains sqlite in name
            if (strpos(strtolower($item), 'sqlite') !== false || strpos(strtolower($item), '.db') !== false) {
                $results[] = [
                    'path' => $path,
                    'size' => filesize($path),
                    'mtime' => filemtime($path)
                ];
            }
        }
    }
}

$files = [];
scanDirRecursive($laravelRoot, $files);
// Also scan one level up, just in case
scanDirRecursive(dirname($laravelRoot), $files);

echo "<table border='1' cellpadding='10' style='border-collapse: collapse; font-family: monospace;'>";
echo "<tr><th>Path</th><th>Size (Bytes)</th><th>Last Modified</th></tr>";
foreach ($files as $file) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($file['path']) . "</td>";
    echo "<td>" . $file['size'] . "</td>";
    echo "<td>" . date('Y-m-d H:i:s', $file['mtime']) . "</td>";
    echo "</tr>";
}
echo "</table>";

?>
