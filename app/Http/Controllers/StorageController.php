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

        // Case-insensitive fallback search in products folder if not found directly
        if (!$realPath) {
            $foldersToScan = [
                storage_path('app/public/products'),
                public_path('storage/products'),
                public_path('img/products')
            ];

            $targetLower = strtolower($filename);
            $targetNoExt = strtolower(pathinfo($filename, PATHINFO_FILENAME));

            foreach ($foldersToScan as $folder) {
                if (!File::isDirectory($folder)) continue;
                $files = File::files($folder);
                foreach ($files as $fileObj) {
                    $fnLower = strtolower($fileObj->getFilename());
                    $fnNoExt = strtolower(pathinfo($fileObj->getFilename(), PATHINFO_FILENAME));
                    if ($fnLower === $targetLower || $fnNoExt === $targetNoExt) {
                        $realPath = $fileObj->getRealPath();
                        break 2;
                    }
                }
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
            // Ignore copy error
        }

        $mimeType = File::mimeType($realPath) ?: 'image/jpeg';
        return response()->file($realPath, [
            'Content-Type' => $mimeType,
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
