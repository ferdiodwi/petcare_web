<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class CustomerProfileController extends Controller
{
    // Method untuk mendapatkan profile customer
    public function getProfile(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated - Token tidak valid'
                ], 401);
            }

            $customer = $user->customer;

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer data not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'address' => $customer->address,
                    'profileImageUrl' => $customer->profile_image_url,
                ],
                'message' => 'Profile data retrieved successfully'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk upload profile image
    public function uploadProfileImage(Request $request, ImageManager $imageManager)
    {
        try {
            $request->validate([
                'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated - Token tidak valid'
                ], 401);
            }

            $customer = $user->customer;

            if (!$customer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Customer data not found'
                ], 404);
            }

            // Hapus gambar lama jika ada
            if ($customer->profile_image) {
                Storage::delete($customer->profile_image);
            }

            $image = $request->file('profile_image');
            $filename = 'customer_profile_images/' . Str::uuid() . '.' . $image->getClientOriginalExtension();

            // Gunakan ImageManager versi 3
            $resizedImage = $imageManager
                ->read($image->getPathname())
                ->resize(800, 800)
                ->toJpeg(85);

            // Simpan ke Storage
            Storage::put($filename, (string) $resizedImage);

            // Simpan path di database
            $customer->profile_image = $filename;
            $customer->save();

            return response()->json([
                'success' => true,
                'data' => [
                    'image_url' => Storage::url($filename)
                ],
                'message' => 'Customer profile image uploaded successfully'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
