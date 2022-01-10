<?php

use Illuminate\Database\Seeder;
use App\estado_habitacion;

class estado_habitacion_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = new estado_habitacion();
        $estado->estado = 'Disponible';
        $estado->save();

        $estado = new estado_habitacion();
        $estado->estado = 'Reservada';
        $estado->save();

        $estado = new estado_habitacion();
        $estado->estado = 'Ocupada';
        $estado->save();

        $estado = new estado_habitacion();
        $estado->estado = 'En Limpieza';
        $estado->save();

        $estado = new estado_habitacion();
        $estado->estado = 'No Disponible';
        $estado->save();
    }
}