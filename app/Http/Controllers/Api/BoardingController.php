<?php

namespace App\Http\Controllers\Api;

use App\Models\Boarding;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Controller;

class BoardingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Boarding::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        // Search by pet name or owner name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('pet_name', 'like', "%{$search}%")
                  ->orWhere('owner_name', 'like', "%{$search}%");
            });
        }

        $boardings = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($boardings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'pet_name' => 'required|string|max:255',
                'species' => 'required|in:Anjing,Kucing,Kelinci,Burung',
                'owner_name' => 'required|string|max:255',
                'owner_phone' => 'required|string|max:20',
                'owner_email' => 'nullable|email|max:255',
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
                'special_instructions' => 'nullable|string|max:1000',
                'daily_rate' => 'required|numeric|min:0',
                'services' => 'nullable|array',
                'services.*' => 'string|max:255'
            ]);

            $boarding = Boarding::create($validated);
            $boarding->total_cost = $boarding->calculateTotalCost();
            $boarding->save();

            return response()->json([
                'message' => 'Data penitipan berhasil disimpan',
                'data' => $boarding
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Boarding $boarding): JsonResponse
    {
        return response()->json($boarding);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Boarding $boarding): JsonResponse
    {
        try {
            $validated = $request->validate([
                'pet_name' => 'sometimes|string|max:255',
                'species' => 'sometimes|in:Anjing,Kucing,Kelinci,Burung',
                'owner_name' => 'sometimes|string|max:255',
                'owner_phone' => 'sometimes|string|max:20',
                'owner_email' => 'nullable|email|max:255',
                'start_date' => 'sometimes|date',
                'end_date' => 'sometimes|date|after:start_date',
                'special_instructions' => 'nullable|string|max:1000',
                'status' => 'sometimes|in:pending,active,completed,cancelled',
                'daily_rate' => 'sometimes|numeric|min:0',
                'services' => 'nullable|array',
                'services.*' => 'string|max:255',
                'notes' => 'nullable|string|max:1000'
            ]);

            $boarding->update($validated);

            // Recalculate total cost if dates or rate changed
            if (isset($validated['start_date']) || isset($validated['end_date']) || isset($validated['daily_rate'])) {
                $boarding->total_cost = $boarding->calculateTotalCost();
                $boarding->save();
            }

            return response()->json([
                'message' => 'Data penitipan berhasil diupdate',
                'data' => $boarding
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Boarding $boarding): JsonResponse
    {
        $boarding->delete();

        return response()->json([
            'message' => 'Data penitipan berhasil dihapus'
        ]);
    }

    /**
     * Get boarding statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_boardings' => Boarding::count(),
            'active_boardings' => Boarding::where('status', 'active')->count(),
            'pending_boardings' => Boarding::where('status', 'pending')->count(),
            'completed_boardings' => Boarding::where('status', 'completed')->count(),
            'monthly_revenue' => Boarding::whereMonth('created_at', now()->month)
                                      ->whereYear('created_at', now()->year)
                                      ->sum('total_cost'),
            'species_breakdown' => Boarding::selectRaw('species, COUNT(*) as count')
                                         ->groupBy('species')
                                         ->get()
        ];

        return response()->json($stats);
    }

    /**
     * Update boarding status
     */
    public function updateStatus(Request $request, Boarding $boarding): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,active,completed,cancelled',
            'notes' => 'nullable|string|max:1000'
        ]);

        $boarding->update($validated);

        return response()->json([
            'message' => 'Status berhasil diupdate',
            'data' => $boarding
        ]);
    }
}
