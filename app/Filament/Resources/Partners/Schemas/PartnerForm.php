<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),

            FileUpload::make('logo')
                ->image()
                ->directory('partners')
                ->visibility('public')
                ->imageEditor()
                ->nullable(),

            TextInput::make('website')
                ->url()
                ->maxLength(255)
                ->nullable()
                ->placeholder('https://'),

            TextInput::make('sort_order')
                ->label('Urutan')
                ->numeric()
                ->minValue(0)
                ->default(0)
                ->required(),

            Toggle::make('is_active')
                ->default(true),
        ]);
    }
}
