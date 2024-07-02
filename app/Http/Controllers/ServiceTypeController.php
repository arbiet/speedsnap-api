<?php

namespace App\Http\Controllers;

use App\Models\ServiceType;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    public function index()
    {
        $serviceTypes = ServiceType::with('serviceProvider')->get();
        return response()->json($serviceTypes);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_types_name' => 'required|string|max:255',
            'service_provider_id' => 'required|exists:service_providers,id',
        ]);

        $serviceType = ServiceType::create($validated);

        return response()->json($serviceType, 201);
    }

    public function show($id)
    {
        $serviceType = ServiceType::with('serviceProvider')->findOrFail($id);
        return response()->json($serviceType);
    }

    public function update(Request $request, $id)
    {
        $serviceType = ServiceType::findOrFail($id);

        $validated = $request->validate([
            'service_types_name' => 'sometimes|required|string|max:255',
            'service_provider_id' => 'sometimes|required|exists:service_providers,id',
        ]);

        $serviceType->update($validated);

        return response()->json($serviceType);
    }

    public function destroy($id)
    {
        $serviceType = ServiceType::findOrFail($id);
        $serviceType->delete();

        return response()->json(['message' => 'Service Type deleted successfully']);
    }
}
