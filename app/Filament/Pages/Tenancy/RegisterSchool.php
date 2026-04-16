<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\School;
use App\Rules\ValidRut;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class RegisterSchool extends RegisterTenant
{
    public static function getLabel(): string { return 'Registrar Nuevo Colegio'; }

    public static function canView(): bool { return auth()->user()->hasRole('super_admin'); }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del Establecimiento')
                    ->schema([
                        TextInput::make('rut_institucion')->label('RUT')->required()->rule(new ValidRut())->live(onBlur: true),
                        TextInput::make('nombre')->label('Nombre')->required(),
                    ])->columns(2),

                Section::make('Configuración de Cursos')
                    ->schema([
                        Repeater::make('cursos_iniciales')
                            ->label('Lista de Niveles y Secciones')
                            ->schema([ // 🔥 Quitamos simple() para usar un esquema de 2 columnas
                                Select::make('nombre')
                                    ->label('Nivel')
                                    ->options([
                                        'Enseñanza Básica' => [
                                            '1° Básico' => '1° Básico', '2° Básico' => '2° Básico', '3° Básico' => '3° Básico',
                                            '4° Básico' => '4° Básico', '5° Básico' => '5° Básico', '6° Básico' => '6° Básico',
                                            '7° Básico' => '7° Básico', '8° Básico' => '8° Básico',
                                        ],
                                        'Enseñanza Media' => [
                                            '1° Medio' => '1° Medio', '2° Medio' => '2° Medio', '3° Medio' => '3° Medio', '4° Medio' => '4° Medio',
                                        ],
                                    ])->required()->columnSpan(3),
                                
                                TextInput::make('seccion')
                                    ->label('Letra/Sección')
                                    ->placeholder('Ej: A')
                                    ->maxLength(10)
                                    ->columnSpan(1), // Más pequeño
                            ])
                            ->columns(4) // El total de la fila
                            ->addActionLabel('+ Agregar curso')
                    ])
            ]);
    }

    protected function handleRegistration(array $data): School
    {
        $cursos = $data['cursos_iniciales'] ?? [];
        unset($data['cursos_iniciales']);

        $school = School::create($data);

        foreach ($cursos as $item) {
            $school->courses()->create([
                'nombre' => $item['nombre'],
                'seccion' => $item['seccion'] ?? null,
            ]);
        }

        auth()->user()->schools()->attach($school);
        return $school;
    }
}