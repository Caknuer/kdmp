<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Article;
use App\Models\BusinessUnit;
use App\Models\Transaction;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Berita', Article::count()),
            Stat::make('Unit Usaha', BusinessUnit::count()),
            Stat::make('Transaksi', Transaction::count()),
        ];
    }
}
