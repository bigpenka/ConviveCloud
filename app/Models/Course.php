<?php

namespace App\Models;

use App\Models\Traits\BelongsToSchool; // 🔥 El escudo
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use BelongsToSchool;

    protected $guarded = [];
    
    public function getFullNameAttribute()
{
    return "{$this->nombre} " . ($this->seccion ?? '');
}
}