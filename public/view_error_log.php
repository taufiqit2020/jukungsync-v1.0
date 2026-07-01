<?php
$logFile = __DIR__ . '/../storage/logs/laravel.log';
if (file_exists($logFile)) {
    $lines = file($logFile);
    $lastLines = array_slice($lines, -100);
    echo "<h1>Laravel Log (Last 100 lines)</h1><pre>";
    echo htmlspecialchars(implode("", $lastLines));
    echo "</pre>";
} else {
    echo "Log file not found.";
}
