<?php

namespace App\Http\Controllers;

use App\Models\InventoryMovement;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryMovementController extends Controller
{
    public function index(Request $request)
    {
        session(['inventory_movements_url' => $request->fullUrl()]);
        
        $query = InventoryMovement::with('product');

        // Apply Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('product', function($q2) use ($search) {
                      $q2->where('nama_barang', 'like', "%{$search}%")
                         ->orWhere('sku', 'like', "%{$search}%");
                  });
            });
        }

        // Apply Filter Status
        if ($request->has('status') && $request->status != '' && $request->status != 'semua') {
            if ($request->status == 'masuk') {
                $query->where('tipe_pergerakan', 'masuk');
            } else {
                $query->where('tipe_pergerakan', 'keluar');
                if ($request->status == 'sudah_invoice') {
                    $query->where('keterangan', 'like', '%Penjualan Invoice%');
                } elseif ($request->status == 'belum_invoice') {
                    $query->where('keterangan', 'like', '%Mutasi Manual%');
                } elseif ($request->status == 'lainnya') {
                    $query->where('keterangan', 'not like', '%Penjualan Invoice%')
                          ->where('keterangan', 'not like', '%Mutasi Manual%');
                }
            }
        }

        $movements = $query->orderBy('tanggal', 'desc')->orderBy('id', 'asc')->paginate(15)->withQueryString();

        // Summaries
        $countMasuk = InventoryMovement::where('tipe_pergerakan', 'masuk')->count();
        $countSudahInvoice = InventoryMovement::where('tipe_pergerakan', 'keluar')
            ->where('keterangan', 'like', '%Penjualan Invoice%')->count();
        $countBelumInvoice = InventoryMovement::where('tipe_pergerakan', 'keluar')
            ->where('keterangan', 'like', '%Mutasi Manual%')->count();
        $countLainnya = InventoryMovement::where('tipe_pergerakan', 'keluar')
            ->where('keterangan', 'not like', '%Penjualan Invoice%')
            ->where('keterangan', 'not like', '%Mutasi Manual%')->count();

        return view('inventory-movements.index', compact('movements', 'countMasuk', 'countSudahInvoice', 'countBelumInvoice', 'countLainnya'));
    }

    public function create()
    {
        $products = Product::orderBy('sku', 'asc')->get();
        $customers = Customer::orderBy('nama_klien', 'asc')->get();
        return view('inventory-movements.create', compact('products', 'customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe_pergerakan' => 'required|in:masuk,keluar',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.jumlah' => 'required|integer|min:1',
            'customer' => 'nullable|string'
        ]);

        if (!empty($request->customer)) {
            $validated['keterangan'] = '[' . $request->customer . '] ' . ($validated['keterangan'] ?? 'Mutasi Manual');
        }

        try {
            DB::transaction(function () use ($validated) {
                foreach ($validated['items'] as $item) {
                    $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                    if ($validated['tipe_pergerakan'] === 'keluar') {
                        if ($product->stok_saat_ini < $item['jumlah']) {
                            throw new \Exception('Stok barang ' . $product->nama_barang . ' tidak mencukupi. Stok saat ini: ' . $product->stok_saat_ini);
                        }
                        $product->stok_saat_ini -= $item['jumlah'];
                    } else {
                        $product->stok_saat_ini += $item['jumlah'];
                    }

                    $product->save();
                    
                    InventoryMovement::create([
                        'product_id' => $item['product_id'],
                        'tipe_pergerakan' => $validated['tipe_pergerakan'],
                        'jumlah' => $item['jumlah'],
                        'tanggal' => $validated['tanggal'],
                        'keterangan' => $validated['keterangan'],
                    ]);
                }
            });

            return redirect(session('inventory_movements_url', route('inventory-movements.index')))->with('success', 'Pergerakan stok berhasil dicatat.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
    public function edit(InventoryMovement $inventoryMovement)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Hanya Superadmin yang dapat mengedit pergerakan stok.');
        }
        $products = Product::orderBy('sku', 'asc')->get();
        $customers = Customer::orderBy('nama_klien', 'asc')->get();
        return view('inventory-movements.edit', compact('inventoryMovement', 'products'));
    }

    public function update(Request $request, InventoryMovement $inventoryMovement)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Hanya Superadmin yang dapat mengedit pergerakan stok.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'tipe_pergerakan' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($validated, $inventoryMovement) {
                // 1. Revert old stock
                $oldProduct = Product::lockForUpdate()->findOrFail($inventoryMovement->product_id);
                if ($inventoryMovement->tipe_pergerakan === 'keluar') {
                    $oldProduct->stok_saat_ini += $inventoryMovement->jumlah;
                } else {
                    $oldProduct->stok_saat_ini -= $inventoryMovement->jumlah;
                }
                $oldProduct->save();

                // 2. Apply new stock
                $newProduct = Product::lockForUpdate()->findOrFail($validated['product_id']);
                if ($validated['tipe_pergerakan'] === 'keluar') {
                    if ($newProduct->stok_saat_ini < $validated['jumlah']) {
                        throw new \Exception('Stok barang ' . $newProduct->nama_barang . ' tidak mencukupi. Stok saat ini: ' . $newProduct->stok_saat_ini);
                    }
                    $newProduct->stok_saat_ini -= $validated['jumlah'];
                } else {
                    $newProduct->stok_saat_ini += $validated['jumlah'];
                }
                $newProduct->save();

                // 3. Update movement record
                $inventoryMovement->update($validated);
            });

            return redirect(session('inventory_movements_url', route('inventory-movements.index')))->with('success', 'Pergerakan stok berhasil diubah.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(InventoryMovement $inventoryMovement)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Hanya Superadmin yang dapat menghapus pergerakan stok.');
        }

        try {
            DB::transaction(function () use ($inventoryMovement) {
                // Revert stock
                $product = Product::lockForUpdate()->findOrFail($inventoryMovement->product_id);
                if ($inventoryMovement->tipe_pergerakan === 'keluar') {
                    $product->stok_saat_ini += $inventoryMovement->jumlah;
                } else {
                    $product->stok_saat_ini -= $inventoryMovement->jumlah;
                }
                $product->save();

                $inventoryMovement->delete();
            });

            return redirect(session('inventory_movements_url', route('inventory-movements.index')))->with('success', 'Pergerakan stok berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}

