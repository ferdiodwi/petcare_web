<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get()->map(function ($product) {
            $product->image_url = $this->generateImageUrl($product->image_path);
            $product->description = $product->description ?? 'No description available.';

            // Remove sensitive path info for API response
            unset($product->image_path);

            return $product;
        });

        return response()->json([
            'status' => 'success',
            'data' => $products,
            'base_url' => config('app.url'), // Use config instead of hardcoded
        ]);
    }

    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        $product->image_url = $this->generateImageUrl($product->image_path);
        $product->description = $product->description ?? 'No description available.';

        // Remove sensitive path info for API response
        unset($product->image_path);

        return response()->json([
            'status' => 'success',
            'data' => $product
        ]);
    }

    /**
     * Generate proper image URL from stored path
     */
    private function generateImageUrl($imagePath)
    {
        // If no image path, return placeholder
        if (!$imagePath) {
            return asset('images/placeholder.jpg');
        }

        // If already a full URL, return as is
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            return $imagePath;
        }

        // Clean the path - remove leading slashes
        $cleanPath = ltrim($imagePath, '/');

        // Handle different storage scenarios
        if (str_starts_with($cleanPath, 'public/')) {
            // Path stored as 'public/folder/file.jpg' (Filament default)
            $storagePath = str_replace('public/', '', $cleanPath);
            return Storage::url($storagePath);
        }
        elseif (str_starts_with($cleanPath, 'storage/')) {
            // Path stored as 'storage/folder/file.jpg'
            $storagePath = str_replace('storage/', '', $cleanPath);
            return Storage::url($storagePath);
        }
        elseif (str_starts_with($cleanPath, 'app/public/')) {
            // Path stored as 'app/public/folder/file.jpg'
            $storagePath = str_replace('app/public/', '', $cleanPath);
            return Storage::url($storagePath);
        }
        else {
            // Assume it's already the correct storage path
            // Check if file exists in storage
            if (Storage::disk('public')->exists($cleanPath)) {
                return Storage::url($cleanPath);
            }

            // If not found, try common folders
            $commonFolders = ['products', 'images', 'uploads'];
            foreach ($commonFolders as $folder) {
                $testPath = $folder . '/' . $cleanPath;
                if (Storage::disk('public')->exists($testPath)) {
                    return Storage::url($testPath);
                }
            }

            // Last resort - return the asset URL
            return asset('storage/' . $cleanPath);
        }
    }

    /**
     * Upload image (for testing purposes)
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('products', 'public');

            return response()->json([
                'status' => 'success',
                'path' => $path,
                'url' => Storage::url($path),
                'full_url' => asset('storage/' . $path)
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'No image uploaded'
        ], 400);
    }
}
