<?php

namespace App\Filament\Resources\Fornecedores\Pages;

use App\Filament\Resources\Fornecedores\FornecedoresResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditFornecedores extends EditRecord
{
    protected static string $resource = FornecedoresResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
