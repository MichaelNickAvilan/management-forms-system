@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <?php
    $query_string='';
    $title = 'Evaluación';
    $description = '';
    $label = 'registro';
    $plural_label = 'registros';
    $user = Auth::user();
    ?>
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-building"></i> {{ $title }}</h1>

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
                    @if(isset($_GET['user_id']))
                    <a href="{{action('UsersController@show', $_GET['user_id'])}}"><button type="button" class="btn btn-light"><i class="fas fa-user"></i> {{ strtoupper(str_replace("@domain.com", " ", str_replace("_", " ", $_GET['email']))); }}</button></a>
                    @endif
                    <!--<a href="{{ route('registers.index') }}{{$query_string}}"><button type="button" class="btn btn-light"><i class="fas fa-table"></i> Gestionar {{ $plural_label }}</button></a>
                    <a href="{{ route('registers.create') }}{{$query_string}}"><button type="button" class="btn btn-light active"><i class="fas fa-plus-circle"></i> Crear {{ $label }}</button></a>-->
                </div>
                </div>
                <div class="card-body">
                    <h2>{{ $title }}</h2>
                    <p>{{ $description }}</p>
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
                            @if($user->type == 5)
                            <div class="form-group" style="visibility:hidden;height:0px;">
                            @else
                            <div class="form-group">
                            @endif
                                @if($user->type != 5)
                                <label class="form-control-label" for="id_system">Sistema<span class="small text-danger">*</span></label>
                                @endif
                                @if($user->type == 5)
                                <select id="systems_combo" class="form-control form-control-user" name="id_system" required autofocus style="visibility:hidden;height:0px;">
                                @else
                                <select id="systems_combo" class="form-control form-control-user" name="id_system" required autofocus>
                                @endif
                                    <option value="">Seleccione una opción</option>
                                    @foreach($systems as $system)
                                        <option value="{{ $system['id_system']}}">{{ $system['name_system'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if($user->type == 5)
                            <div class="form-group" style="visibility:hidden;height:0px;">
                            @else
                            <div class="form-group">
                            @endif
                                @if($user->type == 5)
                                <select id="forms_combo" class="form-control form-control-user" name="id_form" required autofocus>
                                @else
                                <select id="forms_combo" class="form-control form-control-user" name="id_form" required autofocus>
                                @endif
                                    <option value="">Seleccione una opción</option>
                                </select>
                            </div>
                            <div id="fields_container" ></div>
                            <div class="form-group">
                                <button id="submit_btn" type="submit" class="btn btn-primary btn-user btn-block">
                                <i class="fas fa-save"></i> Crear {{ $label }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
    window.onload = function() {
        let store = '<?php echo($user['store']); ?>';
        let store_type = store.split(' - ')[0];
        console.log(store_type);
        CreateFieldView.a_systems = <?php echo($systems); ?>;
        Registers.init();
        var systems_combo = document.getElementById('systems_combo');
        var forms_combo = document.getElementById('forms_combo');
        if(systems_combo.options.length === 2){
            systems_combo.selectedIndex = 1;
            CreateFieldView.systemSelected();
            Array.from(forms_combo.options).forEach((option, index)=>{
                if(option.textContent.indexOf(store_type)>=0){
                    forms_combo.selectedIndex = index;
                    Registers.formSelected();
                }
            });
        }
        const querystring = window.location.search
        const params = new URLSearchParams(querystring)
        if(params.get('type') === 'auto'){
            let submit_btn = document.getElementById('submit_btn');
            submit_btn.click();
        }
    };
    </script>
@endsection