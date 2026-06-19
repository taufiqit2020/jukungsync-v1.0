<?php
$file = 'resources/views/invoices/index.blade.php';
$content = file_get_contents($file);

$search = <<<EOD
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Nama Klien / Instansi *</label>
                                <input type="text" name="nama_klien" list="customer-list" value="{{ old('nama_klien') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" required autocomplete="off" placeholder="Pilih atau Ketik Nama Klien Baru...">
                                <datalist id="customer-list">
                                    @foreach(\$customers as \$customer)
                                        <option value="{{ \$customer->nama_klien }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
EOD;

$replace = <<<EOD
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Nama Klien / Instansi *</label>
                                <select name="nama_klien" id="nama_klien" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border bg-white" required>
                                    <option value="">-- Pilih Customer / Klien --</option>
                                    @foreach(\$customers as \$customer)
                                        <option value="{{ \$customer->nama_klien }}">{{ \$customer->nama_klien }}</option>
                                    @endforeach
                                </select>
                            </div>
EOD;

if (strpos($content, '<select name="nama_klien"') === false) {
    $content = str_replace($search, $replace, $content);
    file_put_contents($file, $content);
    echo "Invoice view updated to select\n";
} else {
    echo "Already select\n";
}
