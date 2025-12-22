<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hecho extends Model
{
    protected $guarded = [];
    
    // Para que Laravel maneje esto como fecha automáticamente
    protected $casts = [
        'fecha_ocurrencia' => 'datetime',
    ];
}