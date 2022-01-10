<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicioExtra extends Model
{
    protected $table = 'servicios_extra';
    protected $fillable = [
    
        'nombre_servicio',
        'estado',
        'precio',
        'user_id',
        'descripcion',
        'tipo_id',

    ];

    public function tipo_servicio()
    {
        return $this->belongsTo(TipoServicioExtra::class);
    }
}

