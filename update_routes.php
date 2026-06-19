<?php
$file = 'routes/web.php';
$content = file_get_contents($file);

$useSearch = "use App\Http\Controllers\MerkController;";
$useReplace = "use App\Http\Controllers\MerkController;\nuse App\Http\Controllers\CustomerController;";
$content = str_replace($useSearch, $useReplace, $content);

$routeSearch = "Route::resource('merks', MerkController::class)->except(['create', 'show', 'edit']);";
$routeReplace = "Route::resource('merks', MerkController::class)->except(['create', 'show', 'edit']);\n    Route::resource('customers', CustomerController::class)->except(['create', 'show', 'edit']);";
$content = str_replace($routeSearch, $routeReplace, $content);

file_put_contents($file, $content);
echo "Routes updated.\n";
