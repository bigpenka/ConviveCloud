<?php

namespace App\Filament\Resources\Incidents;

use App\Filament\Resources\Incidents\Pages\ManageIncidents;
use App\Models\Incident;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\Action;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;
    
    // CORRECCIÓN: En Filament 3 solo se usa ?string
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    
    protected static ?string $navigationLabel = 'Incidentes';
    protected static ?string $modelLabel = 'Incidente';
    protected static ?string $pluralModelLabel = 'Incidentes';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Información del Incidente')
                ->schema([
                    Select::make('student_id')
                        ->relationship('student', 'nombres')
                        ->label('Alumno')
                        ->searchable()
                        ->preload()
                        ->required(),
                    
                    DatePicker::make('fecha_incidente')
                        ->label('Fecha')
                        ->default(now())
                        ->required(),

                    Select::make('protocol_id')
                        ->relationship('protocol', 'nombre')
                        ->label('Protocolo Aplicado')
                        ->live()
                        // 🔥 ESTO ES LO NUEVO: Limpia el checklist si cambias de protocolo
                        ->afterStateUpdated(fn (\Filament\Forms\Set $set) => $set('checklist', []))
                        ->required(),

                    CheckboxList::make('checklist')
                        ->label('Etapas del Proceso')
                        // Agregamos \Filament\Forms\Get para evitar errores de tipado
                        ->options(function (\Filament\Forms\Get $get) {
                            $protocolId = $get('protocol_id');
                            if (!$protocolId) return [];
                            return \App\Models\ProtocolStep::where('protocol_id', $protocolId)->pluck('name', 'id');
                        })
                        ->visible(fn (\Filament\Forms\Get $get) => $get('protocol_id'))
                        ->columns(2),

                    Textarea::make('descripcion')
                        ->label('Descripción de los hechos')
                        ->required()
                        ->columnSpanFull(),

                    Select::make('estado')
                        ->options([
                            'Abierto' => 'Abierto',
                            'En Proceso' => 'En Proceso',
                            'Cerrado' => 'Cerrado',
                        ])
                        ->default('Abierto')
                        ->required(),
                ])->columns(2)
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha_incidente')
                    ->label('Fecha')
                    ->date('d-m-Y')
                    ->sortable(),
                
                TextColumn::make('student.nombres')
                    ->label('Alumno')
                    ->searchable(),

                TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Abierto' => 'danger',
                        'En Proceso' => 'warning',
                        'Cerrado' => 'success',
                        default => 'gray',
                    }),
            ])
            ->actions([
                // Botón PDF funcional para Filament 3
                Action::make('pdf')
                    ->label('Reporte')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('danger')
                    ->url(fn (Incident $record) => url('/incidente/'.$record->id.'/print'))
                    ->openUrlInNewTab(),

                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageIncidents::route('/'),
        ];
    }
}