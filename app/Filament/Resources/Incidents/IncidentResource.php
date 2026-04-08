<?php

namespace App\Filament\Resources\Incidents;

use App\Filament\Resources\Incidents\Pages\ManageIncidents;
use App\Models\Incident;
use BackedEnum;
use Filament\Resources\Resource;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-exclamation-triangle';

    protected static ?string $navigationLabel = 'Incidentes';
    protected static ?string $modelLabel = 'Incidente';
    protected static ?string $pluralModelLabel = 'Incidentes';

    public static function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema->components([
            \Filament\Forms\Components\Select::make('student_id')
                ->relationship('student', 'nombres')
                ->label('Alumno Involucrado')
                ->searchable()
                ->preload()
                ->required(),

            \Filament\Forms\Components\DatePicker::make('fecha_incidente')
                ->label('Fecha del Incidente')
                ->default(now())
                ->required(),

            \Filament\Forms\Components\Select::make('protocol_id')
                ->relationship('protocol', 'nombre')
                ->label('Protocolo Aplicado')
                ->live()
                ->required(),

            \Filament\Forms\Components\CheckboxList::make('checklist')
                ->label('Etapas del Proceso')
                ->options(function ($get) {
                    $protocolId = $get('protocol_id');
                    if (!$protocolId) return [];
                    return \App\Models\Incident::find($protocolId)?->protocol?->steps->pluck('name', 'id') ?? [];
                })
                ->visible(fn ($get) => $get('protocol_id'))
                ->live(),

            \Filament\Forms\Components\Textarea::make('descripcion')
                ->label('Descripción Detallada')
                ->required()
                ->columnSpanFull(),

            \Filament\Forms\Components\Select::make('estado')
                ->label('Estado')
                ->options([
                    'Abierto' => 'Abierto',
                    'En Proceso' => 'En Proceso',
                    'Cerrado' => 'Cerrado',
                ])
                ->default('Abierto')
                ->required(),
        ]);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('fecha_incidente')
                    ->label('Fecha')
                    ->date('d-m-Y'),
                
                \Filament\Tables\Columns\TextColumn::make('student.nombres')
                    ->label('Alumno'),

                // Botón PDF (Indestructible por ser HTML puro)
                \Filament\Tables\Columns\TextColumn::make('reporte')
                    ->label('Reporte')
                    ->html()
                    ->formatStateUsing(fn ($record) => "
                        <a href='/incidente/{$record->id}/print' target='_blank' 
                           style='background-color: #dc2626; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: bold; font-size: 11px;'>
                           PDF
                        </a>
                    "),

                \Filament\Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'Abierto' => 'danger',
                        'En Proceso' => 'warning',
                        'Cerrado' => 'success',
                        default => 'gray',
                    }),
            ])
            ->actions([
                // Rutas absolutas para evitar el error "Class not found"
                \Filament\Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Tables\Actions\BulkActionGroup::make([
                    \Filament\Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageIncidents::route('/'),
        ];
    }
}