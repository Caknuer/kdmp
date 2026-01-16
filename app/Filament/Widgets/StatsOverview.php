<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Article;
use App\Models\BusinessUnit;
use App\Models\Partner;
use App\Models\OrganizationMember;
use App\Models\Transaction;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $income = Transaction::where('type', 'income')->sum('amount');
        $expense = Transaction::where('type', 'expense')->sum('amount');
        return [
            Stat::make('Total Artikel', Article::count()),
            Stat::make('Artikel Aktif', Article::where('is_published', true)->count()),
            Stat::make('Unit Bisnis', BusinessUnit::count()),
            Stat::make('Mitra', Partner::count()),
            Stat::make(
                'Pengurus Aktif',
                OrganizationMember::where('type', 'pengurus')->where('is_active', true)->count()
            ),
            Stat::make(
                'Pengawas Aktif',
                OrganizationMember::where('type', 'pengawas')->where('is_active', true)->count()
            ),
            Stat::make('Total Pemasukan', 'Rp ' . number_format($income))
                ->color('success'),

            Stat::make('Total Pengeluaran', 'Rp ' . number_format($expense))
                ->color('danger'),

            Stat::make('Saldo', 'Rp ' . number_format($income - $expense))
                ->color($income - $expense >= 0 ? 'success' : 'danger'),
        ];
    }
}
