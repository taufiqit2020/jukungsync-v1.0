<?php
$content = file_get_contents('app/Http/Controllers/InvoiceController.php');

$search = <<<EOD
    public function destroy(Invoice \$invoice)
    {
        try {
            DB::transaction(function () use (\$invoice) {
                // Kembalikan stok untuk setiap item invoice
                foreach (\$invoice->invoiceItems as \$item) {
                    \$product = Product::lockForUpdate()->find(\$item->product_id);
                    if (\$product) {
                        \$product->stok_saat_ini += \$item->jumlah;
                        \$product->save();
                    }

                    // Hapus inventory movement terkait
                    InventoryMovement::where('product_id', \$item->product_id)
                        ->where('keterangan', 'LIKE', '%' . \$invoice->nomor_invoice . '%')
                        ->where('tipe_pergerakan', 'keluar')
                        ->delete();
                }

                // Hapus semua item invoice
                \$invoice->invoiceItems()->delete();

                // Hapus invoice
                \$invoice->delete();
            });

            return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus dan stok telah dikembalikan.');
        } catch (\Exception \$e) {
            return back()->with('error', 'Gagal menghapus invoice: ' . \$e->getMessage());
        }
    }
EOD;

$replace = <<<EOD
    public function destroy(Invoice \$invoice)
    {
        try {
            DB::transaction(function () use (\$invoice) {
                // Ubah status Inventory Movement menjadi Mutasi Keluar agar bisa ditarik lagi ke invoice jika mau,
                // Stok TIDAK dikembalikan otomatis ke warehouse.
                InventoryMovement::where('keterangan', 'Penjualan Invoice ' . \$invoice->nomor_invoice)
                    ->where('tipe_pergerakan', 'keluar')
                    ->update([
                        'keterangan' => 'Mutasi Keluar (Batal ' . \$invoice->nomor_invoice . ')'
                    ]);

                // Hapus semua item invoice
                \$invoice->invoiceItems()->delete();

                // Hapus invoice
                \$invoice->delete();
            });

            return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus. Item otomatis dikembalikan ke daftar Mutasi Keluar Manual (stok tetap terpotong).');
        } catch (\Exception \$e) {
            return back()->with('error', 'Gagal menghapus invoice: ' . \$e->getMessage());
        }
    }
EOD;

$new_content = str_replace($search, $replace, $content);

if ($new_content === $content) {
    echo "Gagal: String tidak ditemukan!";
} else {
    file_put_contents('app/Http/Controllers/InvoiceController.php', $new_content);
    echo "Sukses mengganti metode destroy.";
}
