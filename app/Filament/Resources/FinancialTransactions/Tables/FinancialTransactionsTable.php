<?php

namespace App\Filament\Resources\FinancialTransactions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;

class FinancialTransactionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state === 'income' ? 'Pemasukan' : 'Pengeluaran')
                    ->color(fn ($state) => $state === 'income' ? 'success' : 'danger')
                    ->sortable(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR', true)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Filter Jenis')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    ]),
            ])
            ->defaultSort('date', 'desc')
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
