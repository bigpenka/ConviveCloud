<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyAlert extends Model
{
    // 🔥 Permite que el sistema guarde quién activó la alerta
    protected $fillable = ['user_id', 'tipo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}