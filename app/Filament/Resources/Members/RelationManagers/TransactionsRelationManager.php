<?php

namespace App\Filament\Resources\Members\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    protected static ?string $title = 'Riwayat Tabungan';

    /* ==========================================================
       FORM INPUT TRANSAKSI
    ========================================================== */
    public function form(Schema $schema): Schema
    {
        return $schema->schema([

            DatePicker::make('date')
                ->label('Tanggal')
                ->required(),

            Select::make('type')
                ->label('Tipe Transaksi')
                ->required()
                ->options([
                    'credit' => 'Setoran (Tambah)',
                    'debit'  => 'Penarikan (Kurang)',
                ]),

            Select::make('category')
                ->label('Kategori')
                ->required()
                ->options([
                    'initial'    => 'Saldo Awal',
                    'monthly'    => 'Setor Bulanan',
                    'voluntary'  => 'Nabung Sukarela',
                    'withdraw'   => 'Penarikan',
                ]),

            TextInput::make('amount')
                ->label('Nominal')
                ->numeric()
                ->required()
                ->minValue(1000),

            Textarea::make('description')
                ->label('Keterangan')
                ->rows(2)
                ->placeholder('Catatan tambahan (opsional)'),

        ]);
    }

    /* ==========================================================
       TABLE RIWAYAT TRANSAKSI
    ========================================================== */
    public function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn ($state) =>
                        $state === 'credit'
                            ? 'Setor'
                            : 'Tarik'
                    )
                    ->color(fn ($state) =>
                        $state === 'credit'
                            ? 'success'
                            : 'danger'
                    ),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'initial'   => 'Saldo Awal',
                        'monthly'   => 'Setor Bulanan',
                        'voluntary' => 'Nabung Sukarela',
                        'withdraw'  => 'Penarikan',
                        default     => ucfirst($state),
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->formatStateUsing(fn ($state) =>
                        'Rp ' . number_format((float) $state, 0, ',', '.')
                    )
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Keterangan')
                    ->limit(40),

            ])
            ->defaultSort('date', 'desc')

            /* ==========================
               HEADER ACTIONS
            ========================== */
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Transaksi'),
            ])

            /* ==========================
               ROW ACTIONS
            ========================== */
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])

            /* ==========================
               BULK ACTIONS
            ========================== */
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
