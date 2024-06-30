<?php

// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\InternetServiceProvider;
use App\Models\SpeedMeasurement;
use App\Models\SpeedMeasurementTimeseries;
use App\Models\DeviceLocation;
use App\Models\UserAgent;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public function run(): void
    {
        // Create 10 users if not already present
        if (User::count() === 0) {
            for ($i = 0; $i < 10; $i++) {
                User::create([
                    'name' => $this->faker->name,
                    'email' => $this->faker->unique()->safeEmail,
                    'password' => bcrypt('password'), // Default password for all users
                    'user_type' => 'user'
                ]);
            }
        }

        $users = User::all();

        $kecamatanData = [
            'Kota' => [
                ['name' => 'Biznet', 'download' => 50, 'upload' => 25, 'throughput' => 37.5, 'latency' => 20, 'packet_loss' => 0.1],
                ['name' => 'FirstMedia', 'download' => 45, 'upload' => 22, 'throughput' => 33.5, 'latency' => 25, 'packet_loss' => 0.2],
                ['name' => 'Iconnet', 'download' => 48, 'upload' => 24, 'throughput' => 36, 'latency' => 22, 'packet_loss' => 0.15],
                ['name' => 'Indihome', 'download' => 47, 'upload' => 23, 'throughput' => 35, 'latency' => 23, 'packet_loss' => 0.18],
                ['name' => 'Jujung Net', 'download' => 40, 'upload' => 20, 'throughput' => 30, 'latency' => 30, 'packet_loss' => 0.25],
                ['name' => 'MyRepublic', 'download' => 49, 'upload' => 24.5, 'throughput' => 36.75, 'latency' => 21, 'packet_loss' => 0.12],
                ['name' => 'SDI', 'download' => 46, 'upload' => 23, 'throughput' => 34.5, 'latency' => 24, 'packet_loss' => 0.2],
                ['name' => 'XL Home', 'download' => 44, 'upload' => 21, 'throughput' => 32.5, 'latency' => 26, 'packet_loss' => 0.22],
            ],
            'Mojoroto' => [
                ['name' => 'Biznet', 'download' => 52, 'upload' => 26, 'throughput' => 39, 'latency' => 19, 'packet_loss' => 0.1],
                ['name' => 'FirstMedia', 'download' => 46, 'upload' => 23, 'throughput' => 34.5, 'latency' => 24, 'packet_loss' => 0.2],
                ['name' => 'Iconnet', 'download' => 50, 'upload' => 25, 'throughput' => 37.5, 'latency' => 20, 'packet_loss' => 0.15],
                ['name' => 'Indihome', 'download' => 49, 'upload' => 24, 'throughput' => 36.5, 'latency' => 21, 'packet_loss' => 0.18],
                ['name' => 'Jujung Net', 'download' => 42, 'upload' => 21, 'throughput' => 31.5, 'latency' => 28, 'packet_loss' => 0.25],
                ['name' => 'MyRepublic', 'download' => 51, 'upload' => 25.5, 'throughput' => 38.25, 'latency' => 20, 'packet_loss' => 0.12],
                ['name' => 'SDI', 'download' => 48, 'upload' => 24, 'throughput' => 36, 'latency' => 22, 'packet_loss' => 0.2],
                ['name' => 'XL Home', 'download' => 45, 'upload' => 22, 'throughput' => 33.5, 'latency' => 25, 'packet_loss' => 0.22],
            ],
            'Pesantren' => [
                ['name' => 'Biznet', 'download' => 51, 'upload' => 25.5, 'throughput' => 38.25, 'latency' => 19, 'packet_loss' => 0.1],
                ['name' => 'FirstMedia', 'download' => 47, 'upload' => 23.5, 'throughput' => 35.25, 'latency' => 23, 'packet_loss' => 0.2],
                ['name' => 'Iconnet', 'download' => 49, 'upload' => 24.5, 'throughput' => 36.75, 'latency' => 21, 'packet_loss' => 0.15],
                ['name' => 'Indihome', 'download' => 48, 'upload' => 24, 'throughput' => 36, 'latency' => 22, 'packet_loss' => 0.18],
                ['name' => 'Jujung Net', 'download' => 41, 'upload' => 20.5, 'throughput' => 30.75, 'latency' => 29, 'packet_loss' => 0.25],
                ['name' => 'MyRepublic', 'download' => 50, 'upload' => 25, 'throughput' => 37.5, 'latency' => 20, 'packet_loss' => 0.12],
                ['name' => 'SDI', 'download' => 47, 'upload' => 23.5, 'throughput' => 35.25, 'latency' => 23, 'packet_loss' => 0.2],
                ['name' => 'XL Home', 'download' => 46, 'upload' => 22.5, 'throughput' => 34.25, 'latency' => 24, 'packet_loss' => 0.22],
            ]
        ];

        foreach ($kecamatanData as $kecamatan => $isps) {
            foreach ($isps as $ispData) {
                $centralPoint = $this->getKecamatanCoordinates($kecamatan);

                for ($month = 1; $month <= 5; $month++) {
                    $entriesThisMonth = rand(5, 15);

                    for ($i = 0; $i < $entriesThisMonth; $i++) {
                        $userId = rand(0, 1) ? $users->random()->id : null;

                        $isp = new InternetServiceProvider();
                        $isp->name = $ispData['name'];
                        $isp->service_type = 'fiber'; // Default value, you can adjust as needed
                        $isp->ip = $this->faker->ipv4;
                        $isp->city = 'Kediri City'; // Adjust this value as needed
                        $isp->region = 'East Java'; // Adjust this value as needed
                        $isp->country = 'Indonesia'; // Adjust this value as needed
                        $isp->loc = $centralPoint;
                        $isp->org = $ispData['name'];
                        $isp->timezone = $this->faker->timezone;
                        $isp->district = $kecamatan; // Adjust this value as needed
                        $isp->user_id = $userId;
                        $isp->save();

                        // Generate a timestamp within the current month and year
                        $measurementTimestamp = $this->faker->dateTimeBetween("2024-$month-01", "2024-$month-" . date('t', strtotime("2024-$month-01")));

                        $measurement = new SpeedMeasurement();
                        $measurement->isp_id = $isp->id;
                        $measurement->user_id = $userId;
                        $measurement->download_speed = $this->generateFluctuatingData($ispData['download'], 0.2);
                        $measurement->upload_speed = $this->generateFluctuatingData($ispData['upload'], 0.2);
                        $measurement->jitter = $this->generateFluctuatingData(rand(19, 30), 0.2);
                        $measurement->packet_loss = $this->generateFluctuatingData($ispData['packet_loss'], 0.2);
                        $measurement->ping = $this->generateFluctuatingData(rand(20, 30), 0.2);
                        $measurement->latency = $this->generateFluctuatingData($ispData['latency'], 0.2);
                        $measurement->created_at = $measurementTimestamp;
                        $measurement->updated_at = $measurementTimestamp;
                        $measurement->save();

                        $this->createTimeseriesData($measurement->id, $userId, $measurementTimestamp);

                        $deviceLocation = $this->generateRandomLocationNear($centralPoint);
                        $deviceLocationModel = new DeviceLocation();
                        $deviceLocationModel->latitude = $deviceLocation['latitude'];
                        $deviceLocationModel->longitude = $deviceLocation['longitude'];
                        $deviceLocationModel->speed_measurement_id = $measurement->id;
                        $deviceLocationModel->user_id = $userId;
                        $deviceLocationModel->district = $kecamatan;
                        $deviceLocationModel->city = 'Kediri City'; // Adjust this value as needed
                        $deviceLocationModel->state = 'East Java'; // Adjust this value as needed
                        $deviceLocationModel->country = 'Indonesia'; // Adjust this value as needed
                        $deviceLocationModel->save();

                        $userAgent = new UserAgent();
                        $userAgent->speed_measurement_id = $measurement->id;
                        $userAgent->user_id = $userId;
                        $userAgent->user_agent = $this->faker->userAgent;
                        $userAgent->save();
                    }
                }
            }
        }
    }

    private function getKecamatanCoordinates($kecamatan)
    {
        $coordinates = [
            'Kota' => '-7.8290715,112.018747',
            'Mojoroto' => '-7.8067467,111.9432509',
            'Pesantren' => '-7.8468415,112.0284304',
        ];

        return $coordinates[$kecamatan];
    }

    private function generateRandomLocationNear($centralPoint)
    {
        list($centralLat, $centralLng) = explode(',', $centralPoint);

        // Generate a small random offset within ±0.001 degrees (approx. 100 meters)
        $latitude = $centralLat + $this->faker->randomFloat(6, -0.001, 0.001);
        $longitude = $centralLng + $this->faker->randomFloat(6, -0.001, 0.001);

        return [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
    }

    private function generateFluctuatingData($baseValue, $variance)
    {
        $minValue = $baseValue * (1 - $variance);
        $maxValue = $baseValue * (1 + $variance);
        return max($minValue, min($maxValue, $baseValue * (1 + (mt_rand() / mt_getrandmax() - 0.5) * 2 * $variance)));
    }

    private function createTimeseriesData($speedMeasurementId, $userId, $measurementTimestamp)
    {
        for ($j = 0; $j < 10; $j++) {
            $startDate = $measurementTimestamp->format('Y-m-01');
            $endDate = $measurementTimestamp->format('Y-m-t');
            $timeseries = new SpeedMeasurementTimeseries();
            $timeseries->speed_measurement_id = $speedMeasurementId;
            $timeseries->timestamp = $this->faker->dateTimeBetween($startDate, $endDate);
            $timeseries->download_speed = $this->generateFluctuatingData(rand(30, 60), 0.2);
            $timeseries->upload_speed = $this->generateFluctuatingData(rand(10, 30), 0.2);
            $timeseries->jitter = $this->generateFluctuatingData(rand(10, 20), 0.2);
            $timeseries->packet_loss = $this->generateFluctuatingData(rand(0, 0.5), 0.2);
            $timeseries->ping = $this->generateFluctuatingData(rand(20, 50), 0.2);
            $timeseries->latency = $this->generateFluctuatingData(rand(10, 30), 0.2);
            $timeseries->save();
        }
    }
}
