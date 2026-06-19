<?php App\Models\Product::where('gambar', 'like', 'img/products/%')->get()->each(function($p) { $p->gambar = str_replace('img/products/', 'products/', $p->gambar); $p->save(); });
