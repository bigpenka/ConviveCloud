<?php

namespace App\Filament\Resources\Students;

use App\Filament\Resources\Students\Pages\ManageStudents;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
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

    // EL FIX: Tipado simple para Filament 3
    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Alumnos';
    protected static ?string $modelLabel = 'Alumno';
    protected static ?string $pluralModelLabel = 'Alumnos';
    protected static ?string $recordTitleAttribute = 'nombres';

    // Cambiamos Schema por Form y components() por schema()
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('rut')
                    ->label('RUT')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('nombres')
                    ->label('Nombres')
                    ->required(),
                TextInput::make('apellidos')
                    ->label('Apellidos')
                    ->required(),
                TextInput::make('curso')
                    ->label('Curso')
                    ->required(),
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
                TextColumn::make('curso')
                    ->label('Curso')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Fecha Registro')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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