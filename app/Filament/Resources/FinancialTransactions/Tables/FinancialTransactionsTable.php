<?php

namespace App\Filament\Resources\FinancialTransactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class FinancialTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')->date(),
                TextColumn::make('type')->badge(),
                TextColumn::make('category')->searchable(),
                TextColumn::make('amount')
                    ->money('IDR', true),
                // TextColumn::make('published_at')
                //     ->dateTime()
                //     ->sortable(),   

            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
