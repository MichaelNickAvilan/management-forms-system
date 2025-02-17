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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-light active"><i class="fas fa-table"></i> Gestionar campos</button>
                        <a href="{{ route('fields.create') }}"><button type="button" class="btn btn-light"><i class="fas fa-plus-circle"></i> Crear campo</button></a>
                    </div>
                </div>
                <div class="card-body">
                    <h2>Listado de campos</h2>
                    <p>En esta sección podrás gestionar los campos asociados a un formulario.</p>
                    <table id="regs_table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Sistema</th>
                                <th>Formulario</th>
                                <th>Campo</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fields as $field)
                            <tr>
                                <td>{{$field->id_field}}</td>
                                <td>{{$field->system->name_system}}</td>
                                <td>{{$field->form->name_form}}</td>
                                <td>{{$field->name_field}}</td>
                                </td>
                                <td><a href="{{action('FieldsController@show', $field['id_field'])}}"><button type="button" class="btn btn-primary"><i class="fas fa-info-circle"></i></button></a></td>
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
        DataTablesUtils.init('regs_table');
     };
    </script>
@endsection
