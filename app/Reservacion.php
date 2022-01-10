<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Reservacion extends Model
{
    protected $table = 'reservaciones';
    protected $dates = ['fecha_inicio', 'fecha_fin'];
    protected $fillable = [
        'habitacion_id',
        'nombres',
        'telefono',
        'fecha_inicio',
        'fecha_fin',
        'pago',
        'user_id',
        'color',
        'estado',
        'estado_id',

    ];

    public function estado_reserva()
    {
        return $this->belongsTo(EstadoReservacion::class);
    }
    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class);
    }
            
    public function setFechaInicioAttribute($fecha_inicio)
    {
        $this->attributes['fecha_inicio'] = $fecha_inicio ? Carbon::parse($fecha_inicio) :null;
    }

    public function setFechaFinAttribute($fecha_fin)
    {
        $this->attributes['fecha_fin'] = $fecha_fin ? Carbon::parse($fecha_fin) :null;
    }  
}
