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
            Textarea::make('profil_singkat')
                ->label('Profil Singkat')
                ->rows(6)
                ->required(),

            Textarea::make('visi')
                ->label('Visi')
                ->rows(4)
                ->required(),

            Repeater::make('misi')
                ->label('Misi')
                ->schema([
                    TextInput::make('item')->required(),
                ])
                ->defaultItems(4)
                ->mutateDehydratedStateUsing(fn ($state) => collect($state)->pluck('item')->values()->all())
                ->mutateStateForValidationUsing(fn ($state) => collect($state ?? [])->map(fn ($v) => ['item' => $v])->all())
                ->addActionLabel('Tambah Misi')
                ->required(),

            Repeater::make('nilai')
                ->label('Nilai-Nilai')
                ->schema([
                    TextInput::make('icon')
                        ->label('Icon')
                        ->helperText('Contoh: 🤝 / 📊 / 🚀 / 🌱')
                        ->maxLength(4)
                        ->required(),
                    TextInput::make('title')
                        ->label('Judul Nilai')
                        ->required(),
                    Textarea::make('desc')
                        ->label('Deskripsi')
                        ->rows(2)
                        ->required(),
                ])
                ->addActionLabel('Tambah Nilai')
                ->required(),
        ]);
    }
}
