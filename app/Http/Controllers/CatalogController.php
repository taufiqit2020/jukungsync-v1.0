<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        
        // Selalu ambil seluruh produk agar pencarian instan sisi klien berjalan sempurna
        $products = Product::with('category')
            ->orderBy('nama_barang', 'asc')
            ->get();
            
        // Group products by category
        $groupedProducts = $products->groupBy(function($product) {
            return $product->category ? $product->category->nama_kategori : 'Tanpa Kategori';
        })->sortBy(function ($items, $key) {
            // Put 'Tanpa Kategori' at the end
            return $key === 'Tanpa Kategori' ? 1 : 0;
        });

        return view('catalog.index', compact('groupedProducts', 'search'));
    }

    public function checkout()
    {
        $user = auth()->user()->fresh(); // Selalu ambil data terbaru dari DB
        $invoiceBlocked = $user->canUseInvoice30() && $user->hasBlockedInvoice();
        return view('catalog.checkout', compact('user', 'invoiceBlocked'));
    }

    public function storeOrder(Request $request)
    {
        $request->validate([
            'items'                   => 'required|array',
            'items.*.product_id'      => 'required|exists:products,id',
            'items.*.qty'             => 'required|integer|min:1',
            'alamat_pengiriman'       => 'required|string',
            'ekspedisi'               => 'required|string',
            'catatan_pengiriman'      => 'nullable|string',
            'metode_pembayaran'       => 'required|string|in:tunai,transfer,invoice_30_hari',
            'ongkir'                  => 'nullable|numeric|min:0',
        ]);

        // Validasi: hanya Premium yang boleh pakai Invoice 30 Hari
        $user = auth()->user()->fresh(); // Pastikan data user terbaru
        if ($request->metode_pembayaran === 'invoice_30_hari' && !$user->canUseInvoice30()) {
            return response()->json([
                'success' => false,
                'message' => 'Metode pembayaran Invoice 30 Hari hanya tersedia untuk pelanggan Premium.',
            ], 422);
        }

        // Validasi: pelanggan Premium yang punya invoice jatuh tempo lewat 3 hari (belum lunas)
        // tidak boleh menggunakan metode Invoice 30 Hari sampai invoice tersebut dilunasi
        if ($request->metode_pembayaran === 'invoice_30_hari' && $user->hasBlockedInvoice()) {
            return response()->json([
                'success' => false,
                'message' => 'Akses metode Invoice 30 Hari Anda diblokir sementara karena terdapat invoice yang telah melewati jatuh tempo lebih dari 3 hari dan belum dilunasi. Silakan lunasi terlebih dahulu atau pilih metode Tunai / Transfer.',
            ], 422);
        }

        DB::beginTransaction();
        try {
            $tierLabel   = $user->getTierLabel();
            $diskonRate  = $user->getDiskonRate();

            // Buat Draft Invoice
            $invoice = Invoice::create([
                'nomor_invoice'      => 'ORD-' . strtoupper(uniqid()),
                'klien_id'           => $user->id,
                'tanggal_invoice'    => now(),
                'nama_klien'         => $user->name,
                'sub_total'          => 0,
                'pajak_ppn'          => 0,
                'total_tagihan'      => 0,
                'jenis_transaksi'    => 'online',
                'status_pesanan'     => 'menunggu_konfirmasi',
                'catatan'            => 'Pesanan E-Catalog dari Customer: ' . $user->name . ' (' . $user->email . ') - Tier: ' . $tierLabel,
                'status_pembayaran'  => 'belum_lunas',
                'alamat_pengiriman'  => $request->alamat_pengiriman,
                'ekspedisi'          => $request->ekspedisi,
                'catatan_pengiriman' => $request->catatan_pengiriman,
                'metode_pembayaran'  => $request->metode_pembayaran,
            ]);

            $subtotal    = 0;
            $totalDiskon = 0;

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Pastikan stok cukup
                if ($product->stok_saat_ini < $item['qty']) {
                    throw new \Exception("Stok {$product->nama_barang} tidak mencukupi. Sisa stok: {$product->stok_saat_ini}");
                }

                // === LOGIKA HARGA 3 TIER ===
                // Gunakan helper getFinalPrice() dari User model
                $hargaBerlaku  = $user->getFinalPrice(
                    (float) $product->harga_jual,
                    (float) ($product->harga_grosir ?? 0),
                    (int)   $item['qty']
                );

                // Hitung selisih diskon untuk laporan
                $hargaSebelumDiskon = ($user->isEligibleGrosir((int) $item['qty']) && $product->harga_grosir > 0)
                    ? (float) $product->harga_grosir
                    : (float) $product->harga_jual;
                $diskonPerItem = ($hargaSebelumDiskon - $hargaBerlaku) * $item['qty'];
                $totalDiskon  += $diskonPerItem;

                $totalHarga = $hargaBerlaku * $item['qty'];
                $subtotal  += $totalHarga;

                InvoiceItem::create([
                    'invoice_id'             => $invoice->id,
                    'product_id'             => $product->id,
                    'jumlah'                 => $item['qty'],
                    'harga_jual_snapshot'    => $hargaBerlaku,
                    'total_harga'            => $totalHarga,
                    'harga_modal_snapshot'   => $product->harga_modal,
                ]);
            }

            // Update subtotal, diskon, dan total tagihan
            $pajakPpn = $subtotal * 0.11;
            $ongkir = (float) $request->input('ongkir', 0);
            
            $invoice->update([
                'sub_total'     => $subtotal,
                'pajak_ppn'     => $pajakPpn,
                'total_tagihan' => $subtotal + $ongkir,
                'ongkir'        => $ongkir,
                'diskon_persen' => $diskonRate * 100,
                'total_diskon'  => $totalDiskon,
            ]);

            DB::commit();

            // ===== CEK AUTO-UPGRADE TIER =====
            // Refresh user agar total pembelian terbaru sudah termasuk invoice baru
            $user->refresh();
            $tierUpgrade = $user->checkAndUpgradeTier();
            // Re-fetch setelah upgrade agar tier terbaru tampil di response
            $user->refresh();
            $totalPembelian = $user->getTotalPembelian();

            // KIRIM NOTIFIKASI WA KE ADMIN
            try {
                $admins = \App\Models\User::whereIn('role', ['staf_admin', 'bendahara', 'superadmin'])
                            ->whereNotNull('nomor_hp')
                            ->get();
                
                if ($admins->count() > 0) {
                    $pesanAdmin = "Halo Tim JukungSync, \n\n";
                    $pesanAdmin .= "Terdapat pesanan E-Catalog baru yang baru saja masuk dan membutuhkan konfirmasi Anda.\n\n";
                    $pesanAdmin .= "*Detail Pesanan:*\n";
                    $pesanAdmin .= "- No. Invoice : *" . $invoice->nomor_invoice . "*\n";
                    $pesanAdmin .= "- Nama Klien  : *" . auth()->user()->name . "*\n";
                    $pesanAdmin .= "- Total Tagihan: *Rp " . number_format($subtotal, 0, ',', '.') . "*\n";
                    $pesanAdmin .= "- Ekspedisi   : *" . $request->ekspedisi . "*\n\n";
                    $pesanAdmin .= "Mohon kesediaannya untuk segera login ke sistem JukungSync guna meninjau dan memproses pesanan ini. Terima kasih!";

                    $targets = $admins->pluck('nomor_hp')->implode(',');
                    \App\Services\FonnteService::sendMessage($targets, $pesanAdmin);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Gagal mengirim WA ke Admin: " . $e->getMessage());
            }

            // Siapkan response payload
            $responseData = [
                'success'         => true,
                'message'         => 'Pesanan berhasil dikirim. Staf kami akan segera memproses pesanan Anda.',
                'tier_upgrade'    => $tierUpgrade,           // null | 'Member' | 'Premium'
                'tier_saat_ini'   => $user->getTierLabel(),  // tier terbaru setelah kemungkinan upgrade
                'total_pembelian' => $totalPembelian,        // total kumulatif untuk info
            ];

            // Jika ada upgrade tier, kirim notifikasi WA ke customer
            if ($tierUpgrade && $user->nomor_hp) {
                try {
                    $pesanCustomer  = "Selamat! 🎉 Akun Anda telah diupgrade ke tier *{$tierUpgrade}*\n\n";
                    $pesanCustomer .= "Total pembelian Anda telah mencapai *Rp " . number_format($totalPembelian, 0, ',', '.') . "*.\n";
                    $pesanCustomer .= "Mulai sekarang Anda menikmati keuntungan tier {$tierUpgrade} di E-Catalog PT Utama Madani Raya.\n\n";
                    $pesanCustomer .= "Terima kasih atas kepercayaan Anda! 🙏";
                    \App\Services\FonnteService::sendMessage($user->nomor_hp, $pesanCustomer);
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::warning("Gagal kirim WA upgrade tier ke customer: " . $e->getMessage());
                }
            }

            return response()->json($responseData);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    public function myOrders()
    {
        $orders = Invoice::with('invoiceItems.product')
            ->where('klien_id', auth()->id())
            ->where('jenis_transaksi', 'online')
            ->latest('tanggal_invoice')
            ->latest('id')
            ->paginate(10);

        return view('catalog.orders', compact('orders'));
    }

    public function getProvinces()
    {
        return \Illuminate\Support\Facades\Cache::remember('wilayah_provinces', 3600 * 24 * 30, function() {
            $urls = [
                'https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json',
                'https://rakhmad.github.io/api-wilayah-indonesia/api/provinces.json'
            ];
            foreach ($urls as $url) {
                try {
                    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
                    $response = @file_get_contents($url, false, $ctx);
                    if ($response) {
                        return json_decode($response, true);
                    }
                } catch (\Exception $e) {}
            }
            return [];
        });
    }

    public function getRegencies($provinceId)
    {
        return \Illuminate\Support\Facades\Cache::remember("wilayah_regencies_{$provinceId}", 3600 * 24 * 30, function() use ($provinceId) {
            $urls = [
                "https://emsifa.github.io/api-wilayah-indonesia/api/regencies/{$provinceId}.json",
                "https://rakhmad.github.io/api-wilayah-indonesia/api/regencies/{$provinceId}.json"
            ];
            foreach ($urls as $url) {
                try {
                    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
                    $response = @file_get_contents($url, false, $ctx);
                    if ($response) {
                        return json_decode($response, true);
                    }
                } catch (\Exception $e) {}
            }
            return [];
        });
    }

    public function getDistricts($regencyId)
    {
        return \Illuminate\Support\Facades\Cache::remember("wilayah_districts_{$regencyId}", 3600 * 24 * 30, function() use ($regencyId) {
            $urls = [
                "https://emsifa.github.io/api-wilayah-indonesia/api/districts/{$regencyId}.json",
                "https://rakhmad.github.io/api-wilayah-indonesia/api/districts/{$regencyId}.json"
            ];
            foreach ($urls as $url) {
                try {
                    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
                    $response = @file_get_contents($url, false, $ctx);
                    if ($response) {
                        return json_decode($response, true);
                    }
                } catch (\Exception $e) {}
            }
            return [];
        });
    }

    public function getVillages($districtId)
    {
        return \Illuminate\Support\Facades\Cache::remember("wilayah_villages_{$districtId}", 3600 * 24 * 30, function() use ($districtId) {
            $urls = [
                "https://emsifa.github.io/api-wilayah-indonesia/api/villages/{$districtId}.json",
                "https://rakhmad.github.io/api-wilayah-indonesia/api/villages/{$districtId}.json"
            ];
            foreach ($urls as $url) {
                try {
                    $ctx = stream_context_create(['http' => ['timeout' => 5]]);
                    $response = @file_get_contents($url, false, $ctx);
                    if ($response) {
                        return json_decode($response, true);
                    }
                } catch (\Exception $e) {}
            }
            return [];
        });
    }
}
