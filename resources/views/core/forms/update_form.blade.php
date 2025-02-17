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
                    <h2>Actualizar un formulario</h2>
                    <p>En esta sección podrás editar los detalles del formulario seleccionado.</p>
                    @if ($errors->any())
                        <div class="alert alert-danger border-left-danger" role="alert">
                            <ul class="pl-4 my-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('forms.update', $id) }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="_method" type="hidden" value="PATCH">
                            <div class="form-group">
                                <label class="form-control-label" for="name_form">Sistema<span class="small text-danger">*</span></label>
                                <select class="form-control form-control-user" name="id_system" required autofocus>
                                    @foreach($systems as $system)
                                        @if($system['id_system'] === $form['id_system'])
                                        <option value="{{ $system['id_system']}}" selected>{{ $system['name_system'] }}</option>
                                        @else
                                            <option value="{{ $system['id_system']}}">{{ $system['name_system'] }}</option>
                                        @endif

                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="name_form">Nombre del formulario<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="name_form" placeholder="{{ __('Digite el nombre del formulario') }}" value="{{ $form['name_form'] }}" required autofocus>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="description_form">Descripción del formulario<span class="small text-danger">*</span></label>
                               <textarea class="form-control form-control-user" name="description_form" placeholder="{{ __('Digite la descripción del formulario') }}" required autofocus>{{ $form['description_form'] }}</textarea>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-save"></i> {{ __('Actualizar formulario') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
