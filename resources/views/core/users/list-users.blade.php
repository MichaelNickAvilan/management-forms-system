@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-building"></i> {{ __('Usuarios') }}</h1>

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status'))
        <div class="alert alert-success border-left-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-light active"><i class="fas fa-table"></i> Gestionar usuarios</button>
                        @if(Auth::user()->type == 1 || Auth::user()->type == 5)
                            <a href="{{ route('users.create') }}"><button type="button" class="btn btn-light"><i class="fas fa-plus-circle"></i> Crear usuario</button></a>
                            <!-- <a href="{{ route('users.create') }}?import=true"><button type="button" class="btn btn-light"><i class="fas fa-cloud-upload-alt"></i> Importar usuarios</button></a> -->
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <h2>Listado de usuarios</h2>
                    <p>En esta sección podrás gestionar los usuarios existentes en el sistema.</p>
                    <table id="regs_table">
                        <thead>
                            <tr>
                                <th>Tienda</th>
                                <th>Nombres</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{$user['store']}}</td>
                                <td>{{$user['name']}} {{$user['last_name']}}</td>
                                <td>{{$user['email']}}</td>
                                <td>
                                    <a title="Ver perfil de {{$user['name']}} {{$user['last_name']}}" href="{{action('UsersController@show', $user['id'])}}"><button style="margin:2px; width:90px;" type="button" class="btn btn-primary"><i class="fas fa-info-circle"></i><br/>Perfil</button></a>
                                    <a title="Evaluar a {{$user['name']}} {{$user['last_name']}}" href="{{ route('registers.create') }}?email={{$user['email']}}&user_id={{$user['id']}}&store={{$user['store']}}"><button style="margin:2px; width:90px;" type="button" class="btn btn-primary"><i class="fas fa-address-card"></i><br/>Evaluar</button></a>
                                    <a title="Actualizar usuario:  {{$user['name']}} {{$user['last_name']}}" href="{{action('UsersController@edit', $user['id'])}}"><button style="margin:2px; width:90px;" type="button" class="btn btn-primary"><i class="fas fa-pen"></i><br/>Actualizar</button></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
     window.onload = function() {
        DataTablesUtils.init('regs_table', true, [0, 'desc'], [0,1,2]);
     };
    </script>
@endsection
