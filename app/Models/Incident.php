<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incident extends Model
{
    protected $fillable = [
        'student_id',
        'protocol_id',
        'fecha_incidente',
        'descripcion',
        'checklist', 
        'seguro_escolar_data',    // <-- AÑADIDO: Para guardar los datos del formulario médico
        'informe_accidente_data', // <-- AÑADIDO: Para guardar los datos del informe
        'estado',
        'fecha_cierre',
    ];

    protected $casts = [
        'fecha_incidente' => 'date',
        'fecha_cierre' => 'datetime',
        'checklist' => 'array', 
        'seguro_escolar_data' => 'array',    // <-- AÑADIDO: Convierte el JSON a array
        'informe_accidente_data' => 'array', // <-- AÑADIDO: Convierte el JSON a array
    ];

    /**
     * Relación con el Alumno
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relación con el Protocolo
     */
    public function protocol(): BelongsTo
    {
        return $this->belongsTo(Protocol::class);
    }
    public function followUps()
{
    return $this->hasMany(IncidentFollowUp::class);
}

}