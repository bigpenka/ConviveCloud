<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Incident;
use App\Models\Protocol;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Alumnos', Student::count())
                ->description('Estudiantes registrados')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),
            Stat::make('Incidentes Abiertos', Incident::where('estado', 'Abierto')->count())
                ->description('Casos que requieren atención')
                ->descriptionIcon('heroicon-m-exclamation-circle')
                ->color('danger'),
            Stat::make('Protocolos Activos', Protocol::count())
                ->description('Normativas vigentes')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),
        ];
    }
}