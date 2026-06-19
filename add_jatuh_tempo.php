<?php
$file = 'resources/views/invoices/edit.blade.php';
$content = file_get_contents($file);

$searchGrid = <<<EOD
                <!-- Info Faktur -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">No. Invoice *</label>
                        <input type="text" name="nomor_invoice" value="{{ old('nomor_invoice', \$invoice->nomor_invoice) }}" class="w-full rounded-lg border-2 border-yellow-400 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-400 focus:ring-opacity-30 text-sm py-2.5 px-3 bg-white font-bold" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nama Klien / Instansi *</label>
                        <input type="text" name="nama_klien" value="{{ old('nama_klien', \$invoice->nama_klien) }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Tanggal Invoice *</label>
                        <input type="date" name="tanggal_invoice" value="{{ old('tanggal_invoice', \$invoice->tanggal_invoice) }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Status Pembayaran *</label>
                        <select name="status_pembayaran" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3">
                            <option value="belum_lunas" {{ old('status_pembayaran', \$invoice->status_pembayaran) === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="lunas" {{ old('status_pembayaran', \$invoice->status_pembayaran) === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                </div>
EOD;

$replaceGrid = <<<EOD
                <!-- Info Faktur -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">No. Invoice *</label>
                        <input type="text" name="nomor_invoice" value="{{ old('nomor_invoice', \$invoice->nomor_invoice) }}" class="w-full rounded-lg border-2 border-yellow-400 shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-400 focus:ring-opacity-30 text-sm py-2.5 px-3 bg-white font-bold" required>
                    </div>
                    <div class="lg:col-span-2">
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nama Klien / Instansi *</label>
                        <input type="text" name="nama_klien" value="{{ old('nama_klien', \$invoice->nama_klien) }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Tanggal Invoice *</label>
                        <input type="date" name="tanggal_invoice" value="{{ old('tanggal_invoice', \$invoice->tanggal_invoice) }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Tanggal Jatuh Tempo *</label>
                        <input type="date" name="tanggal_jatuh_tempo" value="{{ old('tanggal_jatuh_tempo', \$invoice->tanggal_jatuh_tempo) }}" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Status Pembayaran *</label>
                        <select name="status_pembayaran" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3">
                            <option value="belum_lunas" {{ old('status_pembayaran', \$invoice->status_pembayaran) === 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="lunas" {{ old('status_pembayaran', \$invoice->status_pembayaran) === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>
                </div>
EOD;

$content = str_replace($searchGrid, $replaceGrid, $content);

file_put_contents($file, $content);

$fileCtrl = 'app/Http/Controllers/InvoiceController.php';
$contentCtrl = file_get_contents($fileCtrl);

$searchUpdate = <<<EOD
    public function update(Request \$request, Invoice \$invoice)
    {
        \$request->validate([
            'nomor_invoice' => 'required|string|unique:invoices,nomor_invoice,' . \$invoice->id,
            'nama_klien' => 'required|string|max:255',
            'tanggal_invoice' => 'required|date',
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
        ]);

        \$invoice->update([
            'nomor_invoice' => \$request->nomor_invoice,
            'nama_klien' => \$request->nama_klien,
            'tanggal_invoice' => \$request->tanggal_invoice,
            'status_pembayaran' => \$request->status_pembayaran,
        ]);
EOD;

$replaceUpdate = <<<EOD
    public function update(Request \$request, Invoice \$invoice)
    {
        \$request->validate([
            'nomor_invoice' => 'required|string|unique:invoices,nomor_invoice,' . \$invoice->id,
            'nama_klien' => 'required|string|max:255',
            'tanggal_invoice' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
        ]);

        \$invoice->update([
            'nomor_invoice' => \$request->nomor_invoice,
            'nama_klien' => \$request->nama_klien,
            'tanggal_invoice' => \$request->tanggal_invoice,
            'tanggal_jatuh_tempo' => \$request->tanggal_jatuh_tempo,
            'status_pembayaran' => \$request->status_pembayaran,
        ]);
EOD;

$contentCtrl = str_replace($searchUpdate, $replaceUpdate, $contentCtrl);

file_put_contents($fileCtrl, $contentCtrl);
echo "Jatuh tempo added.\n";
