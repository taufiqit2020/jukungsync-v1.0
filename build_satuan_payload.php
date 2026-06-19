<?php
$m = base64_encode(file_get_contents('database/migrations/2026_06_09_063710_add_satuan_to_products_table.php'));
$p = base64_encode(file_get_contents('app/Models/Product.php'));
$c = base64_encode(file_get_contents('app/Http/Controllers/ProductController.php'));
$i = base64_encode(file_get_contents('resources/views/products/index.blade.php'));
$cr = base64_encode(file_get_contents('resources/views/products/create.blade.php'));
$e = base64_encode(file_get_contents('resources/views/products/edit.blade.php'));

$payload = json_encode(['m' => $m, 'p' => $p, 'c' => $c, 'i' => $i, 'cr' => $cr, 'e' => $e]);
file_put_contents('payload_satuan.txt', base64_encode($payload));
