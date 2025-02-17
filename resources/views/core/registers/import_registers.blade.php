@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-building"></i> {{ __('Registros') }}</h1>

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
                <a href="{{ route('registers.index') }}"><button type="button" class="btn btn-light"><i class="fas fa-table"></i> Gestionar registros</button></a>
                    <a href="{{ route('registers.create') }}"><button type="button" class="btn btn-light active"><i class="fas fa-plus-circle"></i> Crear registro</button></a>
                </div>
                </div>
                <div class="card-body">
                    <h2>Selecciona el archivo con los registros a importar</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger border-left-danger" role="alert">
                            <ul class="pl-4 my-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('registers.store') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <input type="hidden" id="type" name="type" value="massive_replacement">
                                <input type="file" class="form-control form-control-user" name="massive_file_import" required="" autofocus="">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-save"></i> {{ __('Importar registros') }}
                                </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    window.onload = function() {
    };
    </script>
@endsection
