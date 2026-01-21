<?php

namespace App\Filament\Resources\MonthlyFinanceReports\Pages;

use App\Filament\Resources\MonthlyFinanceReports\MonthlyFinanceReportResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMonthlyFinanceReports extends ListRecords
{
    protected static string $resource = MonthlyFinanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
