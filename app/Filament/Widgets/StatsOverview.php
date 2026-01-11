<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Article;
use App\Models\Busines;
use App\Models\Transaction;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Berita', Article::count()),
            Stat::make('Unit Usaha', Busines::count()),
            Stat::make('Transaksi', Transaction::count()),
        ];
    }
}
