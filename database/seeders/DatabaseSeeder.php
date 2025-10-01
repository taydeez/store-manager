<?php

namespace Database\Seeders;

use App\Models\StoreFront;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        foreach (range(1, 10) as $userId) {
            StoreFront::factory()->create([
                'user_id' => $userId,
            ]);
        }

        $this->call(RolePermissionSeeder::class);
        $this->call(BooksSeeder::class);
        $this->call(StocksSeeder::class);
        $this->call(ApiKeySeeder::class);
    }
}
