<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants; // 🔥 Interfaz obligatoria para multi-colegio
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 🏢 --- LÓGICA DE COLEGIOS (MULTITENANCY) ---

    /**
     * Relación: Un usuario puede trabajar en varios colegios (Muchos a Muchos).
     * Ahora apunta correctamente a la tabla 'school_user'.
     */
    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class, 'school_user', 'user_id', 'school_id');
    }

    /**
     * Filament usa esto para listar los colegios a los que el usuario tiene acceso.
     */
    public function getTenants(Panel $panel): Collection
    {
        // 🔥 CORREGIDO: Devuelve la relación 'schools'
        return $this->schools;
    }

    /**
     * Seguridad: Verifica si el usuario realmente tiene permiso para entrar a un colegio.
     */
    public function canAccessTenant(Model $tenant): bool
    {
        // 🔥 CORREGIDO: Verifica en la relación 'schools'
        return $this->schools->contains($tenant);
    }

    /**
     * Opcional: Verifica si el usuario puede entrar al panel de administración general.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Permitimos el acceso al panel a los usuarios logueados
        return true; 
    }
}