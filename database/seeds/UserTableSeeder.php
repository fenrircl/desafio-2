<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role_user =   DB::collection('roles')->where('name', 'Administrador')->first();
     //   DB::collection('roles')->where('name', 'users')->first();

       // $role_user = Role::where('name', 'user')->first();
       // $role_admin = Role::where('name', 'admin')->first();


       DB::collection('users')->insert([
        'rut' => '0000000-0',
        'name' => 'admin',
        'surname' => 'example',
        'email' => 'admin@prueba.com',
        'password' => bcrypt('password')
        ]);

        $user = User::all()->first();
        $user->assignRole('Administrador');
        $user->givePermissionTo(['create users', 'edit users','delete users', 'show users']);
    }
}
