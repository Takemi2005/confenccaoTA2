<?php

namespace App\Filament\Resources\InboxMessages\Pages;

use App\Filament\Resources\InboxMessages\InboxMessageResource;
use Filament\Resources\Pages\EditRecord;

class EditInboxMessage extends EditRecord
{
    protected static string $resource = InboxMessageResource::class;
}

