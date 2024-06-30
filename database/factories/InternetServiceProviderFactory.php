<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InternetServiceProvider>
 */
class InternetServiceProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'service_type' => 'fiber',
            'ip' => $this->faker->ipv4,
            'city' => $this->faker->city,
            'region' => $this->faker->state,
            'country' => $this->faker->country,
            'loc' => $this->faker->latitude . ',' . $this->faker->longitude,
            'org' => $this->faker->company,
            'timezone' => $this->faker->timezone,
            'user_id' => null,
        ];
    }
}
