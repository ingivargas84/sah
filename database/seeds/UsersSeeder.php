<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin= User::create([
            'name'=>'superadmin',
            'email'=>'superadmin@vrinfosysgt.com',
            'username'=>'superadmin',
            'password'=>bcrypt('superadmin'),
        ]);
        $superadmin->assignRole('super-admin');


        $admin= User::create([
            'name'=>'admin',
            'email'=>'admin@vrinfosysgt.com',
            'username'=>'admin',
            'password'=>bcrypt('admin'),
        ]);
        $admin->assignRole('Administrador');


        $contabilidad= User::create([
            'name'=>'contabilidad',
            'email'=>'contabilidad@vrinfosysgt.com',
            'username'=>'contabilidad',
            'password'=>bcrypt('contabilidad'),
        ]);
        $contabilidad->assignRole('Contabilidad');


        $recepcion= User::create([
            'name'=>'recepcion',
            'email'=>'recepcion@vrinfosysgt.com',
            'username'=>'recepcion',
            'password'=>bcrypt('recepcion'),
        ]);
        $recepcion->assignRole('Recepcion');

        
        $ventas= User::create([
            'name'=>'ventas',
            'email'=>'ventas@vrinfosysgt.com',
            'username'=>'ventas',
            'password'=>bcrypt('ventas'),
        ]);
        $ventas->assignRole('Ventas');


        $limpieza= User::create([
            'name'=>'limpieza',
            'email'=>'limpieza@vrinfosysgt.com',
            'username'=>'limpieza',
            'password'=>bcrypt('limpieza'),
        ]);
        $limpieza->assignRole('Limpieza');
    }
}