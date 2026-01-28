<?php

namespace App\Filament\Resources\MonthlyFinanceReports\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MonthlyFinanceReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('month')
                    ->label('Bulan Laporan')
                    ->placeholder('Contoh: 2026-01')
                    ->required(),

                TextInput::make('income')
                    ->label('Total Pemasukan')
                    ->prefix('Rp')
                    ->numeric()
                    ->required(),

                TextInput::make('expense')
                    ->label('Total Pengeluaran')
                    ->prefix('Rp')
                    ->numeric()
                    ->required(),

                TextInput::make('balance')
                    ->label('Saldo Akhir')
                    ->prefix('Rp')
                    ->numeric()
                    ->required(),

                Toggle::make('is_published')
                    ->label('Tampilkan di Transparansi Publik')
                    ->helperText('Jika aktif, laporan ini akan muncul di halaman Transparansi.')
                    ->required(),

                Textarea::make('note')
                    ->label('Catatan Tambahan')
                    ->placeholder('Tambahkan catatan jika diperlukan...')
                    ->columnSpanFull(),
            ]);
    }
}
