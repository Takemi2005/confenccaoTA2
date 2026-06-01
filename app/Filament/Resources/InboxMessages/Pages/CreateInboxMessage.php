<?php

namespace App\Filament\Resources\InboxMessages\Pages;

use App\Filament\Resources\InboxMessages\InboxMessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInboxMessage extends CreateRecord
{
    protected static string $resource = InboxMessageResource::class;
}

