<?php

namespace App\Filament\Resources\Incidents\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FollowUpsRelationManager extends RelationManager
{
    protected static string $relationship = 'followUps'; // Debe coincidir con el nombre en tu modelo Incident

    protected static ?string $title = 'Bitácora de Seguimiento';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('fecha')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('tipo_contacto')
                    ->label('Tipo de Intervención')
                    ->options([
                        'Entrevista' => 'Entrevista con Alumno',
                        'Llamada' => 'Llamada a Apoderado',
                        'Reunion' => 'Reunión Presencial',
                        'Derivacion' => 'Derivación a Especialista',
                    ])->required(),
                Forms\Components\Textarea::make('comentario')
                    ->label('Observaciones')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('fecha')
            ->columns([
                Tables\Columns\TextColumn::make('fecha')->date('d/m/Y')->sortable(),
                Tables\Columns\TextColumn::make('tipo_contacto')->badge()->color('info'),
                Tables\Columns\TextColumn::make('comentario')->limit(50),
                Tables\Columns\TextColumn::make('user.name')->label('Usuario'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Agregar Seguimiento'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
}