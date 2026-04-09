<?php

namespace App\Filament\Resources\Protocols;

use App\Filament\Resources\Protocols\Pages\ManageProtocols;
use App\Models\Protocol;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ProtocolResource extends Resource
{
    protected static ?string $model = Protocol::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Protocolos';
    protected static ?string $modelLabel = 'Protocolo';
    protected static ?string $pluralModelLabel = 'Protocolos';
    protected static ?string $recordTitleAttribute = 'nombre';

    protected static bool $isScopedToTenant = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del Protocolo')
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre del Protocolo')
                            ->required()
                            ->columnSpanFull(),

                        Select::make('gravedad')
                            ->label('Gravedad')
                            ->options([
                                'Leve' => 'Leve',
                                'Mediana' => 'Mediana',
                                'Grave' => 'Grave',
                                'Gravísima' => 'Gravísima',
                                'Alta' => 'Alta',
                            ])
                            ->required(),

                        TextInput::make('plazo_dias')
                            ->label('Plazo (Días)')
                            ->required()
                            ->numeric()
                            ->suffix('días'),
                    ])->columns(2),

                Section::make('Etapas de Actuación (Checklist Legal)')
                    ->schema([
                        Repeater::make('checklist')
                            ->label('Pasos')
                            ->schema([
                                TextInput::make('etapa')->required(),
                                TextInput::make('paso')->label('Descripción')->required(),
                                Toggle::make('obligatorio')->default(true),
                            ])
                            ->columns(3)
                            ->collapsible(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('gravedad')
    ->label('Gravedad')
    ->badge()
    ->color(fn (string $state): string => match (trim($state)) {
        'Gravísima' => 'danger',
        'Grave', 'Alta' => 'warning',
        'Mediana' => 'info',
        'Leve' => 'gray',
        default => 'gray',
    }),

                TextColumn::make('plazo_dias')
                    ->label('Plazo')
                    ->suffix(' días')
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProtocols::route('/'),
        ];
    }
}