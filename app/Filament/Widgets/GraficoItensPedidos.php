<?php

namespace App\Filament\Widgets;

use App\Models\ItemPedido;
use Filament\Widgets\ChartWidget;

class GraficoItensPedidos extends ChartWidget
{
    protected static ?int $sort = 6;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        // top 10 produtos mais vendidos (quantidade)
        $rows = ItemPedido::query()
            ->selectRaw('produto_id, SUM(quantidade) as total')
            ->groupBy('produto_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $produtoIds = $rows->pluck('produto_id')->all();

        $produtos = \App\Models\Produto::query()
            ->whereIn('id', $produtoIds)
            ->pluck('nome', 'id');

        $labels = $rows->map(fn ($r) => (string) ($produtos[(int) $r->produto_id] ?? ('Produto #'.$r->produto_id)))->values()->all();
        $series = $rows->pluck('total')->map(fn ($v) => (float) $v)->values()->all();

        return [
            'datasets' => [
                [
                    'label' => 'Quantidade Vendida',
                    'data' => $series,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.35)',
                    'borderColor' => 'rgba(245, 158, 11, 1)',
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

