<?php

namespace App\Filament\Resources\Estoques\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EstoqueInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('produto.id')
                    ->label('Produto'),
                TextEntry::make('quantidade')
                    ->numeric(),
                TextEntry::make('tipo')
                    ->badge(),
                TextEntry::make('observacao')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
