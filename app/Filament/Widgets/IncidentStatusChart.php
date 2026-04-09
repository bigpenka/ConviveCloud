<?php

namespace App\Filament\Widgets;

use App\Models\Incident;
use Filament\Widgets\ChartWidget;

class IncidentStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Estado de Incidentes';
    protected static ?int $sort = 2;

    // 🔥 El Candado de Seguridad
    public static function canView(): bool
    {
        return auth()->user()->hasRole(['super_admin', 'Director', 'encargado_de_convivencia']);
    }

    protected function getData(): array
    {
        $abiertos = Incident::where('estado', 'Abierto')->count();
        $enProceso = Incident::where('estado', 'En Proceso')->count();
        $cerrados = Incident::where('estado', 'Cerrado')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Incidentes',
                    'data' => [$abiertos, $enProceso, $cerrados],
                    'backgroundColor' => [
                        '#ef4444', // Rojo (Abierto)
                        '#f59e0b', // Amarillo (En Proceso)
                        '#10b981', // Verde (Cerrado)
                    ],
                ],
            ],
            'labels' => ['Abiertos', 'En Proceso', 'Cerrados'],
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}