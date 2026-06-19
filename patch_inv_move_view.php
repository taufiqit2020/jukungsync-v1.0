<?php
$file = 'resources/views/inventory-movements/create.blade.php';
$content = file_get_contents($file);

$search = <<<EOD
            <div class="mb-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" placeholder="Contoh: Tambahan stok dari supplier XYZ"></textarea>
            </div>
EOD;

$replace = <<<EOD
            <div class="mb-4">
                <label for="customer" class="block text-sm font-medium text-gray-700 mb-1">Customer / Klien (Opsional)</label>
                <select name="customer" id="customer" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border">
                    <option value="">-- Pilih Customer --</option>
                    @foreach(\$customers as \$customer)
                        <option value="{{ \$customer->nama_klien }}">{{ \$customer->nama_klien }}</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-gray-500 mt-1">Jika dipilih, nama customer akan otomatis ditambahkan ke Keterangan.</p>
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-50 py-2 px-3 border" placeholder="Contoh: Tambahan stok dari supplier XYZ"></textarea>
            </div>
EOD;

if (strpos($content, 'Customer / Klien (Opsional)') === false) {
    $content = str_replace($search, $replace, $content);
    file_put_contents($file, $content);
    echo "Inventory movement view updated\n";
} else {
    echo "Inventory movement view already updated\n";
}
