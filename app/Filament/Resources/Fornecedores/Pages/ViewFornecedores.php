<?php

namespace App\Filament\Resources\Fornecedores\Pages;

use App\Filament\Resources\Fornecedores\FornecedoresResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFornecedores extends ViewRecord
{
    protected static string $resource = FornecedoresResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
