<?php
// Secure token-based access to prevent unauthorized access
$token = $_GET['token'] ?? '';
if ($token !== 'geminisecuretoken123') {
    header('HTTP/1.0 403 Forbidden');
    die('Unauthorized');
}

$laravelRoot = dirname(__DIR__);
$envFile = $laravelRoot . '/.env';
if (!file_exists($envFile)) {
    die("Error: .env not found");
}

$env = [];
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (strpos($line, '=') === false) continue;
    list($name, $value) = explode('=', $line, 2);
    $env[trim($name)] = trim($value, ' "\'');
}

$host = $env['DB_HOST'] ?? '127.0.0.1';
$port = $env['DB_PORT'] ?? '3306';
$db   = $env['DB_DATABASE'] ?? '';
$user = $env['DB_USERNAME'] ?? '';
$pass = $env['DB_PASSWORD'] ?? '';

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    $stmt = $pdo->query("SELECT id, sku, nama_barang, gambar, gambar_tambahan FROM products");
    $products = $stmt->fetchAll();
    
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'timestamp' => date('Y-m-d H:i:s'),
        'total_products' => count($products),
        'products' => $products
    ]);
    
} catch (Exception $e) {
    header('HTTP/1.0 500 Internal Server Error');
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

// Self-destruct after execution
register_shutdown_function(function() {
    @unlink(__FILE__);
});
