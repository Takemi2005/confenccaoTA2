<?php

namespace App\Filament\Resources\InboxMessages\Pages;

use App\Filament\Resources\InboxMessages\InboxMessageResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords\Concerns\InteractsWithTable;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ListInboxMessages extends ListRecords
{
    protected static string $resource = InboxMessageResource::class;

    protected function getTableQuery(): Builder
    {
        // Opção 1 (aprovado): mostrar tudo
        return parent::getTableQuery();
    }
}

