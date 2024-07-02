<?php

namespace App\Http\Controllers;

use App\Models\ServiceProviderAlias;
use App\Models\InternetServiceProvider;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ServiceProviderAliasController extends Controller
{
    public function index()
    {
        $aliases = ServiceProviderAlias::with('serviceProvider')->get();
        return response()->json($aliases);
    }

    public function availableProviders()
    {
        $usedNames = ServiceProviderAlias::pluck('alias_name')->toArray();
        $usedOrgs = ServiceProviderAlias::pluck('alias_org')->toArray();
    
        $availableAliases = InternetServiceProvider::whereNotIn('name', $usedNames)
            ->whereNotIn('org', $usedOrgs)
            ->select('name', 'org')
            ->distinct()
            ->get();
    
        $serviceProviders = ServiceProvider::all(['id', 'provider_name']);
        return response()->json([
            'available_aliases' => $availableAliases,
            'service_providers' => $serviceProviders
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_provider_id' => 'required|exists:service_providers,id',
            'alias_name' => 'required|string|max:255',
            'alias_org' => 'nullable|string|max:255',
        ]);

        $validated['alias_org'] = $validated['alias_org'] ?? $validated['alias_name'];

        $alias = ServiceProviderAlias::create($validated);

        return response()->json($alias, 201);
    }

    public function show($id)
    {
        try {
            $alias = ServiceProviderAlias::with('serviceProvider')->findOrFail($id);
            return response()->json($alias);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Alias not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $alias = ServiceProviderAlias::findOrFail($id);

            $validated = $request->validate([
                'service_provider_id' => 'sometimes|required|exists:service_providers,id',
                'alias_name' => 'sometimes|required|string|max:255',
                'alias_org' => 'nullable|string|max:255',
            ]);

            if (isset($validated['alias_name']) && !isset($validated['alias_org'])) {
                $validated['alias_org'] = $validated['alias_name'];
            }

            $alias->update($validated);

            return response()->json($alias);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Alias not found'], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $alias = ServiceProviderAlias::findOrFail($id);
            $alias->delete();
            return response()->json(['message' => 'Alias deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Alias not found'], 404);
        }
    }
}
