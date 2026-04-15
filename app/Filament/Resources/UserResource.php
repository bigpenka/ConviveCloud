<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password; // 🔥 IMPORTANTE: La clase para las contraseñas seguras

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Equipo Educativo';
    protected static ?string $modelLabel = 'Usuario';

    // 🔥 FIX CLAVE: Le decimos a Filament que la relación es "schools" (en plural)
    protected static ?string $tenantOwnershipRelationshipName = 'schools';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nombre Completo')
                            ->required()
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn ($livewire, $component) => $livewire->validateOnly($component->getStatePath()))
                            ->validationMessages([
                                'required' => 'Por favor, ingresa el nombre de la persona.',
                            ]),
                            
                        Forms\Components\TextInput::make('email')
    ->label('Correo Electrónico')
    ->email() 
    ->required()
    ->unique(ignoreRecord: true)
    ->live(debounce: 500)
    ->afterStateUpdated(fn ($livewire, $component) => $livewire->validateOnly($component->getStatePath()))
    // 🔥 EL FIX ABSOLUTO: Forzamos la validación manual para que no dependa de traducciones de Laravel
    ->rules([
        fn (): \Closure => function (string $attribute, $value, \Closure $fail) {
            if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $value)) {
                $fail('El formato no es válido. Debe tener un "@" y un dominio (ej: .cl o .com).');
            }
        },
    ])
    ->validationMessages([
        'required' => 'No olvides escribir el correo electrónico.',
        'unique' => 'Este correo ya está registrado en la plataforma.',
        'email' => 'Por favor, escribe un correo válido.',
    ]),
                        
                        Forms\Components\TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->revealable()
                            ->live(debounce: 500)
                            // 🔥 Lo mismo para que valide la seguridad de la clave al instante
                            ->afterStateUpdated(fn ($livewire, $component) => $livewire->validateOnly($component->getStatePath()))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->rule(Password::min(8)
                                ->letters()
                                ->mixedCase()
                                ->numbers()
                                ->symbols()
                            )
                            ->validationMessages([
                                'required' => 'La contraseña es obligatoria para usuarios nuevos.',
                            ])
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->helperText('Mín. 8 caracteres, incluir mayúscula, número y símbolo.'),
                        
                        Forms\Components\Select::make('roles')
                            ->label('Asignar Rol')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($livewire, $component) => $livewire->validateOnly($component->getStatePath()))
                            ->validationMessages([
                                'required' => 'Debes asignar al menos un rol al usuario.',
                            ]),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nombre')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('Correo'),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Rol')
                    ->badge()
                    ->color('warning'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}