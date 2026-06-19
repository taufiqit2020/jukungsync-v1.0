<?php
// 1. Update index.blade.php
$fileIndex = 'resources/views/invoices/index.blade.php';
$contentIndex = file_get_contents($fileIndex);

// Add CSS
$cssSearch = "</style>";
$cssReplace = <<<EOD
    .ts-wrapper .ts-control .item {
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        max-width: 100% !important;
        display: block !important;
    }
</style>
EOD;
$contentIndex = str_replace($cssSearch, $cssReplace, $contentIndex);

// Update Grid
$gridSearch = <<<EOD
                        <!-- Info Faktur - Compact -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5 bg-gray-50 p-4 rounded-xl border border-gray-200">
EOD;
$gridReplace = <<<EOD
                        <!-- Info Faktur - Compact -->
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3 mb-5 bg-gray-50 p-4 rounded-xl border border-gray-200">
EOD;
$contentIndex = str_replace($gridSearch, $gridReplace, $contentIndex);

$dateSearch = <<<EOD
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Tanggal *</label>
                                <input type="date" name="tanggal_invoice" x-model="tanggalInvoice" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" required>
                            </div>
                        </div>
EOD;
$dateReplace = <<<EOD
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider">Tanggal Invoice *</label>
                                <input type="date" name="tanggal_invoice" x-model="tanggalInvoice" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" required>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1 uppercase tracking-wider" title="Otomatis +30 Hari">Jatuh Tempo *</label>
                                <input type="date" name="tanggal_jatuh_tempo" x-model="tanggalJatuhTempo" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border" required>
                            </div>
                        </div>
EOD;
$contentIndex = str_replace($dateSearch, $dateReplace, $contentIndex);

// Add default data to alpine
$alpineSearch = <<<EOD
            tanggalInvoice: new Date().toISOString().split('T')[0],
EOD;
$alpineReplace = <<<EOD
            tanggalInvoice: new Date().toISOString().split('T')[0],
            tanggalJatuhTempo: new Date(new Date().setDate(new Date().getDate() + 30)).toISOString().split('T')[0],
EOD;
$contentIndex = str_replace($alpineSearch, $alpineReplace, $contentIndex);

file_put_contents($fileIndex, $contentIndex);

// 2. Update InvoiceController.php
$fileCtrl = 'app/Http/Controllers/InvoiceController.php';
$contentCtrl = file_get_contents($fileCtrl);

$validSearch = <<<EOD
            'tanggal_invoice' => 'required|date',
            'items' => 'required|array|min:1',
EOD;
$validReplace = <<<EOD
            'tanggal_invoice' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'items' => 'required|array|min:1',
EOD;
$contentCtrl = str_replace($validSearch, $validReplace, $contentCtrl);

$createSearch = <<<EOD
                // Create temporary invoice to get ID
                \$invoice = Invoice::create([
                    'nomor_invoice' => \$request->nomor_invoice,
                    'nama_klien' => \$request->nama_klien,
                    'tanggal_invoice' => \$request->tanggal_invoice,
                    'tanggal_jatuh_tempo' => \Carbon\Carbon::parse(\$request->tanggal_invoice)->addDays(30),
EOD;
$createReplace = <<<EOD
                // Create temporary invoice to get ID
                \$invoice = Invoice::create([
                    'nomor_invoice' => \$request->nomor_invoice,
                    'nama_klien' => \$request->nama_klien,
                    'tanggal_invoice' => \$request->tanggal_invoice,
                    'tanggal_jatuh_tempo' => \$request->tanggal_jatuh_tempo,
EOD;
$contentCtrl = str_replace($createSearch, $createReplace, $contentCtrl);

file_put_contents($fileCtrl, $contentCtrl);
echo "Frontend and Backend Updated.\n";
