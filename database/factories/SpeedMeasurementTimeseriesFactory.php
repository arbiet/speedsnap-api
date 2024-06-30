<?php
// database/factories/SpeedMeasurementTimeseriesFactory.php

namespace Database\Factories;

use App\Models\SpeedMeasurementTimeseries;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpeedMeasurementTimeseriesFactory extends Factory
{
    protected $model = SpeedMeasurementTimeseries::class;

    public function definition()
    {
        return [
            // 'speed_measurement_id' => \App\Models\SpeedMeasurement::factory(),
            'timestamp' => $this->faker->dateTimeBetween('2024-01-01', '2024-05-31'),
            'download_speed' => $this->generateFluctuatingData($this->faker->numberBetween(40, 52), 0.2),
            'upload_speed' => $this->generateFluctuatingData($this->faker->numberBetween(20, 26), 0.2),
            'jitter' => $this->generateFluctuatingData($this->faker->numberBetween(19, 30), 0.2),
            'packet_loss' => $this->generateFluctuatingData($this->faker->randomFloat(2, 0.1, 0.25), 0.2),
            'ping' => $this->generateFluctuatingData($this->faker->numberBetween(20, 30), 0.2),
            'latency' => $this->generateFluctuatingData($this->faker->numberBetween(20, 26), 0.2),
        ];
    }

    private function generateFluctuatingData($baseValue, $variance)
    {
        $minValue = $baseValue * (1 - $variance);
        $maxValue = $baseValue * (1 + $variance);
        return max($minValue, min($maxValue, $baseValue * (1 + (mt_rand() / mt_getrandmax() - 0.5) * 2 * $variance)));
    }
}
