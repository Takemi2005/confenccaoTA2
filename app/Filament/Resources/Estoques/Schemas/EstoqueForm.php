<?php

namespace App\Filament\Resources\Estoques\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EstoqueForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('produto_id')
                    ->relationship('produto', 'id')
                    ->required(),
                TextInput::make('quantidade')
                    ->required()
                    ->numeric(),
                Select::make('tipo')
                    ->options(['entrada' => 'Entrada', 'saida' => 'Saida'])
                    ->required(),
                Textarea::make('observacao')
                    ->columnSpanFull(),
            ]);
    }
}
