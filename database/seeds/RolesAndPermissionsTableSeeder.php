<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);
        Permission::create(['name' => 'ver roles']);
        Permission::create(['name' => 'crear roles']);
        Permission::create(['name' => 'editar roles']);
        Permission::create(['name' => 'eliminar roles']);
        Permission::create(['name' => 'ver permisos']);
        Permission::create(['name' => 'crear permisos']);
        Permission::create(['name' => 'editar permisos']);
        Permission::create(['name' => 'eliminar permisos']);

        // create roles and assign created permissions
        // 
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());

        // or may be done by chaining
        $role = Role::create(['name' => 'administrador'])
            ->givePermissionTo([
                'ver usuarios', 
                'crear usuarios', 
                'editar usuarios',
                'ver roles', 
                'crear roles', 
                'editar roles',
                'ver permisos', 
                'crear permisos', 
                'editar permisos',
                ]);

        // this can be done as separate statements
        $role = Role::create(['name' => 'invitado']);
        $role->givePermissionTo('ver usuarios');

                
    }
}
