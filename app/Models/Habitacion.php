<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $fillable = [
        'numero',
        'estado',
    ];

    public function planilla()
    {
        return $this->hasMany(Planilla::class);
    }
}
