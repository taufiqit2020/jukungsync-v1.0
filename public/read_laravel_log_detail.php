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

echo "<html><head><title>Detailed Laravel Log Reader</title>";
echo "<style>
    body { font-family: monospace; background-color: #1e1e1e; color: #d4d4d4; padding: 20px; }
    h1 { color: #569cd6; border-bottom: 1px solid #3c3c3c; padding-bottom: 10px; }
    .error-block { background-color: #252526; border-left: 5px solid #f44336; padding: 15px; margin-bottom: 20px; border-radius: 4px; overflow-x: auto; }
    .error-header { color: #f44336; font-weight: bold; font-size: 1.1em; margin-bottom: 10px; }
    pre { margin: 0; white-space: pre-wrap; word-break: break-all; }
</style></head><body>";

echo "<h1>Detailed Laravel Log Reader</h1>";
echo "Log Path: <code>$logPath</code><br><br>";

if (!file_exists($logPath)) {
    echo "<p style='color: #f44336;'>❌ Log file does not exist.</p>";
    exit;
}

$content = file_get_contents($logPath);
// Laravel log entries start with [YYYY-MM-DD HH:MM:SS]
preg_match_all('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]/m', $content, $matches, PREG_OFFSET_CAPTURE);

if (empty($matches[0])) {
    echo "<p>No standard log entries found. Raw content of last 2000 characters:</p>";
    echo "<pre>" . htmlspecialchars(substr($content, -2000)) . "</pre>";
    exit;
}

$entries = [];
$matchCount = count($matches[0]);
for ($i = 0; $i < $matchCount; $i++) {
    $start = $matches[0][$i][1];
    $end = ($i === $matchCount - 1) ? strlen($content) : $matches[0][$i+1][1];
    $entries[] = substr($content, $start, $end - $start);
}

// Show last 5 errors
$recentEntries = array_slice(array_reverse($entries), 0, 5);

foreach ($recentEntries as $idx => $entry) {
    $lines = explode("\n", trim($entry));
    $header = array_shift($lines);
    echo "<div class='error-block'>";
    echo "<div class='error-header'>" . htmlspecialchars($header) . "</div>";
    echo "<pre>" . htmlspecialchars(implode("\n", $lines)) . "</pre>";
    echo "</div>";
}

?>
