<?php

namespace App\Filament\Resources\FinancialTransactions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class FinancialTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label('Tanggal')
                    ->required()
                    ->default(now()),

                Select::make('type')
                    ->label('Jenis')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    ])
                    ->required(),

                TextInput::make('category')
                    ->label('Kategori')
                    ->placeholder('Contoh: Operasional / Donasi / Pendaftaran')
                    ->maxLength(255)
                    ->nullable(),

                Textarea::make('description')
                    ->label('Keterangan')
                    ->rows(2)
                    ->nullable(),

                TextInput::make('amount')
                    ->label('Nominal')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->prefix('Rp'),
            ]);
    }
}
