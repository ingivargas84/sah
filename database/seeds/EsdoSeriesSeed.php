<?php

use Illuminate\Database\Seeder;
use App\estadoSeries;

class EsdoSeriesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = new estadoSeries();
        $estado->estado = 'Creado';
        $estado->save();
        $estado = new estadoSeries();
        $estado->estado = 'Activo';
        $estado->save();

        $estado = new estadoSeries();
        $estado->estado = 'Vencido';
        $estado->save();

        $estado = new estadoSeries();
        $estado->estado = 'Finalizado';
        $estado->save();

        $estado = new estadoSeries();
        $estado->estado = 'Anulado';
        $estado->save();
    }
    
}