<?php

namespace App\Filament\Resources\AboutPages\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AboutPageForm
{
    public static function configure(Schema $schema): Schema
    {
         return $schema->schema([
            TextInput::make('slug')
                ->label('Slug Halaman')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                ->helperText('Slug digunakan untuk URL internal dan harus unik.'),

            Textarea::make('profil_singkat')
                ->rows(6)
                ->required(),

            Textarea::make('visi')
                ->rows(4)
                ->required(),

            Repeater::make('misi')
                ->schema([
                    TextInput::make('item')->required(),
                ])
                ->defaultItems(4)
                ->mutateDehydratedStateUsing(fn ($state) => collect($state)->pluck('item')->values()->all())
                ->mutateStateForValidationUsing(fn ($state) => collect($state ?? [])->map(fn ($v) => ['item' => $v])->all())
                ->addActionLabel('Tambah Misi')
                ->required(),

            Repeater::make('nilai')
                ->schema([
                    TextInput::make('icon')
                        ->helperText('Contoh: 🤝 / 📊 / 🚀 / 🌱')
                        ->maxLength(4)
                        ->required(),
                    TextInput::make('title')->required(),
                    Textarea::make('desc')->rows(2)->required(),
                ])
                ->addActionLabel('Tambah Nilai')
                ->required(),
        ]);
    }
}
