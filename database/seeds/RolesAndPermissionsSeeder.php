<?php

use Illuminate\Database\Seeder;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // Reset cached roles and permissions
       app()['cache']->forget('maklad.permission.cache');

       // create permissions
       Permission::firstOrCreate(['name' => 'create users']);
       Permission::firstOrCreate(['name' => 'edit users']);
       Permission::firstOrCreate(['name' => 'delete users']);
       Permission::firstOrCreate(['name' => 'show users']);

       // create roles and assign existing permissions
       $role = Role::firstOrCreate(['name' => 'Visualizador']);
       $role->givePermissionTo('show users');


       $role = Role::firstOrCreate(['name' => 'Administrador']);
       $role->givePermissionTo(['create users', 'edit users','delete users', 'show users']);
    }
}
