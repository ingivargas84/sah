<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class documentos extends Model
{
    protected $table = 'documentos';
    protected $fillable = [
        'documentos',
    ];

    public function compras()
    {
        return $this->hasMany(CompraCaja::class);
    }
}
