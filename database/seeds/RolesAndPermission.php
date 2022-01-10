<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // this can be done as separate statements
        $role = Role::create(['name' => 'super-admin']);

        $role = Role::create(['name' => 'Administrador']);

        $role = Role::create(['name' => 'Contabilidad']);

        $role = Role::create(['name' => 'Recepcion']);

        $role = Role::create(['name' => 'Ventas']);

        $role = Role::create(['name' => 'Limpieza']);
        

    }
}
