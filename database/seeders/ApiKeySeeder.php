<?php

namespace Database\Seeders;

use App\Models\ApiClient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         ApiClient::insert([

            [
                'api_key'     => '2e4c9b93f5d18e72a1b0c6d4f8e7a9b1c3d5e6f7a8b9c0d1e2f3a4b5c6d7e8f9',
                'domain'      => '127.0.0.1',
                'expires_in'  => 120
            ]
         ]);
    }
}
