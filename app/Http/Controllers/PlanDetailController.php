<?php

namespace App\Http\Controllers;

use App\Models\PlanDetail;
use Illuminate\Http\Request;

class PlanDetailController extends Controller
{
    public function index()
    {
        $planDetails = PlanDetail::with('serviceProvider')->get();
        return response()->json($planDetails);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'download_speed' => 'required|integer',
            'upload_speed' => 'required|integer',
            'FUP' => 'nullable|integer',
            'free_extra_quota' => 'nullable|integer',
            'downgrade_speed' => 'nullable|integer',
            'devices' => 'nullable|integer',
            'IP_dynamic' => 'nullable|boolean',
            'IP_public' => 'nullable|boolean',
            'modem' => 'nullable|boolean',
            'service_provider_id' => 'required|exists:service_providers,id',
        ]);

        $planDetail = PlanDetail::create($validated);

        return response()->json($planDetail, 201);
    }

    public function show($id)
    {
        $planDetail = PlanDetail::with('serviceProvider')->findOrFail($id);
        return response()->json($planDetail);
    }

    public function update(Request $request, $id)
    {
        $planDetail = PlanDetail::findOrFail($id);

        $validated = $request->validate([
            'plan_name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
            'download_speed' => 'sometimes|required|integer',
            'upload_speed' => 'sometimes|required|integer',
            'FUP' => 'nullable|integer',
            'free_extra_quota' => 'nullable|integer',
            'downgrade_speed' => 'nullable|integer',
            'devices' => 'nullable|integer',
            'IP_dynamic' => 'nullable|boolean',
            'IP_public' => 'nullable|boolean',
            'modem' => 'nullable|boolean',
            'service_provider_id' => 'sometimes|required|exists:service_providers,id',
        ]);

        $planDetail->update($validated);

        return response()->json($planDetail);
    }

    public function destroy($id)
    {
        $planDetail = PlanDetail::findOrFail($id);
        $planDetail->delete();

        return response()->json(['message' => 'Plan Detail deleted successfully']);
    }
}
