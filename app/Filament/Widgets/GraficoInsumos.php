<?php

namespace App\Filament\Widgets;

use App\Models\Insumo;
use Filament\Widgets\ChartWidget;

class GraficoInsumos extends ChartWidget
{
    protected static ?int $sort = 8;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $total = (int) Insumo::query()->count();

        return [
            'datasets' => [
                [
                    'label' => 'Total de Insumos',
                    'data' => [$total],
                    'backgroundColor' => ['rgba(59, 130, 246, 0.35)'],
                    'borderColor' => ['rgba(59, 130, 246, 1)'],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Insumos'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }
}

