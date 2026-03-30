<?php

namespace App\Filament\Resources\MovimentacaoEstoques\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MovimentacaoEstoqueInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('produto_id')
                    ->numeric(),
                TextEntry::make('tipo')
                    ->badge(),
                TextEntry::make('quantidade')
                    ->numeric(),
                TextEntry::make('observacao')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
