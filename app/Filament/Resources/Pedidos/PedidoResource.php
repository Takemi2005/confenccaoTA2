<?php

namespace App\Filament\Resources\Pedidos;

use App\Filament\Resources\Pedidos\Pages\CreatePedido;
use App\Filament\Resources\Pedidos\Pages\EditPedido;
use App\Filament\Resources\Pedidos\Pages\ListPedidos;
use App\Filament\Resources\Pedidos\Pages\ViewPedido;
use App\Filament\Resources\Pedidos\Schemas\PedidoInfolist;
use App\Filament\Resources\Pedidos\Tables\PedidosTable;
use App\Models\Pedido;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;      // ❌ estava em Filament\Forms\Columns
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;                      

class PedidoResource extends Resource
{
    protected static ?string $model = Pedido::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Pedido';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Select::make('cliente_id')          // ❌ estava com 's' minúsculo
                    ->relationship('cliente', 'nome')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Selecionar o Cliente'),

                Select::make('status')              // ❌ estava com 's' minúsculo
                    ->options([
                        'pendente'    => 'Pendente',
                        'em_producao' => 'Em Produção',
                        'finalizado'  => 'Finalizado',
                    ])
                    ->default('pendente')
                    ->required(),

                TextInput::make('valor_total')
                    ->numeric()
                    ->prefix('R$')
                    ->readOnly(),                   // calculado automaticamente

                Repeater::make('itens')
                    ->relationship('itens')
                    ->schema([
                        Select::make('produto_id')
                            ->relationship('produto', 'nome')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Produto')
                            ->columnSpan(2),        // ❌ tinha vírgula solta antes

                        TextInput::make('quantidade')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->live()                // ❌ estava fora do lugar
                            ->afterStateUpdated(fn (Get $get, Set $set) =>
                                self::calcularTotal($get, $set))
                            ->columnSpan(1),

                        TextInput::make('preco_unitario')
                            ->numeric()
                            ->prefix('R$')
                            ->required()
                            ->live()                // ❌ estava fora do lugar
                            ->afterStateUpdated(fn (Get $get, Set $set) =>
                                self::calcularTotal($get, $set))
                            ->columnSpan(1),
                    ])
                    ->columns(2)                    // ❌ estava com ; solto fora da cadeia
                    ->columnSpanFull()              // ❌ estava com ; solto fora da cadeia
                    ->label('Itens do Pedido'),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PedidoInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PedidosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListPedidos::route('/'),
            'create' => CreatePedido::route('/create'),
            'view'   => ViewPedido::route('/{record}'),
            'edit'   => EditPedido::route('/{record}/edit'),
        ];
    }

    // ❌ faltava ":" antes de void, e $set estava dentro do foreach
    public static function calcularTotal(Get $get, Set $set): void
    {
        $itens = $get('itens') ?? [];
        $total = 0;

        foreach ($itens as $item) {
            $quantidade = (float) ($item['quantidade']     ?? 0);
            $preco      = (float) ($item['preco_unitario'] ?? 0);
            $total += $quantidade * $preco;
        }

        // ❌ number_format estava com parâmetros errados: 2.'.' deve ser 2, '.', ''
        $set('valor_total', number_format($total, 2, '.', ''));
    }
}
