<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Maklad\Permission\Traits\HasRoles;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use Notifiable;
    use  HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     * se añadio el campo rut
     */
    protected $fillable = [
        'rut' , 'name', 'surname', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function store(Request $request)
    {
        // Validate the request...
        $user = new User;

        $user->rut = $request->rut;
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->password = $request->password;
        $user->assignRole('Visualizador');
        $user->givePermissionTo('show users');
        $user->save();
        $user->assignRole('Visualizador');
        $user->givePermissionTo('show users');
    }

}
