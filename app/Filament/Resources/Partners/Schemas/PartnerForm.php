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
                ->imageEditor(),

            TextInput::make('website')
                ->url()
                ->placeholder('https://'),

            TextInput::make('order')
                ->numeric()
                ->default(0),

            Toggle::make('is_active')
                ->default(true),
        ]);
    }
}
