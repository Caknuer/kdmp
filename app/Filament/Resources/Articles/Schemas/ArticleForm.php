<?php

namespace App\Filament\Resources\Articles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('slug', Str::slug($state))
                    ),
                TextInput::make('slug')
                    ->required()
                    ->disabled()
                    ->dehydrated(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('thumbnail')
                    ->label('Foto Artikel')
                    ->image()
                    ->disk('public')
                    ->directory('articles')
                    ->imageEditor() // optional tapi bagus
                    ->maxSize(5048) // 5MB
                    ->required(),
                Toggle::make('is_published')
                    ->label('Publikasikan')
                    ->default(false)
                    ->reactive(),

                DateTimePicker::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->visible(fn ($get) => $get('is_published'))
                    ->required(fn ($get) => $get('is_published')),
            ]);
    }
}
