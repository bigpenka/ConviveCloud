<?php

namespace App\Filament\Resources\Incidents\Pages;

use App\Filament\Resources\Incidents\IncidentResource;
use App\Models\User;
use Filament\Actions;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListIncidents extends ListRecords
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $data['estado']    = 'Abierto';
                    $data['school_id'] = Filament::getTenant()->id;
                    return $data;
                })
                ->after(function ($record) {
                    $nombreAlumno    = $record->student?->nombres ?? 'Emergencia Institucional';
                    $nombreProtocolo = $record->protocol?->nombre  ?? 'Sin protocolo';

                    $usuarios = User::role(['super_admin', 'Director', 'Encargado de Convivencia Escolar'])
                        ->whereHas('schools', fn ($q) =>
                            $q->where('schools.id', $record->school_id)
                        )
                        ->get();

                    Notification::make()
                        ->title('🚨 Nuevo Incidente Reportado')
                        ->body("Alumno: {$nombreAlumno} — {$nombreProtocolo}")
                        ->danger()
                        ->sendToDatabase($usuarios);
                }),
        ];
    }
}