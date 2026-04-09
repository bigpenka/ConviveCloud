<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncidentFollowUp extends Model
{
    public function user()
{
    return $this->belongsTo(User::class);
}

public function incident()
{
    return $this->belongsTo(Incident::class);
}
}
