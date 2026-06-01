<?php

namespace App\Filament\Widgets;

use App\Models\Estoque;
use Filament\Widgets\ChartWidget;

class GraficoEstoques extends ChartWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $totais = Estoque::query()
            ->selectRaw("tipo, SUM(quantidade) as total")
            ->groupBy('tipo')
            ->get();

        $map = [
            'entrada' => 0,
            'saida' => 0,
        ];

        foreach ($totais as $t) {
            $map[$t->tipo] = (float) $t->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Quantidade',
                    'data' => [
                        $map['entrada'],
                        $map['saida'],
                    ],
                    'backgroundColor' => [
                        'rgba(34, 197, 94, 0.35)',
                        'rgba(239, 68, 68, 0.35)',
                    ],
                    'borderColor' => [
                        'rgba(34, 197, 94, 1)',
                        'rgba(239, 68, 68, 1)',
                    ],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Entradas', 'Saídas'],
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

