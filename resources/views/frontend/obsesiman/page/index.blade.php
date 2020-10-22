@extends(Helper::setExtendFrontend())

@section('content')

<div class="hero-wrap">
    <div class="home-slider owl-carousel">

        @foreach($slider as $sli)
        <div class="slider-item"
            style="background-image:url({{ Helper::files('slider/'.$sli->marketing_slider_image) }});">
            <div class="overlay"></div>
            <div class="container">
                <div class="row no-gutters slider-text align-items-center justify-content-start">
                    <div class="col-md-6 ftco-animate">
                        <div class="text w-100">
                            <h2>{{ $sli->marketing_slider_name }}</h2>
                            <h1 class="mb-4">{{ $sli->marketing_slider_description }}</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

<section id="service" class=" ftco-section ftco-no-pb ">
    <div class="container ">
        <div class="row justify-content-center pb-5 mb-3 ">
            <div class="col-md-7 heading-section text-center ftco-animate ">
                @php
                $page_service = $page->where('marketing_page_slug', 'service')->first();
                @endphp
                {!! $page_service->marketing_page_description !!}
            </div>
        </div>
        <div class="row ">
            @foreach($service->chunk(2) as $ser)
            <div class="col-md-4 services ftco-animate ">
                @foreach($ser as $serv)
                <div class="d-block d-flex ">
                    <div class="icon d-flex justify-content-center align-items-center ">
                        <span class="{{ $serv->marketing_service_icon }}"></span>
                    </div>
                    <div class="media-body pl-3 ">
                        <h3 class="heading ">{{ $serv->marketing_service_name }}</h3>
                        <p>{{ $serv->marketing_service_description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="section-intro bg-intro" id="section-counter ">
    <div class="container ">
        <div class="row ">
            <div class="col-md-12 col-lg-12 d-flex justify-content-center counter-wrap ftco-animate ">
                <div class="block-18 text-center ">
                    @php
                    $page_statement = $page->where('marketing_page_slug', 'statement')->first();
                    @endphp
                    <div class="text text-white">
                        {!! $page_statement->marketing_page_description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="about" class="ftco-section ftco-no-pb about-me">
    <div class="container">
        <div class="row">
            @php
            $page_about = $page->where('marketing_page_slug', 'about-us')->first();
            @endphp
            <div class="col-md-6 img img-3 d-flex justify-content-center align-items-center"
                style="background-image: url({{ Helper::files('page/'.$page_about->marketing_page_image) }});">
            </div>
            <div class="col-md-6 wrap-about px-md-5 ftco-animate py-5 bg-primary">
                <div class="heading-section">

                    {!! $page_about->marketing_page_description !!}

                    <a href="{{ $page_about->marketing_page_link }}"
                        class="play-video popup-vimeo d-flex align-items-center mt-4">
                        <div class="icon d-flex align-items-center justify-content-center">
                            <span class="fa fa-play"></span>
                        </div>
                        <span class="watch">{{ $page_about->marketing_page_button }}</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pb">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 text-center heading-section ftco-animate">
                @php
                $page_benefit = $page->where('marketing_page_slug', 'benefit')->first();
                @endphp
                {!! $page_benefit->marketing_page_description !!}
            </div>
        </div>
        <div class="row tabulation mt-4 ftco-animate">
            <div class="col-md-4">
                <ul class="nav nav-pills nav-fill d-md-flex d-block flex-column">
                    @foreach($benefit as $ben)
                    <li class="nav-item text-left">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }} py-4" data-toggle="tab"
                            href="#benefit-{{ $ben->marketing_benefit_id }}">{{ $loop->iteration }}.
                            {{ $ben->marketing_benefit_name }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-8">
                <div class="tab-content">
                    @foreach($benefit as $bed)
                    <div class="tab-pane container p-0 {{ $loop->first ? 'active' : '' }}"
                        id="benefit-{{ $bed->marketing_benefit_id }}">
                        <div class="img"
                            style="background-image: url({{ Helper::files('benefit') }}/{{ $bed->marketing_benefit_image }});">
                        </div>
                        {!! $bed->marketing_benefit_description !!}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section id="testimoni" class="ftco-section testimony-section bg-light ftco-no-pb">
    <div class="container">
        <div class="row ftco-animate justify-content-center">

            <div class="col-md-6 col-lg-7 py-5 pl-md-5">
                <div class="py-md-5">
                    <div class="heading-section ftco-animate col-md-12">
                        @php
                        $page_testimony = $page->where('marketing_page_slug', 'testimony')->first();
                        @endphp
                        {!! $page_testimony->marketing_page_description !!}
                    </div>
                    <hr>
                    <div class="carousel-testimony owl-carousel ftco-animate">
                        @foreach($testimony as $test)
                        <div class="item">
                            <div class="testimony-wrap pb-4">
                                <img src="{{ Helper::files('testimony/'.$test->marketing_testimony_image) }}"
                                    class="img-fluid col-md-4" alt="{{ $test->marketing_testimony_name }}">

                                <div class="d-flex mt-3">
                                    <div class="pos ml-3">
                                        <p class="name">{{ $test->marketing_testimony_name }}</p>
                                    </div>
                                </div>
                                <div class="text">
                                    <p class="col-md-12">
                                        {{ $test->marketing_testimony_description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 d-flex">
                <div class="testimony-img"
                    style="background-image: url({{ Helper::files('page/'.$page_testimony->marketing_page_image) }});">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section banner-section bg-light">
    <div class="content">
        <div class="container ">
            <div class="row justify-content-center pb-5 mb-3 ">
                <div class="col-md-7 heading-section text-center ftco-animate ">
                    @php
                    $page_process = $page->where('marketing_page_slug', 'process')->first();
                    @endphp
                    {!! $page_process->marketing_page_description !!}
                </div>
            </div>
        </div>

        <div class="row ftco-animate">
            <div class="col-md-12">
                <div class="carousel-banner owl-carousel ftco-owl">
                    @foreach($process->sortBy('marketing_process_id') as $pro)
                    @if(!$loop->first)
                    <div class="item">
                        <div class="work img d-flex align-items-end "
                            style="background-image: url({{ Helper::files('process/'.$pro->marketing_process_image) }}); ">
                            <span class="number">{{ $loop->iteration }}</span>
                            <a href="{{ Helper::files('process/'.$pro->marketing_process_image) }}"
                                class="icon image-popup d-flex justify-content-center align-items-center ">
                                <span class="fa fa-expand"></span>
                            </a>
                            <div class="desc w-100 px-4 ">
                                <div class="text w-100 mb-3 ">
                                    <span>{{ $pro->marketing_process_name }}</span>
                                    <h2>{{ $pro->marketing_process_description }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($loop->first)
                    <div class="item">
                        <div class="work img d-flex align-items-end "
                            style="background-image: url({{ Helper::files('process/'.$pro->marketing_process_image) }}); ">
                            <span class="number">1</span>
                            <a href="{{ Helper::files('process/'.$pro->marketing_process_image) }}"
                                class="icon image-popup d-flex justify-content-center align-items-center ">
                                <span class="fa fa-expand"></span>
                            </a>
                            <div class="desc w-100 px-4 ">
                                <div class="text w-100 mb-3 ">
                                    <span>{{ $pro->marketing_process_name }}</span>
                                    <h2>{{ $pro->marketing_process_description }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<div class="wa" style="position: fixed;bottom:0px;background-color:white;z-index:9999;left:10px;bottom:5px;width:40px;border-radius:50%;padding:3px">
    <a target="_blank" href="https://api.whatsapp.com/send?phone={{ config('website.phone') }}">
        <img class="img-fluid" src="{{ Helper::frontend('images/wa.png') }}" alt="">
    </a>
</div>

@endsection