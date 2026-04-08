<?php

use Illuminate\Support\Facades\Route;
use App\Models\Incident;
use App\Models\ProtocolStep; // <--- IMPORTANTE: Añadimos esto
use Barryvdh\DomPDF\Facade\Pdf; // Asegúrate de tener esta línea si usas DomPDF

// EL TRUCO PARA QUE EL LOGIN SALTE PRIMERO
Route::get('/', function () {
    return redirect('/admin'); 
});

// TU RUTA DE PDF MEJORADA PARA EL DEBIDO PROCESO
Route::get('/incidente/{incident}/print', function (Incident $incident) {
    
    // 1. Cargamos las relaciones para no tener errores en la vista
    $incident->load(['student', 'protocol']);

    // 2. Buscamos los pasos legales marcados en el checklist
    // Transformamos los IDs guardados en el array a nombres reales
    $pasosMarcados = ProtocolStep::whereIn('id', $incident->checklist ?? [])
        ->orderBy('order')
        ->get();

    // 3. Retornamos la vista del PDF con toda la información
    // Usamos Pdf::loadView si estás usando la librería DomPDF para generar el archivo
    $pdf = Pdf::loadView('pdf.incidente', [
        'incidente' => $incident,
        'pasosMarcados' => $pasosMarcados
    ]);

    return $pdf->stream('Incidente_'.$incident->id.'.pdf');

})->name('incidente.print');