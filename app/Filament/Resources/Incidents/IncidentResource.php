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
use Filament\Forms\Components\Fieldset; // 🔥 IMPORTANTE
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
                                    // 🔥 Inicializamos TODOS los posibles campos para evitar errores de llave no definida en JSON
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

                Section::make('Gestión de Protocolo y Evidencias')
                    ->description('Complete los formularios digitales. Solo suba documentos si provienen de fuentes externas (ej: certificado médico, denuncia externa).')
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
                                        ->label('Documento Externo (Opcional)')
                                        ->directory('evidencias-incidentes')
                                        ->preserveFilenames()
                                        ->openable()
                                        ->downloadable()
                                        ->columnSpan(1),
                                ]),

                                // 🔥 1. FORMULARIO DIGITAL: SALUD Y ACCIDENTES
                                Fieldset::make('Detalles de Atención Médica / Derivación')
                                    ->schema([
                                        TextInput::make('centro_medico')->label('Centro Asistencial'),
                                        TextInput::make('hora_accidente')->label('Hora exacta')->type('time'),
                                        Textarea::make('tipo_lesion')->label('Detalle de la lesión o estado')->columnSpanFull(),
                                    ])
                                    ->visible(fn (Get $get) => in_array($get('nombre_etapa'), [
                                        'Llenado Formulario Seguro Escolar', 
                                        'Derivación a red de salud', 
                                        'Derivación de urgencia', 
                                        'Derivación SENDA'
                                    ])),

                                // 🔥 2. FORMULARIO DIGITAL: ENTREVISTAS (Cubre Agresión Sexual, Bullying, etc)
                                Fieldset::make('Acta de Entrevista / Informe')
                                    ->schema([
                                        Select::make('asistencia_apoderado')->label('¿Asistió el apoderado?')
                                            ->options(['Sí' => 'Sí', 'No' => 'No', 'No aplica' => 'No aplica']),
                                        TextInput::make('nombre_entrevistado')->label('Nombre del entrevistado(s)'),
                                        Textarea::make('relato_estudiante')->label('Relato / Temas Tratados')->rows(3)->columnSpanFull(),
                                        Textarea::make('acuerdos_entrevista')->label('Acuerdos y Compromisos')->rows(2)->columnSpanFull(),
                                    ])
                                    ->visible(fn (Get $get) => in_array($get('nombre_etapa'), [
                                        'Entrevistas de investigación', 
                                        'Informe a apoderados', 
                                        'Entrevista con apoderado (Vigilancia)', 
                                        'Entrevista apoderado', 
                                        'Entrevista reservada', 
                                        'Entrevista acuerdo nombre social', 
                                        'Entrevistas conciliación'
                                    ])),

                                // 🔥 3. FORMULARIO DIGITAL: DENUNCIAS INSTITUCIONALES
                                Fieldset::make('Registro de Denuncia Externa')
                                    ->schema([
                                        Select::make('institucion_denuncia')->label('Institución Receptora')
                                            ->options(['Carabineros' => 'Carabineros (133)', 'PDI' => 'PDI (134)', 'Fiscalía' => 'Fiscalía', 'Tribunal de Familia' => 'Tribunal de Familia']),
                                        TextInput::make('n_parte')->label('N° de Parte / RUC'),
                                        DatePicker::make('fecha_denuncia')->label('Fecha de denuncia'),
                                        Textarea::make('detalle_denuncia')->label('Hechos denunciados')->columnSpanFull(),
                                    ])
                                    ->visible(fn (Get $get) => in_array($get('nombre_etapa'), [
                                        'Denuncia obligatoria (24 hrs)', 
                                        'Denuncia (si hay tráfico)', 
                                        'Llamado a Carabineros (133)', 
                                        'Denuncia Tribunal Familia', 
                                        'Denuncia penal'
                                    ])),

                                // 🔥 4. FORMULARIO DIGITAL: MEDIDAS
                                Fieldset::make('Registro de Medidas Aplicadas')
                                    ->schema([
                                        Select::make('tipo_medida')->label('Tipo de Medida')
                                            ->options(['Formativa' => 'Formativa / Pedagógica', 'Disciplinaria Leve' => 'Disciplinaria Leve', 'Suspensión' => 'Suspensión', 'Condicionalidad' => 'Condicionalidad', 'Cancelación Matrícula/Expulsión' => 'Expulsión']),
                                        DatePicker::make('fecha_inicio_medida')->label('Fecha de Inicio'),
                                        DatePicker::make('fecha_termino_medida')->label('Fecha de Término (Si aplica)'),
                                        Textarea::make('fundamento_medida')->label('Fundamento de la medida según RICE')->columnSpanFull(),
                                    ])
                                    ->visible(fn (Get $get) => in_array($get('nombre_etapa'), [
                                        'Aplicación de medidas formativas', 
                                        'Medidas de resguardo inmediatas', 
                                        'Medidas de resguardo escolar', 
                                        'Medida disciplinaria inmediata', 
                                        'Cese de discriminación',
                                        'Retiro de objeto por autoridad'
                                    ])),

                                // CAJA DE OBSERVACIONES NORMAL
                                Textarea::make('observacion')
                                    ->label('Observaciones de la etapa (Uso General)')
                                    ->rows(2)
                                    ->columnSpanFull()
                                    // Se oculta si la etapa cayó en alguno de los Fieldsets de arriba
                                    ->hidden(fn (Get $get) => in_array($get('nombre_etapa'), [
                                        'Llenado Formulario Seguro Escolar', 'Derivación a red de salud', 'Derivación de urgencia', 'Derivación SENDA',
                                        'Entrevistas de investigación', 'Informe a apoderados', 'Entrevista con apoderado (Vigilancia)', 'Entrevista apoderado', 'Entrevista reservada', 'Entrevista acuerdo nombre social', 'Entrevistas conciliación',
                                        'Denuncia obligatoria (24 hrs)', 'Denuncia (si hay tráfico)', 'Llamado a Carabineros (133)', 'Denuncia Tribunal Familia', 'Denuncia penal',
                                        'Aplicación de medidas formativas', 'Medidas de resguardo inmediatas', 'Medidas de resguardo escolar', 'Medida disciplinaria inmediata', 'Cese de discriminación', 'Retiro de objeto por autoridad'
                                    ])),
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
                    
                    Action::make('descargar_pdf')
                        ->label('Descargar Acta (PDF)')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('danger')
                        ->action(function ($record) {
                            $pdf = Pdf::loadView('pdf.incidente', [
                                'incidente' => $record
                            ]);
                            
                            return response()->streamDownload(
                                fn () => print($pdf->output()), 
                                "Acta-Incidente-{$record->id}.pdf"
                            );
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