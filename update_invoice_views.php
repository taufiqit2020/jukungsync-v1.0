<?php
// Update index.blade.php (Create Modal)
$fileIndex = 'resources/views/invoices/index.blade.php';
$contentIndex = file_get_contents($fileIndex);

$searchKlienIndex = <<<EOD
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Nama Klien / Instansi *</label>
                                <input type="text" name="nama_klien" value="{{ old('nama_klien') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" required placeholder="Contoh: RSU ALMANSYUR MEDIKA">
                            </div>
EOD;

$replaceKlienIndex = <<<EOD
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
$contentIndex = str_replace($searchKlienIndex, $replaceKlienIndex, $contentIndex);
file_put_contents($fileIndex, $contentIndex);


// Update edit.blade.php (Edit Page)
$fileEdit = 'resources/views/invoices/edit.blade.php';
$contentEdit = file_get_contents($fileEdit);

$searchKlienEdit = <<<EOD
                    <div class="lg:col-span-2">
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nama Klien / Instansi *</label>
                        <input type="text" name="nama_klien" value="{{ old('nama_klien', \$invoice->nama_klien) }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                    </div>
EOD;

$replaceKlienEdit = <<<EOD
                    <div class="lg:col-span-2">
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nama Klien / Instansi *</label>
                        <input type="text" name="nama_klien" list="customer-list" value="{{ old('nama_klien', \$invoice->nama_klien) }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required autocomplete="off" placeholder="Pilih atau Ketik Nama Klien Baru...">
                        <datalist id="customer-list">
                            @foreach(\$customers as \$customer)
                                <option value="{{ \$customer->nama_klien }}"></option>
                            @endforeach
                        </datalist>
                    </div>
EOD;
$contentEdit = str_replace($searchKlienEdit, $replaceKlienEdit, $contentEdit);
file_put_contents($fileEdit, $contentEdit);

echo "Views updated with datalist.\n";
