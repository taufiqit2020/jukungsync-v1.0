<?php
$b64 = file_get_contents('payload_invoice_controller.txt');

$php = "<?php\n\n";
$php .= "use Illuminate\\Support\\Facades\\Route;\n";
$php .= "use Illuminate\\Support\\Facades\\File;\n\n";
$php .= "Route::get('/perbaiki-error', function() {\n";
$php .= "    try {\n";
$php .= "        File::put(app_path('Http/Controllers/InvoiceController.php'), base64_decode('$b64'));\n";
$php .= "        // Restore the original web.php safely\n";
$php .= "        \$web_php = <<<'EOD'\n";
$php .= file_get_contents('routes/web.php');
$php .= "\nEOD;\n";
$php .= "        File::put(base_path('routes/web.php'), \$web_php);\n";
$php .= "        return redirect('/invoices')->with('success', 'Error berhasil diperbaiki! Sistem hapus invoice kembali normal dengan fitur Mutasi Keluar yang baru.');\n";
$php .= "    } catch (\\Exception \$e) {\n";
$php .= "        return 'Error: ' . \$e->getMessage();\n";
$php .= "    }\n";
$php .= "});\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_error_fix.md', $md);
