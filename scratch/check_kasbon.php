<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== KASBONS ===\n";
print_r(DB::table('kasbons')->get()->toArray());

echo "\n=== UNPAID INVOICES ===\n";
print_r(DB::table('invoices')->where('status_pembayaran', 'belum_lunas')->get()->toArray());
