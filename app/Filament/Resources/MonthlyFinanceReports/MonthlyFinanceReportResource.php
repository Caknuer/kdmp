<?php

namespace App\Filament\Resources\MonthlyFinanceReports;

use App\Filament\Resources\MonthlyFinanceReports\Pages\CreateMonthlyFinanceReport;
use App\Filament\Resources\MonthlyFinanceReports\Pages\EditMonthlyFinanceReport;
use App\Filament\Resources\MonthlyFinanceReports\Pages\ListMonthlyFinanceReports;
use App\Filament\Resources\MonthlyFinanceReports\Schemas\MonthlyFinanceReportForm;
use App\Filament\Resources\MonthlyFinanceReports\Tables\MonthlyFinanceReportsTable;
use App\Models\MonthlyFinanceReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class MonthlyFinanceReportResource extends Resource
{
    protected static ?string $model = MonthlyFinanceReport::class;

    protected static ?string $navigationLabel = 'Transparansi Keuangan';
    protected static string|\UnitEnum|null $navigationGroup = 'Keuangan';


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MonthlyFinanceReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MonthlyFinanceReportsTable::configure($table);
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
            'index' => ListMonthlyFinanceReports::route('/'),
            'create' => CreateMonthlyFinanceReport::route('/create'),
            'edit' => EditMonthlyFinanceReport::route('/{record}/edit'),
        ];
    }
}
