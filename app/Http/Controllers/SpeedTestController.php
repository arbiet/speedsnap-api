<?php
// app/Http/Controllers/SpeedTestController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InternetServiceProvider;
use App\Models\SpeedMeasurement;
use App\Models\SpeedMeasurementTimeseries;
use App\Models\DeviceLocation;
use App\Models\UserAgent;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

        $jitter = rand(0.1, 25); // Example jitter value
        return response()->json(['jitter' => $jitter], 200);
    }

    public function packetLossTest()
    {
        $user = auth()->user();
        $response = Gate::inspect('speedtest', $user);
        if ($response->denied()) {
            return response()->json(['error' => $response->message()], 403);
        }

        $packetLoss = rand(0, 1.7); // Example packet loss percentage
        return response()->json(['packet_loss' => $packetLoss], 200);
    }

    public function pingTest()
    {
        $user = auth()->user();
        $response = Gate::inspect('speedtest', $user);
        if ($response->denied()) {
            return response()->json(['error' => $response->message()], 403);
        }

        $ping = rand(1, 25); // Example ping value
        return response()->json(['ping' => $ping], 200);
    }

    public function latencyTest()
    {
        $user = auth()->user();
        $response = Gate::inspect('speedtest', $user);
        if ($response->denied()) {
            return response()->json(['error' => $response->message()], 403);
        }

        $latency = rand(1, 25);
        return response()->json(['latency' => $latency], 200);
    }

    public function getIpInfoToken()
    {
        // Retrieve the token from a secure place, e.g., .env file or database
        $token = env('IPINFO_TOKEN', 'b3b0658e3deb21');

        return response()->json(['token' => $token], 200);
    }

    public function storeResults(Request $request)
    {
        $data = $request->all();
        $validationErrors = $this->validateData($data);
    
        if (!empty($validationErrors)) {
            Log::error('Validation failed for speed test results', ['errors' => $validationErrors]);
            return response()->json(['error' => $validationErrors], 422);
        }
    
        try {
            // Determine user ID
            $userId = auth()->check() ? auth()->id() : null;
    
            // Save ISP info
            $ispData = $data['isp'];
            $ispData['user_id'] = $userId;
            $isp = InternetServiceProvider::create($ispData);
    
            // Save speed measurement
            $speedMeasurementData = $data['speed_measurement'];
            $speedMeasurementData['isp_id'] = $isp->id;
            $speedMeasurementData['user_id'] = $userId;
            $speedMeasurement = SpeedMeasurement::create($speedMeasurementData);
    
            // Save timeseries data
            foreach ($data['timeseries'] as $timeseriesData) {
                $timeseriesData['speed_measurement_id'] = $speedMeasurement->id;
                $timeseriesData['user_id'] = $userId;
                SpeedMeasurementTimeseries::create($timeseriesData);
            }
    
            // Save device location
            $deviceLocationData = $data['device_location'];
            $deviceLocationData['user_id'] = $userId;
            DeviceLocation::create($deviceLocationData);
    
            // Save user agent
            UserAgent::create([
                'user_id' => $userId,
                'user_agent' => $data['user_agent'],
            ]);
    
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            Log::error('Failed to save speed test results', ['exception' => $e]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    

    private function validateData($data)
    {
        $errors = [];

        if (!is_array($data['isp'])) {
            $errors['isp'] = 'ISP data must be an array.';
        } else {
            $this->validateIsp($data['isp'], $errors);
        }

        if (!is_array($data['speed_measurement'])) {
            $errors['speed_measurement'] = 'Speed measurement data must be an array.';
        } else {
            $this->validateSpeedMeasurement($data['speed_measurement'], $errors);
        }

        if (!is_array($data['timeseries'])) {
            $errors['timeseries'] = 'Timeseries data must be an array.';
        } else {
            $this->validateTimeseries($data['timeseries'], $errors);
        }

        if (!is_array($data['device_location'])) {
            $errors['device_location'] = 'Device location data must be an array.';
        } else {
            $this->validateDeviceLocation($data['device_location'], $errors);
        }

        if (!is_string($data['user_agent'])) {
            $errors['user_agent'] = 'User agent must be a string.';
        }

        return $errors;
    }

    private function validateIsp($isp, &$errors)
    {
        $requiredFields = ['name', 'service_type', 'ip', 'city', 'region', 'country', 'loc', 'org', 'timezone'];

        foreach ($requiredFields as $field) {
            if (!isset($isp[$field]) || !is_string($isp[$field])) {
                $errors["isp.$field"] = "The $field field is required and must be a string.";
            }
        }

        if (isset($isp['service_type']) && !in_array($isp['service_type'], ['fiber', 'dsl', 'cable', 'wireless', 'satellite'])) {
            $errors["isp.service_type"] = "The service_type field must be one of: fiber, dsl, cable, wireless, satellite.";
        }
    }

    private function validateSpeedMeasurement($speedMeasurement, &$errors)
    {
        $numericFields = ['download_speed', 'upload_speed'];
        $integerFields = ['jitter', 'packet_loss', 'ping', 'latency'];
    
        foreach ($numericFields as $field) {
            if (!isset($speedMeasurement[$field])) {
                $errors["speed_measurement.$field"] = "The $field field is required.";
            } elseif (!is_null($speedMeasurement[$field]) && !is_numeric($speedMeasurement[$field])) {
                $errors["speed_measurement.$field"] = "The $field field must be numeric.";
            }
        }
    
        foreach ($integerFields as $field) {
            if (!isset($speedMeasurement[$field])) {
                $errors["speed_measurement.$field"] = "The $field field is required.";
            } elseif (!is_null($speedMeasurement[$field]) && !is_numeric($speedMeasurement[$field])) {
                $errors["speed_measurement.$field"] = "The $field field must be numeric.";
            }
        }
    }
    

    private function validateTimeseries($timeseries, &$errors)
    {
        foreach ($timeseries as $index => $data) {
            if (!is_array($data)) {
                $errors["timeseries.$index"] = "Each timeseries entry must be an array.";
                continue;
            }

            $this->validateTimeseriesEntry($data, $index, $errors);
        }
    }

    private function validateTimeseriesEntry($data, $index, &$errors)
    {
        $numericFields = ['download_speed', 'upload_speed', 'jitter', 'packet_loss', 'ping', 'latency'];
    
        if (!isset($data['timestamp']) || !strtotime($data['timestamp'])) {
            $errors["timeseries.$index.timestamp"] = "The timestamp field is required and must be a valid date.";
        }
    
        foreach ($numericFields as $field) {
            if (!isset($data[$field]) || !is_numeric($data[$field])) {
                $errors["timeseries.$index.$field"] = "The $field field is required and must be numeric.";
            }
        }
    }
    

    private function validateDeviceLocation($deviceLocation, &$errors)
    {
        $numericFields = ['latitude', 'longitude'];

        foreach ($numericFields as $field) {
            if (!isset($deviceLocation[$field]) || !is_numeric($deviceLocation[$field])) {
                $errors["device_location.$field"] = "The $field field is required and must be numeric.";
            }
        }

        $stringFields = ['road', 'city', 'state', 'country'];

        foreach ($stringFields as $field) {
            if (isset($deviceLocation[$field]) && !is_string($deviceLocation[$field])) {
                $errors["device_location.$field"] = "The $field field must be a string.";
            }
        }
    }

    public function recommendIsp(Request $request)
    {
        // Fetch average speed data per ISP per district and city
        $results = DB::table('speed_measurements')
            ->join('internet_service_providers', 'speed_measurements.isp_id', '=', 'internet_service_providers.id')
            ->join('device_locations', 'speed_measurements.id', '=', 'device_locations.speed_measurement_id')
            ->select(
                'internet_service_providers.name as isp_name',
                'device_locations.city',
                'device_locations.district',
                DB::raw('AVG(speed_measurements.download_speed) as avg_download_speed'),
                DB::raw('AVG(speed_measurements.upload_speed) as avg_upload_speed'),
                DB::raw('AVG(speed_measurements.jitter) as avg_jitter'),
                DB::raw('AVG(speed_measurements.packet_loss) as avg_packet_loss'),
                DB::raw('AVG(speed_measurements.ping) as avg_ping'),
                DB::raw('AVG(speed_measurements.latency) as avg_latency')
            )
            ->groupBy('device_locations.city', 'device_locations.district', 'internet_service_providers.name')
            ->get();

        // Calculate ranking for each district
        $rankedResults = $results->groupBy('district')->map(function ($districtResults) {
            return $districtResults->sortByDesc('avg_download_speed')->values()->map(function ($result, $index) {
                $result->ranking = $index + 1;
                return $result;
            });
        })->flatten(1);

        return response()->json($rankedResults);
    }
}
