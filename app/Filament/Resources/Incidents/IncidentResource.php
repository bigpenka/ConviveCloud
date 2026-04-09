<?php

namespace App\Filament\Resources\Incidents;

use App\Filament\Resources\Incidents\Pages;
use App\Models\Incident;
use App\Models\Protocol;
use App\Models\ProtocolStep;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Grid;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Get;
use Filament\Forms\Set;

class IncidentResource extends Resource
{
    protected static ?string $model = Incident::class;
    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';
    protected static ?string $navigationLabel = 'Incidentes';
    protected static ?string $modelLabel = 'Incidente';
    protected static ?string $pluralModelLabel = 'Incidentes';
    protected static ?string $slug = 'incidents'; 

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información General')
                    ->schema([
                        Select::make('student_id')
                            ->relationship('student', 'nombres')
                            ->label('Alumno')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('Opcional en caso de protocolos institucionales'),
                        
                        DatePicker::make('fecha_incidente')
                            ->label('Fecha del Hecho')
                            ->default(now())
                            ->required(),

                        Select::make('protocol_id')
                            ->relationship('protocol', 'nombre')
                            ->label('Protocolo Aplicado')
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (Set $set, $state) {
                                if (!$state) {
                                    $set('checklist', []);
                                    return;
                                }

                                $steps = ProtocolStep::where('protocol_id', $state)->get();
                                
                                $set('checklist', $steps->map(fn ($step) => [
                                    'nombre_etapa' => $step->name,
                                    'completado' => false,
                                    'archivo_evidencia' => null,
                                    'observacion' => '',
                                ])->toArray());
                            }),

                        Placeholder::make('estado_display')
                            ->label('Estado Actual')
                            ->content(fn (?Incident $record): string => $record?->estado ?? 'Abierto')
                            ->extraAttributes(['class' => 'font-bold text-indigo-600 uppercase']),
                    ])->columns(2),

                Section::make('Gestión de Protocolo y Evidencias')
                    ->description('Los pasos se cargan automáticamente según el protocolo seleccionado.')
                    ->schema([
                        Repeater::make('checklist')
                            ->label('Etapas Obligatorias')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('nombre_etapa')
                                        ->label('Etapa')
                                        ->disabled() 
                                        ->dehydrated() 
                                        ->columnSpan(1),
                                    
                                    Toggle::make('completado')
                                        ->label('¿Realizado?')
                                        ->onColor('success')
                                        ->columnSpan(1),

                                    FileUpload::make('archivo_evidencia')
                                        ->label('Documento (PDF/Acta)')
                                        ->directory('evidencias-incidentes')
                                        ->preserveFilenames()
                                        ->openable()
                                        ->downloadable()
                                        ->columnSpan(1),
                                ]),

                                Textarea::make('observacion')
                                    ->label('Observaciones de la etapa')
                                    ->rows(1)
                                    ->columnSpanFull(),
                            ])
                            ->addable(false)
                            ->reorderable(false)
                            ->itemLabel(fn (array $state): ?string => $state['nombre_etapa'] ?? 'Etapa')
                            ->collapsible()
                            
                    ]),

                Section::make('Narrativa de los Hechos')
                    ->schema([
                        Textarea::make('descripcion')
                            ->label('Descripción detallada')
                            ->required()
                            ->columnSpanFull(),
                    ])
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
                    ->default('Emergencia Institucional')
                    ->description(fn (Incident $record): string => $record->student ? "RUT: {$record->student->rut}" : "General"),

                TextColumn::make('protocol.nombre')
                    ->label('Protocolo')
                    ->limit(30),

                TextColumn::make('progreso')
                    ->label('Documentación')
                    ->getStateUsing(function (Incident $record): string {
                        $total = count($record->checklist ?? []);
                        if ($total === 0) return "Sin Etapas";
                        $conArchivo = collect($record->checklist)->filter(fn($item) => !empty($item['archivo_evidencia']))->count();
                        return "{$conArchivo} / {$total} Archivos";
                    })
                    ->badge()
                    ->color(fn ($state) => str_contains($state, '0 /') ? 'danger' : 'success'),

                TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match (strtolower($state)) {
                        'abierto' => 'danger',
                        'en proceso' => 'warning',
                        'cerrado' => 'success',
                        default => 'gray',
                    }),
            ])
            ->actions([
                ActionGroup::make([
                    EditAction::make(),
                    DeleteAction::make(),
                ])
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIncidents::route('/'),
            'edit' => Pages\EditIncident::route('/{record}/edit'),
        ];
    }
}