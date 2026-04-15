<?php

namespace App\Models;

use Filament\Models\Contracts\HasName; // 🔥 1. Importamos esta herramienta de Filament
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }
    // 🔥 Le decimos que use la tabla intermedia 'school_user' (Muchos a Muchos)
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'school_user', 'school_id', 'user_id');
    }
}