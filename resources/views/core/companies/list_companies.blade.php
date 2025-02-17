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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-light active"><i class="fas fa-table"></i> Gestionar compañías</button>
                        <a href="{{ route('companies.create') }}"><button type="button" class="btn btn-light"><i class="fas fa-plus-circle"></i> Crear compañía</button></a>
                    </div>
                </div>
                <div class="card-body">
                    <h2>Listado de compañías</h2>
                    <p>En esta sección podrás gestionar las compañías existentes en el sistema.</p>
                    <table id="regs_table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Logo</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $company)
                            <tr>
                                <td>{{$company['name_company']}}</td>
                                <td><img style="height:30px;" src="storage/companies/{{$company['company_logo']}}"/></td>
                                </td>
                                <td><a href="{{action('CompaniesController@show', $company['id_company'])}}"><button type="button" class="btn btn-primary"><i class="fas fa-info-circle"></i></button></a></td>
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
        DataTablesUtils.init('regs_table', false);
     };
    </script>
@endsection
