<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoServicioExtra extends Model
{
    protected $table = 'tipo_servicios_extra';
    protected $fillable = [
        'nombre',
        'estado',
        'user_id',
    ];
    public function servicios()
    {
        return $this->hasMany(ServicioExtra::class);
    }
   
}
