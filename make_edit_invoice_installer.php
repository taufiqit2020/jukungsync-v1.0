<?php
$b64_edit = file_get_contents('payload_edit_invoice.txt');
$b64_controller = file_get_contents('payload_controller_edit.txt');

$php = "<?php\n\n";
$php .= "use Illuminate\\Support\\Facades\\Route;\n";
$php .= "use Illuminate\\Support\\Facades\\File;\n\n";
$php .= "Route::get('/tambah-jatuh-tempo', function() {\n";
$php .= "    try {\n";
$php .= "        File::put(resource_path('views/invoices/edit.blade.php'), base64_decode('$b64_edit'));\n";
$php .= "        File::put(app_path('Http/Controllers/InvoiceController.php'), base64_decode('$b64_controller'));\n";
$php .= "        \Illuminate\Support\Facades\Artisan::call('view:clear');\n";
$php .= "        // Restore the original web.php safely\n";
$php .= "        \$web_php = <<<'EOD'\n";
$php .= file_get_contents('routes/web.php');
$php .= "\nEOD;\n";
$php .= "        File::put(base_path('routes/web.php'), \$web_php);\n";
$php .= "        return redirect('/invoices')->with('success', 'Kolom Tanggal Jatuh Tempo berhasil ditambahkan ke halaman Edit Invoice Superadmin.');\n";
$php .= "    } catch (\\Exception \$e) {\n";
$php .= "        return 'Error: ' . \$e->getMessage();\n";
$php .= "    }\n";
$php .= "});\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_jatuh_tempo.md', $md);
