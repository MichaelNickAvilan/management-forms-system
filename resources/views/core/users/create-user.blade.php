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
                    <a href="{{ route('users.create') }}"><button type="button" class="btn btn-light active"><i class="fas fa-plus-circle"></i> Crear usuario</button></a>
                </div>
                </div>
                <div class="card-body">
                    <h2>Registra un usuario</h2>
                    @if ($errors->any())
                        <div class="alert alert-danger border-left-danger" role="alert">
                            <ul class="pl-4 my-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="type">Rol<span class="small text-danger">*</span></label>
                                <select class="form-control form-control-user" name="type" required autofocus>
                                    <option value="">Seleccione una opción</option>
                                    <option value="2">Service agent / Cashier</option>
                                    <option value="3">Evaluador</option>
                                </select>
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="country">País del usuario<span class="small text-danger">*</span></label>
                                <select id="countries_combo" class="form-control form-control-user" name="country" required autofocus>
                                    <option value="">Seleccione una opción</option>
                                    @foreach ($countries as $country)
                                        @if($current_user->type == 5 && $current_user->country ==  $country->country->country)
                                            <option value="{{ $country->country->country }}">{{ $country->country->country }}</option>
                                        @elseif($current_user->type == 1)
                                            <option value="{{ $country->country->country }}">{{ $country->country->country }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="store">Código de la tienda<span class="small text-danger">*</span></label>
                                <select id="stores_combo" class="form-control form-control-user" name="store" required autofocus>
                                    <option value="">Seleccione una opción</option>
                                </select>
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="document">Identificación del usuario<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="document" placeholder="{{ __('Digite la identificación del usuario') }}" value="{{ old('document') }}" required autofocus>
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="name">Nombre del usuario<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="name" placeholder="{{ __('Digite el nombre del usuario') }}" value="{{ old('name') }}" required autofocus>
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="last_name">Apellidos del usuario<span class="small text-danger">*</span></label>
                                <input type="text" class="form-control form-control-user" name="last_name" placeholder="{{ __('Digite los apellidos del usuario') }}" value="{{ old('last_name') }}" required autofocus>
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="email">Correo del usuario<span class="small text-danger">*</span></label>
                                <input type="email" class="form-control form-control-user" name="email" placeholder="{{ __('Digite el correo del usuario') }}" value="{{ old('password') }}" required autofocus>
                            </div>
                            <div class="form-group" style="width:24%; float:left; margin-right:4px;">
                                <label class="form-control-label" for="password">Clave del usuario<span class="small text-danger">*</span></label>
                                <input type="password" class="form-control form-control-user" name="password" placeholder="{{ __('Digite el password del usuario') }}" value="{{ old('password') }}" required autofocus>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                <i class="fas fa-save"></i> {{ __('Registrar usuario') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <script>
        let CountrySelector = {
            a_current_user : <?php echo(json_encode($current_user)); ?>,
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
                        item.stores[0].forEach((store)=>{
                            if(CountrySelector.a_current_user.type == 5){
                                if(CountrySelector.a_current_user.store == store.store){
                                    options += '<option value="'+ store.store +'">'+ store.store +'</option>';
                                }
                            }else{
                                options += '<option value="'+ store.store +'">'+ store.store +'</option>';
                            }
                        });
                    }
                });
                stores_combo.innerHTML = options;
            }
        };
        CountrySelector.init();
    </script>
@endsection
