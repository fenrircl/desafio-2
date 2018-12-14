

@if(count($user) > 0)

        <table class="table" id="table">

  <thead class="thead-inverse">
    <tr>
        <th>Rut</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Ultima actualizacion</th>
        @role('Administrador')
        <th>Accion</th>
        @endrole

    </tr>
  </thead>
          @foreach($user as $user)
  <tbody>

    <tr>

        <td>{{$user->rut}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->surname}}</td>
        <td>{{$user->updated_at}}</td>
        </td>

    </tr>
  </tbody>
      @endforeach

</table>



@else
<p>No hay usuarios</p>
@endif
</div>
