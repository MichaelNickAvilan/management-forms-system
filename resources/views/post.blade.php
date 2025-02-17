
    @extends('layouts.publicheader')
    @section('main-content')
    <main class="main-root">
        <div id="dsn-scrollbar">
            <div class="main-content">

                <!-- ========== Header Normal ========== -->
                <header
                    class="header-page over-hidden p-relative header-padding-top header-padding-bottom border-bottom dsn-header-animation">
                    <div class="bg-circle-dotted"></div>
                    <div class="container">
                        <div class="content-hero p-relative d-flex flex-column h-100 dsn-hero-parallax-title">
                            <div class="metas metas-blog d-flex align-items-center letter-s1 fz-16 p-relative">
                                {{ $post[0]->created_at }}
                            </div>
                            <h1 class="title mt-30 dsn-load-animate text-transform-upper max-w750">
                            {{ $post[0]->value_register }}
                            </h1>
                        </div>
                    </div>
                </header>
                <!-- ========== End Header Normal ========== -->


                <div class="wrapper">
                    <div class="root-blog">
                        <div class="container ">
                            <div class="dsn-posts">
                                <div class="image-head p-relative full-width">
                                    <div class="before-z-index" data-dsn-grid="move-up" data-overlay="5">
                                        <img class="cover-bg-img has-bigger-scale"
                                            src="/storage/registers/{{ $post[4]->value_register }}"
                                            data-dsn-src="/storage/registers/{{ $post[4]->value_register }}" alt="">
                                    </div>
                                </div>
                                <div class="news-content mt-section">
                                    <div class="news-content-inner">
                                        <div class="post-content">
                                        {!! $post[2]->value_register !!}
                                        <br/><br/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div>
@endsection
