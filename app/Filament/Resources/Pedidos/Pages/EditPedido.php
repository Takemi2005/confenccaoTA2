<?php

namespace App\Filament\Resources\Pedidos\Pages;

use App\Filament\Resources\Pedidos\PedidoResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPedido extends EditRecord
{
    protected static string $resource = PedidoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

   protected function mutateFormDataBeforeSave(array $data): array
{
    $total = 0;

    foreach ($data['itens'] ?? [] as $item) {
        $total += (float)($item['quantidade'] ?? 0) * (float)($item['preco_unitario'] ?? 0);
    }

    $data['valor_total'] = $total;

    return $data;
}
}
