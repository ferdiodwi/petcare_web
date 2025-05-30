<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::latest()->get()->map(function ($product) {
                $imageUrl = $this->generateImageUrl($product->image_path);

                // Log untuk debugging
                Log::info('Product Image Processing', [
                    'product_id' => $product->id,
                    'original_path' => $product->image_path,
                    'generated_url' => $imageUrl,
                    'file_exists' => $this->checkImageExists($product->image_path)
                ]);

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description ?? 'No description available.',
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image_url' => $imageUrl,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ];
            });

            return response()->json([
                'status' => 'success',
                'data' => $products,
                'base_url' => config('app.url'),
                'storage_url' => config('app.url') . '/storage',
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch products',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = Product::find($id);

            if (!$product) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Product not found'
                ], 404);
            }

            $imageUrl = $this->generateImageUrl($product->image_path);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description ?? 'No description available.',
                    'price' => $product->price,
                    'stock' => $product->stock,
                    'image_url' => $imageUrl,
                    'created_at' => $product->created_at,
                    'updated_at' => $product->updated_at,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching product: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch product'
            ], 500);
        }
    }

    /**
     * PERBAIKAN: Test endpoint untuk validasi gambar
     */
    public function testImage($filename)
    {
        $possiblePaths = [
            storage_path('app/public/' . $filename),
            storage_path('app/public/products/' . $filename),
            public_path('storage/' . $filename),
            public_path('storage/products/' . $filename),
        ];

        foreach ($possiblePaths as $path) {
            if (file_exists($path) && is_file($path)) {
                $mimeType = mime_content_type($path);

                // Set proper headers
                $headers = [
                    'Content-Type' => $mimeType,
                    'Cache-Control' => 'public, max-age=31536000',
                    'Expires' => gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT',
                ];

                return response()->file($path, $headers);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Image not found',
            'searched_paths' => $possiblePaths
        ], 404);
    }

    /**
     * PERBAIKAN: Repair storage links
     */
    public function repairStorage()
    {
        try {
            // Check if storage link exists
            $publicStoragePath = public_path('storage');

            if (is_link($publicStoragePath)) {
                unlink($publicStoragePath);
            }

            if (is_dir($publicStoragePath)) {
                // If it's a directory, remove it
                File::deleteDirectory($publicStoragePath);
            }

            // Create symbolic link
            $target = storage_path('app/public');
            symlink($target, $publicStoragePath);

            return response()->json([
                'status' => 'success',
                'message' => 'Storage link repaired successfully',
                'target' => $target,
                'link' => $publicStoragePath,
                'link_exists' => is_link($publicStoragePath),
                'target_exists' => is_dir($target)
            ]);

        } catch (\Exception $e) {
            Log::error('Storage repair failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to repair storage link',
                'error' => $e->getMessage()
            ], 500);
        }
    }
// } PERBAIKAN: Generate proper image URL dengan validasi yang lebih baik
private function generateImageUrl($imagePath)
{
    // Jika tidak ada image path, return null
    if (!$imagePath) {
        return null;
    }

    // Jika sudah URL lengkap, ganti localhost dengan IP yang benar
    if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
        if (str_contains($imagePath, 'localhost')) {
            // PERBAIKAN: Ganti localhost dengan APP_URL dari config
            $imagePath = str_replace('http://localhost', config('app.url'), $imagePath);
        }
        return $imagePath;
    }

    // Clean the path
    $cleanPath = ltrim($imagePath, '/');

    // Remove common prefixes untuk normalisasi
    if (str_starts_with($cleanPath, 'storage/')) {
        $cleanPath = substr($cleanPath, 8);
    }
    if (str_starts_with($cleanPath, 'public/')) {
        $cleanPath = substr($cleanPath, 7);
    }

    // PERBAIKAN: Cek file di storage/app/public dulu
    $storagePath = storage_path('app/public/' . $cleanPath);
    if (file_exists($storagePath) && is_file($storagePath)) {
        return config('app.url') . '/storage/' . $cleanPath;
    }

    // Cek di storage/app/public/products/
    $productsPath = storage_path('app/public/products/' . $cleanPath);
    if (file_exists($productsPath) && is_file($productsPath)) {
        return config('app.url') . '/storage/products/' . $cleanPath;
    }

    // Log jika file tidak ditemukan
    Log::warning('Image file not found', [
        'original_path' => $imagePath,
        'clean_path' => $cleanPath,
        'storage_path' => $storagePath,
        'products_path' => $productsPath,
        'app_url' => config('app.url')
    ]);

    return null;
}

public function serveImage($filename)
{
    // Cari file di berbagai lokasi
    $possiblePaths = [
        storage_path('app/public/' . $filename),
        storage_path('app/public/products/' . $filename),
    ];

    foreach ($possiblePaths as $path) {
        if (file_exists($path) && is_file($path)) {
            $mimeType = mime_content_type($path);

            // Validasi bahwa ini adalah file gambar
            $validMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];

            if (in_array($mimeType, $validMimes)) {
                return response()->file($path, [
                    'Content-Type' => $mimeType,
                    'Cache-Control' => 'public, max-age=86400', // Cache 1 hari
                    'Access-Control-Allow-Origin' => '*',
                    'Access-Control-Allow-Methods' => 'GET',
                    'Access-Control-Allow-Headers' => 'Content-Type',
                ]);
            }
        }
    }

    // Jika tidak ditemukan, return 404
    return response()->json([
        'status' => 'error',
        'message' => 'Image not found',
        'filename' => $filename
    ], 404);
}

    /**
     * PERBAIKAN: Check image exists dengan validasi format
     */
    private function checkImageExists($imagePath)
    {
        if (!$imagePath) {
            return false;
        }

        $cleanPath = ltrim($imagePath, '/');

        // Remove common prefixes
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        }
        if (str_starts_with($cleanPath, 'public/')) {
            $cleanPath = substr($cleanPath, 7);
        }

        // Check multiple possible locations
        $paths = [
            storage_path('app/public/' . $cleanPath),
            storage_path('app/public/products/' . $cleanPath),
            public_path('storage/' . $cleanPath),
            public_path('storage/products/' . $cleanPath),
        ];

        foreach ($paths as $path) {
            if (file_exists($path) && is_file($path)) {
                // PERBAIKAN: Validasi juga apakah file benar-benar gambar
                $mimeType = mime_content_type($path);
                $validMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/bmp'];

                if (in_array($mimeType, $validMimes)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * PERBAIKAN: Upload image dengan validasi lebih ketat
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // PERBAIKAN: Validasi file integrity
                if (!$image->isValid()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Invalid image file'
                    ], 400);
                }

                // Generate unique filename
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                // Store in storage/app/public/products/
                $path = $image->storeAs('products', $filename, 'public');

                // PERBAIKAN: Verify file was actually stored
                $storedPath = storage_path('app/public/' . $path);
                if (!file_exists($storedPath)) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Failed to store image file'
                    ], 500);
                }

                // PERBAIKAN: Generate proper URL
                $imageUrl = config('app.url') . '/storage/' . $path;

                return response()->json([
                    'status' => 'success',
                    'message' => 'Image uploaded successfully',
                    'data' => [
                        'filename' => $filename,
                        'path' => $path,
                        'url' => $imageUrl,
                        'size' => $image->getSize(),
                        'mime_type' => $image->getMimeType(),
                        'stored_path' => $storedPath,
                        'file_exists' => file_exists($storedPath)
                    ]
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'No image file provided'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Image upload failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Image upload failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PERBAIKAN: Debug endpoint dengan informasi lebih lengkap
     */
    public function debugImages()
    {
        $products = Product::all();
        $debug = [];

        foreach ($products as $product) {
            $cleanPath = ltrim($product->image_path ?? '', '/');
            if (str_starts_with($cleanPath, 'storage/')) {
                $cleanPath = substr($cleanPath, 8);
            }
            if (str_starts_with($cleanPath, 'public/')) {
                $cleanPath = substr($cleanPath, 7);
            }

            $possiblePaths = [
                storage_path('app/public/' . $cleanPath),
                storage_path('app/public/products/' . $cleanPath),
                public_path('storage/' . $cleanPath),
                public_path('storage/products/' . $cleanPath),
            ];

            $existingPaths = [];
            $mimeTypes = [];

            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    $existingPaths[] = $path;
                    $mimeTypes[$path] = mime_content_type($path);
                }
            }

            $debug[] = [
                'id' => $product->id,
                'name' => $product->name,
                'original_path' => $product->image_path,
                'clean_path' => $cleanPath,
                'possible_paths' => $possiblePaths,
                'existing_paths' => $existingPaths,
                'mime_types' => $mimeTypes,
                'generated_url' => $this->generateImageUrl($product->image_path),
                'file_check' => $this->checkImageExists($product->image_path),
            ];
        }

        return response()->json([
            'status' => 'success',
            'debug_info' => $debug,
            'storage_path' => storage_path('app/public/'),
            'public_path' => public_path('storage/'),
            'app_url' => config('app.url'),
            'storage_link_exists' => is_link(public_path('storage')),
            'php_version' => PHP_VERSION,
            'gd_extension' => extension_loaded('gd'),
            'imagick_extension' => extension_loaded('imagick'),
        ]);
    }
}
