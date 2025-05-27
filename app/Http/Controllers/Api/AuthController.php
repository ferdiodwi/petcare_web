<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255', // username opsional
            'email' => 'required|string|email|max:255|unique:customers',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Buat customer baru
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'data' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $customer->address,
                // JANGAN kirim password dalam response!
            ],
        ], 201);
    }

    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email dan password wajib diisi',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Cari customer berdasarkan email
        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak ditemukan',
            ], 401);
        }

        // DEBUG: Log password info
        \Log::info('Login attempt:', [
            'email' => $request->email,
            'input_password' => $request->password,
            'stored_password' => $customer->password,
            'password_starts_with' => substr($customer->password, 0, 4),
            'hash_check_result' => Hash::check($request->password, $customer->password)
        ]);

        // Cek password
        if (!Hash::check($request->password, $customer->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password salah',
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'data' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'address' => $customer->address,
            ],
        ], 200);
    }
}
