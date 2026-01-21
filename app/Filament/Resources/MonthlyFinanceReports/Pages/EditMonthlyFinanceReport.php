<?php

namespace App\Filament\Resources\MonthlyFinanceReports\Pages;

use App\Filament\Resources\MonthlyFinanceReports\MonthlyFinanceReportResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMonthlyFinanceReport extends EditRecord
{
    protected static string $resource = MonthlyFinanceReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
