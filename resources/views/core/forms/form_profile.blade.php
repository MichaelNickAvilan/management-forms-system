@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-building"></i> {{ __('Formularios') }}</h1>

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
                <a href="{{ route('forms.index') }}"><button type="button" class="btn btn-light"><i class="fas fa-table"></i> Gestionar formularios</button></a>
                    <a href="{{ route('forms.create') }}"><button type="button" class="btn btn-light"><i class="fas fa-plus-circle"></i> Crear formulario</button></a>
                </div>
                </div>
                <div class="card-body">
                    <h2>Detalles del formulario</h2>
                    <p>En esta sección podrás ver los detalles del formulario seleccionado, también es posible continuar con su edición o también optar por su eliminación del sistema.</p>
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
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-control-label" for="name_form">Sistema<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="name_form" placeholder="{{ __('Digite el nombre del formulario') }}" value="{{$system['name_system']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="name_form">Nombre del formulario<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="name_form" placeholder="{{ __('Digite el nombre del formulario') }}" value="{{$form['name_form']}}" disabled>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="description_form">Descripción del formulario<span class="small text-danger">*</span></label>
                               <textarea class="form-control form-control-user" name="description_form" placeholder="{{ __('Digite la descripción del formulario') }}" value="{{ old('name') }}" disabled>{{$form['description_form']}}</textarea>
                            </div>
                            <div class="form-group">
                                <a href="{{action('FormsController@edit', $form['id_form'])}}"><button style="width:49%; float:left; margin-right:2px;" class="btn btn-primary btn-user btn-block">
                                <i class="fas fa-pen"></i> {{ __('Actualizar formulario') }}
                                </button></a>
                                <a href="#">
                                <button type="button" data-toggle="modal" data-target="#delete_form_confirmation" style="width:49%;" class="btn btn-danger btn-user btn-block">
                                <i class="fas fa-trash"></i> {{ __('Eliminar formulario') }}
                                </button></a>
                            </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="delete_form_confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-exclamation-circle"></i> ¿Estás seguro?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                    Al eliminar el sistema <strong>se eliminarán también todos los registros asociados</strong>. Esta acción <strong>no puede deshacerse</strong>.
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" data-dismiss="modal"><i class="fas fa-door-open"></i> Descartar</button>
                    <form action="{{action('FormsController@destroy', $id)}}" method="post">
                        {{csrf_field()}}
                        <input name="_method" type="hidden" value="DELETE">
                        <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i> Estoy seguro, asumo mi responsabilidad</button></div>
                    </form>
                </div>
        </div>
    </div>
@endsection
