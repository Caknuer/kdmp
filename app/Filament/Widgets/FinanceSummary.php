<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\Widget;

class FinanceSummary extends Widget
{
    protected string $view = 'filament.widgets.finance-summary';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    public function getIncome(): int|float
    {
        return (float) Transaction::where('type', 'income')->sum('amount');
    }

    public function getExpense(): int|float
    {
        return (float) Transaction::where('type', 'expense')->sum('amount');
    }

    public function getSaldo(): int|float
    {
        return $this->getIncome() - $this->getExpense();
    }
}
