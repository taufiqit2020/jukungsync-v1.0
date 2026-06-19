<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Expense;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Set default dates to current month if not provided
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Query Invoices within the date range (HANYA invoice manual/klaim, bukan pesanan online)
        $invoices = Invoice::with('invoiceItems.product')
            ->where(function($q) {
                $q->whereNull('jenis_transaksi')
                  ->orWhere('jenis_transaksi', '!=', 'online');
            })
            ->whereDate('tanggal_invoice', '>=', $startDate)
            ->whereDate('tanggal_invoice', '<=', $endDate)
            ->orderBy('tanggal_invoice', 'desc')
            ->get();

        // Calculate Summary
        $totalPendapatan = 0;
        $totalModal = 0;
        $totalPpn = 0;
        
        foreach ($invoices as $invoice) {
            $totalPendapatan += $invoice->sub_total; // Subtotal is raw revenue before tax
            $totalPpn += $invoice->pajak_ppn;
            
            // Calculate total modal (HPP) for this invoice
            foreach ($invoice->invoiceItems as $item) {
                $totalModal += ($item->harga_modal_snapshot * $item->jumlah);
            }
        }

        $labaKotor = $totalPendapatan - $totalModal;
        $totalTransaksi = $invoices->count();

        return view('reports.index', compact(
            'startDate', 'endDate', 
            'invoices', 
            'totalPendapatan', 'totalModal', 'labaKotor', 'totalPpn', 'totalTransaksi'
        ));
    }

    public function print(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $invoices = Invoice::with('invoiceItems.product')
            ->where(function($q) {
                $q->whereNull('jenis_transaksi')
                  ->orWhere('jenis_transaksi', '!=', 'online');
            })
            ->whereDate('tanggal_invoice', '>=', $startDate)
            ->whereDate('tanggal_invoice', '<=', $endDate)
            ->orderBy('tanggal_invoice', 'asc') // Urut kronologis untuk cetak
            ->get();

        $totalPendapatan = 0;
        $totalModal = 0;
        $totalPpn = 0;
        
        foreach ($invoices as $invoice) {
            $totalPendapatan += $invoice->sub_total;
            $totalPpn += $invoice->pajak_ppn;
            foreach ($invoice->invoiceItems as $item) {
                $totalModal += ($item->harga_modal_snapshot * $item->jumlah);
            }
        }

        $labaKotor = $totalPendapatan - $totalModal;

        return view('reports.print', compact(
            'startDate', 'endDate', 
            'invoices', 
            'totalPendapatan', 'totalModal', 'labaKotor', 'totalPpn'
        ));
    }

    public function stockCard(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $productId = $request->input('product_id');

        $products = Product::orderBy('nama_barang')->get();
        $selectedProduct = null;
        $saldoAwal = 0;
        $movements = collect();
        $allProductsSummary = null;

        if ($productId === 'all') {
            $allProductsSummary = collect();
            // Optional optimization: Fetch all movements at once, but for simplicity we iterate if data isn't huge
            foreach ($products as $p) {
                $masukSebelum = InventoryMovement::where('product_id', $p->id)
                    ->whereDate('tanggal', '<', $startDate)
                    ->where('tipe_pergerakan', 'masuk')
                    ->sum('jumlah');
                $keluarSebelum = InventoryMovement::where('product_id', $p->id)
                    ->whereDate('tanggal', '<', $startDate)
                    ->where('tipe_pergerakan', 'keluar')
                    ->sum('jumlah');

                $sAwal = $masukSebelum - $keluarSebelum;

                $masukPeriode = InventoryMovement::where('product_id', $p->id)
                    ->whereDate('tanggal', '>=', $startDate)
                    ->whereDate('tanggal', '<=', $endDate)
                    ->where('tipe_pergerakan', 'masuk')
                    ->sum('jumlah');

                $keluarPeriode = InventoryMovement::where('product_id', $p->id)
                    ->whereDate('tanggal', '>=', $startDate)
                    ->whereDate('tanggal', '<=', $endDate)
                    ->where('tipe_pergerakan', 'keluar')
                    ->sum('jumlah');

                $allProductsSummary->push((object)[
                    'product' => $p,
                    'saldo_awal' => $sAwal,
                    'masuk' => $masukPeriode,
                    'keluar' => $keluarPeriode,
                    'saldo_akhir' => $sAwal + $masukPeriode - $keluarPeriode
                ]);
            }
        } elseif ($productId) {
            $selectedProduct = Product::find($productId);

            if ($selectedProduct) {
                // Hitung saldo awal (Masuk - Keluar sebelum start_date)
                $masukSebelum = InventoryMovement::where('product_id', $productId)
                    ->whereDate('tanggal', '<', $startDate)
                    ->where('tipe_pergerakan', 'masuk')
                    ->sum('jumlah');

                $keluarSebelum = InventoryMovement::where('product_id', $productId)
                    ->whereDate('tanggal', '<', $startDate)
                    ->where('tipe_pergerakan', 'keluar')
                    ->sum('jumlah');

                $saldoAwal = $masukSebelum - $keluarSebelum;

                // Ambil mutasi dalam periode
                $movements = InventoryMovement::where('product_id', $productId)
                    ->whereDate('tanggal', '>=', $startDate)
                    ->whereDate('tanggal', '<=', $endDate)
                    ->orderBy('tanggal', 'asc')
                    ->orderBy('id', 'asc')
                    ->get();
            }
        }

        return view('reports.stock', compact('startDate', 'endDate', 'products', 'selectedProduct', 'saldoAwal', 'movements', 'allProductsSummary'));
    }

    public function purchases(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $purchases = \App\Models\Purchase::with('purchaseItems.product')
            ->whereDate('tanggal_pembelian', '>=', $startDate)
            ->whereDate('tanggal_pembelian', '<=', $endDate)
            ->orderBy('tanggal_pembelian', 'desc')
            ->get();

        $totalPembelian = $purchases->sum('total_biaya');

        return view('reports.purchases', compact('startDate', 'endDate', 'purchases', 'totalPembelian'));
    }

    // --- EXPORT METHODS ---

    public function exportSalesExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $invoices = Invoice::with('invoiceItems.product')
            ->where(function($q) {
                $q->whereNull('jenis_transaksi')
                  ->orWhere('jenis_transaksi', '!=', 'online');
            })
            ->whereDate('tanggal_invoice', '>=', $startDate)
            ->whereDate('tanggal_invoice', '<=', $endDate)
            ->orderBy('tanggal_invoice', 'asc')
            ->get();

        $fileName = 'laporan_penjualan_' . $startDate . '_sd_' . $endDate . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($invoices) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'No. Invoice', 'Klien', 'Pendapatan', 'Modal', 'Laba'], ';'); // semicolon for Excel compatibility in ID locale

            $totalPendapatan = 0;
            $totalModal = 0;

            foreach ($invoices as $inv) {
                $modalInv = 0;
                foreach($inv->invoiceItems as $item) {
                    $modalInv += ($item->harga_modal_snapshot * $item->jumlah);
                }
                $labaInv = $inv->sub_total - $modalInv;
                
                $totalPendapatan += $inv->sub_total;
                $totalModal += $modalInv;

                fputcsv($file, [
                    Carbon::parse($inv->tanggal_invoice)->format('d/m/Y'),
                    $inv->nomor_invoice,
                    $inv->nama_klien,
                    $inv->sub_total,
                    $modalInv,
                    $labaInv
                ], ';');
            }
            fputcsv($file, ['TOTAL', '', '', $totalPendapatan, $totalModal, $totalPendapatan - $totalModal], ';');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function printStockCard(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $productId = $request->input('product_id');

        if (!$productId) return back();

        if ($productId === 'all') {
            $products = Product::orderBy('nama_barang')->get();
            $allProductsSummary = collect();
            foreach ($products as $p) {
                $masukSebelum = InventoryMovement::where('product_id', $p->id)->whereDate('tanggal', '<', $startDate)->where('tipe_pergerakan', 'masuk')->sum('jumlah');
                $keluarSebelum = InventoryMovement::where('product_id', $p->id)->whereDate('tanggal', '<', $startDate)->where('tipe_pergerakan', 'keluar')->sum('jumlah');
                $sAwal = $masukSebelum - $keluarSebelum;
                $masukPeriode = InventoryMovement::where('product_id', $p->id)->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)->where('tipe_pergerakan', 'masuk')->sum('jumlah');
                $keluarPeriode = InventoryMovement::where('product_id', $p->id)->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)->where('tipe_pergerakan', 'keluar')->sum('jumlah');

                $allProductsSummary->push((object)[
                    'product' => $p,
                    'saldo_awal' => $sAwal,
                    'masuk' => $masukPeriode,
                    'keluar' => $keluarPeriode,
                    'saldo_akhir' => $sAwal + $masukPeriode - $keluarPeriode
                ]);
            }
            return view('reports.print-stock-all', compact('startDate', 'endDate', 'allProductsSummary'));
        }

        $selectedProduct = Product::find($productId);
        if (!$selectedProduct) return back();

        $masukSebelum = InventoryMovement::where('product_id', $productId)->whereDate('tanggal', '<', $startDate)->where('tipe_pergerakan', 'masuk')->sum('jumlah');
        $keluarSebelum = InventoryMovement::where('product_id', $productId)->whereDate('tanggal', '<', $startDate)->where('tipe_pergerakan', 'keluar')->sum('jumlah');
        $saldoAwal = $masukSebelum - $keluarSebelum;

        $movements = InventoryMovement::where('product_id', $productId)
            ->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)
            ->orderBy('tanggal', 'asc')->orderBy('id', 'asc')->get();

        return view('reports.print-stock', compact('startDate', 'endDate', 'selectedProduct', 'saldoAwal', 'movements'));
    }

    public function exportStockCardExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $productId = $request->input('product_id');

        if (!$productId) return back();

        if ($productId === 'all') {
            $products = Product::orderBy('nama_barang')->get();
            $allProductsSummary = collect();
            foreach ($products as $p) {
                $masukSebelum = InventoryMovement::where('product_id', $p->id)->whereDate('tanggal', '<', $startDate)->where('tipe_pergerakan', 'masuk')->sum('jumlah');
                $keluarSebelum = InventoryMovement::where('product_id', $p->id)->whereDate('tanggal', '<', $startDate)->where('tipe_pergerakan', 'keluar')->sum('jumlah');
                $sAwal = $masukSebelum - $keluarSebelum;
                $masukPeriode = InventoryMovement::where('product_id', $p->id)->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)->where('tipe_pergerakan', 'masuk')->sum('jumlah');
                $keluarPeriode = InventoryMovement::where('product_id', $p->id)->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)->where('tipe_pergerakan', 'keluar')->sum('jumlah');

                $allProductsSummary->push((object)[
                    'product' => $p,
                    'saldo_awal' => $sAwal,
                    'masuk' => $masukPeriode,
                    'keluar' => $keluarPeriode,
                    'saldo_akhir' => $sAwal + $masukPeriode - $keluarPeriode
                ]);
            }

            $fileName = 'rekap_stok_semua_produk_' . $startDate . '_sd_' . $endDate . '.csv';
            $headers = [
                "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0"
            ];

            $callback = function() use($allProductsSummary, $startDate, $endDate) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['REKAPITULASI KARTU STOK SEMUA PRODUK'], ';');
                fputcsv($file, ['Periode:', Carbon::parse($startDate)->format('d/m/Y') . ' - ' . Carbon::parse($endDate)->format('d/m/Y')], ';');
                fputcsv($file, [], ';');
                
                fputcsv($file, ['No', 'Nama Barang', 'SKU', 'Saldo Awal', 'Masuk', 'Keluar', 'Saldo Akhir'], ';');
                
                $no = 1;
                foreach ($allProductsSummary as $summary) {
                    fputcsv($file, [
                        $no++,
                        $summary->product->nama_barang,
                        $summary->product->sku,
                        $summary->saldo_awal,
                        $summary->masuk,
                        $summary->keluar,
                        $summary->saldo_akhir
                    ], ';');
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        $selectedProduct = Product::find($productId);
        if (!$selectedProduct) return back();

        $masukSebelum = InventoryMovement::where('product_id', $productId)->whereDate('tanggal', '<', $startDate)->where('tipe_pergerakan', 'masuk')->sum('jumlah');
        $keluarSebelum = InventoryMovement::where('product_id', $productId)->whereDate('tanggal', '<', $startDate)->where('tipe_pergerakan', 'keluar')->sum('jumlah');
        $saldoAwal = $masukSebelum - $keluarSebelum;

        $movements = InventoryMovement::where('product_id', $productId)
            ->whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)
            ->orderBy('tanggal', 'asc')->orderBy('id', 'asc')->get();

        $fileName = 'kartu_stok_' . preg_replace('/[^A-Za-z0-9\-]/', '_', $selectedProduct->sku) . '_' . $startDate . '.csv';
        $headers = [
            "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0"
        ];

        $callback = function() use($selectedProduct, $startDate, $endDate, $saldoAwal, $movements) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['KARTU STOK'], ';');
            fputcsv($file, ['Barang:', $selectedProduct->nama_barang], ';');
            fputcsv($file, ['SKU:', $selectedProduct->sku], ';');
            fputcsv($file, ['Periode:', Carbon::parse($startDate)->format('d/m/Y') . ' - ' . Carbon::parse($endDate)->format('d/m/Y')], ';');
            fputcsv($file, [], ';');
            
            fputcsv($file, ['Tanggal', 'Keterangan/Ref', 'Masuk', 'Keluar', 'Saldo'], ';');
            fputcsv($file, ['-', 'SALDO AWAL', '-', '-', $saldoAwal], ';');
            
            $currentSaldo = $saldoAwal;
            foreach ($movements as $m) {
                if($m->tipe_pergerakan === 'masuk') {
                    $currentSaldo += $m->jumlah;
                } else {
                    $currentSaldo -= $m->jumlah;
                }
                
                fputcsv($file, [
                    Carbon::parse($m->tanggal)->format('d/m/Y'),
                    $m->keterangan,
                    $m->tipe_pergerakan === 'masuk' ? $m->jumlah : '-',
                    $m->tipe_pergerakan === 'keluar' ? $m->jumlah : '-',
                    $currentSaldo
                ], ';');
            }
            fputcsv($file, ['SALDO AKHIR', '', '', '', $currentSaldo], ';');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function printPurchases(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $purchases = \App\Models\Purchase::whereDate('tanggal_pembelian', '>=', $startDate)
            ->whereDate('tanggal_pembelian', '<=', $endDate)->orderBy('tanggal_pembelian', 'asc')->get();

        $totalPembelian = $purchases->sum('total_biaya');

        return view('reports.print-purchases', compact('startDate', 'endDate', 'purchases', 'totalPembelian'));
    }

    public function exportPurchasesExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $purchases = \App\Models\Purchase::whereDate('tanggal_pembelian', '>=', $startDate)
            ->whereDate('tanggal_pembelian', '<=', $endDate)->orderBy('tanggal_pembelian', 'asc')->get();

        $fileName = 'laporan_pembelian_' . $startDate . '_sd_' . $endDate . '.csv';
        $headers = [
            "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0"
        ];

        $callback = function() use($purchases) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'No. Faktur', 'Supplier', 'Total Biaya'], ';');
            
            $total = 0;
            foreach ($purchases as $p) {
                $total += $p->total_biaya;
                fputcsv($file, [
                    Carbon::parse($p->tanggal_pembelian)->format('d/m/Y'),
                    $p->nomor_faktur,
                    $p->nama_supplier,
                    $p->total_biaya
                ], ';');
            }
            fputcsv($file, ['TOTAL', '', '', $total], ';');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function onlineOrders(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Ambil invoice online yang sudah selesai (atau semua, mari ambil semua dan tampilkan status)
        $orders = Invoice::with('invoiceItems.product')
            ->where('jenis_transaksi', 'online')
            ->whereDate('tanggal_invoice', '>=', $startDate)
            ->whereDate('tanggal_invoice', '<=', $endDate)
            ->orderBy('tanggal_invoice', 'desc')
            ->get();

        $totalPendapatan = 0;
        $totalModal = 0;

        foreach ($orders as $order) {
            // Hanya hitung yang selesai/lunas untuk total pendapatan riil
            if ($order->status_pesanan === 'selesai' || $order->status_pembayaran === 'lunas') {
                $totalPendapatan += $order->sub_total;
                foreach ($order->invoiceItems as $item) {
                    $totalModal += ($item->harga_modal_snapshot * $item->jumlah);
                }
            }
        }

        $labaKotor = $totalPendapatan - $totalModal;
        $totalTransaksi = $orders->count();

        // Get Top Selling Products (hanya dari pesanan online)
        $topProducts = InvoiceItem::with('product')
            ->whereHas('invoice', function($q) use ($startDate, $endDate) {
                $q->where('jenis_transaksi', 'online')
                  ->whereDate('tanggal_invoice', '>=', $startDate)
                  ->whereDate('tanggal_invoice', '<=', $endDate);
            })
            ->selectRaw('product_id, SUM(jumlah) as total_qty, SUM(total_harga) as total_revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('reports.online-orders', compact('startDate', 'endDate', 'orders', 'totalPendapatan', 'totalModal', 'labaKotor', 'totalTransaksi', 'topProducts'));
    }

    public function printOnlineOrders(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $orders = Invoice::with('invoiceItems.product')
            ->where('jenis_transaksi', 'online')
            ->whereDate('tanggal_invoice', '>=', $startDate)
            ->whereDate('tanggal_invoice', '<=', $endDate)
            ->orderBy('tanggal_invoice', 'asc')
            ->get();

        $totalPendapatan = 0;
        $totalModal = 0;

        foreach ($orders as $order) {
            if ($order->status_pesanan === 'selesai' || $order->status_pembayaran === 'lunas') {
                $totalPendapatan += $order->sub_total;
                foreach ($order->invoiceItems as $item) {
                    $totalModal += ($item->harga_modal_snapshot * $item->jumlah);
                }
            }
        }

        $labaKotor = $totalPendapatan - $totalModal;

        return view('reports.print-online-orders', compact('startDate', 'endDate', 'orders', 'totalPendapatan', 'totalModal', 'labaKotor'));
    }

    public function exportOnlineOrdersExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $orders = Invoice::with('invoiceItems.product')
            ->where('jenis_transaksi', 'online')
            ->whereDate('tanggal_invoice', '>=', $startDate)
            ->whereDate('tanggal_invoice', '<=', $endDate)
            ->orderBy('tanggal_invoice', 'asc')
            ->get();

        $fileName = 'laporan_pesanan_ecatalog_' . $startDate . '_sd_' . $endDate . '.csv';
        $headers = [
            "Content-type" => "text/csv", "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache", "Cache-Control" => "must-revalidate, post-check=0, pre-check=0", "Expires" => "0"
        ];

        $callback = function() use($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Tanggal', 'No. Pesanan', 'Klien', 'Status', 'Pendapatan', 'Modal', 'Laba'], ';');
            
            $totalPendapatan = 0;
            $totalModal = 0;

            foreach ($orders as $order) {
                $modalInv = 0;
                $pendapatanInv = 0;
                $labaInv = 0;

                // Hanya hitung angka untuk laporan jika sudah selesai
                if ($order->status_pesanan === 'selesai' || $order->status_pembayaran === 'lunas') {
                    $pendapatanInv = $order->sub_total;
                    foreach($order->invoiceItems as $item) {
                        $modalInv += ($item->harga_modal_snapshot * $item->jumlah);
                    }
                    $labaInv = $pendapatanInv - $modalInv;
                    
                    $totalPendapatan += $pendapatanInv;
                    $totalModal += $modalInv;
                }

                fputcsv($file, [
                    Carbon::parse($order->tanggal_invoice)->format('d/m/Y'),
                    $order->nomor_invoice,
                    $order->nama_klien,
                    strtoupper(str_replace('_', ' ', $order->status_pesanan)),
                    $pendapatanInv,
                    $modalInv,
                    $labaInv
                ], ';');
            }
            fputcsv($file, ['TOTAL (Pesanan Selesai)', '', '', '', $totalPendapatan, $totalModal, $totalPendapatan - $totalModal], ';');
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function buktiInvoices(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $invoices = Invoice::whereNotNull('bukti_file')
            ->whereDate('tanggal_invoice', '>=', $startDate)
            ->whereDate('tanggal_invoice', '<=', $endDate)
            ->orderBy('tanggal_invoice', 'desc')
            ->paginate(15);

        return view('reports.bukti-invoices', compact('startDate', 'endDate', 'invoices'));
    }

    public function printBuktiInvoices(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $invoices = Invoice::whereNotNull('bukti_file')
            ->whereDate('tanggal_invoice', '>=', $startDate)
            ->whereDate('tanggal_invoice', '<=', $endDate)
            ->orderBy('tanggal_invoice', 'asc')
            ->get();

        return view('reports.print-bukti-invoices', compact('startDate', 'endDate', 'invoices'));
    }

    public function jatuhTempo(Request $request)
    {
        $invoices = Invoice::with('invoiceItems.product')
            ->where('status_pembayaran', 'belum_lunas')
            ->whereNotNull('tanggal_jatuh_tempo')
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->get();

        return view('reports.jatuh-tempo', compact('invoices'));
    }

    public function printJatuhTempo(Request $request)
    {
        $invoices = Invoice::with('invoiceItems.product')
            ->where('status_pembayaran', 'belum_lunas')
            ->whereNotNull('tanggal_jatuh_tempo')
            ->orderBy('tanggal_jatuh_tempo', 'asc')
            ->get();

        return view('reports.print-jatuh-tempo', compact('invoices'));
    }

    public function movements(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status = $request->input('status', 'semua');
        $search = $request->input('search', '');

        $query = InventoryMovement::with('product')
            ->whereDate('tanggal', '>=', $startDate)
            ->whereDate('tanggal', '<=', $endDate);

        if ($search != '') {
            $query->where(function($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('product', function($q2) use ($search) {
                      $q2->where('nama_barang', 'like', "%{$search}%")
                         ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        if ($status != '' && $status != 'semua') {
            if ($status == 'masuk') {
                $query->where('tipe_pergerakan', 'masuk');
            } else {
                $query->where('tipe_pergerakan', 'keluar');
                if ($status == 'sudah_invoice') {
                    $query->where('keterangan', 'like', '%Penjualan Invoice%');
                } elseif ($status == 'belum_invoice') {
                    $query->where('keterangan', 'like', '%Mutasi Manual%');
                } elseif ($status == 'lainnya') {
                    $query->where('keterangan', 'not like', '%Penjualan Invoice%')
                          ->where('keterangan', 'not like', '%Mutasi Manual%');
                }
            }
        }

        $movements = $query->orderBy('tanggal', 'desc')->orderBy('id', 'asc')->get();

        // Summaries based on the date range
        $countMasuk = InventoryMovement::whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)
            ->where('tipe_pergerakan', 'masuk')->count();
        $countSudahInvoice = InventoryMovement::whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)
            ->where('tipe_pergerakan', 'keluar')
            ->where('keterangan', 'like', '%Penjualan Invoice%')->count();
        $countBelumInvoice = InventoryMovement::whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)
            ->where('tipe_pergerakan', 'keluar')
            ->where('keterangan', 'like', '%Mutasi Manual%')->count();
        $countLainnya = InventoryMovement::whereDate('tanggal', '>=', $startDate)->whereDate('tanggal', '<=', $endDate)
            ->where('tipe_pergerakan', 'keluar')
            ->where('keterangan', 'not like', '%Penjualan Invoice%')
            ->where('keterangan', 'not like', '%Mutasi Manual%')->count();

        return view('reports.movements', compact(
            'startDate', 'endDate', 'status', 'search', 'movements',
            'countMasuk', 'countSudahInvoice', 'countBelumInvoice', 'countLainnya'
        ));
    }

    public function printMovements(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status = $request->input('status', 'semua');
        $search = $request->input('search', '');

        $query = InventoryMovement::with('product')
            ->whereDate('tanggal', '>=', $startDate)
            ->whereDate('tanggal', '<=', $endDate);

        if ($search != '') {
            $query->where(function($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('product', function($q2) use ($search) {
                      $q2->where('nama_barang', 'like', "%{$search}%")
                         ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        if ($status != '' && $status != 'semua') {
            if ($status == 'masuk') {
                $query->where('tipe_pergerakan', 'masuk');
            } else {
                $query->where('tipe_pergerakan', 'keluar');
                if ($status == 'sudah_invoice') {
                    $query->where('keterangan', 'like', '%Penjualan Invoice%');
                } elseif ($status == 'belum_invoice') {
                    $query->where('keterangan', 'like', '%Mutasi Manual%');
                } elseif ($status == 'lainnya') {
                    $query->where('keterangan', 'not like', '%Penjualan Invoice%')
                          ->where('keterangan', 'not like', '%Mutasi Manual%');
                }
            }
        }

        $movements = $query->orderBy('tanggal', 'asc')->orderBy('id', 'asc')->get();

        return view('reports.print-movements', compact('startDate', 'endDate', 'status', 'search', 'movements'));
    }

    public function exportMovementsExcel(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $status = $request->input('status', 'semua');
        $search = $request->input('search', '');

        $query = InventoryMovement::with('product')
            ->whereDate('tanggal', '>=', $startDate)
            ->whereDate('tanggal', '<=', $endDate);

        if ($search != '') {
            $query->where(function($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('product', function($q2) use ($search) {
                      $q2->where('nama_barang', 'like', "%{$search}%")
                         ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        if ($status != '' && $status != 'semua') {
            if ($status == 'masuk') {
                $query->where('tipe_pergerakan', 'masuk');
            } else {
                $query->where('tipe_pergerakan', 'keluar');
                if ($status == 'sudah_invoice') {
                    $query->where('keterangan', 'like', '%Penjualan Invoice%');
                } elseif ($status == 'belum_invoice') {
                    $query->where('keterangan', 'like', '%Mutasi Manual%');
                } elseif ($status == 'lainnya') {
                    $query->where('keterangan', 'not like', '%Penjualan Invoice%')
                          ->where('keterangan', 'not like', '%Mutasi Manual%');
                }
            }
        }

        $movements = $query->orderBy('tanggal', 'asc')->orderBy('id', 'asc')->get();

        $fileName = 'laporan_mutasi_stok_' . $startDate . '_sd_' . $endDate . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($movements, $startDate, $endDate, $status) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['LAPORAN MUTASI STOK BARANG'], ';');
            fputcsv($file, ['Periode:', Carbon::parse($startDate)->format('d/m/Y') . ' - ' . Carbon::parse($endDate)->format('d/m/Y')], ';');
            fputcsv($file, ['Filter Status:', strtoupper(str_replace('_', ' ', $status))], ';');
            fputcsv($file, [], ';');

            fputcsv($file, ['Tanggal', 'SKU', 'Nama Barang', 'Tipe Pergerakan', 'Jumlah', 'Keterangan', 'Status Invoice'], ';');

            foreach ($movements as $m) {
                $statusInvoice = '-';
                if ($m->tipe_pergerakan === 'keluar') {
                    if (strpos($m->keterangan, 'Penjualan Invoice') !== false) {
                        $statusInvoice = 'Sudah Invoice';
                    } elseif (strpos($m->keterangan, 'Mutasi Manual') !== false) {
                        $statusInvoice = 'Belum Invoice';
                    } else {
                        $statusInvoice = 'Lainnya (Kantor/Internal)';
                    }
                }

                fputcsv($file, [
                    Carbon::parse($m->tanggal)->format('d/m/Y'),
                    $m->product->sku ?? '-',
                    $m->product->nama_barang ?? '-',
                    $m->tipe_pergerakan === 'masuk' ? 'Masuk' : 'Keluar',
                    ($m->tipe_pergerakan === 'masuk' ? '+' : '-') . $m->jumlah,
                    $m->keterangan ?? '-',
                    $statusInvoice
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function expenses(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $kategori = $request->input('kategori');

        $query = Expense::whereDate('tanggal', '>=', $startDate)
                        ->whereDate('tanggal', '<=', $endDate);
        
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $expenses = $query->orderBy('tanggal', 'desc')->get();
        $totalPengeluaran = $expenses->sum('nominal');

        return view('reports.expenses', compact('expenses', 'totalPengeluaran', 'startDate', 'endDate', 'kategori'));
    }

    public function printExpenses(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $kategori = $request->input('kategori');

        $query = Expense::whereDate('tanggal', '>=', $startDate)
                        ->whereDate('tanggal', '<=', $endDate);
        
        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $expenses = $query->orderBy('tanggal', 'asc')->get();
        $totalPengeluaran = $expenses->sum('nominal');

        return view('reports.print-expenses', compact('expenses', 'totalPengeluaran', 'startDate', 'endDate', 'kategori'));
    }
}

