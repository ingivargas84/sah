<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    protected $table = 'habitacion';
    protected $fillable = [
    
        'nombre_habitacion',
        'estado',
        'precio',
        'descripcion',
        'user_id',
        'nivel_id',
        'tipo_id',
        'estado_id',

    ];

    public function estado_habitacion()
    {
        return $this->belongsTo(estado_habitacion::class);
    }
    public function tipo_habitacion()
    {
        return $this->belongsTo(TipoHabitacion::class);
    }
}
