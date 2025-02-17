@extends('layouts.admin')

@section('main-content')
    <?php
        $user = Auth::user();
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
                    <a href="{{ route('registers.index') }}{{$query_string}}"><button type="button" class="btn btn-light"><i class="fas fa-table"></i> Gestionar {{ $plural_label }}</button></a>
                    @if(Auth::user()->type == 1)
                    <!-- <a href="{{ route('registers.create') }}{{$query_string}}"><button type="button" class="btn btn-light"><i class="fas fa-plus-circle"></i> Crear {{ $label }}</button></a> -->
                    @endif
                </div>
                </div>
                <div class="card-body">
                    <h2>Actualizar {{ $label }}</h2>
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
                    <form method="POST" action="{{ route('registers.update', $register->id_register) }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input name="_method" type="hidden" value="PATCH">
                        <div id="fields_container"></div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                            <i class="fas fa-pen"></i> Actualizar {{ $label }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    window.onload = function() {
        CreateFieldView.a_systems = [ <?php echo($system); ?> ];
        Registers.a_registers = [ <?php echo($register); ?> ];
        Registers.a_form = <?php echo($form); ?>;
        for(var i=0;i<Registers.a_form.fields.length;i++){
            for(var j=0;j<Registers.a_registers[0].values.length;j++){
                if(Registers.a_registers[0].values[j].id_field == Registers.a_form.fields[i].id_field){
                    Registers.a_form.fields[i]['value'] = Registers.a_registers[0].values[j];
                }
            }
        }
        Registers.init();
    };
</script>
@endsection
