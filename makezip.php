<?php
$zip = new ZipArchive();
if ($zip->open('update_grosir_dan_invoice_FIXED.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
    $files = [
        'app/Http/Controllers/ProductController.php',
        'app/Http/Controllers/UserController.php',
        'app/Http/Controllers/CatalogController.php',
        'app/Models/Product.php',
        'app/Models/User.php',
        'resources/views/products/create.blade.php',
        'resources/views/products/edit.blade.php',
        'resources/views/products/index.blade.php',
        'resources/views/users/form.blade.php',
        'resources/views/users/index.blade.php',
        'resources/views/catalog/index.blade.php',
        'resources/views/invoices/index.blade.php',
        'resources/views/invoices/show.blade.php',
        'resources/views/invoices/struk.blade.php',
        'resources/views/welcome.blade.php',
        'resources/views/auth/login.blade.php',
        'resources/views/auth/register.blade.php',
        'database/migrations/2026_06_08_034222_add_harga_grosir_to_products_table.php',
        'database/migrations/2026_06_08_034228_add_tipe_pelanggan_to_users_table.php',
        'routes/web.php'
    ];
    foreach ($files as $f) {
        if (file_exists($f)) {
            $zip->addFile($f, $f);
            echo "Added $f\n";
        } else {
            echo "Missing $f\n";
        }
    }
    $zip->close();
    echo "Done!\n";
} else {
    echo "Failed to create zip.\n";
}
