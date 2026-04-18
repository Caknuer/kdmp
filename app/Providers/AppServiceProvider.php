<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $settings = Setting::all()->pluck('value', 'key')->toArray();
            $gmapsUrl = $settings['gmaps_url'] ?? null;

            $gmapsEmbed = null;
            if ($gmapsUrl && preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+),(\d+(\.\d+)?)z/', $gmapsUrl, $m)) {
                $gmapsEmbed = "https://www.google.com/maps?q={$m[1]},{$m[2]}&z=".(int)$m[3]."&output=embed";
            }

            $view->with('setting', (object) [
                'site_name' => $settings['site_name'] ?? null,
                'address' => $settings['address'] ?? null,
                'phone' => $settings['phone'] ?? null,
                'email' => $settings['email'] ?? null,
                'footer_description' => $settings['footer_description'] ?? null,
                'gmaps_url' => $gmapsUrl,
                'gmaps_embed_src' => $gmapsEmbed,
                'facebook' => $settings['facebook'] ?? null,
                'instagram' => $settings['instagram'] ?? null,
                'twitter' => $settings['twitter'] ?? null,
                'youtube' => $settings['youtube'] ?? null,
                'whatsapp' => $settings['whatsapp'] ?? null,
            ]);
        });
    }
}
