<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maklad\Permission\Models\Role;
use Maklad\Permission\Models\Permission;
use app\user;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $currentuser = User::where('rut', Auth::user()->rut)->first();
$user = User::all();
      //return   $user = DB::collection('users')->where('rut',Auth::user()->rut)->first()->get();
     // && $users->givePermissionTo('show users');

      //  return $userInfo = Auth::user()->id;

      // return  $user->hasPermissionTo('edit articles');
      //return $role = Role::findByName('Visualizador');

        return view('home')->with('user', $user);
    }
}
