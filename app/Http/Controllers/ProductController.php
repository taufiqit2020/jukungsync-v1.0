<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Merk;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'merk'])->orderBy('sku', 'asc');
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('sku', 'like', '%' . $search . '%')
                  ->orWhere('nama_barang', 'like', '%' . $search . '%');
            });
        }
        
        $products = $query->paginate(10)->withQueryString();
        session(['products_url' => $request->fullUrl()]);
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        $merks = Merk::all();
        return view('products.create', compact('categories', 'merks'));
    }

    public function nextSku(Request $request)
    {
        $categoryId = $request->query('category_id');
        if (!$categoryId) {
            return response()->json(['sku' => '']);
        }

        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json(['sku' => '']);
        }

        // Tentukan prefix berdasarkan kategori secara ketat (strict mapping)
        $name = strtolower($category->nama_kategori);
        if (str_contains($name, 'atk')) {
            $prefix = 'A';
        } elseif (str_contains($name, 'kebersihan')) {
            $prefix = 'B';
        } elseif (str_contains($name, 'ibu') || str_contains($name, 'bayi')) {
            $prefix = 'C';
        } elseif (str_contains($name, 'ipsrs')) {
            $prefix = 'D';
        } elseif (str_contains($name, 'lainnya')) {
            $prefix = 'E';
        } elseif (str_contains($name, 'plastik')) {
            $prefix = 'P';
        } else {
            // Gunakan huruf pertama nama kategori jika tidak cocok
            $prefix = strtoupper(substr($category->nama_kategori, 0, 1));
            if (!$prefix || !preg_match('/[A-Z]/', $prefix)) {
                $prefix = 'BRG';
            }
        }

        // Cari nomor maksimal untuk prefix ini
        // Kita mencocokkan pattern $prefix diikuti dengan tanda hubung (-) opsional dan angka
        $skus = Product::where('sku', 'like', $prefix . '%')
            ->pluck('sku')
            ->toArray();

        $maxNum = 0;
        foreach ($skus as $sku) {
            if (preg_match('/^' . preg_quote($prefix, '/') . '-?([0-9]+)$/i', $sku, $matches)) {
                $num = (int)$matches[1];
                if ($num > $maxNum) {
                    $maxNum = $num;
                }
            }
        }

        $nextNum = $maxNum + 1;
        $nextSku = $prefix . '-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

        return response()->json(['sku' => $nextSku]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'merk_id' => 'nullable|exists:merks,id',
            'sku' => 'required|string|unique:products,sku',
            'nama_barang' => 'required|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'harga_grosir' => 'nullable|numeric|min:0',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimum' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        Product::create($validated);

        return redirect(session('products_url', route('products.index')))->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        $merks = Merk::all();
        return view('products.edit', compact('product', 'categories', 'merks'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'merk_id' => 'nullable|exists:merks,id',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'nama_barang' => 'required|string|max:255',
            'satuan' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
            'harga_modal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'harga_grosir' => 'nullable|numeric|min:0',
            'stok_saat_ini' => 'required|integer|min:0',
            'stok_minimum' => 'nullable|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        $product->update($validated);

        return redirect(session('products_url', route('products.index')))->with('success', 'Barang berhasil diubah.');
    }

    public function destroy(Product $product)
    {
        try {
            $gambarPath = $product->gambar;
            $product->delete();
            
            if ($gambarPath) {
                Storage::disk('public')->delete($gambarPath);
            }
            return redirect(session('products_url', route('products.index')))->with('success', 'Barang berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect(session('products_url', route('products.index')))->with('error', 'Barang tidak dapat dihapus karena sudah memiliki riwayat transaksi (Invoice/Pergerakan Stok).');
            }
            return redirect(session('products_url', route('products.index')))->with('error', 'Terjadi kesalahan sistem saat menghapus barang.');
        }
    }
}
