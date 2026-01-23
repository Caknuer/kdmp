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

            $view->with('setting', (object) [
                'site_name' => $settings['site_name'] ?? null,
                'address' => $settings['address'] ?? null,
                'phone' => $settings['phone'] ?? null,
                'email' => $settings['email'] ?? null,
                'website' => $settings['website'] ?? null,
                'footer_description' => $settings['footer_description'] ?? null,
                'gmaps' => $settings['gmaps'] ?? null,
            ]);
        });
    }
}
