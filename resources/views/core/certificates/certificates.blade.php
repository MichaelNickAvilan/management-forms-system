@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-building"></i> {{ __('Mis certificados') }}</h1>

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
                </div>
                <div class="card-body">
                    <h2>Encuentra tus certificados</h2>
                    <p>Diligencia el formulario para descargar el certificado que deseas.</p>
                    @if ($errors->any())
                        <div class="alert alert-danger border-left-danger" role="alert">
                            <ul class="pl-4 my-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('certificados.store') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-control-label" for="name_company">Selecciona el tipo de certificado<span class="small text-danger">*</span></label>
                                <select id="certType_combo" class="form-control form-control-user" name="certType" required autofocus>
                                    <option value="">Seleccione una opción</option>
                                    <option value="CERTLAB">Certificado laboral</option>
                                    <option value="retefuente">Certificado de ingresos y retenciones</option>
                                    <option value="desprendible">Desprendible de nómina</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label" for="year">Selecciona un año<span class="small text-danger">*</span></label>
                                <select id="year" class="form-control form-control-user" name="year" autofocus>
                                    <option value="">Seleccione una opción</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                </select>
                            </div>
                            <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-search"></i> {{ __('Buscar documentos') }}
                            </button>
                        </div>
                    </form>
                </div>
                @if( isset($certificates) )
                        @if(count($certificates)>0)
                            <script>
                            gtag('event', 'certificates_search', {
                            'event_category': 'certificates_search_result_'+'{{$cert_type}}',
                            'event_label':
                            <?php
                            $user = Auth::user();
                            echo("'year: ".$certificates[0]->year.
                            " | name: ".$user->name)." | id: ".$user->id."'";
                            ?>,
                            });
                            </script>
                            @endif
                <div class="card-body">
                    <h2>Listado de certificados</h2>
                    <table id="regs_table">
                        <thead>
                            <tr>
                                <th>Año</th>
                                <th>Periodo</th>
                                <th>Mes</th>
                                <th>Documento.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificates as $cert)
                            <tr>
                                <td>{{$cert->year}}</td>
                                <td>{{$cert->month}}</td>
                                <td>{{$cert->period}}</td>
                                <td>
                                    <a href="{{$cert->document}}" target="_blank" download>
                                        <button type="button" class="btn btn-primary"><i class="fas fa-file-download"></i></button>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

        </div>
    </div>
    <script>
     window.onload = function() {
        DataTablesUtils.init('regs_table');
        populateYears();
     };
     function populateYears(){
         var currentYear = new Date().getFullYear();
         var opns='<option value="">Seleccione una opción</option>';
         for(var i=currentYear;i>(currentYear-3);i--){
             opns+='<option value="'+i+'">'+i+'</option>';
         }
         var el = document.getElementById('year');
         el.innerHTML=opns;
     }
    </script>
@endsection
