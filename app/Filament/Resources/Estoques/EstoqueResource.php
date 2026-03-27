<?php

namespace App\Filament\Resources\Estoques;

use App\Filament\Resources\Estoques\Pages\CreateEstoque;
use App\Filament\Resources\Estoques\Pages\EditEstoque;
use App\Filament\Resources\Estoques\Pages\ListEstoques;
use App\Models\Estoque;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\Estoques\Tables\EstoquesTable;
use backedEnum;
use App\Filament\Resources\Estoques\Pages\ViewEstoque;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Repeater;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;

class EstoqueResource extends Resource
{
    protected static ?string $model = Estoque::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Movimentações de Estoque';
public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
            Select::make('produto_id')
                ->relationship('produto', 'nome')
                ->required()
                ->preload()
                ->searchable()
                ->label('Produto'),
            Select::make('tipo')
                ->options([
                'entrada' => 'Entrada',
                'saida' => 'Saída',
                ])
                ->required()
                ->label('Transação'),
            TextInput::make('quantidade')
                ->required()
                ->numeric()
                ->minValue(0)
                ->label('Quantidade'),
            Textarea::make('observacao')
                ->label('Observações')
                ->rows(3)
                ->maxLength(255),
            Repeater::make('itens')
                ->label('Itens')
                ->schema([
                Select::make('produto_id')
                    ->relationship('produto', 'nome')
                    ->required()
                    ->preload()
                    ->searchable()
                    ->label('Produto'),
                TextInput::make('quantidade')
                    ->label('Quantidade')
                    ->numeric()
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Get $get, Set $set) =>
                    self::calcularTotal($get, $set))
                    ->columnSpan(1),
                ]),
            ]);
        }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('produto.nome')->searchable()->label('Produto'),
            TextColumn::make('tipo')->badge(),
            TextColumn::make('quantidade')->numeric(),
            TextColumn::make('observacao')->limit(50),
        ]);
    }


    public static function getPages(): array
    {
        return [
            'index'  => ListEstoques::route('/'),
            'create' => CreateEstoque::route('/create'),
            'edit'   => EditEstoque::route('/{record}/edit'),
        ];
    }
    
}