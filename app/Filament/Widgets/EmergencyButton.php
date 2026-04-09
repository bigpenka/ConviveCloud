<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Incidents\IncidentResource;
use App\Models\EmergencyAlert;
use App\Models\Incident;
use App\Models\Protocol;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class EmergencyButton extends Widget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    protected static string $view = 'filament.widgets.emergency-button';

    protected int | string | array $columnSpan = 'full';

    public function triggerAlertAction(): Action
    {
        return Action::make('triggerAlert')
            ->label('ACTIVAR BOTÓN DE PÁNICO')
            ->icon('heroicon-o-bell-alert')
            ->color('danger')
            ->size('xl')
            ->requiresConfirmation()
            ->modalHeading('🚨 ¿ACTIVAR PROTOCOLO DE CRISIS?')
            ->modalDescription('Esta acción notificará a todo el personal y creará un registro de incidente de alta prioridad para Amenaza Armada.')
            ->modalSubmitActionLabel('SÍ, ACTIVAR ALERTA')
            ->action(function () {
                // 1. Registro en BD (Auditoría de quién apretó el botón)
                EmergencyAlert::create(['user_id' => auth()->id()]);

                // 2. Buscar el Protocolo legal (Circular 482)
                // Buscamos uno que se llame "Amenaza" o "Tiroteo"
                $protocol = Protocol::where('nombre', 'like', '%Amenaza%')
                    ->orWhere('nombre', 'like', '%Armada%')
                    ->first();

                if (!$protocol) {
                    Notification::make()
                        ->warning()
                        ->title('Protocolo no encontrado')
                        ->body('Debes crear un protocolo con la palabra "Amenaza" para automatizar la creación del incidente.')
                        ->send();
                    return;
                }

                // 3. Crear el Incidente automáticamente
                $incident = Incident::create([
                    'student_id' => null, // Es un incidente general del establecimiento
                    'protocol_id' => $protocol->id,
                    'fecha_incidente' => now(),
                    'descripcion' => 'ALERTA DISPARADA POR BOTÓN DE PÁNICO: Situación de riesgo inminente detectada.',
                    'estado' => 'En Proceso',
                    'checklist' => [], 
                ]);

                // 4. Notificar a todo el personal administrativo
                $admins = User::all();
                Notification::make()
                    ->title('🚨 EMERGENCIA CRÍTICA ACTIVADA')
                    ->body("Se ha iniciado el protocolo: {$protocol->nombre}. Revise la bitácora de incidentes.")
                    ->danger()
                    ->persistent()
                    ->sendToDatabase($admins);
                
                Notification::make()
                    ->success()
                    ->title('Alerta enviada y Protocolo iniciado')
                    ->send();

                // 5. 🔥 REDIRECCIÓN INMEDIATA: Lleva al director a completar los pasos legales
                return redirect()->to(IncidentResource::getUrl('edit', ['record' => $incident]));
            });
    }
}