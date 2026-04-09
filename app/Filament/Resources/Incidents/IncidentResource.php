<?php

namespace App\Filament\Resources\Incidents;

use App\Filament\Resources\Incidents\Pages\ManageIncidents;
use App\Models\Incident;
use App\Models\Protocol;
use App\Models\ProtocolStep;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Filament\Forms\Get;
use Filament\Forms\Set;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;
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
                            ->afterStateUpdated(fn (Set $set) => $set('checklist', []))
                            ->required(),

                        CheckboxList::make('checklist')
                            ->label('Etapas del Proceso')
                            ->live() // 🔥 CRUCIAL: Para que las secciones de abajo aparezcan al marcar
                            ->options(function (Get $get) {
                                $protocolId = $get('protocol_id');
                                if (!$protocolId) return [];
                                return ProtocolStep::where('protocol_id', $protocolId)->pluck('name', 'id');
                            })
                            ->visible(fn (Get $get) => $get('protocol_id'))
                            ->columns(2),

                        // 🏥 SECCIÓN: FORMULARIO SEGURO ESCOLAR
                        Section::make('Detalles de Seguro Escolar')
                            ->description('Información adicional para el formulario de seguro.')
                            // 🔍 ACTIVACIÓN: Se muestra cuando marcas el ID '3' (Comunicación a Apoderados)
                            ->visible(fn (Get $get) => in_array('3', $get('checklist') ?? []))
                            ->statePath('seguro_escolar_data')
                            ->schema([
                                Grid::make(2)->schema([
                                    Toggle::make('avisado_apoderado')->label('¿Se avisó al apoderado?')->onColor('success'),
                                    Toggle::make('traslado_centro')->label('¿Traslado a centro médico?')->onColor('danger'),
                                ]),
                                Select::make('centro_asistencial')
                                    ->label('Lugar de atención')
                                    ->options([
                                        'SAPU' => 'SAPU',
                                        'Hospital' => 'Hospital Regional',
                                        'Clinica' => 'Clínica Convenio',
                                        'Mutual' => 'Mutual de Seguridad',
                                    ]),
                                Textarea::make('descripcion_lesion')
                                    ->label('Descripción de la lesión / Primeros Auxilios')
                                    ->rows(2),
                            ])->columns(1),

                        // 🔍 SECCIÓN: INFORME DE INVESTIGACIÓN
                        Section::make('Informe de Investigación de Accidente')
                            ->description('Datos para el reporte de investigación interna.')
                            // 🔍 ACTIVACIÓN: Se muestra cuando marcas el ID '4' (Investigación y Descargos)
                            ->visible(fn (Get $get) => in_array('4', $get('checklist') ?? []))
                            ->statePath('informe_accidente_data')
                            ->schema([
                                Grid::make(2)->schema([
                                    Textarea::make('causas')->label('Causas del accidente'),
                                    Textarea::make('medidas')->label('Medidas preventivas tomadas'),
                                ]),
                                TextInput::make('testigos')->label('Testigos presentes'),
                            ]),

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
                TextColumn::make('fecha_incidente')->label('Fecha')->date('d-m-Y')->sortable(),
                TextColumn::make('student.nombres')->label('Alumno')->searchable(),
                TextColumn::make('protocol.nombre')->label('Protocolo'),
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
    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\Incidents\RelationManagers\FollowUpsRelationManager::class,
        ];
    }
}