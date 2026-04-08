<?php

namespace App\Filament\Resources\Protocols;

use App\Filament\Resources\Protocols\Pages\ManageProtocols;
use App\Models\Protocol;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema; // Usando Schema para evitar incompatibilidades
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProtocolResource extends Resource
{
    protected static ?string $model = Protocol::class;

    // EL FIX DEL ERROR: Tipado estricto exigido por Filament
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Protocolos';
    protected static ?string $modelLabel = 'Protocolo';
    protected static ?string $pluralModelLabel = 'Protocolos';

    protected static ?string $recordTitleAttribute = 'nombre';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre del Protocolo')
                    ->required()
                    ->placeholder('Ej: Maltrato entre alumnos'),

                Select::make('gravedad')
                    ->label('Gravedad')
                    ->options([
                        'Leve' => 'Leve',
                        'Mediana' => 'Mediana',
                        'Grave' => 'Grave',
                        'Gravísima' => 'Gravísima',
                    ])
                    ->required(),

                TextInput::make('plazo_dias')
                    ->label('Plazo (Días)')
                    ->required()
                    ->numeric()
                    ->suffix('días'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre')
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('gravedad')
                    ->label('Gravedad')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Leve' => 'gray',
                        'Mediana' => 'info',
                        'Grave' => 'warning',
                        'Gravísima' => 'danger',
                        default => 'gray',
                    })
                    ->searchable(),

                TextColumn::make('plazo_dias')
                    ->label('Días de Plazo')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageProtocols::route('/'),
        ];
    }
}