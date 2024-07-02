<?php

namespace App\Http\Controllers;

use App\Models\CoverageArea;
use Illuminate\Http\Request;

class CoverageAreaController extends Controller
{
    public function index()
    {
        $coverageAreas = CoverageArea::with('serviceProvider')->get();
        return response()->json($coverageAreas);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'service_provider_id' => 'required|exists:service_providers,id',
        ]);

        $coverageArea = CoverageArea::create($validated);

        return response()->json($coverageArea, 201);
    }

    public function show($id)
    {
        $coverageArea = CoverageArea::with('serviceProvider')->findOrFail($id);
        return response()->json($coverageArea);
    }

    public function update(Request $request, $id)
    {
        $coverageArea = CoverageArea::findOrFail($id);

        $validated = $request->validate([
            'city' => 'sometimes|required|string|max:255',
            'state' => 'sometimes|required|string|max:255',
            'service_provider_id' => 'sometimes|required|exists:service_providers,id',
        ]);

        $coverageArea->update($validated);

        return response()->json($coverageArea);
    }

    public function destroy($id)
    {
        $coverageArea = CoverageArea::findOrFail($id);
        $coverageArea->delete();

        return response()->json(['message' => 'Coverage Area deleted successfully']);
    }
}
