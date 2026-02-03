<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\BusinessUnit;
use App\Models\OrganizationMember;
use App\Models\Partner;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $income = Transaction::where('type', 'income')->sum('amount');
        $expense = Transaction::where('type', 'expense')->sum('amount');
        $saldo = $income - $expense;

        return [
            Stat::make('Total Artikel', Article::count())
                ->icon('heroicon-m-document-text'),

            Stat::make('Artikel Aktif', Article::where('is_published', true)->count())
                ->icon('heroicon-m-check-badge'),

            Stat::make('Unit Bisnis', BusinessUnit::count())
                ->icon('heroicon-m-building-office-2'),

            Stat::make('Mitra', Partner::count())
                ->icon('heroicon-m-hand-raised'),

            Stat::make(
                'Pengurus Aktif',
                OrganizationMember::where('type', 'pengurus')->where('is_active', true)->count()
            )->icon('heroicon-m-user-group'),

            Stat::make(
                'Pengawas Aktif',
                OrganizationMember::where('type', 'pengawas')->where('is_active', true)->count()
            )->icon('heroicon-m-shield-check'),

            Stat::make('Total Pemasukan', 'Rp ' . number_format($income))
                ->color('success')
                ->icon('heroicon-m-arrow-trending-up'),

            Stat::make('Total Pengeluaran', 'Rp ' . number_format($expense))
                ->color('danger')
                ->icon('heroicon-m-arrow-trending-down'),

            Stat::make('Saldo', 'Rp ' . number_format($saldo))
                ->color($saldo >= 0 ? 'success' : 'danger')
                ->icon('heroicon-m-wallet'),
        ];
    }
}
