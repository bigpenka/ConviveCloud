<?php

namespace App\Filament\Widgets;

use App\Models\Incident;
use App\Models\Student;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    // 🔥 El Candado de Seguridad
    public static function canView(): bool
    {
        return auth()->user()->hasRole(['super_admin', 'Director', 'encargado_de_convivencia']);
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Total Alumnos', Student::count())
                ->description('Matrícula actual')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Incidentes Activos', Incident::whereIn('estado', ['Abierto', 'En Proceso'])->count())
                ->description('Casos requiriendo atención')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),

            Stat::make('Casos Cerrados', Incident::where('estado', 'Cerrado')->count())
                ->description('Incidentes resueltos históricamente')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('primary'),
        ];
    }
}