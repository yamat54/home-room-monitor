<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeshData extends Model
{
    protected $fillable = [
        'time',
        'temp',
        'humid',
    ];

    protected $casts = [
        'time' => 'datetime',
    ];
}

