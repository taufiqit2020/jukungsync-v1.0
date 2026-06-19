<?php

namespace App\Http\Controllers;

use App\Models\Merk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MerkController extends Controller
{
    public function index(Request $request)
    {
        session(['merks_url' => $request->fullUrl()]);
        $merks = Merk::latest()->paginate(10);
        return view('merks.index', compact('merks'));
    }

    public function create()
    {
        return view('merks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_merk' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->nama_merk);
        if (Merk::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        Merk::create([
            'nama_merk' => $request->nama_merk,
            'slug' => $slug,
        ]);

        return redirect(session('merks_url', route('merks.index')))->with('success', 'Merk berhasil ditambahkan.');
    }

    public function edit(Merk $merk)
    {
        return view('merks.edit', compact('merk'));
    }

    public function update(Request $request, Merk $merk)
    {
        $request->validate([
            'nama_merk' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->nama_merk);
        if (Merk::where('slug', $slug)->where('id', '!=', $merk->id)->exists()) {
            $slug .= '-' . time();
        }

        $merk->update([
            'nama_merk' => $request->nama_merk,
            'slug' => $slug,
        ]);

        return redirect(session('merks_url', route('merks.index')))->with('success', 'Merk berhasil diubah.');
    }

    public function destroy(Merk $merk)
    {
        // Karena kita set nullable, produk tidak akan terhapus, merk_id nya akan jadi null
        $merk->delete();
        return redirect(session('merks_url', route('merks.index')))->with('success', 'Merk berhasil dihapus. Produk dengan merk ini kini tidak bermerk.');
    }
}
