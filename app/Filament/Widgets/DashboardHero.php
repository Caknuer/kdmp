<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardHero extends Widget
{
    protected string $view = 'filament.widgets.dashboard-hero';

    protected static ?int $sort = 0;
    
    protected static ?string $heading = null;

    protected int|string|array $columnSpan = 3;
    
    public function getCurrentDate(): string
    {
        return now()->translatedFormat('d F Y');
    }
    
    public function getCurrentTime(): string
    {
        return now()->format('H:i');
    }
    
    public function getGreeting(): string
    {
        $hour = (int) now()->format('H');
        if ($hour >= 5 && $hour < 12) {
            return 'Selamat Pagi';
        } elseif ($hour >= 12 && $hour < 15) {
            return 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 19) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }
}
