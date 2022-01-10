<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoReservacion extends Model
{
    protected $table = 'estado_reservacion';
    protected $fillable = [
        'estado',
    ];
}
