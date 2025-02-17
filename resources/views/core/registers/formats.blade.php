@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-building"></i> {{ __('Formatos') }}</h1>

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
                <div class="card-body">
                    <p>Encuentra en esta sección el listado de formatos internos de la compañía.</p>
                    <table id="formats_table">
                        <thead>
                            <tr>
                                <th>Área</th>
                                <th>Nombre del formato</th>
                                <th>Formato</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($formats as $format)
                        <tr>
                            @foreach($format->values as $value)
                                @if($loop->index==2)
                                <td><a href="/storage/registers/{{$value->value_register}}" target="_blank" download><button type="button" class="btn btn-primary"><i class="fas fa-download"></i></button></a></td>
                                @else
                                <td>{{$value->value_register}}</td>
                                @endif
                            @endforeach
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
        DataTablesUtils.init('formats_table');
    };
    </script>
@endsection
