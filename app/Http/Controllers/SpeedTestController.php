<?php
// app/Http/Controllers/SpeedTestController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class SpeedTestController extends Controller
{
    public function downloadTest()
    {
        $user = auth()->user();
        $response = Gate::inspect('speedtest', $user);
        if ($response->denied()) {
            return response()->json(['error' => $response->message()], 403);
        }

        $data = str_repeat('0', 1024 * 1024 * 5); // 5MB data
        return response($data, 200, [
            'Content-Type' => 'application/octet-stream',
            'Content-Length' => strlen($data),
        ]);
    }

    public function uploadTest(Request $request)
    {
        $user = auth()->user();
        $response = Gate::inspect('speedtest', $user);
        if ($response->denied()) {
            return response()->json(['error' => $response->message()], 403);
        }

        try {
            Log::info('Upload request received', [
                'user_id' => $user->id,
                'content_type' => $request->header('Content-Type'),
            ]);

            if (!$request->has('upload_data')) {
                Log::error('No data uploaded');
                return response()->json(['error' => 'No data uploaded'], 400);
            }

            $data = $request->input('upload_data');
            $size = strlen($data);

            Log::info('Upload size: ' . $size); // Log the upload size
            return response()->json(['size' => $size], 200);

        } catch (\Exception $e) {
            Log::error('Upload test error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function jitterTest()
    {
        $user = auth()->user();
        $response = Gate::inspect('speedtest', $user);
        if ($response->denied()) {
            return response()->json(['error' => $response->message()], 403);
        }

        // Implement the jitter test logic here
        $jitter = rand(1, 100); // Example jitter value
        return response()->json(['jitter' => $jitter], 200);
    }

    public function packetLossTest()
    {
        $user = auth()->user();
        $response = Gate::inspect('speedtest', $user);
        if ($response->denied()) {
            return response()->json(['error' => $response->message()], 403);
        }

        // Implement the packet loss test logic here
        $packetLoss = rand(0, 10); // Example packet loss percentage
        return response()->json(['packet_loss' => $packetLoss], 200);
    }

    public function pingTest()
    {
        $user = auth()->user();
        $response = Gate::inspect('speedtest', $user);
        if ($response->denied()) {
            return response()->json(['error' => $response->message()], 403);
        }

        // Implement the ping test logic here
        $ping = rand(1, 100); // Example ping value
        return response()->json(['ping' => $ping], 200);
    }

    public function latencyTest()
    {
        $user = auth()->user();
        $response = Gate::inspect('speedtest', $user);
        if ($response->denied()) {
            return response()->json(['error' => $response->message()], 403);
        }

        // Implement the latency test logic here
        $latency = rand(1, 100); // Example latency value
        return response()->json(['latency' => $latency], 200);
    }

    public function getIpInfoToken()
    {
        // Retrieve the token from a secure place, e.g., .env file or database
        $token = env('IPINFO_TOKEN', 'b3b0658e3deb21');

        return response()->json(['token' => $token], 200);
    }
}
