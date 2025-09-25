<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Stocks::insert([
            // ID 1
            [
                'book_id'         => 1,
                'user_id'         => 1,
                'quantity'        => 20,
                'added'           => 20,
                'removed'         => 0,
                'description'     => "Book added",
            ],
            [
                'book_id'         => 2,
                'user_id'         => 1,
                'quantity'        => 20,
                'added'           => 20,
                'removed'         => 0,
                'description'     => "Book added",
            ],
            [
                'book_id'         => 3,
                'user_id'         => 1,
                'quantity'        => 20,
                'added'           => 20,
                'removed'         => 0,
                'description'     => "Book added",
            ],
            [
                'book_id'         => 4,
                'user_id'         => 1,
                'quantity'        => 20,
                'added'           => 20,
                'removed'         => 0,
                'description'     => "Book added",
            ],
            [
                'book_id'         => 5,
                'user_id'         => 1,
                'quantity'        => 20,
                'added'           => 20,
                'removed'         => 0,
                'description'     => "Book added",
            ]
        ]);
    }
}
