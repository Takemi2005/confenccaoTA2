<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole;
use App\Filament\Resources\Roles\Pages\ListRoles;
use App\Filament\Resources\Roles\Pages\ViewRole;
use App\Filament\Resources\Roles\Schemas\RoleForm;
use App\Filament\Resources\Roles\Schemas\RoleInfolist;
use App\Filament\Resources\Roles\Tables\RolesTable;
//use App\Models\Role;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Spatie\Permission\Models\Role;
use Filament\Tables\Columns\TextColumn;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

   //  public static function canAccess(): bool
  //   {
 //      return auth()->user()?->hasRole('Admin') ?? false;
// }


public static function getNavigationGroup(): ?string
{
    return 'Administração';
}
public static function getNavigationLabel(): string
{
    return 'Cargos';
}


          public static function canAccess(): bool
          {
            return auth()->user()?->hasRole('acessar_clientes') ?? false;
            // return auth()->user()?->can('acessar_clientes') ?? false;
            // return auth()->user()?->can('acessar_pedidos') ?? false;
            // return auth()->user()?->can('acessar_produtos') ?? false;
          }


    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Cargos e Funções';

    public static function form(Schema $schema): Schema
    {
        //return RoleForm::configure($schema);

        return $schema
            ->schema([
                Select::make('permissions')
                    ->label('Permissões')
                    ->multiple()
                    ->relationship('permissions', 'name')
                    ->preload()
                    ->columnSpanFull(),


                TextInput::make('name')
                    ->label('Nome da regra')
                    ->required(),


            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RoleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        
        return $table
         ->columns([
                TextColumn::make('Permissions.name')
                    ->label('Nome do Regra')
                    ->searchable()
                    ->sortable(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view' => ViewRole::route('/{record}'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}