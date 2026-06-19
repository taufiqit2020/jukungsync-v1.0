<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));
        if (strlen($q) < 2) return response()->json(['results' => []]);

        $products = Product::where('nama_barang', 'like', "%{$q}%")
            ->orWhere('sku', 'like', "%{$q}%")
            ->limit(5)->get(['id','sku','nama_barang','stok_saat_ini']);

        $invoices = Invoice::where('nomor_invoice', 'like', "%{$q}%")
            ->orWhere('nama_klien', 'like', "%{$q}%")
            ->limit(5)->get(['id','nomor_invoice','nama_klien','total_tagihan','tanggal_invoice']);

        $customers = Customer::where('nama_klien', 'like', "%{$q}%")
            ->limit(5)->get(['id','nama_klien']);

        return response()->json([
            'results' => [
                'products' => $products,
                'invoices' => $invoices,
                'customers' => $customers,
            ]
        ]);
    }
}
