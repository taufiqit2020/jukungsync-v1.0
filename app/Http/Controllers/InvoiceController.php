<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\InventoryMovement;
use App\Models\Kasbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        // Tampilkan invoice manual (klaim) dan juga pesanan online bermetode 'invoice_30_hari' yang sudah disetujui (status != 'menunggu_konfirmasi')
        $query = Invoice::where(function($q) {
                $q->whereNull('jenis_transaksi')
                  ->orWhere('jenis_transaksi', '!=', 'online')
                  ->orWhere(function($sub) {
                      $sub->where('jenis_transaksi', 'online')
                          ->where('metode_pembayaran', 'invoice_30_hari')
                          ->where('status_pesanan', '!=', 'menunggu_konfirmasi');
                  });
            });

        // FR-07: Filter by status
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        // FR-07: Filter by customer name
        if ($request->filled('customer')) {
            $query->where('nama_klien', 'like', '%' . $request->customer . '%');
        }

        // FR-07: Filter by date range
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_invoice', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_invoice', '<=', $request->sampai);
        }

        // FR-07: Search by invoice number
        if ($request->filled('nomor')) {
            $query->where('nomor_invoice', 'like', '%' . $request->nomor . '%');
        }

        // Clone query for total calculation (before paginate)
        $totalTagihanFilter = (clone $query)->sum('total_tagihan');
        $totalBelumLunasFilter = (clone $query)->where('status_pembayaran', 'belum_lunas')->sum('total_tagihan');

        $invoices = $query->orderBy('tanggal_invoice', 'desc')
            ->orderBy('id', 'asc')
            ->paginate(15)
            ->withQueryString();

        $products = Product::with('category')->orderBy('sku', 'asc')->get();
        $customers = Customer::orderBy('nama_klien', 'asc')->get();
        
        $lastInvoice = Invoice::latest('id')->first();
        $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $nomor_invoice = sprintf('%03d/UMAR/%s/%s', $nextId, $this->romanMonth(date('n')), date('Y'));

        return view('invoices.index', compact('invoices', 'products', 'nomor_invoice', 'customers', 'totalTagihanFilter', 'totalBelumLunasFilter'));
    }

    public function create()
    {
        $products = Product::with('category')->orderBy('sku', 'asc')->get();
        $customers = Customer::orderBy('nama_klien', 'asc')->get();
        
        // Auto-generate next invoice number
        $lastInvoice = Invoice::latest('id')->first();
        $nextId = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $nomor_invoice = sprintf('%03d/UMAR/%s/%s', $nextId, $this->romanMonth(date('n')), date('Y'));

        return view('invoices.create', compact('products', 'nomor_invoice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_invoice' => 'required|string|unique:invoices,nomor_invoice',
            'nama_klien' => 'required|string|max:255',
            'tanggal_invoice' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.movement_id' => 'nullable|exists:inventory_movements,id',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Initialize totals
                $sub_total = 0;


                
                // Create temporary invoice to get ID
                $invoice = Invoice::create([
                    'nomor_invoice' => $request->nomor_invoice,
                    'nama_klien' => $request->nama_klien,
                    'tanggal_invoice' => $request->tanggal_invoice,
                    'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
                    'sub_total' => 0,
                    'pajak_ppn' => 0,
                    'total_tagihan' => 0,
                    'status_pembayaran' => 'belum_lunas',
                ]);

                foreach ($request->items as $item) {
                    // Cek jika item berasal dari tarikan Mutasi Keluar Manual
                    if (isset($item['movement_id']) && !empty($item['movement_id'])) {
                        $mov = InventoryMovement::find($item['movement_id']);
                        if ($mov && $mov->tipe_pergerakan === 'keluar') {
                            if ($mov->jumlah <= $item['jumlah']) {
                                // Konversi penuh: hapus pergerakan manual lama dan pulihkan stok sementara agar bisa dipotong lagi oleh Invoice
                                $product = Product::lockForUpdate()->find($mov->product_id);
                                if ($product) {
                                    $product->stok_saat_ini += $mov->jumlah;
                                    $product->save();
                                }
                                $mov->delete();
                            } else {
                                // Konversi parsial (Split): kurangi jumlah pada pergerakan manual lama
                                $mov->jumlah -= $item['jumlah'];
                                $mov->save();
                                
                                // Pulihkan stok HANYA sebesar jumlah yang masuk ke invoice, agar bisa dipotong lagi oleh Invoice
                                $product = Product::lockForUpdate()->find($mov->product_id);
                                if ($product) {
                                    $product->stok_saat_ini += $item['jumlah'];
                                    $product->save();
                                }
                            }
                        }
                    }

                    $product = Product::lockForUpdate()->findOrFail($item['product_id']);
                    
                    if ($product->stok_saat_ini < $item['jumlah']) {
                        throw new \Exception("Stok {$product->nama_barang} tidak mencukupi. Sisa: {$product->stok_saat_ini}");
                    }

                    $harga_pakai = $product->harga_jual;
                    if ($request->has('is_grosir') && $product->harga_grosir > 0) {
                        $harga_pakai = $product->harga_grosir;
                    }

                    $total_harga_item = $harga_pakai * $item['jumlah'];
                    $sub_total += $total_harga_item;

                    // Deduct Stock
                    $product->stok_saat_ini -= $item['jumlah'];
                    $product->save();

                    // Create Inventory Movement
                    InventoryMovement::create([
                        'product_id' => $product->id,
                        'tipe_pergerakan' => 'keluar',
                        'jumlah' => $item['jumlah'],
                        'tanggal' => $request->tanggal_invoice,
                        'keterangan' => 'Penjualan Invoice ' . $invoice->nomor_invoice,
                    ]);

                    // Create Invoice Item
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $product->id,
                        'jumlah' => $item['jumlah'],
                        'harga_modal_snapshot' => $product->harga_modal,
                        'harga_jual_snapshot' => $harga_pakai,
                        'total_harga' => $total_harga_item,
                    ]);
                }

                // Calculate PPN and Total
                $pajak_ppn = $sub_total * 0.11;
                $total_tagihan = $sub_total; // Sesuai permintaan revisi user

                $invoice->update([
                    'sub_total' => $sub_total,
                    'pajak_ppn' => $pajak_ppn,
                    'total_tagihan' => $total_tagihan,
                ]);

                // Otomatis buat/sinkronkan data Kasbon
                Kasbon::syncFromInvoice($invoice);
            });

            return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dibuat dan stok otomatis terpotong.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Invoice $invoice, Request $request)
    {
        $invoice->load('invoiceItems.product.category');
        $isInternal = $request->has('mode') && $request->mode === 'internal';
        
        return view('invoices.show', compact('invoice', 'isInternal'));
    }

    public function suratJalan(Invoice $invoice)
    {
        $user = auth()->user();
        if ($user->role === 'customer' && $invoice->klien_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }
        
        $invoice->load('invoiceItems.product.category');
        return view('invoices.surat_jalan', compact('invoice'));
    }

    public function exportWord(Invoice $invoice)
    {
        $invoice->load('invoiceItems.product.category');
        $html = view('invoices.word', compact('invoice'))->render();
        
        $filename = 'Invoice-' . str_replace('/', '-', $invoice->nomor_invoice) . '.doc';
        
        return response($html)
            ->header('Content-Type', 'application/msword')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->header('Cache-Control', 'max-age=0');
    }

    public function struk(Invoice $invoice)
    {
        $invoice->load('invoiceItems.product');
        return view('invoices.struk', compact('invoice'));
    }

    public function markPaid(Invoice $invoice)
    {
        if ($invoice->status_pembayaran !== 'belum_lunas') {
            return back()->with('error', 'Invoice ini sudah lunas atau dibatalkan.');
        }

        $invoice->update([
            'status_pembayaran' => 'lunas'
        ]);

        // Otomatis sinkronkan status Kasbon
        Kasbon::syncFromInvoice($invoice);

        // Trigger auto-tier upgrade check
        $user = \App\Models\User::find($invoice->klien_id);
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

        return back()->with('success', 'Status pembayaran invoice berhasil diubah menjadi Lunas.');
    }

    public function getManualOutMovements(Request $request)
    {
        $tanggal = $request->query('tanggal');
        if (!$tanggal) return response()->json([]);

        // Get movements of type 'keluar' on the given date
        // that are assigned to a customer (starts with '[')
        $movements = InventoryMovement::with('product')
            ->where('tipe_pergerakan', 'keluar')
            ->whereDate('tanggal', $tanggal)
            ->where('keterangan', 'LIKE', '[%')
            ->get();

        return response()->json($movements);
    }

    private function romanMonth($month)
    {
        $map = [
            1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
            7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
        ];
        return $map[$month] ?? '';
    }

    // ==================== SUPERADMIN ONLY ====================

    public function edit(Invoice $invoice)
    {
        $invoice->load('invoiceItems.product.category');
        $products = Product::with('category')->orderBy('sku', 'asc')->get();
        $customers = Customer::orderBy('nama_klien', 'asc')->get();
        $customers = \App\Models\Customer::orderBy('nama_klien', 'asc')->get();
        return view('invoices.edit', compact('invoice', 'products', 'customers'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'nomor_invoice' => 'required|string|unique:invoices,nomor_invoice,' . $invoice->id,
            'nama_klien' => 'required|string|max:255',
            'tanggal_invoice' => 'required|date',
            'tanggal_jatuh_tempo' => 'required|date',
            'status_pembayaran' => 'required|in:lunas,belum_lunas',
            'ongkir' => 'nullable|numeric|min:0',
        ]);

        $klien = trim($request->nama_klien);
        if(!empty($klien)){
            \App\Models\Customer::firstOrCreate(['nama_klien' => $klien]);
        }

        $ongkir = (float) $request->input('ongkir', 0);

        $updateData = [
            'nomor_invoice' => $request->nomor_invoice,
            'nama_klien' => $klien,
            'tanggal_invoice' => $request->tanggal_invoice,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'status_pembayaran' => $request->status_pembayaran,
            'ongkir' => $ongkir,
            'total_tagihan' => $invoice->sub_total + $ongkir,
        ];

        // Jika ini adalah pesanan online, sinkronkan status_pesanan dengan status_pembayaran secara konsisten
        if ($invoice->jenis_transaksi === 'online') {
            if ($request->status_pembayaran === 'lunas') {
                $updateData['status_pesanan'] = 'selesai';
            } elseif ($request->status_pembayaran === 'belum_lunas' && $invoice->status_pesanan === 'selesai') {
                $updateData['status_pesanan'] = 'diproses';
            }
        }

        $invoice->update($updateData);

        // Otomatis sinkronkan data Kasbon
        Kasbon::syncFromInvoice($invoice);

        if ($request->status_pembayaran === 'lunas') {
            $user = \App\Models\User::find($invoice->klien_id);
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
        }
        
        $from = $request->input('from');
        if ($from === 'online-orders') {
            return redirect()->route('online-orders.index')->with('success', 'Pesanan online berhasil diperbarui oleh Superadmin.');
        } elseif ($from === 'reports') {
            return redirect()->route('reports.online-orders')->with('success', 'Pesanan online berhasil diperbarui oleh Superadmin.');
        }
        
        return redirect()->route('invoices.index')->with('success', 'Invoice berhasil diperbarui oleh Superadmin.');
    }

    public function destroy(Invoice $invoice)
    {
        try {
            DB::transaction(function () use ($invoice) {
                // Ubah status Inventory Movement menjadi Mutasi Keluar agar bisa ditarik lagi ke invoice jika mau,
                // Stok TIDAK dikembalikan otomatis ke warehouse.
                InventoryMovement::where('keterangan', 'Penjualan Invoice ' . $invoice->nomor_invoice)
                    ->where('tipe_pergerakan', 'keluar')
                    ->update([
                        'keterangan' => 'Mutasi Keluar (Batal ' . $invoice->nomor_invoice . ')'
                    ]);

                // Hapus semua item invoice
                $invoice->invoiceItems()->delete();

                // Hapus invoice
                $invoice->delete();
            });

            $from = request()->input('from');
            if ($from === 'online-orders') {
                return redirect()->route('online-orders.index')->with('success', 'Pesanan online berhasil dihapus oleh Superadmin.');
            } elseif ($from === 'reports') {
                return redirect()->route('reports.online-orders')->with('success', 'Pesanan online berhasil dihapus oleh Superadmin.');
            }

            return redirect()->route('invoices.index')->with('success', 'Invoice berhasil dihapus. Item otomatis dikembalikan ke daftar Mutasi Keluar Manual (stok tetap terpotong).');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus invoice: ' . $e->getMessage());
        }
    }

    public function uploadBukti(Request $request, Invoice $invoice)
    {
        $request->validate([
            'bukti_file' => 'required|mimes:jpg,jpeg,png,pdf|max:5120', // max 5MB
            'bukti_keterangan' => 'nullable|string',
        ]);

        if ($request->hasFile('bukti_file')) {
            // Hapus file lama jika ada
            if ($invoice->bukti_file) {
                Storage::disk('public')->delete($invoice->bukti_file);
            }

            // Menggunakan penamaan acak (hash) dari Laravel untuk keamanan (mencegah directory traversal & eksekusi)
            $path = $request->file('bukti_file')->store('bukti_invoices', 'public');

            $invoice->bukti_file = $path;
            $invoice->bukti_keterangan = $request->bukti_keterangan;
            $invoice->save();
        }

        return back()->with('success', 'Bukti Invoice berhasil diunggah.');
    }
}
