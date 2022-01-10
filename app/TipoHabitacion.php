<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    protected $table = 'tipo_habitacion';
    protected $fillable = [
        'tipo_habitacion',
        'estado',
        'user_id',
    ];

    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class);
    }
}
