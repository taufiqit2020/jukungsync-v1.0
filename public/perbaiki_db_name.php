<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$laravelRoot = dirname(__DIR__);
$envPath = $laravelRoot . '/.env';

echo "<h1>Perbaikan Konfigurasi Database & Cache</h1>";

if (!file_exists($envPath)) {
    echo "❌ File .env tidak ditemukan di $envPath<br>";
    exit;
}

$envContent = file_get_contents($envPath);

// Cek apakah database name u169145000_jukungsyncv1 ada di .env
if (strpos($envContent, 'u169145000_jukungsyncv1') !== false) {
    echo "⚙ Mendeteksi database salah: <code>u169145000_jukungsyncv1</code><br>";
    $envContent = str_replace('u169145000_jukungsyncv1', 'u169145000_jukungsync1', $envContent);
    
    if (file_put_contents($envPath, $envContent) !== false) {
        echo "✔ Berhasil mengubah nama database menjadi <code>u169145000_jukungsync1</code> di .env!<br>";
    } else {
        echo "❌ Gagal memperbarui file .env!<br>";
        exit;
    }
} else {
    echo "ℹ Nama database di .env tidak menggunakan u169145000_jukungsyncv1 atau sudah diubah.<br>";
}

// Hapus cache konfigurasi secara langsung di filesystem
$configCachePath = $laravelRoot . '/bootstrap/cache/config.php';
if (file_exists($configCachePath)) {
    if (@unlink($configCachePath)) {
        echo "✔ File cache config (bootstrap/cache/config.php) berhasil dihapus!<br>";
    } else {
        echo "❌ Gagal menghapus file cache config!<br>";
    }
} else {
    echo "ℹ File cache config memang tidak ada (sudah bersih).<br>";
}

// Hapus cache route secara langsung di filesystem
$routeCachePath = $laravelRoot . '/bootstrap/cache/routes-v7.php';
if (file_exists($routeCachePath)) {
    @unlink($routeCachePath);
    echo "✔ File cache routes berhasil dihapus!<br>";
}

// Coba hubungkan ke database untuk testing
echo "<h3>Menguji Koneksi Database...</h3>";

// Parse .env untuk mendapatkan kredensial
$lines = explode("\n", $envContent);
$dbConfig = [];
foreach ($lines as $line) {
    $line = trim($line);
    if (empty($line) || strpos($line, '#') === 0) continue;
    if (strpos($line, '=') !== false) {
        list($key, $val) = explode('=', $line, 2);
        $dbConfig[trim($key)] = trim($val, "\"' ");
    }
}

$dbHost = $dbConfig['DB_HOST'] ?? '127.0.0.1';
$dbPort = $dbConfig['DB_PORT'] ?? '3306';
$dbName = $dbConfig['DB_DATABASE'] ?? '';
$dbUser = $dbConfig['DB_USERNAME'] ?? '';
$dbPass = $dbConfig['DB_PASSWORD'] ?? '';

echo "Host: $dbHost<br>";
echo "Port: $dbPort<br>";
echo "Database: $dbName<br>";
echo "User: $dbUser<br>";

try {
    $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];
    $pdo = new PDO($dsn, $dbUser, $dbPass, $options);
    echo "<h2 style='color: green;'>✔ Hore! Koneksi database MySQL BERHASIL!</h2>";
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>❌ Koneksi database GAGAL:</h2>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}

?>
