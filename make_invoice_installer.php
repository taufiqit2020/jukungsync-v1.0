<?php
$b64 = base64_encode(file_get_contents('app/Http/Controllers/InvoiceController.php'));

$php = "<?php\n\n";
$php .= "use Illuminate\\Support\\Facades\\Route;\n";
$php .= "use Illuminate\\Support\\Facades\\File;\n\n";
$php .= "Route::get('/perbaiki-invoice', function() {\n";
$php .= "    try {\n";
$php .= "        File::put(app_path('Http/Controllers/InvoiceController.php'), base64_decode('$b64'));\n";
$php .= "        \Illuminate\Support\Facades\Artisan::call('optimize:clear');\n";
$php .= "        // Restore the original web.php safely by reading from a backup or from string\n";
$php .= "        \$web_php = <<<'EOD'\n";
$php .= file_get_contents('routes/web.php');
$php .= "\nEOD;\n";
$php .= "        File::put(base_path('routes/web.php'), \$web_php);\n";
$php .= "        return redirect('/invoices')->with('success', 'Barang dengan stok 0 yang ditarik dari mutasi manual sekarang sudah berhasil ditampilkan!');\n";
$php .= "    } catch (\\Exception \$e) {\n";
$php .= "        return 'Error: ' . \$e->getMessage();\n";
$php .= "    }\n";
$php .= "});\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_invoice.md', $md);
