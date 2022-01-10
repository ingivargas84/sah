<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estado_empleado extends Model
{
    protected $table = 'estado_empleado';
    protected $fillable = [
        'estado',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }
}
