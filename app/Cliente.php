<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Cliente extends Model
{
    protected $table = 'clientes';
    protected $dates = ['nacimiento'];
    protected $fillable = [
    
        'nombres',
        'apellidos',
        'nit',
        'no_documento',
        'celular',
        'telefono',
        'direccion',
        'correo',
        'nacimiento',
        'estado', 
        'user_id',
        'tipo_id',
        'tipo_documento_id',

    ];

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }
    public function tipo_cliente()
    {
        return $this->belongsTo(TipoCliente::class);
    }
    public function setNacimientoAttribute($nacimiento)
    {
        $this->attributes['nacimiento'] = $nacimiento ? Carbon::parse($nacimiento) :null;
    }
  

}
