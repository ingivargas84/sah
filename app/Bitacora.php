<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacora';
    protected $fillable = [
        'id',
        'user_id',
        'info_anterior',
        'info_nueva',
        'accion',
        'nombre_tabla',
    ];

}
