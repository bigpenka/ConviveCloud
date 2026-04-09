<?php

namespace App\Models;

use Filament\Models\Contracts\HasName; // 🔥 1. Importamos esta herramienta de Filament
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model implements HasName // 🔥 2. Le agregamos "implements HasName"
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'slug', 
        'rut_institucion', 
        'direccion'
    ];

    // 🔥 3. Agregamos esta función para traducirle a Filament
    public function getFilamentName(): string
    {
        return $this->nombre; // Le decimos que el nombre real está en la columna 'nombre'
    }
}