<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\StoreFront;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StoreInventory>
 */
class StoreInventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::inRandomOrder()->value('id'),
            'store_front_id' => StoreFront::inRandomOrder()->value('id'),
            'book_quantity' => 10,
            'stocked_quantity' => 10,
            'is_available' => $this->faker->randomElement(['true', 'false']),
            'admin_disabled' => 'false',
        ];
    }
}
