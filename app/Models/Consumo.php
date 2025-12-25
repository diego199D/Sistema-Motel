<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consumo extends Model
{
    protected $fillable = [
        'planilla_id',
        'nombre',
        'cantidad',
        'precio',
    ];

    public function planilla()
    {
        return $this->belongsTo(Planilla::class);
    }
}
