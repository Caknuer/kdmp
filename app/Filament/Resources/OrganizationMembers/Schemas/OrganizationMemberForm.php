<?php

namespace App\Filament\Resources\OrganizationMembers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class OrganizationMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name_p')
                ->label('Nama')
                ->required(),
            TextInput::make('role')->required(),

            Select::make('type')
                ->options([
                    'pengurus' => 'Pengurus',
                    'pengawas' => 'Pengawas',
                ])
                ->required(),

            FileUpload::make('photo_p')
                ->disk('public')
                ->label('Photo')
                ->directory('organization')
                ->visibility('public')
                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg', 'image/webp'])
                ->maxSize(5120) // 5MB limit
                ->preserveFilenames(),

            Textarea::make('bio')->rows(4),

            TextInput::make('order')
                        ->numeric()
                        ->default(0)
                        ->required(),
            Toggle::make('is_active')->default(true),
        ]);
    }
}