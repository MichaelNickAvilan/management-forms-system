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
                    <a href="{{ route('fields.create') }}"><button type="button" class="btn btn-light active"><i class="fas fa-plus-circle"></i> Crear campo</button></a>
                </div>
                </div>
                <div class="card-body">
                    <h2>Registra un campo</h2>
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

                    <form method="POST" action="{{ route('fields.store') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-control-label" for="id_system">Sistema<span class="small text-danger">*</span></label>
                                <select id="systems_combo" class="form-control form-control-user" name="id_system" required autofocus>
                                    <option value="">Seleccione una opción</option>
                                    @foreach($systems as $system)
                                        <option value="{{ $system['id_system']}}">{{ $system['name_system'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="id_form">Formulario<span class="small text-danger">*</span></label>
                                <select id="forms_combo" class="form-control form-control-user" name="id_form" required autofocus>
                                    <option value="">Seleccione una opción</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="type_field">Tipo de campo<span class="small text-danger">*</span></label>
                                <select id="fields_combo" class="form-control form-control-user" name="type_field" required autofocus>
                                    <option value="">Seleccione una opción</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type->value}}">{{ $type->label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="name_field">Nombre del campo<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="name_field" placeholder="{{ __('Digite el nombre del campo') }}" value="{{ old('name') }}" required autofocus>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="description_field">Descripción del campo<span class="small text-danger">*</span></label>
                               <textarea class="form-control form-control-user" name="description_field" placeholder="{{ __('Digite la descripción del campo.') }}" value="{{ old('name') }}" required autofocus></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="settings_field">Configuración del campo<span class="small text-danger">*</span></label>
                               <textarea class="form-control form-control-user" name="settings_field" placeholder="{{ __('Ingrese un objeto JSON con la configuración del campo') }}" value="{{ old('name') }}" required autofocus></textarea>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="position_field">Posición del campo<span class="small text-danger">*</span></label>
                                <input type="number" class="form-control form-control-user" name="position_field" placeholder="{{ __('Digite la posición del campo en el formulario') }}" value="{{ old('name') }}" required autofocus>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-save"></i> {{ __('Registrar un campo') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    window.onload = function() {
        CreateFieldView.a_systems = JSON.parse('<?php echo($systems); ?>');
    };
    </script>
@endsection
