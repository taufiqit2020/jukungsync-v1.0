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
    file_put_contents($laravelRoot . '/public/list_files.php', base64_decode('PD9waHAKaW5pX3NldCgnZGlzcGxheV9lcnJvcnMnLCAxKTsKaW5pX3NldCgnZGlzcGxheV9zdGFydHVwX2Vycm9ycycsIDEpOwplcnJvcl9yZXBvcnRpbmcoRV9BTEwpOwoKJGxhcmF2ZWxSb290ID0gZGlybmFtZShfX0RJUl9fKTsKZWNobyAiPGgxPlJlbW90ZSBGaWxlIExpc3RlciB2MjwvaDE+IjsKZWNobyAiPHA+TGFyYXZlbCBSb290OiAkbGFyYXZlbFJvb3Q8L3A+IjsKCiRwdWJsaWNTdG9yYWdlID0gJGxhcmF2ZWxSb290IC4gJy9wdWJsaWMvc3RvcmFnZSc7CmVjaG8gIjxoMj5TdG9yYWdlIExpbmsgRGlhZ25vc3RpY3M8L2gyPiI7CmVjaG8gIlBhdGg6ICRwdWJsaWNTdG9yYWdlPGJyPiI7CmVjaG8gImlzX2xpbms6ICIgLiAoaXNfbGluaygkcHVibGljU3RvcmFnZSkgPyAiWUVTIiA6ICJOTyIpIC4gIjxicj4iOwppZiAoaXNfbGluaygkcHVibGljU3RvcmFnZSkpIHsKICAgIGVjaG8gInJlYWRsaW5rIHRhcmdldDogIiAuIHJlYWRsaW5rKCRwdWJsaWNTdG9yYWdlKSAuICI8YnI+IjsKfQplY2hvICJmaWxlX2V4aXN0czogIiAuIChmaWxlX2V4aXN0cygkcHVibGljU3RvcmFnZSkgPyAiWUVTIiA6ICJOTyIpIC4gIjxicj4iOwplY2hvICJpc19kaXI6ICIgLiAoaXNfZGlyKCRwdWJsaWNTdG9yYWdlKSA/ICJZRVMiIDogIk5PIikgLiAiPGJyPiI7CgpmdW5jdGlvbiBsaXN0RGlyKCRkaXIpIHsKICAgIGlmICghaXNfZGlyKCRkaXIpKSB7CiAgICAgICAgZWNobyAiPHAgc3R5bGU9J2NvbG9yOnJlZDsnPk5vdCBhIGRpcmVjdG9yeSBvciBicm9rZW4gc3ltbGluazogJGRpcjwvcD4iOwogICAgICAgIHJldHVybjsKICAgIH0KICAgICRpdGVtcyA9IHNjYW5kaXIoJGRpcik7CiAgICBlY2hvICI8dWw+IjsKICAgIGZvcmVhY2ggKCRpdGVtcyBhcyAkaXRlbSkgewogICAgICAgIGlmICgkaXRlbSA9PT0gJy4nIHx8ICRpdGVtID09PSAnLi4nKSBjb250aW51ZTsKICAgICAgICAkcGF0aCA9ICRkaXIgLiAnLycgLiAkaXRlbTsKICAgICAgICBpZiAoaXNfZGlyKCRwYXRoKSkgewogICAgICAgICAgICBlY2hvICI8bGk+PHN0cm9uZz5bRElSXSAkaXRlbTwvc3Ryb25nPiI7CiAgICAgICAgICAgIGlmIChpbl9hcnJheSgkaXRlbSwgWydzdG9yYWdlJywgJ3B1YmxpYycsICdhcHAnLCAnaW1nJywgJ3Byb2R1Y3RzJywgJ2J1a3RpX2ludm9pY2VzJ10pKSB7CiAgICAgICAgICAgICAgICBsaXN0RGlyKCRwYXRoKTsKICAgICAgICAgICAgfQogICAgICAgICAgICBlY2hvICI8L2xpPiI7CiAgICAgICAgfSBlbHNlIHsKICAgICAgICAgICAgJHNpemUgPSBmaWxlc2l6ZSgkcGF0aCk7CiAgICAgICAgICAgIGVjaG8gIjxsaT4kaXRlbSAoJHNpemUgYnl0ZXMpPC9saT4iOwogICAgICAgIH0KICAgIH0KICAgIGVjaG8gIjwvdWw+IjsKfQoKZWNobyAiPGgyPkxpc3RpbmcgUHVibGljIFN0b3JhZ2UgQ29udGVudHM8L2gyPiI7Cmxpc3REaXIoJHB1YmxpY1N0b3JhZ2UpOwoKZWNobyAiPGgyPkxpc3RpbmcgUHVibGljIEltZyBDb250ZW50czwvaDI+IjsKbGlzdERpcigkbGFyYXZlbFJvb3QgLiAnL3B1YmxpYy9pbWcnKTsKCmVjaG8gIjxoMj5MaXN0aW5nIFN0b3JhZ2UgQXBwIFB1YmxpYzwvaDI+IjsKbGlzdERpcigkbGFyYXZlbFJvb3QgLiAnL3N0b3JhZ2UvYXBwL3B1YmxpYycpOwo/Pgo='));
    $log .= '✔ Berhasil memperbarui file: public/list_files.php\n';
    echo "<h1>Pembaruan Berhasil (v56)!</h1><pre style='background:#f3f4f6;padding:1rem;'>" . htmlspecialchars($log) . "</pre>";
} catch (\Exception $e) {
    echo "<h1 style='color:red;'>Error:</h1><pre>" . $e->getMessage() . "</pre>";
}
