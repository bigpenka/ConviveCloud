<?php

namespace App\Filament\Resources\Incidents;

use App\Filament\Resources\Incidents\Pages;
use App\Models\Incident;
use App\Models\Protocol;
use App\Models\ProtocolStep;
use App\Models\Course; // 🔥 Importamos el modelo Course
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
use Filament\Forms\Components\Fieldset;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

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
                // 🔒 Sección de Información General
                Section::make('Información General')
                    ->schema([
                        // 1️⃣ FILTRO DE CURSO
                        Select::make('course_id')
                            ->label('Filtrar por Curso')
                            ->placeholder('Seleccione un curso...')
                            ->options(fn () => Course::all()->mapWithKeys(function ($course) {
                                // Mostramos Nombre + Sección (ej: 1° Medio A)
                                return [$course->id => "{$course->nombre} " . ($course->seccion ?? '')];
                            }))
                            ->live() // 🔥 Hace que el formulario reaccione al cambio
                            ->searchable()
                            ->preload()
                            ->afterStateUpdated(fn (Set $set) => $set('student_id', null)) // Limpia el alumno si cambias el curso
                            ->disabled(fn (?Incident $record) => $record?->estado === 'Cerrado'),

                        // 2️⃣ SELECTOR DE ALUMNO (DINÁMICO)
                        Select::make('student_id')
                            ->label('Alumno')
                            ->relationship('student', 'nombres', function ($query, Get $get) {
                                $courseId = $get('course_id');
                                
                                // 🚀 Si hay un curso seleccionado, filtramos los alumnos
                                if ($courseId) {
                                    return $query->where('course_id', $courseId);
                                }
                                
                                // Si no hay curso, opcionalmente podrías devolver nada o todos
                                return $query; 
                            })
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nombres} {$record->apellidos}") // Nombre completo
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn (?Incident $record) => $record?->estado === 'Cerrado'),
                        
                        DatePicker::make('fecha_incidente')
                            ->label('Fecha del Hecho')
                            ->default(now())
                            ->required()
                            ->disabled(fn (?Incident $record) => $record?->estado === 'Cerrado'),

                        Select::make('protocol_id')
                            ->relationship('protocol', 'nombre')
                            ->label('Protocolo Aplicado')
                            ->live()
                            ->required()
                            ->disabled(fn (?Incident $record) => $record?->estado === 'Cerrado')
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
                                    'centro_medico' => null,
                                    'hora_accidente' => null,
                                    'tipo_lesion' => null,
                                    'asistencia_apoderado' => null,
                                    'nombre_entrevistado' => null,
                                    'relato_estudiante' => null,
                                    'acuerdos_entrevista' => null,
                                    'institucion_denuncia' => null,
                                    'n_parte' => null,
                                    'fecha_denuncia' => null,
                                    'detalle_denuncia' => null,
                                    'tipo_medida' => null,
                                    'fecha_inicio_medida' => null,
                                    'fecha_termino_medida' => null,
                                    'fundamento_medida' => null,
                                ])->toArray());
                            }),

                        Placeholder::make('estado_display')
                            ->label('Estado Actual')
                            ->content(fn (?Incident $record): string => $record?->estado ?? 'Abierto')
                            ->extraAttributes(['class' => 'font-bold text-indigo-600 uppercase']),
                    ])->columns(2),

                // 🔒 Gestión de Protocolo (Repeater)
                Section::make('Gestión de Protocolo y Evidencias')
                    ->description('Complete los formularios digitales. Si el caso está cerrado, no podrá modificar estos datos.')
                    ->schema([
                        Repeater::make('checklist')
                            ->label('Etapas Obligatorias')
                            ->disabled(fn (?Incident $record) => $record?->estado === 'Cerrado')
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
                                        ->label('Documento Externo (Opcional)')
                                        ->directory('evidencias-incidentes')
                                        ->columnSpan(1),
                                ]),

                                Fieldset::make('Detalles de Atención Médica')
                                    ->schema([
                                        TextInput::make('centro_medico')->label('Centro Asistencial'),
                                        TextInput::make('hora_accidente')->label('Hora')->type('time'),
                                        Textarea::make('tipo_lesion')->label('Detalle lesión')->columnSpanFull(),
                                    ])
                                    ->visible(fn (Get $get) => in_array($get('nombre_etapa'), ['Derivación a red de salud', 'Derivación de urgencia', 'Llenado Formulario Seguro Escolar'])),

                                Fieldset::make('Acta de Entrevista')
                                    ->schema([
                                        Select::make('asistencia_apoderado')->label('¿Asistió apoderado?')->options(['Sí' => 'Sí', 'No' => 'No']),
                                        TextInput::make('nombre_entrevistado')->label('Entrevistado'),
                                        Textarea::make('relato_estudiante')->label('Relato')->columnSpanFull(),
                                    ])
                                    ->visible(fn (Get $get) => str_contains(strtolower($get('nombre_etapa')), 'entrevista')),

                                Textarea::make('observacion')
                                    ->label('Observaciones Generales')
                                    ->rows(2)
                                    ->columnSpanFull()
                                    ->hidden(fn (Get $get) => !empty($get('centro_medico')) || !empty($get('nombre_entrevistado'))),
                            ])
                            ->addable(false)
                            ->deletable(false)
                            ->reorderable(false)
                            ->collapsible(),
                    ]),

                Section::make('Narrativa de los Hechos')
                    ->schema([
                        Textarea::make('descripcion')
                            ->label('Descripción detallada')
                            ->required()
                            ->disabled(fn (?Incident $record) => $record?->estado === 'Cerrado')
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fecha_incidente')->label('Fecha')->date('d-m-Y')->sortable(),
                TextColumn::make('student.nombres')->label('Alumno')->default('Institucional'),
                TextColumn::make('protocol.nombre')->label('Protocolo')->limit(30),
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
                    Action::make('descargar_pdf')
                        ->label('Descargar Acta')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function ($record) {
                            $pdf = Pdf::loadView('pdf.incidente', ['incidente' => $record]);
                            return response()->streamDownload(fn () => print($pdf->output()), "Acta-{$record->id}.pdf");
                        }),
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