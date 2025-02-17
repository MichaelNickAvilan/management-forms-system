@extends('layouts.publicheader')
    @section('main-content')
    <main class="main-root">

        <div id="dsn-scrollbar">
            <div class="main-content">
                <div class="wrapper">
                    <!-- ========== Slider Parallax ========== -->
                    <div class="main-slider has-horizontal full-width p-relative w-100 h-100-v">
                        <div class="content-slider p-relative w-100 h-100 over-hidden v-dark">
                            <div class="bg-container  dsn-hero-parallax-img p-relative w-100 h-100">
                                <div class="slide-inner dsn-webgl h-100" data-overlay="5"
                                    data-dsn-displacement="assets/img/displacement/8.jpg" data-dsn-intensity="-2"
                                    data-dsn-speedIn="1.2" data-dsn-easing="Expo.easeInOut" data-dsn-speedOut="1.2">

                                </div>
                            </div>

                            <div class="dsn-slider-content p-absolute h-100 w-100 v-dark-head">

                                <div class="dsn-container  d-flex align-items-end">
                                    <?php $counter = 0; ?>
                                    @foreach($forms[1]->registers as $register)
                                            <?php $centinel = FALSE; ?>
                                            @foreach($register->values as $value)
                                                @if($value->field == 'Álbum' && $value->value_register == urldecode($_GET["album"]))
                                                    <?php
                                                    $counter++;
                                                    $centinel = TRUE;
                                                    $currentRegister = $register;
                                                    ?>
                                                @endif
                                            @endforeach
                                            @if($centinel==TRUE)
                                            <?php
                                            $imagen = "";
                                            $titulo = "";
                                            $descripcion = "";
                                            ?>
                                            @foreach($currentRegister->values as $value)
                                                <?php
                                                switch($value->field){
                                                    case 'Imagen':
                                                        $imagen = $value->value_register;
                                                    break;
                                                    case 'Título':
                                                        $titulo = $value->value_register;
                                                    break;
                                                    case 'Descripción':
                                                        $descripcion = $value->value_register;
                                                    break;
                                                };
                                                ?>
                                                @endforeach
                                            <div class="slide-content p-absolute active"
                                            data-webgel-src="/storage/registers/{{ $imagen }}" data-overlay="4">
                                                <div class="content p-relative">
                                                    <div class="d-block"></div>
                                                    <h1 class="title user-no-selection d-inline-block ">
                                                        <a href="#" class="effect-ajax" data-dsn-ajax="slider">{{ $titulo }}</a>
                                                    </h1>
                                                    <hr class="mt-20" />
                                                    <p class="max-w570 mt-20 description ">{{ $descripcion }}</p>
                                                </div>
                                            </div>
                                            @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <div
                            class="control-nav dsn-load-animate p-absolute w-100 d-flex justify-content-end  dsn-container v-dark-head">
                            <div class="prev-container">
                                <div class="container-inner">
                                    <div class="triangle"></div>
                                    <svg class="circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                        <g class="circle-wrap" fill="none" stroke-width="1" stroke-linejoin="round"
                                            stroke-miterlimit="10">
                                            <circle cx="12" cy="12" r="10.5"></circle>
                                        </g>
                                    </svg>
                                </div>
                            </div>

                            <div class="slider-counter d-flex align-items-center">
                                <span class="slider-current-index">01</span>
                                <span class="slider-counter-delimiter"></span>
                                <span class="slider-total-index">{{ $counter }}</span>
                            </div>

                            <div class="next-container">
                                <div class="container-inner">
                                    <div class="triangle"></div>
                                    <svg class="circle" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24">
                                        <g class="circle-wrap" fill="none" stroke-width="1" stroke-linejoin="round"
                                            stroke-miterlimit="10">
                                            <circle cx="12" cy="12" r="10.5"></circle>
                                        </g>
                                    </svg>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- ========== End Slider Parallax ========== -->

                </div>
            </div>
        </div>
    </main>
    @endsection
