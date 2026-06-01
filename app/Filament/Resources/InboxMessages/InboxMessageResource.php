<?php

namespace App\Filament\Resources\InboxMessages;

use App\Filament\Resources\InboxMessages\Pages\CreateInboxMessage;
use App\Filament\Resources\InboxMessages\Pages\EditInboxMessage;
use App\Filament\Resources\InboxMessages\Pages\ListInboxMessages;
use App\Filament\Resources\InboxMessages\Pages\ViewInboxMessage;
use App\Models\InboxMessage;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use UnitEnum;

class InboxMessageResource extends Resource
{
    protected static ?string $model = InboxMessage::class;

    protected static string|UnitEnum|null $navigationGroup = 'Comunicação';
    protected static ?int $navigationSort = 1;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedInbox;

    protected static ?string $recordTitleAttribute = 'subject';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('Mensagem')
                    ->schema([
                        Grid::make()->schema([
                            Select::make('sender_id')
                                ->label('Remetente')
                                ->relationship('sender', 'name')
                                ->required()
                                ->preload()
                                ->searchable(),

                            Select::make('recipient_id')
                                ->label('Destinatário')
                                ->relationship('recipient', 'name')
                                ->required()
                                ->preload()
                                ->searchable(),
                        ])->columns(2),

                        TextInput::make('subject')
                            ->label('Assunto')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('body')
                            ->label('Corpo')
                            ->required(),

                        DateTimePicker::make('read_at')
                            ->label('Lida em')
                            ->nullable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sender.name')
                    ->label('Remetente')
                    ->searchable(),

                TextColumn::make('recipient.name')
                    ->label('Destinatário')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),

                BadgeColumn::make('read_at')
                    ->label('Status')
                    ->getStateUsing(fn ($record) => $record->read_at ? 'Lida' : 'Não lida')
                    ->colors([
                        'success' => 'Lida',
                        'warning' => 'Não lida',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInboxMessages::route('/'),
            'create' => CreateInboxMessage::route('/create'),
            'view' => ViewInboxMessage::route('/{record}'),
            'edit' => EditInboxMessage::route('/{record}/edit'),
        ];
    }
}

