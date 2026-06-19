<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$m = App\Models\InventoryMovement::orderBy('tanggal', 'desc')->orderBy('id', 'desc')->limit(10)->get();
foreach($m as $i) {
    echo $i->tanggal . ' | id:' . $i->id . ' | created_at:' . $i->created_at . ' | updated_at:' . $i->updated_at . "\n";
}
