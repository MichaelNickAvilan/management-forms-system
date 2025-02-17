@extends('layouts.publicheader')
    @section('main-content')
    <main class="main-root">
        <div id="dsn-scrollbar">
            <div class="main-content">

                <!-- ========== Header Normal ========== -->

                <header
                    class="header-page over-hidden p-relative">
                </header>
                <!-- ========== End Header Normal ========== -->


                <div class="wrapper">
                    <div class="container root-contact">
                        <div class="box-contact-inner section-margin">
                            @if(Session::has('message'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{{ Session::get('message') }} <button id="close_btn" class="close-button">X</button></li>
                                </ul>
                            </div>
                             @endif
                            <div class="row align-items-center">
                                <div class="col-lg-7">
                                    <div class="form-box">
                                        <div class="line line-top"></div>
                                        <div class="line line-bottom"></div>
                                        <div class="line line-left"></div>
                                        <div class="line line-right"></div>
                                        <div class="mb-30 d-flex text-left flex-column align-items-start">
                                            <p class="sub-heading line-shap line-shap-before mb-15">
                                                @if(isset($job))
                                                <span class="line-bg-right">{{ $forms[0]->registers[0]->values[9]->value_register }}</span>
                                                @else
                                                <span class="line-bg-right">{{ $forms[0]->registers[0]->values[3]->value_register }}</span>
                                                @endif
                                            </p>
                                            @if(isset($job))
                                            <h2 class="section-title  title-cap">
                                                {{ $job[0]->value_register }}
                                            </h2>
                                            @endif
                                        </div>
                                        @if(isset($job))
                                        <p class="mb-30">{!! $job[2]->value_register !!}</p><br/>
                                        @endif
                                        <form class="form"
                                        method="POST" action="{{ route('jobapply.store') }}"
                                        enctype="multipart/form-data"
                                            data-toggle="validator">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="id_form" value="{{ $fields[0]->id_form }}">
                                            <input type="hidden" name="external" value="true">
                                            <div class="messages"></div>
                                            <div class="input__wrap controls">
                                                @foreach($fields as $field)
                                                <div class="form-group">
                                                    <div class="entry-box">
                                                        @switch($field->type_field)
                                                            @case('text')
                                                                @if($field->id_field!=55)
                                                                    <label>{{ $field->name_field }} *</label>
                                                                    <input id="{{ $field->id_field }}_text" type="text" name="{{ $field->id_field }}_text"
                                                                    required="required"
                                                                    data-error="campo requerido.">
                                                                @else
                                                                    @if(isset($job))
                                                                    <input id="{{ $field->id_field }}_text" type="hidden" name="{{ $field->id_field }}_text"
                                                                    required="required" value="{{ $job[0]->value_register }}"
                                                                    data-error="campo requerido.">
                                                                    @endif
                                                                @endif

                                                            @break
                                                            @case('number')
                                                                <label>{{ $field->name_field }} *</label>
                                                                <input id="{{ $field->id_field }}_number" type="number" name="{{ $field->id_field }}_number"
                                                                required="required"
                                                                data-error="campo requerido.">
                                                            @break
                                                            @case('file')
                                                                <label>{{ $field->name_field }} *</label>
                                                                <input id="{{ $field->id_field }}_image" type="file" name="{{ $field->id_field }}_file"
                                                                required="required"
                                                                data-error="campo requerido.">
                                                            @break
                                                            @case('text_area')
                                                                <label>{{ $field->name_field }} *</label>
                                                                <textarea id="{{ $field->id_field }}_text_area" tname="{{ $field->id_field }}_text_area"
                                                                required="required"
                                                                data-error="campo requerido."></textarea>
                                                            @break
                                                        @endswitch

                                                    </div>
                                                    <div class="help-block with-errors"></div>
                                                </div>
                                                @endforeach
                                                <div class="text-right">
                                                    <div class="image-zoom w-auto d-inline-block" data-dsn="parallax">
                                                        <button type="submit" class="dsn-button ">
                                                            <span class="dsn-border border-color-default"></span>
                                                            <span class="text-button">Aplicar</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-lg-5">
                                    <div class="box-info-contact">

                                        <ul>
                                            @foreach($helpers[1]->registers as $register)
                                            <li>
                                                <h5 class="title-block mb-15">{{ $register->values[0]->value_register }}</h5>
                                                <p class="text-p">{{ $register->values[1]->value_register }}</p>
                                            </li>
                                            @endforeach
                                            @foreach($helpers[1]->registers as $register)
                                            <li>
                                                <p class="text-p ">{{ $register->values[2]->value_register }}</p>
                                                <div class="over-hidden mt-5">
                                                    <a href="mailto:{{ $register->values[3]->value_register }}" data-hover-text="{{ $register->values[3]->value_register }}" class="link-hover">{{ $register->values[3]->value_register }}</a>
                                                </div>

                                            </li>
                                            @endforeach
                                            <li>
                                                <h5 class="title-block mb-15">Síguenos en</h5>
                                                @foreach($helpers[2]->registers as $register)
                                                <div class="social-item over-hidden">
                                                    <a class="link-hover" data-hover-text="{{ $register->values[0]->value_register }}" href="{{ $register->values[1]->value_register }}"
                                                        target="_blank" rel="nofollow">{{ $register->values[0]->value_register }}</a>
                                                </div>
                                                @endforeach
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    (function(){
                        var btn = document.getElementById('close_btn');
                        if(btn!=null && btn!=undefined){
                            btn.addEventListener('click', function(e){
                                var container = e.target.parentNode.parentNode.parentNode.parentNode;
                                var al = e.target.parentNode.parentNode.parentNode;
                                container.removeChild(al);
                            });
                        }
                    })();
                </script>
                @endsection
