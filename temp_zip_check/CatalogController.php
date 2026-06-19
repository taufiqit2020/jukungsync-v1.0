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
        $search = $request->input('search');
        
        $products = Product::with('category')->when($search, function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            })
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

    public function storeOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Buat Draft Invoice
            $invoice = Invoice::create([
                'nomor_invoice' => 'ORD-' . strtoupper(uniqid()),
                'klien_id' => auth()->id(),
                'tanggal_invoice' => now(),
                'nama_klien' => auth()->user()->name,
                'sub_total' => 0,
                'pajak_ppn' => 0,
                'total_tagihan' => 0,
                'jenis_transaksi' => 'online',
                'status_pesanan' => 'menunggu_konfirmasi',
                'catatan' => 'Pesanan E-Catalog dari Customer: ' . auth()->user()->name . ' (' . auth()->user()->email . ')',
                'status_pembayaran' => 'belum_lunas',
            ]);

            $subtotal = 0;

            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                // Pastikan stok cukup (Opsional, tapi sebaiknya dicek)
                if ($product->stok_saat_ini < $item['qty']) {
                    throw new \Exception("Stok {$product->nama_barang} tidak mencukupi. Sisa stok: {$product->stok_saat_ini}");
                }

                $tipePelanggan = auth()->user()->tipe_pelanggan ?? 'reguler';
                $hargaBerlaku = ($tipePelanggan === 'grosir' && $product->harga_grosir > 0) ? $product->harga_grosir : $product->harga_jual;

                $totalHarga = $hargaBerlaku * $item['qty'];
                $subtotal += $totalHarga;

                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $product->id,
                    'jumlah' => $item['qty'],
                    'harga_jual_snapshot' => $hargaBerlaku,
                    'total_harga' => $totalHarga,
                    'harga_modal_snapshot' => $product->harga_modal, // Untuk laporan laba nanti
                ]);
            }

            // Update subtotal (PPN 0% default untuk pemesanan awal)
            $invoice->update([
                'sub_total' => $subtotal,
                'total_tagihan' => $subtotal,
            ]);

            DB::commit();

            

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
                    $pesanAdmin .= "- Total Tagihan: *Rp " . number_format($subtotal, 0, ',', '.') . "*\n\n";
                    $pesanAdmin .= "Mohon kesediaannya untuk segera login ke sistem JukungSync guna meninjau dan memproses pesanan ini. Terima kasih!";

                    $targets = $admins->pluck('nomor_hp')->implode(',');
                    \App\Services\FonnteService::sendMessage($targets, $pesanAdmin);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Gagal mengirim WA ke Admin: " . $e->getMessage());
            }

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikirim. Staf kami akan segera memproses pesanan Anda.',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            

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
                    $pesanAdmin .= "- Total Tagihan: *Rp " . number_format($subtotal, 0, ',', '.') . "*\n\n";
                    $pesanAdmin .= "Mohon kesediaannya untuk segera login ke sistem JukungSync guna meninjau dan memproses pesanan ini. Terima kasih!";

                    $targets = $admins->pluck('nomor_hp')->implode(',');
                    \App\Services\FonnteService::sendMessage($targets, $pesanAdmin);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Gagal mengirim WA ke Admin: " . $e->getMessage());
            }

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
}
