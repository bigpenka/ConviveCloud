<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool; // 🔥 Importamos el Trait
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class Incident extends Model
{
    use BelongsToSchool; // 🚀 ACTIVAMOS EL BLINDAJE AQUÍ

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
        'checklist' => 'array',
        'seguro_escolar_data' => 'array',
        'informe_accidente_data' => 'array',
    ];

    protected static function booted(): void
    {
        static::created(function (Incident $incident) {
            $user = Auth::user();

            if ($user) {
                $protocolo = $incident->protocol;

                Notification::make()
                    ->title($protocolo?->gravedad === 'Gravísima' ? '🚨 EMERGENCIA' : 'Nuevo Incidente')
                    ->body("Caso registrado: " . ($protocolo?->nombre ?? 'Sin protocolo'))
                    ->icon($protocolo?->gravedad === 'Gravísima' ? 'heroicon-o-exclamation-triangle' : 'heroicon-o-bell')
                    ->color($protocolo?->gravedad === 'Gravísima' ? 'danger' : 'success')
                    ->sendToDatabase($user);

                \Filament\Notifications\Events\DatabaseNotificationsSent::dispatch($user);
            }
        });
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function protocol(): BelongsTo
    {
        return $this->belongsTo(Protocol::class);
    }

    public function followUps(): HasMany
    {
        return $this->hasMany(IncidentFollowUp::class);
    }
    
    // Ya no necesitas la función school() aquí, porque el Trait se encarga de eso.
}