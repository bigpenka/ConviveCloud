<?php

namespace App\Filament\Resources\Students;

use App\Filament\Resources\Students\Pages\ManageStudents;
use App\Models\Student;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema; // EL FIX: Usamos Schema
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    // EL FIX: Tipado estricto para tu versión
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-users';

    // --- TRADUCCIÓN A ESPAÑOL ---
    protected static ?string $navigationLabel = 'Alumnos';
    protected static ?string $modelLabel = 'Alumno';
    protected static ?string $pluralModelLabel = 'Alumnos';

    protected static ?string $recordTitleAttribute = 'nombres';

    // EL FIX: Cambiamos Form por Schema y schema() por components()
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ->recordTitleAttribute('nombres')
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
                    ->dateTime()
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