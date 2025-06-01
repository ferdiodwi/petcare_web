<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grooming;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GroomingController extends Controller
{
    public function index()
    {
        return response()->json(Grooming::all());
    }

    private function getHargaByKategori($kategori)
    {
        return match ($kategori) {
            'basic' => 50000,
            'premium' => 85000,
            'full_treatment' => 120000,
            default => 0,
        };
    }

    public function store(Request $request)
    {
        try {
            // Log data yang diterima untuk debugging
            Log::info('Grooming booking data received:', $request->all());

            $request->validate([
                'name' => 'required|string|max:255',
                'kategori' => 'required|in:basic,premium,full_treatment',
                'tanggal' => 'required|date',
                'jam' => 'required',
                'email' => 'required|email',
                'phone' => 'required',
                'catatan' => 'nullable|string',
            ]);

            $data = $request->all();
            $data['harga'] = $this->getHargaByKategori($data['kategori']);

            $grooming = Grooming::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Booking berhasil dibuat',
                'data' => $grooming
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating grooming booking:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function show($id)
    {
        $grooming = Grooming::findOrFail($id);
        return response()->json($grooming);
    }

    public function update(Request $request, $id)
    {
        $grooming = Grooming::findOrFail($id);
        $data = $request->all();
        if (isset($data['kategori'])) {
            $data['harga'] = $this->getHargaByKategori($data['kategori']);
        }
        $grooming->update($data);

        return response()->json($grooming);
    }

    public function destroy($id)
    {
        $grooming = Grooming::findOrFail($id);
        $grooming->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
