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

// Parse .env file
$envFile = $laravelRoot . '/.env';
if (!file_exists($envFile)) {
    die("Error: .env file not found.");
}

$env = [];
$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue;
    if (strpos($line, '=') === false) continue;
    list($name, $value) = explode('=', $line, 2);
    $env[trim($name)] = trim($value, ' "\'');
}

$mysqlHost = $env['DB_HOST'] ?? '127.0.0.1';
$mysqlPort = $env['DB_PORT'] ?? '3306';
$mysqlDb   = $env['DB_DATABASE'] ?? '';
$mysqlUser = $env['DB_USERNAME'] ?? '';
$mysqlPass = $env['DB_PASSWORD'] ?? '';

// Connect to SQLite
$sqlitePath = $laravelRoot . '/database/database.sqlite';
if (!file_exists($sqlitePath)) {
    die("Error: SQLite database file not found at: $sqlitePath");
}

try {
    $sqlitePdo = new PDO('sqlite:' . $sqlitePath);
    $sqlitePdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error connecting to SQLite: " . $e->getMessage());
}

// Connect to MySQL
try {
    $mysqlDsn = "mysql:host=$mysqlHost;port=$mysqlPort;dbname=$mysqlDb;charset=utf8mb4";
    $mysqlPdo = new PDO($mysqlDsn, $mysqlUser, $mysqlPass);
    $mysqlPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Error connecting to MySQL: " . $e->getMessage());
}

$tables = [
    'users',
    'categories',
    'merks',
    'products',
    'customers',
    'expenses',
    'purchases',
    'purchase_items',
    'inventory_movements',
    'invoices',
    'invoice_items',
    'settings'
];

echo "<h1>Starting SQLite to MySQL Data Migration...</h1>";

try {
    // Disable foreign key checks
    $mysqlPdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
    
    foreach ($tables as $table) {
        echo "<h3>Table: $table</h3>";
        
        // 1. Truncate table first
        $mysqlPdo->exec("TRUNCATE TABLE `$table`;");
        
        // 2. Fetch all data from SQLite
        $stmt = $sqlitePdo->query("SELECT * FROM `$table` ");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($rows) === 0) {
            echo "No data in SQLite. Table truncated in MySQL.<br>";
            continue;
        }
        
        // 3. Prepare MySQL Insert Statement
        $columns = array_keys($rows[0]);
        $colNames = implode('`, `', $columns);
        $placeholders = implode(', ', array_map(function($col) { return ":$col"; }, $columns));
        
        $insertSql = "INSERT INTO `$table` (`$colNames`) VALUES ($placeholders)";
        $insertStmt = $mysqlPdo->prepare($insertSql);
        
        $count = 0;
        foreach ($rows as $row) {
            // Bind value types correctly
            foreach ($row as $col => $val) {
                if ($val === null) {
                    $insertStmt->bindValue(":$col", null, PDO::PARAM_NULL);
                } else {
                    $insertStmt->bindValue(":$col", $val);
                }
            }
            $insertStmt->execute();
            $count++;
        }
        echo "Successfully migrated $count rows.<br>";
    }
    
    // Enable foreign key checks back
    $mysqlPdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    echo "<h2>✔ Data migration completed successfully! All tables sync'd.</h2>";
} catch (Exception $e) {
    // Re-enable foreign key checks just in case
    $mysqlPdo->exec("SET FOREIGN_KEY_CHECKS = 1;");
    echo "<h2>❌ Error during migration:</h2><pre>" . $e->getMessage() . "</pre>";
}
?>
