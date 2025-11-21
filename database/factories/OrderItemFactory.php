<?php

namespace Database\Factories;


use App\Models\Book;
use App\Models\StoreFront;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 10, 300);
        $qty = $this->faker->numberBetween(1, 5);

        return [
            'book_id' => Book::inRandomOrder()->value('id'),
            'store_front_id' => StoreFront::inRandomOrder()->value('id') ?? StoreFront::factory(),
            'quantity' => $qty,
            'unit_price' => $price,
            'sub_total' => $price * $qty,
        ];
    }
}
