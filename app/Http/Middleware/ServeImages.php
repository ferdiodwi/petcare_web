<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServeImages
{
    public function handle(Request $request, Closure $next)
    {
        // Check if request is for an image in storage
        if ($request->is('storage/*')) {
            $path = str_replace('storage/', '', $request->path());

            // Try to find the file in various locations
            $possiblePaths = [
                storage_path('app/public/' . $path),
                storage_path('app/public/products/' . $path),
            ];

            foreach ($possiblePaths as $filePath) {
                if (file_exists($filePath) && is_file($filePath)) {
                    $mimeType = mime_content_type($filePath);

                    // Validate it's actually an image
                    if (str_starts_with($mimeType, 'image/')) {
                        return response()->file($filePath, [
                            'Content-Type' => $mimeType,
                            'Cache-Control' => 'public, max-age=31536000',
                        ]);
                    }
                }
            }
        }

        return $next($request);
    }
}
