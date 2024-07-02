<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    public function index()
    {
        $providers = ServiceProvider::all();
        return response()->json($providers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provider_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|string|email|max:255',
            'website' => 'required|string|max:255',
            'customer_support_hours' => 'required|string|max:255',
            'installation_fee' => 'required|numeric',
        ]);

        $provider = ServiceProvider::create($validated);

        return response()->json($provider, 201);
    }

    public function show($id)
    {
        $provider = ServiceProvider::findOrFail($id);
        return response()->json($provider);
    }

    public function update(Request $request, $id)
    {
        $provider = ServiceProvider::findOrFail($id);

        $validated = $request->validate([
            'provider_name' => 'sometimes|required|string|max:255',
            'address' => 'sometimes|required|string|max:255',
            'contact_number' => 'sometimes|required|string|max:20',
            'email' => 'sometimes|required|string|email|max:255',
            'website' => 'sometimes|required|string|max:255',
            'customer_support_hours' => 'sometimes|required|string|max:255',
            'installation_fee' => 'sometimes|required|numeric',
        ]);

        $provider->update($validated);

        return response()->json($provider);
    }

    public function destroy($id)
    {
        $provider = ServiceProvider::findOrFail($id);
        $provider->delete();

        return response()->json(['message' => 'Service Provider deleted successfully']);
    }
}
