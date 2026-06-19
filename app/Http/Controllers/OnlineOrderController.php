<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineOrderController extends Controller
{
    public function index()
    {
        // Get online invoices, newest first
        $orders = Invoice::with('invoiceItems.product')
            ->where('jenis_transaksi', 'online')
            ->orderByRaw("
                CASE status_pesanan 
                    WHEN 'menunggu_konfirmasi' THEN 1 
                    WHEN 'diproses' THEN 2 
                    WHEN 'selesai' THEN 3 
                    WHEN 'dibatalkan' THEN 4 
                    ELSE 5 
                END
            ")
            ->latest('tanggal_invoice')
            ->latest('id')
            ->paginate(15);
            
        return view('online-orders.index', compact('orders'));
    }

    public function show(Invoice $online_order)
    {
        if ($online_order->jenis_transaksi !== 'online') {
            abort(404);
        }

        $online_order->load('invoiceItems.product.category');
        return view('online-orders.show', compact('online_order'));
    }

    public function approve(Invoice $online_order)
    {
        if ($online_order->jenis_transaksi !== 'online' || $online_order->status_pesanan !== 'menunggu_konfirmasi') {
            return back()->with('error', 'Status pesanan tidak valid untuk disetujui.');
        }

        try {
            DB::transaction(function () use ($online_order) {
                // Deduct stock and create movements
                foreach ($online_order->invoiceItems as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item->product_id);
                    
                    if ($product->stok_saat_ini < $item->jumlah) {
                        throw new \Exception("Stok tidak cukup untuk: {$product->nama_barang}. Sisa: {$product->stok_saat_ini}");
                    }

                    // Deduct stock
                    $product->stok_saat_ini -= $item->jumlah;
                    $product->save();

                    // Create inventory movement
                    InventoryMovement::create([
                        'product_id' => $product->id,
                        'tipe_pergerakan' => 'keluar',
                        'jumlah' => $item->jumlah,
                        'tanggal' => now(),
                        'keterangan' => 'Penjualan Online ' . $online_order->nomor_invoice,
                    ]);
                }

                // Generate official invoice number if it's invoice_30_hari
                $updateData = [
                    'status_pesanan' => 'diproses', // Atau langsung 'selesai' tergantung alur bisnis
                    'tanggal_jatuh_tempo' => now()->addDays(30),
                ];
                if ($online_order->metode_pembayaran === 'invoice_30_hari') {
                    $nextId = $online_order->id;
                    $nomor_invoice = sprintf('%03d/UMAR/%s/%s', $nextId, $this->romanMonth(date('n')), date('Y'));
                    $updateData['nomor_invoice'] = $nomor_invoice;
                }

                // Update status dan set jatuh tempo H+30 sejak disetujui
                $online_order->update($updateData);
            });

            

            // KIRIM NOTIFIKASI WA KE KLIEN
            try {
                $klien = \App\Models\User::find($online_order->klien_id);
                if ($klien && $klien->nomor_hp) {
                    $pesanKlien = "Halo Bapak/Ibu *" . $klien->name . "*,\n\n";
                    $pesanKlien .= "Kabar baik! Pesanan E-Catalog Anda dengan nomor tagihan *" . $online_order->nomor_invoice . "* telah kami terima dan disetujui.\n\n";
                    $pesanKlien .= "Saat ini tim kami sedang menyiapkan dan memproses pesanan Anda untuk segera dikirimkan.\n\n";
                    $pesanKlien .= "Terima kasih banyak atas kepercayaannya berbelanja di PT. Utama Madani Raya. Semoga harinya menyenangkan! ?";

                    \App\Services\FonnteService::sendMessage($klien->nomor_hp, $pesanKlien);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Gagal mengirim WA persetujuan ke Klien: " . $e->getMessage());
            }

            return back()->with('success', 'Pesanan berhasil disetujui dan stok telah dipotong.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function complete(Invoice $online_order)
    {
        if ($online_order->jenis_transaksi !== 'online' || $online_order->status_pesanan !== 'diproses') {
            return back()->with('error', 'Pesanan belum diproses.');
        }

        $online_order->update([
            'status_pesanan' => 'selesai',
            'status_pembayaran' => 'lunas',
        ]);

        // Trigger auto-tier upgrade check
        $user = \App\Models\User::find($online_order->klien_id);
        if ($user) {
            $user->refresh();
            $tierUpgrade = $user->checkAndUpgradeTier();
            if ($tierUpgrade && $user->nomor_hp) {
                try {
                    $totalPembelian = $user->getTotalPembelian();
                    $pesanCustomer  = "Selamat! 🎉 Akun Anda telah diupgrade ke tier *{$tierUpgrade}*\n\n";
                    $pesanCustomer .= "Total pembelian Anda telah mencapai *Rp " . number_format($totalPembelian, 0, ',', '.') . "*.\n";
                    $pesanCustomer .= "Mulai sekarang Anda menikmati keuntungan tier {$tierUpgrade} di E-Catalog PT Utama Madani Raya.\n\n";
                    $pesanCustomer .= "Terima kasih atas kepercayaan Anda! 🙏";
                    \App\Services\FonnteService::sendMessage($user->nomor_hp, $pesanCustomer);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("Gagal kirim WA upgrade tier ke customer: " . $e->getMessage());
                }
            }
        }

        return back()->with('success', 'Pesanan diselesaikan.');
    }

    public function reject(Invoice $online_order)
    {
        if ($online_order->jenis_transaksi !== 'online' || $online_order->status_pesanan === 'selesai' || $online_order->status_pesanan === 'dibatalkan') {
            return back()->with('error', 'Status pesanan tidak valid untuk dibatalkan.');
        }

        // Jika sudah diproses, kembalikan stok
        if ($online_order->status_pesanan === 'diproses') {
            try {
                DB::transaction(function () use ($online_order) {
                    foreach ($online_order->invoiceItems as $item) {
                        $product = Product::lockForUpdate()->find($item->product_id);
                        if ($product) {
                            $product->stok_saat_ini += $item->jumlah;
                            $product->save();

                            // Buat retur stok
                            InventoryMovement::create([
                                'product_id' => $product->id,
                                'tipe_pergerakan' => 'masuk',
                                'jumlah' => $item->jumlah,
                                'tanggal' => now(),
                                'keterangan' => 'Pembatalan Pesanan Online ' . $online_order->nomor_invoice,
                            ]);
                        }
                    }
                    $online_order->update(['status_pesanan' => 'dibatalkan']);
                });
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
            }
        } else {
            // Belum diproses, stok belum berkurang, langsung batalkan
            $online_order->update(['status_pesanan' => 'dibatalkan']);
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    private function romanMonth($month)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[$month] ?? '';
    }
}
