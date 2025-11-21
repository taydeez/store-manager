<?php

use App\Support\SettingsManager;

if (!function_exists('setting')) {
    function setting(string $key, $default = null)
    {
        return app(SettingsManager::class)->get($key, $default);
    }
}

if (!function_exists('set_setting')) {
    function set_setting(string $key, $value)
    {
        return app(SettingsManager::class)->set($key, $value);
    }
}
