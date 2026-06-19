<?php
$files = [
    'app/Http/Controllers/CategoryController.php',
    'app/Http/Controllers/MerkController.php',
    'app/Http/Controllers/ProductController.php',
    'app/Http/Controllers/UserController.php'
];

$payload = [];
foreach ($files as $file) {
    $path = __DIR__ . '/' . $file;
    if (file_exists($path)) {
        $payload[$file] = base64_encode(file_get_contents($path));
    }
}

file_put_contents('payload_controllers.json', json_encode($payload));
echo "Payload controllers generated.\n";
