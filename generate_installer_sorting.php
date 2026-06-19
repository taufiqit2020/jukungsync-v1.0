<?php
$b64 = file_get_contents('payload_sorting.txt');
$b64 = trim($b64);

$php = "<?php\n\n";
$php .= "use Illuminate\\Support\\Facades\\Route;\n";
$php .= "use Illuminate\\Support\\Facades\\File;\n\n";
$php .= "Route::get('/perbaiki-urutan', function() {\n";
$php .= "    try {\n";
$php .= "        \$payload = json_decode(base64_decode('$b64'), true);\n";
$php .= "        File::put(app_path('Http/Controllers/InventoryMovementController.php'), base64_decode(\$payload['inventory_movement']));\n";
$php .= "        File::put(app_path('Http/Controllers/InvoiceController.php'), base64_decode(\$payload['invoice']));\n";
$php .= "        File::put(app_path('Http/Controllers/PurchaseController.php'), base64_decode(\$payload['purchase']));\n";
$php .= "        \Illuminate\Support\Facades\Artisan::call('optimize:clear');\n";
$php .= "        return redirect('/inventory-movements')->with('success', 'Urutan tabel berhasil diperbaiki menjadi sesuai dengan waktu input (berurutan) walaupun tanggal disesuaikan/backdate.');\n";
$php .= "    } catch (\\Exception \$e) {\n";
$php .= "        return 'Error: ' . \$e->getMessage();\n";
$php .= "    }\n";
$php .= "});\n";

file_put_contents('generate_installer_sorting_final.php', $php);
