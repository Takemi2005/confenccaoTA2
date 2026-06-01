<?php

namespace App\Filament\Widgets;

use App\Models\MovimentacaoEstoque;
use Filament\Widgets\ChartWidget;

class GraficoMovimentacaoEstoques extends ChartWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $entradas = MovimentacaoEstoque::query()
            ->where('tipo', 'entrada')
            ->orderByDesc('created_at')
            ->limit(7)
            ->get()
            ->reverse()
            ->values();

        $saidas = MovimentacaoEstoque::query()
            ->where('tipo', 'saida')
            ->orderByDesc('created_at')
            ->limit(7)
            ->get()
            ->reverse()
            ->values();

        $labels = $entradas->pluck('created_at')->map(fn ($d) => $d->format('d/m'))->all();

        $entradaSeries = $entradas->pluck('quantidade')->map(fn ($v) => (float) $v)->all();
        $saidaSeries = $saidas->pluck('quantidade')->map(fn ($v) => (float) $v)->all();

        $entradaSeries = array_pad($entradaSeries, count($labels), 0);
        $saidaSeries = array_pad($saidaSeries, count($labels), 0);

        return [
            'datasets' => [
                [
                    'label' => 'Entradas',
                    'data' => $entradaSeries,
                    'backgroundColor' => 'rgba(34, 197, 94, 0.35)',
                    'borderColor' => 'rgba(34, 197, 94, 1)',
                    'borderWidth' => 2,
                ],
                [
                    'label' => 'Saídas',
                    'data' => $saidaSeries,
                    'backgroundColor' => 'rgba(239, 68, 68, 0.35)',
                    'borderColor' => 'rgba(239, 68, 68, 1)',
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

