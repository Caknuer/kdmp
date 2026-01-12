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
        $value = Setting::where('key', $key)->value('value');
        return $value ?? $default;
    }
}
