<?php

namespace App\Filament\Resources\Pedidos\Pages;

use App\Filament\Resources\Pedidos\PedidoResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePedido extends CreateRecord
{
    protected static string $resource = PedidoResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $total = 0;

        foreach ($data['itens'] ?? [] as $item) {
            $total += (float)($item['quantidade'] ?? 0) * (float)($item['preco_unitario'] ?? 0);
        }

        $data['valor_total'] = $total;

        return $data;
    }
}