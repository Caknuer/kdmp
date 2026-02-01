<?php

namespace App\Filament\Resources\BusinessUnits\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class BusinessUnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([

                TextInput::make('name')
                    ->label('Nama Unit Usaha')
                    ->required()
                    ->maxLength(120)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        // slug tidak berubah saat edit (URL stabil)
                        if (filled($get('slug'))) return;
                        $set('slug', Str::slug($state));
                    }),

                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('category')
                    ->label('Kategori Unit')
                    ->options([
                        'Keuangan' => 'Keuangan',
                        'Perdagangan' => 'Perdagangan',
                        'Produksi' => 'Produksi',
                        'Jasa' => 'Jasa',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $map = [
                            'Keuangan' => 'heroicon-o-banknotes',
                            'Perdagangan' => 'heroicon-o-shopping-cart',
                            'Produksi' => 'heroicon-o-cog-6-tooth',
                            'Jasa' => 'heroicon-o-briefcase',
                            'Lainnya' => 'heroicon-o-building-storefront',
                        ];

                        $set('icon', $map[$state] ?? 'heroicon-o-building-storefront');
                    }),

                Select::make('icon')
                    ->label('Icon Unit')
                    ->options([
                        'heroicon-o-banknotes' => 'Keuangan (Banknotes)',
                        'heroicon-o-shopping-cart' => 'Perdagangan (Cart)',
                        'heroicon-o-cog-6-tooth' => 'Produksi (Gear)',
                        'heroicon-o-briefcase' => 'Jasa (Briefcase)',
                        'heroicon-o-building-storefront' => 'Umum (Storefront)',
                    ])
                    ->required()
                    ->helperText('Aman untuk tampilan production'),

                FileUpload::make('thumbnail')
                    ->label('Logo Unit')
                    ->image()
                    ->disk('public')
                    ->directory('unit-usaha')
                    ->visibility('public')
                    ->maxSize(2048)
                    ->columnSpanFull(),

                Textarea::make('description')
                    ->label('Deskripsi Unit')
                    ->rows(3)
                    ->columnSpanFull(),

                Textarea::make('services')
                    ->label('Contoh Layanan')
                    ->rows(4)
                    ->helperText('Pisahkan layanan dengan baris baru')
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),

                TextInput::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->required(),
            ]);
    }
}
