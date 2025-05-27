<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

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
