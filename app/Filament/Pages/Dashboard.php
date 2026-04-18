<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;

use App\Filament\Widgets\DashboardHero;
use App\Filament\Widgets\FinanceSummary;
use App\Filament\Widgets\QuickActions;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\ArticlesChart;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard Admin';
    protected static ?string $title = 'Dashboard Admin';
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-home';

    public function getHeaderWidgets(): array
    {
        return [
            DashboardHero::class,     // kiri (3 kolom)
            QuickActions::class,      // kanan (1 kolom)
            StatsOverview::class,     // full
        ];
    }

    public function getWidgets(): array
    {
        return [
            FinanceSummary::class,
            // ArticlesChart::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 4;
    }
}
