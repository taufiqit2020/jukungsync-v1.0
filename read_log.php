<?php
function findLaravelRoot($dir, $depth = 0) {
    if ($depth > 3) return null;
    if (!is_dir($dir)) return null;
    if (file_exists($dir . '/artisan') && file_exists($dir . '/bootstrap/app.php')) return $dir;
    $items = @scandir($dir);
    if (!$items) return null;
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') continue;
        $path = $dir . '/' . $item;
        if (is_dir($path)) {
            $found = findLaravelRoot($path, $depth + 1);
            if ($found) return $found;
        }
    }
    return null;
}
$laravelRoot = findLaravelRoot(__DIR__);
if (!$laravelRoot) $laravelRoot = __DIR__;

$logFile = $laravelRoot . '/storage/logs/laravel.log';
if (file_exists($logFile)) {
    // Read the last 50 lines
    $lines = file($logFile);
    $lastLines = array_slice($lines, -50);
    $logContent = implode("", $lastLines);
    echo "<pre>" . htmlspecialchars($logContent) . "</pre>";
} else {
    echo "No log file found at " . $logFile;
}
