@extends('layouts.publicheader')
    @section('main-content')
    <main class="main-root">
        <div id="dsn-scrollbar">
            <div class="main-content">

                <!-- ========== Header Normal ========== -->
                <header
                    class="header-page over-hidden background-section p-relative header-padding-top header-padding-bottom border-bottom dsn-header-animation">
                    <div class="bg-circle-dotted"></div>
                    <div class="container">
                        <div class="content-hero p-relative d-flex flex-column h-100 dsn-hero-parallax-title">
                            <p class="subtitle p-relative line-shap  line-shap-after">
                                <span class="pl-10 pr-10 background-main dsn-load-animate">{{ $forms[0]->registers[0]->values[0]->value_register }}</span>
                            </p>
                            <h1 class="title mt-30 dsn-load-animate text-transform-upper">{{ $forms[0]->registers[0]->values[8]->value_register }}</h1>
                        </div>
                    </div>
                </header>
                <!-- ========== End Header Normal ========== -->


                <div class="wrapper">
                    <div class="root-blog section-margin ">
                        <div class="container ">
                            <div class="dsn-posts d-grid grid-lg-1">
                                @foreach($forms[1]->registers as $register)
                                <div class=" blog-item p-relative d-flex align-items-center h-100 w-100"
                                    data-swiper-parallax-scale="0.85">
                                    <div class="box-meta">
                                        <div class="entry-date">
                                            <a href="#" class="effect-ajax">{{ $register->values[0]->created_at }}</a>
                                        </div>
                                    </div>
                                    <div class="box-img over-hidden">
                                        <img class="cover-bg-img"
                                            src="/storage/registers/{{ $register->values[2]->value_register }}"
                                            data-dsn-src="/storage/registers/{{ $register->values[2]->value_register }}" alt="">
                                    </div>
                                    <div class="box-content p-relative">

                                        <div class="box-content-body">
                                            <h4 class="title-block mb-20 ">
                                                <a href="#" class="effect-ajax">{{ $register->values[0]->value_register }}</a>
                                            </h4>
                                            {!! $register->values[1]->value_register !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
    @endsection
