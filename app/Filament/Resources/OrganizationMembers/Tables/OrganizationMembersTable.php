<?php

namespace App\Filament\Resources\OrganizationMembers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;

class OrganizationMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) =>
                $query->where('type', 'pengurus')
            )
            ->defaultSort('order')
            ->columns([
                ImageColumn::make('photo')->circular(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('role'),
                TextColumn::make('type')->badge(),
                ToggleColumn::make('is_active'),
            ])
            ->filters([
                 SelectFilter::make('type')   
                ->options([
                    'pengurus' => 'Pengurus',
                    'pengawas' => 'Pengawas',
                ]),
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
