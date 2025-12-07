<?php

namespace Database\Seeders;

use App\Models\{Book, Customer, Order, StoreFront, StoreInventory, User};
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        foreach (range(1, 5) as $userId) {
            StoreFront::factory()->create([
                'user_id' => $userId,
            ]);
        }


        Book::factory(50)->create();

        StoreInventory::factory(50)->create();

        Customer::factory(50)->create();

        Order::factory(30)->create();

        $this->call(ApiKeySeeder::class);
        $this->call(RolePermissionSeeder::class);
    }
}
