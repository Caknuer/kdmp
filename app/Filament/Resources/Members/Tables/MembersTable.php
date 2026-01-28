<?php

namespace App\Filament\Resources\Members\Tables;

use App\Models\Member;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Kode disalin'),

                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('No. HP'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->sortable(),

                TextColumn::make('balance')
                    ->label('Saldo')
                    ->getStateUsing(fn (Member $record) => $record->balance)
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'pending',
                        'approved' => 'approved',
                        'rejected' => 'rejected',
                    ]),
            ])
            ->actions([
                EditAction::make(),

                // ✅ APPROVE + saldo awal
                Action::make('approve')
                    ->label('Approve + Saldo')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn (Member $record) => $record->status === 'pending')
                    ->form([
                        TextInput::make('initial_amount')
                            ->label('Saldo Awal')
                            ->numeric()
                            ->required()
                            ->minValue(0),

                        TextInput::make('description')
                            ->label('Keterangan')
                            ->default('Saldo awal dari admin'),
                    ])
                    ->requiresConfirmation()
                    ->action(function (Member $record, array $data) {
                        $record->update([
                            'status' => 'approved',
                            'approved_at' => now(),
                        ]);

                        // kalau saldo awal = 0, tidak perlu buat transaksi
                        $initialAmount = (float) ($data['initial_amount'] ?? 0);
                        if ($initialAmount > 0) {
                            $record->transactions()->create([
                                'date' => now()->toDateString(),
                                'type' => 'credit',
                                'category' => 'initial',
                                'description' => $data['description'] ?? null,
                                'amount' => $initialAmount,
                            ]);
                        }
                    }),

                // ✅ TOPUP saldo (setelah approved)
                Action::make('topup')
                    ->label('Topup Saldo')
                    ->icon('heroicon-o-plus-circle')
                    ->color('primary')
                    ->visible(fn (Member $record) => $record->status === 'approved')
                    ->form([
                        TextInput::make('amount')
                            ->label('Nominal')
                            ->numeric()
                            ->required()
                            ->minValue(1),

                        TextInput::make('description')
                            ->label('Keterangan')
                            ->default('Topup saldo oleh admin'),
                    ])
                    ->requiresConfirmation()
                    ->action(function (Member $record, array $data) {
                        $record->transactions()->create([
                            'date' => now()->toDateString(),
                            'type' => 'credit',
                            'category' => 'topup',
                            'description' => $data['description'] ?? null,
                            'amount' => (float) $data['amount'],
                        ]);
                    }),

                // ✅ REJECT (opsional tapi bagus untuk flow)
                Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (Member $record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(function (Member $record) {
                        $record->update([
                            'status' => 'rejected',
                        ]);
                    }),
            ])
            ->bulkActions([
                    BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
