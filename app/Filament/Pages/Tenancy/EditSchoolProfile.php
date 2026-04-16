<?php

namespace App\Filament\Pages\Tenancy;

use App\Rules\ValidRut;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditSchoolProfile extends EditTenantProfile
{
    public static function getLabel(): string { return 'Perfil del Colegio'; }

    public function form(Form $form): Form
    {
        $isNotAdmin = !auth()->user()->hasRole('super_admin');

        return $form
            ->schema([
                Section::make('Información Institucional')
                    ->schema([
                        TextInput::make('rut_institucion')->label('RUT')->required()->disabled($isNotAdmin),
                        TextInput::make('nombre')->label('Nombre')->required()->disabled($isNotAdmin),
                    ])->columns(2),

                Section::make('Gestión de Cursos')
                    ->schema([
                        Repeater::make('courses')
                            ->relationship()
                            ->label('Niveles y Secciones registrados')
                            ->schema([
                                Select::make('nombre')
                                    ->label('Nivel')
                                    ->options([
                                        '1° Básico' => '1° Básico', '2° Básico' => '2° Básico', '3° Básico' => '3° Básico',
                                        '4° Básico' => '4° Básico', '5° Básico' => '5° Básico', '6° Básico' => '6° Básico',
                                        '7° Básico' => '7° Básico', '8° Básico' => '8° Básico',
                                        '1° Medio' => '1° Medio', '2° Medio' => '2° Medio', '3° Medio' => '3° Medio', '4° Medio' => '4° Medio',
                                    ])->required()->columnSpan(3),
                                
                                TextInput::make('seccion')
                                    ->label('Letra')
                                    ->placeholder('A, B, C...')
                                    ->columnSpan(1),
                            ])
                            ->columns(4)
                            ->disabled($isNotAdmin)
                            ->addable(!$isNotAdmin)
                            ->deletable(!$isNotAdmin)
                            ->reorderable(!$isNotAdmin)
                    ])
            ]);
    }
}