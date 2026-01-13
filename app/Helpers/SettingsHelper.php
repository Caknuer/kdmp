<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    /**
     * Ambil value setting berdasarkan key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        return cache()->remember(
            'setting_'.$key,
            now()->addHour(),
            fn () => Setting::where('key', $key)->value('value') ?? $default
        );
    }
}
