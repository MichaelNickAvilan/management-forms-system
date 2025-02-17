@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-building"></i> {{ __('Compañías') }}</h1>

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
                    <a href="{{ route('companies.index') }}"><button type="button" class="btn btn-light"><i class="fas fa-table"></i> Gestionar compañías</button></a>
                    <a href="{{ route('companies.create') }}"><button type="button" class="btn btn-light active"><i class="fas fa-plus-circle"></i> Crear compañía</button></a>
                    <a href="{{ route('companies.show', $id) }}"><button type="button" class="btn btn-light"><i class="fas fa-info-circle"></i> Ver perfil</button></a>
                </div>
                </div>
                <div class="card-body">
                    <h2>Actualizar una compañía</h2>
                    <p>En esta sección podrás editar cualquier detalle de la comañía seleccionada.</p>
                    @if ($errors->any())
                        <div class="alert alert-danger border-left-danger" role="alert">
                            <ul class="pl-4 my-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('companies.update', $id) }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="_method" type="hidden" value="PATCH">
                            <div class="form-group">
                                <label class="form-control-label" for="name_company">Nombre de la compañía<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="name_company" placeholder="{{ __('Digite el nombre de la compañía') }}" value="{{ $company['name_company'] }}" required autofocus>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="company_logo">Logo de la compañía<span class="small text-danger">*</span></label>
                                <img style="height:50px;" src="/storage/companies/{{$company['company_logo']}}"/>
                                <input type="file" class="form-control form-control-user" name="company_logo"/>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-pen"></i> {{ __('Actualizar compañía') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
