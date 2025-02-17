@extends('layouts.admin')

@section('main-content')
    <?php
        $query_string='';
        $title = 'Registros';
        $description = 'Un registro se compone de múltiples campos pertenecientes a un formulario de un sistema.';
        $label = 'registro';
        $plural_label = 'registros';
        $user = Auth::user();
    ?>

    <!-- Page Heading -->
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
                    <a href="{{action('UsersController@show', $_GET['user_id'])}}"><button type="button" class="btn btn-light"><i class="fas fa-user"></i> Ver usuario</button></a>
                    @endif
                    @if(Auth::user()->type == 1)
                    <a href="{{ route('registers.create') }}{{$query_string}}"><button type="button" class="btn btn-light"><i class="fas fa-plus-circle"></i> Crear {{ $label }}</button></a>
                    @endif
                </div>
                </div>
                <div class="card-body">
                    <h2>Perfil del {{ $label }} con ID: {{ $register->id_register }}</h2>
                    <p>Creado en: {{ $register->created_at }}</p>
                    <p>Actualizado en:  {{ $register->updated_at }}</p>
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

                    <div>
                        <div id="fields_container"></div>
                        <div class="form-group">
                            <a href="{{action('RegistersController@edit', $register->id_register)}}?{{$_SERVER['QUERY_STRING']}}"><button style="width:49%; float:left; margin-right:2px;" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-pen"></i> Actualizar {{ $label }}
                            </button></a>
                            <a href="#">
                            <button type="button" data-toggle="modal" data-target="#delete_register_confirmation" style="width:49%;" class="btn btn-danger btn-user btn-block">
                            <i class="fas fa-trash"></i> Eliminar {{ $label }}
                            </button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="delete_register_confirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-exclamation-circle"></i> ¿Estás seguro?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" role="alert">
                Al eliminar el registro sus datos no estarán disponibles nuevamente<strong>. Esta acción <strong>no puede deshacerse</strong>.
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal"><i class="fas fa-door-open"></i> Descartar</button>
                <form action="{{action('RegistersController@destroy', $register->id_register)}}" method="post">
                    {{csrf_field()}}
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit"><i class="fas fa-trash"></i> Estoy seguro, asumo mi responsabilidad</button></div>
                </form>
            </div>
    </div>
</div>
<script>
    window.onload = function() {
        CreateFieldView.a_systems = [ <?php echo($system); ?> ];
        Registers.a_registers = [ <?php echo($register); ?> ];
        Registers.a_form = <?php echo($form); ?>;
        for(var i=0;i<Registers.a_form.fields.length;i++){
            let settings_field = JSON.parse(Registers.a_form.fields[i].settings_field);
            if(settings_field.type != 'title'){
                for(var j=0;j<Registers.a_registers[0].values.length;j++){
                    if(Registers.a_registers[0].values[j].id_field == Registers.a_form.fields[i].id_field){
                        Registers.a_form.fields[i]['value'] = Registers.a_registers[0].values[j];
                    }
                }
            }
        }
        Registers.init();
    };
</script>
@endsection
