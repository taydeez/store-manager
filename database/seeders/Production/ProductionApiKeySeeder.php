<?php
/*
 * © 2026 Demilade Oyewusi
 * Licensed under the MIT License.
 * See the LICENSE file for details.
 */

namespace Database\Seeders\Production;

use App\Models\ApiClient;
use Illuminate\Database\Seeder;

class ProductionApiKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApiClient::firstOrCreate(
            [
                'domain' => '*',
                'api_key' => 'sk_live_9f8c1e2b4a7d6c0e3b5f91a2d4c8e7f6b0a9c1d2e4f5a6b7c8d9e0f1a345',
                'created_at' => '2026-01-01 00:00:00',
                'expires_at' => '2027-01-01 00:00:00',
            ],
        );
    }
}
