@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-building"></i> {{ __('Campos') }}</h1>

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

            <!-- Approach -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('fields.index') }}"><button type="button" class="btn btn-light"><i class="fas fa-table"></i> Gestionar campos</button></a>
                    <a href="{{ route('fields.create') }}"><button type="button" class="btn btn-light"><i class="fas fa-plus-circle"></i> Crear campo</button></a>
                </div>
                </div>
                <div class="card-body">
                    <h2>Detalles del campo</h2>
                    <p>Un campo pertenece a un formulario y es la base para la recolección de registros.</p>
                    @if ($errors->any())
                        <div class="alert alert-danger border-left-danger" role="alert">
                            <ul class="pl-4 my-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div>
                            <div class="form-group">
                                <label class="form-control-label" for="id_system">Sistema<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="name_system" value="{{ $system['name_system'] }}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="id_form">Formulario<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="form_name" value="{{ $form['name_form'] }}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="type_field">Tipo de campo<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="type_field" value="{{ $field['type_field'] }}" disabled>

                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="name_field">Nombre del campo<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="name_field" placeholder="{{ __('Digite el nombre del campo') }}" value="{{ $field['name_field'] }}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="description_field">Descripción del campo<span class="small text-danger">*</span></label>
                               <textarea class="form-control form-control-user" name="description_field" placeholder="{{ __('Digite la descripción del campo.') }}" value="{{ old('name') }}" disabled>{{$field['description_field']}}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="settings_field">Configuración del campo<span class="small text-danger">*</span></label>
                                <textarea class="form-control form-control-user" name="settings_field" placeholder="{{ __('Ingrese un objeto JSON con la configuración del campo') }}" value="{{ $field['settings_field'] }}" disabled>{{ $field['settings_field'] }}</textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="position_field">Posición del campo<span class="small text-danger">*</span></label>
                                <input type="number" class="form-control form-control-user" name="position_field" placeholder="{{ __('Digite la posición del campo en el formulario') }}" value="{{$field['position_field']}}" disabled>
                            </div>
                            <div class="form-group">
                                <a href="{{action('FieldsController@edit', $id)}}"><button style="width:49%; float:left; margin-right:2px;" class="btn btn-primary btn-user btn-block">
                                <i class="fas fa-pen"></i> {{ __('Actualizar campo') }}
                                </button></a>
                                <a href="#">
                                <button type="button" data-toggle="modal" data-target="#delete_field_confirmation" style="width:49%;" class="btn btn-danger btn-user btn-block">
                                <i class="fas fa-trash"></i> {{ __('Eliminar campo') }}
                                </button></a>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- Modal -->
     <div class="modal fade" id="delete_field_confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-circle"></i> ¿Estás seguro?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                    Al eliminar el campo <strong>se eliminarán también todos los registros asociados</strong>. Esta acción <strong>no puede deshacerse</strong>.
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal"><i class="fas fa-door-open"></i> Descartar</button>
                    <form action="{{action('FieldsController@destroy', $id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i> Estoy seguro, asumo mi responsabilidad</button></div>
                    </form>
                </div>
        </div>
    </div>
@endsection
