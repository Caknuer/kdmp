<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class PartnerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
                
                Textarea::make('description')
                ->label('Keterangan')
                ->rows(2)
                ->nullable(),
                
                FileUpload::make('logo')
                ->image()
                ->required()
                ->disk("public")
                ->directory('partners')
                ->visibility('public')
                ->imageEditor()
                ->nullable(),
                
                TextInput::make('website')
                ->url()
                ->required()
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
