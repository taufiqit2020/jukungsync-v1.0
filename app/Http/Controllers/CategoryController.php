<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        session(['categories_url' => $request->fullUrl()]);
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->nama_kategori);
        if (Category::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        Category::create([
            'nama_kategori' => $request->nama_kategori,
            'slug' => $slug,
        ]);

        return redirect(session('categories_url', route('categories.index')))->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->nama_kategori);
        if (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug .= '-' . time();
        }

        $category->update([
            'nama_kategori' => $request->nama_kategori,
            'slug' => $slug,
        ]);

        return redirect(session('categories_url', route('categories.index')))->with('success', 'Kategori berhasil diubah.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(session('categories_url', route('categories.index')))->with('success', 'Kategori berhasil dihapus.');
    }
}
