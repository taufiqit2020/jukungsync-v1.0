<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InventoryMovement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalProducts = Product::count();
        
        $totalRevenueThisMonth = Invoice::completed()
                                        ->whereMonth('tanggal_invoice', $currentMonth)
                                        ->whereYear('tanggal_invoice', $currentYear)
                                        ->sum('total_tagihan');
                                        
        $totalInvoicesThisMonth = Invoice::completed()
                                         ->whereYear('tanggal_invoice', $currentYear)
                                         ->count();

        $lowStockProducts = Product::where('stok_saat_ini', '<', 10)
                                   ->orderBy('stok_saat_ini', 'asc')
                                   ->take(5)
                                   ->get();

        $recentMovements = InventoryMovement::with('product')
                                            ->latest('tanggal')
                                            ->latest('id')
                                            ->take(5)
                                            ->get();

        // Top 5 Produk Terlaris (sepanjang waktu)
        $topProducts = DB::table('invoice_items')
            ->join('products', 'invoice_items.product_id', '=', 'products.id')
            ->select('products.nama_barang', 'products.sku', DB::raw('SUM(invoice_items.jumlah) as total_terjual'))
            ->groupBy('products.id', 'products.nama_barang', 'products.sku')
            ->orderByDesc('total_terjual')
            ->take(5)
            ->get();

        // Data Grafik Penjualan 7 Hari Terakhir
        $chartDates = [];
        $chartRevenues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $revenue = Invoice::completed()->whereDate('tanggal_invoice', $date)->sum('total_tagihan');
            $chartDates[] = Carbon::parse($date)->format('d M');
            $chartRevenues[] = $revenue;
        }

        // FR-06: Stok Menipis (<= stok_minimum)
        $stokMenipis = Product::whereColumn('stok_saat_ini', '<=', 'stok_minimum')
                               ->orderBy('stok_saat_ini', 'asc')
                               ->limit(5)
                               ->get();

        // FR-06: Invoice Jatuh Tempo dalam 7 hari ke depan
        $invoiceJatuhTempo = Invoice::where('status_pembayaran', 'belum_lunas')
                                    ->whereBetween('tanggal_jatuh_tempo', [
                                        Carbon::today(),
                                        Carbon::today()->addDays(7),
                                    ])
                                    ->limit(5)
                                    ->get();

        // FR-06: Mutasi Pending (Mutasi Manual belum di-invoice)
        $mutasiPendingCount = InventoryMovement::where(function($q) {
                                    $q->where('keterangan', 'like', '%Mutasi Manual%')
                                      ->orWhere(function($q2) {
                                          $q2->where('keterangan', 'like', '[%')
                                             ->where('tipe_pergerakan', 'keluar');
                                      });
                                })->count();

        // FR-06: Top 3 Customer bulan ini
        $topCustomers = DB::table('invoices')
            ->select('nama_klien', DB::raw('SUM(total_tagihan) as total_transaksi'))
            ->whereMonth('tanggal_invoice', $currentMonth)
            ->whereYear('tanggal_invoice', $currentYear)
            ->whereNull('jenis_transaksi')
            ->orWhere(function($q) use ($currentMonth, $currentYear) {
                $q->whereMonth('tanggal_invoice', $currentMonth)
                  ->whereYear('tanggal_invoice', $currentYear)
                  ->where('jenis_transaksi', '!=', 'online');
            })
            ->groupBy('nama_klien')
            ->orderByDesc('total_transaksi')
            ->limit(3)
            ->get();

        // FR-06: Omzet Bulan Lalu
        $lastMonth = Carbon::now()->subMonth();
        $omzetBulanLalu = Invoice::completed()
                                  ->whereMonth('tanggal_invoice', $lastMonth->month)
                                  ->whereYear('tanggal_invoice', $lastMonth->year)
                                  ->sum('total_tagihan');

        return view('dashboard', compact(
            'totalProducts', 
            'totalRevenueThisMonth', 
            'totalInvoicesThisMonth', 
            'lowStockProducts', 
            'recentMovements',
            'topProducts',
            'chartDates',
            'chartRevenues',
            'stokMenipis',
            'invoiceJatuhTempo',
            'mutasiPendingCount',
            'topCustomers',
            'omzetBulanLalu'
        ));
    }
}

