<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    // Definimos los campos que se pueden llenar
    protected $fillable = [
        'rut', 
        'nombre', 
        'apellido', 
        'curso'
    ];

    // Relación: Un estudiante puede tener muchos protocolos
    public function protocolos()
    {
        return $this->hasMany(Protocolo::class);
    }
}