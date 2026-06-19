<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Laravel Diagnostics</h1>";
echo "PHP Version: " . PHP_VERSION . "<br>";

$laravelRoot = dirname(__DIR__);
echo "Laravel Root: " . $laravelRoot . "<br>";

// 1. Check .env
$envPath = $laravelRoot . '/.env';
if (file_exists($envPath)) {
    echo "✔ .env file exists.<br>";
} else {
    echo "❌ .env file is MISSING at $envPath!<br>";
}

// 2. Check vendor/autoload.php
$autoloadPath = $laravelRoot . '/vendor/autoload.php';
if (file_exists($autoloadPath)) {
    echo "✔ vendor/autoload.php exists.<br>";
} else {
    echo "❌ vendor/autoload.php is MISSING at $autoloadPath!<br>";
}

// 3. Try to boot Laravel and catch error
try {
    echo "Attempting to boot Laravel...<br>";
    if (file_exists($autoloadPath)) {
        require $autoloadPath;
    }
    $appPath = $laravelRoot . '/bootstrap/app.php';
    if (file_exists($appPath)) {
        echo "✔ bootstrap/app.php exists.<br>";
        $app = require_once $appPath;
        $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
        echo "✔ Laravel Bootstrapped successfully!<br>";
    } else {
        echo "❌ bootstrap/app.php is MISSING at $appPath!<br>";
    }
} catch (Throwable $e) {
    echo "❌ Error during boot:<br>";
    echo "<pre>" . $e->getMessage() . "\nFile: " . $e->getFile() . " Line: " . $e->getLine() . "\n" . $e->getTraceAsString() . "</pre>";
}
?>
