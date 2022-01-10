<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_habitacion extends Model
{
    protected $table = 'estado_habitacion';
    protected $fillable = [
        'estado',
    ];

    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class);
    }
}
