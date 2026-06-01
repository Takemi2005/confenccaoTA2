<?php

namespace App\Filament\Widgets;

use App\Models\Pedido;
use Filament\Widgets\ChartWidget;

class GraficoPedidos extends ChartWidget
{
    protected static ?int $sort = 5;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $rows = Pedido::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $labels = $rows->pluck('status')->map(fn ($s) => (string) $s)->all();
        $series = $rows->pluck('total')->map(fn ($v) => (float) $v)->all();

        return [
            'datasets' => [
                [
                    'label' => 'Pedidos por Status',
                    'data' => $series,
                    'backgroundColor' => 'rgba(168, 85, 247, 0.35)',
                    'borderColor' => 'rgba(168, 85, 247, 1)',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels ?: ['—'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}

