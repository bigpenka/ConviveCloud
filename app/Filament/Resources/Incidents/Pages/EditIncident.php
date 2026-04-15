<?php

namespace App\Filament\Resources\Incidents\Pages;

use App\Filament\Resources\Incidents\IncidentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditIncident extends EditRecord
{
    protected static string $resource = IncidentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // 🔥 El Botón Inteligente para Cerrar Caso
            Actions\Action::make('cerrar_caso')
                ->label('Cerrar Caso')
                ->color('success')
                ->icon('heroicon-o-check-badge')
                ->requiresConfirmation()
                ->modalHeading('¿Estás seguro de cerrar este incidente?')
                ->modalDescription('Asegúrate de haber "Guardado" los últimos cambios del checklist antes de cerrar. Una vez cerrado, se registrará la fecha de término y el caso quedará archivado.')
                ->hidden(fn () => $this->record->estado === 'Cerrado')
                ->action(function () {
                    $incident = $this->record;
                    $checklist = $incident->checklist ?? [];
                    
                    $faltanEtapas = false;
                    foreach ($checklist as $step) {
                        if (empty($step['completado']) || $step['completado'] === false) {
                            $faltanEtapas = true;
                            break;
                        }
                    }

                    if ($faltanEtapas) {
                        Notification::make()
                            ->title('Acción denegada')
                            ->body('Faltan etapas del protocolo por completar. Revisa el checklist y asegúrate de guardar los cambios.')
                            ->danger()
                            ->send();
                        return;
                    }

                    $incident->update([
                        'estado' => 'Cerrado',
                        'fecha_cierre' => now(),
                    ]);

                    Notification::make()
                        ->title('Caso Cerrado Exitosamente')
                        ->success()
                        ->send();
                }),

            Actions\DeleteAction::make(),
        ];
    }

    // 🔥 Cambio automático a "En Proceso" al marcar la primera tarea
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($this->record->estado === 'Cerrado') {
            return $data;
        }

        $checklist = $data['checklist'] ?? [];
        $alMenosUnoCompletado = false;

        foreach ($checklist as $step) {
            if (!empty($step['completado']) && $step['completado'] === true) {
                $alMenosUnoCompletado = true;
                break;
            }
        }

        if ($this->record->estado === 'Abierto' && $alMenosUnoCompletado) {
            $data['estado'] = 'En Proceso';
            
            Notification::make()
                ->title('Estado Actualizado')
                ->body('El incidente ha pasado automáticamente a "En Proceso".')
                ->info()
                ->send();
        }

        return $data;
    }
}