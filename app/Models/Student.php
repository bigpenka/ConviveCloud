<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{
    // 🔥 Dejamos el modelo abierto para que Filament pueda guardar los datos y el ID del colegio
    protected $guarded = []; 

    // 🔥 Agregamos la relación exacta que Filament está buscando
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}