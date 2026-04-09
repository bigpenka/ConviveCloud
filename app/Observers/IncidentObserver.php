<?php

namespace App\Observers;

use App\Models\Incident;

class IncidentObserver
{
    /**
     * Se activa cada vez que guardas un cambio en el incidente.
     */
    public function updated(Incident $incident): void
    {
        // 1. Obtenemos el total de pasos del protocolo
        // Usamos el operador nullsafe (?->) por si el protocolo se borra por error
        $totalPasos = $incident->protocol?->steps()->count() ?? 0;
        
        // 2. Contamos los pasos marcados directamente del campo 'checklist'
        // Filament guarda esto como un array JSON
        $pasosCompletados = is_array($incident->checklist) ? count($incident->checklist) : 0;

        // 3. Determinamos el nuevo estado (OJO: Con mayúsculas para que coincida con la tabla)
        $nuevoEstado = match (true) {
            $totalPasos === 0 => 'Abierto',
            $pasosCompletados === 0 => 'Abierto',
            $pasosCompletados < $totalPasos => 'En Proceso',
            $pasosCompletados === $totalPasos => 'Cerrado',
            default => 'Abierto',
        };

        // 4. Actualizamos solo si el estado realmente cambió
        if ($incident->estado !== $nuevoEstado) {
            $incident->estado = $nuevoEstado;
            // saveQuietly() es clave para no crear un bucle infinito de updates
            $incident->saveQuietly(); 
        }
    }

    public function created(Incident $incident): void
    {
        if (!$incident->estado) {
            $incident->estado = 'Abierto';
            $incident->saveQuietly();
        }
    }
}