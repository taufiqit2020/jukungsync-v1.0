<?php
$file = 'app/Http/Controllers/InvoiceController.php';
$content = file_get_contents($file);

if (strpos($content, 'use App\Models\Customer;') === false) {
    $content = str_replace('use App\Models\InvoiceItem;', "use App\Models\InvoiceItem;\nuse App\Models\Customer;", $content);
}

if (strpos($content, '$customers = Customer::orderBy') === false) {
    $content = str_replace("\$products = Product::with('category')->orderBy('sku', 'asc')->get();", "\$products = Product::with('category')->orderBy('sku', 'asc')->get();\n        \$customers = Customer::orderBy('nama_klien', 'asc')->get();", $content);
    $content = str_replace("compact('invoices', 'products', 'nomor_invoice')", "compact('invoices', 'products', 'nomor_invoice', 'customers')", $content);
}

file_put_contents($file, $content);
echo "InvoiceController updated\n";
