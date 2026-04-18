<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class QuickActions extends Widget
{
    protected string $view = 'filament.widgets.quick-actions';

    protected static ?int $sort = 3;
    
    protected static ?string $heading = 'Aksi Cepat';

    protected int|string|array $columnSpan = 1;
}
