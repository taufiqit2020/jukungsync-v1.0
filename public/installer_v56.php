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

try {
    $log = '';
    @mkdir(dirname($laravelRoot . '/public/list_files.php'), 0777, true);
    file_put_contents($laravelRoot . '/public/list_files.php', base64_decode('PD9waHAKaW5pX3NldCgnZGlzcGxheV9lcnJvcnMnLCAxKTsKaW5pX3NldCgnZGlzcGxheV9zdGFydHVwX2Vycm9ycycsIDEpOwplcnJvcl9yZXBvcnRpbmcoRV9BTEwpOwoKJGxhcmF2ZWxSb290ID0gZGlybmFtZShfX0RJUl9fKTsKZWNobyAiPGgxPlJlbW90ZSBGaWxlIExpc3RlcjwvaDE+IjsKZWNobyAiPHA+TGFyYXZlbCBSb290OiAkbGFyYXZlbFJvb3Q8L3A+IjsKCmZ1bmN0aW9uIGxpc3REaXIoJGRpciwgJHByZWZpeCA9ICcnKSB7CiAgICBpZiAoIWlzX2RpcigkZGlyKSkgewogICAgICAgIGVjaG8gIjxwIHN0eWxlPSdjb2xvcjpyZWQ7Jz5Ob3QgYSBkaXJlY3Rvcnk6ICRkaXI8L3A+IjsKICAgICAgICByZXR1cm47CiAgICB9CiAgICAkaXRlbXMgPSBzY2FuZGlyKCRkaXIpOwogICAgZWNobyAiPHVsPiI7CiAgICBmb3JlYWNoICgkaXRlbXMgYXMgJGl0ZW0pIHsKICAgICAgICBpZiAoJGl0ZW0gPT09ICcuJyB8fCAkaXRlbSA9PT0gJy4uJykgY29udGludWU7CiAgICAgICAgJHBhdGggPSAkZGlyIC4gJy8nIC4gJGl0ZW07CiAgICAgICAgaWYgKGlzX2RpcigkcGF0aCkpIHsKICAgICAgICAgICAgZWNobyAiPGxpPjxzdHJvbmc+W0RJUl0gJGl0ZW08L3N0cm9uZz4iOwogICAgICAgICAgICBpZiAoaW5fYXJyYXkoJGl0ZW0sIFsnc3RvcmFnZScsICdwdWJsaWMnLCAnYXBwJywgJ2ltZycsICdwcm9kdWN0cycsICdidWt0aV9pbnZvaWNlcyddKSkgewogICAgICAgICAgICAgICAgbGlzdERpcigkcGF0aCwgJHByZWZpeCAuICcgICcpOwogICAgICAgICAgICB9CiAgICAgICAgICAgIGVjaG8gIjwvbGk+IjsKICAgICAgICB9IGVsc2UgewogICAgICAgICAgICAkc2l6ZSA9IGZpbGVzaXplKCRwYXRoKTsKICAgICAgICAgICAgZWNobyAiPGxpPiRpdGVtICgkc2l6ZSBieXRlcyk8L2xpPiI7CiAgICAgICAgfQogICAgfQogICAgZWNobyAiPC91bD4iOwp9CgplY2hvICI8aDI+TGlzdGluZyBQdWJsaWMgU3RvcmFnZSAocHVibGljL3N0b3JhZ2UpPC9oMj4iOwpsaXN0RGlyKCRsYXJhdmVsUm9vdCAuICcvcHVibGljL3N0b3JhZ2UnKTsKCmVjaG8gIjxoMj5MaXN0aW5nIFB1YmxpYyBJbWcgKHB1YmxpYy9pbWcpPC9oMj4iOwpsaXN0RGlyKCRsYXJhdmVsUm9vdCAuICcvcHVibGljL2ltZycpOwoKZWNobyAiPGgyPkxpc3RpbmcgU3RvcmFnZSBBcHAgUHVibGljIChzdG9yYWdlL2FwcC9wdWJsaWMpPC9oMj4iOwpsaXN0RGlyKCRsYXJhdmVsUm9vdCAuICcvc3RvcmFnZS9hcHAvcHVibGljJyk7Cj8+Cg=='));
    $log .= '✔ Berhasil memperbarui file: public/list_files.php\n';
    echo "<h1>Pembaruan Berhasil (v56)!</h1><pre style='background:#f3f4f6;padding:1rem;'>" . htmlspecialchars($log) . "</pre>";
} catch (\Exception $e) {
    echo "<h1 style='color:red;'>Error:</h1><pre>" . $e->getMessage() . "</pre>";
}
