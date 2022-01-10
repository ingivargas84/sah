<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = 'tipos_documentos';
    protected $fillable = [
    
        'tipo_documentos',
        'estado',
        'user_id',

    ];
    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
