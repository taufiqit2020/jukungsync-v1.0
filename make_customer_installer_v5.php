<?php
$b64_migration = file_get_contents('payload_migration.txt');
$b64_model = file_get_contents('payload_customer_model.txt');
$b64_ctrl = file_get_contents('payload_customer_controller.txt');
$b64_inv_ctrl = file_get_contents('payload_invoice_ctrl.txt');
$b64_view_idx = file_get_contents('payload_customer_index.txt');
$b64_admin = file_get_contents('payload_admin_layout.txt');
$b64_inv_view_idx = file_get_contents('payload_index.txt');
$b64_inv_view_edit = file_get_contents('payload_edit_invoice.txt');
$b64_web = base64_encode(file_get_contents('routes/web.php'));

$php = "<?php\n";
$php .= "ini_set('display_errors', 1);\n";
$php .= "ini_set('display_startup_errors', 1);\n";
$php .= "error_reporting(E_ALL);\n\n";

$php .= "// Root Laravel dipaksa ke direktori saat ini (public_html)\n";
$php .= "\$laravelRoot = __DIR__;\n\n";

$php .= "// Fungsi untuk menulis file\n";
$php .= "function put_file_safe(\$path, \$content) {\n";
$php .= "    \$dir = dirname(\$path);\n";
$php .= "    if (!is_dir(\$dir)) mkdir(\$dir, 0755, true);\n";
$php .= "    file_put_contents(\$path, \$content);\n";
$php .= "}\n\n";

$php .= "try {\n";
$php .= "    // 1. Tulis semua file baru ke tempatnya masing-masing\n";
$php .= "    put_file_safe(\$laravelRoot . '/database/migrations/2026_06_10_070151_create_customers_table.php', base64_decode('$b64_migration'));\n";
$php .= "    put_file_safe(\$laravelRoot . '/app/Models/Customer.php', base64_decode('$b64_model'));\n";
$php .= "    put_file_safe(\$laravelRoot . '/app/Http/Controllers/CustomerController.php', base64_decode('$b64_ctrl'));\n";
$php .= "    put_file_safe(\$laravelRoot . '/app/Http/Controllers/InvoiceController.php', base64_decode('$b64_inv_ctrl'));\n";
$php .= "    put_file_safe(\$laravelRoot . '/resources/views/customers/index.blade.php', base64_decode('$b64_view_idx'));\n";
$php .= "    put_file_safe(\$laravelRoot . '/resources/views/layouts/admin.blade.php', base64_decode('$b64_admin'));\n";
$php .= "    put_file_safe(\$laravelRoot . '/resources/views/invoices/index.blade.php', base64_decode('$b64_inv_view_idx'));\n";
$php .= "    put_file_safe(\$laravelRoot . '/resources/views/invoices/edit.blade.php', base64_decode('$b64_inv_view_edit'));\n";
$php .= "    put_file_safe(\$laravelRoot . '/routes/web.php', base64_decode('$b64_web'));\n\n";

$php .= "    // 2. Hapus Cache secara manual (Hard Delete) agar tidak ada rute yang nyangkut\n";
$php .= "    \$cacheDir = \$laravelRoot . '/bootstrap/cache';\n";
$php .= "    if (is_dir(\$cacheDir)) {\n";
$php .= "        \$files = glob(\$cacheDir . '/*.php');\n";
$php .= "        foreach (\$files as \$file) @unlink(\$file);\n";
$php .= "    }\n\n";

$php .= "    // 3. Load Laravel untuk menjalankan perintah database (Migrate)\n";
$php .= "    require \$laravelRoot . '/vendor/autoload.php';\n";
$php .= "    \$app = require_once \$laravelRoot . '/bootstrap/app.php';\n";
$php .= "    \$kernel = \$app->make(Illuminate\\Contracts\\Http\\Kernel::class);\n";
$php .= "    \$response = \$kernel->handle(\$request = Illuminate\\Http\\Request::capture());\n\n";
$php .= "    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);\n";
$php .= "    \Illuminate\Support\Facades\Artisan::call('optimize:clear');\n\n";

$php .= "    echo \"<div style='font-family: sans-serif; text-align: center; margin-top: 50px;'>\";\n";
$php .= "    echo \"<h1 style='color:#16a34a;'>✅ Instalasi Sempurna!</h1>\";\n";
$php .= "    echo \"<p style='color:#4b5563;'>Sistem Master Data Customer telah terpasang dan rute sudah disetel ulang.</p>\";\n";
$php .= "    echo \"<a href='/customers' style='display: inline-block; padding: 10px 20px; background: #991b1b; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px;'>Kembali ke Aplikasi</a>\";\n";
$php .= "    echo \"</div>\";\n\n";

$php .= "    @unlink(__FILE__);\n";
$php .= "} catch (\\Exception \$e) {\n";
$php .= "    echo \"<h1 style='color:red;'>Error Fatal:</h1><pre>\" . \$e->getMessage() . \"</pre>\";\n";
$php .= "}\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_customer_v5.md', $md);
