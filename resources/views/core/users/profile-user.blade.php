@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
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

    @if(isset($user) != TRUE)    
    <div class="row">
        <div class="col-xl-12 col-md-12 mb-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                </div>
                <div class="card-body">
                    <div class="form-group" style="width:100%; float:left; margin-right:4px;">
                        <label class="form-control-label" for="type">País</label>
                        <select id="countries_combo" class="form-control form-control-user" name="country" required="" autofocus="">
                        </select>
                    </div>
                    <div class="form-group" style="width:100%; float:left; margin-right:4px;">
                        <label class="form-control-label" for="type">Tienda</label>
                        <select id="stores_combo" class="form-control form-control-user" name="store" required="" autofocus="">
                            <option value="">Selecciona una tienda</option>
                        </select>
                    </div>
                    <div class="form-group" style="width:100%; float:left; margin-right:4px;">
                        <label class="form-control-label" for="type">Usuarios</label>
                        <select id="users_combo" class="form-control form-control-user" name="user" required="" autofocus="">
                            <option value="">Selecciona un usuario</option>
                        </select>
                    </div>
                    <div class="form-group" style="width:50%; float:left; margin-right:4px;">
                        <label class="form-control-label" for="type">Desde</label>
                        <input id="from_date" type="date" class="form-control form-control-user"/>
                    </div>
                    <div class="form-group" style="width:49%; float:left; margin-left:5px;">
                        <label class="form-control-label" for="type">Hasta</label>
                        <input id="to_date" type="date" class="form-control form-control-user"/>
                    </div>
                    <select id="dates_combo" class="form-control form-control-user" name="user" required="" autofocus="" style="height:0px;visibility:hidden;" multiple>
                        <option value="">Selecciona una fecha</option>
                    </select>
                    
                    
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Puntaje
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="mood_container"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div id="mood_bar" class="progress-bar" role="progressbar" style="width: 1%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i id="mood_face" class="far fa-smile fa-4x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2" style="border-left: .25rem solid #ffd966 !important;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Conectar
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="connect_container"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div id="connect_bar" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color:#ffd966 !important;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-charging-station fa-4x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2" style="border-left: .25rem solid #6aa84f !important;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Enganchar
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="engage_container"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div id="engage_bar" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color:#6aa84f !important;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="	fas fa-handshake fa-4x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2" style="border-left: .25rem solid #a64d79 !important;">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Inspirar
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" id="inspire_container"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div id="inspire_bar" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color:#a64d79 !important;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-lightbulb fa-4x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    </div>

    <div class="row">
        <div class="col-xl-6 col-md-6 mb-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Fortalezas</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold"><i class="far fa-grin-alt fa-1x text-black-300"></i><span id="top_bar_yes_label" class="float-right"></span></h4>
                    <div class="progress mb-4">
                        <div id="top_bar_yes" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color: rgb(255, 217, 102) !important;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold"><i class="far fa-smile fa-1x text-black-300"></i><span id="high_bar_yes_label" class="float-right"></span></h4>
                        <div class="progress mb-4">
                            <div id="high_bar_yes" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color: rgb(255, 217, 102) !important;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <h4 class="small font-weight-bold"><i class="far fa-flushed fa-1x text-black-300"></i><span id="middle_bar_yes_label" class="float-right"></span></h4>
                    <div class="progress mb-4">
                        <div id="middle_bar_yes" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color: rgb(255, 217, 102) !important;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold"><i class="far fa-frown fa-1x text-black-300"></i><span id="low_bar_yes_label" class="float-right"></span></h4>
                    <div class="progress mb-4">
                        <div id="low_bar_yes" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color: rgb(255, 217, 102) !important;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold"><i class="far fa-angry fa-1x text-black-300"></i><span id="bottom_bar_yes_label" class="float-right"></span></h4>
                    <div class="progress">
                        <div id="bottom_bar_yes" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color: rgb(255, 217, 102) !important;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-md-6 mb-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Áreas de oportunidad</h6>
                </div>
                <div class="card-body">
                    <h4 class="small font-weight-bold"><i class="far fa-grin-alt fa-1x text-black-300"></i><span id="top_bar_no_label" class="float-right"></span></h4>
                    <div class="progress mb-4">
                        <div id="top_bar_no" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color: red !important;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold"><i class="far fa-smile fa-1x text-black-300"></i><span id="high_bar_no_label" class="float-right"></span></h4>
                        <div class="progress mb-4">
                            <div id="high_bar_no" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color: red !important;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <h4 class="small font-weight-bold"><i class="far fa-flushed fa-1x text-black-300"></i><span id="middle_bar_no_label" class="float-right"></span></h4>
                    <div class="progress mb-4">
                        <div id="middle_bar_no" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color: red !important;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold"><i class="far fa-frown fa-1x text-black-300"></i><span id="low_bar_no_label" class="float-right"></span></h4>
                    <div class="progress mb-4">
                        <div id="low_bar_no" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color: red !important;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <h4 class="small font-weight-bold"><i class="far fa-angry fa-1x text-black-300"></i><span id="bottom_bar_no_label" class="float-right"></span></h4>
                    <div class="progress">
                        <div id="bottom_bar_no" class="progress-bar bg-info" role="progressbar" style="width: 1%; background-color: red !important;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-12 mb-4">
            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                @if(isset($user))
                <div class="btn-group" role="group" aria-label="Basic example">
                    @if(Auth::user()->type == 1 || Auth::user()->type == 5 || Auth::user()->type == 6)
                    <a href="{{ route('users.index') }}"><button type="button" class="btn btn-light"><i class="fas fa-table"></i> Gestionar usuarios</button></a>
                    <a href="{{ route('registers.create') }}?email={{$user['email']}}&user_id={{$user['id']}}&store={{$user['store']}}"><button type="button" class="btn btn-light"><i class="fas fa-address-card"></i> Evaluar usuario</button></a>
                    <a href="{{ route('registers.index') }}?email={{$user['email']}}&user_id={{$user['id']}}"><button type="button" class="btn btn-light"><i class="fas fa-address-card"></i> Ver evaluaciones del usuario</button></a>
                    <a href="{{action('UsersController@edit', $user['id'])}}"><button type="button" class="btn btn-light"><i class="fas fa-pen"></i> Actualizar usuario</button></a>
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#delete_user_confirmation"><i class="fas fa-trash"></i> Eliminar usuario</button>
                    @endif
                </div>
                @endif
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger border-left-danger" role="alert">
                            <ul class="pl-4 my-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(isset($user))
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">Información del colaborador</div>
                        <div class="card-body">
                            <div class="pl-lg-4 col-lg-12">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="name">Tienda</label>
                                            <input type="text" class="form-control form-control-user" name="name" value="{{ $user['store'] }}" disabled>
                                        </div>
                                    </div>                        
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="name">Nombres</label>
                                            <input type="text" class="form-control form-control-user" name="name" value="{{ $user['name'] }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="last_name">Apellidos</label>
                                            <input type="text" class="form-control form-control-user" name="last_name" value="{{ $user['last_name'] }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="email">Rol del usuario</label>
                                            <?php 
                                                $role = '';
                                                switch($user->type){
                                                    case 2:
                                                    $role = 'In store employee';
                                                    break;
                                                    default:
                                                    $role = 'Administrator';
                                                }
                                            ?>
                                            <input type="email" class="form-control form-control-user" name="email" value="{{ $role }}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">Evaluaciones realizadas</div>
                        <div class="card-body">
                            <div class="pl-lg-4 col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table id='regs_table'>
                                            <thead>
                                                <tr>
                                                    <th>Nombre formulario</th>
                                                    <th>Promedio conectar</th>
                                                    <th>Promedio enganchar</th>
                                                    <th>Promedio inspirar</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id='profile_table_body'></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="summary_container" style="visibility:hidden;" class="card shadow mb-4">
                        <div class="card-header py-3">Detalle por usuario</div>
                        <div class="card-body">
                            <div class="pl-lg-4 col-lg-12">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table id="users_summary_table">
                                            <thead>
                                                <tr>
                                                    <th>Usuario</th>
                                                    <th>Conectar</th>
                                                    <th>Enganchar</th>
                                                    <th>Inspirar</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="users_summary"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add_action_plan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    @if(Auth::user()->type == 2)
                        <h5 class="modal-title"><i class="fas fa-exclamation-circle"></i> Plan de acción</h5>
                    @else
                    <h5 class="modal-title"><i class="fas fa-exclamation-circle"></i> Registra o edita un plan de acción</h5>
                    @endif
                    
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('registers.store') }}" enctype="multipart/form-data" method="POST">
                        {{csrf_field()}}
                        <div class="form-group" style="width:100%; float:left; margin-right:4px;">
                            <label class="form-control-label" for="type">Puntos a destacar<span class="small text-danger">*</span></label>
                            <textarea id="highlights_txt" class="form-control form-control-user" name="highlights"></textarea>
                        </div>
                        <div class="form-group" style="width:100%; float:left; margin-right:4px;">
                            <label class="form-control-label" for="type">Puntos a mejorar<span class="small text-danger">*</span></label>
                            <textarea id="lowlights_txt" class="form-control form-control-user" name="lowlights"></textarea>
                        </div>
                        <input id="fields_txt" name="fields_txt" type="text" style="visibility:hidden; height:0px;"/>
                        <div class="form-group" style="width:100%; float:left; margin-right:4px;">
                        @if(Auth::user()->type == 5)
                        <button class="btn btn-info" type="submit"><i class="fas fa-pen"></i> Registrar</button></div>
                        @endif
                        </div>
                    </form>
                </div>
        </div>
    </div>
    <div class="modal fade" id="delete_user_confirmation2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-circle"></i> ..l¿Estás seguro?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                    Al eliminar el usuario <strong>se eliminarán también todos los contenidos dependientes del mismo</strong>. Esta acción <strong>no puede deshacerse</strong>.
                    </div>
                </div>
                @if(isset($user))
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal"><i class="fas fa-door-open"></i> Descartar</button>
                    <form action="{{action('UsersController@destroy', $user['id'])}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i> Estoy seguro, asumo mi responsabilidad</button></div>
                    </form>
                </div>
                @endif
        </div>
    </div>
    <div class="modal fade" id="add_action_plan2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-circle"></i> Registra o modifica un plan de acción para el usuario.</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form method="post">
                        {{csrf_field()}}
                        <div class="form-group" style="width:100%; float:left; margin-right:4px;">
                            <label class="form-control-label" for="type">Puntos a destacar<span class="small text-danger">*</span></label>
                            <textarea class="form-control form-control-user" name="highlights"></textarea>
                        </div>
                        <div class="form-group" style="width:100%; float:left; margin-right:4px;">
                            <label class="form-control-label" for="type">Puntos a mejorar<span class="small text-danger">*</span></label>
                            <textarea class="form-control form-control-user" name="highlights"></textarea>
                        </div>
                        <div class="form-group" style="width:100%; float:left; margin-right:4px;">
                        <button class="btn btn-info" type="submit"><i class="fas fa-pen"></i> Registrar</button></div>
                        </div>
                    </form>
                </div>
                @if(isset($user))
                <div class="modal-footer">
                    
                </div>
                @endif
        </div>
    </div>
<script>
     window.onload = function() {
        UserProfile.a_current_user = 
        <?php
            if(isset($user)){
                echo(json_encode($user)); 
            }else{
                echo("'empty'");
            }
        ?>;
        UserProfile.init( <?php echo(json_encode($registers)); ?> );
        FiltersUtils.a_evaluations = ( <?php echo(json_encode($registers)); ?> );
        FiltersUtils.init(<?php echo(json_encode($geo_data)); ?>);
     };
</script>
@endsection
