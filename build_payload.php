<?php
$files = [
    'app/Models/Setting.php',
    'app/Http/Controllers/SettingController.php',
    'resources/views/settings/landing_page.blade.php',
    'resources/views/layouts/admin.blade.php',
    'resources/views/welcome.blade.php',
    'database/migrations/2026_06_09_021759_create_settings_table.php',
    'routes/web.php'
];

$payload = [];
foreach ($files as $file) {
    $path = __DIR__ . '/test_fixed/' . $file;
    if (file_exists($path)) {
        $payload[$file] = base64_encode(file_get_contents($path));
    }
}

file_put_contents('payload.json', json_encode($payload));
echo "Payload generated.\n";
