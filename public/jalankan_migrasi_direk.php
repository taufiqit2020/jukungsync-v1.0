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

// Hapus file migrasi lama yang duplikat di Hostinger jika ada
$oldMigration = $laravelRoot . '/database/migrations/2026_06_03_060544_create_purchases_table.php';
if (file_exists($oldMigration)) {
    @unlink($oldMigration);
}

// Load composer autoloader
require $laravelRoot . '/vendor/autoload.php';

// Bootstrap Laravel application
$app = require_once $laravelRoot . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h1>Menjalankan migrate:fresh...</h1><pre>";
try {
    $status = $kernel->handle(
        $input = new Symfony\Component\Console\Input\StringInput('migrate:fresh --force'),
        $output = new Symfony\Component\Console\Output\BufferedOutput
    );
    echo $output->fetch();
    echo "\n✔ Migrasi database berhasil dilaksanakan!\n";
} catch (\Exception $e) {
    echo "\n❌ Terjadi Kesalahan saat migrasi:\n" . $e->getMessage() . "\n";
}
echo "</pre>";

echo "<h1>Menjalankan optimize:clear...</h1><pre>";
try {
    $status2 = $kernel->handle(
        $input2 = new Symfony\Component\Console\Input\StringInput('optimize:clear'),
        $output2 = new Symfony\Component\Console\Output\BufferedOutput
    );
    echo $output2->fetch();
    echo "\n✔ Cache Laravel berhasil dibersihkan!\n";
} catch (\Exception $e) {
    echo "\n❌ Gagal membersihkan cache:\n" . $e->getMessage() . "\n";
}
echo "</pre>";
?>
