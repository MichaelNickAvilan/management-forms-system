@extends('layouts.publicheader')
    @section('main-content')
    <main class="main-root">
        <div id="dsn-scrollbar">
            <div class="main-content">

                <!-- ========== Header Normal ========== -->
                <header
                    class="header-page over-hidden p-relative header-padding-top header-padding-bottom border-bottom dsn-header-animation">
                    <div class="bg-circle-dotted"></div>
                    <div class="dsn-container">
                        <div class="content-hero p-relative d-flex flex-column h-100 dsn-hero-parallax-title">
                            <p class="subtitle p-relative line-shap  line-shap-after">
                                <span class="pl-10 pr-10 background-main dsn-load-animate">{{ $forms[0]->registers[0]->values[0]->value_register }}</span>
                            </p>
                            <h1 class="title mt-30 dsn-load-animate text-transform-upper">
                            {{ $forms[1]->registers[0]->values[4]->value_register }}
                            </h1>
                        </div>
                    </div>
                </header>
                <!-- ========== End Header Normal ========== -->


                <div class="wrapper">

                    <div class="image-head p-relative">
                        <div class="before-z-index" data-dsn-grid="move-up" data-overlay="5">
                            <img class="cover-bg-img has-bigger-scale"
                            src="/storage/registers/{{ $forms[1]->registers[0]->values[7]->value_register }}"
                            data-dsn-src="/storage/registers/{{ $forms[1]->registers[0]->values[7]->value_register }}" alt="">
                        </div>
                    </div>

                    <!-- ========== About Section ========== -->
                    <section class="about-section-2 p-relative section-margin" data-dsn-title="About">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="box-left">
                                        <div class="section-title">
                                            <h4>{{ $forms[1]->registers[0]->values[0]->value_register }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="box-right">
                                        {!! $forms[1]->registers[0]->values[1]->value_register !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- ========== End About Section ========== -->

                    <div class="section-margin has-popup over-hidden p-relative">
                        <div class="container">
                            <div class="d-grid grid-md-2  over-hidden">
                                <a href="/storage/registers/{{ $forms[1]->registers[0]->values[5]->value_register }}"
                                    class="p-relative over-hidden d-flex h-v-60">
                                    <img src="/storage/registers/{{ $forms[1]->registers[0]->values[5]->value_register }}"
                                        data-dsn-src="/storage/registers/{{ $forms[1]->registers[0]->values[5]->value_register }}"
                                        data-dsn-srcset="/storage/registers/{{ $forms[1]->registers[0]->values[5]->value_register }} 1800w,/storage/registers/{{ $forms[1]->registers[0]->values[5]->value_register }} 768w"
                                        alt="" class="cover-bg-img">
                                </a>

                                <a href="/storage/registers/{{ $forms[1]->registers[0]->values[6]->value_register }}" class="p-relative over-hidden d-flex h-v-60">
                                    <img src="/storage/registers/{{ $forms[1]->registers[0]->values[6]->value_register }}"
                                        data-dsn-src="/storage/registers/{{ $forms[1]->registers[0]->values[6]->value_register }}"
                                        data-dsn-srcset="/storage/registers/{{ $forms[1]->registers[0]->values[6]->value_register }} 1800w,/storage/registers/{{ $forms[1]->registers[0]->values[6]->value_register }} 768w"
                                        alt="" class="cover-bg-img">
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- ========== About Section ========== -->
                    <section class="about-section-2 p-relative section-margin" data-dsn-title="About">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="box-left">
                                        <div class="section-title">
                                            <h4>{{ $forms[1]->registers[0]->values[2]->value_register }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="box-right">
                                        {!! $forms[1]->registers[0]->values[3]->value_register !!}
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="col-lg-6">
                                        <div class="box-center">
                                            <div class="section-title">
                                                <br/><br/><h4>Nuestros valores</h4><br/>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="box-bottom">
                                            <div class="d-grid d-grid-no-space grid-md-3 grid-sm-1">
                                                @foreach($forms[2]->registers as $register)
                                                <div class="item d-flex align-items-center">
                                                    <i class="fas fa-check theme-color"></i>
                                                    <h4 class="title-block ml-15">{{ $register->values[0]->value_register }}</h4>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- ========== End About Section ========== -->
                </div>
    @endsection
