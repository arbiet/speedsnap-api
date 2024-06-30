<?php
// database/factories/DeviceLocationFactory.php

namespace Database\Factories;

use App\Models\DeviceLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceLocationFactory extends Factory
{
    protected $model = DeviceLocation::class;

    public function definition()
    {
        return [
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'road' => $this->faker->streetName,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'user_id' => null, // Allow null user
            // 'speed_measurement_id' => \App\Models\SpeedMeasurement::factory(),
        ];
    }
}
