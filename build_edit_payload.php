<?php
$c = base64_encode(file_get_contents('app/Http/Controllers/InventoryMovementController.php'));
$i = base64_encode(file_get_contents('resources/views/inventory-movements/index.blade.php'));
$e = base64_encode(file_get_contents('resources/views/inventory-movements/edit.blade.php'));
$w = base64_encode(file_get_contents('routes/web.php'));

$payload = json_encode(['c' => $c, 'i' => $i, 'e' => $e, 'w' => $w]);
file_put_contents('payload_edit.txt', base64_encode($payload));
