<?php
$file = 'resources/views/invoices/index.blade.php';
$content = file_get_contents($file);

$search = <<<EOD
            <div class="mb-4">
                <label for="nama_klien" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Klien / Instansi <span class="text-red-500">*</span></label>
                <input type="text" name="nama_klien" id="nama_klien" class="w-full rounded border-gray-300 focus:border-tema-marun focus:ring focus:ring-red-200 text-sm" placeholder="Contoh: RSU ALMANSYUR MEDIKA" required>
            </div>
EOD;

$replace = <<<EOD
            <div class="mb-4">
                <label for="nama_klien" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Klien / Instansi <span class="text-red-500">*</span></label>
                <select name="nama_klien" id="nama_klien" class="w-full rounded border-gray-300 focus:border-tema-marun focus:ring focus:ring-red-200 text-sm" required>
                    <option value="">-- Pilih Customer dari Master Data --</option>
                    @foreach(\$customers as \$customer)
                        <option value="{{ \$customer->nama_klien }}">{{ \$customer->nama_klien }}</option>
                    @endforeach
                </select>
                <p class="text-[10px] text-gray-500 mt-1">Data diambil otomatis dari menu Master Data Customer.</p>
            </div>
EOD;

if (strpos($content, 'Pilih Customer dari Master Data') === false) {
    $content = str_replace($search, $replace, $content);
    file_put_contents($file, $content);
    echo "Invoice view updated\n";
} else {
    echo "Invoice view already updated\n";
}
