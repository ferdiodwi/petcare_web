<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Grooming;
use Illuminate\Http\Request;

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
        $request->validate([
            'kategori' => 'required|in:basic,premium,full_treatment',
            'tanggal' => 'required|date',
            'jam' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $data = $request->all();
        $data['harga'] = $this->getHargaByKategori($data['kategori']);

        $grooming = Grooming::create($data);

        return response()->json($grooming, 201);
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
