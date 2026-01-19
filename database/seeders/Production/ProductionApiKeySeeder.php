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
                'api_key' => config('app.x_api_key'),
                'created_at' => '2026-01-01 00:00:00',
                'expires_at' => '2027-01-01 00:00:00',
            ],
        );
    }
}
