<?php

namespace App\Filament\Resources\Incidents\Pages;

use App\Filament\Resources\Incidents\IncidentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncidents extends ListRecords
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                // 🔥 La magia: Forzamos a que el incidente nazca como "Abierto" desde el modal
                ->mutateFormDataUsing(function (array $data): array {
                    $data['estado'] = 'Abierto';
                    return $data;
                }),
        ];
    }
}