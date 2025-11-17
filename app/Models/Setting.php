<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected static function booted()
    {
        static::saved(function () {
            app(\App\Support\SettingsManager::class)->clearCache();
        });

        static::deleted(function () {
            app(\App\Support\SettingsManager::class)->clearCache();
        });
    }


}
