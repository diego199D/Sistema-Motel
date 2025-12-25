<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $fillable =[
        'habitacion_id',
        'fecha',
        'entrada',
        'salida',
        'pago_adelantado',
        'ac',
        'monto_habitacion',
        'monto_consumo',
        'monto_total',
    ];

    protected $casts = [
    'entrada' => 'datetime',
    'salida' => 'datetime',
    'fecha' => 'date',
];

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }

    public function consumo(){
        return $this->hasMany(Consumo::class, );
    }
}
