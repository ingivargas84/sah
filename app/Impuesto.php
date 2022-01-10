<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Impuesto extends Model
{
    protected $table = 'impuestos';
    protected $fillable = [
    
        'nombre_impuesto',
        'estado',
        'porcentaje',
        'user_id',

    ];
}
