<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    protected $table = 'tipos_pago';
    protected $fillable = [
        'tipo_pago',
        'estado',
        'user_id',
    ];

}
