<?php

namespace Database\Seeders\Production;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProductionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insertOrIgnore([

            [
                'name' => "Super Admin",
                'email' => 'admin@sccportal.com',
                'email_verified_at' => now(),
                'password' => Hash::make('trending@123'),
                'remember_token' => Str::random(10),
                'is_active' => 'true'
            ],
        ]);
    }
}
