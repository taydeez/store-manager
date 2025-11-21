<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'added_by' => User::inRandomOrder()->value('id'),
            'quantity' => $this->faker->numberBetween(1, 100),
            'price' => $this->faker->randomElement([1000, 2000, 3000, 4000, 5000, 6000, 10000, 15000, 20000]),
            'image_url' => $this->faker->imageUrl(
                width: 640, // Optional: Specify the desired width
                height: 480, // Optional: Specify the desired height
                category: 'animals', // Optional: Specify an image category (e.g., 'cats', 'nature')
                randomize: true, // Optional: Get a random image (default: true)
                word: 'Bookstore' // Optional: Add a text overlay to the image
            ),
            'available' => $this->faker->randomElement(['true', 'false']),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Book $book) {
            $item = Stock::factory(1)->make([
                'user_id' => $book->added_by,
                'book_id' => $book->id,
                'main_store_quantity' => $book->quantity,
                'grand_quantity' => $book->quantity,
                'added' => $book->quantity,
            ]);

            $book->stocks()->saveMany($item);
        });
    }
}
