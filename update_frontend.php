<?php
$file = 'resources/views/invoices/index.blade.php';
$content = file_get_contents($file);

// 1. Remove the global hidden inputs loop
$search1 = <<<EOD
                        <!-- Hidden inputs untuk ID pergerakan stok yang ditarik -->
                        <template x-for="movId in convertedMovementIds" :key="movId">
                            <input type="hidden" name="convert_movement_ids[]" :value="movId">
                        </template>
EOD;
$content = str_replace($search1, '', $content);

// 2. Add hidden input inside the items loop template
$search2 = <<<EOD
                                    <template x-for="(item, index) in items" :key="item.id">
                                        <tr class="hover:bg-amber-50 transition-colors">
EOD;
$replace2 = <<<EOD
                                    <template x-for="(item, index) in items" :key="item.id">
                                        <tr class="hover:bg-amber-50 transition-colors">
                                            <template x-if="item.movement_id">
                                                <input type="hidden" :name="'items['+index+'][movement_id]'" :value="item.movement_id">
                                            </template>
EOD;
$content = str_replace($search2, $replace2, $content);

// 3. Update AlpineJS items push to include movement_id
$search3 = <<<EOD
                    this.items.push({
                        id: this.nextId++,
                        product_id: m.product_id,
                        jumlah: m.jumlah,
                        harga_jual: m.product ? m.product.harga_jual : 0,
                        subtotal: (m.product ? m.product.harga_jual : 0) * m.jumlah,
                        ts: null
                    });
EOD;
$replace3 = <<<EOD
                    this.items.push({
                        id: this.nextId++,
                        product_id: m.product_id,
                        jumlah: m.jumlah,
                        harga_jual: m.product ? m.product.harga_jual : 0,
                        subtotal: (m.product ? m.product.harga_jual : 0) * m.jumlah,
                        ts: null,
                        movement_id: m.id
                    });
EOD;
$content = str_replace($search3, $replace3, $content);

// 4. Update AlpineJS removeItem to return movement_id to the pool
$search4 = <<<EOD
            removeItem(index) {
                if(this.items.length > 1) {
                    let item = this.items[index];
                    if(item.ts) item.ts.destroy();
                    this.items.splice(index, 1);
                }
            },
EOD;
$replace4 = <<<EOD
            removeItem(index) {
                if(this.items.length > 1) {
                    let item = this.items[index];
                    if(item.ts) item.ts.destroy();
                    if(item.movement_id) {
                        this.convertedMovementIds = this.convertedMovementIds.filter(id => id !== item.movement_id);
                        this.fetchManualMovements(this.tanggalInvoice);
                    }
                    this.items.splice(index, 1);
                }
            },
EOD;
$content = str_replace($search4, $replace4, $content);

// 5. Update addItem to include movement_id: null
$search5 = <<<EOD
            addItem() {
                this.items.push({ id: this.nextId++, product_id: '', jumlah: 1, harga_jual: 0, subtotal: 0, ts: null });
            },
EOD;
$replace5 = <<<EOD
            addItem() {
                this.items.push({ id: this.nextId++, product_id: '', jumlah: 1, harga_jual: 0, subtotal: 0, ts: null, movement_id: null });
            },
EOD;
$content = str_replace($search5, $replace5, $content);

// 6. Fix default items array init
$search6 = <<<EOD
            items: [
                { id: 1, product_id: '', jumlah: 1, harga_jual: 0, subtotal: 0, ts: null }
            ],
EOD;
$replace6 = <<<EOD
            items: [
                { id: 1, product_id: '', jumlah: 1, harga_jual: 0, subtotal: 0, ts: null, movement_id: null }
            ],
EOD;
$content = str_replace($search6, $replace6, $content);

file_put_contents($file, $content);
echo "Frontend update completed.\n";
