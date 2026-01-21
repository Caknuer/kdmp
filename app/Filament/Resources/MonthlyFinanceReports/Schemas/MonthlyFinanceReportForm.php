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
                    ->required(),
                TextInput::make('income')
                    ->required()
                    ->numeric(),
                TextInput::make('expense')
                    ->required()
                    ->numeric(),
                TextInput::make('balance')
                    ->required()
                    ->numeric(),
                Toggle::make('is_published')
                    ->required(),
                Textarea::make('note')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
