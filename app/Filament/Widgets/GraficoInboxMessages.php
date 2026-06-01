<?php

namespace App\Filament\Widgets;

use App\Models\InboxMessage;
use Filament\Widgets\ChartWidget;

class GraficoInboxMessages extends ChartWidget
{
    protected static ?int $sort = 10;

    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $lidas = InboxMessage::query()->whereNotNull('read_at')->count();
        $naoLidas = InboxMessage::query()->whereNull('read_at')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Mensagens da Inbox',
                    'data' => [(int) $lidas, (int) $naoLidas],
                    'backgroundColor' => ['rgba(59, 130, 246, 0.35)', 'rgba(245, 158, 11, 0.35)'],
                    'borderColor' => ['rgba(59, 130, 246, 1)', 'rgba(245, 158, 11, 1)'],
                    'borderWidth' => 2,
                ],
            ],
            'labels' => ['Lidas', 'Não lidas'],
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

