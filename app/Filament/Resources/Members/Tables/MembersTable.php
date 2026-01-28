<?php

namespace App\Filament\Resources\Members\Tables;

use App\Models\Member;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
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
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((float) $state, 0, ',', '.'))
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

                /* ==========================================================
                   APPROVE + SALDO AWAL
                ========================================================== */
                Action::make('approve')
                    ->label('Approve + Saldo Awal')
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

                        Notification::make()
                            ->title('Berhasil Approve')
                            ->body('Anggota telah di-approve dan saldo awal diproses.')
                            ->success()
                            ->send();
                    }),

                /* ==========================================================
                   TAMBAH TABUNGAN (SETOR) - credit
                   - monthly  : Setor Bulanan
                   - voluntary: Nabung Sukarela
                ========================================================== */
                Action::make('deposit')
                    ->label('Tambah Tabungan')
                    ->icon('heroicon-o-plus-circle')
                    ->color('primary')
                    ->visible(fn (Member $record) => $record->status === 'approved')
                    ->form([
                        Select::make('category')
                            ->label('Jenis Setoran')
                            ->required()
                            ->options([
                                'monthly' => 'Setor Bulanan',
                                'voluntary' => 'Nabung Sukarela',
                            ]),

                        TextInput::make('amount')
                            ->label('Nominal Setor')
                            ->numeric()
                            ->required()
                            ->minValue(1000),

                        TextInput::make('description')
                            ->label('Keterangan')
                            ->default('Setoran tabungan anggota'),
                    ])
                    ->requiresConfirmation()
                    ->action(function (Member $record, array $data) {
                        $record->transactions()->create([
                            'date' => now()->toDateString(),
                            'type' => 'credit',
                            'category' => $data['category'],
                            'description' => $data['description'] ?? null,
                            'amount' => (float) $data['amount'],
                        ]);

                        Notification::make()
                            ->title('Tabungan Ditambahkan')
                            ->body('Setoran berhasil dicatat.')
                            ->success()
                            ->send();
                    }),

                /* ==========================================================
                   AMBIL SALDO (PENARIKAN) - debit
                   Validasi: tidak boleh melebihi saldo
                ========================================================== */
                Action::make('withdraw')
                    ->label('Ambil Saldo')
                    ->icon('heroicon-o-minus-circle')
                    ->color('danger')
                    ->visible(fn (Member $record) => $record->status === 'approved')
                    ->form([
                        TextInput::make('amount')
                            ->label('Nominal Penarikan')
                            ->numeric()
                            ->required()
                            ->minValue(1000),

                        TextInput::make('description')
                            ->label('Keterangan')
                            ->default('Penarikan saldo anggota'),
                    ])
                    ->requiresConfirmation()
                    ->action(function (Member $record, array $data) {

                        $amount = (float) $data['amount'];
                        $currentBalance = (float) $record->balance;

                        if ($amount > $currentBalance) {
                            Notification::make()
                                ->title('Saldo tidak mencukupi!')
                                ->body('Saldo saat ini: Rp ' . number_format($currentBalance, 0, ',', '.'))
                                ->danger()
                                ->send();

                            return;
                        }

                        $record->transactions()->create([
                            'date' => now()->toDateString(),
                            'type' => 'debit',
                            'category' => 'withdraw',
                            'description' => $data['description'] ?? null,
                            'amount' => $amount,
                        ]);

                        Notification::make()
                            ->title('Penarikan Berhasil')
                            ->body('Saldo berhasil dikurangi.')
                            ->success()
                            ->send();
                    }),

                /* ==========================================================
                   REJECT
                ========================================================== */
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

                        Notification::make()
                            ->title('Ditolak')
                            ->body('Pendaftaran anggota ditolak.')
                            ->warning()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
