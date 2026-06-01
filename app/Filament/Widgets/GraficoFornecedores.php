<?php

namespace App\Filament\Widgets;

use App\Models\Fornecedores;
use Filament\Widgets\ChartWidget;

class GraficoFornecedores extends ChartWidget
{
    protected static ?int $sort = 9;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $total = (int) Fornecedores::query()->count();

        return [
            'datasets' => [
                [
                    'label' => 'Total de Fornecedores',
                    'data' => [$total],
                    'backgroundColor' => ['rgba(244, 63, 94, 0.35)'],
                    'borderColor' => ['rgba(244, 63, 94, 1)'],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Fornecedores'],
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

