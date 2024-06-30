<?php

// database/factories/UserAgentFactory.php

namespace Database\Factories;

use App\Models\UserAgent;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAgentFactory extends Factory
{
    protected $model = UserAgent::class;

    public function definition()
    {
        return [
            'user_agent' => $this->faker->userAgent,
            'user_id' => null, // Allow null user
            // 'speed_measurement_id' => \App\Models\SpeedMeasurement::factory(),
        ];
    }
}
