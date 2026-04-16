<?php

namespace App\Models;

use Filament\Models\Contracts\HasName; 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class School extends Model implements HasName 
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'slug', 
        'rut_institucion', 
        'direccion'
    ];

    public function getFilamentName(): string
    {
        return $this->nombre; 
    }

    /**
     * 🚀 RELACIÓN CLAVE: Define que un colegio tiene muchos alumnos.
     * Esto soluciona el error "does not have a relationship named [students]".
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'school_user', 'school_id', 'user_id');
    }
}