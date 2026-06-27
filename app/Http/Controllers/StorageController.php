<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class StorageController extends Controller
{
    public function serve($path)
    {
        $decodedPath = urldecode($path);
        $filename = basename($decodedPath);

        // Check potential file locations in order of priority:
        $candidates = [
            storage_path('app/public/' . $decodedPath),
            storage_path('app/public/products/' . $filename),
            public_path('storage/' . $decodedPath),
            public_path('storage/products/' . $filename),
            public_path('img/products/' . $filename),
            public_path('img/' . $decodedPath),
        ];

        $realPath = null;
        foreach ($candidates as $candidate) {
            if (File::exists($candidate) && !is_dir($candidate)) {
                $realPath = $candidate;
                break;
            }
        }

        if (!$realPath) {
            // Fallback to general default image
            $generalDefault = public_path('img/products/umum.png');
            if (File::exists($generalDefault)) {
                $realPath = $generalDefault;
            } else {
                abort(404);
            }
        }

        // Auto-mirror to public/storage/$decodedPath for super-fast static serving
        try {
            $destPublic = public_path('storage/' . $decodedPath);
            if (!File::exists($destPublic)) {
                File::makeDirectory(dirname($destPublic), 0777, true, true);
                File::copy($realPath, $destPublic);
            }
        } catch (\Throwable $e) {
            // Ignore copy error and proceed serving file
        }

        $mimeType = File::mimeType($realPath) ?: 'image/jpeg';
        return response()->file($realPath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
