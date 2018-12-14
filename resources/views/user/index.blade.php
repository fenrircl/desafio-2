@extends('layouts.app')

@section('content')

@if (session('success'))
<div class="alert alert-success">
{{session('success')}}
</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="container">

<center>
<h1> Usuarios  </h1>
</center>
@role('Administrador')

<a href="user/create"><button type="submit" class="btn add-modal btn-primary">Agregar nuevo usuario</button></a>
@endrole


  <br><h3></h3>

  <table class="table table-bordered" id="users-table">
        <thead>
            <tr>
                <th>Rut</th>
                <th>Nombre</th>
                <th>Apellido</th>
                @role('Administrador')
                <th>Rol</th>
                <th>Accion</th>
                @endrole
            </tr>
        </thead>
    </table>




 <!-- Ventana modal editar -->
 <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" role="form">
                    @include('user.form')
                    </form>
                    <div class="deleteContent">
                            ¿Está seguro de eliminar al usuario:  <span class="dname"></span> ? <span
                                class="hidden did"></span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn actionBtn" data-dismiss="modal">
                                <span id="footer_action_button" class='glyphicon'> </span>
                            </button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                                <span class='glyphicon glyphicon-remove'></span> Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

<!-- Include this after the sweet alert js file -->
<script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
<script src="js/sweetalert2.all.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<!-- AJAX CRUD operations -->
<script type="text/javascript">
    // add a new user
    $(document).on('click', '.add-modal', function() {
        $('.modal-title').text('Agregar nuevo usuario');
        $('#addModal').modal('show');
    });
    $(document).on('click', '.add', function() {

    //    console.log("add clicked");
        $.ajax({
            type: 'POST',
            url: 'user',
            data: {
                '_token': $('input[name=_token]').val(),
                'name': $('#name').val(),
                'surname': $('#surname').val(),
                'rut': $('#rut').val(),
                'password': $('#password').val(),
                'password_confirmation': $('#password-confirm').val()
            },
            success: function(data){
                if(data['success']){
                    //recargar datatable de usuarios
                    $('#users-table').DataTable().ajax.reload();
                    Swal({
                    type: 'success',
                    title: 'Usuario agregado',
                    showConfirmButton: false,
                    timer: 1500
                    })
                }
                else{
                    Swal({
                    type: 'error',
                    title: 'Oops...',
                    text: data['error'],
                    })
                }

                },
            error: function(error){
                console.log("Error:");
                console.log(error);
                }
        });
    });

//click en boton editar
$(document).ready(function() {
  $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text("Editar");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').removeClass('delete');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Editar');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#fid').val($(this).data('id'));
        $('#name').val($(this).data('name'));
        $('#surname').val($(this).data('surname'));
        $('#rol').val($(this).data('rol'));
        $('#myModal').modal('show');
    });
    //click en boton eliminar

    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text(" Eliminar");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').removeClass('edit');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Eliminar');
        $('.did').text($(this).data('id'));
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        $('.dname').html($(this).data('name'));
        $('#myModal').modal('show');
        $('.did').hide();
    });

//click en editar
    $('.modal-footer').on('click', '.edit', function() {
        $.ajax({
            type: 'post',
            url: '/editUser',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $("#fid").val(),
                'name': $('#name').val(),
                'surname': $('#surname').val()
            },
            success: function(data) {
                $('#users-table').DataTable().ajax.reload();
            }
        });
    });

    $("#add").click(function() {

        $.ajax({
            type: 'post',
            url: '/addItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'name': $('input[name=name]').val()
            },
            success: function(data) {
                if ((data.errors)){
                  $('.error').removeClass('hidden');
                    $('.error').text(data.errors.name);
                }
                else {
                    $('.error').addClass('hidden');
                    $('#table').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                }
            },

        });
        $('#name').val('');
    });



    //click en eliminar usuaario
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: '/deleteUser',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('.did').text()
            },
            success: function(data) {
                $('#users-table').DataTable().ajax.reload();

                $('.item' + $('.did').text()).remove();
            }
        });
    });
});



</script>

<script>
        $(function() {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('user.getUser') !!}',
                columns: [
                    { data: 'rut', name: 'rut' },
                    { data: 'name', name: 'name' },
                    { data: 'surname', name: 'surname' },
                    @role('Administrador')
                    { data: 'rol.name' },
                    {data: 'action', name: 'action', orderable: false, searchable: false}
                    @endrole
                ]
            });
        });
        </script>
<br><script src = "/js/plugin/datatables/jquery.dataTables.min.js" defer ></script>

@endsection
