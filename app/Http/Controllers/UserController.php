<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Maklad\Permission\Traits\HasRoles;
use auth;
use Validator;
use Yajra\Datatables\Datatables;
use Maklad\Permission\Models\Role;


class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::all();
        // return $providers;
      // return  $users = User::role('Administrador')->get();
      //$currentuser = Auth::user();
      //$currentuser->assignRole('Administrador');

           return view('user.index')->with('user', $user);
       // return view('user.index');
    }



    public function getUser()
    {
    //$client = Client::all()->sortBy("name");
    $roles = role::pluck('name', '_id');

    //$user = user::all()->with('roles');
    $user = user::whereNotNull('_id')->get();
    //$roles = role::all();
    //return  role::where('_id', "5c12a0aee690b2422c003549")->get();
    //$roles = $user->roles->pluck('name');
    foreach ($user as $key ){
    $key->roleid = $key->role_ids[0];
    $key->rolname = role::where('_id', $key->roleid)->select('name')->first();
    }
   // return $user;
         $currentuser = Auth::user();




      if ( $currentuser->hasRole('Administrador'))
      {
        return Datatables::of($user)

      ->addColumn('action', function ($user) {
      return ' <td>
            <td><button class="edit-modal btn btn-primary" data-id="'.$user->id.'" data-rol="'.$user->rolname->name.'" data-surname="'.$user->surname.'" data-name="'.$user->name.'">
            <span class="glyphicon glyphicon-edit"></span> Editar</button>

      <td><button class="delete-modal btn btn-danger" data-id="'.$user->id.'" data-name="'.$user->name.' "data-phone="'.$user->phone.'">
      <span class="glyphicon glyphicon-edit"></span> Eliminar
      </button>
      ';
      })

      ->editColumn('rol', function ($user) {
        $yourJson = trim($user->roles, '[]');
       // return $yourJson;
        return $test = (json_decode($yourJson, true));
        })
      ->make(true);
    }
    else{
        return Datatables::of($user)

        ->editColumn('rol', function ($user) {
          $yourJson = trim($user->roles, '[]');
         // return $yourJson;
          return $test = (json_decode($yourJson, true));
          })
        ->make(true);
    }
    }
//edit user function
    public function editUser(Request $req) {
      //  return $req;
        $data = User::find ( $req->id );
        $data->name = $req->name;
        $data->surname = $req->surname;

        $data->save ();
        return response ()->json ( $data );
    }

//delete user function
    public function deleteUser(Request $req)
    {
        //return $req;
        User::find($req->id)->delete();
        return response()->json();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('user.register');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function store(Request $request)
    {
        //
       // return $request;

       $validator = Validator::make($request->all(), [
        'rut' => ['required', 'string', 'max:255', 'unique:users'],
        'name' => ['required', 'string', 'max:255'],
        'surname' => ['required', 'string', 'max:255'],
        'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
    ]);

    //return response()->json(['success'=>'success']);

    if ($validator->passes()) {
        User::store($request);
      //  return response()->json(['success'=>'success']);
        return redirect('/user')->with('success', 'Usuario agregado correctamente');

    }

   // return response()->json(['error'=>$validator->errors()->all()]);
   return redirect('/user')->with('success', 'Usuario agregado correctamente');

       // User::store($request);

      //      return $validatedData;
      // return json_encode($request);

       /*
        $this->validate($request, [
            'rut' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            ]);
            User::store($request);

        //$user->assignRole($role);

        return redirect('/user')->with('success', 'Usuario agregado correctamente');
*/

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
