<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Checkin extends Model
{
    protected $table = 'checkin';
    protected $dates = ['fecha_inicio', 'fecha_fin'];
    protected $fillable = [
    
        'cliente_id',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'adelanto',
        'habitacion_id',
        'precio',
        'user_id'

    ];

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }
    public function tipo_cliente()
    {
        return $this->belongsTo(TipoCliente::class);
    }
    public function setFechaInicioAttribute($fecha_inicio)
    {
        $this->attributes['fecha_inicio'] = $fecha_inicio ? Carbon ::parse($fecha_inicio) :null;
    }

    public function setFechaFinAttribute($fecha_fin)
    {
        $this->attributes['fecha_fin'] = $fecha_fin ? Carbon::parse($fecha_fin) :null;
    }  
    public function user()
    {
        return $this->belongsTo(User::class); //$puesto->user->name
    }

    public function habitacion()
    {
        return $this->belongsTo(Habitacion::class); 
    }
    
}
