<?php
$inv_mov = base64_encode(file_get_contents('app/Http/Controllers/InventoryMovementController.php'));
$inv = base64_encode(file_get_contents('app/Http/Controllers/InvoiceController.php'));
$pur = base64_encode(file_get_contents('app/Http/Controllers/PurchaseController.php'));

$payload = [
    'inventory_movement' => $inv_mov,
    'invoice' => $inv,
    'purchase' => $pur
];

file_put_contents('payload_sorting.txt', base64_encode(json_encode($payload)));
