<?php
$b64 = file_get_contents('payload_print_v5.txt');

$php = "<?php\n\n";
$php .= "use Illuminate\\Support\\Facades\\Route;\n";
$php .= "use Illuminate\\Support\\Facades\\File;\n\n";
$php .= "Route::get('/perbaiki-print-v5', function() {\n";
$php .= "    try {\n";
$php .= "        File::put(resource_path('views/invoices/show.blade.php'), base64_decode('$b64'));\n";
$php .= "        \Illuminate\Support\Facades\Artisan::call('view:clear');\n";
$php .= "        // Restore the original web.php safely\n";
$php .= "        \$web_php = <<<'EOD'\n";
$php .= file_get_contents('routes/web.php');
$php .= "\nEOD;\n";
$php .= "        File::put(base_path('routes/web.php'), \$web_php);\n";
$php .= "        return redirect('/invoices')->with('success', 'Berhasil! Footer Alamat sekarang dikunci tepat di ujung bawah setiap kertas cetakan, dan Tanda Tangan OWNER kini selalu berada di bawah keterangan rekening Bank secara sejajar namun tidak saling menimpa/menabrak.');\n";
$php .= "    } catch (\\Exception \$e) {\n";
$php .= "        return 'Error: ' . \$e->getMessage();\n";
$php .= "    }\n";
$php .= "});\n";

$md = "```php\n" . $php . "\n```";
file_put_contents('C:/Users/USER/.gemini/antigravity/brain/f12d4254-b154-471c-b76a-aa67f4e9fcf6/installer_print_v5.md', $md);
