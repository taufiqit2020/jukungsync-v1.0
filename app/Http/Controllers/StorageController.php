<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class StorageController extends Controller
{
    public function serve($path)
    {
        // Path fisik di dalam folder storage aman (storage/app/public)
        $filePath = storage_path('app/public/' . $path);

        if (!File::exists($filePath)) {
            // Fallback 1: Cek apakah ada di folder public/img/ (yang di-track oleh git)
            $fallbackPath = public_path('img/' . $path);
            if (File::exists($fallbackPath)) {
                return Response::file($fallbackPath);
            }

            // Fallback 2: Jika gambar produk default tidak ditemukan
            $filename = basename($path);
            $defaultProducts = [
                'kertas.png', 'lakban.png', 'minyak.png', 'pakaian.png',
                'pengharum.png', 'perawatan.png', 'popok.png', 'pulpen.png',
                'sabun.png', 'spray.png', 'tinta.png', 'umum.png'
            ];

            if (in_array($filename, $defaultProducts)) {
                $defaultPath = public_path('img/products/' . $filename);
                if (File::exists($defaultPath)) {
                    return Response::file($defaultPath);
                }
            }

            // Fallback 3: Gunakan gambar default umum (umum.png) jika gambar tidak ditemukan sama sekali
            $generalDefault = public_path('img/products/umum.png');
            if (File::exists($generalDefault)) {
                return Response::file($generalDefault);
            }

            // Terakhir: abort 404 jika benar-benar tidak ada
            abort(404);
        }

        return Response::file($filePath);
    }
}
