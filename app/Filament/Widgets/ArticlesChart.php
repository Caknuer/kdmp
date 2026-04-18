<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ArticlesChart extends ChartWidget
{
    protected ?string $heading = 'Statistik Artikel per Bulan';
    
    protected static ?string $heading_override = 'Statistik Artikel per Bulan';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 3;

    protected function getHeight(): ?string
    {
        return 'auto';
    }
    
    public function getChartOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
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
            $labels[] = Carbon::create()->month($month)->translatedFormat('M');

            $found = $articles->firstWhere('month', $month);
            $data[] = $found ? $found->total : 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Artikel Dibuat',
                    'data' => $data,
                    'backgroundColor' => 'rgba(244, 63, 94, 0.5)',
                    'borderColor' => 'rgb(244, 63, 94)',
                    'borderWidth' => 2,
                    'borderRadius' => 4,
                    'hoverBackgroundColor' => 'rgba(225, 29, 72, 0.7)',
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
