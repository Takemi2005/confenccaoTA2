<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;

class GraficoUsers extends ChartWidget
{
    protected static ?int $sort = 11;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        // Contagem de usuários por role (Spatie)
        $roleStats = [];

        $roles = \Spatie\Permission\Models\Role::query()->orderBy('name')->get();

        foreach ($roles as $role) {
            $roleStats[] = [
                'label' => (string) $role->name,
                'total' => (int) User::role($role->name)->count(),
            ];
        }

        // remove roles com 0, mantendo visual
        $roleStats = array_values(array_filter($roleStats, fn ($r) => $r['total'] > 0));

        if (empty($roleStats)) {
            $roleStats = [
                ['label' => 'Sem roles', 'total' => (int) User::query()->count()],
            ];
        }

        $labels = array_map(fn ($r) => $r['label'], $roleStats);
        $series = array_map(fn ($r) => (float) $r['total'], $roleStats);

        return [
            'datasets' => [
                [
                    'label' => 'Usuários por Role',
                    'data' => $series,
                    'backgroundColor' => 'rgba(99, 102, 241, 0.35)',
                    'borderColor' => 'rgba(99, 102, 241, 1)',
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

