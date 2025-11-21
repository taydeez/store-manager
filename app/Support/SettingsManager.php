<?php
/*
 *
 *  * © ${YEAR} Demilade Oyewusi
 *  * Licensed under the MIT License.
 *  * See the LICENSE file for details.
 *
 */

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsManager
{
    protected string $cacheKey = 'app.settings.all';
    protected int $cacheTTL = 3600; // 1 hour

    /**
     * Get a setting by key.
     */
    public function get(string $key, $default = null)
    {
        $settings = $this->all();

        return $settings[$key] ?? $default;
    }

    /**
     * Return all settings (cached).
     */
    public function all(): array
    {
        return Cache::remember($this->cacheKey, $this->cacheTTL, function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Set or update a setting.
     */
    public function set(string $key, $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        $this->clearCache();
    }

    /**
     * Clear the settings cache.
     */
    public function clearCache(): void
    {
        Cache::forget($this->cacheKey);
    }
}
