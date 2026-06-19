<?php
$file = 'app/Http/Controllers/InventoryMovementController.php';
$content = file_get_contents($file);

$search = <<<EOD
            'items.*.jumlah' => 'required|integer|min:1',
        ]);

        try {
EOD;

$replace = <<<EOD
            'items.*.jumlah' => 'required|integer|min:1',
            'customer' => 'nullable|string'
        ]);

        if (!empty(\$request->customer)) {
            \$validated['keterangan'] = '[' . \$request->customer . '] ' . (\$validated['keterangan'] ?? 'Mutasi Manual');
        }

        try {
EOD;

if (strpos($content, '$validated[\'keterangan\'] = \'[\' . $request->customer') === false) {
    $content = str_replace($search, $replace, $content);
    file_put_contents($file, $content);
    echo "InventoryMovementController store updated\n";
} else {
    echo "Already updated\n";
}
