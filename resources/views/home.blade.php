@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bienvenido  {{ Auth::user()->name }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
<center>
        <a href="user" class="btn btn btn-primary" role="button"> <span class="glyphicon glyphicon-edit"> </span>Listado de usuarios</a>
        @role('Administrador')
        <a href="user/create" class="btn btn btn-primary" role="button"> <span class="glyphicon glyphicon-edit"> </span>Registrar usuario</a>
        @endrole
</center>
<br><br>
Listado de usuarios
                    <table class="table table-inverse">
                        <thead class="thead-inverse">
                          <tr>
                            <th>Rut</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                          </tr>
                        </thead>
                                @foreach($user as $user)
                        <tbody>
                          <tr>
                          <td>{{$user->rut}}</td>
                          <td>{{$user->name}}</td>
                          <td>{{$user->surname}}</td>
                              </td>
                          </tr>
                        </tbody>
                            @endforeach
                      </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
