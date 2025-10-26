<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\StoreFront;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number' => 'ORD-'.strtoupper(Str::random(8)),
            'customer_id' => Customer::inRandomOrder()->value('id') ?? Customer::factory(),
            'sold_by_id' => User::inRandomOrder()->value('id') ?? User::factory(),
            'store_front_id' => StoreFront::inRandomOrder()->value('id') ?? StoreFront::factory(),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed']),
            'total_amount' => 0,
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }


    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            // create related items
            $items = OrderItem::factory(3)->make([
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status
            ]);

            $order->items()->saveMany($items);

            // update order total
            $order->update([
                'total_amount' => $order->items->sum('subtotal'),
            ]);
        });
    }
}
