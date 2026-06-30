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
        $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'merk_id'      => 'nullable|exists:merks,id',
            'sku'          => 'required|string|unique:products,sku',
            'nama_barang'  => 'required|string|max:255',
            'satuan'       => 'nullable|string|max:50',
            'deskripsi'    => 'nullable|string',
            'harga_modal'  => 'required|numeric|min:0',
            'harga_jual'   => 'required|numeric|min:0',
            'harga_grosir' => 'nullable|numeric|min:0',
            'stok_saat_ini'=> 'required|integer|min:0',
            'stok_minimum' => 'nullable|integer|min:0',
            'gambar'       => 'nullable|array|max:5',
            'gambar.*'     => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        // Upload gambar
        $savedPaths = [];
        if ($request->hasFile('gambar')) {
            foreach ((array) $request->file('gambar') as $file) {
                if ($file && $file->isValid()) {
                    $path = $file->store('products', 'public');
                    $dest = public_path('storage/' . $path);
                    @mkdir(dirname($dest), 0777, true);
                    @copy(storage_path('app/public/' . $path), $dest);
                    $savedPaths[] = $path;
                }
            }
        }

        Product::create([
            'category_id'    => $request->category_id,
            'merk_id'        => $request->merk_id ?: null,
            'sku'            => $request->sku,
            'nama_barang'    => $request->nama_barang,
            'satuan'         => $request->satuan ?: null,
            'deskripsi'      => $request->deskripsi ?: null,
            'harga_modal'    => $request->harga_modal,
            'harga_jual'     => $request->harga_jual,
            'harga_grosir'   => $request->harga_grosir ?: null,
            'stok_saat_ini'  => $request->stok_saat_ini,
            'stok_minimum'   => $request->stok_minimum ?? 0,
            'gambar'         => $savedPaths[0] ?? null,
            'gambar_tambahan'=> count($savedPaths) > 1 ? array_slice($savedPaths, 1) : null,
        ]);

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
        $request->validate([
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
            'gambar' => 'nullable|array|max:5',
            'gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'existing_images' => 'nullable|array',
        ]);

        // Dapatkan gambar lama
        $oldImages = $product->all_images;
        
        // Dapatkan gambar lama yang dipertahankan
        $keptImages = $request->input('existing_images', []);
        
        // Hapus gambar lama yang tidak dipertahankan
        foreach ($oldImages as $oldImg) {
            if (!in_array($oldImg, $keptImages)) {
                if (!$this->isDefaultImage($oldImg)) {
                    Storage::disk('public')->delete($oldImg);
                    @unlink(public_path('storage/' . $oldImg));
                }
            }
        }
        
        // Upload gambar baru
        $newImages = [];
        if ($request->hasFile('gambar')) {
            $uploadedFiles = $request->file('gambar');
            if (is_array($uploadedFiles)) {
                foreach ($uploadedFiles as $file) {
                    if ($file && $file->isValid()) {
                        $path = $file->store('products', 'public');
                        $dest = public_path('storage/' . $path);
                        @mkdir(dirname($dest), 0777, true);
                        @copy(storage_path('app/public/' . $path), $dest);
                        $newImages[] = $path;
                    }
                }
            }
        }
        
        // Gabungkan gambar lama yang disimpan & gambar baru
        $allFinalImages = array_merge($keptImages, $newImages);
        $allFinalImages = array_slice($allFinalImages, 0, 5);
        
        // Update data secara eksplisit
        $product->category_id = $request->category_id;
        $product->merk_id = $request->merk_id ?: null;
        $product->sku = $request->sku;
        $product->nama_barang = $request->nama_barang;
        $product->satuan = $request->satuan ?: null;
        $product->deskripsi = $request->deskripsi ?: null;
        $product->harga_modal = $request->harga_modal;
        $product->harga_jual = $request->harga_jual;
        $product->harga_grosir = $request->harga_grosir ?: null;
        $product->stok_saat_ini = $request->stok_saat_ini;
        $product->stok_minimum = $request->stok_minimum ?? 0;
        $product->gambar = $allFinalImages[0] ?? null;
        $product->gambar_tambahan = count($allFinalImages) > 1 ? array_slice($allFinalImages, 1) : null;
        $product->save();

        return redirect(session('products_url', route('products.index')))->with('success', 'Barang berhasil diubah.');
    }

    public function destroy(Product $product)
    {
        try {
            $allImages = $product->all_images;
            $product->delete();
            
            foreach ($allImages as $img) {
                if ($img && !$this->isDefaultImage($img)) {
                    Storage::disk('public')->delete($img);
                    @unlink(public_path('storage/' . $img));
                }
            }
            return redirect(session('products_url', route('products.index')))->with('success', 'Barang berhasil dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect(session('products_url', route('products.index')))->with('error', 'Barang tidak dapat dihapus karena sudah memiliki riwayat transaksi (Invoice/Pergerakan Stok).');
            }
            return redirect(session('products_url', route('products.index')))->with('error', 'Terjadi kesalahan sistem saat menghapus barang.');
        }
    }

    private function isDefaultImage($path)
    {
        if (empty($path)) {
            return false;
        }
        $defaultNames = [
            'umum.png', 'kertas.png', 'pulpen.png', 'lakban.png', 'tinta.png', 
            'pengharum.png', 'spray.png', 'sabun.png', 'popok.png', 'minyak.png', 
            'pakaian.png', 'perawatan.png'
        ];
        $filename = basename($path);
        return in_array(strtolower($filename), $defaultNames);
    }
}
