<?php

namespace App\Http\Controllers;

use App\Models\InternetServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class InternetServiceProviderController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except:['index', 'show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $providers = InternetServiceProvider::all();
            return response()->json([
                'message' => 'Data retrieved successfully',
                'data' => $providers
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'service_type' => 'required|in:fiber,dsl,cable,wireless,satellite',
                'ip' => 'required|ip',
                'city' => 'required|string|max:255',
                'region' => 'required|string|max:255',
                'country' => 'required|string|max:2',
                'loc' => 'required|string',
                'org' => 'required|string|max:255',
                'timezone' => 'required|string|max:255',
            ]);

            $validatedData['user_id'] = Auth::id(); // Set user_id to current logged in user

            $provider = InternetServiceProvider::create($validatedData);

            return response()->json([
                'message' => 'Internet Service Provider created successfully',
                'data' => $provider
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create Internet Service Provider',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $provider = InternetServiceProvider::findOrFail($id);
            return response()->json([
                'message' => 'Data retrieved successfully',
                'data' => $provider
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Internet Service Provider not found',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to retrieve data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'service_type' => 'sometimes|required|in:fiber,dsl,cable,wireless,satellite',
                'ip' => 'sometimes|required|ip',
                'city' => 'sometimes|required|string|max:255',
                'region' => 'sometimes|required|string|max:255',
                'country' => 'sometimes|required|string|max:2',
                'loc' => 'sometimes|required|string',
                'org' => 'sometimes|required|string|max:255',
                'timezone' => 'sometimes|required|string|max:255',
            ]);

            $provider = InternetServiceProvider::findOrFail($id);

            // Authorize the user
            Gate::authorize('update', $provider);

            $provider->update($validatedData);

            return response()->json([
                'message' => 'Internet Service Provider updated successfully',
                'data' => $provider
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Internet Service Provider not found',
                'error' => $e->getMessage()
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update Internet Service Provider',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $provider = InternetServiceProvider::findOrFail($id);

            // Authorize the user
            Gate::authorize('delete', $provider);

            $provider->delete();

            return response()->json([
                'message' => 'Internet Service Provider deleted successfully'
            ], 204);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Internet Service Provider not found',
                'error' => $e->getMessage()
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete Internet Service Provider',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
