<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="discrption" content="parallax one page" />
    <title>{{ $forms[0]->registers[0]->values[0]->value_register }}</title>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;family=Poppins:wght@300;400;500;600;700&amp;display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;family=Poppins:wght@300;400;500;600;700&amp;display=swap"
    rel="stylesheet"></noscript>
    <link rel="preload" href="{{ asset('assets/img/circle-dotted.png') }}" as="image" />
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?cache=1A') }}">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-125424716-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-125424716-2');
    </script>
</head>
<body class="v-light dsn-effect-scroll dsn-ajax">
    <!-- <Menu> -->
    <div class="site-header dsn-container dsn-load-animate">
        <div class="extend-container d-flex w-100 align-items-baseline justify-content-between align-items-end">
            <div class="inner-header p-relative">
                <div class="main-logo">
                    <a href="/" data-dsn="parallax">
                        <img class="light-logo"
                            src="/storage/registers/{{ $forms[0]->registers[0]->values[4]->value_register }}"
                            data-dsn-src="/storage/registers/{{ $forms[0]->registers[0]->values[4]->value_register }}" alt="" />
                        <img class="dark-logo"
                            src="/storage/registers/{{ $forms[0]->registers[0]->values[4]->value_register }}"
                            data-dsn-src="/storage/registers/{{ $forms[0]->registers[0]->values[4]->value_register }}" alt="" />
                    </a>
                </div>
            </div>
            <div class="menu-icon d-flex align-items-baseline">
                <div class="text-menu p-relative  font-heading text-transform-upper">
                    <div class="p-absolute text-button">Menu</div>
                    <div class="p-absolute text-open"></div>
                    <div class="p-absolute text-close"></div>
                </div>
                <div class="icon-m" data-dsn="parallax" data-dsn-move="10">
                    <span class="menu-icon-line p-relative d-inline-block icon-top"></span>
                    <span class="menu-icon-line p-relative d-inline-block icon-center"></span>
                    <span class="menu-icon-line p-relative d-block icon-bottom"></span>
                </div>
            </div>
            <nav class="accent-menu dsn-container main-navigation p-absolute  w-100  d-flex align-items-baseline ">
                <div class="menu-cover-title">Menu</div>
                <ul class="extend-container p-relative d-flex flex-column justify-content-center h-100">
                    @foreach($helpers[0]->registers as $register)
                    <li>
                        <a href="{{ $register->values[1]->value_register }}">
                            <span class="dsn-title-menu">{{ $register->values[0]->value_register }}</span>
                        </a>
                    </li>
                    @endforeach
                    @if(Auth::check())
                        @foreach($intranet[0]->registers as $register)
                        <li>
                            <a href="{{ $register->values[1]->value_register }}">
                                <span class="dsn-title-menu">{{ $register->values[0]->value_register }}</span>
                            </a>
                        </li>
                        @endforeach
                    @endif
                </ul>
                <div class="container-content  p-absolute h-100 left-60 d-flex flex-column justify-content-center">
                    @foreach($helpers[1]->registers as $register)
                    <div class="nav__info">
                        <div class="nav-content">
                            <p class="title-line">{{ $register->values[0]->value_register }}</p>
                            <p>{{ $register->values[1]->value_register }}</p>
                        </div>
                        <div class="nav-content">
                            <p class="links over-hidden">
                                <a href="mailto:{{ $register->values[2]->value_register }}" data-hover-text="{{ $register->values[2]->value_register }}" class="link-hover">{{ $register->values[2]->value_register }}</a>
                            </p>
                        </div>
                    </div>
                    @endforeach
                    <div class="nav-social nav-content">
                        <div class="nav-social-inner p-relative">
                            <p class="title-line">Recursos</p>
                            <ul>
                                 <li>
                                    <a href="/login" target="_self" rel="nofollow">Intranet
                                        <div class="icon-circle"></div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="nav-social nav-content">
                        <div class="nav-social-inner p-relative">
                            <p class="title-line">Síguenos en</p>
                            <ul>
                                 @foreach($helpers[2]->registers as $register)
                                <li>
                                    <a href="{{ $register->values[1]->value_register }}" target="_blank" rel="nofollow">{{ $register->values[0]->value_register }}
                                        <div class="icon-circle"></div>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- </Menu> -->
    <!-- ========== End Menu ========== -->
    @yield('main-content')
    <!-- <ContactLink> -->
    <section class="next-page p-relative section-padding  border-top">
        <div class="bg-circle-dotted"></div>
            <div class="bg-circle-dotted bg-circle-dotted-right"></div>
                <div class="container">
                    <div class="c-wapp d-flex justify-content-between">
                        <div class="d-flex flex-column">
                            <p class="sub-heading line-shap line-shap-after ">
                                <span class="line-bg-left">
                                {{ $forms[0]->registers[0]->values[3]->value_register }}
                                </span>
                            </p>
                            <h2 class="section-title max-w750 mt-15">
                            {{ $forms[0]->registers[0]->values[2]->value_register }}
                            </h2>
                        </div>
                        <div class="button-box d-flex justify-content-end align-items-center">
                            <div>
                                <a href="/contacto" onclick="document.getElementsByClassName('contact-btn')[0].click();" class="mt-30 effect-ajax dsn-button p-relative">
                                    <span class="dsn-border-rdu "></span>Contáctanos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- </ContactLink> -->
    <!-- <Footer> -->
    <footer class="footer p-relative background-section">
        <div class="container">
            <div class="footer-container">
                <div class="d-flex align-items-center h-100">
                    <div class="column-left">
                        <div class="footer-social p-relative">
                            <ul>
                                <li class="over-hidden">
                                    <a href="/storage/registers/{{ $forms[0]->registers[0]->values[5]->value_register }}" data-dsn="parallax" target="_blank"
                                    rel="nofollow">{{ $forms[0]->registers[0]->values[5]->field }}
                                    </a>
                                </li>
                                <li class="over-hidden">
                                    <a href="/storage/registers/{{ $forms[0]->registers[0]->values[6]->value_register }}" data-dsn="parallax" target="_blank"
                                    rel="nofollow">{{ $forms[0]->registers[0]->values[6]->field }}.</a>
                                </li>
                                <li class="over-hidden">
                                    <a href="/storage/registers/{{ $forms[0]->registers[0]->values[7]->value_register }}" data-dsn="parallax" target="_blank"
                                    rel="nofollow">{{ $forms[0]->registers[0]->values[7]->field }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="inner-header p-relative">
                            <div class="main-logo">
                                <a href="https://www.bureauveritascertification.com/" target="_blank" data-dsn="parallax">
                                    <img class="light-logo"
                                    style="width:125px"
                                    src="https://www.bureauveritascertification.com/wp-content/uploads/2020/10/bvcertification.png" />
                                </a>
                                <br/>
                                <p style="font-size:9px;">ISO 9001:2015 | ISO 14001:2015 | ISO 45001:2018<p>
                            </div>
                        </div>
                    </div>
                    <div class="scroll-top animation-rotate" data-dsn="parallax">
                        <img src="assets/img/scroll_top.svg" alt="">
                        <i class="fa fa-angle-up"></i>
                    </div>
                    <div class="column-right">
                        <div class="footer-social p-relative">
                            <ul>
                            @if(isset($forms[5]))
                            @foreach($forms[5]->registers as $register)
                                <li class="over-hidden">
                                    <a href="{{ $register->values[1]->value_register }}" data-dsn="parallax" target="_blank"
                                    rel="nofollow">{{ $register->values[0]->value_register }}
                                    </a>
                                </li>
                            @endforeach
                            @endif
                            </ul>
                            <br/><br/><br/>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center h-100">
                    <div style="
                        margin: 0 auto 0 auto;
                        text-align: center;
                        font-size: 13px;
                        margin-top: 11px;
                    ">Todos los derechos reservados © {{ $forms[0]->registers[0]->values[0]->value_register }}</div>
                </div>
            </div>
        </div>
    </footer>
    <!-- </Footer> -->
    </div>
    <!-- <TopPageLink> -->
    <div class="scroll-to-top">
        <img src="{{ asset('assets/img/scroll_top.svg') }}" alt="">
        <div class="box-numper">
            <span>10%</span>
        </div>
    </div>
    <!-- </TopPageLink> -->
    <!-- <Cursor> -->
    <div class="cursor">
        <div class="cursor-helper">
            <span class="cursor-drag">Drag</span>
            <span class="cursor-view">View</span>
            <span class="cursor-open"><i class="fas fa-plus"></i></span>
            <span class="cursor-close">Close</span>
            <span class="cursor-play">play</span>
            <span class="cursor-next"><i class="fas fa-chevron-right"></i></span>
            <span class="cursor-prev"><i class="fas fa-chevron-left"></i></span>
        </div>
    </div>
    <!-- </Cursor> -->
    <div class="dsn-paginate-right-page"></div>
    <div class="line-border-style w-100 h-100"></div>
    <script src="{{ asset('assets/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins.min.js') }}"></script>
    <script src="{{ asset('assets/js/dsn-grid.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>
</html>
