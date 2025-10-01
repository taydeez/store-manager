<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StoreFront>
 */
class StoreFrontFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'store_name' => $this->faker->company,
            'store_address' => $this->faker->address,
            'store_country' => $this->faker->country,
            'store_phone' => $this->faker->phoneNumber,
            'store_email' => $this->faker->email,
            'is_active' => $this->faker->randomElement(['true', 'false']),
            'store_city' => $this->faker->city,
        ];
    }
}
