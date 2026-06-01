<?php

namespace App\Filament\Widgets;

use App\Models\Cliente;
use App\Models\ItemPedido;
use Filament\Widgets\ChartWidget;

class GraficoClientes extends ChartWidget
{
    protected static ?int $sort = 7;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        // top 10 clientes por quantidade vendida (via item_pedido -> pedido -> cliente)
        $rows = ItemPedido::query()
            ->join('pedidos', 'pedidos.id', '=', 'item_pedidos.pedido_id')
            ->selectRaw('pedidos.cliente_id, SUM(item_pedidos.quantidade) as total')
            ->groupBy('pedidos.cliente_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $clienteIds = $rows->pluck('cliente_id')->all();

        $clientes = Cliente::query()
            ->whereIn('id', $clienteIds)
            ->pluck('id', 'id');

        $labels = $rows->map(fn ($r) => 'Cliente #' . $r->cliente_id)->values()->all();
        $series = $rows->pluck('total')->map(fn ($v) => (float) $v)->values()->all();

        return [
            'datasets' => [
                [
                    'label' => 'Quantidade Vendida',
                    'data' => $series,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.35)',
                    'borderColor' => 'rgba(16, 185, 129, 1)',
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

