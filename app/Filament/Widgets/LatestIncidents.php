<?php

namespace App\Filament\Widgets;

use App\Models\Incident;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestIncidents extends BaseWidget
{
    protected static ?string $heading = 'Últimos Incidentes Reportados';
    protected int | string | array $columnSpan = 'full';
    protected static ?int $sort = 3;

    // 🔥 El Candado de Seguridad
    public static function canView(): bool
    {
        return auth()->user()->hasRole(['super_admin', 'Director', 'encargado_de_convivencia']);
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Incident::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('fecha_incidente')
                    ->label('Fecha')
                    ->date('d/m/Y'),
                Tables\Columns\TextColumn::make('student.nombres')
                    ->label('Alumno'),
                Tables\Columns\TextColumn::make('protocol.nombre')
                    ->label('Protocolo'),
                Tables\Columns\TextColumn::make('estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Abierto' => 'danger',
                        'En Proceso' => 'warning',
                        'Cerrado' => 'success',
                        default => 'gray',
                    }),
            ])
            ->paginated(false);
    }
}