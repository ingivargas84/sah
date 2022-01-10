<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCliente extends Model
{
    protected $table = 'tipos_clientes';
    protected $fillable = [
    
        'tipo_cliente',
        'estado',
        'descuento',
        'user_id',

    ];
    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
