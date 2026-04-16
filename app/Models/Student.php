<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // 🔥 Importación clave

class Student extends Model
{
    use BelongsToSchool;

    // Permitimos que Filament guarde todos los campos (incluyendo el course_id)
    protected $guarded = []; 

    // 🚀 ESTO ES LO QUE FALTABA: La conexión entre el Alumno y el Curso
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
