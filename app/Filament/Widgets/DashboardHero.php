<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardHero extends Widget
{
    protected string $view = 'filament.widgets.dashboard-hero';

    protected static ?int $sort = 0;

    // kiri atas (3/4)
    protected int|string|array $columnSpan = 3;
}
