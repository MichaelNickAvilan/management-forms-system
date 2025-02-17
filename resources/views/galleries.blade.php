@extends('layouts.publicheader')
    @section('main-content')
    <main class="main-root">
        <div id="dsn-scrollbar">
            <div class="main-content">


                <div class="wrapper">
                    <div class="root-blog section-margin ">
                        <div class="container ">
                            <div class="dsn-posts d-grid grid-lg-1">
                                @foreach($groups as $group)
                                <div class=" blog-item p-relative d-flex align-items-center h-100 w-100"
                                    data-swiper-parallax-scale="0.85">
                                    <div class="box-meta">
                                        <div class="entry-date">
                                            <a href="/galeria?album={{ urlencode($group->title) }}" class="effect-ajax">{{ $group->images[0][0]->created_at }}</a>
                                        </div>
                                    </div>
                                    <div class="box-img over-hidden">
                                        <?php $port=""; ?>
                                        @foreach($group->images as $image)
                                            @foreach($image as $values)
                                                @if($values->field === "Imagen")
                                                    <?php $port=$values->value_register; ?>
                                                @endif
                                            @endforeach
                                        <img class="cover-bg-img"
                                            src="/storage/registers/{{ $port }}"
                                            data-dsn-src="/storage/registers/{{ $port }}" alt="">
                                        @endforeach
                                    </div>
                                    <div class="box-content p-relative">

                                        <div class="box-content-body">
                                            <h4 class="title-block mb-20 ">
                                                <a href="/galeria?album={{ urlencode($group->title) }}" class="effect-ajax">{{ $group->title }}</a>
                                            </h4>
                                            {!! $group->images[0][1]->value_register !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
    @endsection
