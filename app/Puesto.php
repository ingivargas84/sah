<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    protected $table = 'puestos';
    protected $fillable = [
        'id',
        'nombre',
        'user_crea_id',
        'estado',
    ];

    public function empleados()
    {
        return $this->hasMany()(Empleado::class);
    }
}
