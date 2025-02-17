@extends('layouts.admin')

@section('main-content')

    <!-- Page Heading -->
    <?php
    $original_email = '';
    $query_string='?p=1';
    if(isset($_GET['user_id'])){
        $query_string='user_id='.$_GET['user_id'];
    }
    
    $title = 'Registros';
    $description = 'Un registro se compone de múltiples campos pertenecientes a un formulario de un sistema.';
    $label = 'registro';
    $plural_label = 'registros';
    $user = Auth::user();
    ?>
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-building"></i> {{ $title }}</h1>
    <input id="lara_token" type="hidden" name="_token" value="{{ csrf_token() }}" />

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
                        @if(isset($_GET['user_id']))
                            <a href="{{action('UsersController@show', $_GET['user_id'])}}"><button type="button" class="btn btn-light"><i class="fas fa-user"></i> Ver usuario</button></a>
                            @if($user->type!=2)
                            <a href="/registers"><button type="button" class="btn btn-light"><i class="fas fa-search"></i> Buscar todos los registros</button></a>
                            @endif
                        </a>
                        @endif
                        @if($user->type!=2)
                        <button onclick="ReportBuilder.init()" type="button" class="btn btn-light"><i class="fas fa-download"></i> Descargar reporte.</button>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <h2>Encuentra {{ $plural_label }}</h2>
                    <p>{{ $description }}</p>
                    <div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="form-control-label" for="id_system">Sistema<span class="small text-danger">*</span></label>
                                <select id="systems_combo" class="form-control form-control-user" name="id_system" required autofocus>
                                    <option>Seleccione una opción</option>
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
                                @if(isset($_GET['user_id']))
                                <a id="regs_link" href="">
                                    <button id="search_registers_btn" style="width:100%; float:left; margin-right:5px;" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-search"></i> Buscar evaluaciones de {{ $_GET['email'] }}
                                    </button>
                                </a>
                                <a id="regs_link" href="">
                                    <button id="regs_link_button" style="width:0%; float:left; visibility:hidden;" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-search"></i> Buscar evaluaciones de mis usuarios..
                                    </button>
                                </a>
                                <br/>
                                @else
                                @if($user->type!=2)
                                <a id="regs_link" href="#">
                                    <button id="regs_link_button" class="btn btn-primary btn-user btn-block">
                                    <i class="fas fa-search"></i> Buscar evaluaciones de mis usuarios
                                    </button>
                                </a>
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="border-top my-3"></div>
                        @if(isset($fields))
                        <div class="border-top my-3"></div>
                        <?php 
                            $heads_count = count($fields)-4;
                            $fields_count = 0; 
                        ?>
                        @if($user->type != 2)
                        <div class="row">
                            <div id="charts_container" class="col-lg-12 mb-4">
                                <div class="card col-lg-12 shadow mb-4" style="float:left;">
                                    <div class="btn btn-primary btn-user btn-block"> Distribución de respuestas por pregunta </div>
                                    <div id="stacked_container" style="width:100%; height:400px;"></div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <table id="regs_table">
                            <thead>
                                <tr>
                                    <th>Código {{ $label }}</th>
                                    <th>Creado en</th>
                                    <th>Actualizado en</th>
                                    @foreach($fields as $field)
                                        @if($field->type_field !='text_area')
                                            @if( json_decode($field->settings_field)->type != 'title' )
                                                <th>{{$field->name_field}}</th>
                                            @endif
                                            @else
                                            <th>{{$field->name_field}}</th>
                                        @endif
                                    @endforeach
                                    @if($user->type != 2)
                                    <th>Acciones</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($registers as $register)
                                <tr>
                                    <td>{{$register->id_register}}</td>
                                    <td>{{$register->created_at}}</td>
                                    <td>{{$register->updated_at}}</td>
                                    @foreach($fields as $field)
                                        @foreach($register->values as $value)
                                            <?php 
                                            $store='';
                                            $uid='';
                                            ?>
                                            @if( $field->id_field == $value->id_field )
                                                @if( $field->type_field !='text_area' )
                                                    @if( json_decode($field->settings_field)->type != 'title' )
                                                    <?php 
                                                        $fields_count++;
                                                        if($field->name_field === 'Usuario a evaluar' || $field->name_field === 'Usuário a avaliar'){
                                                            $original_email = $value->value_register;
                                                            $value->value_register = str_replace("_"," ",$value->value_register);
                                                            $value->value_register = strtoupper(str_replace("@domain.com"," ",$value->value_register));
                                                        }
                                                        if($field->name_field === 'Tienda'){
                                                            $store = $value->value_register;
                                                        }
                                                    ?>
                                                        @if($field->type_field == 'image')
                                                        <td style="text-align:center">
                                                            <img height="50" src="/storage/registers/{{$value->value_register}}"></img>
                                                            <br/>/storage/registers/{{$value->value_register}}
                                                        </td>
                                                        @else
                                                            @if($field->type_field == 'file')
                                                            <td style="text-align:left">
                                                            <a href="/storage/registers/{{$value->value_register}}" target="_blank" download><button type="button" class="btn btn-primary"><i class="fas fa-download"></i></button></a>
                                                            </td>
                                                            @else
                                                            <td>{{$value->value_register}}</td>
                                                            @endif
                                                        @endif
                                                    @endif
                                                @else
                                                <td>{{ preg_replace( "/(\r|\n)/", "", strip_tags(str_replace(',','',$value->value_register)) ) }}</td>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endforeach
                                    <?php
                                        if($fields[0]->id_form != 95){
                                            $store_ask = App\Users::where('email', $original_email)->first();
                                            if(isset($store_ask->id)){
                                                $uid = $store_ask->id;
                                                $store = $store_ask->store;
                                                for($i=0; $i<($heads_count-$fields_count)-1;$i++){
                                                    if($fields[0]->id_form >= 83){
                                                        if($i === ($heads_count-$fields_count)-1){
                                                            echo('<td>'.$store.'</td>');
                                                        }
                                                    }else{
                                                        if($i === ($heads_count-$fields_count)-2){
                                                            echo('<td>'.$store.'</td>');
                                                        } else{
                                                            echo('<td>Pendiente por diligenciar</td>');
                                                        }
                                                    }
                                                }
                                                $fields_count = 0;
                                            }
                                        }
                                    ?>
                                    @if($user->type != 2)
                                    <td><a href="{{action('RegistersController@show', $register->id_register)}}{{$query_string}}&email={{$original_email}}&store={{$store}}&user_id={{$uid}}"><button type="button" class="btn btn-primary"><i class="fas fa-info-circle"></i></button></a></td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <div id="records_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 id="modal_title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="modal_body" class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
            </div>
            </div>
        </div>
        </div>
    <script>
     window.onload = function() {
        CreateFieldView.a_systems = <?php echo($systems); ?>;
        @if(isset($registers))
        Registers.a_registers = <?php echo( $registers ); ?>;
        DataTablesUtils.init('regs_table', false);
        @endif
        @if(isset($fields))
        Registers.a_titles = <?php echo( json_encode($fields) ); ?>;
        @endif
        @if(isset($current_system))
        Registers.a_current_system_id = <?php echo($current_system['id_system']); ?>;
        Registers.a_current_form_id = <?php echo($current_form['id_form']); ?>;
        @endif
        Registers.init();
     };
    </script>
@endsection
