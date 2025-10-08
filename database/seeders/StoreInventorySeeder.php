<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\StoreInventory::insert([
            [
                'book_id'  => 1,
                'store_front_id' => 1,
                'book_quantity'  => 20,
                'stocked_quantity'  => 20,
                'is_available'  => 'true',
                'admin_disabled'  => 'false',
            ]
            ]);
    }
}
