<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Product;
use App\Models\InventoryMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::orderBy('tanggal_pembelian', 'desc')->orderBy('id', 'desc')->paginate(15);
        $products = Product::orderBy('sku', 'asc')->get();
        
        foreach ($products as $p) {
            $lastPurchaseItem = PurchaseItem::where('product_id', $p->id)
                ->latest('id')
                ->first();
                
            $p->harga_beli_terakhir = $lastPurchaseItem ? (float) $lastPurchaseItem->harga_beli : (float) $p->harga_modal;
            $p->harga_jual_terakhir = $lastPurchaseItem && isset($lastPurchaseItem->harga_jual) ? (float) $lastPurchaseItem->harga_jual : (float) $p->harga_jual;

            // Get last 5 purchase history
            $p->history = PurchaseItem::where('product_id', $p->id)
                ->with('purchase')
                ->latest('id')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return [
                        'tanggal' => $item->purchase ? \Carbon\Carbon::parse($item->purchase->tanggal_pembelian)->format('d/m/Y') : '-',
                        'faktur' => $item->purchase ? $item->purchase->nomor_faktur : '-',
                        'supplier' => $item->purchase ? $item->purchase->nama_supplier : '-',
                        'harga_beli' => (float) $item->harga_beli,
                        'harga_jual' => (float) $item->harga_jual,
                    ];
                })->toArray();
        }
        
        return view('purchases.index', compact('purchases', 'products'));
    }

    public function create()
    {
        $products = Product::orderBy('sku', 'asc')
            ->get(['id', 'sku', 'nama_barang', 'stok_saat_ini', 'harga_modal', 'harga_jual']);
        return view('purchases.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_faktur' => 'required|string|unique:purchases,nomor_faktur',
            'nama_supplier' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'keterangan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|string',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
            'items.*.harga_jual' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();
            
            $total_biaya = 0;
            
            $purchase = Purchase::create([
                'nomor_faktur' => $request->nomor_faktur,
                'nama_supplier' => $request->nama_supplier,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'keterangan' => $request->keterangan,
                'total_biaya' => 0,
            ]);

            foreach ($request->items as $item) {
                $productId = $item['product_id'];
                
                // Cek apakah product_id adalah ID numerik yang valid di tabel products
                if (is_numeric($productId) && Product::where('id', $productId)->exists()) {
                    $product = Product::lockForUpdate()->findOrFail($productId);
                } else {
                    // Ini adalah barang baru yang dimasukkan secara manual!
                    // Dapatkan category_id default (Kategori pertama atau buat baru)
                    $category = \App\Models\Category::first();
                    if (!$category) {
                        $category = \App\Models\Category::create(['nama_kategori' => 'Umum']);
                    }
                    
                    // Generate SKU unik
                    $sku = 'BRG-' . strtoupper(uniqid());
                    while (Product::where('sku', $sku)->exists()) {
                        $sku = 'BRG-' . strtoupper(uniqid());
                    }
                    
                    $product = Product::create([
                        'category_id' => $category->id,
                        'sku' => $sku,
                        'nama_barang' => $productId, // Nama barang yang diketik manual
                        'harga_modal' => $item['harga_beli'],
                        'harga_jual' => $item['harga_jual'],
                        'stok_saat_ini' => 0,
                        'satuan' => 'Pcs',
                    ]);
                }
                
                $total_harga_item = $item['harga_beli'] * $item['jumlah'];
                $total_biaya += $total_harga_item;

                // Tambah Stok & Update Harga Modal + Harga Jual otomatis
                $product->stok_saat_ini += $item['jumlah'];
                $product->harga_modal = $item['harga_beli'];
                $product->harga_jual = $item['harga_jual'];
                $product->save();

                // Create Inventory Movement
                InventoryMovement::create([
                    'product_id' => $product->id,
                    'tipe_pergerakan' => 'masuk',
                    'jumlah' => $item['jumlah'],
                    'tanggal' => $request->tanggal_pembelian,
                    'keterangan' => 'Restok Faktur ' . $purchase->nomor_faktur . ' dari ' . $purchase->nama_supplier,
                ]);

                // Create Purchase Item dengan harga_jual snapshot
                PurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $product->id,
                    'jumlah' => $item['jumlah'],
                    'harga_beli' => $item['harga_beli'],
                    'harga_jual' => $item['harga_jual'],
                    'total_harga' => $total_harga_item,
                ]);
            }

            $purchase->update([
                'total_biaya' => $total_biaya,
            ]);

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'Data Barang Masuk berhasil dicatat, stok bertambah, dan harga barang diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load('purchaseItems.product.category');
        return view('purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        $purchase->load('purchaseItems.product');
        $products = Product::orderBy('sku', 'asc')
            ->get(['id', 'sku', 'nama_barang', 'stok_saat_ini', 'harga_modal', 'harga_jual']);
        
        foreach ($products as $p) {
            $lastPurchaseItem = PurchaseItem::where('product_id', $p->id)
                ->latest('id')
                ->first();
                
            $p->harga_beli_terakhir = $lastPurchaseItem ? (float) $lastPurchaseItem->harga_beli : (float) $p->harga_modal;
            $p->harga_jual_terakhir = $lastPurchaseItem && isset($lastPurchaseItem->harga_jual) ? (float) $lastPurchaseItem->harga_jual : (float) $p->harga_jual;

            // Get last 5 purchase history
            $p->history = PurchaseItem::where('product_id', $p->id)
                ->with('purchase')
                ->latest('id')
                ->limit(5)
                ->get()
                ->map(function($item) {
                    return [
                        'tanggal' => $item->purchase ? \Carbon\Carbon::parse($item->purchase->tanggal_pembelian)->format('d/m/Y') : '-',
                        'faktur' => $item->purchase ? $item->purchase->nomor_faktur : '-',
                        'supplier' => $item->purchase ? $item->purchase->nama_supplier : '-',
                        'harga_beli' => (float) $item->harga_beli,
                        'harga_jual' => (float) $item->harga_jual,
                    ];
                })->toArray();
        }

        return view('purchases.edit', compact('purchase', 'products'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'nomor_faktur' => 'required|string|unique:purchases,nomor_faktur,' . $purchase->id,
            'nama_supplier' => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'keterangan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|string',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.harga_beli' => 'required|numeric|min:0',
            'items.*.harga_jual' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $oldFaktur = $purchase->nomor_faktur;
            $oldSupplier = $purchase->nama_supplier;

            // 1. Load old items
            $purchase->load('purchaseItems');

            // 2. Delete old inventory movements
            InventoryMovement::where('tipe_pergerakan', 'masuk')
                ->where('keterangan', 'Restok Faktur ' . $oldFaktur . ' & dari ' . $oldSupplier)
                ->orWhere('keterangan', 'Restok Faktur ' . $oldFaktur . ' dari ' . $oldSupplier)
                ->delete();

            // 3. Deduct stock for deleted/changed items
            foreach ($purchase->purchaseItems as $oldItem) {
                $stillExists = false;
                foreach ($request->items as $submittedItem) {
                    if ($submittedItem['product_id'] == $oldItem->product_id) {
                        $stillExists = true;
                        break;
                    }
                }
                
                if (!$stillExists) {
                    $product = Product::lockForUpdate()->find($oldItem->product_id);
                    if ($product) {
                        $product->stok_saat_ini -= $oldItem->jumlah;
                        $product->save();
                    }
                    $oldItem->delete();
                }
            }

            // 4. Update or Create items
            $total_biaya = 0;

            foreach ($request->items as $itemData) {
                $productId = $itemData['product_id'];
                
                if (is_numeric($productId) && Product::where('id', $productId)->exists()) {
                    $product = Product::lockForUpdate()->findOrFail($productId);
                } else {
                    // Create new product if manually typed
                    $category = \App\Models\Category::first();
                    if (!$category) {
                        $category = \App\Models\Category::create(['nama_kategori' => 'Umum']);
                    }
                    $sku = 'BRG-' . strtoupper(uniqid());
                    while (Product::where('sku', $sku)->exists()) {
                        $sku = 'BRG-' . strtoupper(uniqid());
                    }
                    $product = Product::create([
                        'category_id' => $category->id,
                        'sku' => $sku,
                        'nama_barang' => $productId,
                        'harga_modal' => $itemData['harga_beli'],
                        'harga_jual' => $itemData['harga_jual'],
                        'stok_saat_ini' => 0,
                        'satuan' => 'Pcs',
                    ]);
                }

                $existingItem = PurchaseItem::where('purchase_id', $purchase->id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($existingItem) {
                    $selisihQty = $itemData['jumlah'] - $existingItem->jumlah;
                    $product->stok_saat_ini += $selisihQty;
                    $product->harga_modal = $itemData['harga_beli'];
                    $product->harga_jual = $itemData['harga_jual'];
                    $product->save();

                    $existingItem->update([
                        'jumlah' => $itemData['jumlah'],
                        'harga_beli' => $itemData['harga_beli'],
                        'harga_jual' => $itemData['harga_jual'],
                        'total_harga' => $itemData['harga_beli'] * $itemData['jumlah'],
                    ]);
                } else {
                    $product->stok_saat_ini += $itemData['jumlah'];
                    $product->harga_modal = $itemData['harga_beli'];
                    $product->harga_jual = $itemData['harga_jual'];
                    $product->save();

                    PurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'product_id' => $product->id,
                        'jumlah' => $itemData['jumlah'],
                        'harga_beli' => $itemData['harga_beli'],
                        'harga_jual' => $itemData['harga_jual'],
                        'total_harga' => $itemData['harga_beli'] * $itemData['jumlah'],
                    ]);
                }

                $total_biaya += $itemData['harga_beli'] * $itemData['jumlah'];

                // Create movement
                InventoryMovement::create([
                    'product_id' => $product->id,
                    'tipe_pergerakan' => 'masuk',
                    'jumlah' => $itemData['jumlah'],
                    'tanggal' => $request->tanggal_pembelian,
                    'keterangan' => 'Restok Faktur ' . $request->nomor_faktur . ' dari ' . $request->nama_supplier,
                ]);
            }

            $purchase->update([
                'nomor_faktur' => $request->nomor_faktur,
                'nama_supplier' => $request->nama_supplier,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'keterangan' => $request->keterangan,
                'total_biaya' => $total_biaya,
            ]);

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'Data Pembelian Barang Masuk dan stok master barang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(Purchase $purchase)
    {
        try {
            DB::beginTransaction();

            $purchase->load('purchaseItems');

            foreach ($purchase->purchaseItems as $item) {
                $product = Product::lockForUpdate()->find($item->product_id);
                if ($product) {
                    $product->stok_saat_ini -= $item->jumlah;
                    $product->save();
                }
            }

            // Hapus data inventory movements
            InventoryMovement::where('tipe_pergerakan', 'masuk')
                ->where('keterangan', 'Restok Faktur ' . $purchase->nomor_faktur . ' dari ' . $purchase->nama_supplier)
                ->delete();

            $purchase->purchaseItems()->delete();
            $purchase->delete();

            DB::commit();

            return redirect()->route('purchases.index')->with('success', 'Data Barang Masuk berhasil dihapus dan stok produk telah dikurangi.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
