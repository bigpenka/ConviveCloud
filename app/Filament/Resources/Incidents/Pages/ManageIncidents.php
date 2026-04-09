<?php

namespace App\Filament\Resources\Incidents\Pages;

use App\Filament\Resources\Incidents\IncidentResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageIncidents extends ManageRecords
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->after(function ($record) {
                    // Buscamos a los "jefes" para avisarles
                    $usuariosAnotificar = User::role(['super_admin', 'encargado_de_convivencia'])->get();
                    
                    Notification::make()
                        ->title('🚨 Nuevo Incidente Reportado')
                        ->body("El alumno {$record->student->nombres} tiene un nuevo reporte de {$record->protocol->nombre}.")
                        ->icon('heroicon-o-exclamation-triangle')
                        ->color('danger')
                        ->danger() // Lo hace resaltar más
                        ->sendToDatabase($usuariosAnotificar);
                }),
        ];
    }
}