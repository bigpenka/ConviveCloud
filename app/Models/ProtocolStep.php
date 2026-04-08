<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProtocolStep extends Model
{
    protected $fillable = [
        'protocol_id',
        'name',
        'order',
        'is_mandatory'
    ];
}