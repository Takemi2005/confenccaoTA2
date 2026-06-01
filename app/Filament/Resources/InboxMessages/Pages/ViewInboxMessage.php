<?php

namespace App\Filament\Resources\InboxMessages\Pages;

use App\Filament\Resources\InboxMessages\InboxMessageResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ViewInboxMessage extends ViewRecord
{
    protected static string $resource = InboxMessageResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return $data;
    }

    public function mount($record): void
    {
        parent::mount($record);

        if ($record && empty($record->read_at)) {
            $record->forceFill(['read_at' => now()])->save();
        }
    }
}

