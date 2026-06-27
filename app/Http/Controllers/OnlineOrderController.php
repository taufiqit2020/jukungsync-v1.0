<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Kasbon;
use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OnlineOrderController extends Controller
{
    // ================================================================
    // Daftar nama staf untuk surat jalan
    // ================================================================
    const STAF_SURAT_JALAN = [
        [
            'jabatan' => 'KEPALA OPERASIONAL',
            'nama'    => 'TAUFIQURRAHMAN,S.Kom',
        ],
        [
            'jabatan' => 'KEPALA PEMASARAN & PELAYANAN',
            'nama'    => 'PRIMANANDA CINDINA DAMAYANTI,S.Kom',
        ],
        [
            'jabatan' => 'STAFF PEMASARAN',
            'nama'    => 'MUHAMMAD IHSAN',
        ],
        [
            'jabatan' => 'STAFF ARMADA PT UMAR',
            'nama'    => 'MUHAMMAD',
        ],
    ];

    public function index()
    {
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

        // Kasbon terkait (jika ada)
        $kasbon = Kasbon::where('invoice_id', $online_order->id)->first();

        // Daftar staf untuk pilihan surat jalan
        $stafList = self::STAF_SURAT_JALAN;

        return view('online-orders.show', compact('online_order', 'kasbon', 'stafList'));
    }

    // ================================================================
    // APPROVE – Terima & Proses Pesanan
    // ================================================================
    public function approve(Invoice $online_order)
    {
        if ($online_order->jenis_transaksi !== 'online' || $online_order->status_pesanan !== 'menunggu_konfirmasi') {
            return back()->with('error', 'Status pesanan tidak valid untuk disetujui.');
        }

        try {
            DB::transaction(function () use ($online_order) {
                foreach ($online_order->invoiceItems as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item->product_id);
                    
                    if ($product->stok_saat_ini < $item->jumlah) {
                        throw new \Exception("Stok tidak cukup untuk: {$product->nama_barang}. Sisa: {$product->stok_saat_ini}");
                    }

                    $product->stok_saat_ini -= $item->jumlah;
                    $product->save();

                    InventoryMovement::create([
                        'product_id'       => $product->id,
                        'tipe_pergerakan'  => 'keluar',
                        'jumlah'           => $item->jumlah,
                        'tanggal'          => now(),
                        'keterangan'       => 'Penjualan Online ' . $online_order->nomor_invoice,
                    ]);
                }

                $updateData = [
                    'status_pesanan'       => 'diproses',
                    'tanggal_jatuh_tempo'  => now()->addDays(30),
                ];

                if ($online_order->metode_pembayaran === 'invoice_30_hari') {
                    $nextId        = $online_order->id;
                    $nomor_invoice = Invoice::generateDynamicNumber($online_order->nama_klien, $nextId);
                    $updateData['nomor_invoice'] = $nomor_invoice;
                }

                $online_order->update($updateData);
            });

            // Kirim notifikasi WA ke klien
            try {
                $klien = \App\Models\User::find($online_order->klien_id);
                if ($klien && $klien->nomor_hp) {
                    $pesan  = "Halo Bapak/Ibu *{$klien->name}*,\n\n";
                    $pesan .= "Pesanan E-Catalog Anda dengan nomor *{$online_order->nomor_invoice}* telah disetujui.\n";
                    $pesan .= "Tim kami sedang menyiapkan pesanan Anda. Terima kasih! 🙏";
                    \App\Services\FonnteService::sendMessage($klien->nomor_hp, $pesan);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Gagal WA approve: ' . $e->getMessage());
            }

            return back()->with('success', 'Pesanan berhasil disetujui dan stok telah dipotong.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // ================================================================
    // COMPLETE PAID – Tandai Selesai & Lunas
    // ================================================================
    public function completePaid(Request $request, Invoice $online_order)
    {
        if ($online_order->jenis_transaksi !== 'online' || $online_order->status_pesanan !== 'diproses') {
            return back()->with('error', 'Pesanan belum diproses atau sudah selesai.');
        }

        $online_order->update([
            'status_pesanan'    => 'selesai',
            'status_pembayaran' => 'lunas',
        ]);

        // Trigger auto-tier upgrade
        $this->checkTierUpgrade($online_order->klien_id);

        // Notif WA ke klien
        try {
            $klien = \App\Models\User::find($online_order->klien_id);
            if ($klien && $klien->nomor_hp) {
                $pesan  = "Halo Bapak/Ibu *{$klien->name}*,\n\n";
                $pesan .= "✅ Pesanan *{$online_order->nomor_invoice}* telah selesai dan pembayaran tercatat *LUNAS*.\n";
                $pesan .= "Terima kasih atas kepercayaan Anda berbelanja di PT. Utama Madani Raya! 🙏";
                \App\Services\FonnteService::sendMessage($klien->nomor_hp, $pesan);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal WA complete-paid: ' . $e->getMessage());
        }

        return back()->with('success', 'Pesanan ditandai Selesai & Lunas.');
    }

    // ================================================================
    // COMPLETE UNPAID – Tandai Selesai & Belum Lunas → Masuk Kasbon
    // ================================================================
    public function completeUnpaid(Request $request, Invoice $online_order)
    {
        if ($online_order->jenis_transaksi !== 'online' || $online_order->status_pesanan !== 'diproses') {
            return back()->with('error', 'Pesanan belum diproses atau sudah selesai.');
        }

        $nominal_dibayar = $request->input('nominal_dibayar', 0);
        $sisa_tagihan = $online_order->total_tagihan - $nominal_dibayar;

        if ($nominal_dibayar > $online_order->total_tagihan) {
            return back()->with('error', 'Nominal dibayar tidak boleh lebih dari total tagihan.');
        }

        DB::transaction(function () use ($online_order, $request, $nominal_dibayar, $sisa_tagihan) {
            $status_pembayaran = $sisa_tagihan <= 0 ? 'lunas' : 'belum_lunas';

            $online_order->update([
                'status_pesanan'    => 'selesai',
                'status_pembayaran' => $status_pembayaran,
            ]);

            // Jika ada sisa tagihan, buat entri Kasbon
            if ($sisa_tagihan > 0) {
                Kasbon::updateOrCreate(
                    ['invoice_id' => $online_order->id],
                    [
                        'klien_id'       => $online_order->klien_id,
                        'nama_klien'     => $online_order->nama_klien,
                        'nomor_invoice'  => $online_order->nomor_invoice,
                        'total_tagihan'  => $online_order->total_tagihan,
                        'jumlah_dibayar' => $nominal_dibayar,
                        'sisa_tagihan'   => $sisa_tagihan,
                        'status'         => 'belum_lunas',
                        'tanggal_kasbon' => now()->toDateString(),
                        'keterangan'     => $request->input('keterangan_kasbon', 'Kasbon dari pesanan online ' . $online_order->nomor_invoice . ($nominal_dibayar > 0 ? " (DP: Rp " . number_format($nominal_dibayar, 0, ',', '.') . ")" : "")),
                    ]
                );
            }
        });

        // Notif WA ke klien
        try {
            $klien = \App\Models\User::find($online_order->klien_id);
            if ($klien && $klien->nomor_hp) {
                $pesan  = "Halo Bapak/Ibu *{$klien->name}*,\n\n";
                $pesan .= "📦 Pesanan *{$online_order->nomor_invoice}* telah selesai.\n";
                if ($nominal_dibayar > 0) {
                    $pesan .= "💰 Pembayaran diterima: *Rp " . number_format($nominal_dibayar, 0, ',', '.') . "*\n";
                }
                if ($sisa_tagihan > 0) {
                    $pesan .= "💳 Sisa tagihan sebesar *Rp " . number_format($sisa_tagihan, 0, ',', '.') . "* dicatat sebagai *kasbon*.\n";
                    $pesan .= "Mohon segera diselesaikan pembayarannya. Terima kasih! 🙏";
                } else {
                    $pesan .= "✅ Pembayaran telah LUNAS. Terima kasih! 🙏";
                }
                \App\Services\FonnteService::sendMessage($klien->nomor_hp, $pesan);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Gagal WA complete-unpaid: ' . $e->getMessage());
        }

        return back()->with('success', 'Pesanan ditandai Selesai & Kasbon berhasil dicatat.');
    }

    // ================================================================
    // SURAT JALAN – Halaman print surat jalan
    // ================================================================
    public function suratJalan(Request $request, Invoice $online_order)
    {
        if ($online_order->jenis_transaksi !== 'online') {
            abort(404);
        }

        $online_order->load('invoiceItems.product.category');

        // Ambil pilihan staf dari request (setelah user pilih dari modal)
        $stafPengantar  = $request->input('staf_pengantar');
        $stafPenerima   = $request->input('staf_penerima');

        // Cari detail staf dari array konstanta
        $selectedPengantar = collect(self::STAF_SURAT_JALAN)
            ->firstWhere('nama', $stafPengantar);
        $selectedPenerima  = collect(self::STAF_SURAT_JALAN)
            ->firstWhere('nama', $stafPenerima);

        $stafList = self::STAF_SURAT_JALAN;

        return view('online-orders.surat-jalan', compact(
            'online_order',
            'stafList',
            'selectedPengantar',
            'selectedPenerima'
        ));
    }

    // ================================================================
    // COMPLETE (method lama – keep backward compat)
    // ================================================================
    public function complete(Invoice $online_order)
    {
        return $this->completePaid(request(), $online_order);
    }

    // ================================================================
    // REJECT – Batalkan Pesanan
    // ================================================================
    public function reject(Invoice $online_order)
    {
        if ($online_order->jenis_transaksi !== 'online'
            || $online_order->status_pesanan === 'selesai'
            || $online_order->status_pesanan === 'dibatalkan') {
            return back()->with('error', 'Status pesanan tidak valid untuk dibatalkan.');
        }

        if ($online_order->status_pesanan === 'diproses') {
            try {
                DB::transaction(function () use ($online_order) {
                    foreach ($online_order->invoiceItems as $item) {
                        $product = Product::lockForUpdate()->find($item->product_id);
                        if ($product) {
                            $product->stok_saat_ini += $item->jumlah;
                            $product->save();

                            InventoryMovement::create([
                                'product_id'       => $product->id,
                                'tipe_pergerakan'  => 'masuk',
                                'jumlah'           => $item->jumlah,
                                'tanggal'          => now(),
                                'keterangan'       => 'Pembatalan Pesanan Online ' . $online_order->nomor_invoice,
                            ]);
                        }
                    }
                    $online_order->update(['status_pesanan' => 'dibatalkan']);
                });
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
            }
        } else {
            $online_order->update(['status_pesanan' => 'dibatalkan']);
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // ================================================================
    // HELPERS
    // ================================================================
    private function checkTierUpgrade(int $klienId): void
    {
        $user = \App\Models\User::find($klienId);
        if (!$user) return;

        $user->refresh();
        $tierUpgrade = $user->checkAndUpgradeTier();
        if ($tierUpgrade && $user->nomor_hp) {
            try {
                $total = $user->getTotalPembelian();
                $pesan  = "Selamat! 🎉 Akun Anda diupgrade ke tier *{$tierUpgrade}*\n\n";
                $pesan .= "Total pembelian Anda: *Rp " . number_format($total, 0, ',', '.') . "*\n";
                $pesan .= "Nikmati keuntungan tier {$tierUpgrade} di E-Catalog PT Utama Madani Raya. Terima kasih! 🙏";
                \App\Services\FonnteService::sendMessage($user->nomor_hp, $pesan);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::warning('Gagal WA tier upgrade: ' . $e->getMessage());
            }
        }
    }

    private function romanMonth($month): string
    {
        $map = [
            1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',
            7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'
        ];
        return $map[$month] ?? '';
    }
}
