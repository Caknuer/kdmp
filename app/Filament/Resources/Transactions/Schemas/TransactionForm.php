<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                DatePicker::make('date')
                    ->required(),
    
                Select::make('type')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    ])
                    ->required(),
    
                TextInput::make('category')
                    ->required(),
    
                Textarea::make('description'),
    
                TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->prefix('Rp'),
            ]);

    }
}
