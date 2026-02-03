<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ArticlesChart extends ChartWidget
{
    protected ?string $heading = 'Jumlah Artikel per Bulan';

    protected static ?int $sort = 1;

    // 3 dari 4 kolom (kiri)
    protected int|string|array $columnSpan = 3;

    protected function getHeight(): ?string
    {
        return '50px';
    }

    protected function getData(): array
    {
        $articles = Article::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];

        foreach (range(1, 12) as $month) {
            $labels[] = Carbon::create()->month($month)->translatedFormat('F');

            $found = $articles->firstWhere('month', $month);
            $data[] = $found ? $found->total : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Artikel',
                    'data' => $data,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
