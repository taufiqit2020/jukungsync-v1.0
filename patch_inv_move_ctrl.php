<?php
$file = 'app/Http/Controllers/InventoryMovementController.php';
$content = file_get_contents($file);

if (strpos($content, 'use App\Models\Customer;') === false) {
    $content = str_replace('use App\Models\Product;', "use App\Models\Product;\nuse App\Models\Customer;", $content);
}

if (strpos($content, '$customers = Customer::orderBy') === false) {
    $content = str_replace("\$products = Product::orderBy('sku', 'asc')->get();", "\$products = Product::orderBy('sku', 'asc')->get();\n        \$customers = Customer::orderBy('nama_klien', 'asc')->get();", $content);
    $content = str_replace("compact('products')", "compact('products', 'customers')", $content);
}

file_put_contents($file, $content);
echo "InventoryMovementController updated\n";
