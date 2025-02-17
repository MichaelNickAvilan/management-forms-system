@extends('layouts.publicheader')
@section('main-content')
<main class="main-root">
    <div id="dsn-scrollbar">
        <div class="main-content">
            <!-- ========== Slider Parallax ========== -->
            <div class="main-slider full-width has-horizontal p-relative w-100 h-100-v dsn-header-animation">
                <div class="content-slider p-relative w-100 h-100 over-hidden v-dark-head">
                    <div class="bg-container  dsn-hero-parallax-img p-relative w-100 h-100">
                        <div class="slide-inner h-100">
                            <div class="swiper-wrapper">
                                @foreach($forms[3]->registers as $register)
                                <div class="slide-item swiper-slide over-hidden">
                                    <div class="image-bg cover-bg w-100 h-100 " data-overlay="6"
                                    data-swiper-parallax="85%" data-swiper-parallax-scale="1.1">
                                        <img class="cover-bg-img"
                                        src="/storage/registers/{{ $register->values[4]->value_register }}"
                                        data-dsn-src="/storage/registers/{{ $register->values[4]->value_register }}" alt="">
                                    </div>
                                    <div class="slide-content p-absolute ">
                                        <div class="content p-relative">
                                            <p class="max-w570 mb-15 description">
                                            {{ $register->values[0]->value_register }}
                                            </p>
                                            <div class="d-block"></div>
                                            <h1 class="title user-no-selection d-inline-block text-uppercase">
                                            {{ $register->values[1]->value_register }}
                                            </h1>
                                            <div class="d-block"></div>
                                            @if($register->values[2]->value_register != 'N/A')
                                            <a href="{{ $register->values[3]->value_register }}" target="_self" class="mt-30 dsn-button link-custom">
                                                <span class="dsn-border border-color-reverse-color"></span>
                                                {{ $register->values[2]->value_register }}
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                        </div>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                            <div class="dsn-slider-content p-absolute h-100 w-100 ">
                                <div class="dsn-container  d-flex align-items-center justify-content-center text-center">
                                </div>
                            </div>
                        </div>
                        <div class="control-nav p-absolute w-100 d-flex justify-content-center  dsn-container v-dark-head">
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
                        <span class="slider-total-index">05</span>
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
            <div class="wrapper">
                <!-- ========== Posts Section ========== -->
                <section class="work-section work-no-scale not-filter p-relative dsn-swiper over-hidden v-dark-head"
                data-dsn-option='{"slidesPerView":3,"autoplay":true,"centeredSlides":false}'>
                    <div class="swiper-container" data-swiper-autoplay="5000">
                        <div class="swiper-wrapper">
                            @foreach($forms[1]->registers as $register)
                            <a href="/post/{{ $register->values[3]->id_register }}"><div class="work-item  swiper-slide over-hidden">
                                <div class="box-img p-relative over-hidden" data-overlay="6">
                                    <img class="cover-bg-img" src="/storage/registers/{{ $register->values[4]->value_register }}" data-dsn-src="/storage/registers/{{ $register->values[4]->value_register }}" alt="">
                                </div>
                                <div class="box-content">
                                    <div class="metas d-inline-block mb-15">
                                        <span> {{ $register->values[3]->value_register }} </span>
                                    </div>
                                    <h4 class="sec-title"><a class="effect-ajax" data-dsn-ajax="work">
                                        {{ $register->values[0]->value_register }}</a>
                                    </h4>
                                </div>
                            </div></a>
                            @endforeach
                        </div>
                    </div>
                </section>
                <!-- ========== End Posts Section ========== -->
                <!-- ========== Job Section ========== -->
                <section class="our-blog  our-blog-classic not-filter section-margin p-relative dsn-swiper"
                data-dsn-animate="section"
                data-dsn-option='{"slidesPerView":3,"spaceBetween":30 ,"centeredSlides":false}'>
                    <div class="container mb-70 d-flex text-center flex-column align-items-center">
                        <h2 class="section-title">Ven y trabaja con nosotros</h2>
                    </div>
                    <div class="container">
                        <div class="swiper-container ">
                            <div class="swiper-wrapper">
                                @foreach($forms[2]->registers as $register)
                                <div class="swiper-slide blog-classic-item">
                                    <div class=" blog-item p-relative d-flex align-items-center h-100 w-100">
                                        <div class="box-meta">
                                            <div class="entry-date">
                                                {{ $register->values[0]->created_at }}
                                            </div>
                                        </div>
                                        <div class="box-img over-hidden">
                                            <img class="cover-bg-img" src="/storage/registers/{{ $register->values[3]->value_register }}" data-dsn-src="/storage/registers/{{ $register->values[3]->value_register }}" alt="">
                                        </div>
                                        <div class="box-content p-relative">
                                            <div class="box-content-body">
                                                <h4 class="title-block">
                                                    {{ $register->values[0]->value_register }}
                                                </h4>
                                                <br/>
                                                <a href="/trabajo/{{ $register->values[0]->id_register }}" onclick="document.getElementsByClassName('contact-btn')[0].click();" class="mt-30 effect-ajax dsn-button p-relative">
                                                    <span class="dsn-border-rdu "></span>Aplicar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="dsn-pagination mt-30 dsn-container d-flex justify-content-between">
                                <div class="swiper-next">
                                    <div class="next-container">
                                        <div class="container-inner">
                                            <div class="triangle"></div>
                                            <svg class="circle" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24">
                                                <g class="circle-wrap" fill="none" stroke-width="1"
                                                stroke-linejoin="round" stroke-miterlimit="10">
                                                    <circle cx="12" cy="12" r="10.5"></circle>
                                                </g>
                                            </svg>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="swiper-pagination"></div>
                                    <div class="swiper-prev">
                                    <div class="prev-container">
                                        <div class="container-inner">
                                            <div class="triangle"></div>
                                            <svg class="circle" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24">
                                                <g class="circle-wrap" fill="none" stroke-width="1"
                                                stroke-linejoin="round" stroke-miterlimit="10">
                                                    <circle cx="12" cy="12" r="10.5"></circle>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- ========== End Job Section ========== -->
                <!-- ========== facts-section ========== -->
                <div class="facts-section p-relative section-padding background-section  over-hidden">
                    <div class="bg-circle-dotted"></div>
                    <div class="bg-circle-dotted bg-circle-dotted-right"></div>
                    <div class="container">
                        <div class="d-grid grid-lg-4 grid-sm-2">
                            @foreach($forms[4]->registers as $register)
                            <div class="facts-item">
                                <div class="text-center p-relative">
                                    <span class="number">{{ $register->values[0]->value_register }}</span>
                                    <h6 class="sm-title-block v-middle w-100">{{ $register->values[1]->value_register }}</h6>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- ========== end facts-section ========== -->
@endsection
