<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // 🔥 Importante para la relación

class Protocol extends Model
{
    // Permite asignación masiva para el nombre (ajusta según tus columnas reales)
    protected $fillable = ['nombre', 'descripcion', 'gravedad', 'plazo_dias'];

    /**
     * Relación: Un protocolo tiene muchos pasos (etapas).
     * Esto permite que hagamos $protocol->steps->count()
     */
    public function steps(): HasMany
    {
        return $this->hasMany(ProtocolStep::class);
    }
}