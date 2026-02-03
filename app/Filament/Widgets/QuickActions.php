<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickActions extends Widget
{
    protected string $view = 'filament.widgets.quick-actions';

    protected static ?int $sort = 1;

    // kanan atas (1/4)
    protected int|string|array $columnSpan = 1;
}
