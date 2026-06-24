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
    @mkdir(dirname($laravelRoot . '/public/perbaiki_storage_link.php'), 0777, true);
    file_put_contents($laravelRoot . '/public/perbaiki_storage_link.php', base64_decode('PD9waHAKaW5pX3NldCgnZGlzcGxheV9lcnJvcnMnLCAxKTsKaW5pX3NldCgnZGlzcGxheV9zdGFydHVwX2Vycm9ycycsIDEpOwplcnJvcl9yZXBvcnRpbmcoRV9BTEwpOwoKJGxhcmF2ZWxSb290ID0gZGlybmFtZShfX0RJUl9fKTsKJHB1YmxpY1N0b3JhZ2VQYXRoID0gX19ESVJfXyAuICcvc3RvcmFnZSc7CiR0YXJnZXRTdG9yYWdlUGF0aCA9ICRsYXJhdmVsUm9vdCAuICcvc3RvcmFnZS9hcHAvcHVibGljJzsKCmVjaG8gIjxoMT5QZXJiYWlrYW4gU3RvcmFnZSBTeW1saW5rIExhcmF2ZWw8L2gxPiI7CmVjaG8gIkxhcmF2ZWwgUm9vdDogIiAuIGh0bWxzcGVjaWFsY2hhcnMoJGxhcmF2ZWxSb290KSAuICI8YnI+IjsKZWNobyAiUHVibGljIFN0b3JhZ2UgUGF0aDogIiAuIGh0bWxzcGVjaWFsY2hhcnMoJHB1YmxpY1N0b3JhZ2VQYXRoKSAuICI8YnI+IjsKZWNobyAiVGFyZ2V0IFN0b3JhZ2UgUGF0aDogIiAuIGh0bWxzcGVjaWFsY2hhcnMoJHRhcmdldFN0b3JhZ2VQYXRoKSAuICI8YnI+PGJyPiI7CgovLyAxLiBQZXJpa3NhIHRhcmdldCBkaXJlY3RvcnkKaWYgKCFpc19kaXIoJHRhcmdldFN0b3JhZ2VQYXRoKSkgewogICAgZWNobyAiTWVtYnVhdCBkaXJla3RvcmkgdGFyZ2V0Li4uPGJyPiI7CiAgICBpZiAoQG1rZGlyKCR0YXJnZXRTdG9yYWdlUGF0aCwgMDc3NywgdHJ1ZSkpIHsKICAgICAgICBlY2hvICLinJQgRGlyZWt0b3JpIHRhcmdldCBiZXJoYXNpbCBkaWJ1YXQuPGJyPiI7CiAgICB9IGVsc2UgewogICAgICAgIGVjaG8gIuKdjCBHYWdhbCBtZW1idWF0IGRpcmVrdG9yaSB0YXJnZXQhPGJyPiI7CiAgICB9Cn0gZWxzZSB7CiAgICBlY2hvICLinJQgRGlyZWt0b3JpIHRhcmdldCBhZGEuPGJyPiI7Cn0KCi8vIDIuIFBlcmlrc2EgYXBha2FoIHB1YmxpYy9zdG9yYWdlIHN1ZGFoIGFkYQokbGlua1ZhbGlkID0gZmFsc2U7CmlmIChmaWxlX2V4aXN0cygkcHVibGljU3RvcmFnZVBhdGgpIHx8IGlzX2xpbmsoJHB1YmxpY1N0b3JhZ2VQYXRoKSkgewogICAgZWNobyAiUHVibGljIHN0b3JhZ2UgbGluay9mb2xkZXIgc3VkYWggYWRhLjxicj4iOwogICAgCiAgICAvLyBQZXJpa3NhIGFwYWthaCBpdHUgc3ltbGluawogICAgaWYgKGlzX2xpbmsoJHB1YmxpY1N0b3JhZ2VQYXRoKSkgewogICAgICAgICRsaW5rVGFyZ2V0ID0gQHJlYWRsaW5rKCRwdWJsaWNTdG9yYWdlUGF0aCk7CiAgICAgICAgZWNobyAiVGlwZTogU3ltYm9saWMgTGluazxicj4iOwogICAgICAgIGVjaG8gIk1lbnVuanVrIGtlOiAiIC4gaHRtbHNwZWNpYWxjaGFycygkbGlua1RhcmdldCkgLiAiPGJyPiI7CiAgICAgICAgCiAgICAgICAgLy8gQ2VrIGFwYWthaCBsaW5rIHRhcmdldCB2YWxpZAogICAgICAgIGlmIChyZWFscGF0aCgkcHVibGljU3RvcmFnZVBhdGgpID09PSByZWFscGF0aCgkdGFyZ2V0U3RvcmFnZVBhdGgpKSB7CiAgICAgICAgICAgIGVjaG8gIuKclCBTeW1ib2xpYyBsaW5rIHN1ZGFoIGJlbmFyIGRhbiB2YWxpZCE8YnI+IjsKICAgICAgICAgICAgJGxpbmtWYWxpZCA9IHRydWU7CiAgICAgICAgfSBlbHNlIHsKICAgICAgICAgICAgZWNobyAi4pqgIFN5bWJvbGljIGxpbmsgbWVudW5qdWsga2UgdGVtcGF0IHlhbmcgc2FsYWgsIG1lbmdoYXB1cyBsaW5rIGxhbWEuLi48YnI+IjsKICAgICAgICAgICAgaWYgKEB1bmxpbmsoJHB1YmxpY1N0b3JhZ2VQYXRoKSkgewogICAgICAgICAgICAgICAgZWNobyAi4pyUIExpbmsgbGFtYSBiZXJoYXNpbCBkaWhhcHVzLjxicj4iOwogICAgICAgICAgICAgICAgJGxpbmtWYWxpZCA9IGZhbHNlOwogICAgICAgICAgICB9IGVsc2UgewogICAgICAgICAgICAgICAgZWNobyAi4p2MIEdhZ2FsIG1lbmdoYXB1cyBsaW5rIGxhbWEhPGJyPiI7CiAgICAgICAgICAgICAgICAkbGlua1ZhbGlkID0gdHJ1ZTsgLy8gcHJldmVudCByZWNyZWF0aW9uIGlmIHVubGluayBmYWlscwogICAgICAgICAgICB9CiAgICAgICAgfQogICAgfSBlbHNlIHsKICAgICAgICBlY2hvICJUaXBlOiBEaXJla3RvcmkgQmlhc2EgKEJ1a2FuIFN5bWxpbmspPGJyPiI7CiAgICAgICAgZWNobyAi4pqgIE1lbmdoYXB1cyBkaXJla3RvcmkgYmlhc2EgYWdhciBiaXNhIGRpZ2FudGlrYW4gb2xlaCBzeW1saW5rLi4uPGJyPiI7CiAgICAgICAgCiAgICAgICAgLy8gUmVjdXJzaXZlIGhlbHBlciB0byBkZWxldGUgZm9sZGVyCiAgICAgICAgZnVuY3Rpb24gZGVsZXRlRGlyKCRkaXJQYXRoKSB7CiAgICAgICAgICAgIGlmICghaXNfZGlyKCRkaXJQYXRoKSkgcmV0dXJuIGZhbHNlOwogICAgICAgICAgICBpZiAoc3Vic3RyKCRkaXJQYXRoLCBzdHJsZW4oJGRpclBhdGgpIC0gMSwgMSkgIT0gJy8nKSB7CiAgICAgICAgICAgICAgICAkZGlyUGF0aCAuPSAnLyc7CiAgICAgICAgICAgIH0KICAgICAgICAgICAgJGZpbGVzID0gZ2xvYigkZGlyUGF0aCAuICcqJywgR0xPQl9NQVJLKTsKICAgICAgICAgICAgZm9yZWFjaCAoJGZpbGVzIGFzICRmaWxlKSB7CiAgICAgICAgICAgICAgICBpZiAoaXNfZGlyKCRmaWxlKSkgewogICAgICAgICAgICAgICAgICAgIGRlbGV0ZURpcigkZmlsZSk7CiAgICAgICAgICAgICAgICB9IGVsc2UgewogICAgICAgICAgICAgICAgICAgIEB1bmxpbmsoJGZpbGUpOwogICAgICAgICAgICAgICAgfQogICAgICAgICAgICB9CiAgICAgICAgICAgIHJldHVybiBAcm1kaXIoJGRpclBhdGgpOwogICAgICAgIH0KICAgICAgICAKICAgICAgICBpZiAoZGVsZXRlRGlyKCRwdWJsaWNTdG9yYWdlUGF0aCkpIHsKICAgICAgICAgICAgZWNobyAi4pyUIERpcmVrdG9yaSBiaWFzYSBiZXJoYXNpbCBkaWhhcHVzLjxicj4iOwogICAgICAgICAgICAkbGlua1ZhbGlkID0gZmFsc2U7CiAgICAgICAgfSBlbHNlIHsKICAgICAgICAgICAgZWNobyAi4p2MIEdhZ2FsIG1lbmdoYXB1cyBkaXJla3RvcmkgYmlhc2EhPGJyPiI7CiAgICAgICAgICAgICRsaW5rVmFsaWQgPSB0cnVlOwogICAgICAgIH0KICAgIH0KfSBlbHNlIHsKICAgIGVjaG8gIlB1YmxpYyBzdG9yYWdlIGxpbmsgYmVsdW0gYWRhLjxicj4iOwogICAgJGxpbmtWYWxpZCA9IGZhbHNlOwp9CgovLyAzLiBCdWF0IHN5bWxpbmsgYmFydSBqaWthIHRpZGFrIHZhbGlkIC8gYmVsdW0gYWRhCmlmICghJGxpbmtWYWxpZCkgewogICAgZWNobyAiTWVtYnVhdCBzeW1ib2xpYyBsaW5rIGJhcnUuLi48YnI+IjsKICAgIGlmIChAc3ltbGluaygkdGFyZ2V0U3RvcmFnZVBhdGgsICRwdWJsaWNTdG9yYWdlUGF0aCkpIHsKICAgICAgICBlY2hvICLinJQgU3ltYm9saWMgbGluayBiYXJ1IGJlcmhhc2lsIGRpYnVhdCE8YnI+IjsKICAgIH0gZWxzZSB7CiAgICAgICAgZWNobyAi4p2MIEdhZ2FsIG1lbmdndW5ha2FuIHN5bWxpbmsoKS4gTWVuY29iYSBtZXRvZGUgY29weS9hcnRpc2FuLi4uPGJyPiI7CiAgICAgICAgLy8gQWx0ZXJuYXRpZjogSmFsYW5rYW4gY29tbWFuZCBhcnRpc2FuCiAgICAgICAgdHJ5IHsKICAgICAgICAgICAgaWYgKGZpbGVfZXhpc3RzKCRsYXJhdmVsUm9vdCAuICcvdmVuZG9yL2F1dG9sb2FkLnBocCcpKSB7CiAgICAgICAgICAgICAgICByZXF1aXJlICRsYXJhdmVsUm9vdCAuICcvdmVuZG9yL2F1dG9sb2FkLnBocCc7CiAgICAgICAgICAgICAgICAkYXBwID0gcmVxdWlyZV9vbmNlICRsYXJhdmVsUm9vdCAuICcvYm9vdHN0cmFwL2FwcC5waHAnOwogICAgICAgICAgICAgICAgJGFwcC0+bWFrZSgnSWxsdW1pbmF0ZVxDb250cmFjdHNcQ29uc29sZVxLZXJuZWwnKS0+Ym9vdHN0cmFwKCk7CiAgICAgICAgICAgICAgICBcSWxsdW1pbmF0ZVxTdXBwb3J0XEZhY2FkZXNcQXJ0aXNhbjo6Y2FsbCgnc3RvcmFnZTpsaW5rJyk7CiAgICAgICAgICAgICAgICBlY2hvICLinJQgU3RvcmFnZSBsaW5rIGRpYnVhdCB2aWEgQXJ0aXNhbjogIiAuIGh0bWxzcGVjaWFsY2hhcnMoXElsbHVtaW5hdGVcU3VwcG9ydFxGYWNhZGVzXEFydGlzYW46Om91dHB1dCgpKSAuICI8YnI+IjsKICAgICAgICAgICAgfQogICAgICAgIH0gY2F0Y2ggKFRocm93YWJsZSAkZSkgewogICAgICAgICAgICBlY2hvICLinYwgR2FnYWwgdmlhIEFydGlzYW46ICIgLiAkZS0+Z2V0TWVzc2FnZSgpIC4gIjxicj4iOwogICAgICAgIH0KICAgIH0KfQoKLy8gNC4gVmVyaWZpa2FzaSBha2hpcgppZiAoZmlsZV9leGlzdHMoJHB1YmxpY1N0b3JhZ2VQYXRoKSAmJiBpc19saW5rKCRwdWJsaWNTdG9yYWdlUGF0aCkpIHsKICAgIGVjaG8gIjxicj48aDMgc3R5bGU9J2NvbG9yOmdyZWVuOyc+4pyUIFNFTEVTQUk6IExpbmsgc3RvcmFnZSBiZXJoYXNpbCBkaXBlcmJhaWtpIGRhbiB2YWxpZCE8L2gzPiI7Cn0gZWxzZSB7CiAgICBlY2hvICI8YnI+PGgzIHN0eWxlPSdjb2xvcjpyZWQ7Jz7inYwgR0FHQUw6IExpbmsgc3RvcmFnZSB0ZXRhcCB0aWRhayB2YWxpZC4gSHVidW5naSBhZG1pbi48L2gzPiI7Cn0KPz4K'));

    // --- LOGIC PERBAIKAN STORAGE LINK OTOMATIS ---
    $publicStoragePath = $laravelRoot . '/public/storage';
    $targetStoragePath = $laravelRoot . '/storage/app/public';
    $linkSuccess = false;
    $linkMessage = '';

    if (!is_dir($targetStoragePath)) {
        @mkdir($targetStoragePath, 0777, true);
    }

    if (file_exists($publicStoragePath) || is_link($publicStoragePath)) {
        if (is_link($publicStoragePath)) {
            if (realpath($publicStoragePath) === realpath($targetStoragePath)) {
                $linkSuccess = true;
                $linkMessage = 'Symbolic link storage sudah valid dan aktif.';
            } else {
                @unlink($publicStoragePath);
            }
        } else {
            // Jika berupa direktori biasa, coba hapus
            function deleteFolderRecursive($dir) {
                if (!is_dir($dir)) return false;
                $files = array_diff(scandir($dir), array('.','..'));
                foreach ($files as $file) {
                    (is_dir("$dir/$file")) ? deleteFolderRecursive("$dir/$file") : unlink("$dir/$file");
                }
                return rmdir($dir);
            }
            deleteFolderRecursive($publicStoragePath);
        }
    }

    if (!$linkSuccess) {
        if (@symlink($targetStoragePath, $publicStoragePath)) {
            $linkSuccess = true;
            $linkMessage = 'Symbolic link storage berhasil dibuat menggunakan PHP symlink()!';
        } else {
            try {
                if (file_exists($laravelRoot . '/vendor/autoload.php')) {
                    require_once $laravelRoot . '/vendor/autoload.php';
                    $app = require_once $laravelRoot . '/bootstrap/app.php';
                    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
                    \Illuminate\Support\Facades\Artisan::call('storage:link');
                    $linkSuccess = true;
                    $linkMessage = 'Symbolic link storage berhasil dibuat menggunakan php artisan storage:link!';
                }
            } catch (\Throwable $e) {
                $linkMessage = 'Gagal membuat symbolic link: ' . $e->getMessage();
            }
        }
    }

    // Bersihkan cache Laravel
    $cacheDir = $laravelRoot . '/bootstrap/cache';
    if (is_dir($cacheDir)) { $caches = glob($cacheDir . '/*.php'); foreach ($caches as $cf) @unlink($cf); }

    if (function_exists('opcache_reset')) { opcache_reset(); }

    echo "<div style='font-family:Inter,sans-serif;max-width:640px;margin:60px auto;padding:0 20px;'>";  
    echo "<div style='background:linear-gradient(135deg,#1e3a8a,#2563eb);border-radius:1.25rem;padding:2rem;color:white;text-align:center;margin-bottom:1.5rem;'>";  
    echo "<div style='font-size:3rem;margin-bottom:0.75rem;'>🖼️</div>";  
    echo "<h1 style='margin:0;font-size:1.5rem;font-weight:900;'>Pembaruan & Perbaikan Berhasil!</h1>";  
    echo "<p style='margin:0.5rem 0 0;opacity:0.8;font-size:0.9rem;'>Perbaikan Bug Upload & Tampilan Gambar Produk</p>";  
    echo "</div>";  
    echo "<div style='background:white;border:1px solid #e5e7eb;border-radius:1rem;padding:1.5rem;margin-bottom:1.25rem;box-shadow:0 4px 16px rgba(0,0,0,0.06);'>";  
    echo "<h2 style='margin:0 0 1rem;color:#1f2937;font-size:1rem;font-weight:800;'>Status Link Storage:</h2>";  
    if ($linkSuccess) {
        echo "<div style='background:#dcfce7;border:1.5px solid #86efac;color:#166534;border-radius:0.75rem;padding:1rem;font-size:0.875rem;font-weight:600;'>✔ " . htmlspecialchars($linkMessage) . "</div>";
    } else {
        echo "<div style='background:#fee2e2;border:1.5px solid #fecaca;color:#991b1b;border-radius:0.75rem;padding:1rem;font-size:0.875rem;font-weight:600;'>❌ " . htmlspecialchars($linkMessage) . "</div>";
    }
    echo "</div>";  
    echo "<div style='text-align:center;'>";  
    echo "<a href='/products' style='display:inline-flex;align-items:center;gap:0.5rem;padding:0.875rem 2rem;background:linear-gradient(135deg,#ca8a04,#d97706);color:#111827;text-decoration:none;border-radius:0.875rem;font-weight:800;font-size:0.95rem;box-shadow:0 4px 16px rgba(202,138,4,0.35);'>📦 Buka Data Barang</a>";  
    echo "</div>";  
    echo "</div>";  
} catch (\Exception $e) {
    echo "<h1 style='color:red;'>Error:</h1><pre>" . $e->getMessage() . "</pre>";
}
