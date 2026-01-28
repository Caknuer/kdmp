<?php

namespace App\Filament\Resources\Members\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
        TextInput::make('nama')->required(),
        TextInput::make('nik')->required(),
        Textarea::make('address')->required(),
        TextInput::make('phone')->required(),

        FileUpload::make('ktp_photo_path')
            ->disk('public')
            ->directory('ktp')
            ->image()
            ->required(),

        Select::make('status')
            ->options([
                'pending' => 'pending',
                'approved' => 'approved',
                'rejected' => 'rejected',
            ])
            ->disabled(), // status jangan manual, lewat action approve/reject

        TextInput::make('code')->disabled(),
    ]);
    }
}
