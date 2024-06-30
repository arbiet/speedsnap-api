<?php
// database/factories/SpeedMeasurementFactory.php
namespace Database\Factories;

use App\Models\SpeedMeasurement;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpeedMeasurementFactory extends Factory
{
    protected $model = SpeedMeasurement::class;

    public function definition()
    {
        return [
            // 'isp_id' => \App\Models\InternetServiceProvider::factory(),
            'user_id' => null, // or use `User::factory()` if needed
            'download_speed' => $this->faker->numberBetween(40, 52),
            'upload_speed' => $this->faker->numberBetween(20, 26),
            'jitter' => $this->faker->numberBetween(19, 30),
            'packet_loss' => $this->faker->randomFloat(2, 0.1, 0.25),
            'ping' => $this->faker->numberBetween(20, 30),
            'latency' => $this->faker->numberBetween(20, 26),
        ];
    }
}
