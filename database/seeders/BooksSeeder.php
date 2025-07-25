<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksSeeder extends Seeder
{
    /**
     * R)un the database seeds.
     */
    public function run(): void
    {
        \App\Models\Books::insert([
            // ID 1
            [
                'title'     => 'Amazing Book One',
                'added_by'  => 1,
                'quantity'  => 20,
                'price'     => 4000,
                'tags'      => json_encode(['main_store','new']),
            ],
            [
                'title'     => 'Beautiful Book',
                'added_by'  => 1,
                'quantity'  => 10,
                'price'     => 3000,
                'tags'      => json_encode(['main_store','new']),
            ],
            [
                'title'     => 'The watcher',
                'added_by'  => 1,
                'quantity'  => 15,
                'price'     => 3500,
                'tags'      => json_encode(['main_store','new']),
            ],
            [
                'title'     => 'Quicksand Islands',
                'added_by'  => 1,
                'quantity'  => 40,
                'price'     => 7000,
                'tags'      => json_encode(['main_store','old']),
            ],
            [
                'title'     => 'The title should be longer just for testing purposes',
                'added_by'  => 1,
                'quantity'  => 35,
                'price'     => 1500,
                'tags'      => json_encode(['main_store','old']),
            ]
        ]);
    }
}
