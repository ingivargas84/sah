<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    protected $table = 'niveles';
    protected $fillable = [
        'id',
        'nivel_nombre',
        'user_id',
        'estado',
    ];
}