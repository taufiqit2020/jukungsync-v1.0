<?php
$b64 = file_get_contents('payload_merks_view.txt');
$content = base64_decode($b64);

// Replace title and strings
$content = str_replace("Data Merk", "Data Customer", $content);
$content = str_replace("merks.", "customers.", $content);
$content = str_replace("merks)", "customers)", $content);
$content = str_replace("\$merks", "\$customers", $content);
$content = str_replace("\$merk", "\$customer", $content);
$content = str_replace("merkData", "customerData", $content);
$content = str_replace("merksData", "customersData", $content);
$content = str_replace("nama_merk", "nama_klien", $content);

// Update table columns
$searchTableHead = <<<EOD
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Customer</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Keterangan</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                </tr>
EOD;
$replaceTableHead = <<<EOD
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">No</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Nama Klien / Instansi</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Kontak</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Alamat & Ket</th>
                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-white uppercase tracking-wider">Aksi</th>
                </tr>
EOD;
$content = str_replace($searchTableHead, $replaceTableHead, $content);

$searchTableBody = <<<EOD
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \$loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ \$customer->nama_klien }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ \$customer->keterangan ?: '-' }}</td>
EOD;
$replaceTableBody = <<<EOD
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \$loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ \$customer->nama_klien }}</td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        @if(\$customer->no_telp) <div>📞 {{ \$customer->no_telp }}</div> @endif
                        @if(\$customer->email) <div>✉️ {{ \$customer->email }}</div> @endif
                        @if(!\$customer->no_telp && !\$customer->email) - @endif
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        @if(\$customer->alamat) <div class="mb-1">📍 {{ \$customer->alamat }}</div> @endif
                        @if(\$customer->keterangan) <div class="text-xs text-gray-500 italic">"{{ \$customer->keterangan }}"</div> @endif
                        @if(!\$customer->alamat && !\$customer->keterangan) - @endif
                    </td>
EOD;
$content = str_replace($searchTableBody, $replaceTableBody, $content);

// Update forms
$searchFormCreate = <<<EOD
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Customer <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_klien" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3 border" required>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Keterangan</label>
                            <textarea name="keterangan" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border"></textarea>
                        </div>
EOD;
$replaceFormCreate = <<<EOD
                        <div class="mb-4">
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nama Klien / Instansi *</label>
                            <input type="text" name="nama_klien" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">No. Telp</label>
                                <input type="text" name="no_telp" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Email</label>
                                <input type="email" name="email" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Alamat Lengkap</label>
                            <textarea name="alamat" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border"></textarea>
                        </div>
                        <div class="mb-5">
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Keterangan / Catatan</label>
                            <textarea name="keterangan" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border"></textarea>
                        </div>
EOD;
$content = str_replace($searchFormCreate, $replaceFormCreate, $content);

$searchFormEdit = <<<EOD
                        <div class="mb-4">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Customer <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_klien" x-model="editData.nama_klien" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3 border" required>
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-gray-700 mb-1">Keterangan</label>
                            <textarea name="keterangan" x-model="editData.keterangan" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border"></textarea>
                        </div>
EOD;
$replaceFormEdit = <<<EOD
                        <div class="mb-4">
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Nama Klien / Instansi *</label>
                            <input type="text" name="nama_klien" x-model="editData.nama_klien" class="w-full rounded-lg border-2 border-gray-200 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2.5 px-3" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">No. Telp</label>
                                <input type="text" name="no_telp" x-model="editData.no_telp" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Email</label>
                                <input type="email" name="email" x-model="editData.email" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Alamat Lengkap</label>
                            <textarea name="alamat" x-model="editData.alamat" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border"></textarea>
                        </div>
                        <div class="mb-5">
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Keterangan / Catatan</label>
                            <textarea name="keterangan" x-model="editData.keterangan" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-tema-marun focus:ring focus:ring-tema-marun focus:ring-opacity-30 text-sm py-2 px-3 border"></textarea>
                        </div>
EOD;
$content = str_replace($searchFormEdit, $replaceFormEdit, $content);

// Update Alpine Data Structure
$searchAlpine = <<<EOD
            editData: { id: '', nama_klien: '', keterangan: '' },
EOD;
$replaceAlpine = <<<EOD
            editData: { id: '', nama_klien: '', no_telp: '', email: '', alamat: '', keterangan: '' },
EOD;
$content = str_replace($searchAlpine, $replaceAlpine, $content);

$searchOpenEdit = <<<EOD
            openEdit(customer) {
                this.editData = {
                    id: customer.id,
                    nama_klien: customer.nama_klien,
                    keterangan: customer.keterangan
                };
EOD;
$replaceOpenEdit = <<<EOD
            openEdit(customer) {
                this.editData = {
                    id: customer.id,
                    nama_klien: customer.nama_klien,
                    no_telp: customer.no_telp,
                    email: customer.email,
                    alamat: customer.alamat,
                    keterangan: customer.keterangan
                };
EOD;
$content = str_replace($searchOpenEdit, $replaceOpenEdit, $content);

if (!is_dir('resources/views/customers')) {
    mkdir('resources/views/customers', 0755, true);
}
file_put_contents('resources/views/customers/index.blade.php', $content);
echo "Customer view created.\n";
