<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Incident extends Model
{
    protected $fillable = [
        'school_id',
        'student_id',
        'protocol_id',
        'fecha_incidente',
        'descripcion',
        'checklist', 
        'seguro_escolar_data',
        'informe_accidente_data',
        'estado',
        'fecha_cierre',
    ];

    protected $casts = [
        'fecha_incidente' => 'date',
        'fecha_cierre' => 'datetime',
        'checklist' => 'array', // 🔥 CRÍTICO: Para que el Repeater de Filament funcione
        'seguro_escolar_data' => 'array',
        'informe_accidente_data' => 'array',
    ];

    /**
     * Relación con el Alumno
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relación con el Protocolo aplicado
     */
    public function protocol(): BelongsTo
    {
        return $this->belongsTo(Protocol::class);
    }

    /**
     * Seguimientos del incidente
     */
    public function followUps(): HasMany
    {
        return $this->hasMany(IncidentFollowUp::class);
    }

    /**
     * Relación con el Colegio (Multi-tenant)
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}