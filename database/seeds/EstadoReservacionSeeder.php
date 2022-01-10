<?php

use Illuminate\Database\Seeder;
use App\EstadoReservacion;

class EstadoReservacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = new EstadoReservacion();
        $estado->estado = 'Nueva';
        $estado->save();

        $estado = new EstadoReservacion();
        $estado->estado = 'Confirmada';
        $estado->save();

        $estado = new EstadoReservacion();
        $estado->estado = 'Ocupada';
        $estado->save();

        $estado = new EstadoReservacion();
        $estado->estado = 'Finalizada';
        $estado->save();
    }
}
