<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class estadoSeries extends Model
{
    protected $table = 'estado_series';
    protected $fillable = [
        'estado',
    ];
    public function series()
    {
        return $this->hasMany(SeriesFactura::class);
    }
}
