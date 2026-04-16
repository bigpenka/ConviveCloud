<?php

namespace App\Observers;

use App\Models\Incident;
use App\Mail\IncidentClosedMail;
use Illuminate\Support\Facades\Mail;

class IncidentObserver
{
    /**
     * Se ejecuta cada vez que el incidente se actualiza.
     */
    public function updated(Incident $incident): void
    {
        // 🚀 Verificamos que el estado cambió a 'Cerrado' y que no se mande mil veces
        if ($incident->isDirty('status') && $incident->status === 'Cerrado') {
            
            // Cargamos las relaciones para que el mail no salga vacío
            $incident->load(['student', 'etapas']); 

            if ($incident->student && $incident->student->email_apoderado) {
                Mail::to($incident->student->email_apoderado)
                    ->send(new IncidentClosedMail($incident));
            }
        }
    }
}