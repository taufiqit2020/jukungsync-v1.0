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
    file_put_contents($laravelRoot . '/public/list_files.php', base64_decode('PD9waHAKaW5pX3NldCgnZGlzcGxheV9lcnJvcnMnLCAxKTsKaW5pX3NldCgnZGlzcGxheV9zdGFydHVwX2Vycm9ycycsIDEpOwplcnJvcl9yZXBvcnRpbmcoRV9BTEwpOwoKJGxhcmF2ZWxSb290ID0gZGlybmFtZShfX0RJUl9fKTsKZWNobyAiPGgxPlJlbW90ZSBGaWxlIExpc3RlciB2NDwvaDE+IjsKZWNobyAiPHA+TGFyYXZlbCBSb290OiAkbGFyYXZlbFJvb3Q8L3A+IjsKCiRwdWJsaWNTdG9yYWdlID0gJGxhcmF2ZWxSb290IC4gJy9wdWJsaWMvc3RvcmFnZSc7CmVjaG8gIjxoMj5TdG9yYWdlIExpbmsgRGlhZ25vc3RpY3M8L2gyPiI7CmVjaG8gIlBhdGg6ICRwdWJsaWNTdG9yYWdlPGJyPiI7CmVjaG8gImlzX2xpbms6ICIgLiAoaXNfbGluaygkcHVibGljU3RvcmFnZSkgPyAiWUVTIiA6ICJOTyIpIC4gIjxicj4iOwplY2hvICJmaWxlX2V4aXN0czogIiAuIChmaWxlX2V4aXN0cygkcHVibGljU3RvcmFnZSkgPyAiWUVTIiA6ICJOTyIpIC4gIjxicj4iOwplY2hvICJpc19kaXI6ICIgLiAoaXNfZGlyKCRwdWJsaWNTdG9yYWdlKSA/ICJZRVMiIDogIk5PIikgLiAiPGJyPiI7Cgokc3RvcmFnZUFwcFB1YmxpYyA9ICRsYXJhdmVsUm9vdCAuICcvc3RvcmFnZS9hcHAvcHVibGljJzsKZWNobyAiPGgyPkNoZWNraW5nIHN0b3JhZ2UvYXBwL3B1YmxpYzwvaDI+IjsKZWNobyAiUGF0aDogJHN0b3JhZ2VBcHBQdWJsaWM8YnI+IjsKZWNobyAiaXNfZGlyOiAiIC4gKGlzX2Rpcigkc3RvcmFnZUFwcFB1YmxpYykgPyAiWUVTIiA6ICJOTyIpIC4gIjxicj4iOwoKaWYgKGlzX2Rpcigkc3RvcmFnZUFwcFB1YmxpYykpIHsKICAgICRpdGVtcyA9IHNjYW5kaXIoJHN0b3JhZ2VBcHBQdWJsaWMpOwogICAgZWNobyAiSXRlbXMgaW4gc3RvcmFnZS9hcHAvcHVibGljOjxicj48dWw+IjsKICAgIGZvcmVhY2ggKCRpdGVtcyBhcyAkaXRlbSkgewogICAgICAgIGlmICgkaXRlbSA9PT0gJy4nIHx8ICRpdGVtID09PSAnLi4nKSBjb250aW51ZTsKICAgICAgICAkcGF0aCA9ICRzdG9yYWdlQXBwUHVibGljIC4gJy8nIC4gJGl0ZW07CiAgICAgICAgJHR5cGUgPSBpc19kaXIoJHBhdGgpID8gIltESVJdIiA6ICJbRklMRV0iOwogICAgICAgIGVjaG8gIjxsaT4kdHlwZSAkaXRlbTwvbGk+IjsKICAgIH0KICAgIGVjaG8gIjwvdWw+IjsKfSBlbHNlIHsKICAgIGVjaG8gIjxwIHN0eWxlPSdjb2xvcjpyZWQ7Jz5zdG9yYWdlL2FwcC9wdWJsaWMgaXMgbm90IGEgZGlyZWN0b3J5ITwvcD4iOwp9Cj8+Cg=='));
    $log .= '✔ Berhasil memperbarui file: public/list_files.php\n';
    echo "<h1>Pembaruan Berhasil (v56)!</h1><pre style='background:#f3f4f6;padding:1rem;'>" . htmlspecialchars($log) . "</pre>";
} catch (\Exception $e) {
    echo "<h1 style='color:red;'>Error:</h1><pre>" . $e->getMessage() . "</pre>";
}
