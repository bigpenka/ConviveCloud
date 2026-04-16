<?php

namespace App\Filament\Resources\Students;

use App\Filament\Resources\Students\Pages\ManageStudents;
use App\Models\Student;
use App\Rules\ValidRut;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Alumnos';
    protected static ?string $modelLabel = 'Alumno';
    protected static ?string $pluralModelLabel = 'Alumnos';
    protected static ?string $recordTitleAttribute = 'nombres';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 👤 SECCIÓN 1: DATOS DEL ALUMNO
                Section::make('Datos del Estudiante')
                    ->schema([
                        TextInput::make('rut')
                            ->label('RUT')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->rule(new ValidRut())
                            // 🚀 Validación en tiempo real
                            ->live(onBlur: true) 
                            ->afterStateUpdated(function (\Filament\Forms\Contracts\HasForms $livewire, \Filament\Forms\Components\Component $component) {
                                $livewire->validateOnly($component->getStatePath());
                            })
                            ->placeholder('12.345.678-9')
                            ->maxLength(12),
                            
                        TextInput::make('nombres')
                            ->label('Nombres')
                            ->required(),
                            
                        TextInput::make('apellidos')
                            ->label('Apellidos')
                            ->required(),
                            
                        // 🚀 Relación de Curso vinculada al Tenant
                        Select::make('course_id') 
                            ->relationship('course', 'nombre')
                            ->label('Curso')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('nombre')
                                    ->label('Nombre del Curso')
                                    ->required()
                                    ->placeholder('Ej: 1° Medio A'),
                            ]),
                    ])->columns(2),

                // 👨‍👩‍👧 SECCIÓN 2: DATOS DEL APODERADO
                Section::make('Contacto del Apoderado')
                    ->description('Estos datos se usarán para enviar actas y alertas automáticas.')
                    ->schema([
                        TextInput::make('nombre_apoderado')
                            ->label('Nombre Completo')
                            ->maxLength(255),
                            
                        Select::make('parentesco_apoderado')
                            ->label('Parentesco')
                            ->options([
                                'Padre' => 'Padre',
                                'Madre' => 'Madre',
                                'Tutor Legal' => 'Tutor Legal',
                                'Otro' => 'Otro',
                            ]),
                            
                        TextInput::make('email_apoderado')
                            ->label('Correo Electrónico')
                            ->email()
                            ->placeholder('ejemplo@correo.com')
                            ->maxLength(255),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('rut')
                    ->label('RUT')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nombres')
                    ->label('Nombres')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('apellidos')
                    ->label('Apellidos')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('course.nombre') 
                    ->label('Curso')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Fecha Registro')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
            'index' => ManageStudents::route('/'),
        ];
    }
}