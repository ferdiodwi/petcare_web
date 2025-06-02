<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\GroomingController;
use App\Http\Controllers\Api\CustomerProfileController;
use App\Http\Controllers\Api\BoardingController;


Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products/upload-image', [ProductController::class, 'uploadImage']);


// PERBAIKAN: Routes untuk debugging dan testing
Route::get('/products/debug-images', [ProductController::class, 'debugImages']);
Route::get('/products/test-image/{filename}', [ProductController::class, 'testImage']);
Route::post('/products/repair-storage', [ProductController::class, 'repairStorage']);


Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Api is working',
        'timestamp' => now(),
        'app_url' => config('app.url'),
        'storage_path' => storage_path('app/public'),
        'public_storage_exists' => is_link(public_path('storage')),
    ]);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Auth routes
Route::post('/register', [AuthController::class, 'register']);

// Tambahkan di routes/api.php sebelum Route::post('/login'...)
Route::post('/debug-hash', function(Request $request) {
    $customer = Customer::where('email', $request->email)->first();

    if (!$customer) {
        return response()->json(['error' => 'Customer not found']);
    }

    $inputPassword = $request->password;
    $storedPassword = $customer->password;

    return response()->json([
        'email' => $request->email,
        'input_password' => $inputPassword,
        'stored_password' => $storedPassword,
        'stored_password_length' => strlen($storedPassword),
        'starts_with' => substr($storedPassword, 0, 4),
        'is_bcrypt_format' => preg_match('/^\$2[aby]\$\d{2}\$.{53}$/', $storedPassword),
        'hash_check_result' => Hash::check($inputPassword, $storedPassword),
        'new_hash_sample' => Hash::make($inputPassword)
    ]);
});

// Tambahkan setelah route debug-hash
Route::post('/fix-password', function(Request $request) {
    $customer = Customer::where('email', $request->email)->first();

    if (!$customer) {
        return response()->json(['error' => 'Customer not found']);
    }

    // Force bcrypt hash
    $newHash = bcrypt($request->new_password);

    // Update password
    $customer->password = $newHash;
    $customer->save();

    return response()->json([
        'message' => 'Password updated successfully',
        'old_hash_starts_with' => substr($customer->getOriginal('password'), 0, 4),
        'new_hash_starts_with' => substr($newHash, 0, 4),
        'new_hash_length' => strlen($newHash),
        'is_bcrypt_format' => preg_match('/^\$2[aby]\$\d{2}\$.{53}$/', $newHash)
    ]);
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/test-config', function () {
    return response()->json([
        'app_url' => config('app.url'),
        'storage_path' => storage_path('app/public'),
        'public_storage_exists' => is_link(public_path('storage')),
        'public_storage_path' => public_path('storage'),
        'storage_link_target' => is_link(public_path('storage')) ? readlink(public_path('storage')) : null,
        'sample_files' => array_slice(glob(storage_path('app/public/*')), 0, 5),
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    // Get customer profile data
    Route::get('/customer/profile', [CustomerProfileController::class, 'getProfile']);

    // Upload customer profile image
    Route::post('/customer/upload-profile-image', [CustomerProfileController::class, 'uploadProfileImage']);
});


// Boarding routes
Route::prefix('boardings')->group(function () {
    Route::get('/', [BoardingController::class, 'index']);
    Route::post('/', [BoardingController::class, 'store']);
    Route::get('/statistics', [BoardingController::class, 'statistics']);
    Route::get('/{boarding}', [BoardingController::class, 'show']);
    Route::put('/{boarding}', [BoardingController::class, 'update']);
    Route::delete('/{boarding}', [BoardingController::class, 'destroy']);
    Route::patch('/{boarding}/status', [BoardingController::class, 'updateStatus']);
});


Route::apiResource('groomings', GroomingController::class);
Route::get('/images/{filename}', [ProductController::class, 'serveImage']);
Route::get('/debug/images', [ProductController::class, 'debugImages']);
Route::get('/products', [ProductController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/customer/{id}', [OrderController::class, 'getCustomerOrders']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:api'])->group(function () {
    // Order routes
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'getCustomerOrders']);
        Route::get('/{orderId}', [OrderController::class, 'getOrderDetails']);
        Route::put('/{orderId}/status', [OrderController::class, 'updateStatus']); // Admin only
    });
});


Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']); // GET /api/orders - Ambil semua pesanan
    Route::get('/{id}', [OrderController::class, 'show']); // GET /api/orders/{id} - Ambil satu pesanan
    Route::post('/', [OrderController::class, 'store']); // POST /api/orders - Buat pesanan baru
    Route::patch('/{id}/status', [OrderController::class, 'updateStatus']); // PATCH /api/orders/{id}/status - Update status pesanan
});
