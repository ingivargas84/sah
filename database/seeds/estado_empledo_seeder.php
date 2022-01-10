<?php

use Illuminate\Database\Seeder;
use App\estado_empleado;

class estado_empledo_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = new estado_empleado();
        $estado->estado = 'Activo';
        $estado->save();

        $estado = new estado_empleado();
        $estado->estado = 'Inactivo';
        $estado->save();

        $estado = new estado_empleado();
        $estado->estado = 'Vacaciones';
        $estado->save();

        $estado = new estado_empleado();
        $estado->estado = 'Suspendido';
        $estado->save();
    }
}
