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
