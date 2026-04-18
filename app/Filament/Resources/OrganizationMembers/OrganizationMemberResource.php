<?php

namespace App\Filament\Resources\OrganizationMembers;

use App\Filament\Resources\OrganizationMembers\Pages\CreateOrganizationMember;
use App\Filament\Resources\OrganizationMembers\Pages\EditOrganizationMember;
use App\Filament\Resources\OrganizationMembers\Pages\ListOrganizationMembers;
use App\Filament\Resources\OrganizationMembers\Schemas\OrganizationMemberForm;
use App\Filament\Resources\OrganizationMembers\Tables\OrganizationMembersTable;
use App\Models\OrganizationMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;


class OrganizationMemberResource extends Resource
{
    protected static ?string $model = OrganizationMember::class;
    
    protected static ?string $navigationLabel = 'Struktur Organisasi';
    
    protected static ?string $pluralModelLabel = 'Struktur Organisasi';
    
    protected static ?string $modelLabel = 'Struktur Organisasi';
    
    protected static ?int $navigationSort = 6;
    
    protected static string|UnitEnum|null $navigationGroup = 'Konten';

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-user-group';

    public static function form(Schema $schema): Schema
    {
        return OrganizationMemberForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OrganizationMembersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrganizationMembers::route('/'),
            'create' => CreateOrganizationMember::route('/create'),
            'edit' => EditOrganizationMember::route('/{record}/edit'),
        ];
    }
}
