<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesAndPermission::class);
        $this->call(UsersSeeder::class);
        $this->call(estado_empledo_seeder::class);
        $this->call(EmpresaSeeder::class); 
        $this->call(estado_habitacion_seeder::class);
        $this->call(EstadoReservacionSeeder::class);
        $this->call(EsdoSeriesSeed::class);
        $this->call(DocumentosSeeder::class);
        
        
    }
}
