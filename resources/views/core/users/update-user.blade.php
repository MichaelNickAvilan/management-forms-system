@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-building"></i> {{ __('Sistemas') }}</h1>

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
                    <a href="{{ route('users.index') }}"><button type="button" class="btn btn-light"><i class="fas fa-table"></i> Gestionar usuarios</button></a>
                    @if(Auth::user()->type == 1)
                        <a href="{{ route('users.create') }}"><button type="button" class="btn btn-light"><i class="fas fa-plus-circle"></i> Crear usuario</button></a>
                        <!-- <a href="{{ route('users.create') }}?import=true"><button type="button" class="btn btn-light"><i class="fas fa-cloud-upload-alt"></i> Importar usuarios</button></a> -->
                    @endif
                </div>
                </div>
                <div class="card-body">
                    <h2>Actualizar usuario</h2>
                    <p>En esta sección podrás actualizar los detalles del usuario. Si no deseas cambiar el password del usuario, puedes dejar el campo en blanco.</p>
                    @if ($errors->any())
                        <div class="alert alert-danger border-left-danger" role="alert">
                            <ul class="pl-4 my-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.update', $user['id']) }}" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input name="_method" type="hidden" value="PATCH">
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="type">Rol<span class="small text-danger">*</span></label>
                                <select class="form-control form-control-user" name="type" required autofocus value="{{ $user['type'] }}">
                                <option value="">Seleccione una opción</option>
                                    <option value="2">Service agent / Cashier</option>
                                    <option value="3">Evaluador</option>
                                </select>
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="name">Nombres</label>
                                <input type="text" class="form-control form-control-user" name="name" placeholder="{{ __('Digite los nombres del usuario') }}" value="{{ $user['name'] }}" >
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="last_name">Apellidos</label>
                                <input type="text" class="form-control form-control-user" name="last_name" placeholder="{{ __('Digite los apellidos del usuario') }}" value="{{ $user['last_name'] }}" >
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="email">Correo del usuario<span class="small text-danger">*</span></label>
                                <input type="email" class="form-control form-control-user" name="email" placeholder="{{ __('Digite el correo del usuario') }}" value="{{ $user['email'] }}" required autofocus disabled>
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="password">Clave del usuario</label>
                                <input type="password" class="form-control form-control-user" name="password" placeholder="{{ __('Digite el password del usuario') }}" value="">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                <i class="fas fa-save"></i> {{ __('Actualizar usuario') }}
                            </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        let CountrySelector = {
            a_countries: <?php echo(json_encode($countries)); ?>,
            init:function(){
                CountrySelector.addListeners();
            },
            addListeners:function(){
                let countries_combo = document.getElementById('countries_combo');
                countries_combo.addEventListener('change', CountrySelector.countryChange);
            },
            countryChange:function(e){
                let stores_combo = document.getElementById('stores_combo');
                let options = '<option value="">Seleccione una opción</option>';
                let countries = CountrySelector.a_countries;
                countries.forEach((item)=>{
                    if(item.country.country === e.target.value ){
                        console.log(item.stores[0]);
                        item.stores[0].forEach((store)=>{
                            options += '<option value="'+ store.store +'">'+ store.store +'</option>';
                        });
                    }
                });
                stores_combo.innerHTML = options;
            }
        };
        CountrySelector.init();
    </script>
@endsection
