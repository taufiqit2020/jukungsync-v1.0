<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function findLaravelRoot($dir, $depth = 0) {
    if ($depth > 3) return null;
    if (!is_dir($dir)) return null;
    if (file_exists($dir . '/artisan') && file_exists($dir . '/bootstrap/app.php')) return $dir;
    $items = @scandir($dir);
    if (!$items) return null;
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) { $found = findLaravelRoot($path, $depth + 1); if ($found) return $found; }
    }
    return null;
}

$laravelRoot = findLaravelRoot(dirname(__DIR__));
if (!$laravelRoot) $laravelRoot = __DIR__;

$logPath = $laravelRoot . '/storage/logs/laravel.log';

echo "<h1>Laravel Log Reader</h1>";
echo "Log Path: $logPath<br>";

if (!file_exists($logPath)) {
    echo "❌ Log file does not exist.<br>";
    exit;
}

$lines = file($logPath);
$lastLines = array_slice($lines, -100);

echo "<pre>";
foreach ($lastLines as $line) {
    echo htmlspecialchars($line);
}
echo "</pre>";
?>
