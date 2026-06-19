<?php
$file = 'app/Http/Controllers/InvoiceController.php';
$content = file_get_contents($file);

// 1. Validasi tambahan
$searchVal = <<<EOD
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
EOD;
$replaceVal = <<<EOD
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.movement_id' => 'nullable|exists:inventory_movements,id',
EOD;
$content = str_replace($searchVal, $replaceVal, $content);


// 2. Remove old convert_movement_ids block
$searchOldBlock = <<<EOD
                // Handle conversion of manual movements to prevent double deduction
                if (\$request->has('convert_movement_ids')) {
                    foreach (\$request->convert_movement_ids as \$mov_id) {
                        \$mov = InventoryMovement::find(\$mov_id);
                        if (\$mov && \$mov->tipe_pergerakan === 'keluar') {
                            \$product = Product::lockForUpdate()->find(\$mov->product_id);
                            if (\$product) {
                                // Restore stock temporarily
                                \$product->stok_saat_ini += \$mov->jumlah;
                                \$product->save();
                            }
                            // Delete the original manual movement
                            \$mov->delete();
                        }
                    }
                }
EOD;
$content = str_replace($searchOldBlock, '', $content);


// 3. Update the item loop to handle partial conversions
$searchItemLoop = <<<EOD
                foreach (\$request->items as \$item) {
                    \$product = Product::lockForUpdate()->findOrFail(\$item['product_id']);
EOD;

$replaceItemLoop = <<<EOD
                foreach (\$request->items as \$item) {
                    // Cek jika item berasal dari tarikan Mutasi Keluar Manual
                    if (isset(\$item['movement_id']) && !empty(\$item['movement_id'])) {
                        \$mov = InventoryMovement::find(\$item['movement_id']);
                        if (\$mov && \$mov->tipe_pergerakan === 'keluar') {
                            if (\$mov->jumlah <= \$item['jumlah']) {
                                // Konversi penuh: hapus pergerakan manual lama dan pulihkan stok sementara agar bisa dipotong lagi oleh Invoice
                                \$product = Product::lockForUpdate()->find(\$mov->product_id);
                                if (\$product) {
                                    \$product->stok_saat_ini += \$mov->jumlah;
                                    \$product->save();
                                }
                                \$mov->delete();
                            } else {
                                // Konversi parsial (Split): kurangi jumlah pada pergerakan manual lama
                                \$mov->jumlah -= \$item['jumlah'];
                                \$mov->save();
                                
                                // Pulihkan stok HANYA sebesar jumlah yang masuk ke invoice, agar bisa dipotong lagi oleh Invoice
                                \$product = Product::lockForUpdate()->find(\$mov->product_id);
                                if (\$product) {
                                    \$product->stok_saat_ini += \$item['jumlah'];
                                    \$product->save();
                                }
                            }
                        }
                    }

                    \$product = Product::lockForUpdate()->findOrFail(\$item['product_id']);
EOD;

$content = str_replace($searchItemLoop, $replaceItemLoop, $content);

file_put_contents($file, $content);
echo "Backend update completed.\n";
