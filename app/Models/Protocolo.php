<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protocolo extends Model
{
    // Campos permitidos según nuestra base de datos
    protected $fillable = [
        'folio', 
        'tipo', 
        'estado', 
        'estudiante_id', 
        'user_id'
    ];

    // Relación: Un protocolo pertenece a un estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }
}