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
    file_put_contents($laravelRoot . '/public/list_files.php', base64_decode('PD9waHAKaW5pX3NldCgnZGlzcGxheV9lcnJvcnMnLCAxKTsKaW5pX3NldCgnZGlzcGxheV9zdGFydHVwX2Vycm9ycycsIDEpOwplcnJvcl9yZXBvcnRpbmcoRV9BTEwpOwoKJGxhcmF2ZWxSb290ID0gZGlybmFtZShfX0RJUl9fKTsKZWNobyAiPGgxPlJlbW90ZSBGaWxlIExpc3RlciB2MzwvaDE+IjsKZWNobyAiPHA+TGFyYXZlbCBSb290OiAkbGFyYXZlbFJvb3Q8L3A+IjsKCiRwdWJsaWNTdG9yYWdlID0gJGxhcmF2ZWxSb290IC4gJy9wdWJsaWMvc3RvcmFnZSc7CmVjaG8gIjxoMj5TdG9yYWdlIExpbmsgRGlhZ25vc3RpY3M8L2gyPiI7CmVjaG8gIlBhdGg6ICRwdWJsaWNTdG9yYWdlPGJyPiI7CmVjaG8gImlzX2xpbms6ICIgLiAoaXNfbGluaygkcHVibGljU3RvcmFnZSkgPyAiWUVTIiA6ICJOTyIpIC4gIjxicj4iOwplY2hvICJmaWxlX2V4aXN0czogIiAuIChmaWxlX2V4aXN0cygkcHVibGljU3RvcmFnZSkgPyAiWUVTIiA6ICJOTyIpIC4gIjxicj4iOwplY2hvICJpc19kaXI6ICIgLiAoaXNfZGlyKCRwdWJsaWNTdG9yYWdlKSA/ICJZRVMiIDogIk5PIikgLiAiPGJyPiI7Cgokc3RvcmFnZUFwcFB1YmxpY1Byb2R1Y3RzID0gJGxhcmF2ZWxSb290IC4gJy9zdG9yYWdlL2FwcC9wdWJsaWMvcHJvZHVjdHMnOwplY2hvICI8aDI+Q2hlY2tpbmcgc3RvcmFnZS9hcHAvcHVibGljL3Byb2R1Y3RzPC9oMj4iOwplY2hvICJQYXRoOiAkc3RvcmFnZUFwcFB1YmxpY1Byb2R1Y3RzPGJyPiI7CmVjaG8gImlzX2RpcjogIiAuIChpc19kaXIoJHN0b3JhZ2VBcHBQdWJsaWNQcm9kdWN0cykgPyAiWUVTIiA6ICJOTyIpIC4gIjxicj4iOwppZiAoaXNfZGlyKCRzdG9yYWdlQXBwUHVibGljUHJvZHVjdHMpKSB7CiAgICAkZmlsZXMgPSBzY2FuZGlyKCRzdG9yYWdlQXBwUHVibGljUHJvZHVjdHMpOwogICAgZWNobyAiRmlsZSBDb3VudDogIiAuIGNvdW50KCRmaWxlcykgLiAiPGJyPiI7CiAgICBlY2hvICJTYW1wbGUgZmlsZXM6PGJyPiI7CiAgICBlY2hvICI8dWw+IjsKICAgICRjb3VudCA9IDA7CiAgICBmb3JlYWNoICgkZmlsZXMgYXMgJGZpbGUpIHsKICAgICAgICBpZiAoJGZpbGUgPT09ICcuJyB8fCAkZmlsZSA9PT0gJy4uJykgY29udGludWU7CiAgICAgICAgZWNobyAiPGxpPiRmaWxlICgiIC4gZmlsZXNpemUoJHN0b3JhZ2VBcHBQdWJsaWNQcm9kdWN0cyAuICcvJyAuICRmaWxlKSAuICIgYnl0ZXMpPC9saT4iOwogICAgICAgICRjb3VudCsrOwogICAgICAgIGlmICgkY291bnQgPiAxMCkgewogICAgICAgICAgICBlY2hvICI8bGk+Li4uIGFuZCBtb3JlPC9saT4iOwogICAgICAgICAgICBicmVhazsKICAgICAgICB9CiAgICB9CiAgICBlY2hvICI8L3VsPiI7Cn0KPz4K'));
    $log .= '✔ Berhasil memperbarui file: public/list_files.php\n';
    echo "<h1>Pembaruan Berhasil (v56)!</h1><pre style='background:#f3f4f6;padding:1rem;'>" . htmlspecialchars($log) . "</pre>";
} catch (\Exception $e) {
    echo "<h1 style='color:red;'>Error:</h1><pre>" . $e->getMessage() . "</pre>";
}
