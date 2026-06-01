<?php

namespace App\Filament\Widgets;

use App\Models\Produto;
use Filament\Widgets\ChartWidget;

class GraficoProdutos extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $produtos = Produto::query()
            ->withSum('estoques as entradas', [
                'tipo' => 'entrada',
            ])
            ->withSum('estoques as saidas', [
                'tipo' => 'saida',
            ])
            ->get();

        // saldo = entradas - saidas
        $rows = $produtos->map(function ($p) {
            $entradas = (float) ($p->entradas ?? 0);
            $saidas = (float) ($p->saidas ?? 0);
            return [
                'label' => (string) $p->nome,
                'saldo' => $entradas - $saidas,
            ];
        });

        $rows = $rows->sortByDesc('saldo')->take(10)->values();

        $labels = $rows->pluck('label')->all();
        $series = $rows->pluck('saldo')->map(fn ($v) => (float) $v)->all();

        return [
            'datasets' => [
                [
                    'label' => 'Saldo de Estoque',
                    'data' => $series,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.35)',
                    'borderColor' => 'rgba(59, 130, 246, 1)',
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

